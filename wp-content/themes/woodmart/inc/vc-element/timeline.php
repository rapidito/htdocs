<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Timeline element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_timeline_shortcode' ) ) {
	function woodmart_vc_map_timeline_shortcode() {
		vc_map( array(
			'name' => esc_html__( 'Timeline', 'woodmart' ),
			'base' => 'woodmart_timeline',
			'as_parent' => array( 'only' => 'woodmart_timeline_item, woodmart_timeline_breakpoint' ),
			'content_element' => true,
			'show_settings_on_create' => true,
			'description' => esc_html__( 'Timeline for the history of your product', 'woodmart' ),
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'icon' => WOODMART_ASSETS . '/images/vc-icon/timeline.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Line style', 'woodmart' ),
					'param_name' => 'line_style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Dashed', 'woodmart' ) => 'dashed'
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Color of line', 'woodmart' ),
					'param_name' => 'line_color'
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Color of dots', 'woodmart' ),
					'param_name' => 'dots_color'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Item style', 'woodmart' ),
					'param_name' => 'item_style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'With shadow', 'woodmart' ) => 'shadow'
					)
				),
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
			'name' => esc_html__( 'Timeline item', 'woodmart'),
			'base' => 'woodmart_timeline_item',
			'as_child' => array( 'only' => 'woodmart_timeline' ),
			'content_element' => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'icon' => WOODMART_ASSETS . '/images/vc-icon/timeline-item.svg',
			'params' => array(
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'heading' => esc_html__( 'Background color ', 'woodmart' ),
					'param_name' => 'color_bg'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Position', 'woodmart' ),
					'param_name' => 'position',
					'value' => array(
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
						esc_html__( 'Full Width', 'woodmart' ) => 'full-width'
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image Primary', 'woodmart' ),
					'group' => esc_html__( 'Primary section', 'woodmart' ),
					'param_name' => 'image_primary',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'js_composer' ),
					'group' => esc_html__( 'Primary section', 'woodmart' ),
					'param_name' => 'img_size_primary',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'js_composer' )
				),
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'heading' => esc_html__( 'Title Primary', 'woodmart' ),
					'param_name' => 'title_primary',
					'group' => esc_html__( 'Primary section', 'woodmart' ),
					'description' => esc_html__( 'Provide the title for primary timeline item.', 'woodmart' )
				),
				array(
					'type' => 'textarea_html',
					'heading' => esc_html__( 'Content Primary', 'woodmart' ),
					'group' => esc_html__( 'Primary section', 'woodmart' ),
					'param_name' => 'content',
					'description' => esc_html__( 'Provide the description for primary timeline item.', 'woodmart' )
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image Secondary', 'woodmart' ),
					'group' => esc_html__( 'Secondary section', 'woodmart' ),
					'param_name' => 'image_secondary',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'js_composer' ),
					'group' => esc_html__( 'Secondary section', 'woodmart' ),
					'param_name' => 'img_size_secondary',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'js_composer' )
				),
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'heading' => esc_html__( 'Title Secondary', 'woodmart' ),
					'group' => esc_html__( 'Secondary section', 'woodmart' ),
					'param_name' => 'title_secondary',
					'description' => esc_html__( 'Provide the title for secondary timeline item.', 'woodmart' )
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Content Secondary', 'woodmart' ),
					'group' => esc_html__( 'Secondary section', 'woodmart' ),
					'param_name' => 'content_secondary',
					'description' => esc_html__( 'Provide the description for secondary timeline item.', 'woodmart' )
				)
			),
		) );

		vc_map( array(
			'name' => esc_html__( 'Timeline breakpoint', 'woodmart'),
			'base' => 'woodmart_timeline_breakpoint',
			'as_child' => array( 'only' => 'woodmart_timeline' ),
			'content_element' => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'icon' => WOODMART_ASSETS . '/images/vc-icon/timeline-breakpoint.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Provide the title for this timeline item.', 'woodmart' )
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'heading' => esc_html__( 'Background color ', 'woodmart' ),
					'param_name' => 'color_bg',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		) );

		// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
		if( class_exists( 'WPBakeryShortCodesContainer' ) ){
			class WPBakeryShortCode_woodmart_timeline extends WPBakeryShortCodesContainer {}
		}

		// Replace Wbc_Inner_Item with your base name from mapping for nested element
		if( class_exists( 'WPBakeryShortCode' ) ){
			class WPBakeryShortCode_woodmart_timeline_item extends WPBakeryShortCode {}
		}
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_timeline_shortcode' );
}