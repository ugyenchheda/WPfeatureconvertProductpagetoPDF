<?php 
 // return all the post with specified category
 function get_existing_products_with_category($category) {
	$post_ids = array();
	if(!empty($category)){		

		 $args = array(	'post_type'             => 'product',
					    'post_status'           => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
					    'posts_per_page'        => '-1',
					    'product_cat' => $category
					);
		$product_data = new WP_Query($args);
		
		if ( $product_data->have_posts() ) {
			while ( $product_data->have_posts() ) : $product_data->the_post();
				array_push($post_ids, get_the_ID());
			endwhile;			
		}
		wp_reset_query();
		return $post_ids;	}
	return $post_ids;
}

// get all product categories
function palmer_product_cats(){
	$product_cats = array();
  
	$product_categories = get_terms( 'producer', array( 'hide_empty' => 0 ) );

	if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
	  	foreach ( $product_categories as $term ) {
			if(array_key_exists('term_id', $term) ) {
				$product_cats[ $term->term_id ] =  strtolower( trim( $term->name  ) );
			}
		}
	}

	return $product_cats;
 }
 // get all product categories
function palmer_product_category(){
	$product_cats = array();
  
	$product_categories = get_terms( 'product_cat', array( 'hide_empty' => 0 ) );

	if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
	  	foreach ( $product_categories as $term ) {
			if(array_key_exists('term_id', $term) ) {
				$product_cats[ $term->term_id ] =  strtolower( trim( $term->name  ) );
			}
		}
	}

	return $product_cats;
 }
 
 // exits product ids which have meta_key is vp-nummer
 function get_existing_product_ids(){
 	global $wpdb; 
 	$product_ids = array();
 	$tableName = $wpdb->prefix."postmeta";

 	$query = "SELECT post_id, meta_value FROM $tableName WHERE meta_key = 'vp-nummer' "; 	

 	$result = $wpdb->get_results( $query );

 	if($result){
 		foreach ($result as $entry) {
 			if(!empty($entry->meta_value)){
 				$product_ids[$entry->meta_value] = $entry->post_id;
 			} 			
 		}
 	}

    return $product_ids;
 }

 function get_existing_product_idss(){
 	global $wpdb; 
 	$product_ids = array();
 	$tableName = $wpdb->prefix."postmeta";

 	$query = "SELECT post_id, meta_value FROM $tableName WHERE meta_key = 'ArticleNumber' "; 	

 	$result = $wpdb->get_results( $query );

 	if($result){
 		foreach ($result as $entry) {
 			if(!empty($entry->meta_value)){
 				$product_ids[$entry->meta_value] = $entry->post_id;
 			} 			
 		}
 	}

    return $product_ids;
 }

 // Delete not updated products

 function palmer_delete_non_updated_products($undeleted_post_ids){
	global $wpdb; 
	$args = array(	'post_type'             => 'product',
					'post_status'           => 'publish',
					'posts_per_page'        => '-1'
					);
		$product_data = new WP_Query($args);
		
		if ( $product_data->have_posts() ) {
			while ( $product_data->have_posts() ) : $product_data->the_post();
				if(!in_array(get_the_ID(), $undeleted_post_ids)){
					wp_delete_post(get_the_ID(), true);
				}
			endwhile;			
		}
		wp_reset_query();

 }

 // manage attachment with post id
 function manageImage($filename,$post_id)  {
	 // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	require_once ABSPATH.'wp-admin/includes/admin.php';
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

 	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( basename( $filename ), null );

	// Get the path to the upload directory.
	$wp_upload_dir = wp_upload_dir();
	// Prepare an array of post data for the attachment.
	$attachment = array(
		'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);

	// Insert the attachment.
	
	$attach_id = wp_insert_attachment( $attachment, $filename, $post_id);

	// Generate the metadata for the attachment, and update the database record.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	set_post_thumbnail( $post_id, $attach_id );

 }

 if ( ! function_exists( 'palmer_timeout_extended' ) ) {
	function palmer_timeout_extended( $time ) {
	    return 50;
	}
}
add_filter( 'http_request_timeout', 'palmer_timeout_extended' );
 
?>
