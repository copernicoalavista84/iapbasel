<?php

/**
 * Init Theme Related Settings
 */

/** Internal Settings **/
require_once 'version.php';

/**
 * Required and Recommended Plugins
 */
add_action( 'tgmpa_register', 'spyropress_register_plugins' );
function spyropress_register_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // MP6
        array(
            'name'                  => 'WP-Admin Metro Skin',
            'slug'                  => 'mp6',
            'required'              => true
        ),

        // Wordpress SEO
        array(
            'name'      => 'WordPress SEO by Yoast',
            'slug'      => 'wordpress-seo',
            'required'  => false,
        ),

        // Contact Form 7
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => true,
        )
    );

    tgmpa( $plugins );
}
?>