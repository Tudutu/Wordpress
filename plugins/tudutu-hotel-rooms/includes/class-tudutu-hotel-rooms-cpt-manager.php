<?php

class Tudutu_Hotel_Rooms_Cpt_Manager {

  public function register_custom_post_types() {

    $this->register_post_type_hotel_room();
    $this->register_post_type_special_offer();   
  }

  private function register_post_type_hotel_room() {
    $labels = array(
			'name'               => __( 'Rooms' ),
			'singular_name'      => __( 'Room' ),
			'add_new_item'			 => __('Add New Room'),
			'edit_item'					 => __('Edit Room'),
			'new_item'					 => __('New Room'),
			'view_item'					 => __('View Room'),
			'search_items'			 => __('Search Rooms'),
			'not_found'					 => __('No Rooms Found'),
			'not_found_in_trash' => __('No rooms found in Trash'),
			'all_items'					 => __('All Rooms'),
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
      'taxonomies'					 => ['tdt_hotel_rooms_price', 'tdt_hotel_rooms_category'],
			'menu_position'        => 30,
			'menu_icon'            => 'dashicons-building',
		);

		register_post_type( 'tdt_hotel_room', $args );
  }

  private function register_post_type_special_offer() {
    $labels = array(
			'name'               => __( 'Special Offer' ),
			'singular_name'      => __( 'Special Offer' ),
			'add_new_item'			 => __('Add New Special Offer'),
			'edit_item'					 => __('Edit Special Offer'),
			'new_item'					 => __('New Special Offer'),
			'view_item'					 => __('View Special Offer'),
			'search_items'			 => __('Search Special Offers'),
			'not_found'					 => __('No Special Offers Found'),
			'not_found_in_trash' => __('No special offers found in Trash'),
			'all_items'					 => __('All Special Offers'),
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
      'show_in_menu'         => 'edit.php?post_type=tdt_hotel_room',
		);

		register_post_type( 'tdt_special_offer', $args );
  }

  public function register_custom_taxonomies() {

    // Add new unit taxonomy to Tdt_Hotel_Room 
		register_taxonomy('tdt_hotel_rooms_price', 'tdt_hotel_room', array(
			// This array of options controls the labels displayed in the WordPress Admin UI
			'labels' => array(
				'name' => _x( 'Units', 'taxonomy general name' ),
				'singular_name' => _x( 'Unit', 'taxonomy singular name' ),
				'search_items' =>  __( 'Search Units' ),
				'all_items' => __( 'All Units' ),
				'edit_item' => __( 'Edit Unit' ),
				'update_item' => __( 'Update Unit' ),
				'add_new_item' => __( 'Add New Unit' ),
				'new_item_name' => __( 'New Unit' ),
        'menu_name' => __( 'Units' ),
        'choose_from_most_used' => __('Choose from most used units'),
      ),
      'meta_box_cb' => 'post_categories_meta_box'
    ));
    
    // Add new room category taxonomy to Tdt_Hotel_Room 
		register_taxonomy('tdt_hotel_rooms_category', 'tdt_hotel_room', array(
			// This array of options controls the labels displayed in the WordPress Admin UI
			'labels' => array(
				'name' => _x( 'Categories', 'taxonomy general name' ),
				'singular_name' => _x( 'Category', 'taxonomy singular name' ),
				'search_items' =>  __( 'Search Categories' ),
				'all_items' => __( 'All Categories' ),
				'edit_item' => __( 'Edit Category' ),
				'update_item' => __( 'Update Category' ),
				'add_new_item' => __( 'Add New Category' ),
				'new_item_name' => __( 'New Category' ),
        'menu_name' => __( 'Categories' ),
        'choose_from_most_used' => __('Choose from most used categories'),
      ),
      'meta_box_cb' => 'post_categories_meta_box'
		));
  }

  public function add_hotel_rooms_meta_boxes() {
    // Add metabox for special offer
		add_meta_box( 
			'tdt_hotel_rooms_special_offer',
			'Special Offer',
			function( $p ) {
				$this->hotel_rooms_special_offer_callback( $p );
			},
			'tdt_hotel_room'
		);

		// Add metabox for price
		add_meta_box( 
			'tdt_hotel_rooms_price',
			'Price',
			function( $p ) {
				$this->hotel_rooms_price_callback( $p );
			},
			'tdt_hotel_room'
		);
	}
	
	public function add_special_offers_meta_boxes() {
    // Add metabox for short description of special offer
		add_meta_box( 
			'tdt_special_offer_short_desc',
			'Short Description',
			function( $p ) {
				$this->special_offer_short_desc_callback( $p );
			},
			'tdt_special_offer'
		);
  }

  /**
	 * Output the HTML for the special offer metabox.
	 */
	public function hotel_rooms_special_offer_callback( $post ) {

		// Nonce field to validate form request came from current site
		wp_nonce_field( basename( __FILE__ ), 'hotel_rooms_fields' );

		// Get the special offer data if it's already been entered
		$current_special_offer = get_post_meta( $post->ID, 'hotel_rooms_special_offer', true );
		
		// // Output the field
		// echo '<input type="text" style=" width: 100%" value="' . esc_textarea( $special_offer )  . '" >';
	
		$all_special_offers = get_posts( array(
			'post_type' => 'tdt_special_offer',
			'numberposts' => -1,
			'orderby' => 'post_title',
			'order' => 'ASC'
		));

		$dropdown_html = '<select name="hotel_rooms_special_offer">';
		// $all_special_offers ?:$dropdown_html .= '<option value="">No Special Offers Available</option>';
		$dropdown_html .= '<option value="">None</option>';
		foreach ($all_special_offers as $special_offer) {
			if ($special_offer->ID == $current_special_offer) {
				$dropdown_html .= '<option value="' . $special_offer->ID . '" selected>' . $special_offer->post_title . '</option>';
			} else {
				$dropdown_html .= '<option value="' . $special_offer->ID . '" >' . $special_offer->post_title . '</option>';
			}
		}
		$dropdown_html .= '</select>';

		echo $dropdown_html;

	}

	/**
	 * Output the HTML for the price metabox.
	 */
	public function hotel_rooms_price_callback( $post ) {

		// Nonce field to validate form request came from current site
		wp_nonce_field( basename( __FILE__ ), 'hotel_rooms_fields' );

		// Get the price data if it's already been entered
		$price= get_post_meta( $post->ID, 'hotel_rooms_price', true );
		
		// // Output the field
		echo '<input name="hotel_rooms_price" type="number" min="0.00" step="0.01" value="' . esc_textarea( $price )  . '" >';

	}
	
	/**
	 * Output the HTML for the short description metabox.
	 */
	public function special_offer_short_desc_callback( $post ) {

		// Nonce field to validate form request came from current site
		wp_nonce_field( basename( __FILE__ ), 'special_offers_fields' );

		// Get the url data if it's already been entered
		$short_desc = get_post_meta( $post->ID, 'special_offer_short_desc', true );
		
		// Output the field
		echo '<input type="text" style=" width: 100%" name="special_offer_short_desc" value="' . esc_textarea( $short_desc )  . '" >';
  }
  
  /**
	 * Save the metabox data
	 */
	public function save_hotel_rooms_meta( $post_id, $post ) {

		// Return if the user doesn't have edit permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
    }
    
    // Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times.
		if ( ! (isset( $_POST['hotel_rooms_special_offer'] ) && isset( $_POST['hotel_rooms_price'] )) || ! wp_verify_nonce( $_POST['hotel_rooms_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Now that we're authenticated, time to save the data.
		// This sanitizes the data from the field and saves it into an array $special_offer_meta.
		$hotel_rooms_meta['hotel_rooms_special_offer'] = esc_textarea( $_POST['hotel_rooms_special_offer'] );
		$hotel_rooms_meta['hotel_rooms_price'] = esc_textarea( $_POST['hotel_rooms_price'] );

		// Cycle through the $hotel_rooms_meta array.
		// Note, in this example we just have one item, but this is helpful if you have multiple.
		foreach ( $hotel_rooms_meta as $key => $value ) {

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
	 * Save the metabox data
	 */
	public function save_special_offers_meta( $post_id, $post ) {

		// Return if the user doesn't have edit permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
    }
    
    // Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times.
		if ( ! isset( $_POST['special_offer_short_desc'] ) || ! wp_verify_nonce( $_POST['special_offers_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Now that we're authenticated, time to save the data.
		// This sanitizes the data from the field and saves it into an array $special_offer_meta.
		$special_offer_meta['special_offer_short_desc'] = esc_textarea( $_POST['special_offer_short_desc'] );

		// Cycle through the $special_offer_meta array.
		// Note, in this example we just have one item, but this is helpful if you have multiple.
		foreach ( $special_offer_meta as $key => $value ) {

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
	public function special_offers_columns ( $columns ) {

		$columns = array(
			'cb' => $columns['cb'],
			'ID' => __('ID'),
			'title' => __( 'Title' ),
		);
		
		return $columns;
	}

	/**
	 *	Add the content into the custom columns on All Media Links page
		*/
	public function special_offers_column ( $column, $post_id ) {
		
		// url column
		if ( 'ID' === $column ) {
			echo $post_id;
		}
	}

}