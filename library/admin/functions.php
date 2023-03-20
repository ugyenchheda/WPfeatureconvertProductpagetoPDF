<?php
function palmer_sync_product_data()
{
    $api_url = "http://193.160.3.15:60003/api/Product?pageSize=-1";
	$response = wp_remote_get( $api_url ,
		array( 'timeout' => 10,
				'headers' => array( 'Token' => '71df9ef0-333f-45e0-bdc1-766fefd84daa@2019-03-04.11:29 |tiac4vecturaAdmin',					
				'Accept'        => 'application/json;ver=1.0',
				'Content-Type'  => 'application/json; charset=UTF-8',
				) 
        ));
    $articles = json_decode($response['body']);  
	// $client = new HttpClient('http://193.160.3.15:60003/api/Product?pageSize=-1');
	// $client->setHeader('Token: 71df9ef0-333f-45e0-bdc1-766fefd84daa@2019-03-04.11:29 |tiac4vecturaAdmin');
	// $client->setHeader('Accept: application/json');
    // $response = $client->execute();
    // $articles = $response->body;
	$product_ids = get_existing_product_ids();
	$product_idss = get_existing_product_idss();
	/*echo "<pre>";
	print_r($product_idss);
	exit();*/
	$product_cats = palmer_product_cats(); //producer
	$product_category = palmer_product_category(); //category
	$riedel_product_ids = get_existing_products_with_category('Riedel');

	$updated_product_ids = array();
	$product_media_info = array();
	if ($articles) {
		foreach ($articles as $key => $article) {

			// if(!empty($article->VPArticleNumber) && $article->ActiveProduct20 == 1){
			if ( !empty($article->VPArticleNumber) || !empty($article->ArticleNumber) ){
			 if($article->ActiveProduct20 == 1 || $article->ActiveProduct21 == 1){
				$product_attributes = array(
					"pa_varenummer" => ltrim($article->VPArticleNumber, '0'),
					"pa_alkohol" => ltrim($article->AlcoholPercent, '0'),
					"pa_varenavn" =>  ltrim($article->ArticleName, '0'),
					"pa_vecturaid" => ltrim($article->ArticleNumber, '0'),
					"pa_land" => ltrim($article->Country, '0'),
					"pa_distrikt" => ltrim($article->District, '0'),
					"pa_Vectura_pris" => ltrim($article->HorecaPrice1, '0'),
					"pa_enhetstype" => ltrim($article->SalesUnit, '0'),
					"pa_temperatur" => ltrim($article->ServingTemperature, '0'),
					"pa_mark" => ltrim($article->SoilInfo, '0'),
					"pa_underdistrikt" => ltrim($article->SubDistrict, '0'),
					"pa_volum" => ltrim($article->Volume, '0'),
					"pa_varetype" => ltrim($article->VPArticleType, '0'), //used for category
					"pa_bitterhet" => ltrim($article->VPBitterness, '0'),
					"pa_farge" => ltrim($article->VPColor, '0'),
					"pa_korktype" => ltrim($article->VPCorkType, '0'),
					"pa_emballasjetype" => ltrim($article->VPPackagingType, '0'),
					"pa_passertil01" => ltrim($article->VPRecommendedFoodSymbol1, '0'),
					"pa_passertil02" => ltrim($article->VPRecommendedFoodSymbol2, '0'),
					"pa_passertil03" => ltrim($article->VPRecommendedFoodSymbol3, '0'),
					"pa_friskhet" => ltrim($article->VPFreshness, '0'),
					"pa_fylde" => ltrim($article->VPFullness, '0'),
					"pa_vareurl" => ltrim($article->VPImageURL, '0'),
					"pa_rastoff" => ltrim($article->VPIngredients, '0'),
					"pa_produktutvalg" => ltrim($article->VPCategory, '0'),
					"pa_generelt_Ordinær_pris" => ltrim($article->VPPrice, '0'),
					"pa_lukt" => ltrim($article->VPSmell, '0'),
					"pa_lagringsgrad" => ltrim($article->VPStorageInfo, '0'),
					"pa_sodme" => ltrim($article->VPSweetness, '0'),
					"pa_garvestoffer" => ltrim($article->VPTannin, '0'),
					"pa_smak" => ltrim($article->VPTaste, '0'),
					"pa_argang" => ltrim($article->VPVintage, '0'),
					"pa_sukker" => ltrim($article->VPSugar, '0'),
					"pa_syre" => ltrim($article->VPAcid, '0'),
					"pa_butikkategori" => ltrim($article->VPShopcategory, '0'),

				);

				if (array_key_exists($article->VPArticleNumber, $product_ids)) {
					$post_id = $product_ids[$article->VPArticleNumber];
				}else if (array_key_exists($article->ArticleNumber, $product_idss)) {
					$post_id = $product_idss[$article->ArticleNumber];
				} else {
					$VPArticleDescription = (isset($article->VPArticleDescription) && $article->VPArticleDescription != '')?$article->VPArticleDescription:'';
					$ArticleName = (isset($article->ArticleName) && $article->ArticleName != '')?$article->ArticleName:'';

					$post_id = wp_insert_post(
						array(
							"author_id" => 1,
							"post_title" => $ArticleName,
							"post_content" => $VPArticleDescription,
							"post_type" => 'product',
							"post_status" => 'publish'
						)
					);

					update_post_meta($post_id, '_sku', $article->VPArticleNumber);
					update_post_meta($post_id, 'vp-nummer', $article->VPArticleNumber);
					update_post_meta($post_id, 'ArticleNumber', $article->ArticleNumber);
					
				}

				// Updated post, Generate Array for media
				if ($post_id) {
					array_push($updated_product_ids, $post_id);
					$path = ($article->ImageFlag) ? 'https://www.vectura.no/Images/produkter/' . $article->ArticleNumber . 'jpg' : 'https://bilder.vinmonopolet.no/cache/515x515-0/' . $article->VPArticleNumber . '-1.jpg';
					$product_media_info[$post_id] = $article->ArticleNumber;
				}
				update_post_meta($post_id, '_regular_price', $article->VPPrice);
				update_post_meta($post_id, '_price', $article->VPPrice);
				update_post_meta($post_id, 'image_status', 'false');
				update_post_meta($post_id, 'karakteristikk', $article->Description);
				//Asign Categories/taxonomies
				$term_id = 62;
				if (!empty($article->ProducerName)) {
					$db_term_id =  array_search(strtolower(trim($article->ProducerName)), $product_cats);
					if (isset($db_term_id) && !empty($db_term_id)) {
						$term_id = $db_term_id;
					} else {
						$producername = trim($article->ProducerName);
						$parent_term = term_exists( $producername ); // array is returned if taxonomy is given
						$parent_term_id = $parent_term['term_id'];         // get numeric term id
						wp_insert_term(
						    $producername,   // the term 
						    'producer', // the taxonomy
						    array(
						        'description' => '',
						        'slug'        => '',
						        'parent'      => $parent_term_id,
						    )
						);

						$term_idata = get_term_by('name',  trim($article->ProducerName), 'producer');
						$term_id = $term_idata->term_id;
					}
				}
				wp_set_object_terms($post_id, $term_id, 'producer');
				 
				/* for category import */
				$cat_term_id = 15; //uncategorized
				if (!empty($article->VPArticleType)) {
					$cat_term_id =  array_search(strtolower(trim($article->VPArticleType)), $product_category);
					if (isset($cat_term_id) && !empty($cat_term_id)) {
						$cat_term_id = $cat_term_id;
					} else {
						$product_catname = trim($article->VPArticleType);
						$parent_term1 = term_exists( $product_catname ); // array is returned if taxonomy is given
						$parent_term_id1 = $parent_term1['term_id'];         // get numeric term id
						wp_insert_term(
						    $product_catname,   // the term 
						    'product_cat', // the taxonomy
						    array(
						        'description' => '',
						        'slug'        => '',
						        'parent'      => $parent_term_id1,
						    )
						);

						$term_idata1 = get_term_by('name',  trim($article->VPArticleType), 'product_cat');
						$cat_term_id = $term_idata1->term_id;
					}
				}
				wp_set_object_terms($post_id, $cat_term_id, 'product_cat');

				if (!empty($article->VPImporter)) {
					wp_set_object_terms( $post_id, $article->VPImporter, 'product_tag' );
				}
			
				// Update Post meta 
				if (!empty($article->ProductionMethod)) {
					update_post_meta($post_id, 'produksjonsmetode', $article->ProductionMethod);
				}

				if (!empty($article->FoodDescription)) {
					update_post_meta($post_id, 'matretter', $article->FoodDescription);
				}


				// Update Product Attributes
				if ($product_attributes) {
					foreach ($product_attributes as $key => $value) {

						if (!empty($value)) {

							$attributes[sanitize_title($key)] = array(
								'name'          => wc_clean($key),
								'value'         => ltrim($value, '0'),
								'position'      => 1, // the order in which it is displayed
								'is_visible'    => 1, // this is the one you wanted, set to true
								'is_variation'  => 1, // set to true if it will be used for variations
								'is_taxonomy'   => 1 // set to true
							);

							wp_set_object_terms($post_id, $value, $key, false);
						}
					}
				}

				update_post_meta($post_id, '_product_attributes', $attributes);
		    	}
			}
		}
		//  Update media info into DB
		update_option('product_media_info', $product_media_info);

		// Delete un updated products
		$undeleted_post_ids = array_merge($updated_product_ids, $riedel_product_ids);
		$undeleted_post_ids = array_unique($undeleted_post_ids);
		echo "<pre>";
		print_r($undeleted_post_ids);
		//palmer_delete_non_updated_products($undeleted_post_ids);
	}
}

// define the woocommerce_product_options_inventory_product_data callback
function action_woocommerce_product_options_inventory_product_data(  ) {
    ?>
	<div class="options_group">
	<?php	$field = array(
					'id' => 'vp-nummer',
					'label' => __( 'Vp nummer', 'textdomain' ),
					'desc_tip'      => true,
					'description' => 'Vp nummer er en unik identifikator for hvert enkelt produckt og hver tjeneste som kan kajøpes.',
				);
				woocommerce_wp_text_input( $field );?>
	</div>
<?php }

// add the action
add_action('woocommerce_product_options_inventory_product_data', 'action_woocommerce_product_options_inventory_product_data', 0, 0 );
add_action('woocommerce_process_product_meta', 'save_inventory_field' );

function save_inventory_field( $post_id ) {
	$custom_field_value = isset( $_POST['vp-nummer'] ) ? $_POST['vp-nummer'] : '';
	$product = wc_get_product( $post_id );
	$product->update_meta_data( 'vp-nummer', $custom_field_value );
	$product->save();
}

function get_redirect_target($url)
{
    $url_exists = 2;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$out = curl_exec($ch);
	// line endings is the wonkiest piece of this whole thing
	$out = str_replace("\r", "", $out);
	// only look at the headers
	$headers_end = strpos($out, "\n\n");
	if( $headers_end !== false ) { 
	    $out = substr($out, 0, $headers_end);
	}   
	$headers = explode("\n", $out);
	 foreach($headers as $header) {
	 	if($header == 'HTTP/1.1 302 Found') {
			if( substr($header, 0, 10) == "Location: " ) { 
				$target = substr($header, 10);
				$url_exists = 1;
			}
		}
	    
	   }
	
	return $url_exists;
}

function abc($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  $out = curl_exec($ch);
  // line endings is the wonkiest piece of this whole thing
  $out = str_replace("\r", "", $out);
  // only look at the headers
  $headers_end = strpos($out, "\n\n");
  if( $headers_end !== false ) { 
      $out = substr($out, 0, $headers_end);
  }   
  $headers = explode("\n", $out);
  if($headers[0] == 'HTTP/1.1 302 Found') {
     return true;
  } else {
     return false;
  }
}


// for media data
function palmer_update_media_data()
{
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => -1,
	);
	$uploadDir = wp_get_upload_dir();
	$targerFolerName = $uploadDir["path"];

	$upload_dir = wp_upload_dir();
	

	if (!file_exists($targerFolerName)) {
		mkdir($targerFolerName, 0777, true);
	}

	$loop = new WP_Query($args);
	while ($loop->have_posts()) : $loop->the_post();
		$post_id = get_the_ID();

			$a = get_post_meta($post_id, 'vp-nummer', true);
	    	$a1 = get_post_meta($post_id, 'ArticleNumber', true);

	    	//$bottlepng = 'https://bilder.vinmonopolet.no/bottle.png';
			$bottlepng =  $upload_dir['baseurl'].'/bottle.png';
			//http://dev.palmer.com/wp-content/uploads/bottle.png
	    	$bottleresp = wp_remote_get($bottlepng);
	    	$fileName = $targerFolerName . '/' . $a . '.jpg';
	    	$fileName1 = $targerFolerName . '/' . $a1 . '.jpg';
	    	$bottlefilepath = $targerFolerName . '/bottle.png';
			
			// case 1
	    	$bilderurl = 'https://bilder.vinmonopolet.no/cache/515x515-0/' . $a . '-1.jpg';
			$vecturaurl = 'https://www.vectura.no/Images/produkter/' . $a1 . '.jpg';
			//$image_status = get_post_meta($post_id, 'image_status', true);
			
			$response = wp_remote_get($bilderurl);
			$response_code = wp_remote_retrieve_response_code($response);
			
			$response1 = wp_remote_get($vecturaurl);
			$response_code1 = wp_remote_retrieve_response_code($response1);
			
			//case 2
			$bilderurl1 = 'https://bilder.vinmonopolet.no/cache/515x515-0/' . $a1 . '-1.jpg';
			$vectura2 = 'https://www.vectura.no/Images/produkter/' . $a1 . '.jpg';
			
			$response2 = wp_remote_get($bilderurl1);
			$response_code2 = wp_remote_retrieve_response_code($response2);
			
			$response3 = wp_remote_get($vectura2);
			$response_code3 = wp_remote_retrieve_response_code($response3);
//if ($image_status == "false") :
	    	if (!empty($a) && !empty($a1)) {
	    		//case 1
	    			$check = abc($bilderurl);
	    			if($check){
	    				if ($response_code1 == '200') {
						  wp_delete_attachment(get_post_thumbnail_id($post_id));
					 	  file_put_contents($fileName1, $response1['body']);
						  manageImage($fileName1, $post_id);
						}else{
						  wp_delete_attachment(get_post_thumbnail_id($post_id));
						  file_put_contents($bottlefilepath,$bottleresp['body']);
						  manageImage($bottlefilepath, $post_id);
					    }
	    			}else{
	    				if ($response_code == '200') {
						  wp_delete_attachment(get_post_thumbnail_id($post_id));
			    	      file_put_contents($fileName1, $response['body']);
				          manageImage($fileName1, $post_id);
					   }else{
						  wp_delete_attachment(get_post_thumbnail_id($post_id));
						  file_put_contents($bottlefilepath,$bottleresp['body']);
						  manageImage($bottlefilepath, $post_id);
					   }
	    			}
              update_post_meta($post_id, 'image_status', 'true');
	    	}else if(empty($a) && !empty($a1)){
				//ArticleNumber is not empty but vp-nummer is empty
	    		//case 2
	    			$check = abc($bilderurl1);
	    			if($check){
	    				//redirected to bottle.png so choose vectura
	    				if ($response_code3 == '200') {
							wp_delete_attachment(get_post_thumbnail_id($post_id));
					 	    file_put_contents($fileName1, $response3['body']);
						    manageImage($fileName1, $post_id);
						}
						else{
							wp_delete_attachment(get_post_thumbnail_id($post_id));
							file_put_contents($bottlefilepath,$bottleresp['body']);
						    manageImage($bottlefilepath, $post_id);
						}
	    			}else{
	    				//bilder
	    				if ($response_code2 == '200') {
					 	 wp_delete_attachment(get_post_thumbnail_id($post_id));
			    	     file_put_contents($fileName1, $response2['body']);
				         manageImage($fileName1, $post_id);
						}
						else{
						 wp_delete_attachment(get_post_thumbnail_id($post_id));
						 file_put_contents($bottlefilepath,$bottleresp['body']);
						 manageImage($bottlefilepath, $post_id);
					    }
	    			}
	    		update_post_meta($post_id, 'image_status', 'true');
	    	}
   endwhile;
   wp_reset_query();
}

function palmer_update_media_data1()
{
	
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => -1,
	);

	$uploadDir = wp_get_upload_dir();
	$targerFolerName = $uploadDir["path"];

	if (!file_exists($targerFolerName)) {
		mkdir($targerFolerName, 0777, true);
	}

	$loop = new WP_Query($args);
	while ($loop->have_posts()) : $loop->the_post();
		$post_id = get_the_ID();
		update_post_meta($post_id, 'image_status', 'false');

		$a = get_post_meta($post_id, 'vp-nummer', true);
		$a1 = get_post_meta($post_id, 'ArticleNumber', true);
		$image_status = get_post_meta($post_id, 'image_status', true);

		$image_status = get_post_meta($post_id, 'image_status', true);
		if ($image_status == "false") :
			$fileName = $targerFolerName . '/' . $a . '.jpg';
			if (!empty($a) && !empty($a1)) {
				//145629
				$response = wp_remote_get('https://bilder.vinmonopolet.no/cache/515x515-0/' . $a . '-1.jpg');
				$response_code = wp_remote_retrieve_response_code($response);
				if ($response_code == '200') {
					wp_delete_attachment(get_post_thumbnail_id($post_id));
					file_put_contents($fileName, $response['body']);
					manageImage($fileName, $post_id);
				} else {
					$response = wp_remote_get('https://www.vectura.no/Images/produkter/' . $a1 . '.jpg');
					$response_code = wp_remote_retrieve_response_code($response);
					if ($response_code == '200') {
						wp_delete_attachment(get_post_thumbnail_id($post_id));
						file_put_contents($fileName, $response['body']);
						manageImage($fileName, $post_id);
					}
				}

				update_post_meta($post_id, 'image_status', 'true');
			}
		endif;
	endwhile;
	wp_reset_query();
}

//manage media for taxonomy
function taxImageManage($filename, $tax_id)  {
	// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	require_once (ABSPATH.'wp-admin/includes/admin.php');
	require_once (ABSPATH . 'wp-admin/includes/image.php');

	// check folder name
	$uploadDir = wp_get_upload_dir();		
	$targerFolerName = $uploadDir["path"];	
	
	if(!file_exists($targerFolerName)){		
		mkdir($targerFolerName, 0777, true);
	}
	$targerFileName = $targerFolerName."/".basename($filename);
	if(!empty($filename)){
		file_put_contents($targerFileName, file_get_contents( $filename ));
		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $targerFileName ), null );
		// Get the path to the upload directory.
		$wp_upload_dir = wp_upload_dir();
		// print_r($wp_upload_dir);		
		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $targerFileName ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $targerFileName ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		
		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $targerFileName);		
		update_post_meta($post_id, '_thumbnail_id', $attach_id );

		$path_img = $wp_upload_dir['url'] . '/' . basename($filename); 
		
		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $targerFileName );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		update_term_meta( $tax_id, 'palmer_producer_logo',  $path_img );
		update_term_meta( $tax_id, 'palmer_producer_logo_id',  $attach_id );		
	}

}
