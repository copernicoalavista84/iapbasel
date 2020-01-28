<?php

/**
 * SpyroPress Hooks
 * Action/filter hooks used for SpyroPress functions/templates
 *
 * @category Core
 * @package SpyroPress
 *
 */

/** WordPress Hooks ********************************************************/

/** Override Gallery Shortcode **/
remove_shortcode( 'gallery' );

/** Improved Excerpt **/
remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'spyropress_get_excerpt' );

/** Post Hooks **/
add_filter( 'post_class', 'spyropress_entry_class' );
add_action( 'wp_head', 'spyropress_set_post_views', 25 );
add_action( 'init', 'spyropress_set_post_views_cookies' );
/** SpyroPress Hooks ********************************************************/

/** Add elements and meta to <head> area **/
add_action( 'spyropress_head', 'display_meta_title', 1 );
add_action( 'spyropress_head', 'display_meta_tags', 2 );
add_action( 'spyropress_head', 'spyropress_register_stylesheets', 11 );
add_action( 'spyropress_head', 'spyropress_register_scripts', 11 );

add_action( 'wp_head', 'spyropress_head', 0 );
add_action( 'wp_head', 'spyropress_fav_touch_icons' );
add_action( 'wp_head', 'spyropress_conditional_scripts', 11 );

/** Header Hooks **/
add_action( 'spyropress_before_header', 'display_browser_happy', 1 );
add_filter( 'wp_nav_menu_items', 'spyropress_wp_nav_menu_objects', 10, 2 );

/** Footer Hooks **/
add_action( 'spyropress_footer', 'output_credit', 99 );
add_action( 'wp_footer', 'output_tracking_code', 99 );
?>