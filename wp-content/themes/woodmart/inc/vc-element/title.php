<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Section title element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_title' ) ) {
	function woodmart_vc_map_title() {
		vc_map( array(
			'name' => esc_html__( 'Section title', 'woodmart' ),
			'base' => 'woodmart_title',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Styled title for sections', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/section-title.svg',
			'params' => array(
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title size', 'woodmart' ),
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
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title color', 'woodmart' ),
					'param_name' => 'color',
					'value' => woodmart_section_title_color_variation()
				),
				woodmart_title_gradient_picker(),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Underline', 'woodmart' ) => 'underlined',
						esc_html__( 'Underline 2', 'woodmart' ) => 'underlined-2',
						esc_html__( 'Shadow', 'woodmart' ) => 'shadow',
						esc_html__( 'With image', 'woodmart' ) => 'image'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title tag', 'woodmart' ),
					'param_name' => 'tag',
					'value' => array(
						'h1','h2','h3','h4','h5','h6','p','div','span'
					),
					'std' => 'h4'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title width', 'woodmart' ),
					'param_name' => 'title_width',
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
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Sub title', 'woodmart' ),
					'group' => esc_html__( 'Subtitle', 'woodmart' ),
					'param_name' => 'subtitle'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Subtitle font', 'woodmart' ),
					'group' => esc_html__( 'Subtitle', 'woodmart' ),
					'param_name' => 'subtitle_font',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Alternative', 'woodmart' ) => 'alt'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Subtitle style', 'woodmart' ),
					'group' => esc_html__( 'Subtitle', 'woodmart' ),
					'param_name' => 'subtitle_style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Background', 'woodmart' ) => 'background'
					)
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Text after title', 'woodmart' ),
					'group' => esc_html__( 'Text', 'woodmart' ),
					'param_name' => 'after_title'
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'image' )
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'image' )
					) 
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				//Custom sizes
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
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'woodmart' )
				),
			),
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_title' );
}
