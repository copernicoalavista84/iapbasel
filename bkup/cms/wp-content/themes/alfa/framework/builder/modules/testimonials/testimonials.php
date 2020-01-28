<?php

/**
 * Module: Testimonials
 *
 * @author 		SpyroSol
 * @category 	SpyropressBuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Testimonials extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.

        $this->cssclass = '';
        $this->description = __( 'Testimonials.', 'spyropress' );
        $this->id_base = 'testimonial';
        $this->name = __( 'Testimonials', 'spyropress' );

        // Fields
        $this->fields = array(        
                       
            array(
                'label' => __( 'Testimonial', 'spyropress' ),
                'id' => 'content',
                'type' => 'textarea',
                'rows' => 4
            ),
            
            array(
                'label' => __( 'Author Name', 'spyropress' ),
                'id' => 'author',
                'type' => 'text'
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {

        // extracting info
        extract( $args ); extract( $instance );
        
        echo '
       	<div class="back-quv">	
    		<div class="container">
    			<div class="sixteen columns">
    				<div class="quv">' . $content . '</div>
    				<div class="quv-autor">
    					<em>' . $author . '</em>
    				</div>
    			</div>
    		</div>
    	</div>';
    }

}
spyropress_builder_register_module( 'Spyropress_Module_Testimonials' );
?>