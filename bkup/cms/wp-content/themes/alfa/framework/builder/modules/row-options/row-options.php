<?php

/**
 * Module: Sub-Pages
 * A list of sub-page titles or excerpts.
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Row_Options extends SpyropressBuilderModule {

    public function __construct() {

        $this->cssclass = 'row-options';
        $this->description = __( 'Set row options and styling here.', 'spyropress' );
        $this->id_base = 'spyropress_row_options';
        $this->name = __( 'Row Options', 'spyropress' );

        $locations = get_registered_nav_menus();
        $menus = wp_get_nav_menus();
        $menu_options = array();
        
        if ( isset( $locations ) && count( $locations ) > 0 && isset( $menus ) && count( $menus ) > 0 ) {
            foreach ( $menus as $menu ) {
                $menu_options[$menu->term_id] = $menu->name;
            }
        }
        
        // Fields
        $this->fields = array(

            array(
                'id' => 'show',
                'type' => 'checkbox',
                'options' => array(
                    '1' => '<strong>Disable this row temporarily</strong>'
                )
            ),

            /*array(
                'label' => 'Background Skin',
                'id' => 'bg_skin',
                'type' => 'select',
                'options' => array(
                    'color' => 'Colored',
                    'gray' => 'Gray',
                    'dark-gray' => 'Dark Gray',
                    'darker' => 'Darker Gray',
                    'light-gray' => 'Light Gray',
                    'white' => 'White',
                )
            )*/
        );
        
        if( !empty( $menu_options ) ) {
            $this->fields[] = array(
                'label' => 'Menu Name',
                'id' => 'menu_id',
                'type' => 'select',
                'options' => $menu_options
            );
            
            $this->fields[] = array(
                'label' => 'Menu Label',
                'id' => 'menu_label',
                'type' => 'text'
            );
        }

        $this->create_widget();
    }
    
    function after_validate_fields( $instance ) {
        
        if(
            isset( $instance['menu_id'] ) && isset( $instance['menu_label'] ) &&
            !empty( $instance['menu_id'] ) && !empty( $instance['menu_label'] )
        ) {
            
            $key = sanitize_key( $instance['menu_label'] );
            $instance['custom_container_id'] = $key;
            $menu_link = '#HOME_URL#' . $key;
            $is_link = false;
            
            $menu_items = wp_get_nav_menu_items( $instance['menu_id'] );
            foreach ( $menu_items as $menu_item ) {
                if ( $menu_item->url == $menu_link ) {
                    $is_link = true;
                    break;
                }
            }
            
            if ( ! $is_link ) {
                wp_update_nav_menu_item( $instance['menu_id'], 0, array(
                    'menu-item-title' => $instance['menu_label'],
                    'menu-item-classes' => 'internal',
                    'menu-item-url' => $menu_link,
                    'menu-item-status' => 'publish' ) );
        
                update_option( 'menu_check', true );
            }
        }
        
        return $instance;
    }
}

?>