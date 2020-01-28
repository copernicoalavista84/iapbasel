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
        ( $img ) ? '<img src="' . $img . '" alt="' . $alt . '" title="' . esc_attr( strip_tags( $title ) ) . '" class="imgresize" />' : $title
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
 * Post Meta i.e. Date, Author, Comments
 */
function spyropress_post_meta( $args = '' ) {
    echo spyropress_get_post_meta( $args );
}
function spyropress_get_post_meta( $args = '' ) {

    $defaults = array(
        'wrapper' => 'div',
        'wrapper_class' => 'post-entry-meta entry-meta',
        'template' => '{author}{date}{category}{tags}{comments}',
        'use_icons' => true,
        'icons_color' => '',
        'related_post_meta' => get_setting( 'post_meta' ),
        'echo' => true
    );
    $args = wp_parse_args( $args, $defaults );
    extract( $args );

    if ( !is_array( $related_post_meta ) )
        $related_post_meta = ( $related_post_meta ) ? explode( ',', $related_post_meta ) : array();

    if ( $use_icons )
        $icon = '<i class="%s ' . $icons_color . '"></i>';

    if ( in_array( 'meta_author', $related_post_meta ) && $author = get_the_author() )
            $metas['author'] = sprintf(
                '<div class="meta-block">%s<span class="post-entry-author">By %s</span></div>',
                sprintf( $icon, 'icon-user' ), $author
            );

    if ( in_array( 'meta_category', $related_post_meta ) && $categories = get_the_category_list( ', ' ) )
        $metas['category'] = sprintf(
            '<div class="meta-block">%s<span class="post-entry-category">%s</span></div>',
            sprintf( $icon, 'icon-folder-close' ), $categories
        );

    if ( in_array( 'meta_date', $related_post_meta ) )
        $metas['date'] = sprintf(
            '<div class="meta-block">%s<span class="post-entry-date">%s</span></div>',
            sprintf( $icon, 'icon-time' ), get_the_date()
        );

    if ( in_array( 'meta_comments', $related_post_meta ) ) {

        if ( comments_open() && ! post_password_required() ) {
            $num_comments = get_comments_number();

            if ( $num_comments == 0 ) {
                $comments = __( '0 Comments', 'spyropress' );
            }
            elseif ( $num_comments > 1 ) {
                $comments = $num_comments . __( ' Comments', 'spyropress' );
            }
            else {
                $comments = __( '1 Comment', 'spyropress' );
            }

            $metas['comments'] = sprintf(
                '<div class="meta-block">%s<span class="post-entry-comments">%s</span></div>',
                sprintf( $icon, 'icon-comment' ), $comments
            );
        }
    }

    if ( in_array( 'meta_tags', $related_post_meta ) && $tags = get_the_tag_list( '', ', ', '' ) )
        $metas['tags'] = sprintf(
            '<div class="meta-block">%s<span class="post-entry-tags">%s</span></div>',
            sprintf( $icon, 'icon-tags' ), $tags
        );


    $content = sprintf( '<%1$s class="%2$s">%3$s<div class="clear"></div></%1$s>', $wrapper, $wrapper_class, token_repalce( $template, $metas ) );

    if ( $echo )
        echo $content;
    else
        return $content;
}

function spyropress_next_prev_post_link( $args = '' ) {
    echo spyropress_get_next_prev_post_link( $args );
}
function spyropress_get_next_prev_post_link( $args = '' ) {
    $defaults = array(
        'wrapper' => '<div class="nav-internal">',
        'wrapper_end' => '<div class="clear"></div></div>',
        'in_same_cat' => get_setting( 'next_prev_in_same_cat' ),
        'use_thumb' => get_setting( 'next_prev_use_thumb' ),
        'thumb_width' => get_setting( 'next_prev_thumb_width' ),
        'thumb_height' => get_setting( 'next_prev_thumb_height' ),
        'next_link_format' => get_setting( 'next_link_format' ),
        'prev_link_format' => get_setting( 'prev_link_format' )
    );
    $args = wp_parse_args( $args, $defaults );
    extract( $args );

    // prev post link
    $prev_post = get_previous_post( $in_same_cat );
    if ( ! empty( $prev_post ) ) {
        $prev_img = '';
        if ( $use_thumb ) {
            $img_args = array(
                'width' => $thumb_width,
                'height' => $thumb_height,
                'class' => 'pull-left',
                'echo' => false,
                'post_id' => $prev_post->ID
            );
            $prev_img = get_image( $img_args );
        }

        if ( ! $prev_link_format )
            $prev_link_format = '<span class="pull-left">' . __( '&laquo; Previous', 'spyropress' ) . '<br/>{title}</span>';

        $prev_link_format = str_replace( '{title}', get_the_title( $prev_post->ID ), $prev_link_format );
        $prev_link_format = str_replace( '{img}', $prev_img, $prev_link_format );

        $prev_link = '<div class="prev internal-section"><a href="' . get_permalink( $prev_post->ID ) . '">' . $prev_link_format . '</a></div>';
    }

    // next post link
    $next_post = get_next_post( $in_same_cat );
    if ( ! empty( $next_post ) ) {
        $next_img = '';
        if ( $use_thumb ) {
            $img_args = array(
                'width' => $thumb_width,
                'height' => $thumb_height,
                'class' => 'pull-right',
                'echo' => true,
                'post_id' => $next_post->ID
            );
            $next_img = get_image( $img_args );
        }

        if ( ! $next_link_format )
            $next_link_format = '<span class="pull-right">' . __( 'Next &raquo;', 'spyropress' ) . '<br/>{title}</span>';

        $next_link_format = str_replace( '{title}', get_the_title( $next_post->ID ), $next_link_format );
        $next_link_format = str_replace( '{img}', $next_img, $next_link_format );

        $next_link = '<div class="next internal-section"><a href="' . get_permalink( $next_post->ID ) . '">' . $next_link_format . '</a></div>';
    }

    return $wrapper . $prev_link . $next_link . $wrapper_end;
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
