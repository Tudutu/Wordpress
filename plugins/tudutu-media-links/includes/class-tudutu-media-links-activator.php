<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Tudutu_Media_Links
 * @subpackage Tudutu_Media_Links/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tudutu_Media_Links
 * @subpackage Tudutu_Media_Links/includes
 * @author     Your Name <email@example.com>
 */
class Tudutu_Media_Links_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Generated a CPT

		// Flush rewrite rules
		flush_rewrite_rules();
	}

}
