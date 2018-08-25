<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Extra menu list element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_extra_menu' ) ) {
	function woodmart_vc_map_extra_menu() {
		vc_map( array(
			'name' => esc_html__( 'Extra menu list', 'woodmart' ),
			'base' => 'extra_menu',
			'as_parent' => array( 'only' => 'extra_menu_list' ),
			'content_element' => true,
			'show_settings_on_create' => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Create a menu list for your mega menu dropdown', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/extra-menu-list.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'value' => '',
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this parent menu item to have a link.', 'woodmart' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label text (optional)', 'woodmart' ),
					'param_name' => 'label_text',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Label (optional)', 'woodmart' ),
					'param_name' => 'label',
					'value' => array(
						esc_html__( 'Primary Color', 'woodmart' ) => 'primary',
						esc_html__( 'Secondary', 'woodmart' ) => 'secondary',
						esc_html__( 'Red', 'woodmart' ) => 'red',
						esc_html__( 'Green', 'woodmart' ) => 'green',
						esc_html__( 'Blue', 'woodmart' ) => 'blue',
						esc_html__( 'Orange', 'woodmart' ) => 'orange',
						esc_html__( 'Grey', 'woodmart' ) => 'grey',
						esc_html__( 'Black', 'woodmart' ) => 'black',
						esc_html__( 'White', 'woodmart' ) => 'white',
					),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			),
		    'js_view' => 'VcColumnView'
		) );

		vc_map( array(
			'name' => esc_html__( 'Extra menu list item', 'woodmart' ),
			'base' => 'extra_menu_list',
			'as_child' => array( 'only' => 'extra_menu' ),
			'content_element' => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'A link for your extra menu list', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/extra-menu-list-item.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'value' => '',
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this parent menu item to have a link.', 'woodmart' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label text (optional)', 'woodmart' ),
					'param_name' => 'label_text',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Label (optional)', 'woodmart' ),
					'param_name' => 'label',
					'value' => array(
						esc_html__( 'Primary Color', 'woodmart' ) => 'primary',
						esc_html__( 'Secondary', 'woodmart' ) => 'secondary',
						esc_html__( 'Red', 'woodmart' ) => 'red',
						esc_html__( 'Green', 'woodmart' ) => 'green',
						esc_html__( 'Blue', 'woodmart' ) => 'blue',
						esc_html__( 'Orange', 'woodmart' ) => 'orange',
						esc_html__( 'grey', 'woodmart' ) => 'grey',
						esc_html__( 'Black', 'woodmart' ) => 'black',
						esc_html__( 'White', 'woodmart' ) => 'white',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_extra_menu' );
}

if( class_exists( 'WPBakeryShortCodesContainer' ) ){
    class WPBakeryShortCode_extra_menu extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_extra_menu_list extends WPBakeryShortCode {

    }
}