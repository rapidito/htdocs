<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
*  Brands element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_map_brands' ) ) {
	function woodmart_vc_map_brands() {
		$order_by_values = array(
			'',
			esc_html__( 'Name', 'woodmart' ) => 'name',
			esc_html__( 'Slug', 'woodmart' ) => 'slug',
			esc_html__( 'Term ID', 'woodmart' ) => 'term_id',
			esc_html__( 'ID', 'woodmart' ) => 'id',
			esc_html__( 'Random', 'woodmart' ) => 'random',
			esc_html__( 'As IDs or slugs provided order', 'woodmart' ) => 'include',
		);

		$order_way_values = array(
			'',
			esc_html__( 'Descending', 'woodmart' ) => 'DESC',
			esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
		);


		vc_map( array(
			'name' => esc_html__( 'Brands', 'woodmart' ),
			'base' => 'woodmart_brands',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Brands carousel/grid', 'woodmart' ),
        	'icon' => WOODMART_ASSETS . '/images/vc-icon/brands.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number', 'woodmart' ),
					'param_name' => 'number',
					'description' => esc_html__( 'The `number` field is used to display the number of brands.', 'woodmart' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses(  __( 'Select how to sort retrieved brands. More at %s.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'woodmart' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses(  __( 'Designates the ascending or descending order. More at %s.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Image hover', 'woodmart' ),
					'param_name' => 'hover',
					'save_always' => true,
					'value' => array(
						'Default' => 'default',
						'Simple' => 'simple',
						'Alternate' => 'alt',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Brand style', 'woodmart' ),
					'param_name' => 'brand_style',
					'save_always' => true,
					'value' => array(
						'Default' => 'default',
						'Bordered' => 'bordered',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'value' => 4,
					'param_name' => 'style',
					'save_always' => true,
					'value' => array(
						'Carousel' => 'carousel',
						'Grid' => 'grid',
						'Links List' => 'list',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'per_row',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'value' => 3,
					'param_name' => 'columns',
					'save_always' => true,
					'description' => esc_html__( 'How much columns grid', 'woodmart' ),
					'value' => array(
						'',
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'grid', 'list' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Brands', 'woodmart' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'description' => esc_html__( 'List of product brands to show. Leave empty to show all', 'woodmart' ),
				)
			)
		) );

	}
	add_action( 'vc_before_init', 'woodmart_vc_map_brands' );
}

//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_woodmart_brands_ids_callback', 'woodmart_productBrandsAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_woodmart_brands_ids_render', 'woodmart_productBrandsRenderByIdExact', 10, 1 );

if( ! function_exists( 'woodmart_productBrandsAutocompleteSuggester' ) ) {
	function woodmart_productBrandsAutocompleteSuggester( $query, $slug = false ) {
		global $wpdb;
		$cat_id = (int) $query;
		$query = trim( $query );

		$attribute = woodmart_get_opt( 'brands_attribute' );

		$post_meta_infos = $wpdb->get_results(
			$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = '%s' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
						$attribute,
				$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = esc_html__( 'Id', 'woodmart' ) . ': ' .
				                 $value['id'] .
				                 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'woodmart' ) . ': ' .
				                                                      $value['name'] : '' ) .
				                 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'woodmart' ) . ': ' .
				                                                      $value['slug'] : '' );
				$result[] = $data;
			}
		}

		return $result;
	}
}

if( ! function_exists( 'woodmart_productBrandsRenderByIdExact' ) ) {
	function woodmart_productBrandsRenderByIdExact( $query ) {
		global $wpdb;
		$query = $query['value'];
		$cat_id = (int) $query;
		$attribute = woodmart_get_opt( 'brands_attribute' );
		$term = get_term( $cat_id, $attribute );

		return woodmart_productCategoryTermOutput( $term );
	}
}