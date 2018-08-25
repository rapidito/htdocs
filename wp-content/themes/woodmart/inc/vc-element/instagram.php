<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Instagram element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_instagram' ) ) {
	function woodmart_vc_map_instagram() {
		vc_map( array(
			'name' => esc_html__( 'Instagram', 'woodmart' ),
			'base' => 'woodmart_instagram',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Instagram photos', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/instagram.svg',
			'params' =>  woodmart_get_instagram_params()
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_instagram' );
}

if( ! function_exists( 'woodmart_get_instagram_params' ) ) {
	function woodmart_get_instagram_params() {
		return apply_filters( 'woodmart_get_instagram_params', array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Username', 'woodmart' ),
				'param_name' => 'username',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Number of photos', 'woodmart' ),
				'param_name' => 'number',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Photo size', 'woodmart' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Thumbnail', 'woodmart' ) => 'thumbnail',
					esc_html__( 'Large', 'woodmart' ) => 'large'
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open link in', 'woodmart' ),
				'param_name' => 'target',
				'value' => array(
					esc_html__( 'Current window (_self)', 'woodmart' ) => '_self',
					esc_html__( 'New window (_blank)', 'woodmart' ) => '_blank'
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Link text', 'woodmart' ),
				'param_name' => 'link',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Design', 'woodmart' ),
				'param_name' => 'design',
				'skip_in' => 'widget',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Grid', 'woodmart' ) => 'grid',
					esc_html__( 'Slider', 'woodmart' ) => 'slider'
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Photos per row', 'woodmart' ),
				'param_name' => 'per_row',
				'skip_in' => 'widget',
				'description' => esc_html__('Number of photos per row for grid design or items in slider per view.', 'woodmart' ),
				'value' => array(
					1,2,3,4,5,6,7,8,9,10,11,12
				)
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Instagram text', 'woodmart' ),
				'param_name' => 'content',
				'skip_in' => 'widget',
				'description' => esc_html__( 'Add here few words about your instagram profile.', 'woodmart' )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add spaces between photos', 'woodmart' ),
				'skip_in' => 'widget',
				'param_name' => 'spacing',
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Rounded corners for images', 'woodmart' ),
				'skip_in' => 'widget',
				'param_name' => 'rounded',
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide likes and comments', 'woodmart' ),
				'skip_in' => 'widget',
				'param_name' => 'hide_mask',
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
				'param_name' => 'hide_pagination_control',
				'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				'skip_in' => 'widget',
				'dependency' => array(
					'element' => 'design',
					'value' => array( 'slider' )
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
				'param_name' => 'hide_prev_next_buttons',
				'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				'skip_in' => 'widget',
				'dependency' => array(
					'element' => 'design',
					'value' => array( 'slider' )
				),
			)
		) );
	}
}