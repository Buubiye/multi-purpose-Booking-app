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

/*
*--------------------------------------------------------------------------------------------
* This section will be exported to a different file
*
*/
add_action( 'personal_options_update', 'save_extra_user_profile_fields_qif' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields_qif' );

function save_extra_user_profile_fields_qif( $user_id ) {
    if(!current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta($user_id, 'pictures', $_POST["pictures"]);
    update_user_meta($user_id, 'number', $_POST["number"]);
    update_user_meta($user_id, 'birthdate', $_POST["birthdate"]);
    update_user_meta($user_id, 'distance_moved_today', $_POST["distance_moved_today"]);
    update_user_meta($user_id, 'total_orders', $_POST["total_orders"]);
    update_user_meta($user_id, 'total_distance_moved', $_POST["total_distance_moved"]);
    update_user_meta($user_id, 'services', $_POST["services"]);
}

add_action( 'show_user_profile', 'extra_user_profile_fields_qif' );
add_action( 'edit_user_profile', 'extra_user_profile_fields_qif' );

function extra_user_profile_fields_qif( $user ) { 
    $user_id = $user->ID;
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.js"></script>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
            <td>Pictures</td>
            <td><input type="text" name="pictures">
            </td>
        </tr>
        <tr>
            <td>Number</td>
            <td><input type="text" name="number">
            </td>
        </tr>
        <tr>
            <td>Birthdate</td>
            <td><input type="text" name="birthdate">
            </td>
        </tr>
        <tr>
            <td>Distance Moved Today</td>
            <td><input type="text" name="distance_moved_today">
            </td>
        </tr>
        <tr>
            <td>Total Orders</td>
            <td><input type="text" name="total_orders">
            </td>
        </tr>
        <tr>
            <td>Total Distance Moved</td>
            <td><input type="text" name="total_distance_moved">
            </td>
        </tr>
        <tr>
            <td>Services</td>
            <td><input type="text" name="services">
            </td>
        </tr>
    </table>
    <script type="text/javascript">
        $('input').addClass('regular-text');
        $('input[name=pictures]').val('<?php echo get_the_author_meta('pictures', $user->ID); ?>');
        $('input[name=number]').val('<?php echo get_the_author_meta('number', $user->ID); ?>');
        $('input[name=birthdate]').val('<?php echo get_the_author_meta('birthdate', $user->ID); ?>');
        $('input[name=distance_moved_today]').val('<?php echo get_the_author_meta('distance_moved_today', $user->ID); ?>');
        $('input[name=total_orders]').val('<?php echo get_the_author_meta('total_orders', $user->ID); ?>');
        $('input[name=total_distance_moved]').val('<?php echo get_the_author_meta('total_distance_moved', $user->ID); ?>');
        $('input[name=services]').val('<?php echo get_the_author_meta('services', $user->ID); ?>');
        // Hide some default options //
            /*
            $('.user-url-wrap').hide();
            $('.user-description-wrap').hide();
            $('.user-profile-picture').hide();
            $('.user-rich-editing-wrap').hide();
            $('.user-admin-color-wrap').hide();
            $('.user-comment-shortcuts-wrap').hide();
            $('.show-admin-bar').hide();
            $('.user-language-wrap').hide();
            //*/
    </script>
<?php 
}

function new_modify_user_table_qif( $column ) {
    $column['number'] = 'Number';
    $column['birthdate'] = 'Birthdate';
    $column['total_orders'] = 'Total Orders';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table_qif' );

function new_modify_user_table_row_qif( $val, $column_name, $user_id ) {
    $meta = get_user_meta($user_id);
    switch ($column_name) {
        case 'pictures' :
            $pictures = $meta['pictures'][0];
            return $pictures;
        case 'number' :
            $number = $meta['number'][0];
            return $number;
        case 'birthdate' :
            $birthdate = $meta['birthdate'][0];
            return $birthdate;
        case 'distance_moved_today' :
            $distance_moved_today = $meta['distance_moved_today'][0];
            return $distance_moved_today;
        case 'total_orders' :
            $total_orders = $meta['total_orders'][0];
            return $total_orders;
        case 'total_distance_moved' :
            $total_distance_moved = $meta['total_distance_moved'][0];
            return $total_distance_moved;
        case 'services' :
            $services = $meta['services'][0];
            return $services;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row_qif', 10, 3 );

/*
* -------------------------------------------------------------------------------------
*/





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
require_once('includes\class-booking-plugin-activator.php');
register_activation_hook( __FILE__, 'create_mpbp_services_db_table' );

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
			require_once('includes\class-booking-plugin-activator.php');
			register_activation_hook( __FILE__, 'create_mpbp_services_db_table' );
        }

        public function admin_menu() {
            $menu_title = 'Multi-Purpose-Booking';  // The title of your menu entry
			$menu_subTitles = ['Services', 'orders', 'all_users', 'all_service_providers', 'settings', 'all_services', 'orders_crud', 'users', 'service_provider' ];
            $menu_slug  = 'my_table2';   
			$sum_menu_1_slugs = ['Services', 'orders', 'all_users', 'all_service_providers', 'settings', 'all_services', 'orders_crud', 'users', 'service_provider' ];
			// The slug, for example: wp-admin/admin.php?page=my_table
            add_menu_page($menu_title, $menu_title, 'manage_options', $menu_slug, array($this, 'admin_page'));
			add_submenu_page($menu_slug, $menu_subTitles[0], $menu_subTitles[0], 'manage_options', $menu_subTitles[0], array($this, 'services_page'));
			add_submenu_page($menu_slug, $menu_subTitles[1], $menu_subTitles[1], 'manage_options', $menu_subTitles[1], array($this, 'all_orders_page'));
			add_submenu_page($menu_slug, $menu_subTitles[2], $menu_subTitles[2], 'manage_options', $menu_subTitles[2], array($this, 'users_page'));
			add_submenu_page($menu_slug, $menu_subTitles[3], $menu_subTitles[3], 'manage_options', $menu_subTitles[3], array($this, 'service_providers_page'));
			add_submenu_page($menu_slug, $menu_subTitles[4], $menu_subTitles[4], 'manage_options', $menu_subTitles[4], array($this, 'settings_page'));
            //hidden submenus
			add_submenu_page($menu_slug, $menu_subTitles[5], $menu_subTitles[5], 'manage_options', $menu_subTitles[5], array($this, 'all_services_page'));
			add_submenu_page($menu_slug, $menu_subTitles[6], $menu_subTitles[6], 'manage_options', $menu_subTitles[6], array($this, 'orders_crud_page'));
			add_submenu_page($menu_slug, $menu_subTitles[7], $menu_subTitles[7], 'manage_options', $menu_subTitles[7], array($this, 'users_crud_page'));
			add_submenu_page($menu_slug, $menu_subTitles[8], $menu_subTitles[8], 'manage_options', $menu_subTitles[8], array($this, 'service_providers_crud_page'));
		}
		
		public function admin_page() {
		   require_once('admin\partials\booking-plugin-admin-display.php');
		}
		public function services_page(){
			require_once('admin\partials\services-admin-display.php');
		}
		public function all_services_page(){
			require_once('admin\partials\all_services_page.php');
		}
		public function all_orders_page(){
			require_once('admin\partials\all_order_page.php');
		}
		public function orders_crud_page(){
			require_once('admin\partials\orders-admin-display.php');
		}
		public function users_page(){
			require_once('admin\partials\users-admin-display.php');
		}
		public function users_crud_page(){
			require_once('admin\partials\users-admin-crud.php');
		}
		public function service_providers_page(){
			require_once('admin\partials\service-providers-admin-display.php');
		}
		public function service_providers_crud_page(){
			require_once('admin\partials\service-providers-admin-crud.php');
		}
		public function settings_page(){
			require_once('admin\partials\settings-admin-display.php');
		}
    }

    new My_Table2();


/*
*--------------------------------------------------------------------
* this section works on shortcodes and it will be exported to a different file
*/
   function mpbp_orders_func(){
	   require_once('admin\partials\orders-admin-display.php');
        return 'hello world, this is my first shortcode';
   }  
   
   //add a service shortcode
   function mpbp_services_shortcode( $atts = [], $content = null, $tags = '' ){
	   $s = shortcode_atts(array(
	   'id' => '',
	   'number'=> '',
	   'category' => ''
	   ), $atts );
	   
	  /* //extract the ids from the services from dbtable
	   global $wpdb;
	   $ids = 'WHERE id IN ('. trim(json_encode($s['id']), '[]') .')' | "";
	   $get_data = $wpdb->get_results('SELECT * FROM wp_mpbpservices2'. $ids;
	   
	   //create a loop which prints out the services in a gallery form
	   $mpbp_number_of_products = sizeof($get_data) | 10;
	   for($i = 0; $i < $mpbp_number_of_products; $i++){
		   echo '<div style="float: left">
		         
		   ';
		   
	   }*/
	   require_once plugin_dir_path(dirname(__FILE__)).'multi-purpose-Booking-app\admin\class-booking-plugin-listings.php';
$mpbp_service_listing = new mpbp_data_listing();
  $mpbp_service_listing->mpbp_db_table =  'wp_mpbpservices2';
  $mpbp_service_listing->mpbp_services_results_per_page = 5;
  $mpbp_service_listing->mpbp_listing_title = '<h1>Services</h1>';
  $mpbp_service_listing->mpbp_listing_button = 'Add New';
  $mpbp_service_listing->mpbp_listing_button_url = '/index.php/sample-page/?';
  $mpbp_service_listing->mpbp_items = 'Services';
  $mpbp_service_listing->mpbp_page_name = 'all_services';
  $mpbp_service_listing->mpbp_listing_url = '/wp-admin/admin.php?page=all_services&order=';
  $mpbp_service_listing->mpbp_listing_td = ["pictures", "name", "category", "quantity", "status"];
  $mpbp_service_listing->mpbp_listing_td_data;
  $mpbp_service_listing->mpbp_search_columns = ["id", "name"];
  /*
  *
  */
  $mpbp_service_listing->mpbp_listing_th = ["", "Pictures", "Name", "Category", "Quantity", "Status"];
  $mpbp_service_listing->mpbp_listing_th_data = ['<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>'];
   
  return $mpbp_service_listing->mpbp_render_listing(); 

   }
   
   /* register shortcodes */
   function add_mpbp_shorcodes(){
	    add_shortcode( 'services', 'mpbp_services_shortcode' );
		add_shortcode('mpbp_orders', 'mpbp_orders_func');
   }
   add_action('init', 'add_mpbp_shorcodes');
	


