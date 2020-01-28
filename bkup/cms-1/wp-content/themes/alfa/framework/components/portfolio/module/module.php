<?php

/**
 * Module: Portfolio
 * Display a list of portfolio
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Portfolio extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );
        $this->cssclass = 'module-portfolio';
        $this->description = __( 'Display a list of portfolio.', 'spyropress' );
        $this->id_base = 'spyropress_portfolio';
        $this->name = __( 'Recent Portfolio', 'spyropress' );

        // Fields
        $this->fields = array(
            
            array(
                'label' => __( 'Number of items per page', 'spyropress' ),
                'id' => 'limit',
                'type' => 'range_slider',
                'max' => 30,
                'std' => 4
            ),
            
            array(
                'label' => __( 'Portfolio Category', 'spyropress' ),
                'id' => 'cat',
                'type' => 'multi_select',
                'options' => spyropress_get_taxonomies( 'portfolio_tags' )
            ),
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        extract( $args );

        // get view to render
        include $this->get_view();
    }
    
    function query( $atts, $content = null ) {

        $default = array (
            'post_type' => 'portfolio',
            'limit' => -1,
            'columns' => false,
            'pagination' => false,
            'callback' => 'generate_portfolio_item',
            'item_class' => 'portfolio-entry'
        );
        $atts = wp_parse_args( $atts, $default );
    
        if ( ! empty( $atts['cat'] ) ) {
    
            $atts['tax_query']['relation'] = 'OR';
            if ( ! empty( $atts['cat'] ) ) {
                $atts['tax_query'][] = array(
                    'taxonomy' => 'portfolio_category',
                    'field' => 'slug',
                    'terms' => $atts['cat'],
                    );
                unset( $atts['cat'] );
            }
        }
    
        if ( $content )
            return token_repalce( $content, spyropress_query_generator( $atts ) );
    
        return spyropress_query_generator( $atts );
    }

}

spyropress_builder_register_module( 'Spyropress_Module_Portfolio' );


// Item HTML Generator
function generate_portfolio_item( $post_ID, $atts ) {

    // these arguments will be available from inside $content
    $image = array(
        'post_id' => $post_ID,
        'echo' => false,
        'width' => 600
    );
    $image_tag = get_image( $image );
    
    $details = get_post_meta( $post_ID, '_portfolio_details', true );
    $client_logo = isset( $details['client_logo'] ) ? '<img src="' . $details['client_logo'] . '" />' : '';
    $client = isset( $details['client'] ) ? '<strong>Client:</strong><em>' . $details['client'] . '</em><br>' : '';
    $date = isset( $details['client'] ) ? '<strong>Date:</strong><em>' . $details['date'] . '</em>' : '';
    $view_online = isset( $details['project_url'] ) ? '<a class="inner-button-works" href="' . $details['project_url'] . '">View Online</a>' : '';
    
    // item tempalte
    $item_tmpl = '
    <div class="work-entry">
    	<div class="container">
    		<div class="three columns">
    			<div class="client">
                    ' . $client_logo . '
    			</div>
    		</div>
    		<div class="nine columns">
    			<div class="view-work">
    				<a class="fancybox fancybox.iframe" href="' . get_permalink( $post_ID ) . '">
                        ' . $image_tag . '
    				    <div class="mask-work"></div>
    				</a>
    			</div>
    		</div>
    		<div class="four columns">
    			<div class="info-works">
    				<h6>' . get_the_title( $post_ID ) . '</h6>
    				<p>' . $client . $date . '</p>
                    ' . $view_online . '
    			</div>
    		</div>
    	</div>
    </div>';
    
    return $item_tmpl;
}
?>