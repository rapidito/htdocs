<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Twitter element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_twitter' ) ) {
	function woodmart_vc_map_twitter() {
		vc_map( array(
			'name' => esc_html__( 'Twitter', 'woodmart' ),
			'base' => 'woodmart_twitter',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Shows tweets from any twitter account', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/twitter.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Twitter Name (without @ symbol)', 'woodmart' ),
					'param_name' => 'name',
					'value' => 'Twitter'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number of Tweets', 'woodmart' ),
					'param_name' => 'num_tweets',
					'value' => 5
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Consumer Key', 'woodmart' ),
					'param_name' => 'consumer_key'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Consumer Secret', 'woodmart' ),
					'param_name' => 'consumer_secret'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Access Token', 'woodmart' ),
					'param_name' => 'access_token'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Access Token Secret', 'woodmart' ),
					'param_name' => 'accesstoken_secret'
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show your avatar image', 'woodmart' ),
					'param_name' => 'show_avatar',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Size of Avatar (default: 48)', 'woodmart' ),
					'param_name' => 'avatar_size'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Exclude Replies', 'woodmart' ),
					'param_name' => 'exclude_replies',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				)
			)
		) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_twitter' );
}