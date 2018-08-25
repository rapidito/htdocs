<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
 * Main Theme class that initialize all
 * other classes like assets, layouts, options
 *
 * Also includes files with theme functions
 * template tags, 3d party plugins etc.
 */
class WOODMART_Theme {
	/**
	 * Array to register redux fields
	 * @var array
	 */
	private $redux_fields = array();

	/**
	 * Classes array to register shortcodes
	 * @var array
	 */
	private $shortcodes = array();

	/**
	 * Classes array to register shortcodes in js_composer
	 * @var array
	 */
	private $vc_element = array();

	/**
	 * Classes array to register in WOODMART_Registery object
	 * @var array
	 */
	private $register_classes = array();

	/**
	 * Files array to include from inc/ folder
	 * @var array
	 */
	private $files_include = array();

	/**
	 * Array of files to include in admin area
	 * @var array
	 */
	private $admin_files_include = array();

	/**
	 * Call init methods
	 */
	public function __construct() {

		$this->shortcodes = array(
			'3d-view',
			'ajax-search',
			'author-area',
			'blog',
			'button',
			'countdown-timer',
			'counter',
			'extra-menu',
			'gallery',
			'google-map',
			'html-block',
			'images-gallery',
			'info-box',
			'instagram',
			'mega-menu',
			'menu-price',
			'popup',
			'portfolio',
			'posts-slider',
			'pricing-tables',
			'promo-banner',
			'responsive-text-block',
			'row-divider',
			'slider',
			'social',
			'team-member',
			'testimonials',
			'timeline',
			'title',
			'twitter',
			'user-panel',
			'list',
			'image-hotspot',
		);

		$this->woo_shortcodes = array(
			'categories',
			'products',
			'products-tabs',
			'brands',
			'products-widget',
			'product-filters',
		);

		$this->vc_elements = array(
			'3d-view',
			'ajax-search',
			'author-area',
			'blog',
			'button',
			'countdown-timer',
			'counter',
			'extra-menu',
			'google-map',
			'images-gallery',
			'info-box',
			'instagram',
			'mega-menu',
			'menu-price',
			'popup',
			'portfolio',
			'pricing-tables',
			'promo-banner',
			'responsive-text-block',
			'row-divider',
			'slider',
			'social',
			'team-member',
			'testimonials',
			'timeline',
			'title',
			'twitter',
			'video-poster',
			'parallax-scroll',
			'list',
			'image-hotspot',
		);

		$this->register_classes = array(
			'notices',
			'options',
			'metaboxes',
			'layout',
			'import',
			'swatches',
			'search',
			'catalog',
			'maintenance',
			'api',
			'license',
		);	

		$this->files_include = array(
			'functions',
			'theme-setup',
			'template-tags',
			'woocommerce',
			'woocommerce/attributes-meta-boxes',
			'woocommerce/product-360-view',
			'woocommerce/size-guide',
			'vc-config',
			'settings',
			'widgets',
			'configs/assets',
			'builder/Builder',
			'builder/Frontend',
			'builder/functions',
			'vc-fields/gradient',
			'vc-fields/image-select',
			'vc-fields/image-hotspot',
			'third-party/cmb2-conditionals/cmb2-conditionals',
			'third-party/cmb2-fields/images-select',
			'third-party/cmb2-fields/slider',
			'third-party/redux-fields/woodmart_gradient',
			'third-party/redux-fields/woodmart_multi_fonts',
			'third-party/redux-fields/woodmart_title',
		);	

		$this->admin_files_include = array(
			'builder/Builder',
			'builder/Backend',
			'admin/dashboard/dashboard',
			'admin/init',
			'admin/functions',
		);	


		$this->third_party_plugins = array(
			'plugin-activation/class-tgm-plugin-activation',
			'nav-menu-images/nav-menu-images',
			'wph-widget-class',
		);		

		$this->_third_party_plugins();
		$this->_core_plugin_classes();
		$this->_include_files();
		$this->_register_classes();

		$this->_include_vc_elements();
		$this->_include_shortcodes();

		if( is_admin() ) {
			$this->_include_admin_files();
		}

	}

	/**
	 * Register classes in WOODMART_Registry
	 * 
	 */
	private function _register_classes() {

		foreach ($this->register_classes as $class) {
			WOODMART_Registry::getInstance()->$class;
		}

	}

	/**
	 * Include files from inc/ folder
	 * 
	 */
	private function _include_files() {

		foreach ($this->files_include as $file) {
			$path = get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php');
			if( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	/**
	 * Include files from inc/ vc-element
	 * 
	 */
	private function _include_vc_elements() {
		$vc_elements = $this->vc_elements;

		if ( woodmart_woocommerce_installed() ) {
			$vc_elements = array_merge( $this->vc_elements, $this->woo_shortcodes );
		}
		foreach ( $vc_elements as $file ) {
			$path = get_template_directory() . '/inc/vc-element/' . $file . '.php';
			if( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	/**
	 * Include files from inc/ shortcodes
	 * 
	 */
	private function _include_shortcodes() {
		$shortcodes = $this->shortcodes;

		if ( woodmart_woocommerce_installed() ) {
			$shortcodes = array_merge( $this->shortcodes, $this->woo_shortcodes );
		}

		foreach ( $shortcodes as $file ) {
			$path = get_template_directory() . '/inc/shortcodes/' . $file . '.php';
			if( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	/**
	 * Include files in admin area
	 * 
	 */
	private function _include_admin_files() {

		foreach ($this->admin_files_include as $file) {
			$path = get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php');
			if( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	/**
	 * Register 3d party plugins
	 * 
	 */
	private function _third_party_plugins() {

		foreach ($this->third_party_plugins as $file) {
			$path = get_parent_theme_file_path( WOODMART_3D . '/' . $file . '.php');
			if( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	private function _core_plugin_classes() {
		if ( class_exists( 'WOODMART_Auth' ) ) {
			$file_path = array(
				'vendor/opauth/twitteroauth/twitteroauth',
				'vendor/autoload'
			);
			foreach ( $file_path as $file ) {
				$path = apply_filters('woodmart_require', WOODMART_PT_3D . $file . '.php');
				if( file_exists( $path ) ) {
					require_once $path;
				}
			}
			$this->register_classes[] = 'auth';
		}
	}

}