<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Promo Banner element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_responsive_text_block' ) ) {
	function woodmart_vc_map_responsive_text_block() {
		vc_map( array(
			'name' => esc_html__( 'Responsive text block', 'woodmart' ),
			'base' => 'woodmart_responsive_text_block',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'A block of text with responsive text sizes', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/text-blox-res.svg',
			'params' => array(
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => esc_html__( 'Text', 'woodmart' ),
					'param_name' => 'content'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text font', 'woodmart' ),
					'param_name' => 'font',
					'value' => array(
						esc_html__( 'Heading', 'woodmart' ) => 'primary',
						esc_html__( 'Text', 'woodmart' ) => 'text',
						esc_html__( 'Alternative', 'woodmart' ) => 'alt'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Font size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Medium', 'woodmart' ) => 'medium',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
						esc_html__( 'Custom', 'woodmart' ) => 'custom'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Font weight', 'woodmart' ),
					'param_name' => 'font_weight',
					'value' => array(
						'',100,200,300,400,500,600,700,800,900
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Desktop text size ( > 1024px )', 'woodmart' ),
					'param_name' => 'desktop_text_size',
					'description' => esc_html__( 'Only number without px.', 'woodmart' ),
					'group' => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'size',
						'value' => array( 'custom' )
					) 
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Tablet text size ( < 1024px )', 'woodmart' ),
					'param_name' => 'tablet_text_size',
					'description' => esc_html__( 'Only number without px.', 'woodmart' ),
					'group' => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'size',
						'value' => array( 'custom' )
					) 	
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Mobile text size ( < 767px )', 'woodmart' ),
					'param_name' => 'mobile_text_size',
					'description' => esc_html__( 'Only number without px.', 'woodmart' ),
					'group' => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'size',
						'value' => array( 'custom' )
					) 
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text width', 'woodmart' ),
					'param_name' => 'content_width',
					'value' => array(
						'100%' => '100',
						'90%' => '90',
						'80%' => '80',
						'70%' => '70',
						'60%' => '60',
						'50%' => '50',
						'40%' => '40',
						'30%' => '30',
						'20%' => '20',
						'10%' => '10'
					)
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
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom color', 'woodmart' ),
					'param_name' => 'color',
					'dependency' => array(
						'element' => 'color_scheme',
						'value' => array( 'custom' )
					) 
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
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
	add_action( 'vc_before_init', 'woodmart_vc_map_responsive_text_block' );
}