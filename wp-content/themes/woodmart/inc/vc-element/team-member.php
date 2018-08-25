<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Team Member element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_team_member' ) ) {
	function woodmart_vc_map_team_member() {
		vc_map( array(
			'name' => esc_html__( 'Team Member', 'woodmart' ),
			'base' => 'team_member',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Display information about some person', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/team-member.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Name', 'woodmart' ),
					'param_name' => 'name',
					'value' => '',
					'description' => esc_html__( 'User name', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'position',
					'value' => '',
					'description' => esc_html__( 'User title', 'woodmart' )
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'User Avatar', 'woodmart' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' ) => 'right'
					)
				),
				woodmart_get_color_scheme_param(),
				array(
					'type' => 'textarea_html',
					'heading' => esc_html__( 'Text', 'woodmart' ),
					'param_name' => 'content',
					'description' => esc_html__( 'You can add some member bio here.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Facebook link', 'woodmart' ),
					'param_name' => 'facebook'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Twitter link', 'woodmart' ),
					'param_name' => 'twitter'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Google+ link', 'woodmart' ),
					'param_name' => 'google_plus'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Linkedin link', 'woodmart' ),
					'param_name' => 'linkedin'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Skype link', 'woodmart' ),
					'param_name' => 'skype'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Instagram link', 'woodmart' ),
					'param_name' => 'instagram'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'With hover', 'woodmart' ) => 'hover',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Social buttons size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'With hover', 'woodmart' ) => 'hover'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Social buttons style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
						esc_html__( 'Colored', 'woodmart' ) => 'colored',
						esc_html__( 'Colored alternative', 'woodmart' ) => 'colored-alt',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Social buttons form', 'woodmart' ),
					'param_name' => 'form',
					'value' => array(
						esc_html__( 'Circle', 'woodmart' ) => 'circle',
						esc_html__( 'Square', 'woodmart' ) => 'square'
					)
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_team_member' );
}