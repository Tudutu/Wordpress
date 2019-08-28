<?php

class Tudutu_Media_Links_Cpt_Manager {
  
  public function register_post_type_media_link() {

		$labels = array(
			'name'               => __( 'Media Links' ),
			'singular_name'      => __( 'Media Link' ),
			'add_new_item'			 => __('Add New Media Link'),
			'edit_item'					 => __('Edit Media Link'),
			'new_item'					 => __('New Media Link'),
			'view_item'					 => __('View Media Link'),
			'search_items'			 => __('Search Media Links'),
			'not_found'					 => __('No Media Links Found'),
			'not_found_in_trash' => __('No media links found in Trash'),
			'all_items'					 => __('All Media Links'),
		);

		$supports = array(
			'title',
			'editor',
			'revisions',
		);

		$args = array(
			'labels'               => $labels,
			'supports'             => $supports,
			'public'               => true,
			'has_archive'          => true,
			'taxonomies'					 => ['tudutu_link_group'],
			'menu_position'        => 30,
			'menu_icon'            => 'dashicons-admin-links',
		);

		register_post_type( 'tudutu_media_link', $args );

	}
	
	/**
	 * Register our new custom taxonomies
	 */
	function add_custom_taxonomies() {
		// Add new Link Group taxonomy to Media Links 
		register_taxonomy('tudutu_link_group', 'tudutu_media_link', array(
			// This array of options controls the labels displayed in the WordPress Admin UI
			'labels' => array(
				'name' => _x( 'Link Groups', 'taxonomy general name' ),
				'singular_name' => _x( 'Link Group', 'taxonomy singular name' ),
				'search_items' =>  __( 'Search Link Groups' ),
				'all_items' => __( 'All Link Groups' ),
				'parent_item' => __( 'Parent Link Group' ),
				'parent_item_colon' => __( 'Parent Link Group:' ),
				'edit_item' => __( 'Edit Link Group' ),
				'update_item' => __( 'Update Link Group' ),
				'add_new_item' => __( 'Add New Link Group' ),
				'new_item_name' => __( 'New Link Group Name' ),
				'menu_name' => __( 'Link Groups' ),
			),
			'meta_box_cb' => 'post_categories_meta_box'
		));
	}

	public function add_media_links_meta_boxes() {
		
		// Add metabox for the url
		add_meta_box( 
			'tudutu_media_link_url',
			'Media Link URL',
			function( $p ) {
				$this->media_links_url_callback( $p );
			},
			'tudutu_media_link'
		);
	}

	/**
	 * Output the HTML for the url metabox.
	 */
	public function media_links_url_callback( $post ) {

		// Nonce field to validate form request came from current site
		wp_nonce_field( basename( __FILE__ ), 'media_link_fields' );

		// Get the url data if it's already been entered
		$url = get_post_meta( $post->ID, 'media_link_url', true );
		
		// Output the field
		echo '<input type="text" style=" width: 100%" name="media_link_url" value="' . esc_textarea( $url )  . '" >';
	}

	/**
	 * Save the url metabox data
	 */
	public function save_media_links_meta( $post_id, $post ) {

		// Return if the user doesn't have edit permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times.
		if ( ! isset( $_POST['media_link_url'] ) || ! wp_verify_nonce( $_POST['media_link_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Now that we're authenticated, time to save the data.
		// This sanitizes the data from the field and saves it into an array $media_link_meta.
		$media_link_meta['media_link_url'] = esc_textarea( $_POST['media_link_url'] );

		// Cycle through the $events_meta array.
		// Note, in this example we just have one item, but this is helpful if you have multiple.
		foreach ( $media_link_meta as $key => $value ) {

			// Don't store custom data twice
			if ( 'revision' === $post->post_type ) {
				return;
			}
			if ( get_post_meta( $post_id, $key, false ) ) {
				// If the custom field already has a value, update it.
				update_post_meta( $post_id, $key, $value );
			} else {
				// If the custom field doesn't have a value, add it.
				add_post_meta( $post_id, $key, $value);
			}
			if ( ! $value ) {
				// Delete the meta key if there's no value
				delete_post_meta( $post_id, $key );
			}
		}
	}

	/**
		* Specify which columns to display on All Media Links page
		*/
	public function media_links_columns ( $columns ) {

		$columns = array(
      'cb' => $columns['cb'],
      'title' => __( 'Title' ),
      'media_link_url' => __( 'URL'),
		);
		
		return $columns;
	}

	/**
	 *	Add the content into the custom columns on All Media Links page
	 */
	public function media_links_column ( $column, $post_id ) {
		
		// url column
		if ( 'media_link_url' === $column ) {
			echo get_post_meta( $post_id, 'media_link_url', true );
		}
	}

}