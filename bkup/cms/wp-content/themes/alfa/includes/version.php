<?php

/**
 * Theme Meta Info for internal usage
 *
 * Dont Mess with it.
 */
add_action('spyropress_init', 'spyropress_setup_theme');
function spyropress_setup_theme() {
    global $spyropress;
    
    $spyropress->internal_name = 'alfa';
    $spyropress->theme_name = 'Alfa';
    $spyropress->theme_version = '1.3';
    
    $spyropress->row_class = 'container';
}
?>