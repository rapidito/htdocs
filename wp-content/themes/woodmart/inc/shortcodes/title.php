<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Section title shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_title' ) ) {
	function woodmart_shortcode_title( $atts ) {
		extract( shortcode_atts( array(
			'title' 	 => 'Title',
			'subtitle' 	 => '',
			'after_title'=> '',
			'link' 	 	 => '',
			'color' 	 => 'default',
			'woodmart_color_gradient' 	 => '',
			'style'   	 => 'default',
			'size' 		 => 'default',
			'subtitle_font' => 'default',
			'subtitle_style' => 'default',
			'align' 	 => 'center',
			'el_class' 	 => '',
			'css'		 => '',
			'tag'        => 'h4',
			'title_width' => '100',
			'font_weight' => '',
			'image' => '',
			'img_size' => '200x50',
			'css_animation' => 'none',
			
			'desktop_text_size' 	 => '',
			'tablet_text_size' 	 => '',
			'mobile_text_size' 	 => ''
		), $atts) );

		$output = $attrs = $separator = '';
		
		$title_id = 'woodmart-title-id-' . uniqid();

		$title_class = $subtitle_class = $title_container_class = '';

		$title_class .= ' woodmart-title-color-' . $color;
		$title_class .= ' woodmart-title-style-' . $style;
		$title_class .= ' woodmart-title-size-' . $size;
		$title_class .= ' woodmart-title-width-' . $title_width;
		$title_class .= ' text-' . $align;
		$title_class .= woodmart_get_css_animation( $css_animation );
		$title_class .= ( $el_class ) ? ' ' . $el_class : '';

		if( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$title_class .= ' ' . vc_shortcode_custom_css_class( $css );
		}
		
		$subtitle_class .= ' font-'. $subtitle_font;
		$subtitle_class .= ' style-'. $subtitle_style;
		
		$title_container_class .= ' woodmart-font-weight-'. $font_weight;
		
		$gradient_style = ( $color == 'gradient' ) ? 'style="' . woodmart_get_gradient_css( $woodmart_color_gradient ) . ';"' : '' ;

		if ( $image ) $separator = woodmart_display_icon( $image, $img_size, 128 );
		
		ob_start();
		?>

		<div id="<?php echo esc_attr( $title_id ); ?>" class="title-wrapper <?php echo esc_attr( $title_class ); ?>">

			<?php if ( $subtitle != '' ): ?>
				<div class="title-subtitle <?php echo esc_attr( $subtitle_class ); ?>"><?php echo ( $subtitle ); ?></div>
			<?php endif; ?>

			<div class="liner-continer">
				<span class="left-line"></span>
				 <?php echo '<'. $tag .' class="woodmart-title-container title ' . $title_container_class . '" ' . $gradient_style . '>' . $title . '</'. $tag .'>'; ?>
				 <?php echo ( $separator ); ?>
				<span class="right-line"></span>
			</div>
			
			<?php if ( $after_title != '' ): ?>
				<div class="title-after_title"><?php echo ( $after_title ); ?></div>
			<?php endif; ?>
			
			<?php if ( $size == 'custom' ): ?>
				<style>
					<?php if ( $desktop_text_size ): ?>
						<?php woodmart_responsive_text_size_css( $title_id, 'woodmart-title-container', $desktop_text_size ); ?>
					<?php endif ?>
					
					<?php if ( $tablet_text_size ): ?>
						@media (max-width: 1024px) {
							<?php woodmart_responsive_text_size_css( $title_id, 'woodmart-title-container', $tablet_text_size ); ?>
						}
					<?php endif ?>

					<?php if ( $mobile_text_size ): ?>
						@media (max-width: 767px) {
							<?php woodmart_responsive_text_size_css( $title_id, 'woodmart-title-container', $mobile_text_size ); ?>
						}
					<?php endif ?>
				</style>
			<?php endif ?>

		</div>
		
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;

	}
	add_shortcode( 'woodmart_title', 'woodmart_shortcode_title' );
}
