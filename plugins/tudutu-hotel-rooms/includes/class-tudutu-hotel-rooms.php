<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Tudutu_Hotel_Rooms
 * @subpackage Tudutu_Hotel_Rooms/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tudutu_Hotel_Rooms
 * @subpackage Tudutu_Hotel_Rooms/includes
 * @author     Your Name <email@example.com>
 */
class Tudutu_Hotel_Rooms {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tudutu_Hotel_Rooms_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $tudutu_hotel_rooms    The string used to uniquely identify this plugin.
	 */
	protected $tudutu_hotel_rooms;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TUDUTU_HOTEL_ROOMS_VERSION' ) ) {
			$this->version = TUDUTU_HOTEL_ROOMS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->tudutu_hotel_rooms = 'tudutu-hotel-rooms';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_common_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tudutu_Hotel_Rooms_Loader. Orchestrates the hooks of the plugin.
	 * - Tudutu_Hotel_Rooms_i18n. Defines internationalization functionality.
	 * - Tudutu_Hotel_Rooms_Admin. Defines all hooks for the admin area.
	 * - Tudutu_Hotel_Rooms_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tudutu-hotel-rooms-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tudutu-hotel-rooms-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tudutu-hotel-rooms-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tudutu-hotel-rooms-public.php';

		/**
		 * The class responsible for managing the registration of custom post types.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tudutu-hotel-rooms-cpt-manager.php';
		

		$this->loader = new Tudutu_Hotel_Rooms_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tudutu_Hotel_Rooms_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tudutu_Hotel_Rooms_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Tudutu_Hotel_Rooms_Admin( $this->get_tudutu_hotel_rooms(), $this->get_version() );
		$cpt_manager = new Tudutu_Hotel_Rooms_Cpt_Manager();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'save_post', $cpt_manager, 'save_hotel_rooms_meta', 10, 2 );
		$this->loader->add_action( 'save_post', $cpt_manager, 'save_special_offers_meta', 10, 2 );
		$this->loader->add_action( 'manage_tdt_special_offer_posts_custom_column', $cpt_manager, 'special_offers_column', 10, 2 );
		$this->loader->add_filter( 'manage_tdt_special_offer_posts_columns', $cpt_manager, 'special_offers_columns', 10, 2 );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Tudutu_Hotel_Rooms_Public( $this->get_tudutu_hotel_rooms(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_shortcode( 'tdt-special-offer', $plugin_public, 'render_special_offer_blurb_shortcode' );
	}

	/**
	 * Register all of the hooks related to both admin and public area
	 * functionality of the plugin.
	 * 
	 * @since		1.0.0
	 * @access	private
	 */
	private function define_common_hooks() {
		$cpt_manager = new Tudutu_Hotel_Rooms_Cpt_Manager();

		$this->loader->add_action('init', $cpt_manager, 'register_custom_taxonomies', 0);
		$this->loader->add_action( 'init', $cpt_manager, 'register_custom_post_types' );
		$this->loader->add_action('add_meta_boxes', $cpt_manager, 'add_hotel_rooms_meta_boxes' );
		$this->loader->add_action('add_meta_boxes', $cpt_manager, 'add_special_offers_meta_boxes' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_tudutu_hotel_rooms() {
		return $this->tudutu_hotel_rooms;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tudutu_Hotel_Rooms_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
