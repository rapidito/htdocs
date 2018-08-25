<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
*  Blog element map
* ------------------------------------------------------------------------------------------------
*/
if( ! function_exists( 'woodmart_vc_map_blog' ) ) {
	function woodmart_vc_map_blog() {

		$post_types_list = array();
		$post_types_list[] = array( 'post', esc_html__( 'Post', 'woodmart' ) );
		$post_types_list[] = array( 'ids', esc_html__( 'List of IDs', 'woodmart' ) );

		vc_map( array(
			'name' => esc_html__('Blog', 'woodmart' ),
			'base' => 'woodmart_blog',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Show your blog posts on the page', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/blog.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Data source', 'woodmart' ),
					'param_name' => 'post_type',
					'value' => $post_types_list,
					'description' => esc_html__( 'Select content type for your grid.', 'woodmart' )
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Include only', 'woodmart' ),
					'param_name' => 'include',
					'description' => esc_html__( 'Add posts, pages, etc. by title.', 'woodmart' ),
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'groups' => true,
					),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'ids' ),
					),
				),
				// Custom query tab
				array(
					'type' => 'textarea_safe',
					'heading' => esc_html__( 'Custom query', 'woodmart' ),
					'param_name' => 'custom_query',
					'description' => wp_kses(  __( 'Build custom query according to <a href="http://codex.wordpress.org/Function_Reference/query_posts">WordPress Codex</a>.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Narrow data source', 'woodmart' ),
					'param_name' => 'taxonomies',
					'settings' => array(
						'multiple' => true,
						// is multiple values allowed? default false
						// 'sortable' => true, // is values are sortable? default false
						'min_length' => 1,
						// min length to start search -> default 2
						// 'no_hide' => true, // In UI after select doesn't hide an select list, default false
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
						// 'values' => $taxonomies_for_filter,
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Enter categories, tags or custom taxonomies.', 'woodmart' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Items per page', 'woodmart' ),
					'param_name' => 'items_per_page',
					'description' => esc_html__( 'Number of items to show per page.', 'woodmart' ),
					'value' => '10',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Pagination', 'woodmart' ),
					'param_name' => 'pagination',
					'value' => array(
	                    '' => '',
	                    esc_html__( 'Pagination', 'woodmart' ) => 'pagination',
	                    wp_kses( __( 'Load more button', 'woodmart' ), 'entities' ) => 'more-btn',
	                    esc_html__( 'Infinit scrolling', 'woodmart' ) => 'infinit',
					),
					'dependency' => array(
						'element' => 'blog_design',
						'value_not_equal_to' => array( 'carousel' ),
					),
				),
				// Design settings
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Blog Design', 'woodmart' ),
					'param_name' => 'blog_design',
					'value' => array(
	                    esc_html__( 'Default', 'woodmart' ) => 'default',
	                    esc_html__( 'Default alternative', 'woodmart' ) => 'default-alt',
	                    esc_html__( 'Small images', 'woodmart' ) => 'small-images',
	                    esc_html__( 'Chess', 'woodmart' ) => 'chess',
						esc_html__( 'Masonry grid', 'woodmart' ) => 'masonry',
						esc_html__( 'Mask on image', 'woodmart' ) => 'mask',
						esc_html__( 'Carousel', 'woodmart' ) => 'carousel',
					),
					'description' => esc_html__( 'You can use different design for your blog styled for the theme', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Blog carousel design', 'woodmart' ),
					'param_name' => 'blog_carousel_design',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'masonry',
	                    esc_html__( 'Small images', 'woodmart' ) => 'small-images',
						esc_html__( 'Mask on image', 'woodmart' ) => 'mask',
					),
					'description' => esc_html__( 'You can use different design for your blog carousel', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Post style small images (Deprecated) ', 'woodmart' ),
					'param_name' => 'carousel_small_img',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Images size', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'param_name' => 'blog_columns',
					'value' => array(
						2, 3, 4
					),
					'description' => esc_html__( 'Blog items columns', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'masonry', 'mask' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Space between posts', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'blog_spacing',
					'value' => array(
						'', 0, 2, 6, 10, 20, 30
					),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'mask', 'masonry', 'carousel' )
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title for posts', 'woodmart' ),
					'param_name' => 'parts_title',
					'group' => esc_html__( 'Design', 'woodmart' ),
					'value' => array(
	                    'Show' => 1,
	                    'Hide' => 0,
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Meta information', 'woodmart' ),
					'param_name' => 'parts_meta',
					'group' => esc_html__( 'Design', 'woodmart' ),
					'value' => array(
	                    'Show' => 1,
	                    'Hide' => 0,
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Post text', 'woodmart' ),
					'param_name' => 'parts_text',
					'group' => esc_html__( 'Design', 'woodmart' ),
					'value' => array(
	                    'Show' => 1,
	                    'Hide' => 0,
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Read more button', 'woodmart' ),
					'param_name' => 'parts_btn',
					'group' => esc_html__( 'Design', 'woodmart' ),
					'value' => array(
	                    'Show' => 1,
	                    'Hide' => 0,
					),
				),
				// Data settings
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => array(
						esc_html__( 'Date', 'woodmart' ) => 'date',
						esc_html__( 'Order by post ID', 'woodmart' ) => 'ID',
						esc_html__( 'Author', 'woodmart' ) => 'author',
						esc_html__( 'Title', 'woodmart' ) => 'title',
						esc_html__( 'Last modified date', 'woodmart' ) => 'modified',
						esc_html__( 'Post/page parent ID', 'woodmart' ) => 'parent',
						esc_html__( 'Number of comments', 'woodmart' ) => 'comment_count',
						esc_html__( 'Menu order/Page Order', 'woodmart' ) => 'menu_order',
						esc_html__( 'Meta value', 'woodmart' ) => 'meta_value',
						esc_html__( 'Meta value number', 'woodmart' ) => 'meta_value_num',
						esc_html__( 'Random order', 'woodmart' ) => 'rand',
					),
					'description' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sorting', 'woodmart' ),
					'param_name' => 'order',
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'value' => array(
						esc_html__( 'Descending', 'woodmart' ) => 'DESC',
						esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'description' => esc_html__( 'Select sorting order.', 'woodmart' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Meta key', 'woodmart' ),
					'param_name' => 'meta_key',
					'description' => esc_html__( 'Input meta key for grid ordering.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'orderby',
						'value' => array( 'meta_value', 'meta_value_num' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Offset', 'woodmart' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'Number of grid elements to displace or pass over.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Exclude', 'woodmart' ),
					'param_name' => 'exclude',
					'description' => esc_html__( 'Exclude posts, pages, etc. by title.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'settings' => array(
						'multiple' => true,
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
						'callback' => 'vc_grid_exclude_dependency_callback',
					),
				),

				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'woodmart' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Also supports for "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode doesn\'t compatible with loop mode.', 'woodmart' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Scroll per page', 'woodmart' ),
					'param_name' => 'scroll_per_page',
					'description' => esc_html__( 'Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'std' => 'yes',
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
	      )

	    ) );
	}
	add_action( 'vc_before_init', 'woodmart_vc_map_blog' );
}

// Necessary hooks for blog autocomplete fields
add_filter( 'vc_autocomplete_woodmart_blog_include_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_woodmart_blog_include_render',
	'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

// Narrow data taxonomies
add_filter( 'vc_autocomplete_woodmart_blog_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_woodmart_blog_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

// Narrow data taxonomies for exclude_filter
add_filter( 'vc_autocomplete_woodmart_blog_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_woodmart_blog_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

add_filter( 'vc_autocomplete_woodmart_blog_exclude_callback',	'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_woodmart_blog_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)