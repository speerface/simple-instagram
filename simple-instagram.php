<?php
/**
 * simple-instagram
 *
 * A plugin to allow users to include InstaGram feeds, media, and information. 
 * 
 *
 * @package   Simple Instagram
 * @author    Aaron Speer <adspeer@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Aaron Speer
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Instagram
 * Plugin URI:        @TODO
 * Description:       A plugin to allow users to include InstaGram feeds, media, and information.
 * Version:           1.0.0
 * Author:            Aaron Speer
 * Author URI:        aaronspeer.com
 * Text Domain:       simple-instagram
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/simple-instagram.php' );

//Get Shortcodes file
require_once( plugin_dir_path( __FILE__ ) . 'includes/simple-instagram-shortcodes.php' );

//Get Widget File
require_once( plugin_dir_path( __FILE__ ) . 'includes/simple-instagram-widgets.php' );


/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
register_activation_hook( __FILE__, array( 'simpleInstagram', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'simpleInstagram', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
add_action( 'plugins_loaded', array( 'simpleInstagram', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-admin.php` with the name of the plugin's admin file
 * - replace Plugin_Name_Admin with the name of the class defined in
 *   `class-plugin-name-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/simple-instagram-admin.php' );
	add_action( 'plugins_loaded', array( 'simpleInstagram_admin', 'get_instance' ) );

}
