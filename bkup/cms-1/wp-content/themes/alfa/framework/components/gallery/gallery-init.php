<?php

/**
 * Gallery Component
 * 
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressGallery extends SpyropressComponent {

    private $path;
    
    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        add_filter( 'builder_include_modules', array( $this, 'register_module' ) );
    }

    function register() {

        // Init Post Type
        $args = array(
            'supports' => array( 'title' )
        );
        $post = new SpyropressCustomPostType( 'Gallery', '', $args );
        $post->add_taxonomy( 'Category', 'gallery_cats', '', array( 'hierarchical' => true ) );
        
        // Add Meta Boxes
        $meta_fields['gallery'] = array(
            array(
                'label' => 'gallery',
                'type' => 'heading',
                'slug' => 'gallery'
            ),
            
            array(
                'label' => 'Content Type',
                'id' => 'content_type',
                'type' => 'select',
                'class' => 'enable_changer',
                'options' => array(
                    'image' => 'Picture',
                    'video' => 'Video'
                ),
                'std' => 'image'
            ),
    
            array(
                'label' => 'Picture',
                'id' => 'image',
                'type' => 'upload'
            ),
    
            array(
                'label' => 'Video URL',
                'class' => 'content_type video',
                'id' => 'video_url',
                'type' => 'text'
            )
        );
        
        $post->add_meta_box( 'gallery_content', 'Content', $meta_fields, '_gallery_content', false );
    }
    
    function register_widget( $widgets ) {
        
        $widgets[] = $this->path . '/widget';
        
        return $widgets;
    }
    
    function register_module( $modules ) {

        $modules[] = $this->path . '/module/module.php';

        return $modules;
    }
}

/**
 * Init the Component
 */
new SpyropressGallery();
?>