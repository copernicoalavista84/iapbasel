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
 * col_1by2
 */
class col_1by2 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/2 Column', 'spyropress' ),
            'description' => __( 'Half width column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_12.png' ),
            'size' => 8
        );
    }
}
spyropress_builder_register_column( 'col_1by2' );

/**
 * col_1by4
 */
class col_1by4 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/4 Column', 'spyropress' ),
            'description' => __( 'One-Fourth width column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_14.png' ),
            'size' => 4
        );
    }
}
spyropress_builder_register_column( 'col_1by4' );

/**
 * col_1by8
 */
class col_1by8 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1/8 Column', 'spyropress' ),
            'description' => __( 'One-Eight width column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_16.png' ),
            'size' => 2
        );
    }
}
spyropress_builder_register_column( 'col_1by8' );

/**
 * col_3by4
 */
class col_3by4 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '3/4 Column', 'spyropress' ),
            'description' => __( 'Three-Fourth width column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_34.png' ),
            'size' => 12
        );
    }
}
spyropress_builder_register_column( 'col_3by4' );

/**
 * col_3by8
 */
class col_3by8 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '3/8 Column', 'spyropress' ),
            'description' => __( 'Three-Eigth width column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_56.png' ),
            'size' => 6
        );
    }
}
spyropress_builder_register_column( 'col_3by8' );

/**
 * col_5by8
 */
class col_5by8 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '5/8 Column', 'spyropress' ),
            'description' => __( 'Five-Eigth width column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_56.png' ),
            'size' => 10
        );
    }
}
spyropress_builder_register_column( 'col_5by8' );

/**
 * col_1
 */
class col_1 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '1 Column', 'spyropress' ),
            'description' => __( '1 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 1
        );
    }
}
spyropress_builder_register_column( 'col_1' );

/**
 * col_2
 */
class col_2 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '2 Column', 'spyropress' ),
            'description' => __( '2 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 2
        );
    }
}
spyropress_builder_register_column( 'col_2' );

/**
 * col_3
 */
class col_3 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '3 Column', 'spyropress' ),
            'description' => __( '3 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 3
        );
    }
}
spyropress_builder_register_column( 'col_3' );

/**
 * col_4
 */
class col_4 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '4 Column', 'spyropress' ),
            'description' => __( '4 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 4
        );
    }
}
spyropress_builder_register_column( 'col_4' );

/**
 * col_5
 */
class col_5 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '5 Column', 'spyropress' ),
            'description' => __( '5 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 5
        );
    }
}
spyropress_builder_register_column( 'col_5' );

/**
 * col_6
 */
class col_6 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '6 Column', 'spyropress' ),
            'description' => __( '6 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 6
        );
    }
}
spyropress_builder_register_column( 'col_6' );

/**
 * col_7
 */
class col_7 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '7 Column', 'spyropress' ),
            'description' => __( '7 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 7
        );
    }
}
spyropress_builder_register_column( 'col_7' );

/**
 * col_8
 */
class col_8 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '8 Column', 'spyropress' ),
            'description' => __( '8 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 8
        );
    }
}
spyropress_builder_register_column( 'col_8' );

/**
 * col_9
 */
class col_9 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '9 Column', 'spyropress' ),
            'description' => __( '9 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 9
        );
    }
}
spyropress_builder_register_column( 'col_9' );

/**
 * col_10
 */
class col_10 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '10 Column', 'spyropress' ),
            'description' => __( '10 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 10
        );
    }
}
spyropress_builder_register_column( 'col_10' );

/**
 * col_11
 */
class col_11 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '11 Column', 'spyropress' ),
            'description' => __( '11 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 11
        );
    }
}
spyropress_builder_register_column( 'col_11' );

/**
 * col_12
 */
class col_12 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '12 Column', 'spyropress' ),
            'description' => __( '12 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 12
        );
    }
}
spyropress_builder_register_column( 'col_12' );

/**
 * col_13
 */
class col_13 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '13 Column', 'spyropress' ),
            'description' => __( '13 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 13
        );
    }
}
spyropress_builder_register_column( 'col_13' );

/**
 * col_14
 */
class col_14 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '14 Column', 'spyropress' ),
            'description' => __( '14 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 14
        );
    }
}
spyropress_builder_register_column( 'col_14' );

/**
 * col_15
 */
class col_15 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '15 Column', 'spyropress' ),
            'description' => __( '15 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 15
        );
    }
}
spyropress_builder_register_column( 'col_15' );

/**
 * col_16
 */
class col_16 extends SpyropressBuilderColumn {

    public function __construct() {

        $this->config = array(
            'name' => __( '16 Column', 'spyropress' ),
            'description' => __( '16 column.', 'spyropress' ),
            'icon' => get_panel_img_path( 'layouts/col_11.png' ),
            'size' => 16
        );
    }
}
spyropress_builder_register_column( 'col_16' );
?>