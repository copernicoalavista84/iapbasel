<?php

/**
 * Bucket Component
 *
 * @package		SpyroPress
 * @category	Components
 */

class SpyropressBucket extends SpyropressComponent {

    private $path;

    function __construct() {

        $this->path = dirname(__FILE__);
        add_action( 'spyropress_register_taxonomy', array( $this, 'register' ) );
        add_filter( 'builder_include_modules', array( $this, 'register_module' ) );
        add_shortcode( 'bucket', array( $this, 'shortcode_handler' ) );
        //add_filter( 'spyropress_register_widgets', array( $this, 'register_module' ) );
    }

    function register() {

        // Init Post Type
        $args = array(
            'supports' => array( 'title', 'editor' )
        );
        $post = new SpyropressCustomPostType( 'Bucket', '', $args );
        
        global $pagenow;
        
        $fields['link_generator'] = array(
            array(
                'label' => 'shortcode',
                'type' => 'heading',
                'slug' => 'link-generator'
            ),
            array(
                'id' => 'instruction_info',
                'type' => 'raw_info',
                'function' => array( $this, 'link_generator' ),
                'desc' => 'good',
            )
        );

        //if( 'post.php' == $pagenow )
            //$post->add_meta_box( 'link_generator', 'Add to Menu', $fields, false, false, 'side' );
    }
    
    function link_generator( $output ) {
        global $post;

        $post_name = $post->post_name;
        $post_permalink = get_permalink( $post->ID );
        $locations = get_registered_nav_menus();
        $menus = wp_get_nav_menus();
        $home_id = get_option( 'page_on_front' );
        $post_link = '';
        $is_link = false;

        if ( isset( $locations ) && count( $locations ) > 0 && isset( $menus ) && count( $menus ) > 0 ) {

            // Create link
            $post_link = '#HOME_URL#section-' . $post_name;

            // Check if this page is already on the menu.
            foreach ( $menus as $menu ) {
                $menu_items = wp_get_nav_menu_items( $menu->term_id );
                $current_menu = $menu->name;
                foreach ( $menu_items as $menu_item ) {
                    if ( $menu_item->url == $post_link ) {
                        echo '<p>' . __( 'This page already exists in:', 'spyropress' ) . ' <strong>' .
                            $current_menu . '</strong></p>';
                        $is_link = true;
                        break;
                    }
                }
            }

            if ( ! $is_link ) {
                $select_options = '';
                foreach ( $menus as $menu ) {
                    $select_options .= '<option value="' . $menu->term_id . '">' . $menu->name . '</option>';
                }
                
                echo '<div id="link_generator_controls">';
                
                echo '<div class="section section-select section-full">
                        <h3 class="heading">Menu Name</h3>
                        <div class="controls">
                            <select id="menu_id" class="chosen">
                                <option value=""></option>
                                ' . $select_options . '
                            </select>
                        </div>
                    </div>';
                
                echo '<div class="section section-text section-full">
                        <h3 class="heading">Menu Label</h3>
                        <div class="controls">
                            <input type="text" value="' . $post->post_title . '" id="menu_label" class="field"/>
                        </div>
                    </div>';

                echo '<input type="hidden" value="' . $post_link . '" id="menu_link" />';
                
                echo '<a href="#" class="add-menu-link button button-primary button-large">' . __( 'Add Menu Item', 'spyropress' ) . '</a><span class="spinner" style=""></span>';
                
                echo '</div>';
            }
        }
        else {
            echo '<p>' . __( 'Your theme does not have menus. If you want to add this page you need to create a new menu. Go to -> Appearance -> Menus',
                'spyropress' ) . '</p>';
        }

        echo '<p class="ajax-warning hidden empty-fields">' . __( 'Error - The fields can not be empty. Fill in empty fields and try again.', 'spyropress' ) . '</p>';
        echo '<p class="link-success hidden">' . __( 'Page has been added to the menu.', 'spyropress' ) . '</p>';

        return '';
    }

    function register_module( $modules ) {

        $modules[] = $this->path . '/module/bucket.php';

        return $modules;
    }

    function shortcode_handler( $atts, $content = '' ) {

        if ( isset( $atts['id'] ) && $atts['id'] )
            return spyropress_get_the_bucket( $atts['id'] );
    }
}

/**
 * Init the Component
 */
new SpyropressBucket();

/** Template Tags ************************/

/**
 * the_builder_content
 */
function spyropress_the_bucket( $id ) {
    echo spyropress_get_the_builder_content( $id );
}
function spyropress_get_the_bucket( $id ) {

    if ( class_exists( 'SpyropressBuilder' ) && spyropress_has_builder_content( $id ) ) {
        
        return spyropress_get_the_builder_content( $id );
    }
    else {
        $bucket = get_post( $id );
        $content = apply_filters( 'the_content', $bucket->post_content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        return $content;
    }
}
?>