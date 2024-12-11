<?php

namespace Prof\SamForms;

// Exit if accessed directly
if ( ! defined( '\ABSPATH' ) ) exit;

class Helpers {

    public static function get_template_part( $folder_path = '', $name = '', $args = array(), $return_results = false ) {

        if ( ! empty( $args ) && is_array( $args ) ) {
            // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
            extract( $args );
        }

        $folder_path = ! empty( $folder_path ) ? "/$folder_path/" : '';

        $template = '';

        // Look in yourtheme/sam-forms/folder-path/name.php and yourtheme/sam-forms/folder-path/name.php.
        if ( $name ) {
            $template = locate_template( array( "sam-forms{$folder_path}{$name}.php" ) );
        }

        // Get default.
        if ( ! $template && $name ) {

            // Try to get it from the PRO dir if it exists.
            if ( file_exists( SAM_FORMS_DIR . "templates{$folder_path}{$name}.php" ) ) {
                $template = SAM_FORMS_DIR . "templates{$folder_path}{$name}.php";
            }

        }

        /**
         * Hook: 'get_template_part'
         *
         * @since 1.0
         */
        $template = apply_filters( 'sam_get_template_part' , $template, $folder_path, $name );


        if ( $template ) {

            // Whether to return template HTML as string or to echo it
            if ( $return_results ) {

                ob_start();

                include( $template );

                return ob_get_clean();

            }

            return include( $template );

        }

    }
    
}