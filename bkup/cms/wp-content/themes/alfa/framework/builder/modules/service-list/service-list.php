<?php

/**
 * Module: Service List
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Service_List extends SpyropressBuilderModule {

    /**
     * Constructor
     */
    public function __construct() {

        $this->path = dirname(__FILE__);
        // Widget variable settings
        $this->cssclass = 'module-service-list';
        $this->description = __( 'Display a list of services.', 'spyropress' );
        $this->id_base = 'service_list';
        $this->name = __( 'Service List', 'spyropress' );
        
        // Fields
        $this->fields = array (
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text'
            ),
            
            array(
                'label' => __( 'Style', 'spyropress' ),
                'id' => 'style',
                'type' => 'select',
                'options' => array(
                    'arrow' => 'Arrow List',
                    'checkmark' => 'Checkmark List',
                ),
                'std' => 'arrow'
            ),
            
            array(
                'label' => __( 'Service', 'spyropress' ),
                'id' => 'list',
                'type' => 'repeater',
                'fields' => array(
        
                    array(
                        'label' => __( 'Teaser', 'spyropress' ),
                        'id' => 'content',
                        'type' => 'textarea',
                        'rows' => 4
                    )
                )
            )
        );
        
        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        extract( $args ); extract( $instance );
        include $this->get_view();
    }

}

spyropress_builder_register_module( 'Spyropress_Module_Service_List' );

?>