<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
*  AJAX search element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_ajax_search' ) ) {
	function woodmart_vc_map_ajax_search() {
		vc_map( array(
			'name' => esc_html__( 'AJAX Search', 'woodmart' ),
			'description' => esc_html__( 'Shows AJAX search form', 'woodmart' ),
			'base' => 'woodmart_ajax_search',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/ajax-search.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number of products to show', 'woodmart' ),
					'param_name' => 'number',
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show price', 'woodmart' ),
					'param_name' => 'price',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 ),
					'std' => 1
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show thumbnail', 'woodmart' ),
					'param_name' => 'thumbnail',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 ),
					'std' => 1
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show category', 'woodmart' ),
					'param_name' => 'category',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 ),
					'std' => 1
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Search post type', 'woodmart'), 
					'param_name' => 'search_post_type',
					'value' => array(
						esc_html__( 'Product', 'woodmart' ) => 'product',
						esc_html__( 'Post', 'woodmart' ) => 'post',
						esc_html__( 'Portfolio', 'woodmart' ) => 'portfolio',
					)
				),
				woodmart_get_color_scheme_param(),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'woodmart' )
				),
			),
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_ajax_search' );
}