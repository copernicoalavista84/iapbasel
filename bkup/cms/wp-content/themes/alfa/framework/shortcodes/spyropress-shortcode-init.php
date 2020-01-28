<?php

/**
 * Shortcodes
 */

init_shortcode();
function init_shortcode() {
    
    $shortcodes = array(
        'footer_information'   => 'spyropress_footer_information',
        'social_information'   => 'spyropress_social_information',
    );
    
    foreach( $shortcodes as $tag => $func )
        add_shortcode( $tag, $func );
}

function spyropress_social_information( $atts = array(), $content = '' ) {

    $socials = get_setting_array( 'socials' );
    if( empty( $socials ) ) return;
    
    $content = '';
    foreach( $socials as $social ) {
        $content .= '<li><a href="' . $social['link'] . '" class="' . $social['network'] . '">' . $social['network'] . '</a></li>';
    }
    
    return '<ul class="social-links clearfix">' . $content . '</ul>';
}

function spyropress_footer_information( $atts = array(), $content = '' ) {

    // Defaults
    $defaults = array(
        'ph_label' => 'Questions?',
        'ph' => 'Call 1-800-8000',
        'email_label' => 'You can also email us at:',
        'email' => 'me@spyropress.com'
    );
    $atts = shortcode_atts( $defaults, $atts );
    extract( $atts );
    
    $content = '
    <ul class="footer-information">
        <li class="phone-info">
            <p>' . $ph_label . '</p>
            <p><strong>Call ' . $ph . '</strong></p>
        </li>
        <li class="email-info">
            <p>' . $email_label . '</p>
            <p><a href="mailto:' . $email . '">' . $email . '</a></p>
        </li>
    </ul>';
    
    return $content;
}

?>