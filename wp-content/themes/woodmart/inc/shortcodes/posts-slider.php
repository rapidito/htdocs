<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Shortcode function to display posts as a slider or as a grid
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_generate_posts_slider' )) {
	function woodmart_generate_posts_slider( $atts, $query = false, $products = false ) {
		$posts_query = $el_class = $args = $my_query = $speed = '';
		$slides_per_view = $wrap = $scroll_per_page = $title_out = '';
		$autoplay = $hide_pagination_control = $hide_prev_next_buttons = $output = $owl_atts = '';
		$posts = array();

		$parsed_atts = shortcode_atts( array_merge( woodmart_get_owl_atts(), array(
			'el_class' => '',
			'posts_query' => '',
			'highlighted_products' => 0,
			'blog_spacing' => woodmart_get_opt( 'blog_spacing' ),
			'product_hover'  => woodmart_get_opt( 'products_hover' ),
			'blog_design'  => 'default',
			'carousel_small_img' => '',
			'blog_carousel_design' => 'masonry',
	        'img_size' => 'large',
			'title' => '',
			'element_title' => '',
		) ), $atts );

		extract( $parsed_atts );
		
		if ( empty( $product_hover ) || $product_hover == 'inherit' ) $product_hover = woodmart_get_opt( 'products_hover' );

		woodmart_set_loop_prop( 'product_hover', $product_hover );
		woodmart_set_loop_prop( 'img_size', $img_size );

		if ( $carousel_small_img == 'yes' ) {
			woodmart_set_loop_prop( 'blog_design', 'carousel_small_img' );
		}

		if ( ! $carousel_small_img && $blog_design == 'carousel' ) {
			woodmart_set_loop_prop( 'blog_design', $blog_carousel_design );
		}
		
		if( ! $query && ! $products && function_exists( 'vc_build_loop_query' ) ) {
			list( $args, $query ) = vc_build_loop_query( $posts_query );
		}

		$carousel_id = 'carousel-' . rand(100,999);

		$carousel_classes = ( $highlighted_products ) ? 'woodmart-highlighted-products' : '';
		$carousel_classes .= ( $element_title ) ? ' with-title' : '';	

		ob_start();

		if ( isset( $query->query['post_type'] ) ) {
			$post_type = $query->query['post_type'];
		}elseif ( $products ) {
			$post_type = 'product';
		}else{
			$post_type = 'post';
		}

		$classes = woodmart_owl_items_per_slide( $slides_per_view, array(), $post_type );
		$classes .= ' slider-type-' . $post_type;

		if ( $post_type == 'post' ) {
			$carousel_classes .= ' woodmart-spacing-' . $blog_spacing;
			$carousel_classes .= ' blog-spacing-' . $blog_spacing;
		}

		if ( $el_class ) $classes .= ' ' . $el_class;

		$parsed_atts['carousel_id'] = $carousel_id;
		$parsed_atts['post_type'] = $post_type;

		if ( $parsed_atts['carousel_js_inline'] == 'yes' ) {
			woodmart_owl_carousel_init( $parsed_atts );
		} else {
			$owl_atts = woodmart_get_owl_attributes( $parsed_atts );
		}

		if( ( $query && $query->have_posts() ) || $products) {
			?>
				<div id="<?php echo esc_attr( $carousel_id ); ?>" class="vc_carousel_container <?php echo esc_attr( $carousel_classes ); ?>" <?php echo ( $owl_atts ); ?>>
					<?php 
						if ( $title ) echo '<h3 class="title slider-title">' . esc_html( $title ) . '</h3>';
						if ( $element_title ) echo '<h4 class="title element-title">' . esc_html( $element_title ) . '</h4>';
					?>
					<div class="owl-carousel <?php echo esc_attr( $classes ); ?>">

						<?php
							if( $products ) {
								foreach ( $products as $product )  {
									woodmart_carousel_query_item(false, $product);
								}
							} else {
								while ( $query->have_posts() ) {
									woodmart_carousel_query_item($query);
								}
							}

						?>

					</div> <!-- end product-items -->
				</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->

			<?php

		}
		wp_reset_postdata();
		
		woodmart_reset_loop();
		
		if ( function_exists( 'woocommerce_reset_loop' ) ) woocommerce_reset_loop();

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}

if( ! function_exists( 'woodmart_carousel_query_item' ) ) {
	function woodmart_carousel_query_item( $query = false, $product = false ) {
		global $post;
		if( $query ) {
			$query->the_post(); // Get post from query
		} else if( $product ) {
			$post_object = get_post( $product->get_id() );
			$post = $post_object;
			setup_postdata( $post );
		}
		?>
			<div class="slide-<?php echo get_post_type(); ?> owl-carousel-item">

				<?php if ( get_post_type() == 'product' || get_post_type() == 'product_variation' && woodmart_woocommerce_installed() ): ?>
					<?php woodmart_set_loop_prop( 'is_slider', true ); ?>
					<?php wc_get_template_part('content-product'); ?>
				<?php elseif( get_post_type() == 'portfolio' ): ?>
					<?php get_template_part( 'content', 'portfolio-slider' ); ?>
				<?php else: ?>
					<?php get_template_part( 'content', 'slider' ); ?>
				<?php endif ?>

			</div>
		<?php
	}
}