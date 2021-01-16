<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Ahmed-C.Buubiye
 * @since             1.0.0
 * @package           Booking_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Multi Purpose Booking Plugin
 * Plugin URI:        Multi-Purpose-Booking-Plugin
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ahmed C.Buubiye
 * Author URI:        Ahmed-C.Buubiye
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       booking-plugin
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
define( 'BOOKING_PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-booking-plugin-activator.php
 */
function activate_booking_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-booking-plugin-activator.php';
	Booking_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-booking-plugin-deactivator.php
 */
function deactivate_booking_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-booking-plugin-deactivator.php';
	Booking_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_booking_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_booking_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-booking-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_booking_plugin() {

	$plugin = new Booking_Plugin();
	$plugin->run();

}
run_booking_plugin();


class My_Table2 {
	

        /*
            Add an menu entry in the Administration. Fore more information see: http://codex.wordpress.org/Administration_Menus
        */
        public function __construct() {
            add_action('admin_menu',    array($this, 'admin_menu'));
			add_action('admin_menu', array($this, 'settings_page'));
        }

        public function admin_menu() {
            $menu_title = 'Multi-Purpose-Booking';  // The title of your menu entry
			$menu_subTitle_1 = 'settings';
            $menu_slug  = 'my_table2';   
			$sum_menu_1_slug = 'settings';
			// The slug, for example: wp-admin/admin.php?page=my_table
            add_menu_page($menu_title, $menu_title, 'manage_options', $menu_slug, array($this, 'admin_page'));
			add_submenu_page($menu_slug, $menu_subTitle_1, $menu_subTitle_1, 'manage_options', array($this, 'settings_page'));
        }
		public function admin_page() {
		   require_once('admin\partials\booking-plugin-admin-display.php');
		}
		public function settings_page(){
			require_once('admin\index.php');
		}
    }

    new My_Table2();
