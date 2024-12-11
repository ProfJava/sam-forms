<?php
/**
 * Plugin Name: SAM Forms
 * Plugin URI: https://github.com/ProfJava/sam-forms
 * Description: A custom WordPress plugin to create forms like login or register or custom form
 * Version: 1.0.2
 * Author: Prof
 * Author URI: https://www.linkedin.com/in/saadfadaly/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: sam-forms
 */

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit();

// Plugin Version
if ( ! defined( 'SAM_FORMS_VERSION' ) )
    define( 'SAM_FORMS_VERSION' , '1.0.2' );

// Constants
define( 'SAM_FORMS_SLUG'    , basename( dirname( __FILE__ ) ) );
define( 'SAM_FORMS_NAME'    , plugin_basename( __FILE__ ) );
define( 'SAM_FORMS_DIR'     , trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'SAM_FORMS_URL'     , trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SAM_FORMS_ASSETS'  , SAM_FORMS_URL . 'assets/' );

use Prof\SamForms\Main;
$sam_autoload_dir = SAM_FORMS_DIR . 'vendor/autoload.php';
if ( file_exists( $sam_autoload_dir ) ) {
    require_once $sam_autoload_dir;
    Main::get_instance()->init();
}
