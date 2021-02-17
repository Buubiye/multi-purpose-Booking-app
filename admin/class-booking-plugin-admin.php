<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       Ahmed-Buubiye
 * @since      1.0.0
 *
 * @package    Booking_Plugin
 * @subpackage Booking_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Booking_Plugin
 * @subpackage Booking_Plugin/admin
 * @author     Ahmed Buubiye <hodansan100@gmail.com>
 */
class Booking_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Booking_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Booking_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/booking-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Booking_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Booking_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/booking-plugin-admin.js', array( 'jquery' ), $this->version, false );
        /*
		* scripts for media widget
		*/
		wp_enqueue_script('media-upload');
		wp_enqueue_media();
		
		/*
		* enqueue jqeury ui and jquery-ui date picker
		*/
		 wp_enqueue_script('jquery-ui-datepicker');
		 wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
		 wp_enqueue_style('jquery-ui');
	}
}

//require_once plugin_dir_path(dirname( __FILE__ ) ) . 'admin\validators\service-form-validation.php';
