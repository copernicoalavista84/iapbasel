<?php

/**
 * Module: Skill List
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Skills extends SpyropressBuilderModule {

    /**
     * Constructor
     */
    public function __construct() {

        $this->path = dirname(__FILE__);
        // Widget variable settings
        $this->cssclass = 'module-skill-list';
        $this->description = __( 'Display a list of skills.', 'spyropress' );
        $this->id_base = 'skill_list';
        $this->name = __( 'Skill List', 'spyropress' );
        
        // Fields
        $this->fields = array (
            
            array(
                'label' => __( 'Title', 'spyropress' ),
                'id' => 'title',
                'type' => 'text'
            ),
                    
            array(
                'label' => __( 'Skills', 'spyropress' ),
                'id' => 'skills',
                'type' => 'repeater',
                'item_title' => 'title',
                'fields' => array(
                    array( 'type' => 'row' ),
                    array( 'type' => 'col', 'size' => 8 ),
                    array(
                        'label' => __( 'Label', 'spyropress' ),
                        'id' => 'title',
                        'type' => 'text',
                        'class' => 'section-full'
                    ),
                    array( 'type' => 'col_end' ),
                    array( 'type' => 'col', 'size' => 8 ),
                    array(
                        'label' => __( 'Percentage', 'spyropress' ),
                        'id' => 'percentage',
                        'type' => 'text',
                        'class' => 'section-full'
                    ),
                    array( 'type' => 'col_end' ),
                    array( 'type' => 'row_end' )
                )
            ),
        );
        
        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        extract( $args ); extract( $instance );
        include $this->get_view();
    }

}

spyropress_builder_register_module( 'Spyropress_Module_Skills' );

?>