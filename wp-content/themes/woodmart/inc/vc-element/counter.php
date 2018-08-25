<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Animated counter element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_animated_counter' ) ) {
	function woodmart_vc_map_animated_counter() {
		vc_map( array(
			'name' => esc_html__( 'Animated Counter', 'woodmart' ),
			'description' => esc_html__( 'Shows animated counter with label', 'woodmart' ),
			'base' => 'woodmart_counter',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/animated-counter.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'woodmart' ),
					'param_name' => 'label'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Actual value', 'woodmart' ),
					'param_name' => 'value',
					'description' => esc_html__('Our final point. For ex.: 95', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra large', 'woodmart' ) => 'extra-large'
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Countdown number font weight', 'woodmart' ),
					'param_name' => 'font_weight',
					'value' => array(
						'',100,200,300,400,500,600,700,800,900
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right'
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Color scheme', 'woodmart' ),
					'param_name' => 'color_scheme',
					'value' => array(
						'' => '',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
						esc_html__( 'Custom', 'woodmart' ) => 'custom'
					)
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom color', 'woodmart' ),
					'param_name' => 'color',
					'dependency' => array(
						'element' => 'color_scheme',
						'value' => array( 'custom' )
					) 
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_animated_counter' );
}