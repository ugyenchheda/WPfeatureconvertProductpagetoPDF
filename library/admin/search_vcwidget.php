<?php 
function palmer_search_product_filters() {
		$attribute_array = array( '' => '' );

		if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if ( $attribute_taxonomies ) {
				foreach ( $attribute_taxonomies as $tax ) {
					$attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
				}
			}
		}

        //Product filter parent element
		vc_map( array(
			'name' => esc_html__( 'Palmer Product Filters', 'basel-child' ),
			'base' => 'newpalmer_product_filters',
			'class' => '',
			'category' => esc_html__( 'Palmer Search', 'basel-child' ),
			'description' => esc_html__( 'Add search filters by category, attributes or price', 'basel-child' ),
            'icon' => BASEL_ASSETS . '/images/vc-icon/product-filter.svg',
            'as_parent' => array( 'only' => 'newpalmer_filter_categories, newpalmer_filters_attribute, newpalmer_filters_price_slider,newpalmer_product_search' ),
			'content_element' => true,
			'show_settings_on_create' => true,
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Button Text', 'basel-child' ),
					'param_name' => 'btn_text',
					'description' => esc_html__( 'Fill button text here.', 'basel-child' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra Class Name', 'basel-child' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'basel-child' )
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'basel-child' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'basel-child' )
				),
				
            ),
			'js_view' => 'VcColumnView'
        ) );
        //Product filter categories
        vc_map( array(
			'name' => esc_html__( 'Palmer Filter Categories', 'basel-child'),
			'base' => 'newpalmer_filter_categories',
			'as_child' => array( 'only' => 'newpalmer_product_filters' ),
			'content_element' => true,
			'category' => esc_html__( 'Palmer Search', 'basel-child' ),
			'icon' => BASEL_ASSETS . '/images/vc-icon/product-filter.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Placeholder', 'basel-child' ),
					'param_name' => 'cat_placeholder',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'basel-child' ),
					'param_name' => 'order_by',
					'value' => array(
						esc_html__( 'Name', 'basel-child' ) => 'name',
						esc_html__( 'ID', 'basel-child' ) => 'ID',
						esc_html__( 'Slug', 'basel-child' ) => 'slug',
						esc_html__( 'Count', 'basel-child' ) => 'count',
						esc_html__( 'Category order', 'basel-child' ) => 'order',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'basel-child' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'basel-child' )
				)
			),
        ) );
        
        //Product filter attribute
        vc_map( array(
			'name' => esc_html__( 'Palmer Filter Attribute', 'basel-child'),
			'base' => 'newpalmer_filters_attribute',
			'as_child' => array( 'only' => 'newpalmer_product_filters' ),
			'content_element' => true,
			'category' => esc_html__( 'Palmer Search', 'basel-child' ),
			'icon' => BASEL_ASSETS . '/images/vc-icon/product-filter.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Filter Placholder', 'basel-child' ),
					'param_name' => 'filter_placeholder',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Select Attribute', 'basel-child' ),
					'param_name' => 'attribute',
					'value' => $attribute_array
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'basel-child' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'basel-child' )
				)
			),
        ) );
        
        //Product filter price
        vc_map( array(
			'name' => esc_html__( 'Palmer Filter Price', 'basel-child'),
			'base' => 'newpalmer_filters_price_slider',
			'as_child' => array( 'only' => 'newpalmer_product_filters' ),
			'content_element' => true,
			'category' => esc_html__( 'Palmer Search', 'basel-child' ),
			'icon' => BASEL_ASSETS . '/images/vc-icon/menu-price.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price Placeholder', 'basel-child' ),
					'param_name' => 'price_placeholder',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'basel-child' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'basel-child' )
				)
			),
		) );

		 //Product Search
		 vc_map( array(
			'name' => esc_html__( 'Palmer Search', 'basel-child'),
			'base' => 'newpalmer_product_search',
			'as_child' => array( 'only' => 'newpalmer_product_filters' ),
			'content_element' => true,
			'category' => esc_html__( 'Palmer Search', 'basel-child' ),
			'icon' => 'icon-wpb-wp',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Placeholder', 'basel-child' ),
					'param_name' => 'cat_placeholder',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'basel-child' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'basel-child' )
				)
			),
        ) );
        
        // A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ){
			class WPBakeryShortCode_newpalmer_product_filters extends WPBakeryShortCodesContainer {}
		}

		if ( class_exists( 'WPBakeryShortCode' ) ){
			class WPBakeryShortCode_newpalmer_filter_categories extends WPBakeryShortCode {}
		}

		if ( class_exists( 'WPBakeryShortCode' ) ){
			class WPBakeryShortCode_newpalmer_filters_attribute extends WPBakeryShortCode {}
		}

		if ( class_exists( 'WPBakeryShortCode' ) ){
			class WPBakeryShortCode_newpalmer_filters_price_slider extends WPBakeryShortCode {}
		}

		if ( class_exists( 'WPBakeryShortCode' ) ){
			class WPBakeryShortCode_newpalmer_product_search extends WPBakeryShortCode {}
		}
    }

add_action( 'vc_before_init', 'palmer_search_product_filters' );


function newpalmer_view_sc( $atts , $content ){
	   global $wp;
        $classes = '';
		extract( shortcode_atts( array(
			'btn_text' => '',
			'css' => '',
			'el_class' => '',
		), $atts) );
		
		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$classes .= ' ' . vc_shortcode_custom_css_class( $css );
		}
		$classes .= ( $el_class ) ? ' ' . $el_class : '';
		$form_action = wc_get_page_permalink( 'shop' );
		$output = '<div id="homebanner" class="homebanner">
		<div class="banner-container">
			<div class="homebanner-content">';
		
		$output .='<form action="'.$form_action.'" class="bannerform' . esc_attr( $classes ) . '" method="GET">';
		$output .= do_shortcode( $content );
		$searchimg = get_stylesheet_directory_uri().'/assets/searchicon.png';
	    $output .= '<div class="form-group hasbtn"><button type="submit" class="btn site-btn"><img src="'.$searchimg.'">' . esc_html__( $btn_text, 'basel-child' ) . '</button></div>';
		$output .= '</form></div>
			</div>
		</div>';

		return $output;
}

add_shortcode('newpalmer_product_filters', 'newpalmer_view_sc'  );

function newpalmer_view_cat( $atts , $content ){

	   global $wp_query, $post;
		$classes = '';
		extract( shortcode_atts( array(
			'cat_placeholder' => '',
			'order_by' => 'name',
			'el_class' => '',
		), $atts) );

		$classes .= ( $el_class ) ? ' ' . $el_class : '';
		$myterms = get_terms( array(
		    'taxonomy' => 'product_cat',
		    'hide_empty' => true,
			'orderby' =>  $order_by 
		) );
		$cat_placeholder = ( $cat_placeholder ) ? $cat_placeholder : esc_html__( 'Categories', 'basel-child' );
		$output = '<div class="form-group haslradius '.$classes.'"><select class="velg cat_selection" data-placeholder="'.$cat_placeholder.'">';
		$output .= '<option value="">'.$cat_placeholder.'</option>';
		foreach($myterms as $term){
	        $term_id   = $term->term_id;
	        $term_name = $term->name;
	        $term_slug = $term->slug;
	        $output .="<option value='".$term_slug."'>".$term_name."</option>";
	    }
		$output .= '</select></div>';
    return $output;
}

add_shortcode('newpalmer_filter_categories', 'newpalmer_view_cat'  );

function newpalmer_view_attr( $atts , $content ){

	   global $wp_query, $post;
		$classes = '';
		extract( shortcode_atts( array(
			'filter_placeholder' => '',
			'attribute' => '',
			'order_by' => 'name',
			'el_class' => '',
		), $atts) );

		$classes .= ( $el_class ) ? ' ' . $el_class : '';
		$pa_tax_list = get_terms( array(
                    'taxonomy' => 'pa_'.$attribute,
                    'orderby' => 'name',
                    'order' => 'asc',
                    'hide_empty' => true,
                ) );
		$filter_placeholder = ( $filter_placeholder ) ? $filter_placeholder : esc_html__( 'Attributes', 'basel-child' );
		$output = '<div class="form-group '.$classes.'"><select class="velg filter_'.$attribute.'" data-placeholder="'.$filter_placeholder.'">';
		$output .= '<option value="">'.$filter_placeholder.'</option>';
		foreach($pa_tax_list as $tax_term){
	        $tax_term_id   = $tax_term->term_id;
	        $tax_term_name = $tax_term->name;
	        $tax_slug = $tax_term->slug;
	        $output .="<option value='".$tax_slug."'>".$tax_term_name."</option>";
	    }
		$output .= '</select></div>';
    return $output;
}
add_shortcode('newpalmer_filters_attribute', 'newpalmer_view_attr'  );

function newpalmer_view_price( $atts , $content ){
	   $classes = '';
		extract( shortcode_atts( array(
			'price_placeholder' => '',
			'el_class' => '',
		), $atts) );
		$classes .= ( $el_class ) ? ' ' . $el_class : '';
		$price_placeholder = ( $price_placeholder ) ? $price_placeholder : esc_html__( 'Price', 'basel-child' );
		$output = '<div class="form-group noborder '.$classes.'"><select class="velg price_selection" data-placeholder="'.$price_placeholder.'">';
		$output .= '<option value="">'.$price_placeholder.'</option>';
		$output .= '<option value="0-150" data-min="0" data-max="150">Inntil 150kr</option>';
		$output .= '<option value="150-250" data-min="150" data-max="250">150 - 250kr</option>';
		$output .= '<option value="250-400" data-min="250" data-max="400">250 - 400kr</option>';
		$output .= '<option value="over-400" data-min="400" data-max="">over 400kr</option>';
		$output .= '</select></div>';
    return $output;
}
add_shortcode('newpalmer_filters_price_slider','newpalmer_view_price');

function newpalmer_view_searchform( $atts , $content ){
	$classes = '';
	 extract( shortcode_atts( array(
		 'search_placeholder' => '',
		 'el_class' => '',
	 ), $atts) );
	 $classes .= ( $el_class ) ? ' ' . $el_class : '';
	 $search_placeholder = ( $search_placeholder ) ? $search_placeholder : 'Søk etter produkter';
	 $output = '<div class="form-group noborder '.$classes.'">';
	 $output .= '<input type="text" class="search-field" name="s" placeholder="'.$search_placeholder.'" value="'.the_search_query().'">';
	 $output .= '<i class="fa fa-search searchicon"></i>';
	 $output .= '</div>';
 return $output;
}
add_shortcode('newpalmer_product_search','newpalmer_view_searchform');


