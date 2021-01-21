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
		
		global $mpbp_service_db_version;
		$mpbp_service_db_version = '1.0';

		function create_mpbp_services_db_table() {
			global $wpdb;
			global $mpbp_service_db_version;

			$table_name = $wpdb->prefix . 'mpbpServices__10';
			
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
				id int(11) NOT NULL AUTO_INCREMENT,
							name varchar(128) NOT NULL,
							description varchar(50000),
							pictures varchar(2000),
							price varchar(255),
							date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
							category varchar(255),
							available_times varchar(255),
							quantity varchar(255),
							status varchar(255),
							extra_info varchar(255),
							PRIMARY KEY (id)					
							) $charset_collate; ";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			add_option( 'mpbp_service_db_version', $mpbp_service_db_version );
		}
		
	}
}

new Booking_Plugin_Activator();
