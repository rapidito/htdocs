<?php  
/**
 * The template for displaying Top-Bar
 *
 */
?>
<?php $top_bar_off = get_post_meta( woodmart_page_ID(), '_woodmart_top_bar_off', true ); ?>
<?php if( woodmart_get_opt('top-bar') && !$top_bar_off ): ?>
	<div class="topbar-wrapp header-color-<?php echo esc_attr( woodmart_get_opt('top-bar-color') ); ?>">
		<div class="container">
			<div class="topbar-content">
				<div class="top-bar-left topbar-column">
					
					<?php if( has_nav_menu( 'top-bar-menu-left' ) ) : ?>
						<div class="topbar-menu woodmart-navigation topbar-left-menu">
							<?php wp_nav_menu(
								array(
									'theme_location' => 'top-bar-menu-left',
									'walker' => new WOODMART_Mega_Menu_Walker()
								)
							); ?>
						</div>
					<?php endif; ?>
					
					<?php if( woodmart_get_opt( 'header_text' ) != '' ): ?>
						<div class="topbar-text topbar-left-text">
							<?php echo do_shortcode( woodmart_get_opt( 'header_text' ) ); ?>
						</div>
					<?php endif; ?>						
					
				</div>
				<div class="top-bar-right topbar-column">
					
					<?php if( woodmart_get_opt( 'top_bar_right_text' ) != '' ): ?>
						<div class="topbar-text topbar-right-text">
							<?php echo do_shortcode( woodmart_get_opt( 'top_bar_right_text' ) ); ?>
						</div>
					<?php endif; ?>		
					<?php if( has_nav_menu( 'top-bar-menu' ) ) : ?>
						<div class="topbar-menu woodmart-navigation topbar-right-menu">
							<?php wp_nav_menu(
								array(
									'theme_location' => 'top-bar-menu',
									'walker' => new WOODMART_Mega_Menu_Walker()
								)
							); ?>
						</div>
					<?php elseif( woodmart_get_opt( 'topbar_links' ) ): ?>
						<div class="topbar-menu woodmart-navigation topbar-right-menu">
							<ul class="menu">
								<?php echo woodmart_topbar_links( '', null, true ); ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div> 
<?php endif; ?><!--END TOP HEADER-->
