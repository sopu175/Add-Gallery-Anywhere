<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sopu.me/
 * @since             1.0.0
 * @package           Add_Gallery_Anywhere
 *
 * @wordpress-plugin
 * Plugin Name:       Add Gallery Anywhere
 * Plugin URI:        https://sopu.me/
 * Description:       This plugin contains dynamic gallery with lightgallery, you can add multiple gallery any page or post using shortcode
 * Version:           1.0.0
 * Author:            Saif Islam
 * Author URI:        https://sopu.me/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       add-gallery-anywhere
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'ADD_GALLERY_ANYWHERE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_add_gallery_anywhere() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-add-gallery-anywhere-activator.php';
	Add_Gallery_Anywhere_Activator::activate();
}





/**
 * The code that runs during plugin deactivation.
 */
function deactivate_add_gallery_anywhere() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-add-gallery-anywhere-deactivator.php';
	Add_Gallery_Anywhere_Deactivator::deactivate();
}




register_activation_hook( __FILE__, 'activate_add_gallery_anywhere' );
register_deactivation_hook( __FILE__, 'deactivate_add_gallery_anywhere' );








/**
 * The core plugin class that is used to define internationalization,
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-add-gallery-anywhere.php';







/**
 * Begins execution of the plugin.
 */
function run_add_gallery_anywhere() {

	$plugin = new Add_Gallery_Anywhere();
	$plugin->run();



}
run_add_gallery_anywhere();
