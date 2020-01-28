<?php

if( is_single() ) return;

$h_type = get_setting( 'h_type' );
$h_img = $h_slider = '';
if( 'image' == $h_type ) {
    $h_img = ' style="background-image:url(' . get_setting( 'h_image' ) . ');"';
}
elseif( 'slider' == $h_type ) {
    $slides = get_setting_array( 'h_slider' );
    
    if( !empty( $slides ) ) {
        
        $h_slider = '
        <a href="" id="arrow_left"><img src="' . assets_img() . 'arrow_left.png" alt="Slide Left" /></a>
        <a href="" id="arrow_right"><img src="' . assets_img() . 'arrow_right.png" alt="Slide Right" /></a>
        <div id="maximage">';
        
        foreach( $slides as $slide ) {
            $h_slider .= '<img src="' . $slide['img'] . '" alt=""/>';
        }
        
        $h_slider .= '</div>';
    }
}
?>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<div id="home"<?php echo $h_img; ?>>
    <?php
        spyropress_logo( array(
            'tag' => 'div',
            'id' => 'logo-big',
            'class' => 'logo-big'
        ) );
    ?>
    <div class="text-home">
    <?php
        if( $teaser1 = get_setting( 'h_teaser_1' ) ) echo "<p>$teaser1</p>";
        if( $teaser2 = get_setting( 'h_teaser_2' ) ) echo "<h5>$teaser2</h5>";
    ?>
    </div>
    <?php if( !get_setting( 'disable_arrow' ) ) { ?>
    <div id="arrow">
        <a href="#about" class="scroll next-section"><img alt='arrow' src='<?php echo assets_img() ?>arrow-down.png'></a>
    </div>
    <?php } ?>
    <?php echo $h_slider; ?>
</div>
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