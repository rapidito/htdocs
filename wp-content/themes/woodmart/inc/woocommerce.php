<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Add theme support for WooCommerce
 * ------------------------------------------------------------------------------------------------
 */

add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );

/**
 * ------------------------------------------------------------------------------------------------
 * Main loop
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_woocommerce_main_loop' ) ) {

	add_action( 'woodmart_woocommerce_main_loop', 'woodmart_woocommerce_main_loop' );

	function woodmart_woocommerce_main_loop( $fragments = false ) {
		global $paged, $wp_query;

        $max_page = $wp_query->max_num_pages;

 		if ( $fragments ) ob_start();
		
		 if ( $fragments && isset( $_GET['loop'] ) ) woodmart_set_loop_prop( 'woocommerce_loop', (int) $_GET['loop'] );
		 
		 //WC 3.4
		$have_posts = 'have_posts';
		if ( function_exists( 'WC' ) && WC()->version >= '3.4' ) {
			$have_posts = 'woocommerce_product_loop';
		}
		
		if ( $have_posts() ) : ?>
			
			<?php if( ! $fragments ) woocommerce_product_loop_start(); ?>
				
			<?php if ( wc_get_loop_prop( 'total' ) || $fragments ): ?>
				<?php while ( have_posts() ) : the_post(); ?>
					
					<?php 
					/**
					 * Hook: woocommerce_shop_loop.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>
			<?php endif; ?>
				

			<?php if( ! $fragments ) woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				if( ! $fragments ) do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php else: ?>
			
			<?php 	
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' ); ?>

		<?php endif;

		if ( $fragments ) $output = ob_get_clean();

	    if( $fragments ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $max_page > $paged ) ? 'have-posts' : 'no-more-posts',
	    		'nextPage' => str_replace( '&#038;', '&', next_posts( $max_page, false ) )
	    	);

	    	echo json_encode( $output );
	    }
	}
}
/**
 * ------------------------------------------------------------------------------------------------
 * Change number of products displayed per page
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_shop_products_per_page' ) ) {
	function woodmart_shop_products_per_page() {
		$per_page = 12;
		$number = apply_filters('woodmart_shop_per_page', woodmart_get_products_per_page() );
		if( is_numeric( $number ) ) {
			$per_page = $number;
		}
		return $per_page;
	}

	add_filter( 'loop_shop_per_page', 'woodmart_shop_products_per_page', 20 );
}


/**
 * ------------------------------------------------------------------------------------------------
 * Set full width layouts for woocommerce pages on set up
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_woocommerce_install_actions' ) ) {
	function woodmart_woocommerce_install_actions() {
		if ( ! empty( $_GET['page'] ) && @$_GET['page'] == 'wc-setup' && ! empty( $_GET['step'] ) && @$_GET['step'] == 'next_steps') {
			$pages = apply_filters( 'woocommerce_create_pages', array(
				'cart' => array(
					'name'    => _x( 'cart', 'Page slug', 'woodmart' ),
					'title'   => _x( 'Cart', 'Page title', 'woodmart' ),
					'content' => '[' . apply_filters( 'woocommerce_cart_shortcode_tag', 'woocommerce_cart' ) . ']'
				),
				'checkout' => array(
					'name'    => _x( 'checkout', 'Page slug', 'woodmart' ),
					'title'   => _x( 'Checkout', 'Page title', 'woodmart' ),
					'content' => '[' . apply_filters( 'woocommerce_checkout_shortcode_tag', 'woocommerce_checkout' ) . ']'
				),
			) );

			foreach ( $pages as $key => $page ) {
				$option = 'woocommerce_' . $key . '_page_id';
				$page_id = get_option( $option );
				update_post_meta( $page_id, '_woodmart_main_layout', 'full-width' );
			}

			woodmart_woocommerce_image_dimensions();
		}
	}

	add_action( 'admin_init', 'woodmart_woocommerce_install_actions', 1000);
	add_action( 'admin_print_styles', 'woodmart_woocommerce_install_actions', 1000);
}


/**
 * Define image sizes
 */
if( ! function_exists( 'woodmart_woocommerce_image_dimensions' ) ) {
	function woodmart_woocommerce_image_dimensions() {
		global $pagenow;
	 	
		update_option( 'woocommerce_single_image_width', '1200' ); 		// Single product image
		update_option( 'woocommerce_thumbnail_image_width', '600' ); 	// Gallery and catalog image
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Check if WooCommerce is active
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_woocommerce_installed' ) ) {
	function woodmart_woocommerce_installed() {
	    return class_exists( 'WooCommerce' );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get base shop page link
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_shop_page_link' ) ) {
	function woodmart_shop_page_link( $keep_query = false, $taxonomy = '' ) {
		// Base Link decided by current page
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif( is_product_category() ) {
			$link = get_term_link( get_query_var('product_cat'), 'product_cat' );
		} elseif( is_product_tag() ) {
			$link = get_term_link( get_query_var('product_tag'), 'product_tag' );
		} else {
			$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
		}

		if( $keep_query ) {

			// Min/Max
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
			}

			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
			}

			// Orderby
			if ( isset( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
			}

			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
			}

			// Post Type Arg
			if ( isset( $_GET['post_type'] ) ) {
				$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
			}

			// Min Rating Arg
			if ( isset( $_GET['min_rating'] ) ) {
				$link = add_query_arg( 'min_rating', wc_clean( $_GET['min_rating'] ), $link );
			}

			// All current filters
			if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
				foreach ( $_chosen_attributes as $name => $data ) {
					if ( $name === $taxonomy ) {
						continue;
					}
					$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
					if ( ! empty( $data['terms'] ) ) {
						$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
					}
					if ( 'or' == $data['query_type'] ) {
						$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
					}
				}
			}
		}

		return $link;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * is ajax request
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_is_woo_ajax' ) ) {
	function woodmart_is_woo_ajax() {
		
		$request_headers = getallheaders();

		if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return 'wp-ajax';
		}
		if( isset( $request_headers['x-pjax'] ) || isset( $request_headers['X-PJAX'] ) || isset( $request_headers['X-Pjax'] ) ) {
			return 'full-page';
		}
		if( isset( $_REQUEST['woo_ajax'] ) ) {
			return 'fragments';
		}
		if( isset( $_REQUEST['_pjax'] ) ) {
			return 'full-page';
		}

		if( woodmart_is_pjax() ) {
			return true;
		}
		return false;
	}
}

if( ! function_exists( 'woodmart_is_pjax' ) ) {
	function woodmart_is_pjax(){
		return isset( $_REQUEST['_pjax'] );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get product design option
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_product_design' ) ) {
	function woodmart_product_design() {
		$design = woodmart_get_opt( 'product_design' );
		if( is_singular( 'product' ) ) {
			$custom = get_post_meta( get_the_ID(), '_woodmart_product_design', true );
			if( ! empty( $custom ) && $custom != 'inherit' ) $design = $custom;
		}

		return $design;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Is product sticky
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_product_sticky' ) ) {
	function woodmart_product_sticky() {
		$sticky = woodmart_get_opt( 'product_sticky' ) && in_array( woodmart_get_opt( 'single_product_style' ), array( 1, 2, 3 ) ) ? true : false;
		if( is_singular( 'product' ) ) {
			$custom = get_post_meta( get_the_ID(), '_woodmart_product_sticky', true );
			if( ! empty( $custom ) && $custom != 'inherit' ) $sticky = $custom;
		}

		return $sticky;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Custom function for product title
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	function woocommerce_template_loop_product_title() {
		echo '<h3 class="product-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Register new image size two times larger than standard woocommerce one 
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_add_image_size' ) ) {
	add_action( 'after_setup_theme', 'woodmart_add_image_size' );

	function woodmart_add_image_size() {

		if( ! function_exists( 'wc_get_image_size' ) ) return;

		$shop_catalog = wc_get_image_size( 'woocommerce_thumbnail' );

		$width = (int) ( $shop_catalog['width'] * 2 );
		$height = ( !empty( $shop_catalog['height'] ) ) ? (int) ( $shop_catalog['height'] * 2 ) : '';

		add_image_size( 'woodmart_shop_catalog_x2', $width, $height, $shop_catalog['crop'] );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Custom thumbnail function for slider
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_template_loop_product_thumbnail' ) ) {
	function woodmart_template_loop_product_thumbnail() {
		echo woodmart_get_product_thumbnail();
	}
}

if ( ! function_exists( 'woodmart_get_product_thumbnail' ) ) {
	function woodmart_get_product_thumbnail( $size = 'woocommerce_thumbnail', $attach_id = false ) {
		global $post;
		$custom_size = $size;
		$defined_sizes = array('woocommerce_thumbnail', 'woodmart_shop_catalog_x2');

		if( woodmart_loop_prop( 'double_size' ) ) {
			$size = 'woodmart_shop_catalog_x2';
		}

		if ( has_post_thumbnail() ) {

			if( ! $attach_id ) $attach_id = get_post_thumbnail_id();

			$props = wc_get_product_attachment_props( $attach_id, $post );
			
			if( woodmart_loop_prop( 'img_size' ) ) {
				$custom_size = woodmart_loop_prop( 'img_size' );
			} 

			$custom_size = apply_filters( 'woodmart_custom_img_size', $custom_size );

			if( ! in_array( $custom_size, $defined_sizes ) && function_exists( 'wpb_getImageBySize' ) ) {

				$img = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $custom_size, 'class' => 'content-product-image' ) );
				$img = $img['thumbnail'];

			} else {
				$img = wp_get_attachment_image( $attach_id, $size, array(
					'title'	 => $props['title'],
					'alt'    => $props['alt'],
				) );
			}

			return $img;

		} elseif ( wc_placeholder_img_src() ) {
			return wc_placeholder_img( $size );
		}
	}
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woodmart_template_loop_product_thumbnail', 10 );


/**
 * ------------------------------------------------------------------------------------------------
 * Checkout steps in page title
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_checkout_steps' ) ) {
	function woodmart_checkout_steps() {

		?>
            <div class="woodmart-checkout-steps">
                <ul>
                	<li class="step-cart <?php echo (is_cart()) ? 'step-active' : 'step-inactive'; ?>">
                		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                			<span><?php esc_html_e('Shopping cart', 'woodmart'); ?></span>
                		</a>
                	</li>
                	<li class="step-checkout <?php echo (is_checkout() && ! is_order_received_page()) ? 'step-active' : 'step-inactive'; ?>">
                		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">
                			<span><?php esc_html_e('Checkout', 'woodmart'); ?></span>
                		</a>
                	</li>
                	<li class="step-complete <?php echo (is_order_received_page()) ? 'step-active' : 'step-inactive'; ?>">
                		<span><?php esc_html_e('Order complete', 'woodmart'); ?></span>
                	</li>
                </ul>
            </div>
		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Custom thumbnail for category (wide items)
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_category_thumb_double_size' ) ) {
	function woodmart_category_thumb_double_size( $category ) {
		$small_thumbnail_size  	= apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
		$dimensions    			= wc_get_image_size( $small_thumbnail_size );
		$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
		$attr_height 			= '';

		if( woodmart_loop_prop( 'double_size' ) ) {
			$small_thumbnail_size = 'woodmart_shop_catalog_x2';
			$dimensions['width'] *= 2;
			if ( $dimensions['height'] ) {
				$dimensions['height'] *= 2;
				$attr_height = 'height="' . esc_attr( $dimensions['height'] ) . '"';
			}
		}

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
			$image = $image[0];
		} else {
			$image = wc_placeholder_img_src();
		}

		if ( $image ) {
			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: https://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			echo apply_filters('woodmart_attachment', '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" ' . $attr_height . ' />', $thumbnail_id, $small_thumbnail_size );
		}
	}
}

remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
add_action( 'woocommerce_before_subcategory_title', 'woodmart_category_thumb_double_size', 10 );


/**
 * ------------------------------------------------------------------------------------------------
 * Quick View button
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_quick_view_btn' ) ) {
	function woodmart_quick_view_btn( $id = false ) {
		if( ! $id ) $id = get_the_ID();

		if ( woodmart_get_opt( 'quick_view' ) ): ?>
			<div class="quick-view">
				<a 
					href="<?php echo esc_url( get_the_permalink( $id ) ); ?>" 
					class="open-quick-view" 
					data-id="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Quick View', 'woodmart' ); ?></a>
			</div>
		<?php endif;

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Quick shop element
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_quick_shop_wrapper' ) ) {
	function woodmart_quick_shop_wrapper() {
		global $product;
		?>
			<div class="quick-shop-wrapper">
				<div class="quick-shop-close"><span><?php esc_html_e('Close', 'woodmart'); ?></span></div>
				<div class="quick-shop-form">
				</div>
			</div>
		<?php
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Show attribute swatches list
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_swatches_list' ) ) {
	function woodmart_swatches_list( $attribute_name = false ) {
		global $product;

		$id = $product->get_id();

		if( empty( $id ) || ! $product->is_type( 'variable' ) ) return false;
		
		if( ! $attribute_name ) {
			$attribute_name = woodmart_grid_swatches_attribute();
		}
		
		if( empty( $attribute_name ) ) return false;

		$available_variations = $product->get_available_variations();

		if( empty( $available_variations ) ) return false;

		$swatches_to_show = woodmart_get_option_variations(  $attribute_name, $available_variations, false, $id );

		if( empty( $swatches_to_show ) ) return false;
		$out = '';

		$out .=  '<div class="swatches-on-grid">';

		$swatch_size = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_size' );

		if( apply_filters( 'woodmart_swatches_on_grid_right_order', true ) ) {
			$terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'slugs' ) );

			$swatches_to_show_tmp = $swatches_to_show;

			$swatches_to_show = array();

			foreach ($terms as $id => $slug) {
				//Fixed php notice
				if ( ! isset( $swatches_to_show_tmp[$slug] ) ) continue;
				$swatches_to_show[$slug] = $swatches_to_show_tmp[$slug];
			}
		}

		foreach ($swatches_to_show as $key => $swatch) {
			$style = $class = '';

			if( ! empty( $swatch['color'] )) {
				$style = 'background-color:' .  $swatch['color'];
			} else if( ! empty( $swatch['image'] ) ) {
				$style = 'background-image: url(' . $swatch['image'] . ')';
			} else if( ! empty( $swatch['not_dropdown'] ) ) {
				$class .= 'text-only ';
			}

			$style .= ';';

			$data = '';

			if( isset( $swatch['image_src'] ) ) {
				$class .= 'swatch-has-image';
				$data .= 'data-image-src="' . $swatch['image_src'] . '"';
				$data .= ' data-image-srcset="' . $swatch['image_srcset'] . '"';
				$data .= ' data-image-sizes="' . $swatch['image_sizes'] . '"';
				if( woodmart_get_opt( 'swatches_use_variation_images' ) ) {
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $swatch['variation_id'] ), 'woocommerce_thumbnail');
					if ( !empty( $thumb ) ) {
						$style = 'background-image: url(' . $thumb[0] . ')';
						$class .= ' variation-image-used';
					}
				}

				if( ! $swatch['is_in_stock'] ) {
					$class .= ' variation-out-of-stock';
				}
			}

			$class .= ' swatch-size-' . $swatch_size;

			$term = get_term_by( 'slug', $key, $attribute_name );

			$out .=  '<div class="swatch-on-grid woodmart-tooltip ' . esc_attr( $class ) . '" style="' . esc_attr( $style ) .'" ' . $data . '>' . $term->name . '</div>';
		}

		$out .=  '</div>';

		return $out;

	}
}


if( ! function_exists( 'woodmart_grid_swatches_attribute' ) ) {
	function woodmart_grid_swatches_attribute() {
		$custom = get_post_meta(get_the_ID(),  '_woodmart_swatches_attribute', true );
		return empty( $custom ) ? woodmart_get_opt( 'grid_swatches_attribute' ) : $custom;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Product deal countdown
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_product_sale_countdown' ) ) {
	function woodmart_product_sale_countdown() {
		global $post;
        $sale_date_end = get_post_meta( $post->ID, '_sale_price_dates_to', true );
		$sale_date_start = get_post_meta( $post->ID, '_sale_price_dates_from', true );
		
		$curent_date = strtotime( date( 'Y-m-d H:i:s' ) );

        if( $sale_date_end < $curent_date || $curent_date < $sale_date_start ) return;

        $timezone = 'GMT';

        if ( apply_filters( 'woodmart_wp_timezone', false ) ) $timezone = wc_timezone_string();
        
		woodmart_enqueue_script( 'woodmart-countdown' );
       
		echo '<div class="woodmart-product-countdown woodmart-timer" data-end-date="' . esc_attr( date( 'Y-m-d H:i:s', $sale_date_end ) ) . '" data-timezone="' . $timezone . '"></div>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Brand image
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_brand' ) ) {
	function woodmart_product_brand() {
		global $product;
		$attr = woodmart_get_opt( 'brands_attribute' );
		if( ! $attr || ! woodmart_get_opt( 'product_page_brand' ) ) return;

		$attributes = $product->get_attributes();

		if( ! isset( $attributes[ $attr ] ) || empty( $attributes[ $attr ] ) ) return;

		$brands = wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'all' ) );

		if( empty( $brands ) ) return;

		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} else {
			$link = get_post_type_archive_link( 'product' );
		}

		$classes = ( woodmart_get_opt( 'product_brand_location' ) == 'sidebar' && ! woodmart_loop_prop( 'is_quick_view' ) ) ? 'widget sidebar-widget' : '';

		echo '<div class="woodmart-product-brands '. esc_attr( $classes ) .'">';

		foreach ($brands as $brand) {
			$image = get_term_meta( $brand->term_id, 'image', true);
			$filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $attr ) );

			$attr_link = apply_filters( 'woodmart_brands_link', add_query_arg( $filter_name, $brand->slug, $link ), $brand );

			if( ! empty( $image ) ) {
				echo '<div class="woodmart-product-brand">';
					echo '<a href="' . esc_url( $attr_link ) . '"><img src="' . esc_url( $image ) . '" title="' . esc_attr( $brand->slug ) . '" alt="' . esc_attr( $brand->slug ) . '" /></a>';
				echo '</div>';
			}

		}

		echo '</div>';

	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Hover image
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_hover_image' ) ) {
	function woodmart_hover_image() {
		global $product;
	
		$attachment_ids = $product->get_gallery_image_ids();

		$hover_image = '';

		if ( ! empty( $attachment_ids[0] ) ) {
			$hover_image = woodmart_get_product_thumbnail( 'woocommerce_thumbnail', $attachment_ids[0] );
		}

		if( $hover_image != '' && woodmart_get_opt( 'hover_image' ) ): ?>
			<div class="hover-img">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php echo ( $hover_image ); ?>
				</a>
			</div>
		<?php endif;

	}
}


if( ! function_exists( 'woodmart_products_nav' ) ) {
	function woodmart_products_nav() {
	    $next = get_next_post();
	    $prev = get_previous_post();

	    $next = ( ! empty( $next ) ) ? wc_get_product( $next->ID ) : false;
	    $prev = ( ! empty( $prev ) ) ? wc_get_product( $prev->ID ) : false;

		?>
			<div class="woodmart-products-nav">
				<?php if ( ! empty( $prev ) ): ?>
				<div class="product-btn product-prev">
					<a href="<?php echo esc_url( $prev->get_permalink() ); ?>"><?php esc_html_e('Previous product', 'woodmart'); ?><span class="product-btn-icon"></span></a>
					<div class="wrapper-short">
						<div class="product-short">
							<div class="product-short-image">
								<a href="<?php echo esc_url( $prev->get_permalink() ); ?>" class="product-thumb">
									<?php echo $prev->get_image();?>
								</a>
							</div>
							<div class="product-short-description">
								<a href="<?php echo esc_url( $prev->get_permalink() ); ?>" class="product-title">
									<?php echo esc_html( $prev->get_title() ); ?>
								</a>
								<span class="price">
									<?php echo $prev->get_price_html(); ?>
								</span>
							</div>
						</div>
					</div>
				</div>
				<?php endif ?>

				<?php woodmart_back_btn();  ?>

				<?php if ( ! empty( $next ) ): ?>
				<div class="product-btn product-next">
					<a href="<?php echo esc_url( $next->get_permalink() ); ?>"><?php esc_html_e('Next product', 'woodmart'); ?><span class="product-btn-icon"></span></a>
					<div class="wrapper-short">
						<div class="product-short">
							<div class="product-short-image">
								<a href="<?php echo esc_url( $next->get_permalink() ); ?>" class="product-thumb">
									<?php echo $next->get_image(); ?>
								</a>
							</div>
							<div class="product-short-description">
								<a href="<?php echo esc_url( $next->get_permalink() ); ?>" class="product-title">
									<?php echo esc_html( $next->get_title() ); ?>
								</a>
								<span class="price">
									<?php echo $next->get_price_html(); ?>
								</span>
							</div>
						</div>
					</div>
				</div>
				<?php endif ?>
			</div>
		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Compare button
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_configure_compare' ) ) {
	add_action( 'init', 'woodmart_configure_compare' );
	function woodmart_configure_compare() {
		global $yith_woocompare;
		if( ! class_exists( 'YITH_Woocompare' ) ) return;

		$compare = $yith_woocompare->obj;

		if ( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ) {
			remove_action( 'woocommerce_after_shop_loop_item', array( $compare, 'add_compare_link' ), 20 );
		}

        if ( get_option('yith_woocompare_compare_button_in_product_page') == 'yes' ) {
        	add_action( 'woocommerce_single_product_summary', 'woodmart_before_compare_button', 33 );
        	add_action( 'woocommerce_single_product_summary', 'woodmart_after_compare_button', 37 );
        }

	}
}

if( ! function_exists( 'woodmart_before_compare_button' ) ) {
	function woodmart_before_compare_button() {
		echo '<div class="compare-btn-wrapper">';
	}
}

if( ! function_exists( 'woodmart_after_compare_button' ) ) {
	function woodmart_after_compare_button() {
		echo '</div>';
	}
}

if( ! function_exists( 'woodmart_compare_btn' ) ) {
	function woodmart_compare_btn() {
		if( ! class_exists( 'YITH_Woocompare' ) ) return;

		if( get_option('yith_woocompare_compare_button_in_products_list') != 'yes' ) return;

		echo '<div class="product-compare-button">';
            global $product;
            $product_id = $product->get_id();

            // return if product doesn't exist
            if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
	            return;

            $is_button = ! isset( $button_or_link ) || ! $button_or_link ? get_option( 'yith_woocompare_is_button' ) : $button_or_link;

            if ( ! isset( $button_text ) || $button_text == 'default' ) {
                $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'woodmart' ) );
            }

            printf( '<a href="%s" class="%s" data-product_id="%d" rel="nofollow">%s</a>', woodmart_compare_add_product_url( $product_id ), 'compare' . ( $is_button == 'button' ? ' button' : '' ), $product_id, $button_text );
        
		echo '</div>';
	}
}


if( ! function_exists( 'woodmart_compare_add_product_url' ) ) {
    function woodmart_compare_add_product_url( $product_id ) {
    	$action_add = 'yith-woocompare-add-product';
        $url_args = array(
            'action' => 'asd',
            'id' => $product_id
        );
        return apply_filters( 'yith_woocompare_add_product_url', esc_url_raw( add_query_arg( $url_args ) ), $action_add );
    }
}


if( ! function_exists( 'woodmart_compare_styles' ) ) {
	add_action( 'wp_print_styles', 'woodmart_compare_styles', 200 );
	function woodmart_compare_styles() {
		if( ! class_exists( 'YITH_Woocompare' ) ) return;
		$view_action = 'yith-woocompare-view-table';
		if ( ( ! defined('DOING_AJAX') || ! DOING_AJAX ) && ( ! isset( $_REQUEST['action'] ) || $_REQUEST['action'] != $view_action ) ) return;
		wp_enqueue_style( 'woodmart-style' );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * WishList button
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_wishlist_btn' ) ) {
	function woodmart_wishlist_btn() {
		if( class_exists('YITH_WCWL_Shortcode')) echo YITH_WCWL_Shortcode::add_to_wishlist(array());
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get product page classes (columns) for product images and product information blocks
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_images_class' ) ) {
	function woodmart_product_images_class() {
		$size = woodmart_product_images_size();
		$layout = woodmart_get_opt( 'single_product_style' );
		
		$class = 'col-md-' . $size . ' col-xs-12';

		$class .= ( $layout == 4 || $layout == 5 ) ? ' col-sm-12' : ' col-sm-6';

		return $class;
	}

	function woodmart_product_images_size() {
		$summary_size = ( woodmart_product_summary_size() == 12 ) ? 12 : 12 - woodmart_product_summary_size();
		return apply_filters( 'woodmart_product_summary_size', $summary_size );
	}
}

if( ! function_exists( 'woodmart_product_summary_class' ) ) {
	function woodmart_product_summary_class() {
		$size = woodmart_product_summary_size();
		$layout = woodmart_get_opt( 'single_product_style' );
		
		$class = 'col-md-' . $size . ' col-xs-12';

		$class .= ( $layout == 4 || $layout == 5 ) ? ' col-sm-12' : ' col-sm-6';

		return $class;
	}

	function woodmart_product_summary_size() {
		$page_layout = woodmart_get_opt( 'single_product_style' );

		$size = 6;
		switch ( $page_layout ) {
			case 1:
				$size = 8;
			break;
			case 2:
				$size = 6;
			break;
			case 3:
				$size = 4;
			break;
			case 4:
				$size = 12;
			break;
			case 5:
				$size = 12;
			break;
		}
		return apply_filters( 'woodmart_product_summary_size', $size );
	}
}

if( ! function_exists( 'woodmart_single_product_class' ) ) {
	function woodmart_single_product_class() {
		global $product;
		$classes = array();
		$classes[] = 'single-product-page';
		$classes[] = 'single-product-content';

		$design = woodmart_product_design();
		$product_bg  = woodmart_get_opt( 'product-background' );
		$attachment_ids = $product->get_gallery_image_ids();
		$page_layout = woodmart_get_opt( 'single_product_style' );
		
		$classes[] = 'product-design-' . $design;
		$classes[] = 'tabs-location-' . woodmart_get_opt( 'product_tabs_location' );
		$classes[] = 'tabs-type-' . woodmart_get_opt( 'product_tabs_layout' );
		$classes[] = 'meta-location-' . woodmart_get_opt( 'product_show_meta' );
		$classes[] = 'reviews-location-' . woodmart_get_opt( 'reviews_location' );

		if( $design == 'alt' ) {
			$classes[] = 'product-align-center';
		}

		if( $page_layout == 4 || $page_layout == 5 ) {
			$classes[] = 'image-full-width';
		}

		if( woodmart_get_opt( 'single_full_width' ) ) {
			$classes[] = 'product-full-width';
		}

		if( woodmart_get_opt( 'product_summary_shadow' ) ) {
			$classes[] = 'product-summary-shadow';
		}

		if( woodmart_product_sticky() ) {
			$classes[] = 'product-sticky-on';
		}

		if( ! empty( $product_bg ) &&  ! empty( $product_bg['background-color'] ) ) {
			$classes[] = 'product-has-bg';
		} else {
			$classes[] = 'product-no-bg';
		}

		if( $attachment_ids ) {
			$classes[] = 'product-with-attachments';
		}

		return $classes;

	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Configure product image gallery JS
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_product_gallery_settings' ) ) {
	function woodmart_get_product_gallery_settings() {
		return apply_filters( 'woodmart_product_gallery_settings', array(
			'images_slider' => woodmart_is_main_product_images_carousel(),
			'thumbs_slider' => array(
				'enabled' => woodmart_is_product_thumb_enabled(),
				'position' => woodmart_get_opt('thums_position'),
				'items' => array(
					'desktop' => 4,
					'desktop_small' => 3,
					'tablet' => 4,
					'mobile' => 3,
					'vertical_items' => 3
				)
			)
		) );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Remove product content link
 * ------------------------------------------------------------------------------------------------
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

/**
 * ------------------------------------------------------------------------------------------------
 * WooCommerce enqueues 3 stylesheets by default. You can disable them all with the following snippet
 * ------------------------------------------------------------------------------------------------
 */

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * ------------------------------------------------------------------------------------------------
 * Disable photoswipe
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'wp_footer', 'woocommerce_photoswipe' );


/**
 * ------------------------------------------------------------------------------------------------
 * Change position of woocommerce notices
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
add_action( 'woocommerce_before_main_content', 'wc_print_notices', 50 );

/**
 * ------------------------------------------------------------------------------------------------
 * Remove ordering from toolbar
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );


/**
 * ------------------------------------------------------------------------------------------------
 * Unhook the WooCommerce wrappers
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


/**
 * ------------------------------------------------------------------------------------------------
 * hook in your own functions to display the wrappers your theme requires
 * ------------------------------------------------------------------------------------------------
 */


/**
 * ------------------------------------------------------------------------------------------------
 * Get CSS class for widget in shop area. Based on the number of widgets
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_widget_column_class' ) ) {
	function woodmart_get_widget_column_class( $sidebar_id = 'filters-area' ) {
		global $_wp_sidebars_widgets;
		if ( empty( $_wp_sidebars_widgets ) ) :
			$_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
		endif;
		
		$sidebars_widgets_count = $_wp_sidebars_widgets;

		if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) || $sidebar_id == 'filters-area' ) {
			$count = ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) ? count( $sidebars_widgets_count[ $sidebar_id ] ) : 0;
			$widget_count = apply_filters( 'widgets_count_' . $sidebar_id, $count );
			$widget_classes = 'widget-count-' . $widget_count;
			$widget_classes .= woodmart_get_grid_el_class( 0, ( ($widget_count > 4) ? 4 : $widget_count ), false, 12, 6, 6 );
			return apply_filters( 'widget_class_' . $sidebar_id, $widget_classes);
		}
	}
}
 

add_action('woocommerce_before_main_content', 'woodmart_woo_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'woodmart_woo_wrapper_end', 10);

if( ! function_exists( 'woodmart_woo_wrapper_start' ) ) {
	function woodmart_woo_wrapper_start() {
		$content_class = woodmart_get_content_class();
		$breadcrumbs_position = woodmart_get_opt( 'single_breadcrumbs_position' );
		$product_design = woodmart_get_opt( 'product_design' );

		if ( is_singular( 'product' ) ) {
			$content_class = 'col-sm-12';
			if ( $breadcrumbs_position == 'default' && $product_design == 'default' ) {
				$breadcrumbs_position = 'summary';
			} elseif ( $breadcrumbs_position == 'default' && $product_design == 'alt' ) {
				$breadcrumbs_position = 'below_header';
			}
			$content_class .= ' breadcrumbs-location-' . $breadcrumbs_position;
		} else {
			$content_class .= ' description-area-' . woodmart_get_opt( 'cat_desc_position' );
		}

        if ( have_posts() ) {
			$content_class .= ' content-with-products';
        } else {
			$content_class .= ' content-without-products';
		}

		echo '<div class="site-content shop-content-area ' . $content_class . '" role="main">';
	}
}


if( ! function_exists( 'woodmart_woo_wrapper_end' ) ) {
	function woodmart_woo_wrapper_end() {
		echo '</div>';
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * My account sidebar
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_before_my_account_navigation' ) ) {
	function woodmart_before_my_account_navigation() {
		echo '<div class="woodmart-my-account-sidebar">';
		if(!function_exists('woodmart_my_account_title')) {
			the_title( '<h3 class="woocommerce-MyAccount-title entry-title">', '</h3>' );
		}
	}

	add_action( 'woocommerce_account_navigation', 'woodmart_before_my_account_navigation', 5 );
}

if( ! function_exists( 'woodmart_after_my_account_navigation' ) ) {
	function woodmart_after_my_account_navigation() {
		$sidebar_name = 'sidebar-my-account';
		if ( is_active_sidebar( $sidebar_name ) ) : ?>
			<aside class="sidebar-container" role="complementary">
				<div class="sidebar-inner">
					<div class="widget-area">
						<?php dynamic_sidebar( $sidebar_name ); ?>
					</div><!-- .widget-area -->
				</div><!-- .sidebar-inner -->
			</aside><!-- .sidebar-container -->
		<?php endif;
		echo '</div><!-- .woodmart-my-account-sidebar -->';
	}

	add_action( 'woocommerce_account_navigation', 'woodmart_after_my_account_navigation', 30 );
}



/**
 * ------------------------------------------------------------------------------------------------
 * Play with woocommerce hooks
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_woocommerce_hooks' ) ) {
	function woodmart_woocommerce_hooks() {
        global $woodmart_prefix;

        $product_meta_position = woodmart_get_opt( 'product_show_meta' );
        $product_show_meta = ( $product_meta_position != 'hide' );
        $product_show_share = woodmart_get_opt( 'product_share' );
        $product_show_descr = woodmart_get_opt( 'product_short_description' );
        $tabs_location = woodmart_get_opt( 'product_tabs_location' );
        $reviews_location = woodmart_get_opt( 'reviews_location' );

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		// Reviews location
		if( $reviews_location == 'separate' ) {
			add_filter( 'woocommerce_product_tabs', 'woodmart_disable_reviews_tab', 98 );
			add_action( 'woocommerce_after_single_product_summary', 'comments_template', 50 );
		}

		// Upsells position
		if( is_singular( 'product' ) ) {
			if( woodmart_get_opt( 'upsells_position' )  == 'sidebar' ) {
				add_action( 'woodmart_before_sidebar_area', 'woocommerce_upsell_display', 20 );
			} else {
				add_action( 'woodmart_woocommerce_after_sidebar', 'woocommerce_upsell_display', 10 );
			}
		}

		// Disable related products option
		if( woodmart_get_opt('related_products') && ! get_post_meta(get_the_ID(),  '_woodmart_related_off', true ) ) {
			add_action( 'woodmart_woocommerce_after_sidebar', 'woocommerce_output_related_products', 20 );
		}

		// Disable product tabs title option
		if( woodmart_get_opt('hide_tabs_titles') || get_post_meta(get_the_ID(),  '_woodmart_hide_tabs_titles', true ) ) {
			add_filter( 'woocommerce_product_description_heading', '__return_false', 20 );
			add_filter( 'woocommerce_product_additional_information_heading', '__return_false', 20 );
		}

		if( woodmart_get_opt('shop_filters') ) {
 			
 			// Use our own order widget list?
			if( apply_filters( 'woodmart_use_custom_order_widget', true ) ) {
				if( ! is_active_widget( false, false, 'woodmart-woocommerce-sort-by', true ) ) {
					add_action( 'woodmart_before_filters_widgets', 'woodmart_sorting_widget', 10 );
				}
				if ( woodmart_get_opt( 'shop_filters_type' ) == 'widgets' ) {
					remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
				}
			}

			// Use our custom price filter widget list?
			if( apply_filters( 'woodmart_use_custom_price_widget', true )  && ! is_active_widget( false, false, 'woodmart-price-filter', true ) ) {
				add_action( 'woodmart_before_filters_widgets', 'woodmart_price_widget', 20 );
			}

			// Add 'filters button'
			add_action( 'woocommerce_before_shop_loop', 'woodmart_filter_buttons', 40 );
		}

		add_action( 'woocommerce_cart_is_empty', 'woodmart_empty_cart_text', 20 );

		// Wrapp cart totals

		add_action( 'woocommerce_before_cart_totals', function() {
			echo '<div class="cart-totals-inner">';
		}, 1);
		add_action( 'woocommerce_after_cart_totals', function() {
			echo '</div><!--.cart-totals-inner-->';
		}, 200);

		// Brand tab for single product
		if( woodmart_get_opt( 'brand_tab' ) ) {
			add_filter( 'woocommerce_product_tabs', 'woodmart_product_brand_tab' );
		}

		// Poduct brand
		if( woodmart_get_opt( 'product_brand_location' ) == 'about_title' && is_singular( 'product' ) ) {
			add_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 3);
		} elseif( is_singular( 'product' )) {
			add_action( 'woodmart_before_sidebar_area', 'woodmart_product_brand', 10 );
		}

		// Product share

		if ( $product_meta_position != 'after_tabs' && $product_show_share ) {
			add_action( 'woocommerce_single_product_summary', 'woodmart_product_share_buttons', 60 );
		}

		// Disable meta and description if turned off
		if ( $product_meta_position != 'add_to_cart' ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}

		if ( ! $product_show_descr ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		}

		// Product tabs location

		if( $tabs_location == 'summary' ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 39 );
		}


		if ( $product_meta_position == 'after_tabs' ) {
			add_action( 'woodmart_after_product_tabs', function() {
				echo '<div class="woodmart-before-product-tabs"><div class="container">';
			}, 10 );

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			if( $product_show_meta ) add_action( 'woodmart_after_product_tabs', 'woocommerce_template_single_meta', 20 );
			if( $product_show_share ) add_action( 'woodmart_after_product_tabs', 'woodmart_product_share_buttons', 30 );

			add_action( 'woodmart_after_product_tabs', function() {
				echo '</div></div>';
			}, 200 );
		}

		// Product video, 360 view, zoom
		$video_url = get_post_meta(get_the_ID(),  '_woodmart_product_video', true );
		$images_360_gallery = woodmart_get_360_gallery_attachment_ids();
		$image_action = woodmart_get_opt( 'image_action' );

		if( ! empty( $video_url ) || ! empty( $images_360_gallery ) || ! empty( $image_action ) ) {
			add_action( 'woodmart_on_product_image', 'woodmart_additional_galleries_open', 25 );
			add_action( 'woodmart_on_product_image', 'woodmart_additional_galleries_close', 100 );
		}
		
		if( ! empty( $video_url ) ) {
			add_action( 'woodmart_on_product_image', 'woodmart_product_video_button', 30 );
		}

		if( ! empty( $images_360_gallery ) ) {
			add_action( 'woodmart_on_product_image', 'woodmart_product_360_view', 40 );
		}

		if( $image_action != 'popup' && woodmart_get_opt( 'photoswipe_icon' ) ) {
			add_action( 'woodmart_on_product_image', 'woodmart_product_zoom_button', 50 );
		}

		// Custom extra content
		$extra_block = get_post_meta(get_the_ID(),  '_woodmart_extra_content', true );

		if( ! empty( $extra_block ) && $extra_block != 0 ) {
			$extra_position = get_post_meta(get_the_ID(),  '_woodmart_extra_position', true );
			if( $extra_position == 'before' ) {
				add_action( 'woocommerce_before_single_product', 'woodmart_product_extra_content', 20 );
			} else if( $extra_position == 'prefooter' ) {
				add_action( 'woodmart_woocommerce_after_sidebar', 'woodmart_product_extra_content', 30 );
			} else {
				add_action( 'woodmart_after_product_content', 'woodmart_product_extra_content', 20 );
				
			}
		}


		// Custom tabs
		add_filter( 'woocommerce_product_tabs', 'woodmart_custom_product_tabs' );

		// Timer on the single product page
		add_action( 'woocommerce_single_product_summary', 'woodmart_single_product_countdown', 15 );

		// Instagram by hashbat for product
		add_action( 'woodmart_woocommerce_after_sidebar', 'woodmart_product_instagram', 80 );

		// Cart page move totals
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

		//Product attibutes after of short description
		if ( woodmart_get_opt( 'attr_after_short_desc' ) ) {
			add_action( 'woocommerce_single_product_summary', 'woodmart_display_product_attributes', 21 );
			add_filter( 'woocommerce_product_tabs', 'woodmart_remove_additional_information_tab', 98 );
		}
	}

	add_action( 'wp', 'woodmart_woocommerce_hooks', 1000 );
}


if( ! function_exists( 'woodmart_single_product_countdown' ) ) {
	function woodmart_single_product_countdown( $tabs ) {
		$timer = woodmart_get_opt( 'product_countdown' );
		if( $timer ) woodmart_product_sale_countdown();
	}
}

if( ! function_exists( 'woodmart_display_product_attributes' ) ) {
	function woodmart_display_product_attributes() {
		global $product;
		if ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
			wc_display_product_attributes( $product );
		}
	}
}

if( ! function_exists( 'woodmart_remove_additional_information_tab' ) ) {
	function woodmart_remove_additional_information_tab( $tabs ) {
		unset( $tabs['additional_information'] );
		return $tabs;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Extra content block
 * ------------------------------------------------------------------------------------------------
 */


if( ! function_exists( 'woodmart_product_extra_content' ) ) {
	function woodmart_product_extra_content( $tabs ) { 
		$extra_block = get_post_meta(get_the_ID(),  '_woodmart_extra_content', true );
		echo '<div class="product-extra-content">' . woodmart_html_block_shortcode( array( 'id' => $extra_block ) ) . '</div>';
	}
}
		

/**
 * ------------------------------------------------------------------------------------------------
 * Additional tab
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_custom_product_tabs' ) ) {
	function woodmart_custom_product_tabs( $tabs ) {
		$additional_tab_title = woodmart_get_opt( 'additional_tab_title' );
		$custom_tab_title = get_post_meta( get_the_ID(),  '_woodmart_product_custom_tab_title', true );
		
		if ( $additional_tab_title ) {
			$tabs['woodmart_additional_tab'] = array(
				'title' 	=> $additional_tab_title,
				'priority' 	=> 50,
				'callback' 	=> 'woodmart_additional_product_tab_content'
			);
		}
		
		if ( $custom_tab_title ) {
			$tabs['woodmart_custom_tab'] = array(
				'title' 	=> $custom_tab_title,
				'priority' 	=> 60,
				'callback' 	=> 'woodmart_custom_product_tab_content'
			);
		}
		
		return $tabs;
	}
}

if( ! function_exists( 'woodmart_additional_product_tab_content' ) ) {
	function woodmart_additional_product_tab_content() {
		// The new tab content
		$tab_content = woodmart_get_opt( 'additional_tab_text' );
		echo do_shortcode( $tab_content );
		
	}
}

if( ! function_exists( 'woodmart_custom_product_tab_content' ) ) {
	function woodmart_custom_product_tab_content() {
		// The new tab content
		$tab_content = get_post_meta( get_the_ID(),  '_woodmart_product_custom_tab_content', true );
		echo do_shortcode( $tab_content );
	}
}


if( ! function_exists( 'woodmart_disable_reviews_tab' ) ) {
	function woodmart_disable_reviews_tab( $tabs ) {
	    unset( $tabs['reviews'] );  // Removes the reviews tab
	    return $tabs;
	}
}



/**
 * ------------------------------------------------------------------------------------------------
 * Product video, 360 view, zoom buttons
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_video_button' ) ) {
	function woodmart_product_video_button() {
		$video_url = get_post_meta(get_the_ID(),  '_woodmart_product_video', true );
		?>
			<div class="product-video-button">
				<a href="<?php echo esc_url( $video_url ); ?>"><span><?php esc_html_e('Watch video', 'woodmart'); ?></span></a>
			</div>
		<?php
	}
}

if( ! function_exists( 'woodmart_product_zoom_button' ) ) {
	function woodmart_product_zoom_button() {
		woodmart_enqueue_script( 'woodmart-photoswipe' );
		?>
			<div class="woodmart-show-product-gallery-wrap"><a href="#" class="woodmart-show-product-gallery"><span><?php esc_html_e('Click to enlarge', 'woodmart'); ?></span></a></div>
		<?php
	}
}

if( ! function_exists( 'woodmart_additional_galleries_open' ) ) {
	function woodmart_additional_galleries_open() {
		?>
			<div class="product-additional-galleries">
		<?php
	}
}

if( ! function_exists( 'woodmart_additional_galleries_close' ) ) {
	function woodmart_additional_galleries_close() {
		?>
			</div>
		<?php
	}
}


if( ! function_exists( 'woodmart_product_360_view' ) ) {
	function woodmart_product_360_view() {
		$images = woodmart_get_360_gallery_attachment_ids();
		if( empty( $images ) ) return;

		$id = rand(100,999);

		$title = '';

		$frames_count = count( $images );

		$images_js_string = '';

		?>
			<div class="product-360-button">
				<a href="#product-360-view"><span><?php esc_html_e('360 product view', 'woodmart'); ?></span></a>
			</div>
			<div id="product-360-view" class="product-360-view-wrapper mfp-hide">
				<div class="woodmart-threed-view threed-id-<?php echo esc_attr( $id ); ?>">
					<?php if ( ! empty( $title ) ): ?>
						<h3 class="threed-title"><span><?php echo ($title); ?></span></h3>
					<?php endif ?>
					<ul class="threed-view-images">
						<?php if ( count($images) > 0 ): ?>
							<?php $i=0; foreach ($images as $img_id): $i++; ?>
								<?php 
									$img = wp_get_attachment_image_src( $img_id, 'full' );
									$width = $img[1];
									$height = $img[2];
									$images_js_string .= "'" . $img[0] . "'"; 
									if( $i < $frames_count ) {
										$images_js_string .= ","; 
									}
								?>
							<?php endforeach ?>
						<?php endif ?>
					</ul>
				    <div class="spinner">
				        <span>0%</span>
				    </div>
				</div>
			</div>
		<?php
		woodmart_enqueue_script( 'woodmart-threesixty' );
		
		wp_add_inline_script('woodmart-theme', 'jQuery(document).ready(function( $ ) {
		    $(".threed-id-' . esc_js( $id ) . '").ThreeSixty({
		        totalFrames: ' . esc_js( $frames_count ) . ',
		        endFrame: ' . esc_js( $frames_count ) . ',
		        currentFrame: 1,
		        imgList: ".threed-view-images",
		        progress: ".spinner",
		        imgArray: ' . "[".$images_js_string."]" . ',
		        height: ' . esc_js( $height ) . ', 	
		        width: ' . esc_js( $width ) . ',
		        responsive: true,
		        navigation: true
		    });
		});', 'after');
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Single product share buttons
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_share_buttons' ) ) {
	function woodmart_product_share_buttons() {
		$type = woodmart_get_opt( 'product_share_type' );
		?>
			<?php if ( woodmart_is_social_link_enable( $type ) ): ?>
				<div class="product-share">
					<span class="share-title"><?php echo ($type == 'share') ? esc_html__('Share', 'woodmart') :  esc_html__('Follow', 'woodmart'); ?></span>
					<?php echo woodmart_shortcode_social( array( 'type' => $type, 'size' => 'small' ) ); ?>
				</div>
			<?php endif ?>
		<?php
	}
}



/**
 * ------------------------------------------------------------------------------------------------
 * Instagram by hashtag for products
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_instagram' ) ) {
	function woodmart_product_instagram() {
		$hashtag = get_post_meta(get_the_ID(),  '_woodmart_product_hashtag', true );
		if( empty( $hashtag ) ) return;
		?>
			<div class="woodmart-product-instagram">
				<p class="product-instagram-intro"><?php printf( wp_kses( __('Tag your photos with <span>%s</span> on Instagram.', 'woodmart') , array('span' => array())), $hashtag ); ?></p>
				<?php echo woodmart_shortcode_instagram( array(
					'username' => esc_html( $hashtag ),
					'number' => 8,
					'size' => 'medium',
					'target' => '_blank',
					'spacing' => 0,
					'rounded' => 0,
					'per_row' => 4
				) ); ?>
			</div>
		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Filters buttons
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_filter_buttons' ) ) {
	function woodmart_filter_buttons() {
		$filters_type = woodmart_get_opt( 'shop_filters_type' ) ? woodmart_get_opt( 'shop_filters_type' ) : 'widgets';
		$always_open = woodmart_get_opt( 'shop_filters_always_open' );

		if ( wc_get_loop_prop( 'is_shortcode' ) || ! wc_get_loop_prop( 'is_paginated' ) || ( ! woocommerce_products_will_display() && $filters_type == 'widgets' ) || $always_open || ( $filters_type == 'content' && ! woodmart_get_opt( 'shop_filters_content' ) ) ) return;
		
		?>
			<div class="woodmart-filter-buttons">
				<a href="#" class="open-filters"><?php esc_html_e('Filters', 'woodmart'); ?></a>
			</div>
		<?php
	}
}

if( ! function_exists( 'woodmart_sorting_widget' ) ) {
	function woodmart_sorting_widget() {
		$filter_widget_class = woodmart_get_widget_column_class( 'filters-area' );
		the_widget( 'WOODMART_Widget_Sorting', array( 'title' => esc_html__('Sort by', 'woodmart') ), array(							
			'before_widget' => '<div id="WOODMART_Widget_Sorting" class="woodmart-widget widget filter-widget ' . esc_attr( $filter_widget_class ) . ' woodmart-woocommerce-sort-by">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>') 
		);
	}
}

if( ! function_exists( 'woodmart_price_widget' ) ) {
	function woodmart_price_widget() {
		$filter_widget_class = woodmart_get_widget_column_class( 'filters-area' );
		the_widget( 'WOODMART_Widget_Price_Filter', array( 'title' => esc_html__('Price filter', 'woodmart') ), array(							
			'before_widget' => '<div id="WOODMART_Widget_Price_Filter" class="woodmart-widget widget filter-widget ' . esc_attr( $filter_widget_class ) . ' woodmart-price-filter">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>') 
		);
	}
}

if( ! function_exists( 'woodmart_filter_widgts_classes' ) ) {
	function woodmart_filter_widgts_classes( $count ) {

		if( apply_filters( 'woodmart_use_custom_order_widget', true )  && ! is_active_widget( false, false, 'woodmart-woocommerce-sort-by', true ) ) {
			$count++;
		}

		if( apply_filters( 'woodmart_use_custom_price_widget', true )  && ! is_active_widget( false, false, 'woodmart-price-filter', true ) ) {
			$count++;
		}

		return $count;
	}

	add_filter('widgets_count_filters-area', 'woodmart_filter_widgts_classes');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Add product brand tab to the single product page
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_brand_tab' ) ) {
	function woodmart_product_brand_tab( $tabs ) {
		global $product;
		
		$show_tab = false;
		$brand_title = esc_html__( 'About brand', 'woodmart' );
		$brand_info = wc_get_product_terms( $product->get_id(), woodmart_get_opt( 'brands_attribute' ), array( 'fields' => 'all' ) );
		if ( !isset( $brand_info[0] ) ) return $tabs;
		
		if ( $brand_info[0]->description ) $show_tab = true;
		if ( woodmart_get_opt( 'brand_tab_name' ) ) $brand_title = sprintf( esc_html__( 'About %s', 'woodmart' ), $brand_info[0]->name );
		
		if ( $show_tab ) {
			$tabs['brand_tab'] = array(
				'title' 	=> $brand_title,
				'priority' 	=> 50,
				'callback' 	=> 'woodmart_product_brand_tab_content'
			);
		}

		return $tabs;
	}
}

if( ! function_exists( 'woodmart_product_brand_tab_content' ) ) {
	function woodmart_product_brand_tab_content() {
		global $product;
		$attr = woodmart_get_opt( 'brands_attribute' );
		if ( ! $attr ) return;

		$attributes = $product->get_attributes();

		if ( ! isset( $attributes[ $attr ] ) || empty( $attributes[ $attr ] ) ) return;

		$brands = wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'slugs' ) );

		if ( empty( $brands ) ) return;

		foreach ($brands as $id => $slug) {
			echo '<div class="woodmart-product-brand-description">';
				$brand = get_term_by('slug', $slug, $attr);
				echo do_shortcode( $brand->description );
			echo '</div>';
		}

	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Force WOODMART Swatche layered nav and price widget to work
 * ------------------------------------------------------------------------------------------------
 */


add_filter( 'woocommerce_is_layered_nav_active', 'woodmart_is_layered_nav_active' );
if( ! function_exists( 'woodmart_is_layered_nav_active' ) ) {
	function woodmart_is_layered_nav_active() {
		return is_active_widget( false, false, 'woodmart-woocommerce-layered-nav', true );
	}
}

add_filter( 'woocommerce_is_price_filter_active', 'woodmart_is_layered_price_active' );

if( ! function_exists( 'woodmart_is_layered_price_active' ) ) {
	function woodmart_is_layered_price_active() {
		$result = is_active_widget( false, false, 'woodmart-price-filter', true );
		if( ! $result ) {
			$result = apply_filters( 'woodmart_use_custom_price_widget', true );
		}
		return $result;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Empty cart text
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_empty_cart_text' ) ) {
	add_action( 'woocommerce_cart_is_empty', 'woodmart_empty_cart_text', 20 );

	function woodmart_empty_cart_text() {
		$empty_cart_text = woodmart_get_opt( 'empty_cart_text' );

		if( ! empty( $empty_cart_text ) ) {
			?>
				<div class="woodmart-empty-cart-text"><?php echo wp_kses( $empty_cart_text, array('p' => array(), 'h1' => array(), 'h2' => array(), 'h3' => array(), 'strong' => array(), 'em' => array(), 'span' => array(), 'div' => array() , 'br' => array()) ); ?></div>
			<?php
		}
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Change the position of woocommerce breadcrumbs
 * ------------------------------------------------------------------------------------------------
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * ------------------------------------------------------------------------------------------------
 * Add photoswipe template to body
 * ------------------------------------------------------------------------------------------------
 */
add_action( 'woodmart_after_footer', 'woodmart_photoswipe_template', 1000 );
if( ! function_exists( 'woodmart_photoswipe_template' ) ) {
	function woodmart_photoswipe_template() {
		get_template_part('woocommerce/single-product/photo-swipe-template');
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Wrap shop tables with divs
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_open_table_wrapper_div' ) ) {
	function woodmart_open_table_wrapper_div() {
		echo '<div class="woodmart-table-wrapper">';
	}
	add_action( 'woocommerce_checkout_order_review', 'woodmart_open_table_wrapper_div', 7 );
}


if( ! function_exists( 'woodmart_close_table_wrapper_div' ) ) {
	function woodmart_close_table_wrapper_div() {
		echo '</div><!-- .woodmart-table-wrapper -->';
	}
	add_action( 'woocommerce_checkout_order_review', 'woodmart_close_table_wrapper_div', 13 );
}


// **********************************************************************// 
// ! Start woocommerce customer session
// **********************************************************************// 

if( ! function_exists( 'woodmart_set_customer_session' ) ) {

	add_action( 'woodmart_before_shop_page', 'woodmart_set_customer_session', 10 );

	function woodmart_set_customer_session() {
		if( ! function_exists( 'WC' ) ) return;
		if ( WC()->version > '2.1' && ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) ) :
			WC()->session->set_customer_session_cookie( true );
		endif;
	}
}

// **********************************************************************// 
// ! Items per page select on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_show_sidebar_btn' ) ) {
	
	add_action( 'woocommerce_before_shop_loop', 'woodmart_show_sidebar_btn', 25 );

	function woodmart_show_sidebar_btn() {
		if ( wc_get_loop_prop( 'is_shortcode' ) || ! wc_get_loop_prop( 'is_paginated' ) ) return;
		
		?>
			<div class="woodmart-show-sidebar-btn">
				<span class="woodmart-side-bar-icon"></span>
				<span><?php esc_html_e('Show sidebar', 'woodmart'); ?></span>
			</div>
		<?php

	}
}

// **********************************************************************// 
// ! Items per page select on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_products_per_page_select' ) ) {
	
	add_action( 'woocommerce_before_shop_loop', 'woodmart_products_per_page_select', 25 );

	function woodmart_products_per_page_select() {
		if ( ! woodmart_get_opt( 'per_page_links' ) || ( wc_get_loop_prop( 'is_shortcode' ) || ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) ) return;
		
		global $wp_query;

		$per_page_options = woodmart_get_opt('per_page_options');

		$products_per_page_options = (!empty($per_page_options)) ? explode(',', $per_page_options) : array(12,24,36,-1);

		?>

		<div class="woodmart-products-per-page">

			<span class="per-page-title"><?php esc_html_e('Show', 'woodmart'); ?></span>

				<?php
					foreach( $products_per_page_options as $key => $value ) :
						?>
							<a rel="nofollow" href="<?php echo add_query_arg('per_page', $value, woodmart_shop_page_link(true)); ?>" class="per-page-variation<?php echo ($value == woodmart_get_products_per_page()) ? ' current-variation' : ''; ?>">
								<span><?php
									$text = '%s';
									esc_html( printf( $text, $value == -1 ? esc_html__( 'All', 'woodmart' ) : $value ) );
								?></span>
							</a>
							<span class="per-page-border"></span>
				<?php endforeach; ?>
		</div>
		<?php
	}
}


if( ! function_exists( 'woodmart_products_per_page_action' ) ) {

	add_action( 'woodmart_before_shop_page', 'woodmart_products_per_page_action', 100 );

	function woodmart_products_per_page_action() {
		if ( isset( $_REQUEST['per_page'] ) ) :
			if( ! class_exists('WC_Session_Handler')) return;
			$s = WC()->session; // WC()->session
			$s->set( 'shop_per_page', intval( $_REQUEST['per_page'] ) );
		endif;
	}
}

// **********************************************************************// 
// ! Get Items per page number on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_products_per_page' ) ) {
	function woodmart_get_products_per_page() {
		if( ! class_exists('WC_Session_Handler') ) return;
		$s = WC()->session; // WC()->session

		if ( isset( $_REQUEST['per_page'] ) && ! empty( $_REQUEST['per_page'] ) ) :
			return intval( $_REQUEST['per_page'] );
		elseif ( $s->__isset( 'shop_per_page' ) ) :
			$val = $s->__get( 'shop_per_page' );
			if( ! empty( $val ) )
				return intval( $s->__get( 'shop_per_page' ) );
		endif;
		return intval( woodmart_get_opt('shop_per_page') );
	}
}


// **********************************************************************// 
// ! Items view select on the shop page
// **********************************************************************// 

if( ! function_exists( 'basel_products_view_select' ) ) {
	
	add_action( 'woocommerce_before_shop_loop', 'basel_products_view_select', 27 );

	function basel_products_view_select() {
		if ( wc_get_loop_prop( 'is_shortcode' ) || ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) return;

		$shop_view = woodmart_get_opt( 'shop_view' );

		$per_row_selector = woodmart_get_opt( 'per_row_columns_selector' );

		$per_row_options = woodmart_get_opt( 'products_columns_variations' );

		$current_shop_view = woodmart_get_shop_view();

		$current_per_row = woodmart_get_products_columns_per_row();

		$products_per_row_options = ( !empty( $per_row_options ) ) ? array_unique( $per_row_options ) : array(2,3,4);
		
		if( $shop_view == 'list' || ( $shop_view == 'grid' && !$per_row_selector ) || ( $shop_view == 'grid' && !$per_row_options )  ) return;
		
		?>
		<div class="woodmart-products-shop-view <?php echo esc_attr( 'products-view-' . $shop_view ); ?>">
			<?php if ( $shop_view != 'grid'): ?>
				
				<a rel="nofollow" href="<?php echo add_query_arg( 'shop_view', 'list', woodmart_shop_page_link( true ) ); ?>" class="shop-view per-row-list <?php echo ( 'list' == $current_shop_view ) ? 'current-variation' : ''; ?>">
					<?php
						echo woodmart_get_svg_content( 'list-style' );
					?>
				</a>
				
			<?php endif ?>
			<?php if ( $per_row_selector && $per_row_options ): ?>

				<?php foreach ( $products_per_row_options as $key => $value ) : if( $value == 0 ) continue; ?>

					<a rel="nofollow" href="<?php echo add_query_arg( array( 'per_row' => $value, 'shop_view' => 'grid' ) , woodmart_shop_page_link( true ) ); ?>" class="per-row-<?php echo esc_attr( $value ); ?> shop-view <?php echo ( $value == $current_per_row && $current_shop_view != 'list' ) ? 'current-variation' : ''; ?>">
						<?php
							echo woodmart_get_svg_content( 'column-' . $value );
						?>
					</a>

				<?php endforeach; ?>

			<?php elseif ( $per_row_selector && $per_row_options || $shop_view == 'grid_list' || $shop_view == 'list_grid' ) : ?>
				
				<a rel="nofollow" href="<?php echo add_query_arg( 'shop_view', 'grid', woodmart_shop_page_link( true ) ); ?>" class="shop-view <?php echo ( 'grid' == $current_shop_view ) ? 'current-variation' : ''; ?>">
					<?php
						echo woodmart_get_svg_content( 'column-3' );
					?>
				</a>
				
			<?php endif ?>
		</div>
		<?php
	}
}


if( ! function_exists( 'woodmart_shop_view_action' ) ) {

	add_action( 'woodmart_before_shop_page', 'woodmart_shop_view_action', 100 );

	function woodmart_shop_view_action() {
		if( ! class_exists('WC_Session_Handler')) return;
		$s = WC()->session; // WC()->session
		if ( is_null( $s ) ) return;

		if ( isset( $_REQUEST['shop_view'] ) ) {
			$s->set( 'shop_view', $_REQUEST['shop_view'] );
		}
		if ( isset( $_REQUEST['per_row'] ) ) {
			$s->set( 'shop_per_row', $_REQUEST['per_row'] );
		}
	}
}
// **********************************************************************// 
// ! Get Items per ROW number on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_products_columns_per_row' ) ) {
	function woodmart_get_products_columns_per_row() {
		if( ! class_exists('WC_Session_Handler') ) return;
		$s = WC()->session; // WC()->session
		if ( is_null( $s ) ) return intval( woodmart_get_opt('products_columns') );

		if ( isset( $_REQUEST['per_row'] ) ) {
			return intval( $_REQUEST['per_row'] );
		}elseif ( $s->__isset( 'shop_per_row' ) ) {
			return intval( $s->__get( 'shop_per_row' ) );
		}else {
			return intval( woodmart_get_opt('products_columns') );
		}
	}
}

if( ! function_exists( 'woodmart_get_shop_view' ) ) {
	function woodmart_get_shop_view() {
		if( ! class_exists('WC_Session_Handler') ) return;
		$s = WC()->session; // WC()->session
		if ( is_null( $s ) ) return woodmart_get_opt('shop_view');

		if ( isset( $_REQUEST['shop_view'] ) ) {
			return $_REQUEST['shop_view'];
		}elseif ( $s->__isset( 'shop_view' ) ) {
			return $s->__get( 'shop_view' );
		}else {
			$shop_view = woodmart_get_opt('shop_view');
			if ( $shop_view == 'grid_list' ) {
				return 'grid';
			}elseif( $shop_view == 'list_grid'){
				return 'list';
			}else{
				return $shop_view;
			}
		}
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Display categories menu
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_categories_nav' ) ) {
	function woodmart_product_categories_nav() {
		global $wp_query, $post;

		$show_subcategories = woodmart_get_opt( 'shop_categories_ancestors' );
		$show_categories_neighbors = woodmart_get_opt( 'show_categories_neighbors' );

		$list_args = array(  
			'taxonomy' => 'product_cat', 
			'hide_empty' => false 
		);

		// Menu Order
		$list_args['menu_order'] = false;
		$list_args['menu_order'] = 'asc';

		// Setup Current Category
		$current_cat   = false;
		$cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {

			$current_cat   = $wp_query->queried_object;
			$cat_ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );

		}

		$list_args['depth']            = 5;
		$list_args['child_of']         = 0;
		$list_args['title_li']         = '';
		$list_args['hierarchical']     = 1;
		$list_args['show_count']       = woodmart_get_opt( 'shop_products_count' );
		$list_args['walker'] = new WOODMART_Walker_Category();

		$class = ( woodmart_get_opt( 'shop_products_count' ) ) ? 'has-product-count' : 'hasno-product-count';

		$shop_link = get_post_type_archive_link( 'product' );

		include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );
		
		if( is_object( $current_cat ) && !get_term_children( $current_cat->term_id, 'product_cat' ) && $show_subcategories && !$show_categories_neighbors ) return;
		
		echo '<div class="woodmart-show-categories"><a href="#">' . esc_html__('Categories', 'woodmart') . '</a></div>';

		echo '<ul class="woodmart-product-categories ' . esc_attr( $class ). '">';
		
		echo '<li class="cat-link shop-all-link"><div class="category-nav-link"><a href="' . esc_url( $shop_link ) . '">
				<span class="category-summary">
					<span class="category-name">' . esc_html__('All', 'woodmart') . '</span>
					<span class="category-products-count">
						<span class="cat-count-label">' . esc_html__('products', 'woodmart') . '</span>
					</span>
				</span>
		</a></div></li>';

		if( $show_subcategories ) {
			woodmart_show_category_ancestors();
		} else {
			wp_list_categories( $list_args );
		}

		echo '</ul>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Display ancestors of current category
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_show_category_ancestors' )) {
	function woodmart_show_category_ancestors() {
		global $wp_query, $post;

		$current_cat   = false;
		$list_args = array();

		$show_categories_neighbors = woodmart_get_opt( 'show_categories_neighbors' );

		if ( is_tax('product_cat') ) {
			$current_cat   = $wp_query->queried_object;
		}

		$list_args = array( 'taxonomy' => 'product_cat', 'hide_empty' => true );

		// Show Siblings and Children Only
		if ( $current_cat ) {

			// Direct children are wanted
			$include = get_terms(
				'product_cat',
				array(
					'fields'       => 'ids',
					'parent'       => $current_cat->term_id,
					'hierarchical' => true,
					'hide_empty'   => false
				)
			);

			$list_args['include'] = implode( ',', $include );

			if ( empty( $include ) && !$show_categories_neighbors ) {
				return;
			}

			if ( $show_categories_neighbors ) {
				if ( get_term_children( $current_cat->term_id, 'product_cat' ) ) {
					$list_args['child_of'] = $current_cat->term_id;
				}elseif( $current_cat->parent != 0 ){
					$list_args['child_of'] = $current_cat->parent;
				}
			}
		} 

		$list_args['depth']                      = 1;
		$list_args['hierarchical']               = 1;
		$list_args['title_li']                   = '';
		$list_args['pad_counts']                 = 1;
		$list_args['show_option_none']           = esc_html__('No product categories exist.', 'woodmart' );
		$list_args['current_category']           = ( $current_cat ) ? $current_cat->term_id : '';
		$list_args['show_count']       			 = woodmart_get_opt( 'shop_products_count' );
		$list_args['walker']					 = new WOODMART_Walker_Category();

		wp_list_categories( $list_args );
	}
}

if( ! class_exists( 'WOODMART_Walker_Category' ) ) {
	class WOODMART_Walker_Category extends Walker_Category {
		public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
			/** This filter is documented in wp-includes/category-template.php */
			$cat_name = apply_filters(
				'list_cats',
				esc_attr( $category->name ),
				$category
			);

			// Don't generate an element if the category name is empty.
			if ( ! $cat_name ) {
				return;
			}

			$link = '<div class="category-nav-link">';
			$link .= '<a href="' . esc_url( get_term_link( $category ) ) . '" ';

			$link .= '>';


			$icon_url = get_term_meta( $category->term_id, 'category_icon', true );

			if( ! empty( $icon_url ) ) {
				$link .= '<img src="'  . esc_url( $icon_url ) . '" alt="' . esc_attr( $category->cat_name ) . '" class="category-icon" />';
			}
			
			$link .= '<span class="category-summary">';
			$link .= '<span class="category-name">' . $cat_name . '</span>';

			if ( ! empty( $args['show_count'] ) ) {
				$link .= '<span class="category-products-count"><span class="cat-count-number">' . number_format_i18n( $category->count ) . '</span> <span class="cat-count-label">' . _n( 'product', 'products', $category->count, 'woodmart' ) . '</span></span>';
			}

			$link .= '</span>';
			$link .= '</a>';
			
			$link .= '</div>';


			if ( 'list' == $args['style'] ) {
				$default_cat = get_option( 'default_product_cat' );
				$output .= "\t<li";
				$css_classes = array(
					'cat-item',
					'cat-item-' . $category->term_id,
					( $category->term_id == $default_cat ? 'wc-default-cat' : '')
				);

				if ( ! empty( $args['current_category'] ) ) {
					// 'current_category' can be an array, so we use `get_terms()`.
					$_current_terms = get_terms( $category->taxonomy, array(
						'include' => $args['current_category'],
						'hide_empty' => false,
					) );

					foreach ( $_current_terms as $_current_term ) {
						if ( $category->term_id == $_current_term->term_id ) {
							$css_classes[] = 'current-cat';
						} elseif ( $category->term_id == $_current_term->parent ) {
							$css_classes[] = 'current-cat-parent';
						}
						while ( $_current_term->parent ) {
							if ( $category->term_id == $_current_term->parent ) {
								$css_classes[] =  'current-cat-ancestor';
								break;
							}
							$_current_term = get_term( $_current_term->parent, $category->taxonomy );
						}
					}
				}

				/**
				 * Filter the list of CSS classes to include with each category in the list.
				 *
				 * @since 4.2.0
				 *
				 * @see wp_list_categories()
				 *
				 * @param array  $css_classes An array of CSS classes to be applied to each list item.
				 * @param object $category    Category data object.
				 * @param int    $depth       Depth of page, used for padding.
				 * @param array  $args        An array of wp_list_categories() arguments.
				 */
				$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

				$output .=  ' class="' . $css_classes . '"';
				$output .= ">$link\n";
			} elseif ( isset( $args['separator'] ) ) {
				$output .= "\t$link" . $args['separator'] . "\n";
			} else {
				$output .= "\t$link<br />\n";
			}
		}
	}
}

if ( ! class_exists( 'WOODMART_WC_Product_Cat_List_Walker' ) && function_exists('WC') ) :

include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

class WOODMART_WC_Product_Cat_List_Walker extends WC_Product_Cat_List_Walker {

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category in reference to parents.
	 * @param integer $current_object_id
	 */
	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$output .= '<li class="cat-item cat-item-' . $cat->term_id;

		if ( $args['current_category'] == $cat->term_id ) {
			$output .= ' current-cat';
		}

		if ( $args['has_children'] && $args['hierarchical'] ) {
			$output .= ' cat-parent';
		}

		if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
			$output .= ' current-cat-parent';
		}

		$output .=  '"><a href="' . get_term_link( (int) $cat->term_id, $this->tree_type ) . '">' . $cat->name . '</a>';

		if ( $args['show_count'] ) {
			$output .= ' <span class="count">' . $cat->count . '</span>';
		}
	}
}

endif;


/**
 * ------------------------------------------------------------------------------------------------
 * Remove () from numbers in categories widget
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_filter_product_categories_widget_args' ) ) {
	function woodmart_filter_product_categories_widget_args( $list_args ) {

		$list_args['walker'] = new WOODMART_WC_Product_Cat_List_Walker();

		return $list_args;
	}

	add_filter( 'woocommerce_product_categories_widget_args', 'woodmart_filter_product_categories_widget_args', 10, 1);
}

/**
 * ------------------------------------------------------------------------------------------------
 * Show product categories
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_categories' ) ) {
	function woodmart_product_categories() {
		global $post, $product;
		if( ! woodmart_get_opt( 'categories_under_title' ) ) return;
		?>
            <div class="woodmart-product-cats">
                <?php
                    echo wc_get_product_category_list( $product->get_id(), ', ' );
                ?>
            </div>
		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Show product brand
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_brands_links' ) ) {
	function woodmart_product_brands_links() {
		global $product;
		$brand_option = woodmart_get_opt( 'brands_attribute' );
		$brands = wc_get_product_terms( $product->get_id(), $brand_option, array( 'fields' => 'all' ) );

		if( !woodmart_get_opt( 'brands_under_title' ) || empty( $brands ) ) return;

		$link = ( defined( 'SHOP_IS_ON_FRONT' ) ) ? home_url() : get_post_type_archive_link( 'product' );

		echo '<div class="woodmart-product-brands-links">';

		foreach ( $brands as $brand ) {
			$filter_name = 'filter_' . sanitize_title( str_replace( 'pa_', '', $brand_option ) );
			$attr_link = apply_filters( 'woodmart_brands_link', add_query_arg( $filter_name, $brand->slug, $link ), $brand );

			$sep = ', ';
			if ( end( $brands ) == $brand ) $sep = '';

			echo '<a href="' . esc_url( $attr_link ) . '">' . $brand->name . '</a>' . $sep;
		}

		echo '</div>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns quick shop of the product by ID. Variations form HTML
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_quick_shop' ) ) {
	function woodmart_quick_shop($id = false) {
		if( isset($_GET['id']) ) {
			$id = (int) $_GET['id'];
		}
		if( ! $id || ! woodmart_woocommerce_installed() ) {
			return;
		}

		global $post;

		$args = array( 'post__in' => array($id), 'post_type' => 'product' );

		$quick_posts = get_posts( $args );

		$quick_view_variable = woodmart_get_opt( 'quick_view_variable' );

		foreach( $quick_posts as $post ) :
			setup_postdata($post);
        	woocommerce_template_single_add_to_cart();
		endforeach; 

		wp_reset_postdata(); 

		die();
	}

	add_action( 'wp_ajax_woodmart_quick_shop', 'woodmart_quick_shop' );
	add_action( 'wp_ajax_nopriv_woodmart_quick_shop', 'woodmart_quick_shop' );

}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns quick view of the product by ID
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_quick_view' ) ) {
	function woodmart_quick_view($id = false) {
		if( isset($_GET['id']) ) {
			$id = (int) $_GET['id'];
		}
		if( ! $id || ! woodmart_woocommerce_installed() ) {
			return;
		}

		global $post, $product;


		$args = array( 'post__in' => array($id), 'post_type' => 'product' );

		$quick_posts = get_posts( $args );

		$quick_view_variable = woodmart_get_opt( 'quick_view_variable' );
		$quick_view_layout = ( woodmart_get_opt( 'quick_view_layout' ) ) ? woodmart_get_opt( 'quick_view_layout' ) : 'horizontal';

		foreach( $quick_posts as $post ) :
			setup_postdata($post);
			$product = wc_get_product($post);
        	remove_action( 'woocommerce_single_product_summary', 'woodmart_before_compare_button', 33 );
			remove_action( 'woocommerce_single_product_summary', 'woodmart_after_compare_button', 37 );
			
			//Remove before and after add to cart button text
			remove_action( 'woocommerce_single_product_summary', 'woodmart_before_add_to_cart_area', 25 );
			remove_action( 'woocommerce_single_product_summary', 'woodmart_after_add_to_cart_area', 31 );
			
        	remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );

        	// Add brand image
        	add_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 8 );

        	// Disable add to cart button for catalog mode
			if( woodmart_get_opt( 'catalog_mode' ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			} elseif( ! $quick_view_variable ) {
				// If no needs to show variations
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_add_to_cart', 30 );
			}

			if( woodmart_get_opt( 'product_share' ) ) add_action( 'woocommerce_single_product_summary', 'woodmart_product_share_buttons', 45 );
			get_template_part('woocommerce/content', 'quick-view-' . $quick_view_layout );
		endforeach; 

		wp_reset_postdata(); 

		die();
	}

	add_action( 'wp_ajax_woodmart_quick_view', 'woodmart_quick_view' );
	add_action( 'wp_ajax_nopriv_woodmart_quick_view', 'woodmart_quick_view' );

}

if( ! function_exists( 'woodmart_product_images_slider' ) ) {
	function woodmart_product_images_slider() {
		wc_get_template( 'quick-view/product-images.php' );
	}
}

if( ! function_exists( 'woodmart_view_product_button' ) ) {
	function woodmart_view_product_button() {
		echo '<a href="' . get_permalink() . '" class="view-details-btn">' . esc_html__('View details', 'woodmart') . '</a>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns numbers of items in the cart. Filter woocommerce fragments
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_cart_data' ) ) {
	add_filter('woocommerce_add_to_cart_fragments', 'woodmart_cart_data', 30);
	function woodmart_cart_data( $array ) {
		ob_start();
		woodmart_cart_count();
		$count = ob_get_clean();
		
		ob_start();
		woodmart_cart_subtotal();
		$subtotal = ob_get_clean();
		
		$array['span.woodmart-cart-number'] = $count;
		$array['span.woodmart-cart-subtotal'] = $subtotal;
		
		return $array;
	}
}

if( ! function_exists( 'woodmart_cart_count' ) ) {
	function woodmart_cart_count() {
		$count = WC()->cart->get_cart_contents_count();
		?>
			<span class="woodmart-cart-number"><?php echo esc_html($count); ?> <span><?php echo esc_html( _n( 'item', 'items', $count, 'woodmart' ) ); ?></span></span>
		<?php
	}
}

if( ! function_exists( 'woodmart_cart_subtotal' ) ) {
	function woodmart_cart_subtotal() {
		?>
			<span class="woodmart-cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		<?php
	}
}



/**
 * ------------------------------------------------------------------------------------------------
 * AJAX add to cart for all product types
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_ajax_add_to_cart' ) ) {
	function woodmart_ajax_add_to_cart() {

		// Get messages
		ob_start();

		wc_print_notices();

		$notices = ob_get_clean();


		// Get mini cart
		ob_start();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();

		// Fragments and mini cart are returned
		$data = array(
			'notices' => $notices,
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
				)
			),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);

		wp_send_json( $data );

		die();
	}
}

add_action( 'wp_ajax_woodmart_ajax_add_to_cart', 'woodmart_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_woodmart_ajax_add_to_cart', 'woodmart_ajax_add_to_cart' );


/**
 * ------------------------------------------------------------------------------------------------
 * If you are using YITH Products Addons plugin you will need to apply the following workaround to
 * be able to add to cart products with AJAX.
 * File: includes/class.yith-wapo-frontend.php, method: add_to_cart_validation, comment line: return false;
 * File: includes/class.yith-wapo.php, method: init, change line: if ( is_admin() && ! $this->is_quick_view() && ! defined( 'DOING_AJAX' ) && DOING_AJAX ) {
 * ------------------------------------------------------------------------------------------------
 */

/**
 * ------------------------------------------------------------------------------------------------
 * Set wishlist cookie
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_maybe_set_wishlist_cookies' ) ) {
	function woodmart_maybe_set_wishlist_cookies() {
		if( ! class_exists( 'YITH_WCWL' ) ) return;
		if ( ! headers_sent() && did_action( 'wp_loaded' ) ) {
			if ( YITH_WCWL()->count_products() > 0 ) {
				woodmart_set_wishlist_cookies( true );
			} elseif ( isset( $_COOKIE['woodmart_items_in_wishlist'] ) ) {
				woodmart_set_wishlist_cookies( false );
			}
		}
	}
	add_action( 'wp', 'woodmart_maybe_set_wishlist_cookies', 100 ); // Set cookies
	add_action( 'shutdown', 'woodmart_maybe_set_wishlist_cookies', 0 ); // Set cookies before shutdown and ob flushing
}


if( ! function_exists( 'woodmart_set_wishlist_cookies' ) ) {
	function woodmart_set_wishlist_cookies( $set = true ) {
		if( ! class_exists( 'YITH_WCWL' ) || ! function_exists( 'wc_setcookie' ) ) return;
		if ( $set ) {
			wc_setcookie( 'woodmart_items_in_wishlist', 1 );
			wc_setcookie( 'woodmart_wishlist_hash', YITH_WCWL()->count_products() );
		} elseif ( isset( $_COOKIE['woodmart_items_in_wishlist'] ) ) {
			wc_setcookie( 'woodmart_items_in_wishlist', 0, time() - HOUR_IN_SECONDS );
			wc_setcookie( 'woodmart_wishlist_hash', '', time() - HOUR_IN_SECONDS );
		}
		do_action( 'woodmart_set_wishlist_cookies', $set );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns numbers of items in the wishlist
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_wishlist_number' ) ) {
	function woodmart_wishlist_number() {
		if( ! class_exists( 'YITH_WCWL' ) ) die();
		echo YITH_WCWL()->count_products();
		die();
	}

	add_action( 'wp_ajax_woodmart_wishlist_number', 'woodmart_wishlist_number' );
	add_action( 'wp_ajax_nopriv_woodmart_wishlist_number', 'woodmart_wishlist_number' );

}


/**
 * ------------------------------------------------------------------------------------------------
 * Function that removes item from cart and returns fragments
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_remove_from_cart' ) ) {
	function woodmart_remove_from_cart() {
		if( ! class_exists( 'WC_AJAX' ) ) die(-1);

		if ( ! empty( $_GET['cart_item'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'woocommerce-cart' ) ) {
			// Remove from cart
			$cart_item_key = sanitize_text_field( $_GET['cart_item'] );

			if ( $cart_item = WC()->cart->get_cart_item( $cart_item_key ) ) {
				WC()->cart->remove_cart_item( $cart_item_key );
			}
		}


		WC_AJAX::get_refreshed_fragments();
	}

	add_action( 'wp_ajax_woodmart_remove_from_cart', 'woodmart_remove_from_cart' );
	add_action( 'wp_ajax_nopriv_woodmart_remove_from_cart', 'woodmart_remove_from_cart' );
}
		
/**
 * ------------------------------------------------------------------------------------------------
 * Determine is it product attribute archieve page
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_is_product_attribute_archieve' ) ) {
	function woodmart_is_product_attribute_archieve() {
	    $queried_object = get_queried_object();
	    if( $queried_object && property_exists( $queried_object, 'taxonomy' ) ) {
	        $taxonomy = $queried_object->taxonomy;
	        return substr($taxonomy, 0, 3) == 'pa_';
	    }
	    return false;
	}
} 
		
/**
 * ------------------------------------------------------------------------------------------------
 * Function to prepare classes for grid element (column)
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_grid_el_class' ) ) {
	function woodmart_get_grid_el_class($loop = 0, $columns = 4, $different_sizes = false, $xs_size = false, $sm_size = 4, $md_size = 3) {
		$classes = '';

		$items_wide = woodmart_get_wide_items_array( $different_sizes );

		if( ! in_array( $columns, array(1,2,3,4,6,12) ) ) {
			$columns = 4;
		}

		if( ! $xs_size ) {
			$xs_size = apply_filters('woodmart_grid_xs_default', 6);
		}

		if( $columns <= 3 ) {
			if( ! $xs_size ) $xs_size = 12;
			if($columns == 1)
				$sm_size = 12;
			else
				$sm_size = 6;
		}		


		$col = ' col-xs-' . $xs_size . ' col-sm-' . $sm_size . ' col-md-';

		$md_size = 12/$columns;

		// every third element make 2 times larger (for isotope grid)
		if( $different_sizes && ( in_array( $loop, $items_wide ) ) ) { 
			$md_size *= 2;
		}

		$classes .= $col . $md_size;

		if($loop > 0) {
			if ( 0 == ( $loop - 1 ) % $columns || 1 == $columns )
				$classes .= ' first ';
			if ( 0 == $loop % $columns )
				$classes .= ' last ';
		}

		return $classes;
	}
}

if( ! function_exists( 'woodmart_get_wide_items_array' ) ) {
	function woodmart_get_wide_items_array( $different_sizes = false ){
		$items_wide = apply_filters( 'woodmart_wide_items', array( 5, 6, 7, 8, 13, 14 ) );

		if( is_array( $different_sizes ) ) {
			$items_wide = apply_filters( 'woodmart_wide_items', $different_sizes );
		}

		return $items_wide;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Function to generate clear elements <div class="clear"></div>
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_grid_clear' )) {
	function woodmart_get_grid_clear($loop = 0, $columns = 4, $xs_columns = 1) {
		$output = '';

		if( ! in_array( $columns, array(1,2,3,4,6,12) ) ) {
			$columns = 4;
		}

		if( $columns < 4) {
			if( 0 == $loop % $xs_columns ) {
				$output .= '<div class="clearfix visible-xs-block"></div>';
			}

			if( 0 == $loop % 2 && $columns != 1) {
				$output .= '<div class="clearfix visible-sm-block"></div>';
			}
		} else {
			if( 0 == $loop % $xs_columns ) {
				$output .= '<div class="clearfix visible-xs-block"></div>';
			}

			if( 0 == $loop % 3 ) {
				$output .= '<div class="clearfix visible-sm-block"></div>';
			}
		}

		if( 0 == $loop % $columns ) {
			$output .= '<div class="clearfix visible-md-block visible-lg-block"></div>';
		}

		return $output;
	}
}

if( ! function_exists( 'woodmart_get_current_term_id' ) ) {
	/**
	 * FIX CMB2 bug
	 */
	function woodmart_get_current_term_id() {
		return isset( $_REQUEST['tag_ID'] ) ? $_REQUEST['tag_ID'] : 0;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart Related product count
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_related_count' ) ) {
	add_filter( 'woocommerce_output_related_products_args', 'woodmart_related_count' );
	  function woodmart_related_count() {
		$args['posts_per_page'] = ( woodmart_get_opt( 'related_product_count' ) ) ? woodmart_get_opt( 'related_product_count' ) : 8;
		return $args;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart is product thumb enabled
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_is_product_thumb_enabled' ) ) {
	function woodmart_is_product_thumb_enabled() {
		$thums_position = woodmart_get_opt('thums_position');
		$product_design = woodmart_get_opt('product_design');
		return ( $product_design != 'sticky' && ( $thums_position == 'bottom' || $thums_position == 'left' ) );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart is main product images carousel
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_is_main_product_images_carousel' ) ) {
	function woodmart_is_main_product_images_carousel() {
		$thums_position = woodmart_get_opt( 'thums_position' );
		return ( $thums_position == 'without' || $thums_position == 'centered' ) ? true : woodmart_is_product_thumb_enabled();
	}
}
 
/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart product label
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_product_label' ) ) {
	function woodmart_product_label() {
		global $product;

		$output = array();

		$product_attributes = woodmart_get_product_attributes_label();
		$percentage_label = woodmart_get_opt( 'percentage_label' );

		if ( $product->is_on_sale() ) {

			$percentage = '';

			if ( $product->get_type() == 'variable' && $percentage_label ) {

				$available_variations = $product->get_variation_prices();
				$max_percentage = 0;

				foreach( $available_variations['regular_price'] as $key => $regular_price ) {
					$sale_price = $available_variations['sale_price'][$key];

					if ( $sale_price < $regular_price ) {
						$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

						if ( $percentage > $max_percentage ) {
							$max_percentage = $percentage;
						}
					}
				}

				$percentage = $max_percentage;
			} elseif ( ( $product->get_type() == 'simple' || $product->get_type() == 'external' ) && $percentage_label ) {
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
			}

			if ( $percentage ) {
				$output[] = '<span class="onsale product-label">-' . $percentage . '%' . '</span>';
			}else{
				$output[] = '<span class="onsale product-label">' . esc_html__( 'Sale', 'woodmart' ) . '</span>';
			}
		}
		
		if( !$product->is_in_stock() && !is_product() ){
			$output[] = '<span class="out-of-stock product-label">' . esc_html__( 'Sold out', 'woodmart' ) . '</span>';
		}

		if ( $product->is_featured() && woodmart_get_opt( 'hot_label' ) ) {
			$output[] = '<span class="featured product-label">' . esc_html__( 'Hot', 'woodmart' ) . '</span>';
		}
		
		if ( get_post_meta( get_the_ID(), '_woodmart_new_label', true ) && woodmart_get_opt( 'new_label' ) ) {
			$output[] = '<span class="new product-label">' . esc_html__( 'New', 'woodmart' ) . '</span>';
		}
		
		if ( $product_attributes ) {
			foreach ( $product_attributes as $attribute ) {
				$output[] = $attribute;
			}
		}
		
		if ( $output ) {
			echo '<div class="product-labels labels-' . woodmart_get_opt( 'label_shape' ) . '">' . implode( '', $output ) . '</div>';
		}
	}
}
add_filter( 'woocommerce_sale_flash', 'woodmart_product_label', 10 );
 
/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart my account links
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_my_account_links' ) ) {
	function woodmart_my_account_links() {
		if ( !woodmart_get_opt( 'my_account_links' ) ) return;
		?>
		<div class="woodmart-my-account-links">
			<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<div class="<?php echo $endpoint; ?>-link">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
				</div>
			<?php endforeach; ?>
			<?php if ( class_exists( 'YITH_WCWL' ) && woodmart_get_opt( 'my_account_wishlist' ) ): ?>
				<?php $wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ); ?>
				<div class="wishlist-link">
					<a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>"><?php echo get_the_title( $wishlist_page_id ); ?></a></li>
				</div>
			<?php endif; ?>
				<div class="logout-link">
					<a href="<?php echo wc_get_account_endpoint_url( 'customer-logout' ); ?>"><?php echo esc_html__( 'Logout', 'woodmart' ); ?></a>
				</div>
		</div>
		<?php
	}
	add_action( 'woocommerce_account_dashboard', 'woodmart_my_account_links', 10 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart my account remove logout link
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_remove_my_account_logout' ) ) {
	function woodmart_remove_my_account_logout( $items ) {
		unset( $items['customer-logout'] );
		return $items;
	}
	add_filter( 'woocommerce_account_menu_items', 'woodmart_remove_my_account_logout', 15 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart open wrapper in wishlist template
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_my_account_wishlist_start' ) ) {
	function woodmart_my_account_wishlist_start(){
		if ( !is_user_logged_in() || !woodmart_get_opt( 'my_account_wishlist' ) ) return;
		?>
			<div class="woocommerce">
				<div class="woocommerce-my-account-wrapper">
		<?php
	}
	add_action( 'yith_wcwl_before_wishlist_form', 'woodmart_my_account_wishlist_start', 10 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart added my account navigation
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_my_account_wishlist_add_nav' ) ) {
	function woodmart_my_account_wishlist_add_nav(){
		if ( !is_user_logged_in() || !woodmart_get_opt( 'my_account_wishlist' ) ) return;
		$sidebar_name = 'sidebar-my-account';
		?>
			<div class="woodmart-my-account-sidebar">
				<?php if ( !function_exists( 'woodmart_my_account_title' ) ): ?>
					<h3 class="woocommerce-MyAccount-title entry-title"><?php echo esc_html__( 'My account', 'woodmart' ); ?></h3>
				<?php endif; ?>
				<?php wc_get_template('myaccount/navigation.php'); ?>
				<?php if ( is_active_sidebar( $sidebar_name ) ): ?>
					<aside class="sidebar-container" role="complementary">
						<div class="sidebar-inner">
							<div class="widget-area">
								<?php dynamic_sidebar( $sidebar_name ); ?>
							</div><!-- .widget-area -->
						</div><!-- .sidebar-inner -->
					</aside><!-- .sidebar-container -->
				<?php endif; ?>
			</div><!-- .woodmart-my-account-sidebar" -->
			
			<div class="woocommerce-MyAccount-content">
		<?php
	}
	add_action( 'yith_wcwl_before_wishlist_form', 'woodmart_my_account_wishlist_add_nav', 10 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart end wrapper in wishlist template
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_my_account_wishlist_end' ) ) {
	function woodmart_my_account_wishlist_end(){
		if ( !is_user_logged_in() || !woodmart_get_opt( 'my_account_wishlist' ) ) return;
		?>
				</div><!-- .woocommerce-MyAccount-content -->
			</div><!-- .woocommerce-my-account-wrapper -->
		</div><!-- .woocommerce -->
		<?php
	}
	add_action( 'yith_wcwl_after_wishlist_form', 'woodmart_my_account_wishlist_end', 10 );	
}

/**
 * ------------------------------------------------------------------------------------------------
 * My account wrapper
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_my_account_wrapp_start' ) ) {
	function woodmart_my_account_wrapp_start(){
		echo '<div class="woocommerce-my-account-wrapper">';
	}
	add_action( 'woocommerce_account_navigation', 'woodmart_my_account_wrapp_start', 1 );
}

if( ! function_exists( 'woodmart_my_account_wrapp_end' ) ) {
	function woodmart_my_account_wrapp_end(){
		echo '</div><!-- .woocommerce-my-account-wrapper -->';
	}
	add_action( 'woocommerce_account_content', 'woodmart_my_account_wrapp_end', 10000 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Mini cart buttons
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_mini_cart_view_cart_btn' ) ) {
	function woodmart_mini_cart_view_cart_btn(){
		echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button btn-cart wc-forward">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
	}
	remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
	add_action( 'woocommerce_widget_shopping_cart_buttons', 'woodmart_mini_cart_view_cart_btn', 10 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Attribute on product element
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_get_product_attributes_label' ) ) {
	function woodmart_get_product_attributes_label(){
		global $product;
		$attributes = $product->get_attributes();
		$output = array();
		foreach ( $attributes as $attribute ) {
			if ( !isset( $attribute['name'] ) ) continue;
		    $show_attr_on_product = woodmart_wc_get_attribute_term( $attribute['name'], 'show_on_product' );
			if ( $show_attr_on_product == 'on' ) {
				$terms = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'all' ) );
				foreach ( $terms as $term ) {
					$content = esc_attr( $term->name );
					$classes = 'label-term-' . $term->slug;
					$classes .= ' label-attribute-' . $attribute['name'];
					
					$image = get_term_meta( $term->term_id, 'image', true );
					if ( $image ) {
						$classes .= ' label-with-img';
						$content = '<img src="' . esc_url( $image ) . '" title="' . esc_attr( $term->slug ) . '" alt="' . esc_attr( $term->slug ) . '" />';
					}
					
					$output[] = '<span class="attribute-label product-label ' . esc_attr( $classes ) . '">'. $content .'</span>';
				}
			}
		}
		return $output;
	}
}
/**
 * ------------------------------------------------------------------------------------------------
 * Dokan compatibility
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_dokan_edit_product_wrap_start' ) ) {
	function woodmart_dokan_edit_product_wrap_start(){
		echo '<div class="site-content col-sm-12" role="main">';
	}
	add_action( 'dokan_dashboard_wrap_before', 'woodmart_dokan_edit_product_wrap_start', 10 );
}

if( ! function_exists( 'woodmart_dokan_edit_product_wrap_end' ) ) {
	function woodmart_dokan_edit_product_wrap_end(){
		echo '</div>';
	}
	add_action( 'dokan_dashboard_wrap_after', 'woodmart_dokan_edit_product_wrap_end', 10 );
}
/**
 * ------------------------------------------------------------------------------------------------
 * Add to Quote Plugin (YITH)
 * ------------------------------------------------------------------------------------------------
 */
if ( function_exists( 'YITH_YWRAQ_Frontend' ) ) {
	remove_action( 'woocommerce_before_single_product', array( YITH_YWRAQ_Frontend(), 'show_button_single_page' ) );

	if( ! function_exists( 'woodmart_show_YWRAQ_button_single_page' ) ) {
		function woodmart_show_YWRAQ_button_single_page(){
			global $product;

		    if( ! $product ){
			    global  $post;
			    if (  ! $post || ! is_object( $post ) || ! is_singular() ) {
				    return;
			    }
			    $product = wc_get_product( $post->ID );
		    }

		    if( get_option('ywraq_show_button_near_add_to_cart','no') == 'yes' && $product->is_in_stock() && $product->get_price() !== '' ){
			    if( $product->is_type( 'variable' ) ){
				    add_action( 'woocommerce_after_single_variation', array(  YITH_YWRAQ_Frontend(), 'add_button_single_page' ),30 );
			    }else{
				    add_action( 'woocommerce_after_add_to_cart_button', array(  YITH_YWRAQ_Frontend(), 'add_button_single_page' ),15 );
			    }
		    }else{
			    add_action( 'woocommerce_single_product_summary', array( YITH_YWRAQ_Frontend(), 'add_button_single_page' ), 30 );
		    }

		}

		add_action( 'woocommerce_before_single_product', 'woodmart_show_YWRAQ_button_single_page', 35 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Before add to cart text area
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_before_add_to_cart_area' ) ) {
	function woodmart_before_add_to_cart_area(){
		$content = woodmart_get_opt( 'content_before_add_to_cart' );
		if ( empty( $content ) ) return;
		echo '<div class="woodmart-before-add-to-cart">' . do_shortcode( $content ) . '</div>';
	}
	add_action( 'woocommerce_single_product_summary', 'woodmart_before_add_to_cart_area', 25 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * After add to cart text area
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_after_add_to_cart_area' ) ) {
	function woodmart_after_add_to_cart_area(){
		$content = woodmart_get_opt( 'content_after_add_to_cart' );
		if ( empty( $content ) ) return;
		echo '<div class="woodmart-after-add-to-cart">' . do_shortcode( $content ) . '</div>';
	}
	add_action( 'woocommerce_single_product_summary', 'woodmart_after_add_to_cart_area', 31 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Reset loop
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_reset_loop' ) ) {
	function woodmart_reset_loop() {
		unset( $GLOBALS['woodmart_loop'] );
		woodmart_setup_loop();
	}
	add_action( 'woocommerce_after_shop_loop', 'woodmart_reset_loop', 1000 );
	add_action( 'loop_end', 'woodmart_reset_loop', 1000 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get loop prop
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_loop_prop' ) ) {
	function woodmart_loop_prop( $prop, $default = '' ) {
		woodmart_setup_loop();
		
		return isset( $GLOBALS['woodmart_loop'], $GLOBALS['woodmart_loop'][ $prop ] ) ? $GLOBALS['woodmart_loop'][ $prop ] : $default;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Set loop prop
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_set_loop_prop' ) ) {
	function woodmart_set_loop_prop( $prop, $value = '' ) {
		if ( ! isset( $GLOBALS['woodmart_loop'] ) ) woodmart_setup_loop();

		$GLOBALS['woodmart_loop'][ $prop ] = $value;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Setup loop
 * ------------------------------------------------------------------------------------------------
 */
 
if( ! function_exists( 'woodmart_setup_loop' ) ) {
	function woodmart_setup_loop( $args = array() ) {
		if ( isset( $GLOBALS['woodmart_loop'] ) ) return; // If the loop has already been setup, bail.
		
		$default_args = array(
			'products_different_sizes' 	=> woodmart_get_opt( 'products_different_sizes' ),
			'product_categories_design' => woodmart_get_opt( 'categories_design' ),
			'product_categories_shadow' => woodmart_get_opt( 'categories_with_shadow' ),
			'products_columns' 		    => ( woodmart_get_opt( 'per_row_columns_selector' ) ) ? apply_filters( 'loop_shop_columns', woodmart_get_products_columns_per_row() ) : woodmart_get_opt( 'products_columns' ),
			'product_categories_style'  => false,		
			'product_hover' 			=> woodmart_get_opt( 'products_hover' ),
			'products_view' 			=> woodmart_get_shop_view(),
			'products_masonry' 			=> woodmart_get_opt( 'products_masonry' ),
			
			'timer' 					=> woodmart_get_opt( 'shop_countdown' ),
			'swatches'					=> false,
			
			'is_slider' 				=> false,
			'is_shortcode' 				=> false,
			'is_quick_view' 			=> false,
			
			'woocommerce_loop' 			=> 0,
			'woodmart_loop' 			=> 0,
			
			'parts_media' 				=> true,
			'parts_title' 				=> true,
			'parts_meta' 				=> true,
			'parts_text' 				=> true,
			'parts_btn' 				=> true,
			
			'blog_design' 				=> woodmart_get_opt( 'blog_design' ),
			'blog_type' 				=> false,
			'blog_columns' 				=> woodmart_get_opt( 'blog_columns' ),
			'img_size' 					=> false,
			'double_size' 				=> false,

			'portfolio_style'			=> woodmart_get_opt( 'portoflio_style' ),
			'portfolio_column'			=> woodmart_get_opt( 'projects_columns' ),
		);
		
		$GLOBALS['woodmart_loop'] = wp_parse_args( $args, $default_args );
	}
	add_action( 'woocommerce_before_shop_loop', 'woodmart_setup_loop', 10 );
	add_action( 'wp', 'woodmart_setup_loop', 50 );
	add_action( 'loop_start', 'woodmart_setup_loop', 10 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Clear all filters button
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_clear_filters_btn' ) ) {
	function woodmart_clear_filters_btn() {
		$url = $_SERVER['REQUEST_URI'];
		$filters = array( 'filter_', 'min_price', 'max_price', 'product_visibility', 'stock', 'onsales' );
		$need_clear = false;
		
		foreach ( $filters as $filter )
			if ( strpos( $url, $filter ) ) $need_clear = true;	
			
		if ( $need_clear ) {
			$reset_url = strtok( $url, '?' );
			if ( isset( $_GET['post_type'] ) ) $reset_url = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $reset_url );
			?>
				<div class="woodmart-clear-filters-wrapp">
					<a class="woodmart-clear-filters" href="<?php echo esc_url( $reset_url ); ?>"><?php echo esc_html__( 'Clear filters', 'woodmart' ); ?></a>
				</div>
			<?php
		}
	}
	add_action( 'woodmart_before_active_filters_widgets', 'woodmart_clear_filters_btn' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Print shop page css from vc elements
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_sticky_single_add_to_cart' ) ) {
	function woodmart_sticky_single_add_to_cart() {
		global $product;

		if ( ! woodmart_woocommerce_installed() || ! is_product() || ! woodmart_get_opt( 'single_sticky_add_to_cart' ) ) return;

		?>
			<div class="woodmart-sticky-btn <?php echo ( woodmart_get_opt( 'mobile_single_sticky_add_to_cart' ) ) ? 'mobile-on' : 'mobile-off' ?>">
				<div class="woodmart-sticky-btn-container container">
					<div class="woodmart-sticky-btn-content">
						<div class="woodmart-sticky-btn-thumbnail">
							<?php echo woocommerce_get_product_thumbnail(); ?>	
						</div>
						<div class="woodmart-sticky-btn-info">
							<h4 class="product-title"><?php the_title(); ?></h4>
							<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>							
						</div>
					</div>
					<div class="woodmart-sticky-btn-cart">
						<span class="price"><?php echo $product->get_price_html(); ?></span>
						<?php if ( $product->is_type( 'simple' ) ): ?>
							<?php woocommerce_simple_add_to_cart(); ?>
						<?php else: ?>
							<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="woodmart-sticky-add-to-cart button alt">
								<?php echo $product->is_type( 'variable' ) ? esc_html__( 'Select options', 'woodmart' ) : $product->single_add_to_cart_text(); ?>
							</a>
						<?php endif; ?>
						<?php 
							if ( class_exists( 'YITH_WCWL' ) ) {
								$default_wishlists = is_user_logged_in() ? YITH_WCWL()->get_wishlists( array( 'is_default' => true ) ) : false;
								$default_wishlist = ! empty( $default_wishlists ) ? $default_wishlists[0]['ID'] : false;
								$exists = YITH_WCWL()->is_product_in_wishlist( $product->get_id(), $default_wishlist );
								$class = $exists ? 'exists' : '';
								echo '<a href="' . YITH_WCWL()->get_wishlist_url() . '" class="woodmart-css-tooltip woodmart-sticky-btn-wishlist ' . $class  . '">' . esc_html__( 'Wishlist', 'woodmart' ) . '</a>';
							}
						?>
					</div>

				</div>
			</div>
		<?php
	}
	add_action( 'woodmart_after_footer', 'woodmart_sticky_single_add_to_cart', 999 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * WPML Compatibility
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_wpml_compatibility' ) ) {
	function woodmart_wpml_compatibility( $ajax_actions ) {
	   $ajax_actions[] = 'woodmart_ajax_add_to_cart';
	   $ajax_actions[] = 'woodmart_quick_view';
	   return $ajax_actions;
	}
	add_filter( 'wcml_multi_currency_ajax_actions', 'woodmart_wpml_compatibility', 10, 1 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Print shop page css from vc elements
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_shop_vc_css' ) ) {
	function woodmart_shop_vc_css() {
		if ( ! function_exists( 'wc_get_page_id' ) ) return;
		$shop_custom_css = get_post_meta( wc_get_page_id( 'shop' ), '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shop_custom_css ) ) {
			echo '<style type="text/css" data-type="vc_shortcodes-custom-css">' . $shop_custom_css . '</style>';
		}
	}
	add_action( 'wp_head', 'woodmart_shop_vc_css', 1000 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Sticky sidebar button
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_sticky_sidebar_button' ) ) {
	function woodmart_sticky_sidebar_button() {
		$sidebar_class = woodmart_get_sidebar_class();
		if ( strstr( $sidebar_class, 'col-md-0' ) || woodmart_maintenance_page() ) return;

		if ( ( woodmart_woocommerce_installed() && ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) && woodmart_get_opt( 'sticky_filter_button' ) && ( woodmart_get_opt( 'shop_hide_sidebar' ) || woodmart_get_opt( 'shop_hide_sidebar_tablet' ) ) ) ) {
			echo '<a href="#" class="woodmart-sticky-sidebar-opener shop-sidebar-opener"></a>';
		} elseif ( woodmart_get_opt( 'hide_main_sidebar_mobile' ) && ( ! woodmart_woocommerce_installed() || ( ! is_shop() && ! is_product_category() && ! is_product_tag() && ! is_product_taxonomy() ) ) ) {
			echo '<a href="#" class="woodmart-sticky-sidebar-opener"></a>';
		}
	}
	
	add_action( 'wp_footer', 'woodmart_sticky_sidebar_button', 200 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Login to see add to cart and prices
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_hide_price_not_logged_in' ) ) {
	function woodmart_hide_price_not_logged_in() {
		if ( ! is_user_logged_in() && woodmart_get_opt( 'login_prices' ) ) {
			add_filter( 'woocommerce_get_price_html', 'woodmart_print_login_to_see' );  
			add_filter( 'woocommerce_loop_add_to_cart_link', '__return_false' );  

			//Add to cart btns
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		}
	}

	add_action( 'init', 'woodmart_hide_price_not_logged_in', 200 );
}

if ( ! function_exists( 'woodmart_print_login_to_see' ) ) {
	function woodmart_print_login_to_see() {
		$settings = whb_get_settings();
		$login_side = isset( $settings['account'] ) && $settings['account']['login_dropdown'] && $settings['account']['form_display'] == 'side';
		$classes = ( ! is_user_logged_in() && $login_side ) ? ' login-side-opener' : '';

		return '<a href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '" class="login-to-prices-msg' . esc_attr( $classes ) . '">' . esc_html__( 'Login to see prices', 'woodmart' ) . '</a>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Shop page filters and custom content
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_shop_filters_area' ) ) {
	function woodmart_shop_filters_area() {
		$filters_type = woodmart_get_opt( 'shop_filters_type' ) ? woodmart_get_opt( 'shop_filters_type' ) : 'widgets';
		$custom_content = woodmart_get_opt( 'shop_filters_content' );
		$always_open = woodmart_get_opt( 'shop_filters_always_open' );
		$filters_opened = ( ( woocommerce_products_will_display() && $filters_type == 'widgets' ) || ( $filters_type == 'content' && $custom_content ) ) && $always_open;
		$classes = $filters_opened ? ' always-open' : '';
		$classes .= $filters_type == 'content' && $custom_content ? ' custom-content' : '';

		if ( woodmart_get_opt( 'shop_filters' ) ) {
			if ( $filters_type == 'content' && ! $custom_content ) return;
			echo '<div class="filters-area' . esc_attr( $classes ) . '">';
				echo '<div class="filters-inner-area row">';
					if ( $filters_type == 'widgets' ) {
						do_action( 'woodmart_before_filters_widgets' );
						dynamic_sidebar( 'filters-area' ); 
						do_action( 'woodmart_after_filters_widgets' );
					} else if ( $filters_type == 'content' && $custom_content ) {
						echo '<div class="col-md-12">';
							echo do_shortcode( '[html_block id="' . esc_attr( $custom_content ) . '"]' );
						echo '</div>';
					}
				echo '</div>';
			echo '</div>';
		}
	}

	add_action( 'woodmart_shop_filters_area', 'woodmart_shop_filters_area', 10 );
}