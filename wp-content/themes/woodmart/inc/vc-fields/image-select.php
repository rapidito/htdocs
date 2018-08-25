<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* Add image select
*/
if( ! function_exists( 'woodmart_add_image_select_type' ) && function_exists( 'vc_add_shortcode_param' ) ) {
	function woodmart_add_image_select_type( $settings, $value ) {
		$settings_value = array_flip( $settings['value'] );
        $uniqid = uniqid();
		ob_start();
		?>
			<input type="hidden" id="input-<?php echo esc_attr( $uniqid ); ?>" class="woodmart-image-select-input wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>">
			<ul class="woodmart-image-select" id="select-<?php echo esc_attr( $uniqid ); ?>">
				<?php foreach ( $settings['value'] as $key => $value ): ?>
					<li data-value="<?php echo esc_attr( $value ); ?>">
						<img src="<?php echo esc_url( $settings['images_value'][$value] ); ?>">
						<h4><?php echo esc_html( $settings_value[$value] ); ?></h4>
					</li>
				<?php endforeach; ?>
			</ul>
			
			<script type="text/javascript">
				(function( $ ){
					var inputValue = $( '#input-<?php echo esc_js( $uniqid ); ?>' ).attr( 'value' );
					$( '#select-<?php echo esc_js( $uniqid ); ?> li[data-value="'+ inputValue +'"]' ).addClass( 'selected' );
					$( '#select-<?php echo esc_js( $uniqid ); ?> li' ).click( function(){
						var _this = $( this ),
							dataValue = _this.data( 'value' );

						_this.siblings().removeClass( 'selected' );
						_this.addClass( 'selected' );
						$( '#input-<?php echo esc_js( $uniqid ); ?>' ).attr( 'value', dataValue ).trigger( 'change' );
					} );
				})(jQuery);
			</script>
		<?php
		return ob_get_clean();
	}
	vc_add_shortcode_param( 'woodmart_image_select', 'woodmart_add_image_select_type' );
}