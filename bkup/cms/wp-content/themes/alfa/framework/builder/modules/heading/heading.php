<?php

/**
 * Module: Heading
 * Add headings into the page layout wherever needed.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Heading extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->cssclass = 'module-heading';
        $this->description = __( 'Add headings into the page layout wherever needed.', 'spyropress' );
        $this->id_base = 'spyropress_heading';
        $this->name = __( 'Heading', 'spyropress' );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Heading Text', 'spyropress' ),
                'id' => 'heading',
                'type' => 'text',
            ),
            
            array(
                'label' => __( 'Descriptive Text', 'spyropress' ),
                'id' => 'description',
                'class' => 'style two',
                'type' => 'textarea',
                'rows' => 4
            ),
            
            array(
                'label' => __( 'Style', 'spyropress' ),
                'id' => 'style',
                'type' => 'select',
                'class' => 'enable_changer',
                'options' => array(
                    'two' => 'Two Liner',
                    'one' => 'One Liner',
                    'simple' => 'Content Heading'
                ),
                'std' => 'two'
            ),
            
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        $style = 'two';
        extract( $args ); extract( $instance );

        // get view to title
        if( 'two' == $style ) {
            echo '<div class="container">';
            if( $heading ) echo "<h1>$heading</h1>";
            if( $description ) echo "<h5>$description</h5>";
            echo '</div>';
        }
        elseif( 'one' == $style ) {
            echo '<div class="padding-top">';
                if( $heading ) echo "<h6>$heading</h6>";
			echo '</div>';
        }
        else {
            if( $heading ) echo "<h6>$heading</h6>";
        }
    }
}

spyropress_builder_register_module( 'Spyropress_Module_Heading' );

?>