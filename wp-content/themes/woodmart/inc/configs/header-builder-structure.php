<?php if ( ! defined("WOODMART_THEME_DIR")) exit("No direct script access allowed");

/**
 * ------------------------------------------------------------------------------------------------
 * Default header builder structure
 * ------------------------------------------------------------------------------------------------
 */

$header_structure = array(
    //General header
    
    'column8' => array(
        'main-header-logo' => array(
            'id' => 'main-header-logo',
            'type' => 'logo',
            'params' => array(
                'image' => array(
                    'id' => 'image',
                    'value' => '',
                    'type' => 'image'
                ),
                'width' => array(
                    'id' => 'width',
                    'value' => 210,
                    'type' => 'slider'
                ),
                'sticky_image' => array(
                    'id' => 'sticky_image',
                    'value' => '',
                    'type' => 'image'
                ),
                'sticky_width' => array(
                    'id' => 'sticky_width',
                    'value' => 250,
                    'type' => 'slider'
                )
            )
        )
    ),
    
    'column9' => array(
        'main-header-menu' => array(
            'id' => 'main-header-menu',
            'type' => 'mainmenu',
            'params' => array(
                'menu_style' => array(
                    'id' => 'menu_style',
                    'value' => 'default',
                    'type' => 'selector'
                ),
                'menu_align' => array(
                    'id' => 'menu_align',
                    'value' => 'center',
                    'type' => 'selector'
                )
            )
        )
    ),

    'column10' => array(
        'main-header-account' => array(
            'id' => 'main-header-account',
            'type' => 'account',
            'params' => array(
                'display' => array(
                    'id' => 'display',
                    'value' => 'text',
                    'type' => 'selector'
                ),
                'with_username' => array(
                    'id' => 'with_username',
                    'value' => false,
                    'type' => 'switcher'
                ),
                'login_dropdown' => array(
                    'id' => 'login_dropdown',
                    'value' => true,
                    'type' => 'switcher'
                ),
            )
        ),
        
        'main-header-search' => array(
            'id' => 'main-header-search',
            'type' => 'search',
            'params' => array(
                'display' => array(
                    'id' => 'display',
                    'value' => 'full-screen',
                    'type' => 'selector'
                ),
                'categories_dropdown' => array(
                    'id' => 'categories_dropdown',
                    'value' => true,
                    'type' => 'switcher'
                ),
                'ajax' => array(
                    'id' => 'ajax',
                    'value' => true,
                    'type' => 'switcher'
                ),
                'post_type' => array(
                    'id' => 'post_type',
                    'value' => 'product',
                    'type' => 'selector'
                )
            )
        ),
        
        'main-header-wishlist' => array(
            'id' => 'main-header-wishlist',
            'type' => 'wishlist',
            'params' => array(
                'design' => array(
                    'id' => 'design',
                    'value' => 'icon',
                    'type' => 'selector'
                )
            )
        ),
        
        'main-header-cart' => array(
            'id' => 'main-header-cart',
            'type' => 'cart',
            'params' => array(
                'position' => array(
                    'id' => 'position',
                    'value' => 'side',
                    'type' => 'selector'
                ),
                'style' => array(
                    'id' => 'style',
                    'value' => '2',
                    'type' => 'selector'
                ),
                'alt_icon' => array(
                    'id' => 'alt_icon',
                    'value' => true,
                    'type' => 'switcher'
                )
            )
        )
    ),
    
    'column_mobile2' => array(
        'main-header-mobile-burger' => array(
            'id' => 'main-header-mobile-burger',
            'type' => 'burger',
            'params' => array(
                'style' => array(
                    'id' => 'style',
                    'value' => 'text',
                    'type' => 'selector'
                ),
                'position' => array(
                    'id' => 'position',
                    'value' => 'left',
                    'type' => 'selector'
                ),
                'categories_menu' => array(
                    'id' => 'categories_menu',
                    'value' => true,
                    'type' => 'switcher'
                ),
                'menu_id' => array(
                    'id' => 'menu_id',
                    'value' => 166,
                    'type' => 'select'
                )
            )
        )
    ),
    
    'column_mobile3' => array(
        'main-header-mobile-logo' => array(
            'id' => 'main-header-mobile-logo',
            'type' => 'logo',
            'params' => array(
                'image' => array(
                    'id' => 'image',
                    'value' => '',
                    'type' => 'image'
                ),
                'width' => array(
                    'id' => 'width',
                    'value' => 138,
                    'type' => 'slider'
                ),
                'sticky_image' => array(
                    'id' => 'sticky_image',
                    'value' => '',
                    'type' => 'image'
                ),
                'sticky_width' => array(
                    'id' => 'sticky_width',
                    'value' => 150,
                    'type' => 'slider'
                )
            )
        )
    ),
    
    'column_mobile4' => array(
        'main-header-mobile-cart' => array(
            'id' => 'main-header-mobile-cart',
            'type' => 'cart',
            'params' => array(
                'position' => array(
                    'id' => 'position',
                    'value' => 'side',
                    'type' => 'selector'
                ),
                'style' => array(
                    'id' => 'style',
                    'value' => '5',
                    'type' => 'selector'
                ),
                'alt_icon' => array(
                    'id' => 'alt_icon',
                    'value' => true,
                    'type' => 'switcher'
                )
            )
        ),
    ),

);

return apply_filters( 'woodmart_default_header_structure', $header_structure );