<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Timeline shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_timeline_shortcode' ) ) {
	function woodmart_timeline_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'line_color' 	 => '#e1e1e1',
			'dots_color' 	 => '#1e73be',
			'line_style' 	 => 'default',
			'item_style' 	 => 'default',
			'el_class' 	 => '',
		), $atts) );
		$timeline_id = uniqid();

		$classes = 'woodmart-timeline-wrapper';
		$classes .= ' woodmart-timeline-id-' . $timeline_id;
		$classes .= ' woodmart-item-' . $item_style;
		$classes .= ' woodmart-line-' . $line_style;

		$line_border_color = 'border-color: '. $line_color .';';
		$line_color = 'background-color: '. $line_color .';';


		( $el_class != '' ) ? $classes .= ' ' . $el_class : false ;
		ob_start();
		?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<style>
				.woodmart-timeline-id-<?php echo esc_attr ( $timeline_id ); ?> .woodmart-timeline-dot {
					background-color: <?php echo esc_attr( $dots_color ); ?>;
				}
			</style>
			<div class="woodmart-timeline-line" style="<?php echo esc_attr( $line_border_color ); ?>">
				<span class="line-dot dot-start" style="<?php echo esc_attr( $line_color ); ?>"></span>
				<span class="line-dot dot-end" style="<?php echo esc_attr( $line_color ); ?>"></span>
			</div>
			<div class="woodmart-timeline">
				<?php echo do_shortcode( $content ); ?>
			</div>
		</div>
		<?php

		return  ob_get_clean();
	}
	add_shortcode( 'woodmart_timeline', 'woodmart_timeline_shortcode' );
}

/**
* ------------------------------------------------------------------------------------------------
* Timeline item shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_timeline_item_shortcode' ) ) {
	function woodmart_timeline_item_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title_primary' 	 => '',
			'image_primary' => '',
			'img_size_primary' => 'full',
			'title_secondary' 	 => '',
			'content_secondary' 	 => '',
			'image_secondary' => '',
			'img_size_secondary' => 'full',
			'position' 	 => 'left',
			'color_bg'   => '',
			'el_class' 	 => '',
		), $atts) );

		$classes = 'woodmart-timeline-item';
		$classes .= ' woodmart-item-position-' . $position;

		$bg_style = 'background-color: '. $color_bg .';';
		$color_style = 'color: '. $color_bg .';';
		
		$img_primary = $img_secondary = '';
		
		if ( function_exists( 'wpb_getImageBySize' ) ) {
			$img_secondary = wpb_getImageBySize( array( 'attach_id' => $image_secondary, 'thumb_size' => $img_size_secondary ) );
			$img_primary = wpb_getImageBySize( array( 'attach_id' => $image_primary, 'thumb_size' => $img_size_primary ) );
		}

		( $el_class != '' ) ? $classes .= ' ' . $el_class : false ;
		ob_start();
		?>
		<div class="<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $bg_style ); ?>">

			<div class="woodmart-timeline-dot"></div>

			<div class="timeline-col timeline-col-primary" style="<?php echo esc_attr( $bg_style ); ?>">
				<span class="timeline-arrow" style="<?php echo esc_attr( $color_style ); ?>"></span>
				<?php if ( $image_primary ): ?>
					<div class="woodmart-timeline-image" >
						<?php echo $img_primary['thumbnail']; ?>
					</div>
				<?php endif ?>
				<h4 class="woodmart-timeline-title"><?php echo esc_attr( $title_primary ); ?></h4> 
				<div class="woodmart-timeline-content reset-mb-10"><?php echo do_shortcode( $content ); ?></div>
			</div>

			<div class="timeline-col timeline-col-secondary" style="<?php echo esc_attr( $bg_style ); ?>">	
				<span class="timeline-arrow" style="<?php echo esc_attr( $color_style ); ?>"></span>
				<?php if ( $image_secondary ): ?>
					<div class="woodmart-timeline-image" >
						<?php echo $img_secondary['thumbnail']; ?>
					</div>
				<?php endif ?>
				<h4 class="woodmart-timeline-title"><?php echo esc_attr( $title_secondary ); ?></h4> 
				<div class="woodmart-timeline-content reset-mb-10"><?php echo do_shortcode( $content_secondary ); ?></div>
			</div>

		</div>
		<?php

		return  ob_get_clean();
	}
	add_shortcode( 'woodmart_timeline_item', 'woodmart_timeline_item_shortcode' );
}

/**
* ------------------------------------------------------------------------------------------------
* Timeline breakpoint shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_timeline_breakpoint_shortcode' ) ) {
	function woodmart_timeline_breakpoint_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' 	 => '',
			'color_bg'      => '',
			'el_class' 	 => '',
		), $atts) );

		$classes = 'woodmart-timeline-breakpoint';

		( $el_class != '' ) ? $classes .= ' ' . $el_class : false ;
		ob_start();
		?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<span class="woodmart-timeline-breakpoint-title" style="background-color: <?php echo esc_attr( $color_bg ); ?>;"><?php echo esc_attr( $title ); ?></span> 
		</div>
		<?php

		return  ob_get_clean();
	}
	add_shortcode( 'woodmart_timeline_breakpoint', 'woodmart_timeline_breakpoint_shortcode' );
}