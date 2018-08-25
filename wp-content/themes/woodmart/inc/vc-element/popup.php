<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Popup element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_popup' ) ) {
	function woodmart_vc_map_popup() {
		$woodmart_popup_params = vc_map_integrate_shortcode( woodmart_get_woodmart_button_shortcode_args(), '', 'Button', array(
			'exclude' => array(
				'link',
				'el_class'
			),
		) );

		vc_map( array(
			'name' => esc_html__( 'Popup', 'woodmart' ),
			'base' => 'woodmart_popup',
			'content_element' => true,
			'as_parent' => array( 'except' => 'testimonial' ),
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Button that shows a popup on click', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/popup.svg',
			'params' => array_merge( array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'ID', 'woodmart' ),
					'param_name' => 'id',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Width', 'woodmart' ),
					'param_name' => 'width',
					'description' => esc_html__( 'Popup width in pixels. For ex.: 800', 'woodmart' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			), $woodmart_popup_params ),
		    'js_view' => 'VcColumnView',
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_popup' );
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if( class_exists( 'WPBakeryShortCodesContainer' ) ){
    class WPBakeryShortCode_woodmart_popup extends WPBakeryShortCodesContainer {

    }
}