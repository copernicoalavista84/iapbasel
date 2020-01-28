<?php

/**
 * Portfolio Component
 * 
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressPortfolio extends SpyropressComponent {

    private $path;
    
    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        add_filter( 'builder_include_modules', array( $this, 'register_module' ) );
    }

    function register() {

        // Init Post Type
        $post = new SpyropressCustomPostType( 'Portfolio' );
        $post->add_taxonomy( 'Tags', 'portfolio_tags' );
        
        // Add Meta Boxes
        $meta_fields['portfolio'] = array(
            array(
                'label' => 'Portfolio',
                'type' => 'heading',
                'slug' => 'portfolio'
            ),
            
            array(
                'label' => 'Client',
                'id' => 'client',
                'type' => 'text'
            ),
    
            array(
                'label' => 'Release Date',
                'id' => 'date',
                'type' => 'datepicker'
            ),
    
            array(
                'label' => 'Project URL',
                'id' => 'project_url',
                'type' => 'text'
            ),
            
            array(
                'label' => 'Client Logo',
                'id' => 'client_logo',
                'type' => 'upload'
            ),
        );
        
        $post->add_meta_box( 'portfolio', 'Portfolio Details', $meta_fields, '_portfolio_details', false );
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
new SpyropressPortfolio();
?>