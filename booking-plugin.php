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


add_action( 'personal_options_update', 'save_extra_user_profile_fields_zpr' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields_zpr' );

function save_extra_user_profile_fields_zpr( $user_id ) {
    if(!current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta($user_id, 'number', $_POST["number"]);
}

add_action( 'show_user_profile', 'extra_user_profile_fields_zpr' );
add_action( 'edit_user_profile', 'extra_user_profile_fields_zpr' );

function extra_user_profile_fields_zpr( $user ) { 
    $user_id = $user->ID;
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.js"></script>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
            <td>Number</td>
            <td><input type="text" name="number">
            </td>
        </tr>
		<tr>
            <td>Pictures</td>
            <td><input type="text" name="pictures">
            </td>
        </tr>
    </table>
    <script type="text/javascript">
        $('input').addClass('regular-text');
        $('input[name=number]').val('<?php echo get_the_author_meta('number', $user->ID); ?>');
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

function new_modify_user_table_zpr( $column ) {
    $column['number'] = 'Number';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table_zpr' );

function new_modify_user_table_row_zpr( $val, $column_name, $user_id ) {
    $meta = get_user_meta($user_id);
    switch ($column_name) {
        case 'number' :
            $number = $meta['number'][0];
            return $number;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row_zpr', 10, 3 );







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

   function mpbp_orders_func(){
	   require_once('admin\partials\orders-admin-display.php');
        return 'hello world, this is my first shortcode';
   }	   
   /* register shortcodes */
		add_shortcode(
           'mpbp_orders',
           'mpbp_orders_func'
        );
		
		