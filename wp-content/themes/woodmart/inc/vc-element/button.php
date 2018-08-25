<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
*  Button element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_shortcode_button' ) ) {
	function woodmart_vc_shortcode_button() {
		vc_map( woodmart_get_woodmart_button_shortcode_args() );
	}
	add_action( 'vc_before_init', 'woodmart_vc_shortcode_button' );
}

if( ! function_exists( 'woodmart_get_woodmart_button_shortcode_args' ) ) {
	function woodmart_get_woodmart_button_shortcode_args() {
		return array(
			'name' => esc_html__( 'Button', 'woodmart' ),
			'base' => 'woodmart_button',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Simple button in different theme styles', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/button.svg',
			'params' => woodmart_get_button_shortcode_params()
		);
	}
}

if( ! function_exists( 'woodmart_get_button_shortcode_params' ) ) {
	function woodmart_get_button_shortcode_params() {
		return apply_filters( 'woodmart_get_button_shortcode_params', array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart' ),
					'param_name' => 'link'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button color', 'woodmart' ),
					'param_name' => 'color',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Primary color', 'woodmart' ) => 'primary',
						esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
						esc_html__( 'Black', 'woodmart' ) => 'black',
						esc_html__( 'White', 'woodmart' ) => 'white',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Link button', 'woodmart' ) => 'link',
						esc_html__( 'Circle', 'woodmart' ) => 'round',
						esc_html__( '3D', 'woodmart' ) => '3d',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button shape', 'woodmart' ),
					'param_name' => 'shape',
					'value' => array(
						esc_html__( 'Rectangle', 'woodmart' ) => 'rectangle',
						esc_html__( 'Circle', 'woodmart' ) => 'round',
						esc_html__( 'Round', 'woodmart' ) => 'semi-round',
					),
					'dependency' => array(
						'element' => 'style',
						'value_not_equal_to' => array( 'round', 'link' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Full width', 'woodmart' ),
					'param_name' => 'full_width',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Button inline', 'woodmart' ),
					'param_name' => 'button_inline',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						'' => '',
						esc_html__( 'left', 'woodmart' ) => 'left',
						esc_html__( 'center', 'woodmart' ) => 'center',
						esc_html__( 'right', 'woodmart' ) => 'right',
					),
					'dependency' => array(
						'element' => 'button_inline',
						'value_not_equal_to' => array( 'yes' ),
					),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Color', 'woodmart' ),
					'param_name' => 'bg_color',
					'group' => esc_html__( 'Custom color', 'woodmart' ),
					'dependency' => array(
						'element' => 'color',
						'value' => array( 'custom' )
					) 
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text color scheme', 'woodmart' ),
					'param_name' => 'color_scheme',
					'group' => esc_html__( 'Custom color', 'woodmart' ),
					'value' => array(
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
					),
					'dependency' => array(
						'element' => 'color',
						'value' => array( 'custom' )
					) 
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Color on hover', 'woodmart' ),
					'param_name' => 'bg_color_hover',
					'group' => esc_html__( 'Custom color', 'woodmart' ),
					'dependency' => array(
						'element' => 'color',
						'value' => array( 'custom' )
					) 
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text color scheme on hover', 'woodmart' ),
					'param_name' => 'color_scheme_hover',
					'group' => esc_html__( 'Custom color', 'woodmart' ),
					'value' => array(
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
					),
					'dependency' => array(
						'element' => 'color',
						'value' => array( 'custom' )
					) 
				),
			)
		);
	}
}