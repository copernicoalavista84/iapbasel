<?php

/**
 * Option/Settings Helper Functions
 *
 * @category Utilities
 * @package Spyropress
 *
 */

/** Option Getter and Formatter **********************/

function get_float_class( $float ) {
    
    // check for null
    if ( ! $float ) return;

    $allowed_floats = array( 'left' => 'pull-left', 'right' => 'pull-right' );

    if ( in_array( $float, array_keys( $allowed_floats ) ) )
        $float = $allowed_floats[$float];

    return $float;
}

/**
 * Row Class
 */
function get_row_class( $return = false ) {
    global $spyropress;

    if ( $return )
        return $spyropress->row_class;
    echo $spyropress->row_class;
}

/**
 * Column Class
 */
function get_column_class( $column ) {

    $class = 'span12';

    switch ( $column ) {
        case 2:
            $class = 'span6';
            break;
        case 3:
            $class = 'span4';
            break;
        case 4:
            $class = 'span3';
            break;
        case 6:
            $class = 'span2';
            break;
    }

    return $class;
}

/** Data Sources for Post Type and Taxonomies **********************/

/**
 * Buckets
 */
function spyropress_get_buckets() {
    
    $buckets = array();
    
    if ( ! post_type_exists( 'bucket' ) ) return $buckets;
    
    // get posts
    $args = array(
        'post_type' => 'bucket',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'asc'
    );
    $posts = get_posts( $args );
    if ( !empty( $posts ) ) {
        foreach ( $posts as $post ) {
            $buckets[$post->ID] = $post->post_title;
        }
    }

    return $buckets;
}

/**
 * Custom Taxonomies
 */
function spyropress_get_taxonomies( $tax = '' ) {
    
    if ( ! $tax ) return array();

    $terms = get_terms( $tax );
    $taxs = array();
    if ( !empty( $terms ) )
        foreach ( $terms as $term )
            $taxs[$term->slug] = $term->name;

    return $taxs;
}

/** Custom Data Sources ********************************************/

/**
 * jQuery Easing Options
 */
function spyropress_get_options_easing() {
    return array(
        'linear' => __( 'linear', 'spyropress' ),
        'jswing' => __( 'jswing', 'spyropress' ),
        'def' => __( 'def', 'spyropress' ),
        'easeInQuad' => __( 'easeInQuad', 'spyropress' ),
        'easeOutQuad' => __( 'easeOutQuad', 'spyropress' ),
        'easeInOutQuad' => __( 'easeInOutQuad', 'spyropress' ),
        'easeInCubic' => __( 'easeInCubic', 'spyropress' ),
        'easeOutCubic' => __( 'easeOutCubic', 'spyropress' ),
        'easeInOutCubic' => __( 'easeInOutCubic', 'spyropress' ),
        'easeInQuart' => __( 'easeInQuart', 'spyropress' ),
        'easeOutQuart' => __( 'easeOutQuart', 'spyropress' ),
        'easeInOutQuart' => __( 'easeInOutQuart', 'spyropress' ),
        'easeInQuint' => __( 'easeInQuint', 'spyropress' ),
        'easeOutQuint' => __( 'easeOutQuint', 'spyropress' ),
        'easeInOutQuint' => __( 'easeInOutQuint', 'spyropress' ),
        'easeInSine' => __( 'easeInSine', 'spyropress' ),
        'easeOutSine' => __( 'easeOutSine', 'spyropress' ),
        'easeInOutSine' => __( 'easeInOutSine', 'spyropress' ),
        'easeInExpo' => __( 'easeInExpo', 'spyropress' ),
        'easeOutExpo' => __( 'easeOutExpo', 'spyropress' ),
        'easeInOutExpo' => __( 'easeInOutExpo', 'spyropress' ),
        'easeInCirc' => __( 'easeInCirc', 'spyropress' ),
        'easeOutCirc' => __( 'easeOutCirc', 'spyropress' ),
        'easeInOutCirc' => __( 'easeInOutCirc', 'spyropress' ),
        'easeInElastic' => __( 'easeInElastic', 'spyropress' ),
        'easeOutElastic' => __( 'easeOutElastic', 'spyropress' ),
        'easeInOutElastic' => __( 'easeInOutElastic', 'spyropress' ),
        'easeInBack' => __( 'easeInBack', 'spyropress' ),
        'easeOutBack' => __( 'easeOutBack', 'spyropress' ),
        'easeInOutBack' => __( 'easeInOutBack', 'spyropress' ),
        'easeInBounce' => __( 'easeInBounce', 'spyropress' ),
        'easeOutBounce' => __( 'easeOutBounce', 'spyropress' ),
        'easeInOutBounce' => __( 'easeInOutBounce', 'spyropress' ),
    );
}

function spyropress_get_options_float() {
    return array(
        'none' => __( 'None', 'spyropress' ),
        'left' => __( 'Left', 'spyropress' ),
        'right' => __( 'Right', 'spyropress' ),
    );
}

function spyropress_get_options_link( $fields ) {
    // check for emptiness
    if ( empty( $fields ) ) $fields = array();

    return array_merge( $fields, array(
        array(
            'label' => __( 'URL/Link Setting', 'spyropress' ),
            'type' => 'toggle'
        ),

        array(
            'label' => __( 'Link Text', 'spyropress' ),
            'id' => 'url_text',
            'type' => 'text'
        ),

        array(
            'label' => __( 'URL/Hash', 'spyropress' ),
            'id' => 'url',
            'type' => 'text'
        ),

        array(
            'label' => __( 'Link to Post/Page', 'spyropress' ),
            'id' => 'link_url',
            'type' => 'custom_post',
            'post_type' => array( 'post', 'page' )
        ),

        array( 'type' => 'toggle_end' )
    ) );
}
?>