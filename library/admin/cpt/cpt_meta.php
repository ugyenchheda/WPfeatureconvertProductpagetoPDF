<?php

/* product Post metabox
-------------------------------------------------*/
add_action('cmb2_admin_init', 'product_meta');
function product_meta()
{

	$prefix = 'product_';
	$product_meta = new_cmb2_box(array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__('product Additional Meta', 'palmer'),
		'object_types'  => array('product'), // Post type

	));

	$product_meta->add_field(array(
		'name'       => esc_html__('karakteristikk', 'palmer'),
		'id'         => 'karakteristikk',
		'attributes'  => array('placeholder' => 'karakteristikk'),
		'type'       => 'text',
	));

	$product_meta->add_field(array(
		'name'       => esc_html__('produksjonsmetode', 'palmer'),
		'id'         => 'produksjonsmetode',
		'attributes'  => array('placeholder' => 'produksjonsmetode'),
		'type'       => 'text',
	));

	$product_meta->add_field(array(
		'name'       => esc_html__('matretter', 'palmer'),
		'id'         => 'matretter',
		'attributes'  => array('placeholder' => 'matretter'),
		'type'       => 'text',
	));
}

//add field for post
add_action('cmb2_admin_init', 'add_postmeta');
function add_postmeta(){
		$prefix = 'post_';
		$post_meta = new_cmb2_box(array(
			'id'            => $prefix . 'metabox',
			'title'         => esc_html__('Post Additional Meta', 'palmer'),
			'object_types'  => array('post'), // Post type

		));

		$post_meta->add_field(array(
			'name'       => esc_html__('Dato', 'palmer'),
			'id'         => 'dato',
			'attributes'  => array('placeholder' => 'dato'),
			'type'       => 'text_date',
		));
}


//producers taxonomy meta//

add_action( 'cmb2_admin_init', 'palmer_producer_taxmeta' ); 
/** 
 * Hook in and add a metabox to add fields to taxonomy terms 
 */ 
function palmer_producer_taxmeta() { 
	$prefix = 'palmer_'; 
 
	/** 
	 * Metabox to add fields to categories and tags 
	 */ 
	$producer_term = new_cmb2_box( array( 
		'id'               => $prefix . 'edit', 
		'title'            => esc_html__( 'Category Metabox', 'palmer' ), // Doesn't output for term boxes 
		'object_types'     => array( 'term' ), // Tells palmer to use term_meta vs post_meta 
		'taxonomies'       => array( 'producer' ), // Tells palmer which taxonomies should have these fields 
		// 'new_term_section' => true, // Will display in the "Add New Category" section 
	) ); 
 
	$producer_term->add_field( array( 
		'name'     => esc_html__( 'Extra Info', 'palmer' ), 
		// 'desc'     => esc_html__( 'field description (optional)', 'palmer' ), 
		'id'       => $prefix . 'extra_info', 
		'type'     => 'title', 
		'on_front' => false, 
	) ); 
 
	$producer_term->add_field( array( 
		'name' => esc_html__( 'Producer Logo', 'palmer' ), 
		'desc' => esc_html__( 'Add logo for producer from here', 'palmer' ), 
		'id'   => $prefix . 'producer_logo', 
		'type' => 'file', 
	) );
} 
?>