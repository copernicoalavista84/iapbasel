<?php

/**
 * SpyroPress Theme Verifier
 * Verify theme against spyropress database and themeforest and install SpyroBuilder and SpyroTempalteBuilder.
 *
 * @author 		SpyroSol
 * @category 	Admin
 * @package 	Spyropress
 */

class SpyropressThemeVerifier {

    function __construct() {
        add_action( 'admin_head', array( $this, 'verify_theme' ) );
    }

    function verify_theme() {

        if ( isset( $_REQUEST['page'] ) ) {

            // Sanitize page being requested.
            $_page = esc_attr( $_REQUEST['page'] );
            
            if ( 'spyropress' == $_page && isset( $_REQUEST['security'] ) &&
                check_admin_referer( 'spyropress-verification', 'security' ) )
            {
                global $spyropress;
                
                $step = ( isset( $_GET['step'] ) ) ? $_GET['step'] : '';
                $step = ( $step ) ? $step : 1;
                if ( $spyropress->admin->is_verified && !$spyropress->admin->is_builder_installed ) $step = 2;
                
                $field_method = 'verify_theme_step' . $step;
                call_user_func( array( $this, $field_method ) );
            }
        }
    }

    function verify_theme_step1() {
        $_username = esc_attr( $_REQUEST['envato_username'] );
        $_code = esc_attr( $_REQUEST['envato_item_code'] );
        $error = false;

        // Check for error
        if ( empty( $_username ) || empty( $_code ) ) {
            add_error_section( __( 'Theme Verification Error', 'spyropress' ) );
            $error = true;
        }

        if ( empty( $_username ) )
            add_error_message( __( 'Enter envato marketplace username to verify.', 'spyropress' ) );

        if ( empty( $_code ) )
            add_error_message( __( 'Enter item purchase code to verify.', 'spyropress' ) );

        if ( $error ) return;

        global $spyropress;

        // verify code
        $json = $spyropress->api->verify_purchase( $_code, $_username );
        $json = json_decode( $json, true );

        // if verified
        if ( $json['success'] && ! $json['black_listed'] ) {

            update_option( '_spyropress_envato_verification_' . get_internal_name(), $_code );
            update_option( '_spyropress_envato_username_' . get_internal_name(), $_username );

            add_notice_message( __( 'Redirecting...', 'spyropress' ) .
            '<script type="text/javascript">
            //<![CDATA[
                window.location.replace("' . admin_url( 'admin.php?page=spyropress&step=2' ) .
                '");
            //]]>
            </script>' );
        }
        else {
            update_option( '_spyropress_envato_verification_' . get_internal_name(), false );
            add_error_section( __( 'Theme Verification Error', 'spyropress' ) );
            add_error_message( $json['message'] );
        }
    }

    function verify_theme_step2() {
        //Setup Filesystem
        $method = get_filesystem_method();

        if ( isset( $_POST['spyropress_ftp_cred'] ) ) {
            $cred = spyropress_decode( $_POST['spyropress_ftp_cred'] );
            $filesystem = WP_Filesystem( $cred );
        }
        else {
            $filesystem = WP_Filesystem();
        }

        if ( false == $filesystem && 'Proceed' != $_POST['upgrade'] ) {

            add_error_message( sprintf( __( 'Failed: Filesystem preventing downloads. (%s)',
                'spyropress' ), $method ) );
            return;
        }

        if ( isset( $_REQUEST['spyropress_installer'] ) ) {
            // Sanitize action being requested.
            $_action = esc_attr( $_REQUEST['spyropress_installer'] );

            if ( 'builder' == $_action ) {

                // Download builder
                global $spyropress;

                $envato_code = get_option( '_spyropress_envato_verification_' . get_internal_name() );
                $envato_username = get_option( '_spyropress_envato_username_' . get_internal_name() );
                $download_link = $spyropress->api->generate_download_link( $envato_code, $envato_username, 'spyropress_builder' );
                $temp_file_addr = $this->download_url( $download_link );

                if ( is_wp_error( $temp_file_addr ) ) {
                    $error = esc_html( $temp_file_addr->get_error_code() );

                    //The source file was not found or is invalid
                    if ( 'http_no_url' == $error )
                        add_error_message( __( 'Failed: Invalid URL Provided', 'spyropress' ) );
                    else
                        add_error_message( sprintf( __( 'Failed: %s', 'spyropress' ), esc_html( $temp_file_addr->get_error_message() ) ) );
                    return;
                }

                // Unzip it
                global $wp_filesystem;
                $to = $wp_filesystem->wp_content_dir() . '/themes/' . get_option( 'template' ) . '/framework/';

                $dounzip = unzip_file( $temp_file_addr, $to );
                unlink( $temp_file_addr ); // Delete Temp File

                if ( is_wp_error( $dounzip ) ) {
                    $error = esc_html( $dounzip->get_error_code() );
                    $data = $dounzip->get_error_data( $error );

                    switch ( $error ) {
                        case 'incompatible_archive':
                            add_error_message( __( 'Failed: Incompatible archive', 'spyropress' ) );
                            break;
                        case 'empty_archive':
                            add_error_message( __( 'Failed: Empty Archive', 'spyropress' ) );
                            break;
                        case 'mkdir_failed':
                            add_error_message( __( 'Failed: mkdir Failure', 'spyropress' ) );
                            break;
                        case 'copy_failed':
                            add_error_message( __( 'Failed: Copy Failed', 'spyropress' ) );
                            break;
                    }

                    return;
                }
                
                // Check for template file
                $temp_file = framework_path() . 'builder/templates/spyropress.xml';
                $step = 3;
                if( !file_exists( $temp_file ) )
                    $step = '4&jumped=1';

                // Successfully Updated
                update_option( '_spyropress_builder_installed_' . get_internal_name(), 1 );
                add_success_message( __( 'Builder successfully downloaded, extracted and installed. Redirecting...', 'spyropress' ) .
                '<script type="text/javascript">
                    //<![CDATA[
                        window.location.replace("' . admin_url( 'admin.php?page=spyropress&step=' . $step ) . '");
                    //]]>
                </script>' );
            }
        }
    }

    function download_url( $url, $timeout = 300 ) {
        //WARNING: The file is not automatically deleted, The script must unlink() the file.
        if ( ! $url )
            return new WP_Error( 'http_no_url', __( 'Invalid URL Provided.', 'spyropress' ) );

        $tmpfname = wp_tempnam( $url );
        if ( ! $tmpfname )
            return new WP_Error( 'http_no_file', __( 'Could not create Temporary file.', 'spyropress' ) );

        $response = wp_remote_get( $url, array(
            'timeout' => $timeout,
            'stream' => true,
            'filename' => $tmpfname
        ) );

        if ( is_wp_error( $response ) ) {
            unlink( $tmpfname );
            return $response;
        }

        if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
            unlink( $tmpfname );
            $message = $response['headers']['message'];
            $message = ( $message ) ? $message : wp_remote_retrieve_response_message( $response );
            return new WP_Error( 'http_404', trim( $message ) );
        }

        return $tmpfname;
    }

    function verify_theme_step3() {

        if ( isset( $_REQUEST['spyropress_installer'] ) ) {
            // Sanitize action being requested.
            $_action = esc_attr( $_REQUEST['spyropress_installer'] );

            if ( 'importer' == $_action ) {

                // Download framework
                $temp_file_addr = framework_path() . 'builder/templates/spyropress.xml';

                include ( framework_path() . 'classes/class-importer.php' );

                if ( class_exists( 'SpyropressImporter' ) ) {
                    $importer = new SpyropressImporter( $temp_file_addr );

                    if ( $importer->importerError ) {
                        add_error_message( $importer->error );
                        return;
                    }

                    $message = __( 'Redirecting...', 'spyropress' );
                    $message .= '<script type="text/javascript">
                    //<![CDATA[
                        window.location.replace("' . admin_url( 'admin.php?page=spyropress&step=4' ) .
                        '");
                    //]]>
                    </script>';

                    add_notice_message( $message );
                }
                else  add_error_message( __( 'Spyropress Importer class not found.', 'spyropress' ) );
            }
        }
    }
}

?>