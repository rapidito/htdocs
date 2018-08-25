<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

// **********************************************************************//
// ! Body classes
// **********************************************************************//

if( ! function_exists( 'woodmart_body_class' ) ) {
	function woodmart_body_class( $classes ) {

		$page_id = woodmart_page_ID();

		$site_width = woodmart_get_opt( 'site_width' );
		$product_design = woodmart_product_design();
		$product_sticky = woodmart_product_sticky();

		$ajax_shop = woodmart_get_opt( 'ajax_shop' );
		$ajax_search = woodmart_get_opt( 'search_ajax' );
		$hide_sidebar_mobile = woodmart_get_opt( 'shop_hide_sidebar' );
		$hide_sidebar_tablet = woodmart_get_opt( 'shop_hide_sidebar_tablet' );
		$hide_sidebar_desktop = woodmart_get_opt( 'shop_hide_sidebar_desktop' );
		$catalog_mode = woodmart_get_opt( 'catalog_mode' );
		$categories_toggle = woodmart_get_opt( 'categories_toggle' );
		$sticky_footer = woodmart_get_opt( 'sticky_footer' );
		$dark = woodmart_get_opt( 'dark_version' );
		$form_fields_style = ( woodmart_get_opt( 'form_fields_style' ) ) ? woodmart_get_opt( 'form_fields_style' ) : 'square';
		$form_border_width = woodmart_get_opt( 'form_border_width' );
		$menu_style = ( woodmart_get_opt( 'menu_style' ) ) ? woodmart_get_opt( 'menu_style' ) : 'default';
		$full_screen_menu = woodmart_get_opt( 'full_screen_menu' );
		$single_post_design = woodmart_get_opt( 'single_post_design' );
		$main_sidebar_mobile = woodmart_get_opt( 'hide_main_sidebar_mobile' );

		if ( $single_post_design == 'large_image' && is_single() ) {
			$classes[] = 'single-post-large-image';
		}

		$header_overlap = $header_sticky = $disable_sticky = false;

		$classes[] = 'wrapper-' . $site_width;
		// Form style settings
		$classes[] = 'form-style-' . $form_fields_style;
		$classes[] = 'form-border-width-' . $form_border_width;

		$classes[] = ( $full_screen_menu ) ? 'global-full-screen-menu' : '';

		if( is_singular( 'product' ) ) {
			$classes[] = 'woodmart-product-design-' . $product_design;
			if( $product_sticky ) {
				$classes[] = 'woodmart-product-sticky-on';
				woodmart_enqueue_script( 'woodmart-sticky-kit' );
			}
		}
		
		if ( woodmart_woocommerce_installed() && ( is_shop() || is_product_category() ) && ( $hide_sidebar_desktop && $sticky_footer ) ) {
			$classes[] = 'no-sticky-footer';
		}elseif( $sticky_footer ){
			$classes[] = 'sticky-footer-on';
		}
		
		$classes[] = ( $dark ) ? 'woodmart-dark' : 'woodmart-light';

		if( $catalog_mode ) {
			$classes[] = 'catalog-mode-on';
		} else {
			$classes[] = 'catalog-mode-off';
		}

		if( $categories_toggle ) {
			$classes[] = 'categories-accordion-on';
		} else {
			$classes[] = 'categories-accordion-off';
		}

		if( woodmart_is_blog_archive() ) {
			$classes[] = 'woodmart-archive-blog';
		} else if( woodmart_is_shop_archive() ) {
			$classes[] = 'woodmart-archive-shop';
		} else if( woodmart_is_portfolio_archive() ) {
			$classes[] = 'woodmart-archive-portfolio';
		}
		
		//Header banner
		if ( ! woodmart_get_opt( 'header_close_btn' ) && woodmart_get_opt( 'header_banner' ) && ! woodmart_maintenance_page() ) {
			$classes[] = 'header-banner-display';
		}
		if ( woodmart_get_opt( 'header_banner' ) && ! woodmart_maintenance_page() ) {
			$classes[] = 'header-banner-enabled';
		}
		
		if( $ajax_shop ) {
			$classes[] = 'woodmart-ajax-shop-on';
		} else {
			$classes[] = 'woodmart-ajax-shop-off';
		}

		if( $ajax_search ) {
			$classes[] = 'woodmart-ajax-search-on';
		} else {
			$classes[] = 'woodmart-ajax-search-off';
		}

		if( $hide_sidebar_mobile && ( woodmart_woocommerce_installed() && ( is_shop() || is_product_category() ) ) || $main_sidebar_mobile && ( ! woodmart_woocommerce_installed() || ( ! is_shop() && ! is_product_category() ) ) ) {
			$classes[] = 'offcanvas-sidebar-mobile';
		}

		if( $hide_sidebar_tablet ) {
			$classes[] = 'offcanvas-sidebar-tablet';
		}

		if( $hide_sidebar_desktop ) {
			$classes[] = 'offcanvas-sidebar-desktop';
		}

		if ( ! is_user_logged_in() && woodmart_get_opt( 'login_prices' ) ) {
			$classes[] = 'login-see-prices';
		}

		$classes = array_merge( $classes, woodmart_get_buttons_config_classes(), woodmart_get_header_body_classes() );

		return $classes;
	}

	add_filter('body_class', 'woodmart_body_class');
}



/**
 * ------------------------------------------------------------------------------------------------
 * Get header body classes
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_header_body_classes' ) ) {
	function woodmart_get_header_body_classes() {
		$classes = array();
		if( whb_is_enabled() ) {

			$settings = whb_get_settings();

			$classes[] = 'whb-enabled';

			if( $settings['overlap'] ) $classes[] = 'woodmart-header-overcontent';
			if( $settings['sticky_shadow'] ) $classes[] = 'woodmart-sticky-shadow';
			if( $settings['sticky_effect'] ) $classes[] = 'woodmart-scroll-' . $settings['sticky_effect'];
			if( $settings['sticky_clone'] && $settings['sticky_effect'] == 'slide' ) $classes[] = 'woodmart-sticky-clone';
			$classes[] = 'dropdowns-color-' . whb_get_dropdowns_color(); 

		} else {
			$page_id = woodmart_page_ID();

			$site_width = woodmart_get_opt( 'site_width' );
			$cart_design = woodmart_get_opt( 'shopping_cart' );
			$wishlist = woodmart_get_opt( 'header_wishlist' );
			$header = woodmart_get_opt( 'header' );
			$header_overlap_opt = woodmart_get_opt( 'header-overlap' );
			$top_bar = woodmart_get_opt( 'top-bar' );
			$header_search = woodmart_get_opt( 'header_search' );
			$logo_responsive = woodmart_get_opt( 'logo_responsive_sizes' );
			$menu_style = ( woodmart_get_opt( 'menu_style' ) ) ? woodmart_get_opt( 'menu_style' ) : 'default';
			$header_dropdowns = ( woodmart_get_opt( 'header_dropdowns_dark' ) ) ? 'light' : 'dark';

			$top_bar = woodmart_get_opt( 'top-bar' );
			$top_bar_page = get_post_meta( $page_id, '_woodmart_top_bar_off', true );

			$header_overlap = $header_sticky = $disable_sticky = false;

			$classes[] = 'global-cart-design-' . $cart_design;
			$classes[] = 'global-search-' . $header_search;
			// Header menu style settings
			$classes[] = 'menu-style-' . $menu_style;
			$classes[] = 'dropdowns-color-' . $header_dropdowns;

			if( $wishlist != 'disable' ) {
				$classes[] = 'global-wishlist-enable';
			} else {
				$classes[] = 'global-wishlist-disable';
			}


		
			if( $top_bar && !$top_bar_page ) {
				$classes[] = 'woodmart-top-bar-on';
			}else {
				$classes[] = 'woodmart-top-bar-off';
			}

			if( $top_bar && woodmart_get_opt( 'top_bar_right_text' ) != '' && !$top_bar_page ) {
				$classes[] = 'woodmart-top-bar-mobile-on';
			} else {
				$classes[] = 'woodmart-top-bar-mobile-off';
			}

			$classes[] = ( $logo_responsive ) ? 'logo-responsive-on' : 'logo-responsive-off';

			// Sticky header settings
			if( woodmart_get_opt('sticky_header') ) {
				$classes[] = 'enable-sticky-header';
				$header_sticky = true;
			} else {
				$disable_sticky = true;
				$classes[] = 'disable-sticky-header';
			}

			// Force header full width class
			if( is_singular( 'product') && woodmart_get_opt('single_full_width') ) {
				$classes[] = 'header-full-width';
			}

			if( woodmart_get_opt('header_full_width') ) {
				$classes[] = 'header-full-width';
			}

			if( in_array( $header, array('menu-top') ) ) {
				$header_sticky = false;
				$classes[] = 'sticky-navigation-only';
			} else if( in_array( $header, array('base', 'simple', 'logo-center', 'categories') ) ) {
				$header_sticky = 'clone';
			}

			$classes[] = 'woodmart-header-' . $header;

			// If header type is SHOP and overlap option is enabled
			if( $header == 'shop' || $header == 'split' ) {
				$header_sticky = 'real';
				if( $header_overlap_opt ) {
					$header_overlap = true;
				}
			}

			if( $header == 'simple' && $header_overlap_opt ) {
				$header_overlap = true;
				$header_sticky = 'real';
			}

			if( $header_overlap ) {
				$classes[] = 'woodmart-header-overlap';
			}

			if( $header_sticky == 'clone' && ! $disable_sticky ) {
				$classes[] = 'sticky-header-clone';
			} elseif( $header_sticky == 'real' && ! $disable_sticky ) {
				$classes[] = 'sticky-header-real';
			}

		}

		return $classes;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Buttons configuration classes
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_buttons_config_classes' ) ) {
	function woodmart_get_buttons_config_classes() {
		$classes = array();

		$classes[] = 'btns-default-' . woodmart_get_opt( 'btns_default_style' );
		$classes[] = 'btns-default-' . woodmart_get_opt( 'btns_default_color_scheme' );
		$classes[] = 'btns-default-hover-' . woodmart_get_opt( 'btns_default_color_scheme_hover' );

		$classes[] = 'btns-shop-' . woodmart_get_opt( 'btns_shop_style' );
		$classes[] = 'btns-shop-' . woodmart_get_opt( 'btns_shop_color_scheme' );
		$classes[] = 'btns-shop-hover-' . woodmart_get_opt( 'btns_shop_color_scheme_hover' );

		$classes[] = 'btns-accent-' . woodmart_get_opt( 'btns_accent_style' );
		$classes[] = 'btns-accent-' . woodmart_get_opt( 'btns_accent_color_scheme' );
		$classes[] = 'btns-accent-hover-' . woodmart_get_opt( 'btns_accent_color_scheme_hover' );

		return $classes;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Filter wp_title
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_wp_title' ) ) {
	function woodmart_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'woodmart' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'woodmart_wp_title', 10, 2 );

}

/**
 * ------------------------------------------------------------------------------------------------
 * Get predefined footer configuration by index
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_footer_config' ) ) {
	function woodmart_get_footer_config( $index ) {

		if( $index > 20 || $index < 1) {
			$index = 1;
		}

		$configs = apply_filters( 'woodmart_footer_configs_array', array(
			1 => array(
				'cols' => array(
					'col-sm-12'
				),

			),
			2 => array(
				'cols' => array(
					'col-sm-6',
					'col-sm-6',
				),
			),
			3 => array(
				'cols' => array(
					'col-sm-4',
					'col-sm-4',
					'col-sm-4',
				),
			),
			4 => array(
				'cols' => array(
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
				),
				'clears' => array(
					2 => 'sm'
				)
			),
			5 => array(
				'cols' => array(
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
				),
				'clears' => array(
					3 => 'sm'
				)
			),
			6 => array(
				'cols' => array(
					'col-md-3 col-sm-4',
					'col-md-6 col-sm-4',
					'col-md-3 col-sm-4',
				),
			),
			7 => array(
				'cols' => array(
					'col-md-6 col-sm-4',
					'col-md-3 col-sm-4',
					'col-md-3 col-sm-4',
				),
			),
			8 => array(
				'cols' => array(
					'col-md-3 col-sm-4',
					'col-md-3 col-sm-4',
					'col-md-6 col-sm-4',
				),
			),
			9 => array(
				'cols' => array(
					'col-md-12 col-sm-12',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
				),
				'clears' => array(
					1 => 'md',
					1 => 'lg',
					3 => 'sm',
				),
			),
			10 => array(
				'cols' => array(
					'col-md-6 col-sm-12',
					'col-md-6 col-sm-12',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
				),
				'clears' => array(
					2 => 'md',
					2 => 'lg',
					4 => 'sm',
				),
			),
			11 => array(
				'cols' => array(
					'col-md-6 col-sm-12',
					'col-md-6 col-sm-12',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-4 col-sm-12',
				),
				'clears' => array(
					2 => 'md',
					2 => 'lg',
					4 => 'sm',
				),
			),
			12 => array(
				'cols' => array(
					'col-md-12 col-sm-12',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-4 col-sm-12',
				),
				'clears' => array(
					1 => 'md',
					1 => 'lg',
					3 => 'sm',
				),
			),
			13 => array(
				'cols' => array(
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
				),
				'clears' => array(
					2 => 'md',
					2 => 'sm',
				),
			),
		) );

		return (isset( $configs[$index] )) ? $configs[$index] : array();
	}
}


// **********************************************************************//
// ! Theme 3d plugins
// **********************************************************************//


if(!defined('YITH_REFER_ID')) {
	define('YITH_REFER_ID', '1040314');
}


if( ! function_exists( 'woodmart_3d_plugins' )) {
	function woodmart_3d_plugins() {
		if( function_exists( 'set_revslider_as_theme' ) ){
			set_revslider_as_theme();
		}
	}

	add_action( 'init', 'woodmart_3d_plugins' );
}

if( ! function_exists( 'woodmart_vcSetAsTheme' ) ) {

	function woodmart_vcSetAsTheme() {
		if( function_exists( 'vc_set_as_theme' ) ){
			vc_set_as_theme();
		}
	}

	add_action( 'vc_before_init', 'woodmart_vcSetAsTheme' );
}


// **********************************************************************//
// ! Obtain real page ID (shop page, blog, portfolio or simple page)
// **********************************************************************//

/**
 * This function is called once when initializing WOODMART_Layout object
 * then you can use function woodmart_page_ID to get current page id
 */
if( ! function_exists( 'woodmart_get_the_ID' ) ) {
	function woodmart_get_the_ID( $args = array() ) {
		global $post;

		$page_id = 0;

		$page_for_posts    = get_option( 'page_for_posts' );
		$page_for_shop     = get_option( 'woocommerce_shop_page_id' );
		$page_for_projects = woodmart_tpl2id( 'portfolio.php' );
		$custom_404_id 	   = woodmart_get_opt( 'custom_404_page' );

		if(isset($post->ID)) $page_id = $post->ID;

		if( isset($post->ID) && ( is_singular( 'page' ) || is_singular( 'post' ) ) ) {
			$page_id = $post->ID;
		} else if( is_home() || is_singular( 'post' ) || is_search() || is_tag() || is_category() || is_date() || is_author() ) {
			$page_id = $page_for_posts;
		} else if( is_archive('portfolio') && get_post_type() == 'portfolio' ) {
			$page_id = $page_for_projects;
		}

		if( woodmart_woocommerce_installed() && function_exists( 'is_shop' )  ) {
			if( isset( $args['singulars'] ) && in_array( 'product', $args['singulars']) && is_singular( "product" ) ) {
				// keep post id
			} else if( is_shop() || is_product_category() || is_product_tag() || is_singular( "product" ) || woodmart_is_product_attribute_archieve() ) {
				$page_id = $page_for_shop;
			}
		}

		if( is_404() && ( $custom_404_id != 'default' || ! empty( $custom_404_id ) ) ) $page_id = $custom_404_id;

		return $page_id;
	}
}


// **********************************************************************//
// ! Function to get HTML block content
// **********************************************************************//

if( ! function_exists( 'woodmart_get_html_block' ) ) {
	function woodmart_get_html_block($id) {
		$content = get_post_field('post_content', $id);

		$content = do_shortcode($content);

		$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shortcodes_custom_css ) ) {
			$content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			$content .= $shortcodes_custom_css;
			$content .= '</style>';
		}

		return $content;
	}

}

if( ! function_exists( 'woodmart_get_static_blocks_array' ) ) {
	function woodmart_get_static_blocks_array() {
		$args = array( 'posts_per_page' => 200, 'post_type' => 'cms_block' );
		$blocks_posts = get_posts( $args );
		$array = array();
		foreach ( $blocks_posts as $post ) :
			setup_postdata( $post );
			$array[$post->post_title] = $post->ID;
		endforeach;
		wp_reset_postdata();
		return $array;
	}
}

// **********************************************************************//
// ! Set excerpt length and more btn
// **********************************************************************//

add_filter( 'excerpt_length', 'woodmart_excerpt_length', 999 );

if( ! function_exists( 'woodmart_excerpt_length' ) ) {
	function woodmart_excerpt_length( $length ) {
		return 20;
	}
}

add_filter('excerpt_more', 'woodmart_new_excerpt_more');

if( ! function_exists( 'woodmart_new_excerpt_more' ) ) {
	function woodmart_new_excerpt_more( $more ) {
		return '';
	}
}

// **********************************************************************//
// ! Add scroll to top buttom
// **********************************************************************//

add_action( 'woodmart_after_footer', 'woodmart_scroll_top_btn' );

if( ! function_exists( 'woodmart_scroll_top_btn' ) ) {
	function woodmart_scroll_top_btn( $more ) {
		if( !woodmart_get_opt( 'scroll_top_btn' ) ) return;
		?>
			<a href="#" class="scrollToTop"><?php esc_attr_e( 'Scroll To Top', 'woodmart' ); ?></a>
		<?php
	}
}


// **********************************************************************//
// ! Return related posts args array
// **********************************************************************//

if( ! function_exists( 'woodmart_get_related_posts_args' ) ) {
	function woodmart_get_related_posts_args( $post_id ) {
		$taxs = wp_get_post_tags( $post_id );
		$args = array();
		if ( $taxs ) {
			$tax_ids = array();
			foreach( $taxs as $individual_tax ) $tax_ids[] = $individual_tax->term_id;

			$args = array(
				'tag__in'               => $tax_ids,
				'post__not_in'          => array( $post_id ),
				'showposts'             => 12,
				'ignore_sticky_posts'   => 1
			);

		}

		return $args;
	}
}

// **********************************************************************//
// ! Navigation walker
// **********************************************************************//

if( ! class_exists( 'WOODMART_Mega_Menu_Walker' )) {
	class WOODMART_Mega_Menu_Walker extends Walker_Nav_Menu {

		private $color_scheme = 'dark';

		public function __construct() {
			$this->color_scheme = whb_get_dropdowns_color();
		}

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			if ( woodmart_get_opt( 'full_screen_menu' ) && isset( $args->menu->slug ) && $args->menu->slug == 'main-navigation' ) $this->color_scheme = 'light';

			if( $depth == 0) {
				$output .= "\n$indent<div class=\"sub-menu-dropdown color-scheme-" . $this->color_scheme . "\">\n";
				$output .= "\n$indent<div class=\"container\">\n";

			}
			if( $depth < 1 ) {
				$sub_menu_class = "sub-menu";
			} else {
				$sub_menu_class = "sub-sub-menu";
			}

			$output .= "\n$indent<ul class=\"$sub_menu_class color-scheme-" . $this->color_scheme . "\">\n";

			if( $this->color_scheme == 'light' || $this->color_scheme == 'dark' ) $this->color_scheme = whb_get_dropdowns_color() ;
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
			if( $depth == 0) {
				$output .= "$indent</div>\n";
				$output .= "$indent</div>\n";
			}
		}

		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'item-level-' . $depth;

			$design = $width = $height = $icon = $label = $label_out = '';
			$design  = get_post_meta( $item->ID, '_menu_item_design',  true );
			$width   = get_post_meta( $item->ID, '_menu_item_width',   true );
			$height  = get_post_meta( $item->ID, '_menu_item_height',  true );
			$icon    = get_post_meta( $item->ID, '_menu_item_icon',    true );
			$event   = get_post_meta( $item->ID, '_menu_item_event',   true );
			$label   = get_post_meta( $item->ID, '_menu_item_label',   true );
			$label_text = get_post_meta( $item->ID, '_menu_item_label-text',   true );
			$block   = get_post_meta( $item->ID, '_menu_item_block',   true );
			$opanchor = get_post_meta( $item->ID, '_menu_item_opanchor', true );
			$callbtn  = get_post_meta( $item->ID, '_menu_item_callbtn', true );
			$color_scheme = get_post_meta( $item->ID, '_menu_item_colorscheme', true );

			if ( $color_scheme == 'light' ) {
				$this->color_scheme = 'light';
			}elseif( $color_scheme == 'dark' ){
				$this->color_scheme = 'dark';
			}

			if( empty($design) ) $design = 'default';

			if ( ! is_object( $args ) ) return;

			if( $depth == 0 && $args->menu_class != 'site-mobile-menu' ) {
				$classes[] = 'menu-item-design-' . $design;
				$classes[] = 'menu-' . ( (  in_array( $design, array( 'sized', 'full-width' ) ) ) ? 'mega-dropdown' : 'simple-dropdown' );
				$event = (empty($event)) ? 'hover' : $event;
				$classes[] = 'item-event-' . $event;
			}

			if( $opanchor == 'enable' ) {
				 $classes[] = 'onepage-link';
				if(($key = array_search('current-menu-item', $classes)) !== false) {
					unset($classes[$key]);
				}
			}

			if( $callbtn == 'enable' ) {
				$classes[] = 'callto-btn';
			}

			if( !empty( $label ) ) {
				$classes[] = 'item-with-label';
				$classes[] = 'item-label-' . $label;
				$label_out = '<span class="menu-label menu-label-' . $label . '">' . esc_attr( $label_text ) . '</span>';
			}

			if( ! empty( $block ) && $design != 'default' ) {
				$classes[] = 'menu-item-has-children';
			}
			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$atts['class'] = 'woodmart-nav-link';

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon_url = '';

			if( $item->object == 'product_cat' ) {
				$icon_url = get_term_meta( $item->object_id, 'category_icon_alt', true );
			}

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			if($icon != '') {
				$item_output .= '<i class="fa fa-' . $icon . '"></i>';
			}
			if( ! empty( $icon_url ) ) {
				$item_output .= '<img src="'  . esc_url( $icon_url ) . '" alt="' . esc_attr( $item->title ) . '" class="category-icon" />';
			}
			/** This filter is documented in wp-includes/post-template.php */
			$item_output .= '<span>' . $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . '</span>';
			$item_output .= $label_out;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$styles = '';

			if( $depth == 0 && $args->menu_class != 'site-mobile-menu' ) {
				/**
				 * Add background image to dropdown
				 **/


				if( has_post_thumbnail( $item->ID ) ) {
					$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );

					//ar($post_thumbnail);

					$styles .= '.menu-item-' . $item->ID . ' > .sub-menu-dropdown {';
						$styles .= 'background-image: url(' . $post_thumbnail[0] .'); ';
					$styles .= '}';
				}

				if ( woodmart_get_opt( 'full_screen_menu' ) && isset( $args->menu->slug ) && $args->menu->slug == 'main-navigation' ) $this->color_scheme = 'light';
				
				if( ! empty( $block ) && !in_array("menu-item-has-children", $item->classes) && $design != 'default' ) {
					$item_output .= "\n$indent<div class=\"sub-menu-dropdown color-scheme-" . $this->color_scheme . "\">\n";
					$item_output .= "\n$indent<div class=\"container\">\n";
						$item_output .= woodmart_html_block_shortcode( array( 'id' => $block ) );
					$item_output .= "\n$indent</div>\n";
					$item_output .= "\n$indent</div>\n";

					if( $this->color_scheme == 'light' || $this->color_scheme == 'dark' ) $this->color_scheme = whb_get_dropdowns_color() ;
				}
			}

			if($design == 'sized' && !empty($height) && !empty($width) && $args->menu_class != 'site-mobile-menu' ) {
				$styles .= '.menu-item-' . $item->ID . '.menu-item-design-sized > .sub-menu-dropdown {';
					$styles .= 'min-height: ' . $height .'px; ';
					$styles .= 'width: ' . $width .'px; ';
				$styles .= '}';
			}

			if( $styles != '' && $args->menu_class != 'site-mobile-menu' ) {
				$item_output .= '<style type="text/css">';
				$item_output .= $styles;
				$item_output .= '</style>';
			}

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}



// **********************************************************************//
// ! // Deletes first gallery shortcode and returns content (http://stackoverflow.com/questions/17224100/wordpress-remove-shortcode-and-save-for-use-elsewhere)
// **********************************************************************//

if( ! function_exists( 'woodmart_strip_shortcode_gallery' ) ) {
	function  woodmart_strip_shortcode_gallery( $content ) {
		preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );
		if ( ! empty( $matches ) ) {
			foreach ( $matches as $shortcode ) {
				if ( 'gallery' === $shortcode[2] ) {
					$pos = strpos( $content, $shortcode[0] );
					if ($pos !== false)
						return substr_replace( $content, '', $pos, strlen($shortcode[0]) );
				}
			}
		}
		return $content;
	}
}


// **********************************************************************//
// ! Get exceprt from post content
// **********************************************************************//

if( ! function_exists( 'woodmart_excerpt_from_content' ) ) {
	function woodmart_excerpt_from_content($post_content, $limit, $shortcodes = '') {
		// Strip shortcodes and HTML tags
		if ( empty( $shortcodes )) {
			$post_content = preg_replace("/\[caption(.*)\[\/caption\]/i", '', $post_content);
			$post_content = preg_replace('`\[[^\]]*\]`','',$post_content);
		}

		$post_content = stripslashes( wp_filter_nohtml_kses( $post_content ) );

		if ( woodmart_get_opt( 'blog_words_or_letters' ) == 'letter' ) {
			$excerpt = mb_substr( $post_content, 0, $limit );
			if ( mb_strlen( $excerpt ) >= $limit ) {
				$excerpt .= '...';
			}
		}else{
			$limit++;
			$excerpt = explode(' ', $post_content, $limit);
			if ( count( $excerpt) >= $limit ) {
				array_pop( $excerpt );
				$excerpt = implode( " ", $excerpt ) . '...';
			} else {
				$excerpt = implode( " ", $excerpt );
			}
		}

		$excerpt = strip_tags( $excerpt );

		if ( trim( $excerpt ) == '...' ) {
			return '';
		}

		return $excerpt;
	}
}

// **********************************************************************//
// ! Get portfolio taxonomies dropdown
// **********************************************************************//

if( ! function_exists( 'woodmart_get_projects_cats_array') ) {
	function woodmart_get_projects_cats_array() {
		$return = array('All' => '');

		if( ! post_type_exists( 'portfolio' ) ) return array();

		$cats = get_terms( 'project-cat' );

		foreach ($cats as $key => $cat) {
			$return[$cat->name] = $cat->term_id;
		}

		return $return;
	}
}

// **********************************************************************//
// ! Get menus dropdown
// **********************************************************************//

if( ! function_exists( 'woodmart_get_menus_array') ) {
	function woodmart_get_menus_array() {
		$woodmart_menus = wp_get_nav_menus();
		$woodmart_menu_dropdown = array();

		foreach ( $woodmart_menus as $menu ) {

			$woodmart_menu_dropdown[$menu->term_id] = $menu->name;

		}

		return $woodmart_menu_dropdown;
	}
}


// **********************************************************************//
// ! Get custom header array created with header builder
// **********************************************************************//

if(!function_exists('woodmart_get_whb_headers_array')) {
	function woodmart_get_whb_headers_array( $get_from_options = false ) {
		if ( $get_from_options ) {
			$list = get_option( 'whb_saved_headers' ); 
		} else {
			$headers_list = whb_get_builder()->list;
			$list = $headers_list->get_all();
		}
		$headers = array();
		$headers['none'] = 'none';

		if( ! empty( $list ) && is_array( $list ) ) {
            foreach ($list as $key => $header) {
                $headers[$key] = $header['name'];
            }
        }

		return $headers;
	}
}

// **********************************************************************//
// ! Get registered sidebars dropdown
// **********************************************************************//

if(!function_exists('woodmart_get_sidebars_array')) {
	function woodmart_get_sidebars_array() {
		global $wp_registered_sidebars;
		$sidebars['none'] = 'none';
		foreach( $wp_registered_sidebars as $id=>$sidebar ) {
			$sidebars[ $id ] = $sidebar[ 'name' ];
		}
		return $sidebars;
	}
}


// **********************************************************************//
// ! If page needs header
// **********************************************************************//

if( ! function_exists( 'woodmart_needs_header' ) ) {
	function woodmart_needs_header() {
		return ( ! woodmart_maintenance_page() );
	}
}

// **********************************************************************//
// ! If page needs footer
// **********************************************************************//

if( ! function_exists( 'woodmart_needs_footer' ) ) {
	function woodmart_needs_footer() {
		return ( ! woodmart_maintenance_page() );
	}
}


// **********************************************************************//
// ! Conditional tags
// **********************************************************************//

if( ! function_exists( 'woodmart_is_shop_archive' ) ) {
	function woodmart_is_shop_archive() {
		return ( woodmart_woocommerce_installed() && ( is_shop() || is_product_category() || is_product_tag() || is_singular( "product" ) || woodmart_is_product_attribute_archieve() ) );
	}
}

if( ! function_exists( 'woodmart_is_blog_archive' ) ) {
	function woodmart_is_blog_archive() {
		return ( is_home() || is_search() || is_tag() || is_category() || is_date() || is_author() );
	}
}

if( ! function_exists( 'woodmart_is_portfolio_archive' ) ) {
	function woodmart_is_portfolio_archive() {
		return ( is_post_type_archive( 'portfolio' ) || is_tax( 'project-cat' ) );
	}
}


// **********************************************************************//
// ! Is maintenance page
// **********************************************************************//

if( ! function_exists( 'woodmart_maintenance_page' ) ) {
	function woodmart_maintenance_page() {

		$pages_ids = woodmart_pages_ids_from_template( 'maintenance' );

		if( ! empty( $pages_ids ) && is_page( $pages_ids ) ) {
			return true;
		}

		return false;
	}
}


// **********************************************************************//
// ! Get page id by template name
// **********************************************************************//

if( ! function_exists( 'woodmart_pages_ids_from_template' ) ) {
	function woodmart_pages_ids_from_template( $name ) {
		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => $name . '.php'
		));

		$return = array();

		foreach($pages as $page){
			$return[] = $page->ID;
		}

		return $return;
	}
}




// **********************************************************************//
// ! Get config file
// **********************************************************************//

if( ! function_exists( 'woodmart_get_config' ) ) {
	function woodmart_get_config( $name ) {
		$path = WOODMART_CONFIGS . '/' . $name . '.php';
		if( file_exists( $path ) ) {
			return include $path;
		} else {
			return array();
		}
	}
}


// **********************************************************************//
// ! Text to one-line string
// **********************************************************************//

if( ! function_exists( 'woodmart_text2line')) {
	function woodmart_text2line( $str ) {
		return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
	}
}


// **********************************************************************//
// ! Get page ID by it's template name
// **********************************************************************//
if( ! function_exists( 'woodmart_tpl2id' ) ) {
	function woodmart_tpl2id( $tpl = '' ) {
		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => $tpl
		));
		foreach($pages as $page){
			return $page->ID;
		}
	}
}

// **********************************************************************//
// ! Get content of the SVG icon located in images/svg folder
// **********************************************************************//
if( ! function_exists( 'woodmart_get_svg_content' ) ) {
	function woodmart_get_svg_content($name) {
		$folder = WOODMART_THEMEROOT . '/images/svg';
		$file = $folder . '/' . $name . '.svg';

		return (file_exists( $file )) ? woodmart_get_any_svg( $file ) : false;
	}
}

if( ! function_exists( 'woodmart_get_any_svg' ) ) {
	function woodmart_get_any_svg( $file, $id = false ) {
		$content = woodmart_get_svg( $file );
		$start_tag = '<svg';
		if( $id ) {
			$pattern = "/id=\"(\w)+\"/";
			if( preg_match($pattern, $content) ) {
				$content = preg_replace($pattern, "id=\"" . $id . "\"", $content);
			} else {
				$content = preg_replace( "/<svg/", "<svg id=\"" . $id . "\"", $content);
			}
		}
		// Strip doctype
		$position = strpos($content, $start_tag);
		$content = substr($content, $position);
		return $content;
	}
}

// **********************************************************************//
// ! Function print array within a pre tags
// **********************************************************************//
if( ! function_exists( 'ar' ) ) {
	function ar($array) {

		echo '<pre>';
			print_r($array);
		echo '</pre>';

	}
}


// **********************************************************************//
// ! Get protocol (http or https)
// **********************************************************************//
if( ! function_exists( 'woodmart_http' )) {
	function woodmart_http() {
		if( ! is_ssl() ) {
			return 'http';
		} else {
			return 'https';
		}
	}
}

// **********************************************************************//
// ! It could be useful if you using nginx instead of apache
// **********************************************************************//

if (!function_exists('getallheaders')) {
	function getallheaders() {
		$headers = array();
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) == 'HTTP_') {
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
    }
}


// **********************************************************************//
//  Function return vc_row with gradient.
// **********************************************************************//
if( ! function_exists( 'woodmart_get_gradient_attr' ) ) {
	function woodmart_get_gradient_attr( $output, $obj, $attr ) {
		if ( ! empty( $attr['woodmart_gradient_switch'] ) ) {
			$gradient_css = woodmart_get_gradient_css( $attr['woodmart_color_gradient'] );
			$output = preg_replace_callback('/woodmart-row-gradient-enable.*?>/',
				function ( $matches ) use( $gradient_css ) {
				   return strtolower( $matches[0] . '<div class="woodmart-row-gradient" style="' . $gradient_css . '"></div>' );
				}, $output );
		}
		return $output;
	}
}

add_filter( 'vc_shortcode_output', 'woodmart_get_gradient_attr', 10, 3 );

// **********************************************************************//
//  Function return all images sizes
// **********************************************************************//
function woodmart_get_all_image_sizes() {
    global $_wp_additional_image_sizes;

    $default_image_sizes = array( 'thumbnail', 'medium', 'large', 'full' );

    foreach ( $default_image_sizes as $size ) {
        $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
        $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
        $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
    }

    if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
        $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
    }

    return $image_sizes;
}

if( ! function_exists( 'woodmart_get_image_size' ) ) {
	function woodmart_get_image_size( $thumb_size ) {
		if ( is_string( $thumb_size ) && in_array( $thumb_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) ) ) {
			$images_sizes = woodmart_get_all_image_sizes();
			$image_size = $images_sizes[$thumb_size];
			if ( $thumb_size == 'full') {
				$image_size['width'] = 999999;
				$image_size['height'] = 999999;
			}
			return array( $image_size['width'], $image_size['height'] );
		}elseif ( is_string( $thumb_size ) ) {
			preg_match_all( '/\d+/', $thumb_size, $thumb_matches );
			if ( isset( $thumb_matches[0] ) ) {
				$thumb_size = array();
				if ( count( $thumb_matches[0] ) > 1 ) {
					$thumb_size[] = $thumb_matches[0][0]; // width
					$thumb_size[] = $thumb_matches[0][1]; // height
				} elseif ( count( $thumb_matches[0] ) > 0 && count( $thumb_matches[0] ) < 2 ) {
					$thumb_size[] = $thumb_matches[0][0]; // width
					$thumb_size[] = $thumb_matches[0][0]; // height
				} else {
					$thumb_size = false;
				}
			}
		}

		return $thumb_size;
	}
}

if( ! function_exists( 'woodmart_get_image_src' ) ) {
	function woodmart_get_image_src( $thumb_id, $thumb_size ) {
		$thumb_size = woodmart_get_image_size( $thumb_size );
		$thumbnail = wpb_resize( $thumb_id, null, $thumb_size[0], $thumb_size[1], true );
		return $thumbnail['url'];
	}
}

// **********************************************************************//
//  Function return gradient css.
// **********************************************************************//
if( ! function_exists( 'woodmart_get_gradient_css' ) ) {
	function woodmart_get_gradient_css( $gradient_attr ) {
		$gradient_css = explode( '|', $gradient_attr );
		$result =  'background-image:-webkit-' . $gradient_css[1] . ';';
		$result .= 'background-image:-moz-' . $gradient_css[1] . ';';
		$result .= 'background-image:-o-' . $gradient_css[1] . ';';
		$result .= 'background-image:'.$gradient_css[1] . ';';
		$result .= 'background-image:-ms-' . $gradient_css[1] . ';';
		return $result;
	}
}
// **********************************************************************//
// ! Append :hover to CSS selectors array
// **********************************************************************//
if( ! function_exists( 'woodmart_append_hover_state' ) ) {
	function woodmart_append_hover_state( $selectors , $focus = false ) {
		$selectors = explode(',', $selectors[0]);

		$return = array();

		foreach ($selectors as $selector) {
			$return[] = $selector . ':hover';
			( $focus ) ? $return[] .= $selector . ':focus' : false ;
		}

		return implode(',', $return);
	}
}

// **********************************************************************//
// Woodmart get theme info
// **********************************************************************//
if( ! function_exists( 'woodmart_get_theme_info' ) ) {
	function woodmart_get_theme_info( $parameter ) {
		$theme_info = wp_get_theme();
		if ( is_child_theme() ){
			$theme_info = wp_get_theme( $theme_info->parent()->template );
		}
		return $theme_info->get( $parameter );
	}
}

// **********************************************************************//
// Woodmart twitter process links
// **********************************************************************//
if( ! function_exists( 'woodmart_twitter_process_links' ) ) {
	function woodmart_twitter_process_links( $tweet ) {

		// Is the Tweet a ReTweet - then grab the full text of the original Tweet
		if( isset( $tweet->retweeted_status ) ) {
			// Split it so indices count correctly for @mentions etc.
			$rt_section = current( explode( ":", $tweet->text ) );
			$text = $rt_section.": ";
			// Get Text
			$text .= $tweet->retweeted_status->text;
		} else {
			// Not a retweet - get Tweet
			$text = $tweet->text;
		}

		// NEW Link Creation from clickable items in the text
		$text = preg_replace( '/((http)+(s)?:\/\/[^<>\s]+)/i', '<a href="$0" target="_blank" rel="nofollow">$0</a>', $text );
		// Clickable Twitter names
		$text = preg_replace( '/[@]+([A-Za-z0-9-_]+)/', '<a href="http://twitter.com/$1" target="_blank" rel="nofollow">@$1</a>', $text );
		// Clickable Twitter hash tags
		$text = preg_replace( '/[#]+([A-Za-z0-9-_]+)/', '<a href="http://twitter.com/search?q=%23$1" target="_blank" rel="nofollow">$0</a>', $text );
		// END TWEET CONTENT REGEX
		return $text;

	}
}

// **********************************************************************//
// Woodmart Owl Items Per Slide
// **********************************************************************//
if( ! function_exists( 'woodmart_owl_items_per_slide' ) ) {
	function woodmart_owl_items_per_slide( $slides_per_view, $hide = array(), $post_type = false, $location = false ) {
		$items = woodmart_get_owl_items_numbers( $slides_per_view, $post_type );
		$classes = '';

		if ( woodmart_get_opt( 'thums_position' ) == 'centered' && $location == 'main-gallery' ) {
			$items['desktop'] = $items['desktop_small'] = $items['tablet'] = $items['mobile'] = 2;
		}
		
		if ( ! in_array( 'xl', $hide ) ) $classes .= 'owl-items-xl-' . $items['desktop'];
		if ( ! in_array( 'lg', $hide ) ) $classes .= ' owl-items-lg-' . $items['desktop_small'];
		$classes .= ' owl-items-md-' . $items['tablet'];
		$classes .= ' owl-items-sm-' . $items['mobile'];

		return $classes;
	}
}
// **********************************************************************//
// Woodmart Get Owl Items Numbers
// **********************************************************************//
if( ! function_exists( 'woodmart_get_owl_items_numbers' ) ) {
	function woodmart_get_owl_items_numbers( $slides_per_view, $post_type = false ) {
		$items = array();
		$items['desktop'] = ( $slides_per_view > 0 ) ? $slides_per_view : 1;
		$items['desktop_small'] = ( $items['desktop'] > 1 ) ? $items['desktop'] - 1 : 1;
		if ( $items['desktop'] == 6 ) $items['desktop_small'] = 4;
		$items['tablet'] = ( $items['desktop_small'] > 1 ) ? $items['desktop_small'] : 1;
		$items['mobile'] = ( $items['tablet'] > 2 ) ? $items['tablet'] - 2 : 1;

		if ( $items['mobile'] > 2 ) {
			$items['mobile'] = 2;
		}

		if ( $post_type == 'product' ) {
			$items['mobile'] = woodmart_get_opt( 'products_columns_mobile' );
		}

		return $items;
	}
}


// **********************************************************************//
// Woodmart Get Settings JS
// **********************************************************************//
if ( ! function_exists('woodmart_settings_js') ) {
	function woodmart_settings_js() {

        $custom_js          = woodmart_get_opt( 'custom_js' );
        $js_ready           = woodmart_get_opt( 'js_ready' );

		ob_start();

        if( ! empty( $custom_js ) || ! empty( $js_ready ) ): ?>
            <?php if( ! empty( $custom_js ) ): ?>
                <?php echo ($custom_js); ?>
            <?php endif; ?>
            <?php if( ! empty( $js_ready ) ): ?>
                jQuery(document).ready(function() {
                    <?php echo ($js_ready); ?>
                });
            <?php endif; ?>
        <?php endif;

        return ob_get_clean();
	}
}

// **********************************************************************//
// Woodmart header theme settings CSS
// **********************************************************************//
if ( ! function_exists('woodmart_header_settings_css') ) {
	function woodmart_header_settings_css() {
		$logo_img_width        = woodmart_get_opt( 'logo_img_width' );
		$logo_img_width_tablet = woodmart_get_opt( 'logo_img_width_tablet' );
		$logo_img_width_mobile = woodmart_get_opt( 'logo_img_width_mobile' );
		$logo_padding        = woodmart_get_opt( 'logo_padding' );
		$logo_padding_tablet = woodmart_get_opt( 'logo_padding_tablet' );
		$logo_padding_mobile = woodmart_get_opt( 'logo_padding_mobile' );

		$logo_responsive = woodmart_get_opt( 'logo_responsive_sizes' );

		$header = woodmart_get_opt( 'header' );
		$header_height = woodmart_get_opt( 'header_height' );
		$sticky_header_height = woodmart_get_opt( 'sticky_header_height' );
		$mobile_header_height = woodmart_get_opt( 'mobile_header_height' );
		
		//Topbar
		$topbar_height = woodmart_get_opt( 'top_bar_height' );
		$topbar_height_mobile = woodmart_get_opt( 'top_bar_mobile_height' );
		
		$widgets_scroll = woodmart_get_opt( 'widgets_scroll' );
		$widgets_height = woodmart_get_opt( 'widget_heights' );

		$primary_color      = woodmart_get_opt( 'primary-color' );

		$custom_css 		= woodmart_get_opt( 'custom_css' );
		$css_desktop 		= woodmart_get_opt( 'css_desktop' );
		$css_tablet 		= woodmart_get_opt( 'css_tablet' );
		$css_wide_mobile 	= woodmart_get_opt( 'css_wide_mobile' );
		$css_mobile         = woodmart_get_opt( 'css_mobile' );
		$custom_js          = woodmart_get_opt( 'custom_js' );
		$js_ready 		    = woodmart_get_opt( 'js_ready' );

		$custom_product_background = get_post_meta( get_the_ID(),  '_woodmart_product-background', true );
		
		ob_start();
		?>
		
		/* TOP BAR HEIGHT */

		.topbar-menu .item-level-0 > a,
		.topbar-menu .woodmart-wishlist-info-widget > a,
		.topbar-text > .wcml-dropdown a.wcml-cs-item-toggle, 
		.topbar-text > .wcml-dropdown-click a.wcml-cs-item-toggle {
			line-height: <?php echo esc_html( $topbar_height ); ?>px;
		}
		
		.topbar-menu .item-level-0 > a,
		.topbar-menu .woodmart-wishlist-info-widget > a,
		.topbar-content,
		.topbar-wrapp,
		.topbar-text > .wcml-dropdown a.wcml-cs-item-toggle, 
		.topbar-text > .wcml-dropdown-click a.wcml-cs-item-toggle {
			height: <?php echo esc_html( $topbar_height ); ?>px;
		}	

		/* HEADER HEIGHT */

        .wrapp-header {
            min-height: <?php echo esc_html( $header_height ); ?>px;
        }

        /* HEADER HEIGHT IN IE */

        .browser-Internet .wrapp-header {
        	height: <?php echo esc_html( $header_height ); ?>px;
        }

        /* STICKY HEADER HEIGHT */

        .act-scroll .wrapp-header,
        .sticky-header .wrapp-header {
            min-height: <?php echo esc_html( $sticky_header_height ); ?>px;
        }

        /* STICKY HEADER HEIGHT IN IE */

        .browser-Internet .act-scroll .wrapp-header,
        .browser-Internet .sticky-header .wrapp-header {
			height: <?php echo esc_html( $sticky_header_height ); ?>px;
        }

		/* DROPDOWNS UNDER HEADER */

        .header-menu-top .navigation-wrap div.main-nav .sub-menu-dropdown,
        .header-menu-top .woodmart-search-dropdown,
        .header-menu-top .dropdown-cart,
        .header-menu-top .sub-menu-dropdown {
            margin-top: <?php echo esc_html( ($header_height / 2) - 20); ?>px;
        }

        .header-menu-top .navigation-wrap div.main-nav .sub-menu-dropdown:after,
        .header-menu-top .woodmart-search-dropdown:after,
        .header-menu-top .dropdown-cart:after,
        .header-menu-top .sub-menu-dropdown:after  {
            height: <?php echo esc_html( ($header_height / 2) - 20); ?>px;
        }
		
		.act-scroll.header-menu-top .navigation-wrap div.main-nav .sub-menu-dropdown,
        .act-scroll .sub-menu-dropdown,
        .act-scroll .woodmart-search-dropdown,
        .act-scroll .dropdown-cart {
            margin-top: <?php echo esc_html( ($sticky_header_height / 2) - 20); ?>px;
        }
		
		.act-scroll.header-menu-top .navigation-wrap div.main-nav .sub-menu-dropdown:after,
        .act-scroll .sub-menu-dropdown:after,
        .act-scroll .woodmart-search-dropdown:after,
        .act-scroll .dropdown-cart:after {
            height: <?php echo esc_html( ($sticky_header_height / 2) - 20); ?>px;
        }

        /* WOODMART LOGO */

        .woodmart-logo img {
            max-width: <?php echo esc_html( $logo_img_width ); ?>px;
        }

        .main-header .woodmart-logo img {
            max-height: <?php echo esc_html( $header_height ); ?>px;
            padding-top: <?php echo esc_html( $logo_padding['padding-top'] ); ?>;
            padding-right: <?php echo esc_html( $logo_padding['padding-right'] ); ?>;
            padding-bottom: <?php echo esc_html( $logo_padding['padding-bottom'] ); ?>;
            padding-left: <?php echo esc_html( $logo_padding['padding-left'] ); ?>;
        }

        <?php if( $header != 'menu-top' ): ?>

            /* And for sticky header logo also */
            .act-scroll .woodmart-logo img,
            .header-clone .woodmart-logo img {
                max-height: <?php echo esc_html( $sticky_header_height ); ?>px;
            }

        <?php endif; ?>

        <?php if ( $logo_responsive ) : ?>

            @media (min-width: 768px) and (max-width: 1024px) {

                .woodmart-logo img {
                    max-width: <?php echo esc_html( $logo_img_width_tablet ); ?>px;
                }

                .main-header .woodmart-logo img {
                    padding-top: <?php echo esc_html( $logo_padding_tablet['padding-top'] ); ?>;
                    padding-right: <?php echo esc_html( $logo_padding_tablet['padding-right'] ); ?>;
                    padding-bottom: <?php echo esc_html( $logo_padding_tablet['padding-bottom'] ); ?>;
                    padding-left: <?php echo esc_html( $logo_padding_tablet['padding-left'] ); ?>;
                }
            }

            @media (max-width: 767px) {

                .woodmart-logo img {
                    max-width: <?php echo esc_html( $logo_img_width_mobile ); ?>px;
                }

                .main-header .woodmart-logo img {
                    padding-top: <?php echo esc_html( $logo_padding_mobile['padding-top'] ); ?>;
                    padding-right: <?php echo esc_html( $logo_padding_mobile['padding-right'] ); ?>;
                    padding-bottom: <?php echo esc_html( $logo_padding_mobile['padding-bottom'] ); ?>;
                    padding-left: <?php echo esc_html( $logo_padding_mobile['padding-left'] ); ?>;
                }
            }

        <?php endif; ?>


        /* PAGE HEADINGS SETTINGS FOR HEADING OVERLAP. CALCULATE ON THE HEADER HEIGHT BASE */

        .woodmart-header-overlap .title-size-default,
        .woodmart-header-overlap .title-size-small,
        .woodmart-header-overlap .title-shop.without-title.title-size-default,
        .woodmart-header-overlap .title-shop.without-title.title-size-small {
            padding-top: <?php echo ($header_height + 40);  ?>px;
        }

        .woodmart-header-overlap .title-shop.without-title.title-size-large,
        .woodmart-header-overlap .title-size-large {
            padding-top: <?php echo ($header_height + 120);  ?>px;
        }


		/* ONLY DESKTOP */

		@media (min-width: 1024px) {

			/* HEADER OVERLAP WITH TOP BAR */

			.woodmart-top-bar-on .header-overlap,
			.woodmart-top-bar-on .header-sticky-real {
				top:<?php echo esc_html( $topbar_height ); ?>px;
			}
		}

		/* TABLET */

        @media (max-width: 1024px) {

        	/* TOP BAR HEIGHT */

			.topbar-content,
			.topbar-wrapp {
				max-height: <?php echo esc_html( $topbar_height_mobile ); ?>px;
				height:auto;
			}

			.topbar-right-text,
			.topbar-text > .wcml-dropdown a.wcml-cs-item-toggle, 
			.topbar-text > .wcml-dropdown-click a.wcml-cs-item-toggle {
				height: <?php echo esc_html( $topbar_height_mobile ); ?>px;
			}

			.topbar-text > .wcml-dropdown a.wcml-cs-item-toggle, 
			.topbar-text > .wcml-dropdown-click a.wcml-cs-item-toggle {
				line-height: <?php echo esc_html( $topbar_height_mobile ); ?>px;
			}			

			.woodmart-top-bar-mobile-on .header-overlap,
			.woodmart-top-bar-mobile-on .header-sticky-real {
				top:<?php echo esc_html( $topbar_height_mobile ); ?>px;
			}

            /* HEADER HEIGHT ON TABLET */
            
            .wrapp-header,
            .act-scroll .wrapp-header,
            .sticky-header .wrapp-header {
                min-height: <?php echo esc_html( $mobile_header_height ); ?>px;
            }

	        /* HEADER HEIGHT ON IE */

	        .browser-Internet .wrapp-header,
	       	.browser-Internet .act-scroll .wrapp-header,
	        .browser-Internet .sticky-header .wrapp-header {
	        	height: <?php echo esc_html( $mobile_header_height ); ?>px;
	        }

            /* LOGO MAX HEIGHT */

            .main-header .woodmart-logo img {
                max-height: <?php echo esc_html( $mobile_header_height ); ?>px;
            }

            .act-scroll .woodmart-logo img,
            .header-clone .woodmart-logo img {
                max-height: <?php echo esc_html( $mobile_header_height ); ?>px;
            }

            /* PAGE HEADINGS SETTINGS FOR HEADING OVERLAP. CALCULATE ON THE MOBILE HEADER HEIGHT BASE */

            .woodmart-header-overlap .title-size-default,
            .woodmart-header-overlap .title-size-small,
            .woodmart-header-overlap .title-shop.without-title.title-size-default,
            .woodmart-header-overlap .title-shop.without-title.title-size-small {
                padding-top: <?php echo ($mobile_header_height + 20);  ?>px;
            }

            .woodmart-header-overlap .title-shop.without-title.title-size-large,
            .woodmart-header-overlap .title-size-large {
                padding-top: <?php echo ($mobile_header_height + 60);  ?>px;
            }

         }

        <?php

        return ob_get_clean();
	}
}

// **********************************************************************//
// Woodmart Get Settings CSS
// **********************************************************************//
if ( ! function_exists('woodmart_settings_css') ) {
	function woodmart_settings_css() {

		$widgets_scroll = woodmart_get_opt( 'widgets_scroll' );
		$widgets_height = woodmart_get_opt( 'widget_heights' );

		$custom_css 		= woodmart_get_opt( 'custom_css' );
		$css_desktop 		= woodmart_get_opt( 'css_desktop' );
		$css_tablet 		= woodmart_get_opt( 'css_tablet' );
		$css_wide_mobile 	= woodmart_get_opt( 'css_wide_mobile' );
		$css_mobile         = woodmart_get_opt( 'css_mobile' );

		//Quickview
		$quickview_width = woodmart_get_opt( 'quickview_width' );
		
		//Shop popup
		$shop_popup_width = woodmart_get_opt( 'popup_width' );
		
		//Header banner
		$header_banner_height = woodmart_get_opt( 'header_banner_height' );
		$header_banner_height_mobile = woodmart_get_opt( 'header_banner_mobile_height' );

		$custom_product_background = get_post_meta( get_the_ID(),  '_woodmart_product-background', true );

		ob_start();

		if( ! whb_is_enabled() ) echo woodmart_header_settings_css();

		?>
		/* Quickview */
		.popup-quick-view {
		   max-width: <?php echo esc_html( $quickview_width ); ?>px;
		}

		/* Shop popup */
		.woodmart-promo-popup {
		   max-width: <?php echo esc_html( $shop_popup_width ); ?>px;
		}

		/* header Banner */
		.header-banner {
			height: <?php echo esc_html( $header_banner_height ); ?>px;
		}

		.header-banner-display .website-wrapper {
			margin-top:<?php echo esc_html( $header_banner_height ); ?>px;
		}	

		/* Tablet */
        @media (max-width: 1024px) {

			/* header Banner */

			.header-banner {
				height: <?php echo esc_html( $header_banner_height_mobile ); ?>px;
			}

			.header-banner-display .website-wrapper {
				margin-top:<?php echo esc_html( $header_banner_height_mobile ); ?>px;
			}

		}

        <?php if( $widgets_scroll ): ?>
            .woodmart-woocommerce-layered-nav .woodmart-scroll-content {
                max-height: <?php echo ($widgets_height); ?>px;
            }
        <?php endif; ?>

		<?php if ( !empty( $custom_product_background ) ): ?>
		.single-product .main-page-wrapper{
			background-color: <?php echo esc_html( $custom_product_background ); ?> !important;
		}
		<?php endif ?>

        <?php
        if( $custom_css != '' ) {
            echo ($custom_css);
        }
        if( $css_desktop != '' ) {
            echo '@media (min-width: 1024px) { ' . ($css_desktop) . ' }';
        }
        if( $css_tablet != '' ) {
            echo '@media (min-width: 768px) and (max-width: 1023px) {' . ($css_tablet) . ' }';
        }
        if( $css_wide_mobile != '' ) {
            echo '@media (min-width: 481px) and (max-width: 767px) { ' . ($css_wide_mobile) . ' }';
        }
        if( $css_mobile != '' ) {
            echo '@media (max-width: 480px) { ' . ($css_mobile) . ' }';
        }

        return ob_get_clean();
	}
}
// **********************************************************************//
// Header classes
// **********************************************************************//
if ( ! function_exists( 'woodmart_get_header_classes' ) ) {
	function woodmart_get_header_classes( $header ){
		$sticky_class = '';

		if( whb_is_enabled() ) {
			$settings = whb_get_settings();

			$header_class = 'whb-header';
			$header_class .= ( $settings['overlap'] ) ? ' whb-overcontent' : '';
			$header_class .= ( $settings['full_width'] ) ? ' whb-full-width' : '';
			$header_class .= ( $settings['sticky_shadow'] ) ? ' whb-sticky-shadow' : '';
			$header_class .= ( $settings['sticky_effect'] ) ? ' whb-scroll-' . $settings['sticky_effect'] : '';
			$header_class .= ( $settings['sticky_clone'] && $settings['sticky_effect'] == 'slide' ) ? ' whb-sticky-clone' : ' whb-sticky-real';

		} else {
			$header_class = 'main-header';
			$header_bg = woodmart_get_opt( 'header_background' );
			$header_overlap_opt = woodmart_get_opt( 'header-overlap' );
			$header_has_bg = ( ! empty( $header_bg['background-color'] ) || ! empty( $header_bg['background-image'] ) );
			$header_overlap = false;

			// If header type is SHOP and overlap option is enabled
			if( ( $header == 'shop' || $header == 'split' || $header == 'simple' ) && $header_overlap_opt ) {
				$header_overlap = true;
			}

			$header_class .= ( $header_has_bg ) ? ' header-has-bg' : ' header-has-no-bg';
			$header_class .= ( $header_overlap ) ? ' header-overlap' : '';
			$header_class .= ' header-' . $header;
			$header_class .= ' icons-design-' . woodmart_get_opt( 'icons_design' );
			$header_class .= ' header-color-' . woodmart_get_opt( 'header_color_scheme' );
			$header_class .= ( woodmart_get_opt( 'full_screen_menu' ) ) ? ' full-screen-menu' : '';

			$mobile_class  = 'header-mobile-' . woodmart_get_opt( 'header_mobile' );
			$header_class .= ' ' . $mobile_class;
			
			$sticky_class .= $mobile_class . ' header-color-' . woodmart_get_opt( 'header_color_scheme' );
		}


		echo 'class="' . esc_attr( $header_class ) . '" data-sticky-class="' . esc_attr( $sticky_class ) . '"';
	}
}

// **********************************************************************//
// Is share button enable
// **********************************************************************//
if ( ! function_exists( 'woodmart_is_social_link_enable' ) ) {
	function woodmart_is_social_link_enable( $type ) {
		$result = false;
		if ( $type == 'share' && ( woodmart_get_opt('share_fb') || woodmart_get_opt('share_twitter') || woodmart_get_opt('share_google') || woodmart_get_opt('share_pinterest') || woodmart_get_opt('share_ok') || woodmart_get_opt('share_whatsapp') || woodmart_get_opt('social_email') || woodmart_get_opt('share_vk') || woodmart_get_opt('share_tg') ) ) {
			$result = true;
		}
		if  ( $type == 'follow' && ( woodmart_get_opt('fb_link') || woodmart_get_opt('twitter_link') || woodmart_get_opt('google_link') || woodmart_get_opt('isntagram_link') || woodmart_get_opt('pinterest_link') || woodmart_get_opt('youtube_link') || woodmart_get_opt('tumblr_link') || woodmart_get_opt('linkedin_link') || woodmart_get_opt('vimeo_link') || woodmart_get_opt('flickr_link') || woodmart_get_opt('github_link') || woodmart_get_opt('dribbble_link') || woodmart_get_opt('behance_link') || woodmart_get_opt('soundcloud_link') || woodmart_get_opt('spotify_link') || woodmart_get_opt('ok_link') || woodmart_get_opt('whatsapp_link') || woodmart_get_opt('vk_link') || woodmart_get_opt('snapchat_link') || woodmart_get_opt('tg_link') ) ) {
			$result = true;
		}
		return $result;
	}
}

// **********************************************************************//
// Print script tag with content
// **********************************************************************//
if ( ! function_exists( 'woodmart_add_inline_script' ) ) {
	function woodmart_add_inline_script( $key, $content, $position = 'after' ) {

		$out = '';
		$tag = 'script';
		$attributes = 'type="text/javascript"';

		$out .= '<' . $tag . ' ' . $attributes . '>';
		$out .= $content;
		$out .= '</' . $tag . '>';


		echo $out;
	}
}

// **********************************************************************//
// Print text size css
// **********************************************************************//
if ( ! function_exists( 'woodmart_responsive_text_size_css' ) ) {
	function woodmart_responsive_text_size_css( $id, $class, $data ) {
		echo '#'. $id . ' .'. $class .'{font-size:' . $data . 'px;line-height:' . intval( $data + 10 ) . 'px;}';
	}
}

// **********************************************************************// 
// Is compare iframe
// **********************************************************************// 
if ( ! function_exists( 'woodmart_is_compare_iframe' ) ) {
	function woodmart_is_compare_iframe() {
		return wp_script_is( 'jquery-fixedheadertable', 'enqueued' );
	}
}

// **********************************************************************// 
// Is SVG image
// **********************************************************************// 
if ( ! function_exists( 'woodmart_is_svg' ) ) {
	function woodmart_is_svg( $src ) {
		return substr( $src, -3, 3 ) == 'svg';
	}
}

// **********************************************************************// 
// Get explode size
// **********************************************************************// 
if ( ! function_exists( 'woodmart_get_explode_size' ) ) {
	function woodmart_get_explode_size( $img_size, $default_size ) {
		$sizes = explode( 'x', $img_size );
		if( count( $sizes ) < 2 ) $sizes[0] = $sizes[1] = $default_size;
		return $sizes;
	}
}

// **********************************************************************// 
// Display icon
// **********************************************************************// 
if ( ! function_exists( 'woodmart_display_icon' ) ) {
	function woodmart_display_icon( $img_id, $img_size, $default_size ) {
		$icon = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size ) );
		$icon_src = $icon['p_img_large'][0];
		$icon_id = rand( 999, 9999 );
		
		$sizes = woodmart_get_explode_size( $img_size, $default_size );
		
		if( woodmart_is_svg( $icon_src ) ) {
			return '<span class="svg-icon img-wrapper" style="width: ' . $sizes[0] . 'px;height: ' . $sizes[1] . 'px;">' . woodmart_get_any_svg( $icon_src, $icon_id ) . '</span>';
		} else {
			return '<span class="img-wrapper">' . wp_kses( $icon['thumbnail'], array( 'img' => array( 'width' => true, 'height' => true, 'src' => true, 'alt' => true, 'data-src' => true, 'data-srcset' => true, 'class' => true ) ) ) . '</span>';
		}
	}
}


// **********************************************************************// 
// Check is theme is activated with a purchase code
// **********************************************************************// 

if ( ! function_exists( 'woodmart_is_license_activated' ) ) {
	function woodmart_is_license_activated() {
	    return get_option( 'woodmart_is_activated', false );
	}
}

// **********************************************************************// 
// Enqueue scripts
// **********************************************************************// 

if ( ! function_exists( 'woodmart_enqueue_script' ) ) {
	function woodmart_enqueue_script( $script_name ) {
	    if ( woodmart_get_opt( 'combined_js' ) ) return;
		wp_enqueue_script( $script_name );
	}
}


/*==============================================
=            Lazy loading functions            =
==============================================*/


// **********************************************************************// 
// Init lazy loading
// **********************************************************************// 
if( ! function_exists( 'woodmart_lazy_loading_init' ) ) {
	function woodmart_lazy_loading_init() {
		if( ! woodmart_get_opt( 'lazy_loading' ) || is_admin() ) return;

		// Used for product categories images for example.
		add_filter('woodmart_attachment', 'woodmart_lazy_attachment_replace', 10, 3);

		// Used for instagram images.
		add_filter('woodmart_image', 'woodmart_lazy_image_standard', 10, 1);

		// Images generated by WPBakery functions
		add_filter('vc_wpb_getimagesize', 'woodmart_lazy_image', 10, 3);

		// Products, blog, a lot of other standard wordpress images
		add_filter('wp_get_attachment_image_attributes', 'woodmart_lazy_attributes', 10, 3);

	}

	add_action( 'init', 'woodmart_lazy_loading_init', 120 );
}


// **********************************************************************// 
// Filters HTML <img> tag and adds lazy loading attributes. Used for product categories images for example.
// **********************************************************************// 
if( ! function_exists( 'woodmart_lazy_attachment_replace' ) ) {
	function woodmart_lazy_attachment_replace( $imgHTML, $attach_id, $size ) {

		if ( preg_match( "/src=['\"]data:image/is", $imgHTML ) ) return $img;


		if( $attach_id ) {
			$lazy_image = woodmart_get_attachment_placeholder( $attach_id, $size );
		} else {
			$lazy_image = woodmart_lazy_get_default_preview();
		}


		return  woodmart_lazy_replace_image( $imgHTML, $lazy_image );
	}
}


// **********************************************************************// 
// Filters HTML <img> tag and adds lazy loading attributes. Used for instagram images.
// **********************************************************************// 
if( ! function_exists( 'woodmart_lazy_image_standard' ) ) {
	function woodmart_lazy_image_standard( $html ) {

		if ( preg_match( "/src=['\"]data:image/is", $html ) ) return $img;

		$lazy_image = woodmart_lazy_get_default_preview();

		return woodmart_lazy_replace_image( $html, $lazy_image );
	}

}


// **********************************************************************// 
// Get default preview image.
// **********************************************************************// 
if( ! function_exists( 'woodmart_lazy_get_default_preview' ) ) {
	function woodmart_lazy_get_default_preview() {
		return WOODMART_IMAGES . '/lazy.png';
	}
}


// **********************************************************************// 
// Filters WPBakery generated image. Needs an HTML, its ID, and params with image size.
// **********************************************************************// 
if( ! function_exists( 'woodmart_lazy_image' ) ) {
	function woodmart_lazy_image( $img, $attach_id, $params ) {

		$thumb_size = woodmart_get_image_size( $params['thumb_size'] );

		$imgHTML = $img['thumbnail'];

		if ( preg_match( "/src=['\"]data:image|woodmart-lazy-load/is", $imgHTML ) ) return $img;

		$lazy_image = woodmart_get_attachment_placeholder( $attach_id, $thumb_size );

		$img['thumbnail'] = woodmart_lazy_replace_image( $imgHTML, $lazy_image );

		return $img;
	}
}


// **********************************************************************// 
// Filters <img> tag passed as an argument.
// **********************************************************************// 
if( ! function_exists( 'woodmart_lazy_replace_image' ) ) {
	function woodmart_lazy_replace_image( $html, $src ) {

		$class = woodmart_lazy_css_class();

		$new = '';
		$new = preg_replace( '/<img(.*?)src=/is', '<img$1src="'.$src.'" data-src=', $html );
		$new = preg_replace( '/<img(.*?)srcset=/is', '<img$1srcset="" data-srcset=', $new );


		if ( preg_match( '/class=["\']/i', $new ) ) {
			$new = preg_replace( '/class=(["\'])(.*?)["\']/is', 'class=$1' . $class . ' $2$1', $new );
		} else {
			$new = preg_replace( '/<img/is', '<img class="' . $class . '"', $new );
		}

		return $new;
	}
}


// **********************************************************************// 
// Filters default WordPress images ATTRIBUTES array called by core API functions.
// **********************************************************************// 
if( ! function_exists( 'woodmart_lazy_attributes' ) ) {
	function woodmart_lazy_attributes($attr, $attachment, $size) {

		$attr['data-src'] = $attr['src'];
		if( isset( $attr['srcset'] ) ) $attr['data-srcset'] = $attr['srcset'];
		
		$attr['src'] = woodmart_get_attachment_placeholder( $attachment->ID, $size );
		$attr['srcset'] = '';

		$attr['class'] = $attr['class'] . ' ' . woodmart_lazy_css_class();


		return $attr;
	}
}


// **********************************************************************// 
// Get lazy loading image CSS class
// **********************************************************************// 
if( ! function_exists( 'woodmart_lazy_css_class' ) ) {
	function woodmart_lazy_css_class() {
		$class = 'woodmart-lazy-load';

		$class .= ' woodmart-lazy-' . woodmart_get_opt( 'lazy_effect' );

		return $class;
	}
}


// **********************************************************************// 
// Get placeholder image. Needs ID to genereate a blurred preview and size.
// **********************************************************************// 
if( ! function_exists( 'woodmart_get_attachment_placeholder' ) ) {
	function woodmart_get_attachment_placeholder( $id, $size ) {

		// Get size from array
		if( is_array( $size) ) {
			$width = $size[0];
			$height = $size[1];
		} else {
			// Take it from the original image
			$image = wp_get_attachment_image_src($id, $size);
			$width = $image[1];
			$height = $image[2];
		}

		$placeholder_size = woodmart_get_placeholder_size( $width, $height );

		$uploaded = woodmart_get_opt('lazy_custom_placeholder');

		$img = woodmart_lazy_get_default_preview();

		if( woodmart_get_opt( 'lazy_generate_previews' ) ) {
			$img = vc_get_image_by_size( $id, $placeholder_size );
		} else if( ! empty( $uploaded ) && is_array( $uploaded ) && ! empty( $uploaded['url'] ) && ! empty( $uploaded['id'] ) ) {
			$img = $uploaded['url'];
			if( woodmart_get_opt( 'lazy_proprtion_size' ) ) {
				$img = vc_get_image_by_size( $uploaded['id'], $width . 'x' . $height );
			}
		} else {
			return woodmart_lazy_get_default_preview();
		}

		if( woodmart_get_opt( 'lazy_base_64' ) ) $img = woodmart_encode_image($id, $img);

		return $img;
	}  
}


// **********************************************************************// 
// Encode small preview image to BASE 64
// **********************************************************************// 
if( ! function_exists( 'woodmart_encode_image' ) ) {
	function woodmart_encode_image( $id, $url ) {

		if( ! wp_attachment_is_image( $id ) || preg_match('/^data\:image/', $url ) ) return $url;

		$meta_key = '_base64_image.' . md5($url);
		
		$img_url = get_post_meta( $id, $meta_key, true );

		if( $img_url ) return $img_url;

		$image_path = preg_replace('/^.*?wp-content\/uploads\//i', '', $url);

		if( ( $uploads = wp_get_upload_dir() ) && ( false === $uploads['error'] ) && ( 0 !== strpos( $image_path, $uploads['basedir'] ) ) ) {
			if( false !== strpos( $image_path, 'wp-content/uploads' ) ) 
				$image_path = trailingslashit( $uploads['basedir'] . '/' . _wp_get_attachment_relative_path( $image_path ) ) . basename( $image_path );
			else 
				$image_path = $uploads['basedir'] . '/' . $image_path;
		}

		$max_size = 150 * 1024; // MB

		//echo '[['.$max_size.' vs '.filesize($image_path).']]';

		if( file_exists( $image_path ) && ( ! $max_size || ( filesize( $image_path ) <= $max_size ) ) ) {
			$filetype = wp_check_filetype( $image_path );

			// Read image path, convert to base64 encoding
			$imageData = base64_encode( file_get_contents( $image_path ) );

			// Format the image SRC:  data:{mime};base64,{data};
			$img_url = 'data:image/' . $filetype['ext'] . ';base64,' . $imageData;

			update_post_meta( $id, $meta_key, $img_url );

			return $img_url;
		}

		return $url;
	}
} 


// **********************************************************************// 
// Generate placeholder preview small size.
// **********************************************************************// 
if( ! function_exists( 'woodmart_get_placeholder_size' ) ) {
	function woodmart_get_placeholder_size( $x0, $y0 ) {

		$x = $y = 10;

		if( $x0 < $y0) {
			$y = ($x * $y0) / $x0;
		}

		if( $x0 > $y0) {
			$x = ($y * $x0) / $y0;
		}

		$x = ceil( $x );
		$y = ceil( $y );

		return (int) $x . 'x' . (int) $y;
	}
}

/*=====  End of Lazy loading functions  ======*/


// **********************************************************************//
// ! Function to get all pages
// **********************************************************************//

if( ! function_exists( 'woodmart_get_pages' ) ) {
	function woodmart_get_pages() {
		$pages = array( 'default' => esc_html__( 'Default', 'woodmart' ) );
		foreach( get_pages() as $page ){
			$pages[$page->ID] = $page->post_title;
		}  
		return $pages;
	}
}

// **********************************************************************//
// ! Function to set custom 404 page
// **********************************************************************//
if( ! function_exists( 'woodmart_custom_404_page' ) ) {
	function woodmart_custom_404_page( $template ) {
		global $wp_query;
		$custom_404 = woodmart_get_opt( 'custom_404_page' );
		if ( $custom_404 == 'default' || empty( $custom_404 )  ) return $template;

		$wp_query->query( 'page_id=' . $custom_404 );
		$wp_query->the_post();
		$template = get_page_template();
		rewind_posts();

		return $template;
	}
	add_filter( '404_template', 'woodmart_custom_404_page', 999 );
}

// **********************************************************************//
// Styles | Custom Font
// **********************************************************************//

if ( ! function_exists( 'woodmart_custom_font_css' ) ) {
	function woodmart_custom_font_css() {
		$custom_fonts = woodmart_get_opt( 'multi_custom_fonts' );
		if ( ! $custom_fonts ) return;

		echo '<style>'."\n";
			foreach ( $custom_fonts as $key => $value ) {

				$eot = woodmart_get_custom_font_url( $value['font-eot'] );
				$woff = woodmart_get_custom_font_url( $value['font-woff'] );
				$woff2 = woodmart_get_custom_font_url( $value['font-woff2'] );
				$ttf = woodmart_get_custom_font_url( $value['font-ttf'] );
				$svg = woodmart_get_custom_font_url( $value['font-svg'] );

				echo '@font-face {'."\n";
					echo 'font-family: "'. sanitize_text_field( $value['font-name'] ) .'";'."\n";
					if ( $eot ) {
						echo 'src: url("'. esc_url( $eot ) .'");'."\n";
						echo 'src: url("'. esc_url( $eot ).'#iefix") format("embedded-opentype"),'."\n";
					}

					if ( $woff ) {
						echo 'url("'. esc_url( $woff ) .'") format("woff"),'."\n";
					}

					if ( $woff2 ) {
						echo 'url("'. esc_url( $woff2 ) .'") format("woff2"),'."\n";
					}

					if ( $ttf ) {
						echo 'url("'. esc_url( $ttf ) .'") format("truetype"),'."\n";
					}

					if ( $svg ) {
						echo 'url("'. esc_url( $svg ) .'#'. sanitize_text_field( $value['font-name'] ) .'") format("svg");'."\n";
					}

					if ( $value['font-weight'] ) {
						echo 'font-weight: ' . sanitize_text_field( $value['font-weight'] ) . ';'."\n";
					} else {
						echo 'font-weight: normal;'."\n";
					}

					echo 'font-style: normal;'."\n";
				echo '}'."\n";
			}
		echo '</style>'."\n";
	}
	
	add_action( 'wp_head', 'woodmart_custom_font_css' );
}

if ( ! function_exists( 'woodmart_get_custom_font_url' ) ) {
	function woodmart_get_custom_font_url( $font ) {
		$url = $font;
		if ( isset( $font['id'] ) && $font['id'] ) {
			$url = wp_get_attachment_url( $font['id'] );
		} elseif ( is_array( $font ) ) {
			$url = $font['url'];
		}

		return $url;
	}
}

// **********************************************************************//
// Get typekit fonts
// **********************************************************************//
if ( ! function_exists( 'woodmart_add_custom_fonts' ) ) {
	function woodmart_add_custom_fonts() {
		global $woodmart_options;
		$fonts = array();
		$typekit_fonts = isset( $woodmart_options['typekit_fonts'] ) ? $woodmart_options['typekit_fonts'] : '';
		$custom_fonts = isset( $woodmart_options['multi_custom_fonts'] ) ? $woodmart_options['multi_custom_fonts'] : '';

		if ( $typekit_fonts ) {
			$typekit = explode( ',', $typekit_fonts );
			$fonts['Custom-Fonts'] = array_combine( $typekit, $typekit );
		}

		if ( $custom_fonts ) {
			foreach ( $custom_fonts as $key => $value ) {
				$fonts['Custom-Fonts'][$value['font-name']] = $value['font-name'];
			}
		}

		return $fonts;
		
	}
	add_filter( 'redux/woodmart_options/field/typography/custom_fonts', 'woodmart_add_custom_fonts' );
}

// **********************************************************************//
// Get css animation
// **********************************************************************//

if ( ! function_exists( 'woodmart_get_css_animation' ) ) {
	function woodmart_get_css_animation( $css_animation ) {
		$output = '';
		if ( $css_animation && $css_animation != 'none' ) {
			wp_enqueue_script( 'waypoints' );
			wp_enqueue_style( 'animate-css' );
			$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation . ' ' . $css_animation;
		}
		return $output;
	}
}

// **********************************************************************//
// Add custom animations to WPB Composer
// **********************************************************************//

if ( ! function_exists( 'woodmart_add_css_animation' ) ) {
	function woodmart_add_css_animation( $animations ) {
		$animations[] = array(
			'label' => esc_html__( 'Woodmart Animations', 'woodmart' ),
			'values' => array(
				esc_html__( 'Slide from top', 'woodmart' ) => array(
					'value' => 'wd-slide-from-top',
					'type' => 'in',
				),
				esc_html__( 'Slide from bottom', 'woodmart' ) => array(
					'value' => 'wd-slide-from-bottom',
					'type' => 'in',
				),
				esc_html__( 'Slide from left', 'woodmart' ) => array(
					'value' => 'wd-slide-from-left',
					'type' => 'in',
				),
				esc_html__( 'Slide from right', 'woodmart' ) => array(
					'value' => 'wd-slide-from-right',
					'type' => 'in',
				),
				esc_html__( 'Right flip Y', 'woodmart' ) => array(
					'value' => 'wd-right-flip-y',
					'type' => 'in',
				),
				esc_html__( 'Left flip Y', 'woodmart' ) => array(
					'value' => 'wd-left-flip-y',
					'type' => 'in',
				),
				esc_html__( 'Top flip X', 'woodmart' ) => array(
					'value' => 'wd-top-flip-x',
					'type' => 'in',
				),
				esc_html__( 'Bottom flip X', 'woodmart' ) => array(
					'value' => 'wd-bottom-flip-x',
					'type' => 'in',
				),
				esc_html__( 'Zoom in', 'woodmart' ) => array(
					'value' => 'wd-zoom-in',
					'type' => 'in',
				),
				esc_html__( 'Rotate Z', 'woodmart' ) => array(
					'value' => 'wd-rotate-z',
					'type' => 'in',
				),
			),
		);

		return $animations;
	}
	
	add_action( 'vc_param_animation_style_list', 'woodmart_add_css_animation', 1000 );
}

// **********************************************************************//
// TODO: Need remove after 1-2 updates
// **********************************************************************//

if ( ! function_exists( 'woodmart_new_custom_fonts' ) ) {
	function woodmart_new_custom_fonts() {
		global $woodmart_options; 
		$old_fonts = array();
		if ( isset( $woodmart_options['font_custom_name'] ) && $woodmart_options['font_custom_name'] ) {
			$old_fonts[0] = array(
				'font-name' => $woodmart_options['font_custom_name'],
				'font-weight' => isset( $woodmart_options['font_custom_weight'] ) ? $woodmart_options['font_custom_weight'] : '',
				'font-woff' => isset( $woodmart_options['font_custom_woff']['url'] ) ? $woodmart_options['font_custom_woff']['url'] : '',
				'font-woff2' => isset( $woodmart_options['font_custom_woff2']['url'] ) ? $woodmart_options['font_custom_woff2']['url'] : '',
				'font-ttf' => isset( $woodmart_options['font_custom_ttf']['url'] ) ? $woodmart_options['font_custom_ttf']['url'] : '',
				'font-svg' => isset( $woodmart_options['font_custom_svg']['url'] ) ? $woodmart_options['font_custom_svg']['url'] : '',
				'font-eot' => isset( $woodmart_options['font_custom_eot']['url'] ) ? $woodmart_options['font_custom_eot']['url'] : '',
			);
		}

		if ( isset( $woodmart_options['font_custom2_name'] ) && $woodmart_options['font_custom2_name'] ) {
			$old_fonts[1] = array(
				'font-name' => $woodmart_options['font_custom2_name'],
				'font-weight' => isset( $woodmart_options['font_custom2_weight'] ) ? $woodmart_options['font_custom2_weight'] : '',
				'font-woff' => isset( $woodmart_options['font_custom2_woff']['url'] ) ? $woodmart_options['font_custom2_woff']['url'] : '',
				'font-woff2' => isset( $woodmart_options['font_custom2_woff2']['url'] ) ? $woodmart_options['font_custom2_woff2']['url'] : '',
				'font-ttf' => isset( $woodmart_options['font_custom2_ttf']['url'] ) ? $woodmart_options['font_custom2_ttf']['url'] : '',
				'font-svg' => isset( $woodmart_options['font_custom2_svg']['url'] ) ? $woodmart_options['font_custom2_svg']['url'] : '',
				'font-eot' => isset( $woodmart_options['font_custom2_eot']['url'] ) ? $woodmart_options['font_custom2_eot']['url'] : '',
			);
		}

		if ( isset( $woodmart_options['font_custom3_name'] ) && $woodmart_options['font_custom3_name'] ) {
			$old_fonts[2] = array(
				'font-name' => $woodmart_options['font_custom3_name'],
				'font-weight' => isset( $woodmart_options['font_custom3_weight'] ) ? $woodmart_options['font_custom3_weight'] : '',
				'font-woff' => isset( $woodmart_options['font_custom3_woff']['url'] ) ? $woodmart_options['font_custom3_woff']['url'] : '',
				'font-woff2' => isset( $woodmart_options['font_custom3_woff2']['url'] ) ? $woodmart_options['font_custom3_woff2']['url'] : '',
				'font-ttf' => isset( $woodmart_options['font_custom3_ttf']['url'] ) ? $woodmart_options['font_custom3_ttf']['url'] : '',
				'font-svg' => isset( $woodmart_options['font_custom3_svg']['url'] ) ? $woodmart_options['font_custom3_svg']['url'] : '',
				'font-eot' => isset( $woodmart_options['font_custom3_eot']['url'] ) ? $woodmart_options['font_custom3_eot']['url'] : '',
			);
		}

		if ( ! $old_fonts ) return;

		Redux::setOption('woodmart_options','multi_custom_fonts', $old_fonts);
		Redux::setOption('woodmart_options','font_custom_name', '');
		Redux::setOption('woodmart_options','font_custom2_name', '');
		Redux::setOption('woodmart_options','font_custom3_name', '');
	}
	add_filter( 'init', 'woodmart_new_custom_fonts' );
}


// **********************************************************************//
// Get current breadcrumbs
// **********************************************************************//

if ( ! function_exists( 'woodmart_current_breadcrumbs' ) ) {
	function woodmart_current_breadcrumbs( $type ) {
		$function = ( $type == 'shop' ) ? 'woocommerce_breadcrumb' : 'woodmart_breadcrumbs';

		if ( woodmart_get_opt( 'yoast_' . $type . '_breadcrumbs' ) && function_exists( 'yoast_breadcrumb' ) ) {
			echo '<div class="yoast-breadcrumb">';
				echo yoast_breadcrumb();
			echo '</div>';
		} else {
			$function();
		}
	}
}