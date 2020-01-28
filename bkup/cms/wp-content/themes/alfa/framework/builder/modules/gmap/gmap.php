<?php

/**
 * Module: Gmap
 * Add headings into the page layout wherever needed.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Gmap extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings
        $this->cssclass = '';
        $this->description = __( 'Add google map into the page layout wherever needed.', 'spyropress' );
        $this->id_base = 'spyropress_gmap';
        $this->name = __( 'Google Map', 'spyropress' );

        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Lat', 'spyropress' ),
                'id' => 'heading',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Long', 'spyropress' ),
                'id' => 'sub_heading',
                'type' => 'text'
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args ); extract( $instance );

        if( empty( $heading ) && empty( $sub_heading ) ) return;
                
        echo '<div id="map" data-lat="' . $heading . '" data-long="' . $sub_heading . '"></div>';
    }
}

spyropress_builder_register_module( 'Spyropress_Module_Gmap' );

?>