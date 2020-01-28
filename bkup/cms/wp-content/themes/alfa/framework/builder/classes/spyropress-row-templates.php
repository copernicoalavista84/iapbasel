<?php

/**
 * SpyroPress Builder
 * Default builder row types
 *
 * @author 		SpyroSol
 * @category 	Builder
 * @package 	Spyropress
 */

/**
 * One Column Row
 */
class one_col_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( '1Col Row', 'spyropress' ),
            'description' => __( 'Full width row.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/1col.png' ),
            'columns' => array(
                array( 'type' => 'col_16' )
            )
        );
    }
}
spyropress_builder_register_row( 'one_col_row_class' );

/**
 * Two Column Row
 */
class two_col_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( '2Col Row', 'spyropress' ),
            'description' => __( 'Row contain 2 half columns.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/2col.png' ),
            'columns' => array(
                array( 'type' => 'col_8' ),
                array( 'type' => 'col_8' )
            )
        );
    }
}
spyropress_builder_register_row( 'two_col_row_class' );

/**
 * Four Column Row
 */
class four_col_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( '4Col Row', 'spyropress' ),
            'description' => __( 'Row contain 4 one-third columns.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/4col.png' ),
            'columns' => array(
                array( 'type' => 'col_4' ),
                array( 'type' => 'col_4' ),
                array( 'type' => 'col_4' ),
                array( 'type' => 'col_4' )
            )
        );
    }
}
spyropress_builder_register_row( 'four_col_row_class' );

/**
 * Eight Column Row
 */
class eight_col_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( '8Col Row', 'spyropress' ),
            'description' => __( 'Row contain 8 columns.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/6col.png' ),
            'columns' => array(
                array( 'type' => 'col_2' ),
                array( 'type' => 'col_2' ),
                array( 'type' => 'col_2' ),
                array( 'type' => 'col_2' ),
                array( 'type' => 'col_2' ),
                array( 'type' => 'col_2' ),
                array( 'type' => 'col_2' ),
                array( 'type' => 'col_2' )
            )
        );
    }
}
spyropress_builder_register_row( 'eight_col_row_class' );

/**
 * Left Sidebar Row
 */
class left_sidebar_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Left Sidebar', 'spyropress' ),
            'description' => __( 'Row has left sidebar.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/left-sidebar.png' ),
            'columns' => array(
                array( 'type' => 'col_4' ),
                array( 'type' => 'col_12' )
            )
        );
    }
}
spyropress_builder_register_row( 'left_sidebar_row_class' );

/**
 * Right Sidebar Row
 */
class right_sidebar_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Right Sidebar', 'spyropress' ),
            'description' => __( 'Row has right sidebar.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/right-sidebar.png' ),
            'columns' => array(
                array( 'type' => 'col_12' ),
                array( 'type' => 'col_4' )
            )
        );
    }
}
spyropress_builder_register_row( 'right_sidebar_row_class' );

/**
 * Blank Row
 */
class blank_row_class extends SpyropressBuilderRow {

    public function __construct() {

        $this->config = array(
            'name' => __( 'Section Row', 'spyropress' ),
            'description' => __( 'Section Row.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/1col.png' ),
            'columns' => array(
                array( 'type' => 'col_16' )
            )
        );
    }
    
    function row_wrapper( $row_ID, $row ) {
        
        $html = '';
        foreach ( $row['columns'] as $col_ID => $column ) {
            $html .= builder_render_frontend_modules( $column['modules'] );
        }
        
        $row_html = sprintf( '
            <div id="%1$s" class="section">
                %2$s
            </div>', $row_ID, $html
        );
        
        return $row_html;
    }
}
spyropress_builder_register_row( 'blank_row_class' );
?>