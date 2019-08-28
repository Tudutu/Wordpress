<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Tudutu_Hotel_Rooms
 *
 * @wordpress-plugin
 * Plugin Name:       Tudutu Hotel Rooms
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Tudutu Ltd
 * Author URI:        https://tudutu.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tudutu-hotel-rooms
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TUDUTU_HOTEL_ROOMS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tudutu-hotel-rooms-activator.php
 */
function activate_tudutu_hotel_rooms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tudutu-hotel-rooms-activator.php';
	Tudutu_Hotel_Rooms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tudutu-hotel-rooms-deactivator.php
 */
function deactivate_tudutu_hotel_rooms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tudutu-hotel-rooms-deactivator.php';
	Tudutu_Hotel_Rooms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tudutu_hotel_rooms' );
register_deactivation_hook( __FILE__, 'deactivate_tudutu_hotel_rooms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tudutu-hotel-rooms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tudutu_hotel_rooms() {

	$plugin = new Tudutu_Hotel_Rooms();
	$plugin->run();

}
run_tudutu_hotel_rooms();
