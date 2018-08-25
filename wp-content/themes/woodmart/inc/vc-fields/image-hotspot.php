<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* Image hotspot field
*/
if ( ! function_exists( 'woodmart_image_hotspot' ) && function_exists( 'vc_add_shortcode_param' ) ) {
	function woodmart_image_hotspot( $settings, $value ) {
		ob_start();
		$uniqid = uniqid();

		$position = explode( '||', $value );
		$left = ( isset( $position[0] ) && $position[0] ) ? $position[0] : '50';
		$top = ( isset( $position[1] ) && $position[1] ) ? $position[1] : '50';

		echo '<input type="hidden" class="woodmart-image-hotspot-position wpb_vc_param_value" name="' . esc_attr( $settings['param_name'] ) . '" value="' . esc_attr( $value ) . '">';
		echo '<div class="woodmart-image-hotspot-preview">';
			//Loader
			echo '
				<div class="xtemos-loader">
					<div class="xtemos-loader-el">
						<img src="' . WOODMART_ASSETS . '/images/loader/loader-el-1.svg' . '" alt="">
					</div>
					<div class="xtemos-loader-el">
						<img src="' . WOODMART_ASSETS . '/images/loader/loader-el-2.svg' . '" alt="">
					</div>
				</div>';

			echo '<div class="woodmart-image-hotspot" style="left: ' . $left . '%; top: ' . $top . '%;"></div>';
			echo '<div class="woodmart-image-hotspot-image"></div>';
			echo '<div class="woodmart-image-hotspot-overlay"></div>';
		echo '</div>';
		 
		?>
		<script type="text/javascript">
			(function( $ ){
				var $point = $('.woodmart-image-hotspot');
				var $frame = $('.woodmart-image-hotspot-preview');
				var $overlay = $('.woodmart-image-hotspot-overlay');
				var $positionField = $('.woodmart-image-hotspot-position');
				var isDragging = false;
				var timer;

				$overlay.on('mousedown', function (event) {
					isDragging = true;
					event.preventDefault();
				}).on('mouseup', function () {
					isDragging = false;
				}).on('mouseleave', function () {
					timer = setTimeout(function () {
						$overlay.trigger('mouseup');
					}, 500);
				}).on('mouseenter', function () {
					clearTimeout(timer);
				}).on('mousemove', function (event) {
					if (!isDragging) return;
					setPosition(event);
				}).on('click', function (event) {
					setPosition(event);
				}).on('dragstart', function (event) {
					event.preventDefault();
				});

				function setPosition(event) {
					var position = {
						x: (event.offsetX / $frame.width() * 100).toFixed(3),
						y: (event.offsetY / $frame.height() * 100).toFixed(3)
					};

					$point.css({
						left: position.x + '%',
						top: position.y + '%'
					});

					$positionField.attr('value', position.x + '||' + position.y).trigger('change');
				}
			})(jQuery);
		</script>
		<?php
		return ob_get_clean();
	}

	vc_add_shortcode_param( 'woodmart_image_hotspot', 'woodmart_image_hotspot' );
}