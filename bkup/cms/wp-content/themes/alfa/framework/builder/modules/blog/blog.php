<?php

/**
 * Module: Blog
 * Display a list of blog posts
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Blog_Posts extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );
        $this->cssclass = 'module-post';
        $this->description = __( 'Display a list of blog posts.', 'spyropress' );
        $this->id_base = 'spyropress_post';
        $this->name = __( 'Blog Posts', 'spyropress' );

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
                'options' => spyropress_get_taxonomies( 'category' )
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
            'post_type' => 'post',
            'limit' => -1,
            'columns' => false,
            'pagination' => false,
            'callback' => 'generate_post_item',
            'item_class' => 'portfolio-entry'
        );
        $atts = wp_parse_args( $atts, $default );
    
        if ( ! empty( $atts['cat'] ) ) {
    
            $atts['tax_query']['relation'] = 'OR';
            if ( ! empty( $atts['cat'] ) ) {
                $atts['tax_query'][] = array(
                    'taxonomy' => 'category',
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

spyropress_builder_register_module( 'Spyropress_Module_Blog_Posts' );


// Item HTML Generator
function generate_post_item( $post_ID, $atts ) {

    // these arguments will be available from inside $content
    $image = array(
        'post_id' => $post_ID,
        'echo' => false,
        'width' => 600
    );
    $image_tag = get_image( $image );
    $image_tag = ( $image_tag ) ? $image_tag : '&nbsp;';
    
    // item tempalte
    $item_tmpl = '
    <div class="post-entry">
    	<div class="container">
    		<div class="three columns">
    			<div class="client">
                    <p>' . get_the_date( 'd.m.Y.' ) . '</p>
                    <h4>' . get_the_time() . '</h4>
    			</div>
    		</div>
    		<div class="nine columns">
    			' . $image_tag . '
    		</div>
    		<div class="four columns">
    			<div class="info-blog">
    				<h6>' . get_the_title( $post_ID ) . '</h6>
    				<p>' . get_the_excerpt() . '</p>
                    <a class="inner-button-blog" href="' . get_permalink( $post_ID ) . '">View Post</a>
    			</div>
    		</div>
    	</div>
    </div>';
    
    return $item_tmpl;
}
?>