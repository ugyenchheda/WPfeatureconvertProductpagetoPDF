<?php
if (!function_exists('newpalmer_front_init')) {
	function newpalmer_front_init()
	{
		new_palmer_guest_id();
	}
}
add_action('init', 'newpalmer_front_init');

/* Random Key Generate */
if (!function_exists('new_palmer_random_keygen')) {
	function new_palmer_random_keygen($n = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';

		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}

		return $randomString;
	}
}

function new_palmer_guest_id()
{
	$content = '';
	if (!isset($_COOKIE['gd_favuser']) || empty($_COOKIE['gd_favuser'])) {
		$user_auth =  new_palmer_random_keygen();
		setcookie('gd_favuser', $user_auth, time() + 78436438, '/');
		$content = $user_auth;
	} else {
		$content = $_COOKIE['gd_favuser'];
	}

	return $content;
}

add_action('wp_ajax_save_wishlist', 'save_wishlist');
add_action('wp_ajax_nopriv_save_wishlist', 'save_wishlist');

function save_wishlist(){
    global $wpdb;
	$response_arr 	= array();
	$userid = new_palmer_guest_id();
	$product_id = $_POST['product_id'];
	$total_count = new_palmer_count_wishlist($userid, $product_id);
	if ($total_count == 0) {
		insert_wishlist($userid,$product_id);
		$response_arr['status'] = 'add';
	}
	$response_arr['count'] = new_palmer_count_wishlist($userid);
	echo json_encode($response_arr);
	exit;
}

 function insert_wishlist($user,$post_id){
	 global $wpdb;
 	$wpdb->insert(
 			'wp_globdig_wishlist',
 			array(
 				'user_id' =>  $user,
 				'product_id' => $post_id,
 				'glob_order' => '1',
 			),
 			array(
 				'%s', 
				'%s',
				'%d',

 			)
 		);
 		return $wpdb->insert_id;
 }

add_action('wp_ajax_remove_wishlist', 'remove_wishlist');
add_action('wp_ajax_nopriv_remove_wishlist', 'remove_wishlist');

function remove_wishlist(){
   $responce = [];
   $product_id=$_POST['product_id'];
   $remove_w = newpalmer_remove_wishlist($_COOKIE['gd_favuser'],$product_id);
   if ( $remove_w ){
      $responce['status'] = 'success';
      $responce['rid'] = $product_id;
   }
   $responce['count_wishlist'] = newpalmer_count_wishlist($_COOKIE['gd_favuser']);
   $responce['message'] = 'Product Remove Favourite';
   echo json_encode( $responce );
   die();
}

 function newpalmer_remove_wishlist($user,$product_id){
	 global $wpdb;
 	$result = $wpdb->delete(
 		'wp_globdig_wishlist',
 			array( 'user_id' => $user,
 		 					'product_id' => $product_id ),
 							array(
 								'%s',
 								'%s'
 							)
 					);
 		return $result;
  }


/* Wishlist count */
if (!function_exists('new_palmer_count_wishlist')) {
	function new_palmer_count_wishlist($userid, $product_id = '')
	{
		global $wpdb;
		$sql = "SELECT COUNT(*) FROM wp_globdig_wishlist WHERE user_id = '" . $userid . "'";

		if (!empty($product_id)) {
			$sql .=  " AND product_id = " .  $product_id;
		}

		return $wpdb->get_var($sql);
	}
}

if (!function_exists('newpalmer_count_wishlist')) {
function newpalmer_count_wishlist( $user ){
 	global $wpdb;
	 $results = $wpdb->get_results( "SELECT * FROM `wp_globdig_wishlist` WHERE `user_id` = '".$user."' ORDER BY `glob_order` ASC", OBJECT );

	 return count($results);
}
}

if (!function_exists('newpalmer_wishlist_results')) {
	function newpalmer_wishlist_results(){
		 global $wpdb;
		 $results = $wpdb->get_results( "SELECT * FROM `wp_globdig_wishlist`");
	
		 return $results;
}
}

function return_user(){
  if(!isset($_COOKIE['gd_favuser'])) {
     $cookie_value = uniqid('gd_');
     setcookie('gd_favuser', $cookie_value, time() + (86400), "/");
   }
   return $_COOKIE['gd_favuser'];
}