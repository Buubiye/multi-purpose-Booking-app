<?php

/**
 * Fired during plugin activation
 *
 * @link       Ahmed-Buubiye
 * @since      1.0.0
 *
 * @package    Booking_Plugin
 * @subpackage Booking_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Booking_Plugin
 * @subpackage Booking_Plugin/includes
 * @author     Ahmed Buubiye <hodansan100@gmail.com>
 */
class Booking_Plugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		function create_plugin_database_table1(){
			global $wpdb;
			$tableName = 'mpbp_services';
			$wpdb_track_table1 = $wpdb->prefix . "$tableName";
			
			$sql = 'CREATE TABLE $wpdb_track_table1 (';
			$sql .= '`id` = int(11) NOT NULL AUTO_INCREMENT,';
			$sql .= '`name` = VARCHAR(128) NOT NULL,';
			$sql .= '`description` = VARCHAR(50000),';
			$sql .= '`pictures` = VARCHAR(2000),';
			$sql .= '`price` = VARCHAR(255),';
			$sql .= '`date-created` = VARCHAR(255),';
			$sql .= '`category` = VARCHAR(255),';
			$sql .= '`available-times` = VARCHAR(255),';
			$sql .= '`quantity` = VARCHAR(255),';
			$sql .= '`status` = VARCHAR(255),';
			$sql .= '`extra-info` = VARCHAR(255),';
			$sql .= 'PRIMARY KEY `order_id` (`id`) ';
			$sql .= ') ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1; ';
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			dbDelta($sql);
		}
        register_activation_hook( __FILE__, 'create_plugin_database_table1' );;
	}

}

new Booking_Plugin_Activator();
