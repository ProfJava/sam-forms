<?php

namespace Prof\SamForms;

// Exit if accessed directly
if ( ! defined( '\ABSPATH' ) ) exit;

use Prof\SamForms\Email\Email;
use Prof\SamForms\Forms\Login;
use Prof\SamForms\Languages\Localization;

class Main {

    /**
     * @var null singleton
     */
    private static $instance = null;

    /**
     * @var SamForms
     */
    private SamForms $sam_forms;

    /**
     * @var Localization
     */
    private Localization $localization;

    /**
     * @var Assets
     */
    private Assets $assets;

    /**
     * @var Email
     */
    private Email $email;

    /**
     * @var Login
     */
    private Login $login_form;

    /**
     * Get instance
     *
     * @return self|null
     */
    public static function get_instance() {

        if ( self::$instance === null ) {

            self::$instance = new self();

        }

        return self::$instance;

    }

    /**
     * Constructor
     */
    private function __construct() {

        $this->sam_forms    = new SamForms();
        $this->assets       = new Assets();
        $this->email        = new Email();
        $this->login_form   = new Login( $this->email );
        $this->localization = new Localization();

    }

    /**
     * Init
     *
     * @return void
     */
    public function init(): void {

        $this->sam_forms->load_hooks();
        $this->assets->load_hooks();
        $this->email->load_hooks();
        $this->login_form->load_hooks();
        $this->localization->load_hooks();

    }

}