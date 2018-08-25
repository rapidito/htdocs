<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Array of specific optinos
 * ------------------------------------------------------------------------------------------------
 */

$rules = array(
	'top-bar' => array(
		'will-be' => false,
		'if' => 'header',
		'in_array' => array( 'menu-top' )
	),
	'header-overlap' => array(
		'will-be' => false,
		'if' => 'header',
		'in_array' => array( 'base', 'logo-center', 'categories', 'menu-top', )
	),
	'shopping_cart' => array(
		'will-be' => 'disable',
		'if' => 'catalog_mode',
		'in_array' => array( true )
	),
	'product_tabs_location' => array(
		'will-be' => 'standard',
		'if' => 'product_tabs_layout',
		'in_array' => array( 'tabs' )
	),
);

if( is_singular( 'product' ) || is_404() ) {
	$shop_header_color = get_post_meta( woodmart_page_ID(), '_woodmart_header_color_scheme', true );
	$header_bg = woodmart_get_opt('header_background');

	$rules['header_color_scheme'] = array(
		'will-be' => 'dark',
		'if' => 'header-overlap',
		'in_array' => array(true)
	);
	
	$rules['header-overlap'] = array(
		'will-be' => false,
		'if' => 'header-overlap',
		'in_array' => array(true)
	);

	if( $shop_header_color == 'light' || ( empty( $header_bg['background-image'] ) && empty( $header_bg['background-color'] ) ) ) {
		$rules['header_color_scheme'] = array(
			'will-be' => 'dark',
			'if' => 'dark_version',
			'in_array' => array(false)
		);
	}

}

if( ! is_user_logged_in() ) {
	$rules['promo_popup'] = array(
		'will-be' => false,
		'if' => 'maintenance_mode',
		'in_array' => array(true)
	);
}

return apply_filters( 'woodmart_get_specific_options', $rules );