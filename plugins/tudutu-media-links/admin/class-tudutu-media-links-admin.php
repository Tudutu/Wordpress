<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Tudutu_Media_Links
 * @subpackage Tudutu_Media_Links/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tudutu_Media_Links
 * @subpackage Tudutu_Media_Links/admin
 * @author     Your Name <email@example.com>
 */
class Tudutu_Media_Links_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $tudutu_media_links    The ID of this plugin.
	 */
	private $tudutu_media_links;

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
	 * @param      string    $tudutu_media_links       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $tudutu_media_links, $version ) {

		$this->tudutu_media_links = $tudutu_media_links;
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
		 * defined in Tudutu_Media_Links_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tudutu_Media_Links_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->tudutu_media_links, plugin_dir_url( __FILE__ ) . 'css/tudutu-media-links-admin.css', array(), $this->version, 'all' );

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
		 * defined in Tudutu_Media_Links_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tudutu_Media_Links_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->tudutu_media_links, plugin_dir_url( __FILE__ ) . 'js/tudutu-media-links-admin.js', array( 'jquery' ), $this->version, false );

	}

}
