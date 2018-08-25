<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Mega Menu widget element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_mega_menu' ) ) {
	function woodmart_vc_map_mega_menu() {
		vc_map( array(
			'name' => esc_html__( 'Mega Menu widget', 'woodmart' ),
			'base' => 'woodmart_mega_menu',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Categories mega menu widget', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/mega-menu-widget.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Choose Menu', 'woodmart' ),
					'param_name' => 'nav_menu',
					'value' => woodmart_get_menus_array()
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Title Color', 'woodmart' ),
					'param_name' => 'color'
				),
				woodmart_get_color_scheme_param(),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_mega_menu' );
}