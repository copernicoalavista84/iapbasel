<?php

/**
 * SpyroPress Importer
 *
 * @author 		SpyroSol
 * @category 	Core
 * @package 	Spyropress
 */

class SpyropressImporter {

    public $error;
    protected $file;
    public $importerError = false;

    function __construct( $file ) {
        $this->file = $file;
        $this->includes();
        $this->import_file();
    }

    function includes() {

        if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
            define( 'WP_LOAD_IMPORTERS', true );

        // Load Importer API
        require_once ABSPATH . 'wp-admin/includes/import.php';

        if ( ! class_exists( 'WP_Importer' ) ) {
            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
            if ( file_exists( $class_wp_importer ) )
                require_once $class_wp_importer;
        }
        else {
            $this->importerError = true;
            $this->error = 'Wordpress Importer Class not found.';
        }

        if ( ! class_exists( 'WP_Import' ) ) {
            $class_wp_import = framework_path() . 'classes/wordpress-importer/wordpress-importer.php';
            if ( file_exists( $class_wp_import ) ) {
                require_once $class_wp_import;
            }
            else {
                $this->importerError = true;
                $this->error = 'Wordpress Import Class not found.';
            }
        }
    }

    function import_file() {

        if ( ! $this->importerError ) {
            $wp_import = new WP_Import();
            // Not sure why these wouldn't be loaded
            if ( ! function_exists( 'wp_insert_category' ) ) {
                include ( ABSPATH . 'wp-admin/includes/taxonomy.php' );
            }
            if ( ! function_exists( 'post_exists' ) ) {
                include ( ABSPATH . 'wp-admin/includes/post.php' );
            }
            if ( ! function_exists( 'comment_exists' ) ) {
                include ( ABSPATH . 'wp-admin/includes/comment.php' );
            }

            ob_start();
            $wp_import->fetch_attachments = true;
            $wp_import->import( $this->file );
            ob_end_clean();
        }
    }
}

?>