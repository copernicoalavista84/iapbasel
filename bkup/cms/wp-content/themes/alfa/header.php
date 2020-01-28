<?php
/*
 * Core Spyropress header template
 *
 * Customise this in your child theme by:
 * - Using hooks and your own functions
 * - Using the 'header-content' template part
 * - For example 'header-content-category.php' for category view or 'header-content.php' (fallback if location specific file not available)
 * - Copying this file to your child theme and customising - it will over-ride this file
 *
 * @package Spyropress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'layout-' . get_setting( 'h_type', 'image' ) ); ?>>
<?php spyropress_wrapper(); ?>
    <?php spyropress_before_header(); ?>
    <!-- header -->
     <header id="header">
     <?php
        spyropress_before_header_content();
        spyropress_get_template_part('part=templates/header-content');
        spyropress_after_header_content();
     ?>
     </header>
     <!-- /header -->
    <?php spyropress_after_header(); ?>