<?php

/**
 * Module: Icon Teaser
 * Display a brief text with a link and use hundreds of built-in icons
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Icon_Teaser extends SpyropressBuilderModule {

    /**
     * Constructor
     */
    public function __construct() {

        // Widget variable settings
        $this->cssclass = 'module-icon-teaser';
        $this->description = __( 'Display a brief text with a link and use of icons.', 'spyropress' );
        $this->id_base = 'spyropress_icon_teaser';
        $this->name = __( 'Icon Teaser', 'spyropress' );

        // Fields
        $this->fields = array (
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text'
            ),

            array(
                'label' => __( 'Content', 'spyropress' ),
                'id' => 'content',
                'type' => 'textarea',
                'rows' => 6
            ),
            
            array(
                'label' => __( 'Upload Icon', 'spyropress' ),
                'id' => 'icon',
                'type' => 'upload'
            ),
        );
        
        $this->fields = spyropress_get_options_link( $this->fields );
        
        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        $icon = $url_text = $link_url = $url = '';
        extract( $args ); extract( spyropress_clean_array( $instance ) );
        
        if( $title ) $title = '<h6>' . $title . '</h6>';
        if( $icon ) $title = '<div class="heading-and-icon"><img width="60" height="60" alt="" src="' . $icon . '">' . $title . '</div>';
        echo $title . wpautop( $content );
        
        $url_text = ( $url_text ) ? $url_text : 'View Details';
        $url = ( $link_url ) ? get_permalink( $link_url ) : $url;
        if ( $url ) $url = ' <a class="b-small" href="' . $url . '">' . $url_text . '</a>';
        
        echo $url;
    }
}

spyropress_builder_register_module( 'Spyropress_Module_Icon_Teaser' );

?>