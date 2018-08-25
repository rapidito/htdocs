<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Menu price elements map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_menu_price' ) ) {
	function woodmart_vc_map_menu_price() {
		vc_map( array(
			'name' => esc_html__( 'Menu price', 'woodmart' ),
			'base' => 'woodmart_menu_price',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Showcase your menu', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/menu-price.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Description', 'woodmart' ),
					'param_name' => 'description',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price', 'woodmart' ),
					'param_name' => 'price',
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'img_id',
					'value' => '',
					'description' => esc_html__( 'Select images from media library.', 'woodmart' )
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this box to have a link.', 'woodmart' )
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_menu_price' );
}