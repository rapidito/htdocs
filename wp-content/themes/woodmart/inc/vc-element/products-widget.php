<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
*  WC products widget element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_products_widget' ) ) {
	function woodmart_vc_map_products_widget() {
		vc_map( array(
			'name' => esc_html__( 'WC products widget', 'woodmart' ),
			'base' => 'woodmart_shortcode_products_widget',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Categories mega menu widget', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/wc-product-widget.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Number of products to show', 'woodmart' ),
					'param_name' => 'number',
					'value' => array(
						1,2,3,4,5,6,7
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Show', 'woodmart' ),
					'param_name' => 'show',
					'value' => array(
						esc_html__( 'All Products', 'woodmart' ) => '',
						esc_html__( 'Featured Products', 'woodmart' ) => 'featured',
						esc_html__( 'On-sale Products', 'woodmart' ) => 'onsale'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => array(
						esc_html__( 'Date', 'woodmart' ) => 'date',
						esc_html__( 'Price', 'woodmart' ) => 'price',
						esc_html__( 'Random', 'woodmart' ) => 'rand',
						esc_html__( 'Sales', 'woodmart' ) => 'sales'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order', 'woodmart' ),
					'param_name' => 'order',
					'value' => array(
						esc_html__( 'ASC', 'woodmart' ) => 'asc',
						esc_html__( 'DESC', 'woodmart' ) => 'desc'
					)
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Categories', 'woodmart' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						'sortable' => true
					),
					'save_always' => true,
					'description' => esc_html__( 'List of product categories', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide free products', 'woodmart' ),
					'param_name' => 'hide_free',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show hidden products', 'woodmart' ),
					'param_name' => 'show_hidden',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			),
		));

		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_woodmart_shortcode_products_widget_ids_callback', 'woodmart_productCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_woodmart_shortcode_products_widget_ids_render', 'woodmart_productCategoryCategoryRenderByIdExact', 10, 1 );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_products_widget' );
}
