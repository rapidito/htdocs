<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
*  Google Map element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_google_map' ) ) {
	function woodmart_vc_map_google_map() {
		vc_map( array(
			'name' => esc_html__( 'Google Map', 'woodmart' ),
			'description' => esc_html__( 'Shows Google map block', 'woodmart' ),
			'base' => 'woodmart_google_map',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'as_parent' => array( 'except' => 'testimonial' ),
			'content_element' => true,
		    'js_view' => 'VcColumnView',
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/google-maps.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Latitude (required)', 'woodmart' ),
					'param_name' => 'lat',
					'description' => wp_kses( __( 'You can use <a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">this service</a> to get coordinates of your location.', 'woodmart' ), array(
                        'a' => array( 
                            'href' => array(), 
                            'target' => array()
                        )
                    ) )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Longitude (required)', 'woodmart' ),
					'param_name' => 'lon'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Google API key (required)', 'woodmart' ),
					'param_name' => 'google_key',
					'description' => wp_kses( __( 'Obtain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google Map VC element.', 'woodmart' ), array(
                        'a' => array( 
                            'href' => array(), 
                            'target' => array()
                        )
                    ) )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Text on marker', 'woodmart' ),
					'param_name' => 'marker_text'
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Marker icon', 'woodmart' ),
					'param_name' => 'marker_icon'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Zoom', 'woodmart' ),
					'param_name' => 'zoom',
					'description' => 'Zoom level when focus the marker<br> 0 - 19'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Height', 'woodmart' ),
					'param_name' => 'height',
					'description' => 'Default: 400'
				),
				array(
					'type' => 'textarea_raw_html',
					'heading' => esc_html__( 'Styles (JSON)', 'woodmart' ),
					'param_name' => 'style_json',
					'description' => 'Styled maps allow you to customize the presentation of the standard Google base maps, changing the visual display of such elements as roads, parks, and built-up areas.<br>
You can find more Google Maps styles on the website: <a target="_blank" href="http://snazzymaps.com/">Snazzy Maps</a><br>
Just copy JSON code and paste it here<br>
For example:<br>
[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]
					'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Zoom with mouse wheel', 'woodmart' ),
					'param_name' => 'scroll',
					'value' => array(
						'' => '',
						esc_html__( 'Yes', 'woodmart' ) => 'yes',
						esc_html__( 'No', 'woodmart' ) => 'no',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Content on the map vertical position', 'woodmart' ),
					'param_name' => 'content_vertical',
					'value' => array(
						'' => '',
						esc_html__( 'Top', 'woodmart' ) => 'top',
						esc_html__( 'Middle', 'woodmart' ) => 'middle',
						esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Content on the map horizontal position', 'woodmart' ),
					'param_name' => 'content_horizontal',
					'value' => array(
						'' => '',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Content width', 'woodmart' ),
					'param_name' => 'content_width',
					'description' => 'Default: 300'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Map mask', 'woodmart' ),
					'param_name' => 'mask',
					'value' => array(
						'' => '',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
						esc_html__( 'Light', 'woodmart' ) => 'light',
					),
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
	add_action( 'vc_before_init', 'woodmart_vc_map_google_map' );
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if( class_exists( 'WPBakeryShortCodesContainer' ) ){
    class WPBakeryShortCode_woodmart_google_map extends WPBakeryShortCodesContainer {

    }
}