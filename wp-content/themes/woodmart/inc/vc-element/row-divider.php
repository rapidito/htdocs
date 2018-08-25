<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Section divider element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_row_divider' ) ) {
	function woodmart_vc_map_row_divider() {
		vc_map( array(
			'name' => esc_html__( 'Section divider', 'woodmart'),
			'base' => 'woodmart_row_divider',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Divider for sections', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/section-divider.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Position', 'woodmart' ),
					'param_name' => 'position',
					'value' => array(
						esc_html__( 'Top', 'woodmart' ) => 'top',
						esc_html__( 'Bottom', 'woodmart' ) => 'bottom'
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Overlap', 'woodmart' ),
					'param_name' => 'content_overlap',
					'value' => array( esc_html__( 'Enable', 'woodmart' ) => 'enable' )
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Color', 'woodmart' ),
					'param_name' => 'color'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Waves Small', 'woodmart' ) => 'waves-small',
						esc_html__( 'Waves Wide', 'woodmart' ) => 'waves-wide',
						esc_html__( 'Curved Line', 'woodmart' ) => 'curved-line',
						esc_html__( 'Triangle', 'woodmart' ) => 'triangle',
						esc_html__( 'Clouds', 'woodmart' ) => 'clouds',
						esc_html__( 'Diagonal Right', 'woodmart' ) => 'diagonal-right',
						esc_html__( 'Diagonal Left', 'woodmart' ) => 'diagonal-left',
						esc_html__( 'Half Circle', 'woodmart' ) => 'half-circle',
						esc_html__( 'Paint Stroke', 'woodmart' ) => 'paint-stroke'
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Custom height', 'woodmart' ),
					'param_name' => 'custom_height',
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'curved-line', 'diagonal-right', 'half-circle', 'diagonal-left' )
					),
					'description' => esc_html__( 'Enter divider height (Note: CSS measurement units allowed).', 'woodmart' )
				),
				
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			),
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_row_divider' );
}