<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

$spacing = woodmart_get_opt( 'products_spacing' );
$class   = '';

if( woodmart_loop_prop( 'products_masonry' ) ) {
	$class .= ' grid-masonry';
	woodmart_enqueue_script( 'isotope' );
	woodmart_enqueue_script( 'woodmart-packery-mode' );
}

if ( woodmart_get_shop_view() == 'list' ) {
	$class .= ' elements-list';
}else{
	$class .= ' woodmart-spacing-' . $spacing;
	$class .= ' products-spacing-' . $spacing;
}

$class .= ' pagination-' . woodmart_get_opt( 'shop_pagination' );

// fix for price filter ajax
$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

if ( woodmart_get_opt( 'shop_countdown' ) ) woodmart_enqueue_script( 'woodmart-countdown' );

?>

<div class="products elements-grid woodmart-products-holder <?php echo esc_attr( $class ); ?> row grid-columns-<?php echo esc_attr( woodmart_loop_prop( 'products_columns' ) ); ?>" data-source="main_loop" data-min_price="<?php echo esc_attr( $min_price ); ?>" data-max_price="<?php echo esc_attr( $max_price ); ?>">