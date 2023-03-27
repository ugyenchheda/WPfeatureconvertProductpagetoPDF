<?php
define( 'BASEL_CHILD_THEME_DIR', get_stylesheet_directory_uri() );
add_image_size('widget_size_thumbnail',60,60,true);

add_action('admin_enqueue_scripts','basel_child_admin_styles');
function basel_child_admin_styles(){
	wp_enqueue_style( 'basel-ad', get_stylesheet_directory_uri() . '/assets/admin_style.css', array(), '281245' );
}


add_action( 'wp_enqueue_scripts', 'basel_child_enqueue_styles', 1000 );
function basel_child_enqueue_styles() {
	$version = basel_get_theme_info( 'Version' );
	if( basel_get_opt( 'minified_css' ) ) {
		wp_enqueue_style( 'basel-style', get_template_directory_uri() . '/style.min.css', array('bootstrap'), $version );
	} else {
		wp_enqueue_style( 'basel-style', get_template_directory_uri() . '/style.css', array('bootstrap'), $version );
	}
	// wp_enqueue_style( 'basel-style', get_template_directory_uri() . '/style1.css', array('bootstrap'), $version );
	wp_enqueue_style( 'basel-select', get_stylesheet_directory_uri() . '/assets/select2.min.css', array(), '281245' );
	wp_enqueue_script( 'basel-selectjs', get_stylesheet_directory_uri() . '/assets/select2.min.js', array('jquery'), $version );
	wp_enqueue_style( 'font-style', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style( 'simple-line-style', 'https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css');
	
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css?v=544' );
	wp_enqueue_style( 'child-style1', get_stylesheet_directory_uri() . '/style1.css?v=544' );
    wp_enqueue_style('select2.min', get_stylesheet_directory_uri() . '/css/chosen.css');
	wp_enqueue_style('nouislider_css', get_stylesheet_directory_uri() . '/css/nouislider.css?v=54343453');
	wp_enqueue_script('select2.min', get_stylesheet_directory_uri() . '/js/chosen.jquery.js', array(), '81245', true);
	wp_enqueue_script('nouislider_script', get_stylesheet_directory_uri() . '/js/nouislider.js', array(), '81245', true);
	if(!is_shop()){
     wp_enqueue_style( 'calendar-style', get_stylesheet_directory_uri() . '/css/calendar.css', array(), '91254');
     wp_enqueue_script('calendar_script', get_stylesheet_directory_uri() . '/assets/calendar.js', array(), '3', true);
    }
	wp_enqueue_script('datepicker-js',get_stylesheet_directory_uri() .'/assets/jquery.ui.datepicker.js',array('jquery'),'1.8.16');
    wp_enqueue_script('doutch-lan-js',get_stylesheet_directory_uri() .'/assets/jquery-ui-i18n.js',array('jquery'),'');
    wp_register_script('palmer_script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery','basel-selectjs'),'91266', true);
	wp_enqueue_script('palmer_script');
	$palmer_params = array(
		'admin_ajax_url' => admin_url('admin-ajax.php'),
		'blog_url' => esc_url( home_url( '/product-category/' ) )
	);
	$palmer_params['slider_price_min'] = palmer_postmeta_mm_value('_price', 'min');
	$palmer_params['slider_price_max'] = palmer_postmeta_mm_value('_price', 'max');
	$palmer_params['site_name']        = get_bloginfo('name');
	$palmer_params['search_url'] = esc_url( home_url( '/' ) ) . 'shop/';
	wp_localize_script('palmer_script', 'palmer_params', $palmer_params);
}

// Load translation files from your child theme instead of the parent theme
function child_theme_slug_setup() {
    load_child_theme_textdomain( 'basel', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'child_theme_slug_setup' );

/* meta value for price */
function palmer_postmeta_mm_value($meta_key, $option = 'min')
{
	global $wpdb;
	$content = '0';

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 1,
		'orderby'  => 'meta_value_num',
		'meta_key'  => '_price',
		'order'  => 'ASC'
	);

	if ($option == 'max') {
		$args['order'] = 'DESC';
	}

	$mm_posts = new WP_Query($args);

	if ($mm_posts->have_posts()) {

		while ($mm_posts->have_posts()) : $mm_posts->the_post();
			$price = get_post_meta(get_the_ID(), '_price', true);
			if (isset($price) && !empty($price)) {
				$content = $price;
			}
		endwhile;
		wp_reset_query();
	}
	return $content;
}

/** Add Library functionality */
include 'inc/template-tags.php';
require 'inc/wishlist_functions.php';
include 'vendor/autoload.php';
include 'library/config_manager.php';

/* filter for product wines */
if (!function_exists('palmer_filter_product')) {
	function palmer_filter_product()
	{
		$response_arr = array();
		$content = '';
		$record_count = '';
		$tax_query_meta = array();
		$meta_query = array();

		$paged = $_POST['paged'];
		if (isset($_POST['opt_mode']) && $_POST['opt_mode'] == 'filter') {
			$paged = 1;
		}

		$args = array(
			'post_type' 	 => 'product',
			'posts_per_page' 	=> $_POST['posts_per_page'],
			'paged' 			=> $paged,
		);

		if (isset($_POST['search_query']) && !empty($_POST['search_query'])) {
			$args['s'] = $_POST['search_query'];
		}

		/* Sorting Data */
		if (!empty($_POST['filter_orderby'])) {
			$filter_sort_cabins = explode("-", $_POST['filter_orderby']);
			$orderby = $filter_sort_cabins[0];
			$order = $filter_sort_cabins[1];

			$args['order'] = $order;

			switch ($orderby) {
				case "price":
					$args['meta_key'] = '_price';
					$args['orderby'] = 'meta_value_num';

					break;
				case "date":
					$args['orderby'] = 'date';
					break;
				case "title":
					$args['orderby'] = 'date';
					break;
				default:
					$args['orderby'] = 'name';
			}
		}

		/* Meta Query */
		if (!empty($_POST['filter_pris'])) {
			$filter_pris_arr = explode("-", $_POST['filter_pris']);
			$meta_query[] = array(
				'key' => '_price',
				'value' => array($filter_pris_arr[0], $filter_pris_arr[1]),
				'type' => 'numeric',
				'compare' => 'BETWEEN'
			);
		}

		if (!empty($_POST['t_id'])) {
			$tax_query_meta[] = array(
				'taxonomy'  => 'product_cat',
				'field'     => 'id',
				'terms'     => array($_POST['t_id']),
			);
		}

		if (!empty($_POST['passertil'])) {
			$tax_query_meta[] = array(
				'taxonomy' => 'pa_passer-til',
				'field'    => 'name',
				'terms'    => array($_POST['passertil']),
			);
		}

		if (!empty($_POST['filter_country'])) {
			$tax_query_meta[] = array(
				'taxonomy' => 'pa_land',
				'field'    => 'name',
				'terms'    => array($_POST['filter_country']),
			);
		}

		if (!empty($_POST['filter_volume'])) {
			$tax_query_meta[] = array(
				'taxonomy' => 'pa_volum',
				'field'    => 'name',
				'terms'    => array($_POST['filter_volume']),
			);
		}

		if (!empty($_POST['filter_district'])) {
			$tax_query_meta[] = array(
				'taxonomy' => 'pa_distrikt',
				'field'    => 'name',
				'terms'    => array($_POST['filter_district']),
			);
		}

		if ($tax_query_meta) {
			$args['tax_query'] = array(
				'relation' => 'AND',
				$tax_query_meta,
			);
		}

		if ($meta_query) {
			$args['meta_query'] =  array(
				'relation' => 'AND',
				$meta_query,
			);
		}

		$cabinpost = new WP_Query($args);
		$total_record = $cabinpost->found_posts;
		$load_more_record = $total_record - $_POST['posts_per_page'] * $paged;
		if ($load_more_record <= 0) {
			$load_more_record = 0;
		}

		//print_r($args);


		if ($cabinpost->have_posts()) {

			while ($cabinpost->have_posts()) : $cabinpost->the_post();

				$content .= '<div class="col-sm-3">
			<div class="product-item">
					<div class="img-holder">
							<a href="' . get_permalink() . '">';

				if (has_post_thumbnail()) {
					$content .= get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'img-fluid'));
				} else {
					$content .=  '<img src="' . get_stylesheet_directory_uri() . '/images/687501-1.jpg" class="img-fluid"  itemprop="image"/>';
				}


				$content .=	'</a>
							<a href="javascript:void(0)" class="view-more"  rel="' . get_the_ID() . '">
									<i class="fa fa-search-plus"></i>
									Quick View </a>';

				$content .=		'<div class="pop-' . get_the_ID() . ' pop_wrap" id="pop-' . get_the_ID() . '">           
								<div class="pop_body">
										<div class="pop_close">
												<i class="fa fa-close"></i>
										</div>
										<div class="col-sm-6">';

				$filter_product = get_the_post_thumbnail_url(get_the_ID(), 'full');
				if ($filter_product) {
					$content .= '<img  src="' . $filter_product . '" class="image_fluid" alt="" >';
				} else {
					$content .= '<img  src="' .  get_stylesheet_directory_uri() . '/images/687501-1.jpg" class="image_fluid" alt="" >';
				}


				$content .= '</div>
										<div class="col-sm-6">
												<div class="pop_bcontent">
														<h3 class="product-title">
																<a href="' . get_permalink() . '">' . get_the_title(get_the_ID()) . '</a>
														</h3>
														<div class="wrap-price">
																<span class="price">';

				$price  = get_post_meta(get_the_ID(), '_price', true);
				if ($price) {
					$content .= 'Kr' . $price;
				}

				$content .= '	</span>
														</div>
														<div class="bar_code">';

				$content .=  do_shortcode('[yith_render_barcode id="' . get_the_ID() . '"]');
				$content .= '</div>
														<div class="product_att">';

				$item_number = get_post_meta(get_the_ID(), '_sku', true);
				$content .= '<p><strong>Varenummer:</strong> ' . $item_number . '</p>';

				$product_terms = get_the_terms(get_the_ID(), 'product_cat');
				foreach ($product_terms as $product_term) {
					$cat_name = $product_term->name;
					$content .= '<p><strong>Kategorier:</strong> ' . $cat_name . '</p>';
				}

				$content .= '<div class ="view_detail">
															 <a href="' . get_permalink() . '"> ' . __('Vis detaljer', 'palmer') . ' </a>	</div>                                    
															</div>';

				$content .= '<div class="add-list">';
				$content .= '<div id="gdfav_id' . get_the_ID() . '">';
				$check =  check_wishlist($_COOKIE['gd_favuser'], get_the_ID());
				if (check_wishlist($_COOKIE['gd_favuser'], get_the_ID()) == 'notadded') {
					$j_action = "product_favorite('" . get_the_ID() . "','add','modal')";
					$content .= '<a class="myFabbtn"  onclick="' . $j_action . '"><i class="fa fa-heart addWine"></i></a>';
				} else {
					$j_action = "product_favorite('" . get_the_ID() . "','remove','modal')";
					$content .= '<a class="myFabbtn"  onclick="' . $j_action . '"><i class="fa fa-heart removeWine"></i></a>';
				}
				$content .= '</div> 
															</div>
												</div>
										</div>	
										<div class="clear"></div>
								</div>                            
						</div>';

				$content .=	'</div>
					<div class="text-holder">
							<h3 class="product-title">
									<a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';

				$price  = get_post_meta(get_the_ID(), '_price', true);
				if (!empty($price)) {
					$content .= '<div class="wrap-price"><span class="price">Kr ' . $price . '</span></div>';
				}

				$content .=	'</div>
			</div>
	 </div>';

			endwhile;
		}

		$content .= '<script>jQuery( document ).ready(function( $ ) { 

			$(".view-more").on("click", function() {
				var p_id = $(this).attr("rel");   
				$(".pop-"+p_id).addClass("visible");  
				
			});

			$(".pop_close").on("click", function() {
				$(".pop_wrap").removeClass("visible");
				$(".bg_wrap").hide();    
			});

		});</script>';
		$record_message = sprintf(esc_html(_n('%d PRODUCT MATCHES YOUR SEARCH CRITERIA', '%d PRODUCTS MATCH YOUR SEARCH CRITERIA', $record_count, 'hytteguiden')), $record_count);
		$response_arr['content'] = $content;
		$response_arr['record_count'] = $record_message;
		$response_arr['total_record'] = $total_record;
		$response_arr['load_more_text'] = __('Last mer', 'hytteguiden') . '(' . $load_more_record . ')';

		echo json_encode($response_arr);
		exit;
	}
}
add_action('wp_ajax_palmer_filter_product', 'palmer_filter_product');
add_action('wp_ajax_nopriv_palmer_filter_product', 'palmer_filter_product');

// register custom widgets
add_action('widgets_init', 'theme_slug_widgets_init');
function theme_slug_widgets_init()
{
	register_sidebar(array(
		'name' => __('Product Alert Sidebar', 'theme-slug'),
		'id' => 'product-alert',
		'description' => __('Alert in this area will be shown on all products.', 'theme-slug'),
		'before_widget' => '<li id="%1$s" class="widget widget-alertproduct %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle alertproducttitle">',
		'after_title'   => '</h2>',
	));
}

if( ! function_exists( 'basel_compare_btn' ) ) {
	function basel_compare_btn() {

	}
}
//registering the product attribute
function product_data_pdf($product)
{
	$data = [];
	$product_id = $product;

	$product = wc_get_product($product);
	$attributes = array(
		'pa_varetype' => $product->get_attribute('pa_varetype'),
		'pa_land' => $product->get_attribute('pa_land'),
		'pa_distrikt' => $product->get_attribute('pa_distrikt'),
		'pa_volum' => $product->get_attribute('pa_volum'),
		'pa_diameter' => $product->get_attribute('pa_diameter'),
		'pa_underdistrikt' => $product->get_attribute('pa_underdistrikt'),
		'pa_argang' => $product->get_attribute('pa_argang'),
		'pa_alkohol' => $product->get_attribute('pa_alkohol'),
		'pa_sukker' => $product->get_attribute('pa_sukker'),
		'pa_syre' => $product->get_attribute('pa_syre'),
		'pa_rastoff' => $product->get_attribute('pa_rastoff'),
		'pa_produktutvalg' => $product->get_attribute('pa_produktutvalg'),
		'pa_butikkategori' => $product->get_attribute('pa_butikkategori'),
		'pa_varenummer' => $product->get_attribute('pa_varenummer'),
		'pa_vekturaid' => $product->get_attribute('pa_vekturaid'),
		'pa_emballasjetype' => $product->get_attribute('pa_emballasjetype'),
		'pa_passertil1' => $product->get_attribute('pa_passertil1'),
		'pa_passertil2' => $product->get_attribute('pa_passertil2'),
		'pa_vecturapris' => $product->get_attribute('pa_vecturapris'),
		'pa_passertil3' => $product->get_attribute('pa_passertil3'),
		'pa_produsent' => $product->get_attribute('pa_produsent'),
		'pa_hoyde'		=> $product->get_attribute('pa_hoyde'),
		'pa_serie' => $product->get_attribute('pa_serie'),
		'pa_vekturaid' => $product->get_attribute('pa_vekturaid')

	);

	$passertil01 = $product->get_attribute('passertil01');
	$passertil_val = explode(",", $passertil01);
	$passertil_data = [];
	
	$p = 0;
	foreach ($passertil_val as $key => $value) {
		$passertil_data[$p]['name'] = $value;
		$passertil_data[$p]['image'] = return_image_passertil01($value);
		$p++;
	}

	if ($product->get_attribute('pa_fylde')) {
		$attributes_images['pa_fylde_image'] = get_stylesheet_directory_uri() . "/images/progress/percent (" . $product->get_attribute('pa_fylde') . ").png";
	}
	if ($product->get_attribute('pa_friskhet')) {
		$attributes_images['pa_friskhet_image'] = get_stylesheet_directory_uri() . "/images/progress/percent (" . $product->get_attribute('pa_friskhet') . ").png";
	}
	if ($product->get_attribute('pa_bitterhet')) {
		$attributes_images['pa_bitterhet_image'] = get_stylesheet_directory_uri() . "/images/progress/percent (" . $product->get_attribute('pa_bitterhet') . ").png";
	}
	if ($product->get_attribute('pa_garvestoffer')) {
		$attributes_images['pa_garvestoffer_image'] = get_stylesheet_directory_uri() . "/images/progress/percent (" . $product->get_attribute('pa_garvestoffer') . ").png";
	}
	if ($product->get_attribute('pa_sodme')) {
		$attributes_images['pa_sodme_image'] = get_stylesheet_directory_uri() . "/images/progress/percent (" . $product->get_attribute('pa_sodme') . ").png";
	}
	if ($product->get_attribute('pa_passertil1')) {
		$attributes_images['pa_passertil1_image'] = get_stylesheet_directory_uri() . "/images/images/food (" . $product->get_attribute('pa_passertil1') . ").png";
	}
	if ($product->get_attribute('pa_passertil2')) {
		$attributes_images['pa_passertil2_image'] = get_stylesheet_directory_uri() . "/images/images/food (" . $product->get_attribute('pa_passertil2') . ").png";
	}
	if ($product->get_attribute('pa_passertil3')) {
		$attributes_images['pa_passertil3_image'] = get_stylesheet_directory_uri() . "/images/images/food (" . $product->get_attribute('pa_passertil3') . ").png";
	}

	$l_image = get_the_post_thumbnail_url($product->get_id(), 'large');
	$karakteristikk = get_post_meta($product->get_id(), 'karakteristikk', true);
	$matretter = get_post_meta($product->get_id(), 'matretter', true);
	$produksjonsmetode = get_post_meta($product->get_id(), 'produksjonsmetode', true);

	$category = get_the_terms($product->get_id(), 'producer');
	foreach ($category as $prod_term) {
		$product_cat_id = $prod_term->term_id;
		$product_parent_categories_all_hierachy = get_ancestors($product_cat_id, 'producer');
	}

	$cat_id1 = $category[0]->term_id;
	$cat_id2 = '';

	if (isset($category[1]->term_id)) {
		$cat_id2 = $category[1]->term_id;
	}
	if (isset($category[2]->term_id)) {
		$cat_id3 = $category[2]->term_id;
	}

	if ($cat_id1 > $cat_id2) {
		$cat_id = $cat_id1;

	} else {
		$cat_id = $cat_id2;
	}

	$child = get_terms('producer', array('parent' => $cat_id, 'hide_empty' => false));
	if (empty($child)) {
		$thumbnail_id = get_woocommerce_term_meta($cat_id, 'thumbnail_id', true);
		$image = wp_get_attachment_url($thumbnail_id);
	} else {
		$thumbnail_id = get_woocommerce_term_meta($cat_id3, 'thumbnail_id', true);
		$image = wp_get_attachment_url($thumbnail_id);
	}
	//first parent
	$first_parent_thumbnail_id = get_woocommerce_term_meta($product_cat_id, 'thumbnail_id', true);
	$first_parent_image = wp_get_attachment_url($first_parent_thumbnail_id);
		$data = array(
		'id' => $product->get_id(),
		'title' => $product->get_title(),
		'category' => $category,
		'image'  => $l_image,
		'price' => $product->get_price_html(),
		'karakteristikk' => $karakteristikk,
		'matretter' => $matretter,
		'produksjonsmetode' => $produksjonsmetode,
		'category_image' => $image,
		'first_parent_image' => $first_parent_image,
		'attributes' => $attributes,
		'attributes_images' => $attributes_images,
		'passertil_data' => $passertil_data,
	);
	return $data;
}

function return_image_passertil01($passertil)
{

	$passertil = ucfirst(trim(strip_tags($passertil)));
	$v = '';
	if ($passertil == 'Fisk') {
		$v = get_stylesheet_directory_uri() . '/images/food/Fisk.png';
	}
	if ($passertil == 'Aperitiff' || $passertil == 'Aperitiff/avec') {
		$v  = get_stylesheet_directory_uri() . '/images/food/aperitiff.png';
	}
	if ($passertil == 'Dessert') {
		$v  = get_stylesheet_directory_uri() . '/images/food/dessert.png';
	}
	if ($passertil == 'Ost') {
		$v  = get_stylesheet_directory_uri() . '/images/food/ost.png';
	}
	if ($passertil == 'Skalldyr') {
		$v  = get_stylesheet_directory_uri() . '/images/food/skalldyr.png';
	}

	if ($passertil == 'Svinekjøtt') {
		$v  = get_stylesheet_directory_uri() . '/images/food/svinekjott.png';
	}
	if ($passertil == 'Grønnsaker') {
		$v  = get_stylesheet_directory_uri() . '/images/food/gronnsaker.png';
	}
	if ($passertil == 'Storvilt') {
		$v  = get_stylesheet_directory_uri() . '/images/food/storvilt.png';
	}
	if ($passertil == 'Kake') {
		$v = get_stylesheet_directory_uri() . '/images/food/dessert.png';
	}
	if ($passertil == 'Lyst kjøtt') {
		$v  = get_stylesheet_directory_uri() . '/images/food/lystkjott.png';
	}
	if ($passertil == 'Lam og sau') {
		$v  = get_stylesheet_directory_uri() . '/images/food/lamsau.png';
	}
	if ($passertil == 'Frukt') {
		$v  = get_stylesheet_directory_uri() . '/images/food/frukt.png';
	}
	if ($passertil == 'Storfe') {
		$v  = get_stylesheet_directory_uri() . '/images/food/storferodtkjott.png';
	}
	if ($passertil == 'Småvilt og fugl') {
		$v  = get_stylesheet_directory_uri() . '/images/food/småvilt.png';
	}

	return $v;
}

/*
* Calendar Events Display
*/
add_shortcode('palmer-event-calendar', 'display_sc_calendar'); 
function display_sc_calendar(){
	ob_start();
    include 'inc/event-calendar.php';
    $html = ob_get_contents();
    ob_get_clean();
    return $html;

}
add_action('wp_ajax_palmer_event_calendar_button', 'palmer_event_calendar_button');
add_action('wp_ajax_nopriv_palmer_event_calendar_button', 'palmer_event_calendar_button');
function palmer_event_calendar_button(){
   if(isset($_POST['month']) && $_POST['month'] != ''){
		$publishdate2 = array();
		$lists2 = array();
		$filterDates = array();
		$month = $_POST['month'];
		$year = $_POST['year'];
		$postDate = date('Y-m', strtotime($year.'-'.$month));
		$the_query2 = new WP_Query(array(
		    'posts_per_page' => -1,
		    'cat' => 38, // this is the category SLUG,
		    'post_status' => 'publish',
		    'post_type'        => 'post',
		));
		$form_response['html_data'] = '';
		if ($the_query2->have_posts()) {
		while ($the_query2->have_posts()) : $the_query2->the_post();
			$dID = get_the_ID();
			$dato = get_post_meta( $dID, 'dato', true );
			if($dato != ''){
				$p = array(
				'title' => get_the_title(),
				'date' => get_the_date(),
				'dato' => $dato,
				'id' => get_the_ID(),
				'permalink' =>get_the_permalink(),
			    );
				$arrayDate = date("Y-m",strtotime($dato));
			    if($arrayDate == $postDate){
		           array_push($filterDates, $p);
		       }
			}
		endwhile;
		}
		if(!empty($filterDates)){
		foreach ($filterDates as $postfilter) {
	       	$postdato1 = $postfilter['dato'];
	       	$posttitle1 = $postfilter['title'];
         	$permalink = $postfilter['permalink'];
         	$did = $postfilter['id'];
         	$timestamp1 = strtotime($postdato1);
			$new_datedato1 = date("M d, Y", $timestamp1); 
			$month1 = date("M", $timestamp1); 
			$day1 = date("d", $timestamp1); 
			$form_response['html_data'] .= '<div class="calendar-event-list"><div class="list-date"><span class="list-month">'.$month1.'</span><span class="list-day">'.$day1.'</span></div><div class="list-info"><h2 class="event-title"><a href="'.$permalink.'" target="_self">'.$posttitle1.'</a></h2><span class="dato">'.$new_datedato1.'</span></div></div>';
       }
      }else{
      	$form_response['html_data'] = '<div class="palmer-event-msg">Ingen hendelser funnet</div>';
      }
     echo json_encode($form_response);
     exit;
    }else{
        die( 'No script kiddies please!' );
    }	
}
/* horea option for the products*/
function custom_pre_get_posts_query( $q ) {

    $tax_query = (array) $q->get( 'tax_query' );

    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'slug',
           'terms' => array( 'horecaprodukter','riedel' ), // Don't display products in the horecaprodukter category on the shop page.
           'operator' => 'NOT IN'
    );


    $q->set( 'tax_query', $tax_query );

}
add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' );  
