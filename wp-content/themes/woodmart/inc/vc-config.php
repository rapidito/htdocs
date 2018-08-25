<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

if( ! function_exists( 'woodmart_vc_extra_classes' ) ) {

	if( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
		add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'woodmart_vc_extra_classes', 30, 3 );
	}

	function woodmart_vc_extra_classes( $class, $base, $atts ) {
		if( ! empty( $atts['woodmart_color_scheme'] ) ) {
			$class .= ' color-scheme-' . $atts['woodmart_color_scheme'];
		}
		if( ! empty( $atts['text_larger'] ) ) {
			$class .= ' text-larger';
		}
		if( ! empty( $atts['woodmart_sticky_column'] ) ) {
			$class .= ' woodmart-sticky-column';
			woodmart_enqueue_script( 'woodmart-sticky-kit' );
		}
		if( ! empty( $atts['woodmart_parallax'] ) ) {
			$class .= ' woodmart-parallax';
			woodmart_enqueue_script( 'woodmart-parallax' );
		}
		if( ! empty( $atts['woodmart_disable_overflow'] ) ) {
			$class .= ' woodmart-disable-overflow';
		}
		if( ! empty( $atts['woodmart_gradient_switch'] ) && apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$class .= ' woodmart-row-gradient-enable';
		}
		//Bg option
		if( ! empty( $atts['woodmart_bg_position'] ) ) {
			$class .= ' woodmart-bg-' . $atts['woodmart_bg_position'];
		}
		//Text align option
		if( ! empty( $atts['woodmart_text_align'] ) ) {
			$class .= ' text-' . $atts['woodmart_text_align'];
		}
		//Responsive opt
		if( ! empty( $atts['woodmart_hide_large'] ) ) {
			$class .= ' hidden-lg';
		}
		if( ! empty( $atts['woodmart_hide_medium'] ) ) {
			$class .= ' hidden-md';
		}
		if( ! empty( $atts['woodmart_hide_small'] ) ) {
			$class .= ' hidden-sm';
		}
		if( ! empty( $atts['woodmart_hide_extra_small'] ) ) {
			$class .= ' hidden-xs';
		}
		//Row reverse opt
		if( ! empty( $atts['row_reverse_mobile'] ) ) {
			$class .= ' row-reverse-mobile';
		}
		if( ! empty( $atts['row_reverse_tablet'] ) ) {
			$class .= ' row-reverse-tablet';
		}
		return $class;
	}
}

if( ! function_exists( 'woodmart_section_title_color_variation' ) ) {
	function woodmart_section_title_color_variation() {
		$variation = array(
			esc_html__( 'Default', 'woodmart' ) => 'default',
			esc_html__( 'Primary color', 'woodmart' ) => 'primary',
			esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
			esc_html__( 'Black', 'woodmart' ) => 'black',
			esc_html__( 'White', 'woodmart' ) => 'white',
		);
		$variation2 = array( esc_html__( 'Gradient', 'woodmart' ) => 'gradient' );
		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$variation = array_merge( $variation, $variation2 ); 
		}
		return $variation;
	}
}

if( ! function_exists( 'woodmart_title_gradient_picker' ) ) {
	function woodmart_title_gradient_picker() {
		$title_color = array(
			'type' => 'woodmart_gradient',
			'param_name' => 'woodmart_color_gradient',
			'heading' => esc_html__( 'Gradient title color', 'woodmart' ),
			'dependency' => array(
				'element' => 'color',
				'value' => array( 'gradient' ),
			) 
		);
		if ( !apply_filters( 'woodmart_gradients_enabled', true ) ) $title_color = false;
		return $title_color;
	}
}


if( ! function_exists( 'woodmart_vc_map_shortcodes' ) ) {

	add_action( 'vc_before_init', 'woodmart_vc_map_shortcodes' );

	function woodmart_vc_map_shortcodes() {

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Parallax option
		 * ------------------------------------------------------------------------------------------------
		 */

		$attributes = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Woodmart parallax', 'woodmart' ),
			'param_name' => 'woodmart_parallax',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		vc_add_param( 'vc_row', $attributes );
		vc_add_param( 'vc_section', $attributes );
		vc_add_param( 'vc_column', $attributes );
		
		/**
		 * ------------------------------------------------------------------------------------------------
		 * Gradient option
		 * ------------------------------------------------------------------------------------------------
		 */
		if( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$woodmart_gradient_switch = array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'woodmart gradient', 'woodmart' ),
				'param_name' => 'woodmart_gradient_switch',
				'group' => esc_html__( 'woodmart Extras', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
			);

			$woodmart_color_gradient = array(
				'type' => 'woodmart_gradient',
				'param_name' => 'woodmart_color_gradient',
				'group' => esc_html__( 'woodmart Extras', 'woodmart' ),
				'dependency' => array(
					'element' => 'woodmart_gradient_switch',
					'value' => array( 'yes' ),
				) 
			);


			vc_add_param( 'vc_row', $woodmart_gradient_switch );
			vc_add_param( 'vc_section', $woodmart_gradient_switch );

			vc_add_param( 'vc_row', $woodmart_color_gradient );
			vc_add_param( 'vc_section', $woodmart_color_gradient );
		}

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Background position
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_bg_position = array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'woodmart' ),
			'param_name' => 'woodmart_bg_position',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array(
				esc_html__( 'None', 'woodmart' ) => '',
				esc_html__( 'Left top', 'woodmart' ) => 'left-top',
				esc_html__( 'Left center', 'woodmart' ) => 'left-center',
				esc_html__( 'Left bottom', 'woodmart' ) => 'left-bottom',
				esc_html__( 'Right top', 'woodmart' ) => 'right-top',
				esc_html__( 'Right center', 'woodmart' ) => 'right-center',
				esc_html__( 'Right bottom', 'woodmart' ) => 'right-bottom',
				esc_html__( 'Center top', 'woodmart' ) => 'center-top',
				esc_html__( 'Center center', 'woodmart' ) => 'center-center',
				esc_html__( 'Center bottom', 'woodmart' ) => 'center-bottom',
			),
		);

		vc_add_param( 'vc_row', $woodmart_bg_position );
		vc_add_param( 'vc_row_inner', $woodmart_bg_position );
		vc_add_param( 'vc_section', $woodmart_bg_position );
		vc_add_param( 'vc_column', $woodmart_bg_position );
		vc_add_param( 'vc_column_inner', $woodmart_bg_position );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Text align
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_text_align = array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Text align', 'woodmart' ),
			'param_name' => 'woodmart_text_align',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array(
				esc_html__( 'Choose', 'woodmart' ) => '',
				esc_html__( 'Left', 'woodmart' ) => 'left',
				esc_html__( 'Center', 'woodmart' ) => 'center',
				esc_html__( 'Right', 'woodmart' ) => 'right',
			),
		);

		vc_add_param( 'vc_column', $woodmart_text_align );
		vc_add_param( 'vc_column_inner', $woodmart_text_align );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Hide option
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_hide_large = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide on large', 'woodmart' ),
			'param_name' => 'woodmart_hide_large',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		$woodmart_hide_medium = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide on medium', 'woodmart' ),
			'param_name' => 'woodmart_hide_medium',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		$woodmart_hide_small = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide on small', 'woodmart' ),
			'param_name' => 'woodmart_hide_small',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		$woodmart_hide_extra_small = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide on extra small', 'woodmart' ),
			'param_name' => 'woodmart_hide_extra_small',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		vc_add_param( 'vc_empty_space', $woodmart_hide_large );
		vc_add_param( 'vc_empty_space', $woodmart_hide_medium );
		vc_add_param( 'vc_empty_space', $woodmart_hide_small );
		vc_add_param( 'vc_empty_space', $woodmart_hide_extra_small );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Row reverse mobile
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_row_reverse_mobile = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Row reverse on mobile', 'woodmart' ),
			'param_name' => 'row_reverse_mobile',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		vc_add_param( 'vc_row', $woodmart_row_reverse_mobile );
		vc_add_param( 'vc_row_inner', $woodmart_row_reverse_mobile );
		
		/**
		 * ------------------------------------------------------------------------------------------------
		 * Row reverse tablet
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_row_reverse_tablet = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Row reverse on tablet', 'woodmart' ),
			'param_name' => 'row_reverse_tablet',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		vc_add_param( 'vc_row', $woodmart_row_reverse_tablet );
		vc_add_param( 'vc_row_inner', $woodmart_row_reverse_tablet );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Gradient option
		 * ------------------------------------------------------------------------------------------------
		 */
		if( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$woodmart_gradient_switch = array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Woodmart gradient', 'woodmart' ),
				'param_name' => 'woodmart_gradient_switch',
				'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
			);

			$woodmart_color_gradient = array(
				'type' => 'woodmart_gradient',
				'param_name' => 'woodmart_color_gradient',
				'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
				'dependency' => array(
					'element' => 'woodmart_gradient_switch',
					'value' => array( 'yes' ),
				) 
			);


			vc_add_param( 'vc_row', $woodmart_gradient_switch );
			vc_add_param( 'vc_section', $woodmart_gradient_switch );

			vc_add_param( 'vc_row', $woodmart_color_gradient );
			vc_add_param( 'vc_section', $woodmart_color_gradient );
		}

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Disable overflow
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_disable_overflow = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Disable "overflow:hidden;"', 'woodmart' ),
			'param_name' => 'woodmart_disable_overflow',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		vc_add_param( 'vc_row', $woodmart_disable_overflow );
		vc_add_param( 'vc_section', $woodmart_disable_overflow );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Add options to columns and text block
		 * ------------------------------------------------------------------------------------------------
		 */

		add_action( 'init', 'woodmart_update_vc_column');

		if( ! function_exists( 'woodmart_update_vc_column' ) ) {
			function woodmart_update_vc_column() {
				if(!function_exists('vc_map')) return;
				vc_remove_param( 'vc_column', 'el_class' );

		        vc_add_param( 'vc_column', woodmart_get_color_scheme_param() );

		        vc_add_param( 'vc_column', array(
					'type' => 'checkbox',
					'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
					'heading' => esc_html__( 'Enable sticky column', 'woodmart' ),
		            'description' => esc_html__( 'Also enable equal columns height for the parent row to make it work', 'woodmart' ),
					'param_name' => 'woodmart_sticky_column'
				) );
		        vc_add_param( 'vc_column', array(
		            'type' => 'textfield',
		            'heading' => esc_html__( 'Extra class name', 'woodmart' ),
		            'param_name' => 'el_class',
		            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
		        ) );

				vc_remove_param( 'vc_column_text', 'el_class' );

		        vc_add_param( 'vc_column_text', woodmart_get_color_scheme_param() );

		        vc_add_param( 'vc_column_text', array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Text larger', 'woodmart' ),
					'param_name' => 'text_larger',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				) );

		        vc_add_param( 'vc_column_text', array(
		            'type' => 'textfield',
		            'heading' => esc_html__( 'Extra class name', 'woodmart' ),
		            'param_name' => 'el_class',
		            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
		        ) );
			}
		}

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Update images carousel parameters
		 * ------------------------------------------------------------------------------------------------
		 */
		add_action( 'init', 'woodmart_update_vc_images_carousel' );

		if( ! function_exists( 'woodmart_update_vc_images_carousel' ) ) {
			function woodmart_update_vc_images_carousel() {
				if( !function_exists( 'vc_map' ) ) return;
				vc_remove_param( 'vc_images_carousel', 'mode' );
				vc_remove_param( 'vc_images_carousel', 'partial_view' );
				vc_remove_param( 'vc_images_carousel', 'el_class' );

		        vc_add_param( 'vc_images_carousel', array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add spaces between images', 'woodmart' ),
					'param_name' => 'spaces',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
				) );

		        vc_add_param( 'vc_images_carousel', array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Specific design', 'woodmart' ),
					'param_name' => 'design',
		            'description' => esc_html__( 'With this option your gallery will be styled in a different way, and sizes will be changed.', 'woodmart' ),
					'value' => array(
						'' => 'none',
						esc_html__( 'Iphone', 'woodmart' ) => 'iphone',
						esc_html__( 'MacBook', 'woodmart' ) => 'macbook',
					)
				) );

		        vc_add_param( 'vc_images_carousel', array(
		            'type' => 'textfield',
		            'heading' => esc_html__( 'Extra class name', 'woodmart' ),
		            'param_name' => 'el_class',
		            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
		        ) );
			}
		}
	}
}

if( ! function_exists( 'woodmart_get_color_scheme_param' ) ) {
	function woodmart_get_color_scheme_param() {
		return apply_filters( 'woodmart_get_color_scheme_param', array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Color Scheme', 'woodmart' ),
			'param_name' => 'woodmart_color_scheme',
			'value' => array(
				esc_html__( 'Choose', 'woodmart' ) => '',
				esc_html__( 'Light', 'woodmart' ) => 'light',
				esc_html__( 'Dark', 'woodmart' ) => 'dark',
			),
		) );
	}
}

if( ! function_exists( 'woodmart_get_user_panel_params' ) ) {
	function woodmart_get_user_panel_params() {
		return apply_filters( 'woodmart_get_user_panel_params', array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title',
			)
		));
	}
}
