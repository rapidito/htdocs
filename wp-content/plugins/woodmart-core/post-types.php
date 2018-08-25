<?php 
class WOODMART_Post_Types {

	public $domain = 'woodmart_starter';

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woodmart' ), '2.1' );
	}

	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woodmart' ), '2.1' );
	}

	public function __construct() {
		
		// Hook into the 'init' action
		add_action( 'init', array($this, 'register_blocks'), 1 );
		add_action( 'init', array($this, 'size_guide'), 1 );
		add_action( 'init', array($this, 'slider'), 1 );

		// Duplicate post action for slides
		add_filter( 'post_row_actions', array($this, 'duplicate_slide_action'), 10, 2 );
		add_filter( 'admin_action_woodmart_duplicate_post_as_draft', array($this, 'duplicate_post_as_draft'), 10, 2 );

		// Manage slides list columns
		add_filter( 'manage_edit-woodmart_slide_columns', array($this, 'edit_woodmart_slide_columns') ) ;
		add_action( 'manage_woodmart_slide_posts_custom_column', array($this, 'manage_woodmart_slide_columns'), 10, 2 );

		// Add shortcode column to block list
		add_filter( 'manage_edit-cms_block_columns', array($this, 'edit_html_blocks_columns') ) ;
		add_action( 'manage_cms_block_posts_custom_column', array($this, 'manage_html_blocks_columns'), 10, 2 );

		add_filter( 'manage_edit-portfolio_columns', array($this, 'edit_portfolio_columns') ) ;
		add_action( 'manage_portfolio_posts_custom_column', array($this, 'manage_portfolio_columns'), 10, 2 );

		add_action( 'init', array($this, 'register_sidebars'), 1 );
		add_action( 'init', array($this, 'register_portfolio'), 1 );

		add_action( 'init', array($this, 'slider'), 1 );

		
	}

	// **********************************************************************// 
	// ! Register Custom Post Type for WoodMart slider
	// **********************************************************************// 
	public function slider() {
		
		if ( function_exists( 'woodmart_get_opt' ) && ! woodmart_get_opt( 'woodmart_slider' ) ) return;

		$labels = array(
			'name'                => _x( 'WoodMart Slider', 'Post Type General Name', 'woodmart' ),
			'singular_name'       => _x( 'Slide', 'Post Type Singular Name', 'woodmart' ),
			'menu_name'           => __( 'Slides', 'woodmart' ),
			'parent_item_colon'   => __( 'Parent Item:', 'woodmart' ),
			'all_items'           => __( 'All Items', 'woodmart' ),
			'view_item'           => __( 'View Item', 'woodmart' ),
			'add_new_item'        => __( 'Add New Item', 'woodmart' ),
			'add_new'             => __( 'Add New', 'woodmart' ),
			'edit_item'           => __( 'Edit Item', 'woodmart' ),
			'update_item'         => __( 'Update Item', 'woodmart' ),
			'search_items'        => __( 'Search Item', 'woodmart' ),
			'not_found'           => __( 'Not found', 'woodmart' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'woodmart' ),
		);

		$args = array(
			'label'               => 'woodmart_slide',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-images-alt2',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'woodmart_slide', $args );

		$labels = array(
			'name'					=> _x( 'Sliders', 'Taxonomy plural name', 'woodmart' ),
			'singular_name'			=> _x( 'Slider', 'Taxonomy singular name', 'woodmart' ),
			'search_items'			=> __( 'Search Sliders', 'woodmart' ),
			'popular_items'			=> __( 'Popular Sliders', 'woodmart' ),
			'all_items'				=> __( 'All Sliders', 'woodmart' ),
			'parent_item'			=> __( 'Parent Slider', 'woodmart' ),
			'parent_item_colon'		=> __( 'Parent Slider', 'woodmart' ),
			'edit_item'				=> __( 'Edit Slider', 'woodmart' ),
			'update_item'			=> __( 'Update Slider', 'woodmart' ),
			'add_new_item'			=> __( 'Add New Slider', 'woodmart' ),
			'new_item_name'			=> __( 'New Slide', 'woodmart' ),
			'add_or_remove_items'	=> __( 'Add or remove Sliders', 'woodmart' ),
			'choose_from_most_used'	=> __( 'Choose from most used sliders', 'woodmart' ),
			'menu_name'				=> __( 'Slider', 'woodmart' ),
		);
	
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => false,
			'show_ui'           => true,
			'query_var'         => false,
			'rewrite'           => false,
			'query_var'         => false,
			'capabilities'      => array(),
		);
	
		register_taxonomy( 'woodmart_slider', array( 'woodmart_slide' ), $args );
	}

	public function duplicate_slide_action( $actions, $post ) {
		if( $post->post_type != 'woodmart_slide' ) return $actions;

		if (current_user_can('edit_posts')) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=woodmart_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
		}
		return $actions;
	}

	public function duplicate_post_as_draft() {
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'woodmart_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}
	 
		/*
		 * Nonce verification
		 */
		if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
			return;
	 
		/*
		 * get the original post id
		 */
		$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		/*
		 * and all the original post data then
		 */
		$post = get_post( $post_id );
	 
		/*
		 * if you don't want current user to be the new post author,
		 * then change next couple of lines to this: $new_post_author = $post->post_author;
		 */
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
	 
		/*
		 * if post data exists, create the post duplicate
		 */
		if (isset( $post ) && $post != null) {
	 
			/*
			 * new post data array
			 */
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title . ' (duplicate)',
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
	 
			/*
			 * insert the post by wp_insert_post() function
			 */
			$new_post_id = wp_insert_post( $args );
	 
			/*
			 * get all current post terms ad set them to the new post draft
			 */
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
	 
			/*
			 * duplicate all post meta just in two SQL queries
			 */
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if( $meta_key == '_wp_old_slug' ) continue;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}
	 
	 
			/*
			 * finally, redirect to the edit post screen for the new draft
			 */
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			exit;
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}

	// **********************************************************************// 
	// ! Register Custom Post Type for Size Guide
	// **********************************************************************// 
	public function size_guide() {
		
		if ( function_exists( 'woodmart_get_opt' ) && ! woodmart_get_opt( 'size_guides' ) ) return;

		$labels = array(
			'name'                => _x( 'Size Guides', 'Post Type General Name', $this->domain ),
			'singular_name'       => _x( 'Size Guide', 'Post Type Singular Name', $this->domain ),
			'menu_name'           => __( 'Size Guides', $this->domain ),
			'add_new'             => _x( 'Add new', 'size guide', $this->domain ),
			'add_new_item'        => __( 'Add new size guide', $this->domain ),
			'new_item'            => __( 'New size guide', $this->domain ),
			'edit_item'           => __( 'Edit size guide', $this->domain ),
			'view_item'           => __( 'View size guide', $this->domain ),
			'all_items'           => __( 'All size guides', $this->domain ),
			'search_items'        => __( 'Search size guides', $this->domain ),
			'not_found'           => __( 'No size guides found.', $this->domain ),
			'not_found_in_trash'  => __( 'No size guides found in trash.', $this->domain )
		);

		$args = array(
			'label'               => __( 'woodmart_size_guide', $this->domain ),
			'description'         => __( 'Size guide to place in your products', $this->domain ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'woodmart_size_guide', $args );
	}
	
	// **********************************************************************// 
	// ! Register Custom Post Type for HTML Blocks
	// **********************************************************************// 
	
	public function register_blocks() {

		$labels = array(
			'name'                => _x( 'HTML Blocks', 'Post Type General Name', $this->domain ),
			'singular_name'       => _x( 'HTML Block', 'Post Type Singular Name', $this->domain ),
			'menu_name'           => __( 'HTML Blocks', $this->domain ),
			'parent_item_colon'   => __( 'Parent Item:', $this->domain ),
			'all_items'           => __( 'All Items', $this->domain ),
			'view_item'           => __( 'View Item', $this->domain ),
			'add_new_item'        => __( 'Add New Item', $this->domain ),
			'add_new'             => __( 'Add New', $this->domain ),
			'edit_item'           => __( 'Edit Item', $this->domain ),
			'update_item'         => __( 'Update Item', $this->domain ),
			'search_items'        => __( 'Search Item', $this->domain ),
			'not_found'           => __( 'Not found', $this->domain ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->domain ),
		);

		$args = array(
			'label'               => __( 'cms_block', $this->domain ),
			'description'         => __( 'CMS Blocks for custom HTML to place in your pages', $this->domain ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-schedule',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'cms_block', $args );

	}


	public function edit_html_blocks_columns( $columns ) {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', $this->domain ),
			'shortcode' => __( 'Shortcode', $this->domain ),	   
			'date' => __( 'Date', $this->domain ),
		);

		return $columns;
	}


	public function manage_html_blocks_columns($column, $post_id) {
		switch( $column ) {
			case 'shortcode' :
				echo '<strong>[html_block id="'.$post_id.'"]</strong>';
			break;
		}	
	}

	// **********************************************************************// 
	// ! Register Custom Post Type for additional sidebars
	// **********************************************************************// 
	public function register_sidebars() {

		$labels = array(
			'name'                => _x( 'Sidebars', 'Post Type General Name', $this->domain ),
			'singular_name'       => _x( 'Sidebar', 'Post Type Singular Name', $this->domain ),
			'menu_name'           => __( 'Sidebars', $this->domain ),
			'parent_item_colon'   => __( 'Parent Item:', $this->domain ),
			'all_items'           => __( 'All Items', $this->domain ),
			'view_item'           => __( 'View Item', $this->domain ),
			'add_new_item'        => __( 'Add New Item', $this->domain ),
			'add_new'             => __( 'Add New', $this->domain ),
			'edit_item'           => __( 'Edit Item', $this->domain ),
			'update_item'         => __( 'Update Item', $this->domain ),
			'search_items'        => __( 'Search Item', $this->domain ),
			'not_found'           => __( 'Not found', $this->domain ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->domain ),
		);

		$args = array(
			'label'               => __( 'woodmart_sidebar', $this->domain ),
			'description'         => __( 'You can create additional custom sidebar and use them in Visual Composer', $this->domain ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 67,
			'menu_icon'           => 'dashicons-welcome-widgets-menus',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'woodmart_sidebar', $args );

	}



	// **********************************************************************// 
	// ! Register Custom Post Type for portfolio
	// **********************************************************************// 
	public function register_portfolio() {

		if ( function_exists( 'woodmart_get_opt' ) && woodmart_get_opt( 'disable_portfolio' ) ) return;

		$labels = array(
			'name'                => _x( 'Portfolio', 'Post Type General Name', $this->domain ),
			'singular_name'       => _x( 'Project', 'Post Type Singular Name', $this->domain ),
			'menu_name'           => __( 'Projects', $this->domain ),
			'parent_item_colon'   => __( 'Parent Item:', $this->domain ),
			'all_items'           => __( 'All Items', $this->domain ),
			'view_item'           => __( 'View Item', $this->domain ),
			'add_new_item'        => __( 'Add New Item', $this->domain ),
			'add_new'             => __( 'Add New', $this->domain ),
			'edit_item'           => __( 'Edit Item', $this->domain ),
			'update_item'         => __( 'Update Item', $this->domain ),
			'search_items'        => __( 'Search Item', $this->domain ),
			'not_found'           => __( 'Not found', $this->domain ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->domain ),
		);

		$args = array(
			'label'               => __( 'portfolio', $this->domain ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 28,
			'menu_icon'           => 'dashicons-format-gallery',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => array('slug' => 'portfolio'),
			'capability_type'     => 'page',
		);

		register_post_type( 'portfolio', $args );

		/**
		 * Create a taxonomy category for portfolio
		 *
		 * @uses  Inserts new taxonomy object into the list
		 * @uses  Adds query vars
		 *
		 * @param string  Name of taxonomy object
		 * @param array|string  Name of the object type for the taxonomy object.
		 * @param array|string  Taxonomy arguments
		 * @return null|WP_Error WP_Error if errors, otherwise null.
		 */
		
		$labels = array(
			'name'					=> _x( 'Project Categories', 'Taxonomy plural name', $this->domain ),
			'singular_name'			=> _x( 'Project Category', 'Taxonomy singular name', $this->domain ),
			'search_items'			=> __( 'Search Categories', $this->domain ),
			'popular_items'			=> __( 'Popular Project Categories', $this->domain ),
			'all_items'				=> __( 'All Project Categories', $this->domain ),
			'parent_item'			=> __( 'Parent Category', $this->domain ),
			'parent_item_colon'		=> __( 'Parent Category', $this->domain ),
			'edit_item'				=> __( 'Edit Category', $this->domain ),
			'update_item'			=> __( 'Update Category', $this->domain ),
			'add_new_item'			=> __( 'Add New Category', $this->domain ),
			'new_item_name'			=> __( 'New Category', $this->domain ),
			'add_or_remove_items'	=> __( 'Add or remove Categories', $this->domain ),
			'choose_from_most_used'	=> __( 'Choose from most used text-domain', $this->domain ),
			'menu_name'				=> __( 'Category', $this->domain ),
		);
	
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => true,
			'query_var'         => true,
			'capabilities'      => array(),
		);
	
		register_taxonomy( 'project-cat', array( 'portfolio' ), $args );

	}


	public function edit_woodmart_slide_columns( $columns ) {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'thumb' => '',
			'title' => __( 'Title', $this->domain ),
			'slide-slider' => __( 'Slider', $this->domain ),	   
			'date' => __( 'Date', $this->domain ),
		);

		return $columns;
	}


	public function manage_woodmart_slide_columns($column, $post_id) {
		switch( $column ) {
			case 'thumb' :
				if( has_post_thumbnail( $post_id ) ) {
					the_post_thumbnail( array(60,60) );
				}
			break;
			case 'slide-slider' :
				$terms = get_the_terms( $post_id, 'woodmart_slider' );
										
				if ( $terms && ! is_wp_error( $terms ) ) : 

					$cats_links = array();

					foreach ( $terms as $term ) {
						$cats_links[] = $term->name;
					}
										
					$cats = join( ", ", $cats_links );
				?>

				<span><?php echo $cats; ?></span>

				<?php endif; 
			break;
		}	
	}



	public function edit_portfolio_columns( $columns ) {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'thumb' => '',
			'title' => __( 'Title', $this->domain ),
			'project-cat' => __( 'Categories', $this->domain ),	   
			'date' => __( 'Date', $this->domain ),
		);

		return $columns;
	}


	public function manage_portfolio_columns($column, $post_id) {
		switch( $column ) {
			case 'thumb' :
				if( has_post_thumbnail( $post_id ) ) {
					the_post_thumbnail( array(60,60) );
				}
			break;
			case 'project-cat' :
				$terms = get_the_terms( $post_id, 'project-cat' );
										
				if ( $terms && ! is_wp_error( $terms ) ) : 

					$cats_links = array();

					foreach ( $terms as $term ) {
						$cats_links[] = $term->name;
					}
										
					$cats = join( ", ", $cats_links );
				?>

				<span><?php echo $cats; ?></span>

				<?php endif; 
			break;
		}	
	}

	/**
	 * Get the plugin url.
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}


}

function WOODMART_Theme_Plugin() {
	return WOODMART_Post_Types::instance();
}

$GLOBALS['woodmart_theme_plugin'] = WOODMART_Theme_Plugin();

function woodmart_compress($variable){
	return base64_encode($variable);
}
function woodmart_decompress($variable){
	return base64_decode($variable);
}
function woodmart_get_svg($variable){
	return file_get_contents($variable);
}
// **********************************************************************// 
// ! Support shortcodes in text widget
// **********************************************************************// 

add_filter('widget_text', 'do_shortcode');
?>
