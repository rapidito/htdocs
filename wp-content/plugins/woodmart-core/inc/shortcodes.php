<?php 
/**
* ------------------------------------------------------------------------------------------------
* Products widget shortcode
* ------------------------------------------------------------------------------------------------
*/
class WOODMART_ShortcodeProductsWidget{
	
	function __construct(){
		add_shortcode( 'woodmart_shortcode_products_widget', array( $this, 'woodmart_shortcode_products_widget' ) );
	}
	public function add_category_order($query_args){
		$ids = explode( ',', $this->ids );
		if ( !empty( $ids[0] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => $ids,
			);
		}
		return $query_args;
	}

	public function woodmart_shortcode_products_widget( $atts ){
		$output = $title = $el_class = '';
		extract( shortcode_atts( array(
			'title' => __( 'Products', 'woodmart' ),
			'ids' => '',
			'el_class' => ''
		), $atts ) );
		
		$this->ids = $ids;
		$output = '<div class="widget_products' . $el_class . '">';
		$type = 'WC_Widget_Products';

		$args = array('widget_id' => uniqid());

		ob_start();
		add_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_category_order' ) );
		if ( function_exists( 'woodmart_woocommerce_installed' ) && woodmart_woocommerce_installed() ) {
			the_widget( $type, $atts, $args );
		}
		remove_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_category_order' ) );
		$output .= ob_get_clean();

		$output .= '</div>';

		return $output;

	}
}
$woodmart_shortcode_products_widget = new WOODMART_ShortcodeProductsWidget();