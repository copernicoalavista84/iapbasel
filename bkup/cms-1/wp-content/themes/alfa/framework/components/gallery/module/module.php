<?php

/**
 * Module: Gallery
 * Display a list of gallery item
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Gallery extends SpyropressBuilderModule {

    public function __construct() {

        // Widget variable settings.
        $this->path = dirname( __FILE__ );
        $this->cssclass = 'module-gallery';
        $this->description = __( 'Display a list of gallery items.', 'spyropress' );
        $this->id_base = 'spyropress_gallery';
        $this->name = __( 'Gallery', 'spyropress' );
        
        
        // Fields
        $this->fields = array(

            array(
                'label' => __( 'Number of items', 'spyropress' ),
                'id' => 'limit',
                'type' => 'range_slider',
                'max' => 50,
                'std' => 10
            ),
                
            array(
                'label' => __( 'Portfolio Category', 'spyropress' ),
                'id' => 'cat',
                'type' => 'multi_select',
                'options' => spyropress_get_taxonomies( 'gallery_cats' )
            ),

            array(
                'id' => 'filters',
                'type' => 'checkbox',
                'options' => array(
                    '1' => __('Enable filters for items', 'spyropress')
                )
            )
        );

        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        extract( $args );

        // get view to render
        include $this->get_view();
    }
    
    function display_filters( $instance, $all_id = 'all' ) {
        
        if( !isset( $instance['filters'] ) ) return;
        
        $cats = spyropress_get_taxonomies( 'gallery_cats' );
        
        if( empty( $cats ) ) return;
        
        echo '<div class="fil"><div class="container"><div class="sixteen columns"><div id="portfolio-filter"><ul id="filter">';
        echo '<li><a href="#" class="current" data-filter="*" title="Show all items">Show all</a></li>';
                
            foreach( $cats as $slug => $name ) {
                echo '<li><a href="#" data-filter=".' . $slug . '" title="Show all items under ' . ucwords( $name ) . '">' . $name . '</a></li>';
            }
        
        echo '</ul></div></div></div></div>';
    }
    
    function query( $atts, $content = null ) {

        $default = array (
            'post_type' => 'gallery',
            'limit' => -1,
            'columns' => false,
            'pagination' => false,
            'callback' => 'generate_gallery_items'
        );
        $atts = wp_parse_args( $atts, $default );
    
        if ( ! empty( $atts['cat'] ) ) {
    
            $atts['tax_query']['relation'] = 'OR';
            if ( ! empty( $atts['cat'] ) ) {
                $atts['tax_query'][] = array(
                    'taxonomy' => 'gallery_cats',
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

spyropress_builder_register_module( 'Spyropress_Module_Gallery' );


// Item HTML Generator
/**
 * generate_masonary_items()
 * 
 * @param mixed $post_ID
 * @param mixed $atts
 * @return
 */
function generate_gallery_items( $post_ID, $atts ) {
    
    $content = get_post_meta( $post_ID, '_gallery_content', true );
    $cats = get_the_terms( $post_ID, 'gallery_cats' );
    
    $cat_class = '';
    if( !empty( $cats ) ) {
        foreach( $cats as $cat )
            $cat_class .= ' ' . $cat->slug;
    }
    
    $image = get_image( array(
        'width' => 500,
        'echo' => false,
        'url' => $content['image']                 
    ) );
    
    if ( 'video' == $content['content_type'] ) {
        return '
        <li class="view video' . $cat_class . '">
        	<div class="view video">
                <a class="fancybox-media" data-fancybox-group="gallery" href="' . $content['video_url'] . '" title="' . esc_attr( get_the_title( $post_ID ) ) . '">
                    ' . $image . '			
                    <div class="mask"></div>
                </a>
            </div>                                 
        </li>';
    }
    else {
        return '
        <li class="view' . $cat_class . '">
        	<div class="view">
                <a class="fancybox" data-fancybox-group="gallery" href="' . $content['image'] . '" title="' . esc_attr( get_the_title( $post_ID ) ) . '">
                    ' . $image . '			
                    <div class="mask"></div>
                </a>
            </div>                                 
        </li>';
    }
}
?>