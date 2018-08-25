<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Testimonials element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_testimonials' ) ) {
	function woodmart_vc_map_testimonials() {
		vc_map( array(
			'name' => esc_html__( 'Testimonials', 'woodmart' ),
			'base' => 'testimonials',
			'as_parent' => array( 'only' => 'testimonial' ),
			'content_element' => true,
			'show_settings_on_create' => false,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'User testimonials slider or grid', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/testimonials.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'value' => ''
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Slider', 'woodmart' ) => 'slider',
						esc_html__( 'Grid', 'woodmart' ) => 'grid'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Standard', 'woodmart' ) => 'standard',
						esc_html__( 'Boxed', 'woodmart' ) => 'boxed'
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
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text size', 'woodmart' ),
					'param_name' => 'text_size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Medium', 'woodmart' ) => 'medium',
						esc_html__( 'Large', 'woodmart' ) => 'large'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'param_name' => 'columns',
					'value' => array(
						1,2,3,4,5,6
					),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' )
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' )
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' )
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'woodmart' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' )
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' )
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' )
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Center mode', 'woodmart' ),
					'group' => 'Slider',
					'param_name' => 'center_mode',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' )
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		    'js_view' => 'VcColumnView'
		) );

		vc_map( array(
			'name' => esc_html__( 'Testimonial', 'woodmart' ),
			'base' => 'testimonial',
			'class' => '',
			'as_child' => array( 'only' => 'testimonials' ),
			'content_element' => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'User testimonial', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/testimonials.svg',
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
					'param_name' => 'title',
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
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => esc_html__( 'Text', 'woodmart' ),
					'param_name' => 'content'
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
	add_action( 'vc_before_init', 'woodmart_vc_map_testimonials' );
}

if( class_exists( 'WPBakeryShortCodesContainer' ) ){
    class WPBakeryShortCode_testimonials extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_testimonial extends WPBakeryShortCode {

    }
}