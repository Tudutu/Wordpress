<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Tudutu_Media_Links
 * @subpackage Tudutu_Media_Links/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tudutu_Media_Links
 * @subpackage Tudutu_Media_Links/public
 * @author     Your Name <email@example.com>
 */
class Tudutu_Media_Links_Public {

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
	 * @param      string    $tudutu_media_links       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $tudutu_media_links, $version ) {

		$this->tudutu_media_links = $tudutu_media_links;
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
		 * defined in Tudutu_Media_Links_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tudutu_Media_Links_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->tudutu_media_links, plugin_dir_url( __FILE__ ) . 'css/tudutu-media-links-public.css', array(), $this->version, 'all' );

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
		 * defined in Tudutu_Media_Links_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tudutu_Media_Links_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->tudutu_media_links, plugin_dir_url( __FILE__ ) . 'js/tudutu-media-links-public.js', array( 'jquery' ), $this->version, false );

	}

	public function media_links_func( $atts ) {
		// $a = shortcode_atts( array(
		// 	'foo' => 'something',
		// 	'bar' => 'something else',
		// ), $atts );
	
		// return "foo = {$a['foo']}";


		$media_links = get_posts(
			array(
			'posts_per_page' => -1,
			'post_type' => 'tudutu_media_link',
			'tax_query' => array(
					array(
						'taxonomy' => 'tudutu_link_group',
						'field' => 'name',
						'terms' => $atts['link-group'],
					)
				)
			)
		);

		$link_group_html = 			'<ul class="tudutu-media-link-group">';
		foreach ($media_links as $media_link) {
			$link_text = $media_link->post_content != "" ? $media_link->post_content : $media_link->post_title;
			$link_group_html .= 		'<li><a class="tudutu-media-link" href="' . $media_link->media_link_url . '">' . $link_text . '</a></li>';
		}
		$link_group_html .= 		'</div>';

		return $link_group_html;
	}

}
