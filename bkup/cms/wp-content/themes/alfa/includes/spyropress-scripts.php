<?php

/**
 * Enqueue scripts and stylesheets
 *
 * @category Core
 * @package SpyroPress
 *
 */

/**
 * Register StyleSheets
 */
function spyropress_register_stylesheets() {

    wp_enqueue_style( 'base', assets_css() . 'base.css', false, '1.0.0' );
    wp_enqueue_style( 'skeleton', assets_css() . 'skeleton.css', false, '1.0.0' );
    wp_enqueue_style( 'layout', assets_css() . 'layout.css', false, '1.0.0' );
    wp_enqueue_style( 'fancybox', assets_css() . 'jquery.fancybox.css', false, '1.0.0' );
    
    // Dynamic StyleSheet
    if ( file_exists( template_path() . 'assets/css/dynamic.css' ) )
        wp_enqueue_style( 'dynamic', assets_css() . 'dynamic.css', false, '2.0.0' );

    // Builder StyleSheet
    if ( file_exists( template_path() . 'assets/css/builder.css' ) )
        wp_enqueue_style( 'builder', assets_css() . 'builder.css', false, '2.0.0' );

    // modernizr
    wp_enqueue_script('jquery' );
}

/**
 * Enqueque Scripts
 */
function spyropress_register_scripts() {

    /**
     * Register Scripts
     */
    // threaded comments
    if ( is_single() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    // Plugins
    wp_register_script( 'gapi', 'http://maps.google.com/maps/api/js?sensor=true', false, '1.0', true );
    wp_register_script( 'jquery-gmaps', assets_js() . 'gmaps.js', false, '1.0', true );
    wp_register_script( 'jquery-easing', assets_js() . 'easing-min.js', false, '1.0', true );
    wp_register_script( 'modernizr', assets_js() . 'modernizr.custom.js', false, '1.0', true );
    wp_register_script( 'jquery-sticky', assets_js() . 'jquery.sticky.js', false, '1.0', true );
    wp_register_script( 'jquery-cbpFWSlider', assets_js() . 'jquery.cbpFWSlider.min.js', false, '1.0', true );
    wp_register_script( 'jquery-parallax', assets_js() . 'jquery.parallax-1.1.3.js', false, '1.0', true );
    wp_register_script( 'jquery-localscroll', assets_js() . 'jquery.localscroll-1.2.7-min.js', false, '1.0', true );
    wp_register_script( 'jquery-scrollTo', assets_js() . 'jquery.scrollTo-1.4.2-min.js', false, '1.0', true );
    wp_register_script( 'jquery-nicescroll', assets_js() . 'jquery.nicescroll.min.js', false, '1.0', true );
    wp_register_script( 'jquery-isotope', assets_js() . 'jquery.isotope.min.js', false, '1.0', true );
    wp_register_script( 'jquery-fancybox', assets_js() . 'jquery.fancybox.js', false, '1.0', true );
    wp_register_script( 'jquery-fancybox-media', assets_js() . 'jquery.fancybox-media.js', false, '1.0', true );
    wp_register_script( 'jquery-quovolver', assets_js() . 'jquery.quovolver.js', false, '1.0', true );
    
    $h_type = get_setting( 'h_type' );
    
    $deps = array(
        'gapi',
        'jquery-gmaps',
        'jquery-easing',
        'modernizr',
        'jquery-sticky',
        'jquery-cbpFWSlider',
        'jquery-parallax',
        'jquery-localscroll',
        'jquery-scrollTo',
        'jquery-nicescroll',
        'jquery-isotope',
        'jquery-fancybox',
        'jquery-fancybox-media',
        'jquery-quovolver'
    );
    
    $work_deps = array(
        'jquery-easing',
        'modernizr',
        'jquery-cbpFWSlider',
        'jquery-nicescroll'
    );
    
    // custom scripts
    if( is_singular( 'portfolio' ) ) {
        wp_register_script( 'custom-script', assets_js() . 'work.js', $work_deps, '2.1', true );
    }
    else {
        
        // Conditional Enqueue
        if( 'slider' == $h_type) {
            
            $slides = get_setting_array( 'h_slider' );
            
            if( !empty( $slides ) ) {
                
                wp_register_script( 'jquery-cycle', assets_js() . 'jquery.cycle.all.js', false, '1.0', true );
                wp_register_script( 'jquery-maximage', assets_js() . 'jquery.maximage.js', false, '1.0', true );
        
                $deps[] = 'jquery-cycle';
                $deps[] = 'jquery-maximage';
        
                $js = '
                $("#maximage").maximage({
                    cycleOptions: {
                        fx: "fade",
                        speed: 2000,
                        prev: "#arrow_left",
                        next: "#arrow_right",
                    }
                });';
                add_jquery_ready($js);
            }
        }
        elseif( 'video' == $h_type ) {
            
            $video = get_setting( 'h_video' );
            $video_alt = get_setting( 'h_video_alt' );
            
            if( !empty( $video ) ) {
                
                wp_register_script( 'jquery-imagesloaded', assets_js() . 'jquery.imagesloaded.min.js', false, '1.0', true );
                wp_register_script( 'zencoder', 'http://vjs.zencdn.net/c/video.js', false, '1.0', true );
                wp_register_script( 'jquery-custom-ui', assets_js() . 'jquery-ui-1.8.22.custom.min.js', false, '1.0', true );
                wp_register_script( 'bigvideo', assets_js() . 'bigvideo.js', false, '1.0', true );
                
                $deps[] = 'jquery-imagesloaded';
                $deps[] = 'zencoder';
                $deps[] = 'jquery-custom-ui';
                $deps[] = 'bigvideo';
                
                $video_alt = ( !empty( $video_alt ) ) ? ', { altSource: "' . $video_alt . '" }' : '';
                $js = '
                var BV = new $.BigVideo({ useFlashForFirefox:false, doLoop:true });
                BV.init();
                BV.show( "' . $video . '"' . $video_alt .' );';
                add_jquery_ready($js);
            }
        }
        wp_register_script( 'custom-script', assets_js() . 'app.js', $deps, '2.1', true );
    }

    /**
     * Enqueue All
     */
    wp_enqueue_script( 'custom-script' );
}

function spyropress_conditional_scripts() {
    
    $content = '<!--[if lte IE 8]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->';
    
    echo get_relative_url( $content );
}
?>