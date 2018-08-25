<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Default options array while Redux is not installed
 * ------------------------------------------------------------------------------------------------
 */

return apply_filters( 'woodmart_get_base_options', array(
	'main_layout' => 'full-width',
	'header' => 'base',
	'header_color_scheme' => 'dark',
	'header-overlap' => false,
	'page-title-size' => 'small',
	'sidebar_width' => 3,
	'blog_sidebar_width' => 3,
	'shopping_cart' => 1,
	'cart_position' => 'side',
	'header_search' => 'full-screen',
	'blog_design' => 'default',
	'products_hover' => 'alt',
	'footer-layout' => 12,
	'disable_footer' => true,
	'logo_img_width' => 250,
	'header_height' => 100,
	'sticky_header' => true,
	'sticky_header_height' => 60,
	'menu_align' => 'left',
	'copyrights-layout' => 'centered',
	'blog_excerpt' => 'full',
	'mobile_header_height' => 50,
	'logo_padding' => array(
		'padding-top'     => '10px',
		'padding-right'   => '0px',
		'padding-bottom'  => '10px',
		'padding-left'    => '0px',
		'units'          => 'px',
	),
	'page-title-design' => 'centered',
	'page-title-color' => 'light',
	'custom_css' => '.page-title-default { background-color: #0a0a0a; }',
	'page_comments' => true,
	'products_columns_mobile' => 2,
	'thums_position' => 'bottom',
	'product_short_description' => true,
	'product_tabs_layout' => 'tabs',
	'related_products' => true,
	'hover_image' => true,
	'products_hover' => 'base',
	'icons_design' => 'line',
	'blog_design' => 'default',
	'search_post_type' => 'post',
	'logo_img_width_mobile' => 140,
	'logo_responsive_sizes' => true,
	'logo_padding_tablet' => array(
		'padding-top'     => '10px',
		'padding-right'   => '0px',
		'padding-bottom'  => '10px',
		'padding-left'    => '0px',
		'units'          => 'px',
	),
	'logo_padding_mobile' => array(
		'padding-top'     => '10px',
		'padding-right'   => '0px',
		'padding-bottom'  => '10px',
		'padding-left'    => '0px',
		'units'          => 'px',
	),
) );