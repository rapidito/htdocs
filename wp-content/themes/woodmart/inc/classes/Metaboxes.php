<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
 * Add metaboxesto pages and posts
 * uses CMB plugins
 *
 */

/*
    to fix image uploads for taxonomies
    add to file CMB2hookup.php
    line 197
    if ( in_array( $hook, array( 'edit-tags.php', 'post.php', 'post-new.php', 'page-new.php', 'page.php' ), true ) ) {

 */
class WOODMART_Metaboxes {
    /**
     * Options slug for Redux Framework
     * @var string
     */
    private $opt_name = "woodmart_options";

    /**
     * Add actions
     *
     */
    public function __construct() {

        //add_action( 'init', array( $this, 'load_cmb_plugin' ), 199 );

        add_action( 'cmb2_init', array( $this, 'load_cmb_plugin' ), 199 );
        add_action( 'cmb2_init', array( $this, 'pages_metaboxes' ), 10000 );
        add_action( 'cmb2_init', array( $this, 'product_metaboxes' ), 10000 );
        add_action( 'cmb2_init', array( $this, 'product_categories' ), 10000 );
        add_action( 'cmb2_init', array( $this, 'posts_categories' ), 10000 );
        add_action( 'cmb2_init', array( $this, 'slider' ), 10000 );

        add_action("redux/metaboxes/{$this->opt_name}/boxes", array( $this, 'metaboxes' ) );
    }

    /**
     * Require CMB plugin files
     *
     */
    public function load_cmb_plugin() {
        if ( function_exists( 'new_cmb2_box' ) ) {
            require_once get_parent_theme_file_path( WOODMART_3D . '/Taxonomy_MetaData/Taxonomy_MetaData_CMB2.php' );
        }
    }

    /**
     * Register all custom metaboxes with CMB2 API
     */
    public function pages_metaboxes() {
        global $woodmart_transfer_options, $woodmart_prefix;

        // Start with an underscore to hide fields from custom fields list
        $woodmart_prefix = '_woodmart_';

        $woodmart_metaboxes = new_cmb2_box( array(
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // true to keep the metabox closed by default
            'id' => 'page_metabox',
            'title' => esc_html__( 'Page Setting (custom metabox from theme)', 'woodmart' ),
            'object_types' => array('page', 'post', 'portfolio'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ) );

        $woodmart_transfer_options = array(
            'page-title-size',
            'main_layout',
            'sidebar_width',
        );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Header options', 'woodmart' ),
            'id'      => $woodmart_prefix . 'header_options_title',
            'type'    => 'title',
        ) );

        if( whb_is_enabled() ) {
          $woodmart_metaboxes->add_field( array(
              'name'    => 'Custom header for this page',
              'id'      => $woodmart_prefix . 'whb_header',
              'desc'    => 'If you are using our header builder for your header configuration you can select different layout from the list for this particular page.',
              'type'    => 'select',
              'options' => woodmart_get_whb_headers_array()
          ) );
        } else {
          $woodmart_transfer_options[] = 'header';
          $woodmart_transfer_options[] = 'header-overlap';
          $woodmart_transfer_options[] = 'header_color_scheme';
        }

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Open categories menu', 'woodmart' ),
            'desc'    => esc_html__( 'Always shows categories navigation on this page', 'woodmart' ),
            'id'      => $woodmart_prefix . 'open_categories',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Page title options', 'woodmart' ),
            'id'      => $woodmart_prefix . 'page_title_title',
            'type'    => 'title',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Disable Page title', 'woodmart' ),
            'desc'    => esc_html__( 'You can hide page heading for this page', 'woodmart' ),
            'id'      => $woodmart_prefix . 'title_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name' => esc_html__( 'Image for page title', 'woodmart' ),
            'desc' => esc_html__( 'Upload an image', 'woodmart' ),
            'id' => $woodmart_prefix . 'title_image',
            'type' => 'file',
            'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
        ) );

        $woodmart_metaboxes->add_field( array(
            'name' => esc_html__( 'Page title background color', 'woodmart' ),
            'desc' => esc_html__( 'Upload an image', 'woodmart' ),
            'id' => $woodmart_prefix . 'title_bg_color',
            'type' => 'colorpicker',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Text color for title', 'woodmart' ),
            'id'      => $woodmart_prefix . 'title_color',
            'type'    => 'radio_inline',
            'options' => array(
                'default' => esc_html__( 'Inherit', 'woodmart' ),
                'light' => esc_html__( 'Light', 'woodmart' ), 
                'dark' => esc_html__( 'Dark', 'woodmart' ),
            ),
            'default' => 'default'
        ) );

        foreach ($woodmart_transfer_options as $field) {
            if( class_exists('Redux') ){
                $cmb_field = $this->redux2cmb_field( $field );
                $woodmart_metaboxes->add_field( $cmb_field );
            }
            if ( $field == 'page-title-size' ) {
                $woodmart_metaboxes->add_field( array(
                    'name'    => esc_html__( 'Sidebar options', 'woodmart' ),
                    'id'      => $woodmart_prefix . 'sidebar_title',
                    'type'    => 'title',
                ) );
            }
        }

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Custom sidebar for this page', 'woodmart' ),
            'id'      => $woodmart_prefix . 'custom_sidebar',
            'type'    => 'select',
            'options' => woodmart_get_sidebars_array()
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Footer options', 'woodmart' ),
            'id'      => $woodmart_prefix . 'footer_title',
            'type'    => 'title',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Disable footer', 'woodmart' ),
            'desc'    => esc_html__( 'You can disable footer for this page', 'woodmart' ),
            'id'      => $woodmart_prefix . 'footer_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Disable prefooter', 'woodmart' ),
            'desc'    => esc_html__( 'You can disable prefooter for this page', 'woodmart' ),
            'id'      => $woodmart_prefix . 'prefooter_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Disable copyrights', 'woodmart' ),
            'desc'    => esc_html__( 'You can disable copyrights for this page', 'woodmart' ),
            'id'      => $woodmart_prefix . 'copyrights_off',
            'type'    => 'checkbox',
        ) );

        if( ! whb_is_enabled() )
            $woodmart_metaboxes->add_field( array(
                'name'    => esc_html__( 'Disable top-bar', 'woodmart' ),
                'desc'    => esc_html__( 'You can disable top-bar for this page', 'woodmart' ),
                'id'      => $woodmart_prefix . 'top_bar_off',
                'type'    => 'checkbox',
            ) );
    }

    /**
     * Metaboxes for products
     */
    public function product_metaboxes() {
        global $woodmart_prefix, $woodmart_transfer_options;

        // Start with an underscore to hide fields from custom fields list
        $woodmart_prefix = '_woodmart_';
        $taxonomies_list = array( '' => 'Select' );
        $taxonomies = get_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomies_list[$taxonomy] = $taxonomy;
        }

        $woodmart_metaboxes = new_cmb2_box( array(
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // true to keep the metabox closed by default
            'id' => 'product_metabox',
            'title' => esc_html__( 'Product Setting (custom metabox from theme)', 'woodmart' ),
            'object_types' => array('product'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Product design & color options', 'woodmart' ),
            'id'      => $woodmart_prefix . 'product_design_title',
            'type'    => 'title',
        ) );

        $woodmart_local_transfer_options = array(
            'product_design',
            'single_product_style',
            'thums_position',
            'product-background',
            'main_layout',
            'sidebar_width',
        );

        foreach ($woodmart_local_transfer_options as $field) {
            if ( $field == 'main_layout' ) {
                $woodmart_metaboxes->add_field( array(
                    'name'    => esc_html__( 'Sidebar options', 'woodmart' ),
                    'id'      => $woodmart_prefix . 'sidebar_title',
                    'type'    => 'title',
                ) );
            }
            if( class_exists('Redux') ){
                $cmb_field = $this->redux2cmb_field( $field );
                $woodmart_metaboxes->add_field( $cmb_field );
            }
        }

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Custom sidebar for this product', 'woodmart' ),
            'id'      => $woodmart_prefix . 'custom_sidebar',
            'type'    => 'select',
            'options' => woodmart_get_sidebars_array()
        ) );

        $blocks = array_flip(woodmart_get_static_blocks_array());

        $blocks = (array)'None' + $blocks;
        
        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Extra content options', 'woodmart' ), 
            'id'      => $woodmart_prefix . 'extra_content_title',
            'type'    => 'title',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Extra content block', 'woodmart' ),
            'desc'    => esc_html__( 'You can create some extra content with WPBakery Page Builder (in Admin panel / HTML Blocks / Add new) and add it to this product', 'woodmart' ),
            'id'      => $woodmart_prefix . 'extra_content',
            'type'    => 'select',
            'options' => $blocks
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Extra content position', 'woodmart' ),
            'id'      => $woodmart_prefix . 'extra_position',
            'type'    => 'radio_inline',
            'options' => array(
                'after' => esc_html__( 'After content', 'woodmart' ),
                'before' => esc_html__( 'Before content', 'woodmart' ),
                'prefooter' => esc_html__( 'Prefooter', 'woodmart' ),
            ),
            'default' => 'after'
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Product tab options', 'woodmart' ), 
            'id'      => $woodmart_prefix . 'tabs_title',
            'type'    => 'title',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Hide tabs headings', 'woodmart' ), 
            'desc'    => esc_html__( 'Description and Additional information', 'woodmart' ),
            'id'      => $woodmart_prefix . 'hide_tabs_titles',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Custom tab title', 'woodmart' ), 
            'id'      => $woodmart_prefix . 'product_custom_tab_title',
            'type'    => 'text',
        ) );
        
        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Custom tab content', 'woodmart' ), 
            'id'      => $woodmart_prefix . 'product_custom_tab_content',
            'type'    => 'textarea',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Product extra options', 'woodmart' ), 
            'id'      => $woodmart_prefix . 'product_extra_title',
            'type'    => 'title',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Add "New" label', 'woodmart' ), 
            'desc'    => esc_html__( 'You can add "New" label to this product', 'woodmart' ),
            'id'      => $woodmart_prefix . 'new_label',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Hide related products', 'woodmart' ), 
            'desc'    => esc_html__( 'You can hide related products on this page', 'woodmart' ),
            'id'      => $woodmart_prefix . 'related_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Grid swatch attribute to display', 'woodmart' ), 
            'desc'    => esc_html__( 'Choose attribute that will be shown on products grid for this particular product', 'woodmart' ),
            'id'      => $woodmart_prefix . 'swatches_attribute',
            'type'    => 'select',
            'options' => $taxonomies_list
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Product video URL', 'woodmart' ), 
            'desc'    => esc_html__( 'Vimeo or YouTube video url. For example: https://www.youtube.com/watch?v=1zPYW6Ipgok', 'woodmart' ),
            'id'      => $woodmart_prefix . 'product_video',
            'type'    => 'text',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__( 'Instagram product hashtag', 'woodmart' ), 
            'desc'    => wp_kses(  __( 'Insert tag that will be used to display images from instagram from your customers. For example: <strong>#nike_rush_run</strong>', 'woodmart' ), 'default' ),
            'id'      => $woodmart_prefix . 'product_hashtag',
            'type'    => 'text',
        ) );

        $woodmart_transfer_options = array_merge( $woodmart_transfer_options, $woodmart_local_transfer_options );

    }

    public function posts_categories() {
        if( ! class_exists('Redux') ) return;

        $blog_design_field = $this->redux2cmb_field( 'blog_design' );

        $blog_design_field['name'] .= ' for this category';

        $cmb_term = new_cmb2_box( array(
            'id'               => 'cat_options',
            'object_types'     => array( 'term' ),
            'taxonomies'       => array( 'category' ),
            'new_term_section' => true, // Will display in the "Add New Category" section
        ) );

        $cmb_term->add_field($blog_design_field);

    }

    public function product_categories() {
        /**
         * Instantiate our taxonomy meta class
         */

        $cmb_term = cmb2_get_metabox( array(
            'id'               => 'product_cat_options',
            'object_types'     => array( 'term' ),
            'taxonomies'       => array( 'product_cat' ),
            'new_term_section' => true, // Will display in the "Add New Category" section
        ), woodmart_get_current_term_id(), 'term' );

        $cmb_term->add_field( array(
            'name' => esc_html__( 'Image for category heading', 'woodmart' ),
            'desc' => esc_html__( 'Upload an image', 'woodmart' ),
            'id' => 'title_image',
            'type' => 'file',
            'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
        ));

        $cmb_term->add_field(array(
            'name' => esc_html__( 'Image (icon) for categories navigation on the shop page', 'woodmart' ),
            'desc' => esc_html__( 'Upload an image', 'woodmart' ),
            'id' => 'category_icon',
            'type' => 'file',
            'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
        ));

        $cmb_term->add_field(array(
            'name' => esc_html__( 'Icon to display in the main menu (or any other menu through the site)', 'woodmart' ),
            'desc' => esc_html__( 'Upload an image', 'woodmart' ),
            'id' => 'category_icon_alt',
            'type' => 'file',
            'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
        ));

    }

    public function slider() {
        $metabox = new_cmb2_box( array(
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // true to keep the metabox closed by default
            'id' => 'slide_metabox',
            'title' => esc_html__( 'Slide Settings', 'woodmart' ),
            'object_types' => array('woodmart_slide'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ) );

        $metabox->add_field( array(
            'name'    => esc_html__( 'Background color', 'woodmart' ),
            'id'      => 'bg_color',
            'type'    => 'colorpicker',
            'default' => '#fefefe'
        ) );

        $metabox->add_field( array(
            'name'    => esc_html__( 'Vertical content align', 'woodmart' ),
            'id'      => 'vertical_align',
            'type'    => 'woodmart_images_select',
            'images_opts' => array(
                'top' => array(
                    'label' => esc_html__( 'Top', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/top.jpg',
                ),
                'middle' => array(
                    'label' => esc_html__( 'Middle', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/middle.jpg',
                ),
                'bottom' => array(
                    'label' => esc_html__( 'Bottom', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/bottom.jpg',
                ),
            ),
            'default' => 'middle',
        ) );

        $metabox->add_field( array(
            'name'    => esc_html__( 'Horizontal content align', 'woodmart' ),
            'id'      => 'horizontal_align',
            'type'    => 'woodmart_images_select',
            'images_opts' => array(
                'left' => array(
                    'label' => esc_html__( 'Left', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/left.jpg',
                ),
                'center' => array(
                    'label' => esc_html__( 'Center', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/center.jpg',
                ),
                'right' => array(
                    'label' => esc_html__( 'Right', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/right.jpg',
                ),
            ),
            'default' => 'left',
        ) );

        $metabox->add_field( array(
            'name' => esc_html__( 'Full width content', 'woodmart' ),
            'desc' => 'Takes the slider\'s width',
            'id'   => 'content_full_width',
            'type' => 'checkbox',
        ) );

        $metabox->add_field( array(
            'name'        => esc_html__( 'Content width [on desktop]', 'woodmart' ),
            'desc'        => esc_html__( 'Set your value in pixels.', 'woodmart' ),
            'id'          => 'content_width',
            'type'        => 'woodmart_slider',
            'min'         => '100',
            'max'         => '1200',
            'step'        => '5',
            'default'     => '1200', // start value
            'value_label' => 'Value:',
            'attributes' => array(
                'data-conditional-id'    => 'content_full_width',
                'data-conditional-value' => 'off',
            ),
        ));

        $metabox->add_field( array(
            'name'        => esc_html__( 'Content width [on tablets]', 'woodmart' ),
            'desc'        => esc_html__( 'Set your value in pixels.', 'woodmart' ),
            'id'          => 'content_width_tablet',
            'type'        => 'woodmart_slider',
            'min'         => '100',
            'max'         => '1200',
            'step'        => '5',
            'default'     => '1200', // start value
            'value_label' => 'Value:',
            'attributes' => array(
                'data-conditional-id'    => 'content_full_width',
                'data-conditional-value' => 'off',
            ),
        ));

        $metabox->add_field( array(
            'name'        => esc_html__( 'Content width [on mobile]', 'woodmart' ),
            'desc'        => esc_html__( 'Set your value in pixels.', 'woodmart' ),
            'id'          => 'content_width_mobile',
            'type'        => 'woodmart_slider',
            'min'         => '50',
            'max'         => '800',
            'step'        => '5',
            'default'     => '300', // start value
            'value_label' => 'Value:',
            'attributes' => array(
                'data-conditional-id'    => 'content_full_width',
                'data-conditional-value' => 'off',
            ),
        ));

        $metabox->add_field( array(
            'name'             => esc_html__( 'Animation', 'woodmart' ),
            'desc'             => esc_html__( 'Select a content appearance animation', 'woodmart' ),
            'id'               => 'slide_animation',
            'type'             => 'select',
            'show_option_none' => false,
            'default'          => 'none',
            'options'          => array(
                'none' => __( 'None', 'woodmart' ),
                'slide-from-top' => __( 'Slide from top', 'woodmart' ),
                'slide-from-bottom' => __( 'Slide from bottom', 'woodmart' ),
                'slide-from-right' => __( 'Slide from right', 'woodmart' ),
                'slide-from-left' => __( 'Slide from left', 'woodmart' ),
                'top-flip-x' => __( 'Top flip X', 'woodmart' ),
                'bottom-flip-x' => __( 'Bottom flip X', 'woodmart' ),
                'right-flip-y' => __( 'Right flip Y', 'woodmart' ),
                'left-flip-y' => __( 'Left flip Y', 'woodmart' ),
                'zoom-in' => __( 'Zoom in', 'woodmart' ),
            ),
        ) );

        $slider_metabox = cmb2_get_metabox( array(
            'id'               => 'slider_settings',
            'object_types'     => array( 'term' ),
            'taxonomies'       => array( 'woodmart_slider' ),
            'new_term_section' => true, 
        ), woodmart_get_current_term_id(), 'term' );


        $slider_metabox->add_field( array(
            'name' => esc_html__( 'Stretch slider', 'woodmart' ),
            'desc' => esc_html__( 'Make slider full width', 'woodmart' ),
            'id'   => 'stretch_slider',
            'type' => 'checkbox',
        ) );

        $slider_metabox->add_field( array(
            'name'        => esc_html__( 'Height on desktop', 'woodmart' ),
            'desc'        => esc_html__( 'Set your value in pixels.', 'woodmart' ),
            'id'          => 'height',
            'type'        => 'woodmart_slider',
            'min'         => '100',
            'max'         => '1200',
            'step'        => '5',
            'default'     => '500', // start value
            'value_label' => 'Value:',
        ));

        $slider_metabox->add_field( array(
            'name'        => esc_html__( 'Height on tablet', 'woodmart' ),
            'desc'        => esc_html__( 'Set your value in pixels.', 'woodmart' ),
            'id'          => 'height_tablet',
            'type'        => 'woodmart_slider',
            'min'         => '100',
            'max'         => '1200',
            'step'        => '5',
            'default'     => '500', // start value
            'value_label' => 'Value:',
        ));

        $slider_metabox->add_field( array(
            'name'        => esc_html__( 'Height on mobile', 'woodmart' ),
            'desc'        => esc_html__( 'Set your value in pixels.', 'woodmart' ),
            'id'          => 'height_mobile',
            'type'        => 'woodmart_slider',
            'min'         => '100',
            'max'         => '1200',
            'step'        => '5',
            'default'     => '500', // start value
            'value_label' => 'Value:',
        ));

        $slider_metabox->add_field( array(
            'name'        => esc_html__( 'Arrows style', 'woodmart' ),
            // 'desc'        => 'Set your value in pixels.',
            'id'          => 'arrows_style',
            'type'        => 'woodmart_images_select',
            'images_opts' => array(
                '1' => array(
                    'label' => 'Style 1',
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/arrow-style-1.jpg',
                ),
                '2' => array(
                    'label' => 'Style 2',
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/arrow-style-2.jpg',
                ),
                '3' => array(
                    'label' => 'Style 3',
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/arrow-style-3.jpg',
                ),
                '0' => array(
                    'label' => 'Disable',
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/arrow-style-disable.jpg',
                ),
            ),
            'default'     => '1',
        ));

        $slider_metabox->add_field( array(
            'name'        => esc_html__( 'Pagination style', 'woodmart' ),
            // 'desc'        => 'Set your value in pixels.',
            'id'          => 'pagination_style',
            'type'        => 'woodmart_images_select',
            'images_opts' => array(
                '1' => array(
                    'label' => esc_html__( 'Style 1', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-style-1.jpg',
                ),
                '2' => array(
                    'label' => esc_html__( 'Style 2', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-style-2.jpg',
                ),
                '0' => array(
                    'label' => esc_html__( 'Disable', 'woodmart' ),
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-style-disable.jpg',
                ),
            ),
            'default'     => '1',
        ));

        $slider_metabox->add_field( array(
            'name'        => esc_html__( 'Navigation color scheme', 'woodmart' ),
            // 'desc'        => 'Set your value in pixels.',
            'id'          => 'pagination_color',
            'type'        => 'woodmart_images_select',
            'images_opts' => array(
                'light' => array(
                    'label' => 'Light',
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-color-light.jpg',
                ),
                'dark' => array(
                    'label' => 'Dark',
                    'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-color-dark.jpg',
                ),
            ),
            'default'     => 'light',
        ));

        $slider_metabox->add_field( array(
            'name' => esc_html__( 'Enable autoplay', 'woodmart' ),
            'desc' => 'Rotate slider images automatically.',
            'id'   => 'autoplay',
            'type' => 'checkbox',
        ) );

        $slider_metabox->add_field( array(
            'name'    => esc_html__( 'Slide change animation', 'woodmart' ),
            'id'      => 'animation',
            'type'    => 'radio_inline',
            'options' => array(
                'slide' => __( 'Slide', 'woodmart' ),
                'fade'  => __( 'Fade', 'woodmart' ),
            ),
            'default' => 'slide',
        ) );
    }


    /**
     * Transfer function from redux to CMB2
     * @param  string $field      field slug in Redux options
     * @return array  $cmb_field  CMB compatible field config array
     */
    public function redux2cmb_field( $field ) {

       if( ! class_exists('Redux') ) return;

        $prefix = '_woodmart_';

        $field = Redux::getField($this->opt_name, $field);


        $options = array();

        switch ($field['type']) {
            case 'image_select':
                $type = 'radio_inline';
                $options = ( ! empty( $field['options'] ) ) ? array('default' => array('title' => 'Inherit') ) + $field['options'] : array();
                ( count( $options ) > 4 )? $type = 'select' : '';
                foreach ($options as $key => $option) {
                    $options[$key] = ( isset( $options[$key]['alt'] ) ) ? $options[$key]['alt'] : $options[$key]['title'];
                }
            break;

            case 'button_set':
                $type = 'radio_inline';
                $options['default'] = 'Inherit';
                foreach ($field['options'] as $key => $value) {
                    $options[$key] = $value;
                }
            break;

            case 'select':
                $type = 'select';
                $options['inherit'] = 'Inherit';
                foreach ($field['options'] as $key => $value) {
                    $options[$key] = $value;
                }
            break;

            case 'switch':
                $type = 'checkbox';
            break;

            case 'background':
                $type = 'colorpicker';
            break;

            default:
                $type = $field['type'];
            break;
        }

        $cmb_field = array(
            'id' => $prefix . $field['id'],
            'type' => $type,
            'name' => $field['title'],
            'options' => $options,
        );

        return $cmb_field;
    }

    public function metaboxes($metaboxes) {
        // Declare your sections
        $boxSections = array();
        $boxSections[] = array(
            'title' => 'Performance',
            'id' => 'performance',
            'icon' => 'el-icon-cog',
            'fields' => array (
                array (
                    'id'       => 'product-background',
                    'type'     => 'background',
                    'title'    => esc_html__( 'Product background', 'woodmart' ),
                    'subtitle' => esc_html__( 'Set background for your products page. You can also specify different background for particular products while editing it.', 'woodmart' ),
                    'output'   => array('.single-product-content')
                ),
            ),
        );

        // Declare your metaboxes
        $metaboxes = array();
        $metaboxes[] = array(
            'id'            => 'sidebar',
            'title'         => esc_html__( 'Sidebar', 'woodmart' ),
            'post_types'    => array( 'product' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSections,
        );

        return $metaboxes;
    }

}
