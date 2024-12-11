<?php

namespace Prof\SamForms;

// Exit if accessed directly
if ( ! defined( '\ABSPATH' ) ) exit;

class Assets {


    /**
     * Load hooks
     *
     * @return void
     */
    public function load_hooks(): void
    {

        add_action( 'wp_enqueue_scripts', [ $this, 'load_plugin_scripts' ] );
//        add_action( 'admin_enqueue_scripts', [ $this, 'load_admin_scripts' ] );

    }


    /**
     * Load scripts
     *
     * @return void
     */
    public function load_plugin_scripts(): void
    {

        // Additional Scripts
        wp_enqueue_style(
            'sam-toast-style',
            '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css',
            false,
            SAM_FORMS_VERSION
        );

        wp_enqueue_script(
            'sam-toast-script',
            '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js',
            array( 'jquery' ),
            SAM_FORMS_VERSION,
            false
        );

        // Main Scripts
        wp_enqueue_style(
            'sam-forms-style',
            SAM_FORMS_ASSETS . 'css/style.css',
            false,
            SAM_FORMS_VERSION
        );

        wp_enqueue_script(
            'sam-forms-scripts',
            SAM_FORMS_ASSETS . 'js/scripts.js',
            array('jquery'),
            SAM_FORMS_VERSION,
            true
        );

        wp_localize_script(
            'sam-forms-scripts',
            'sam_forms_ajax_object',
            [
                'ajax_url'    => admin_url( 'admin-ajax.php' ),
                'ajax_nonce'  => wp_create_nonce( 'sam_forms_ajax' ),
            ]
        );

    }


    /**
     * Load admin scripts
     *
     * @return void
     */
    public function load_admin_scripts(): void
    {



    }

}