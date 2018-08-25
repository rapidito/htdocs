<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Author area element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_author_area' ) ) {
	function woodmart_vc_map_author_area() {
		vc_map( array(
			'name' => esc_html__( 'Author area', 'woodmart' ),
			'base' => 'author_area',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Widget for author information', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/author-area.svg',
			'params' =>  woodmart_get_author_area_params()
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_author_area' );
}

if( ! function_exists( 'woodmart_get_author_area_params' ) ) {
	function woodmart_get_author_area_params() {
		return apply_filters( 'woodmart_get_author_area_params', array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'woodmart' ),
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
				'type' => 'textfield',
				'heading' => esc_html__( 'Author name', 'woodmart' ),
				'param_name' => 'author_name',
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Author bio', 'woodmart' ),
				'param_name' => 'content',
				'description' => esc_html__( 'Add here few words to your author info.', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text alignment', 'woodmart' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'Align left', 'woodmart' ) => '',
					esc_html__( 'Align right', 'woodmart' ) => 'right',
					esc_html__( 'Align center', 'woodmart' ) => 'center'
				),
				'description' => esc_html__( 'Select image alignment.', 'woodmart' )
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Author link', 'woodmart'),
				'param_name' => 'link',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Link text', 'woodmart'),
				'param_name' => 'link_text',
			),
			woodmart_get_color_scheme_param(),
			( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'woodmart' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
			)
		) );
	}
}