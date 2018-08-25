<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* New gallery shortcode
* ------------------------------------------------------------------------------------------------
*/
if( ! function_exists( 'woodmart_images_gallery_shortcode' )) {
	function woodmart_images_gallery_shortcode($atts) {
		$output = $class = $owl_atts = '';

		$parsed_atts = shortcode_atts( array_merge( woodmart_get_owl_atts(), array(
			'ids'        => '',
			'images'     => '',
			'columns'    => 3,
			'size'       => '',
			'img_size'   => 'medium',
			'link'       => '',
			'spacing' 	 => 30,
			'on_click'   => 'lightbox',
			'target_blank' => false,
			'custom_links' => '',
			'view'		 => 'grid',
			'caption'    => false,
			'speed' => '5000',
			'autoplay' => 'no',
			'css_animation' => 'none',
			'el_class' 	 => ''
		) ), $atts );

		extract( $parsed_atts );

		// Override standard wordpress gallery shortcodes

		if ( ! empty( $atts['ids'] ) ) {
			$atts['images'] = $atts['ids'];
		}

		if ( ! empty( $atts['size'] ) ) {
			$atts['img_size'] = $atts['size'];
		}

		extract( $atts );

		$carousel_id = 'gallery_' . rand(100,999);

		$images = explode(',', $images);

		$class .= ' ' . $el_class;
		if( $view != 'justified' ){
			$class .= ' woodmart-spacing-' . $spacing;
			$class .= ' gallery-spacing-' . $spacing;
		} 
		$class .= ' columns-' . $columns;
		$class .= ' view-' . $view;
		$class .= woodmart_get_css_animation( $css_animation );

		if( 'lightbox' === $on_click ) {
			$class .= ' photoswipe-images';
			woodmart_enqueue_script( 'woodmart-photoswipe' );
		}

		if ( 'links' === $on_click && function_exists( 'vc_value_from_safe' ) ) {
			$custom_links = vc_value_from_safe( $custom_links );
			$custom_links = explode( ',', $custom_links );
		}

		if ( $view == 'carousel' ){
			$parsed_atts['carousel_id'] = $carousel_id;
			$owl_atts = woodmart_get_owl_attributes( $parsed_atts );
		}

		ob_start(); ?>
			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="woodmart-images-gallery<?php echo esc_attr( $class ); ?>" <?php echo ( $owl_atts ); ?>>
				<div class="gallery-images <?php if ( $view == 'carousel' ) echo 'owl-carousel ' . woodmart_owl_items_per_slide( $slides_per_view ); ?>">
					<?php if ( count($images) > 0 ): ?>
						<?php $i=0; foreach ($images as $img_id):
							$i++;
							$attachment = get_post( $img_id );
							$title = trim( strip_tags( $attachment->post_title ) );
							$img = '';
							if ( function_exists( 'wpb_getImageBySize' ) ) {
								$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'woodmart-gallery-image image-' . $i ) );
							}
							$link = ( isset( $img['p_img_large']['0'] ) )? $img['p_img_large']['0'] : '';
							$width = ( isset( $img['p_img_large']['1'] ) )? $img['p_img_large']['1'] : '';
							$height = ( isset( $img['p_img_large']['2'] ) )? $img['p_img_large']['2'] : '';
							if( 'links' === $on_click ) {
								$link = (isset( $custom_links[$i-1] ) ? $custom_links[$i-1] : '' );
							}
							?>
							<div class="woodmart-gallery-item">
								<?php if ( $on_click != 'none' ): ?>
									<a href="<?php echo esc_url( $link ); ?>" data-index="<?php echo esc_attr( $i ); ?>" data-width="<?php echo esc_attr( $width ); ?>" data-height="<?php echo esc_attr( $height ); ?>" <?php if( $target_blank ): ?>target="_blank"<?php endif; ?> <?php if( $caption ): ?>title="<?php echo esc_attr( $title ); ?>"<?php endif; ?>>
								<?php endif ?>
								
								<?php if ( isset( $img['thumbnail'] ) ): ?>
									<?php echo $img['thumbnail']; ?>
								<?php endif; ?>
								
								<?php if ( $on_click != 'none' ): ?>
									</a>
								<?php endif ?>
							</div>
						<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			<?php if ( $view == 'masonry' ): 
				woodmart_enqueue_script( 'isotope' );
				woodmart_enqueue_script( 'woodmart-packery-mode' );
				
				wp_add_inline_script('woodmart-theme', 'jQuery( document ).ready(function( $ ) {
	                if (typeof($.fn.isotope) == "undefined" || typeof($.fn.imagesLoaded) == "undefined") return;
	                var $container = $(".view-masonry .gallery-images");

	                // initialize Masonry after all images have loaded
	                $container.imagesLoaded(function() {
	                    $container.isotope({
	                        gutter: 0,
	                        isOriginLeft: ! $("body").hasClass("rtl"),
	                        itemSelector: ".woodmart-gallery-item"
	                    });
	                });
				});', 'after');

			elseif ( $view == 'justified' ): 
				woodmart_enqueue_script( 'woodmart-justifiedGallery' );
				
				wp_add_inline_script('woodmart-theme', 'jQuery( document ).ready(function( $ ) {
					$("#' . esc_js( $carousel_id ) . ' .gallery-images").justifiedGallery({
						margins: 1
					});
				});', 'after');

			endif ?>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
	add_shortcode( 'woodmart_gallery', 'woodmart_images_gallery_shortcode' );
}