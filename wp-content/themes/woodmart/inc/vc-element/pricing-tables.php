<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Pricing tables elements map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_pricing_tables' ) ) {
	function woodmart_vc_map_pricing_tables() {
		vc_map( array(
			'name' => esc_html__( 'Pricing tables', 'woodmart' ),
			'base' => 'pricing_tables',
			'as_parent' => array( 'only' => 'pricing_plan' ),
			'content_element' => true,
			'show_settings_on_create' => false,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Show your pricing plans', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/pricing-tables.svg',
			'params' => array(
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
			'name' => esc_html__( 'Price plan', 'woodmart' ),
			'base' => 'pricing_plan',
			'as_child' => array( 'only' => 'pricing_tables' ),
			'content_element' => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Price option', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/price-plan.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Pricing plan name', 'woodmart' ),
					'param_name' => 'name',
					'value' => ''
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price value', 'woodmart' ),
					'param_name' => 'price_value',
					'value' => ''
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price suffix', 'woodmart' ),
					'param_name' => 'price_suffix',
					'value' => 'per month',
					'description' => esc_html__( 'For example: per month', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price currency', 'woodmart' ),
					'param_name' => 'currency',
					'value' => '',
					'description' => esc_html__( 'For example: $', 'woodmart' )
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Featured list', 'woodmart' ),
					'param_name' => 'features_list',
					'description' => esc_html__( 'Start each feature text from a new line', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button type', 'woodmart' ),
					'param_name' => 'button_type',
					'value' => array(
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
						esc_html__( 'Product add to cart', 'woodmart' ) => 'product'
					),
					'description' => esc_html__( 'Set your custom link for button or allow users to add some product to cart', 'woodmart' )
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Button link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this box to have a link.', 'woodmart' ),
					'dependency' => array(
						'element' => 'button_type',
						'value' => array( 'custom' )
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Button label', 'woodmart' ),
					'param_name' => 'button_label',
					'value' => '',
					'dependency' => array(
						'element' => 'button_type',
						'value' => array( 'custom' )
					)
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Select identificator', 'woodmart' ),
					'param_name' => 'id',
					'description' => esc_html__( 'Input product ID or product SKU or product title to see suggestions', 'woodmart' ),
					'dependency' => array(
						'element' => 'button_type',
						'value' => array( 'product' )
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label text', 'woodmart' ),
					'param_name' => 'label',
					'value' => '',
					'description' => esc_html__( 'For example: Best option!', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Label color', 'woodmart' ),
					'param_name' => 'label_color',
					'value' => array(
						'' => '',
						esc_html__( 'Red', 'woodmart' ) => 'red',
						esc_html__( 'Green', 'woodmart' ) => 'green',
						esc_html__( 'Blue', 'woodmart' ) => 'blue',
						esc_html__( 'Yellow', 'woodmart' ) => 'yellow',
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Best option', 'woodmart' ),
					'param_name' => 'best_option',
					'description' => esc_html__( 'If "YES" this table will be highlighted', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'With background image', 'woodmart' ),
					'param_name' => 'with_bg_image',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'bg_image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' ),
					'dependency' => array(
						'element' => 'with_bg_image',
						'value' => array( 'yes' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						'' => '',
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Alternate', 'woodmart' ) => 'alt'
					)
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
		// Necessary hooks for blog autocomplete fields
		add_filter( 'vc_autocomplete_pricing_plan_id_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_pricing_plan_id_render', 'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_pricing_tables' );
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if( class_exists( 'WPBakeryShortCodesContainer' ) ){
    class WPBakeryShortCode_pricing_tables extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_pricing_plan extends WPBakeryShortCode {

    }
}