<nav id="navigation">
    <?php
    if( $logo = get_setting( 'menu_logo' ) ) {
        echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img class="logo" alt="logo" src="' . $logo . '"></a>';
    }
    ?>
    <?php
        $menu = spyropress_get_nav_menu(
            'primary', array(
                'menu_id' => 'menu',
                'container' => false,
                'echo' => false
            )
        );
        $url = is_front_page() ? '#' : home_url('/#');
        echo str_replace( '#HOME_URL#', $url, $menu );
    ?>
</nav>