<?php

/**
 * SpyroPress Template Functions
 * Functions used in the template files to output content - in most cases hooked in via the template actions. All functions are pluggable.
 *
 * @category Core
 * @package SpyroPress
 */

/**
 * Get Post Views
 */
function spyropress_post_views( $post_id = 0, $singular = 'View', $plural = 'Views' ) {
    echo spyropress_get_post_views( $post_id, $singular, $plural );
}
function spyropress_get_post_views( $post_id = 0, $singular = 'View', $plural = 'Views' ) {

    global $post;

    $postID = ( !empty( $post_id ) && $post_id ) ? $post_id : $post->ID;

    $count_key = '_post_views_count';
    $count = get_post_meta( $postID, $count_key, true );
    $count = ( $count ) ? $count : 0;

    return sprintf( _n( '%d ' . $singular, '%d ' . $plural, $count ), $count );
}

/**
 * Logo
 * Get logo from theme options or pass custom logo
 */
function spyropress_logo( $args = '', $content = '' ) {
    echo spyropress_get_logo( $args, $content );
}
function spyropress_get_logo( $args = '', $content = '' ) {

    $defaults = array(
        'tag' => ( is_front_page() || is_home() ) ? 'h1' : 'div',
        'class' => 'logo',
        'id' => 'logo',
        'link' => esc_url( home_url( '/' ) ),
        'alt' => get_bloginfo( 'name' ),
        'title' => get_bloginfo( 'name' ),
        'show_img' => !get_setting( 'texttitle', false ),
        'img' => get_setting( 'logo', false ),
        'brand' => false,
        'before' => '',
        'after' => ''
    );
    $args = wp_parse_args( $args, $defaults );
    extract( $args, EXTR_SKIP );

    if ( !$brand ) {
        $before = sprintf( '<%1$s class="%2$s" id="%3$s">', $tag, $class, $id );
        $after = sprintf( '</%1$s>', $tag );
    }

    $logo = sprintf(
        '<a href="%1$s" title="%2$s"%3$s>%4$s</a>',
        $link, esc_attr( strip_tags( $title ) ), ( $brand ) ? ' class="brand"' : '',
        ( $img ) ? '<img src="' . $img . '" alt="' . $alt . '" title="' . esc_attr( strip_tags( $title ) ) . '" />' : $title
    );

    return $before . $logo . $after;
}

/**
 * Get menu with Bootstrap Walker
 */
function spyropress_get_nav_menu( $location = 'primary', $args = '' ) {

    $defaults = array(
        'theme_location' => $location,
        'container' => 'nav',
        'container_class' => 'navbar',
        'container_id' => 'primary-nav',
        'menu_class' => 'nav',
        'walker' => new Bootstrapwp_Walker_Nav_Menu
    );

    return wp_nav_menu( wp_parse_args( $args, $defaults ) );
}

/**
 * the_content
 */
function spyropress_the_content( $post_id = '' ) {

    echo spyropress_get_the_content( $post_id );
}

function spyropress_get_the_content( $post_id = '' ) {

    if ( class_exists( 'SpyropressBuilder' ) && spyropress_has_builder_content( $post_id ) ) {
        return spyropress_get_the_builder_content( $post_id );
    }
	elseif ( is_singular() || get_setting( 'post_content' ) == 'content' ) {
        ob_start();
        the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'spyropress' ) );
        return ob_get_clean();
    }
    else {
        return get_the_excerpt();
    }
}

/**
 * Related Post
 */
function spyropress_related_post( $args = array() ) {

    if ( !is_singular() ) return;
    
    spyropress_get_template_part( 'part=templates/related-posts' );
}

/**
 * Author Box
 */
function spyropress_authorbox() {
    spyropress_get_template_part( 'part=templates/author-box' );
}

?>