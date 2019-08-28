<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Tudutu_Media_Links
 * @subpackage Tudutu_Media_Links/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Tudutu_Media_Links
 * @subpackage Tudutu_Media_Links/includes
 * @author     Your Name <email@example.com>
 */
class Tudutu_Media_Links_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		// Flush rewrite rules
		flush_rewrite_rules();
	}

}
