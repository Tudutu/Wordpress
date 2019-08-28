<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Tudutu_Hotel_Rooms
 * @subpackage Tudutu_Hotel_Rooms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tudutu_Hotel_Rooms
 * @subpackage Tudutu_Hotel_Rooms/public
 * @author     Your Name <email@example.com>
 */
class Tudutu_Hotel_Rooms_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $tudutu_hotel_rooms    The ID of this plugin.
	 */
	private $tudutu_hotel_rooms;

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
	 * @param      string    $tudutu_hotel_rooms       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $tudutu_hotel_rooms, $version ) {

		$this->tudutu_hotel_rooms = $tudutu_hotel_rooms;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tudutu_Hotel_Rooms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tudutu_Hotel_Rooms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->tudutu_hotel_rooms, plugin_dir_url( __FILE__ ) . 'css/tudutu-hotel-rooms-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tudutu_Hotel_Rooms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tudutu_Hotel_Rooms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->tudutu_hotel_rooms, plugin_dir_url( __FILE__ ) . 'js/tudutu-hotel-rooms-public.js', array( 'jquery' ), $this->version, false );

	}

	public function render_room_list_shortcode( $atts ) {
		// $a = shortcode_atts( array(
		// 	'foo' => 'something',
		// 	'bar' => 'something else',
		// ), $atts );
	
		// return "foo = {$a['foo']}";


		$rooms = get_posts(
			array(
			'posts_per_page' => -1,
			'post_type' => 'tdt_room_list',
			// 'tax_query' => array(
			// 		array(
			// 			'taxonomy' => 'tudutu_link_group',
			// 			'field' => 'name',
			// 			'terms' => $atts['link-group'],
			// 		)
			// 	)
			)
		);

		$rooms_html = '<ul class="tdt-hotel-rooms">';
		foreach ($rooms as $room) {
			// $link_group_html .= 		'<li><a class="tdt-hotel-room" href="' . $rooms->_post_title . '">' . $rooms->post_title . '</a></li>';
		}
		$rooms_html .= '</div>';

		return $rooms_html;
	}

	public function render_special_offer_blurb_shortcode( $atts ) {
		$special_offer = get_post($atts['id']);

		if ($special_offer->post_type != 'tdt_special_offer') {
			return;
		}
		
		$blurb_html = '<div class="tdt-special-offer-blurb">';
		$blurb_html .= $special_offer->post_content;
		$blurb_html .= '</div>';

		return $blurb_html;
	}

}
