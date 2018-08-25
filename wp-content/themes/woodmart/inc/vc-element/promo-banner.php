<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Promo Banner element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_promo_banner' ) ) {
	function woodmart_vc_map_promo_banner() {
		vc_map( array(
			'name' => esc_html__( 'Promo Banner', 'woodmart' ),
			'base' => 'promo_banner',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Promo image with text and hover effect', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/promo-banner.svg',
			'params' =>  woodmart_get_banner_params()
		) );

		vc_map( array(
			'name' => esc_html__( 'Banners carousel', 'woodmart' ),
			'base' => 'banners_carousel',
			'as_parent' => array( 'only' => 'promo_banner' ),
			'content_element' => true,
			'show_settings_on_create' => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Show your banners as a carousel', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/banners-carousel.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slider spacing', 'woodmart' ),
					'param_name' => 'slider_spacing',
					'value' => array(
						30,20,10,6,2,0
					),
					'description' => esc_html__( 'Set the interval numbers that you want to display between slider items.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'woodmart' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
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
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_promo_banner' );
}

if( ! function_exists( 'woodmart_get_banner_params' ) ) {
	function woodmart_get_banner_params() {
		return apply_filters( 'woodmart_get_banner_params', array(
			//General
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
				'type' => 'vc_link',
				'heading' => esc_html__( 'Banner link', 'woodmart'),
				'param_name' => 'link',
				'description' => esc_html__( 'Enter URL if you want this banner to have a link.', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hover effect', 'woodmart' ),
				'param_name' => 'hover',
				'value' => array(
					esc_html__( 'Zoom image', 'woodmart' ) => 'zoom',
					esc_html__( 'Parallax', 'woodmart' ) => 'parallax',
					esc_html__( 'Background', 'woodmart' ) => 'background',
					esc_html__( 'Bordered', 'woodmart' ) => 'border',
					esc_html__( 'Zoom reverse', 'woodmart' ) => 'zoom-reverse',
					esc_html__( 'Disable', 'woodmart' ) => 'none'
				),
				'description' => esc_html__( 'Set beautiful hover effects for your banner.', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content style', 'woodmart' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Color mask', 'woodmart' ) => 'mask',
					esc_html__( 'Mask with shadow', 'woodmart' ) => 'shadow',
					esc_html__( 'Bordered', 'woodmart' ) => 'border',
					esc_html__( 'Rectangular background', 'woodmart' ) => 'background'
				),
				'description' => esc_html__( 'You can use some of our predefined styles for your banner content.', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Banner content width', 'woodmart' ),
				'param_name' => 'content_width',
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
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Banner content spacing', 'woodmart' ),
				'param_name' => 'content_spacing',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Medium', 'woodmart' ) => 'medium',
					esc_html__( 'Large', 'woodmart' ) => 'large'
				)
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Increase spaces', 'woodmart' ),
				'param_name' => 'increase_spaces',
				'description' => esc_html__( 'Suggest to use this option if you have large banners. Padding will be set in percentage to your screen width.', 'woodmart' ),	
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Color Scheme', 'woodmart' ),
				'param_name' => 'woodmart_color_scheme',
				'value' => array(
					esc_html__( 'Choose', 'woodmart' ) => '',
					esc_html__( 'Light', 'woodmart' ) => 'light',
					esc_html__( 'Dark', 'woodmart' ) => 'dark',
					esc_html__( 'Custom', 'woodmart' ) => 'custom'
				)
			),
			( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'woodmart' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
			),
			//Buttons
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Button text', 'woodmart' ),
				'param_name' => 'btn_text',
				'group' => esc_html__( 'Buttons', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button position', 'woodmart' ),
				'param_name' => 'btn_position',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'value' => array(
					esc_html__( 'Show on hover', 'woodmart' ) => 'hover',
					esc_html__( 'Static', 'woodmart' ) => 'static'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button color', 'woodmart' ),
				'param_name' => 'btn_color',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Primary color', 'woodmart' ) => 'primary',
					esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
					esc_html__( 'Black', 'woodmart' ) => 'black',
					esc_html__( 'White', 'woodmart' ) => 'white'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button style', 'woodmart' ),
				'param_name' => 'btn_style',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
					esc_html__( 'Link button', 'woodmart' ) => 'link',
					esc_html__( 'Circle', 'woodmart' ) => 'round',
					esc_html__( '3D', 'woodmart' ) => '3d'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button shape', 'woodmart' ),
				'param_name' => 'btn_shape',
				'value' => array(
					esc_html__( 'Rectangle', 'woodmart' ) => 'rectangle',
					esc_html__( 'Circle', 'woodmart' ) => 'round',
					esc_html__( 'Round', 'woodmart' ) => 'semi-round',
				),
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'dependency' => array(
					'element' => 'btn_style',
					'value_not_equal_to' => array( 'round', 'link' ),
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button size', 'woodmart' ),
				'param_name' => 'btn_size',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
					esc_html__( 'Small', 'woodmart' ) => 'small',
					esc_html__( 'Large', 'woodmart' ) => 'large',
					esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large'
				)
			),
			//Title & Subtitle
			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title',
				'group' => esc_html__( 'Title & Subtitle', 'woodmart' ),
				'holder' => 'div'
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Subtitle', 'woodmart' ),
				'group' => esc_html__( 'Title & Subtitle', 'woodmart' ),
				'param_name' => 'subtitle'
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Subtitle color', 'woodmart' ),
				'group' => esc_html__( 'Title & Subtitle', 'woodmart' ),
				'param_name' => 'subtitle_color',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Primary', 'woodmart' ) => 'primary',
					esc_html__( 'Alternative', 'woodmart' ) => 'alt'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Subtitle style', 'woodmart' ),
				'group' => esc_html__( 'Title & Subtitle', 'woodmart' ),
				'param_name' => 'subtitle_style',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Background', 'woodmart' ) => 'background'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Title size', 'woodmart' ),
				'group' => esc_html__( 'Title & Subtitle', 'woodmart' ),
				'param_name' => 'title_size',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Small', 'woodmart' ) => 'small',
					esc_html__( 'Large', 'woodmart' ) => 'large',
					esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					esc_html__( 'Custom', 'woodmart' ) => 'custom'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Font weight', 'woodmart' ),
				'group' => esc_html__( 'Title & Subtitle', 'woodmart' ),
				'param_name' => 'font_weight',
				'value' => array(
					'',100,200,300,400,500,600,700,800,900
				)
			),
			//Title custom size
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title desktop text size ( > 1024px )', 'woodmart' ),
				'param_name' => 'title_desktop_text_size',
				'description' => esc_html__( 'Only number without px.', 'woodmart' ),
				'group' => esc_html__( 'Custom size', 'woodmart' ),
				'dependency' => array(
					'element' => 'title_size',
					'value' => array( 'custom' )
				) 
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title tablet text size ( < 1024px )', 'woodmart' ),
				'param_name' => 'title_tablet_text_size',
				'description' => esc_html__( 'Only number without px.', 'woodmart' ),
				'group' => esc_html__( 'Custom size', 'woodmart' ),
				'dependency' => array(
					'element' => 'title_size',
					'value' => array( 'custom' )
				) 	
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title mobile text size ( < 767px )', 'woodmart' ),
				'param_name' => 'title_mobile_text_size',
				'description' => esc_html__( 'Only number without px.', 'woodmart' ),
				'group' => esc_html__( 'Custom size', 'woodmart' ),
				'dependency' => array(
					'element' => 'title_size',
					'value' => array( 'custom' )
				) 
			),
			//Subtitle custom size
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Subtitle desktop text size ( > 1024px )', 'woodmart' ),
				'param_name' => 'subtitle_desktop_text_size',
				'description' => esc_html__( 'Only number without px.', 'woodmart' ),
				'group' => esc_html__( 'Custom size', 'woodmart' ),
				'dependency' => array(
					'element' => 'title_size',
					'value' => array( 'custom' )
				) 
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Subtitle tablet text size ( < 1024px )', 'woodmart' ),
				'param_name' => 'subtitle_tablet_text_size',
				'description' => esc_html__( 'Only number without px.', 'woodmart' ),
				'group' => esc_html__( 'Custom size', 'woodmart' ),
				'dependency' => array(
					'element' => 'title_size',
					'value' => array( 'custom' )
				) 	
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Subtitle mobile text size ( < 767px )', 'woodmart' ),
				'param_name' => 'subtitle_mobile_text_size',
				'description' => esc_html__( 'Only number without px.', 'woodmart' ),
				'group' => esc_html__( 'Custom size', 'woodmart' ),
				'dependency' => array(
					'element' => 'title_size',
					'value' => array( 'custom' )
				)
			),
			
			//Content
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Banner content', 'woodmart' ),
				'group' => esc_html__( 'Content', 'woodmart' ),
				'param_name' => 'content',
				'description' => esc_html__( 'Add here few words to your banner image.', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Banner content text size', 'woodmart' ),
				'group' => esc_html__( 'Content', 'woodmart' ),
				'param_name' => 'content_text_size',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Medium', 'woodmart' ) => 'medium',
					esc_html__( 'Large', 'woodmart' ) => 'large'
				)
			),
			//Positioning
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text alignment', 'woodmart' ),
				'group' => esc_html__( 'Positioning', 'woodmart' ),
				'param_name' => 'text_alignment',
				'value' => array(
					esc_html__( 'Align left', 'woodmart' ) => '',
					esc_html__( 'Align right', 'woodmart' ) => 'right',
					esc_html__( 'Align center', 'woodmart' ) => 'center'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content horizontal alignment', 'woodmart' ),
				'param_name' => 'horizontal_alignment',
				'group' => esc_html__( 'Positioning', 'woodmart' ),
				'value' => array(
					esc_html__( 'Left', 'woodmart' ) => '',
					esc_html__( 'Center', 'woodmart' ) => 'center',
					esc_html__( 'Right', 'woodmart' ) => 'right'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content vertical alignment', 'woodmart' ),
				'param_name' => 'vertical_alignment',
				'group' => esc_html__( 'Positioning', 'woodmart' ),
				'value' => array(
					esc_html__( 'Top', 'woodmart' ) => '',
					esc_html__( 'Middle', 'woodmart' ) => 'middle',
					esc_html__( 'Bottom', 'woodmart' ) => 'bottom'
				)
			),
			//Positioning
			array(
				'type' => 'colorpicker',
				'group' => esc_html__( 'Custom color', 'woodmart' ),
				'heading' => esc_html__( 'Title color', 'woodmart' ),
				'param_name' => 'custom_title_color',
				'dependency' => array(
					'element' => 'woodmart_color_scheme',
					'value' => array( 'custom' )
				)
			),
			array(
				'type' => 'colorpicker',
				'group' => esc_html__( 'Custom color', 'woodmart' ),
				'heading' => esc_html__( 'Subtitle color', 'woodmart' ),
				'param_name' => 'custom_subtitle_color',
				'dependency' => array(
					'element' => 'woodmart_color_scheme',
					'value' => array( 'custom' )
				)
			),
			array(
				'type' => 'colorpicker',
				'group' => esc_html__( 'Custom color', 'woodmart' ),
				'heading' => esc_html__( 'Text color', 'woodmart' ),
				'param_name' => 'custom_text_color',
				'dependency' => array(
					'element' => 'woodmart_color_scheme',
					'value' => array( 'custom' )
				)
			),
		) );
	}
}

if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_banners_carousel extends WPBakeryShortCodesContainer {

    }
}
