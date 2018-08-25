<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Section divider shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_row_divider' ) ) {
	function woodmart_row_divider( $atts ) {
		extract( shortcode_atts( array(
			'position' 	 => 'top',
			'color' 	 => '#e1e1e1',
			'style'   	 => 'waves-small',
			'content_overlap'    => '',
			'custom_height' => '',
			'el_class' 	 => '',
		), $atts) );

		$divider = woodmart_get_svg_content( $style . '-' . $position );
		$divider_id = 'svg-wrap-' . rand( 1000, 9999 );

		$classes = $divider_id;
		$classes .= ' dvr-position-' . $position;
		$classes .= ' dvr-style-' . $style;

		( $content_overlap != '' ) ? $classes .= ' dvr-overlap-enable' : false;
		( $el_class != '' ) ? $classes .= ' ' . $el_class : false ;
		ob_start();
		?>
			<div class="woodmart-row-divider <?php echo esc_attr( $classes ); ?>">
				<?php echo ( $divider ); ?>
				<style>.<?php echo esc_attr( $divider_id ); ?> svg {
						fill: <?php echo esc_html( $color ); ?>;
						<?php echo ( $custom_height ) ? 'height:' . esc_html( $custom_height ) : false ; ?>
					}
				</style>
			</div>
		<?php

		return  ob_get_clean();
	}
	add_shortcode( 'woodmart_row_divider', 'woodmart_row_divider' );
}