<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Images gallery element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_gallery' ) ) {
	function woodmart_vc_map_gallery() {
		vc_map( array(
			'name' => esc_html__( 'Images gallery', 'woodmart' ),
			'base' => 'woodmart_gallery',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Images grid/carousel', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/images-gallery.svg',
			'params' => array(
				array(
					'type' => 'attach_images',
					'heading' => esc_html__( 'Images', 'woodmart' ),
					'param_name' => 'images',
					'value' => '',
					'description' => esc_html__( 'Select images from media library.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'View', 'woodmart' ),
					'value' => 4,
					'param_name' => 'view',
					'save_always' => true,
					'value' => array(
						esc_html__( 'Default grid', 'woodmart' ) => 'grid',
						esc_html__( 'Masonry grid', 'woodmart' ) => 'masonry',
						esc_html__( 'Carousel', 'woodmart' ) => 'carousel',
						esc_html__( 'Justified gallery', 'woodmart' ) => 'justified',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'woodmart' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Space between images', 'woodmart' ),
					'param_name' => 'spacing',
					'value' => array(
						0, 2, 6, 10, 20, 30
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Center mode', 'woodmart' ),
					'param_name' => 'center_mode',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'value' => 3,
					'param_name' => 'columns',
					'save_always' => true,
					'description' => esc_html__( 'How much columns grid', 'woodmart' ),
					'value' => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'6' => 6,
					),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'grid', 'masonry' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'On click action', 'woodmart' ),
					'param_name' => 'on_click',
					'value' => array(
						'' => '',
						esc_html__( 'Lightbox', 'woodmart' ) => 'lightbox',
						esc_html__( 'Custom link', 'woodmart' ) => 'links',
						esc_html__( 'None', 'woodmart' ) => 'none'
					)
				),
				array(
					'type' => 'exploded_textarea_safe',
					'heading' => esc_html__( 'Custom links', 'woodmart' ),
					'param_name' => 'custom_links',
					'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'woodmart' ),
					'dependency' => array(
						'element' => 'on_click',
						'value' => array( 'links' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Open in new tab', 'woodmart' ),
					'save_always' => true,
					'param_name' => 'target_blank',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'default' => 'yes',
					'dependency' => array(
						'element' => 'on_click',
						'value' => array( 'links' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show captions on in lightbox', 'woodmart' ),
					'save_always' => true,
					'param_name' => 'caption',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'default' => 'yes'
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_gallery' );
}