<?php

/**
 * Border OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_import( $option_name ) {

    $item['label'] = __( 'Import Options', 'spyropress' );
    $item['desc'] = __( 'Input your backup file below and hit import to restore your site options from backup.', 'spyropress' );

    echo '<div class="section section-import section-full">';
        build_heading( $item, false );
        build_description( $item );
        echo '<div class="controls">';
            echo '<textarea class="field" name="import_options" id="import_options" rows="10"></textarea>';
        echo '</div>';
        printf(
            '<input type="submit" value="%1$s" class="button-red import-options"/> <em>%2$s</em>',
            esc_attr( 'Import Options', 'spyropress' ), __( 'WARNING! This will overwrite any existing options, please proceed with caution!', 'spyropress' )
        );
    echo '</div>';
}

function spyropress_ui_export( $option_name ) {

    global $spyropress;
    $option_name = str_replace( 'spyropress_', '', $option_name );
    
    // getting url
    $data_url = add_query_arg( array(
        'feed' => 'spyropress_export_options',
        'download' => $option_name,
        'security' => wp_create_nonce( 'export_options' ) ), site_url()
    );
    
    $data = '';
    if( isset( $spyropress->options[$option_name] ) ) {
        $data = $spyropress->options[$option_name];
        $data = spyropress_encode( $data );
    }

    $item['label'] = __( 'Export Options', 'spyropress' );
    $item['desc'] = __( 'Here you can download or copy/paste into a blank file your theme current option settings. Keep this safe as you can use it as backup should anything go wrong. Or you can use it to restore your settings on this site (or any other site).', 'spyropress' );

    echo '<div class="section section-export section-full">';
        build_heading( $item, false );
        build_description( $item );
        echo '<div class="controls">';
            echo '<textarea class="field" name="export_options" id="export_options" rows="10">' . $data . '</textarea>';
        echo '</div>';
        printf(
            '<a href="%1$s" class="button-green export-options">%2$s</a>',
            $data_url, __( 'Download Options', 'spyropress' )
        );
    echo '</div>';
}
?>