<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Base;


use \Inc\Api\SettingsApi;
use \Inc\Base\Basecontroller;
use \Inc\Api\Callbacks\CptCallbacks;
use \Inc\Api\Callbacks\AdminCallbacks;


class CustomPostTypeController extends BaseController
{

    public $settings;

    public $callbacks;

    public $cpt_callbacks;

    public $subpages = array();

    public $custom_post_types = array();


    public function register()
    {

        if( ! $this->activated( 'cpt_manager' ) ) return;


        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->cpt_callbacks = new CptCallbacks();

        $this->setSubpages();


        $this->setSettings();
        $this->setSections();
        $this->setFields();


        $this->settings->addSubPages( $this->subpages )->register();


        $this->storeCustomPostTypes();

        if( ! empty( $this->custom_post_types ) ) {
            add_action( 'init', array( $this, 'registerCustomPostTypes' ) );
        }

    }

    public function setSubpages()
    {

        $this->subpages = array(
            array(
                'parent_slug'   => 'niloy_plugin',
                'page_title'    => 'Niloy Plugin CPT',
                'menu_title'    => 'CPT Manager',
                'capability'    => 'manage_options',
                'menu_slug'     => 'niloy_CPT',
                'page_callback' => array( $this->callbacks, 'adminCptManager' )
             )

        );

    }

    /** */
    public function setSettings()
    {

        $args = array(
            array(
				'option_group' => 'niloy_plugin_cpt_settings',
				'option_name' => 'niloy_plugin_cpt',
                'callback'          => array( $this->cpt_callbacks, 'cptSanitize' )
            )
        );

        // foreach ( $this->managers as $key => $value ) {
		// 	$args[] = array(
		// 		'option_group' => 'niloy_plugin_settings',
		// 		'option_name' => $key,
        //         'callback'          => array( $this->callback_managers, 'checkboxSanitize' )
        //     );
        // }

        $this->settings->setSettings( $args );

    }

    
    public function setSections()
    {

        $args = array(
            array(
                'id'                => 'admin_cpt_section',
                'title'             => 'Custom Post Type Manager',
                'callback'          => array( $this->cpt_callbacks, 'cptSectionManager' ),
                'page'              => 'niloy_CPT'
            )
        );

        $this->settings->setSections( $args );

    }

        
    public function setFields()
    {

        $args = array(

                array(
                    'id'                => 'post_type',
                    'title'             => 'Custom Post Type ID',
                    'callback'          => array( $this->cpt_callbacks, 'textField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'post_type',
                        'placeholder'       => 'eg. product/comic-book',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'plural_name',
                    'title'             => 'Plural Name',
                    'callback'          => array( $this->cpt_callbacks, 'textField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'plural_name',
                        'placeholder'       => 'eg. Products/Books',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'singular_name',
                    'title'             => 'Singular Name',
                    'callback'          => array( $this->cpt_callbacks, 'textField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'singular_name',
                        'placeholder'       => 'eg. Product/Book',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'public',
                    'title'             => 'Is Public?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'public',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'has_archive',
                    'title'             => 'Has Archive?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'has_archive',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'show_ui',
                    'title'             => 'Show in Admin?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'show_ui',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'show_in_rest',
                    'title'             => 'Show in Rest?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'show_in_rest',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'show_in_menu',
                    'title'             => 'Show in Menu?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'show_in_menu',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'show_in_nav_menus',
                    'title'             => 'Show in Nav Menus?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'show_in_nav_menus',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'show_in_admin_bar',
                    'title'             => 'Show in Admin Bar?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'show_in_admin_bar',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'can_export',
                    'title'             => 'Exportable?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'can_export',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'publicly_queryable',
                    'title'             => 'Publicly Queryable?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'publicly_queryable',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'exclude_from_search',
                    'title'             => 'Exclude From Search?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'exclude_from_search',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'delete_with_user',
                    'title'             => 'Delete With User?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'delete_with_user',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'hierarchical',
                    'title'             => 'Has Hierarchical?',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'hierarchical',
                        'class'             => 'ui-toggle',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'menu_position',
                    'title'             => 'Give a Menu Position',
                    'callback'          => array( $this->cpt_callbacks, 'optionField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'menu_position',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'supports',
                    'title'             => 'Supports',
                    'callback'          => array( $this->cpt_callbacks, 'multiRadioField' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'supports',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'taxonomies',
                    'title'             => 'Taxonomies',
                    'callback'          => array( $this->cpt_callbacks, 'radioFieldTax' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'taxonomies',
                        'array'             => 'post_type'
                    )
                ),
                array(
                    'id'                => 'dash_icons',
                    'title'             => 'Select a Dashicon',
                    'callback'          => array( $this->cpt_callbacks, 'checkboxFieldforDashicons' ),
                    'page'              => 'niloy_CPT',
                    'section'           => 'admin_cpt_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin_cpt',
                        'label_for'         => 'dash_icons',
                        'array'             => 'post_type'
                    )
                )

        );

        
        $this->settings->setFields( $args );

    }


    /** */
    public function storeCustomPostTypes()
    {

        $options = get_option( 'niloy_plugin_cpt' ) ?: array();

        $options = get_option( 'niloy_plugin_cpt' );

        foreach ($options as $option) {

            
            $this->custom_post_types[] = array(
                'post_type'             => $option[ 'post_type' ],
                'name'                  => $option[ 'plural_name' ],
                'singular_name'         => $option[ 'singular_name' ],
                'plural_name'           => $option[ 'plural_name' ],
                'menu_name'             => $option[ 'plural_name' ],
                'name_admin_bar'        => $option[ 'singular_name' ],
                'add_new'               => _x( 'Add New', $option[ 'singular_name' ], 'niloy-plugin' ),
                'add_new_item'          => 'Add New ' . $option[ 'singular_name' ],
                'edit_item'             => 'Edit ' . $option[ 'singular_name' ],
                'new_item'              => 'New ' . $option[ 'singular_name' ],
                'view_item'             => 'View ' . $option[ 'singular_name' ],
                'view_items'            => 'View ' . $option[ 'plural_name' ],
                'search_items'          => 'Search ' . $option[ 'plural_name' ],
                'not_found'             => 'No ' . $option[ 'plural_name' ] . ' found',
                'not_found_in_trash'    => 'No ' . $option[ 'plural_name' ] . ' found in Trash',
                'parent_item_colon'     => 'Parent Page',
                'all_items'             => 'All ' . $option[ 'plural_name' ],
                'archives'              => $option[ 'plural_name' ],
                'attributes'            => $option[ 'singular_name' ] . ' Attributes',
                'insert_into_item'      => 'Insert into ' . $option[ 'singular_name' ],
                'uploaded_to_this_item' => 'Uploaded to this ' . $option[ 'singular_name' ],
                'featured_image'        => $option[ 'singular_name' ] . ' Image',
                'set_featured_image'    => 'Set ' . $option[ 'singular_name' ] . ' image',
                'remove_featured_image' => 'Remove ' . $option[ 'singular_name' ] . ' image',
                'use_featured_image'    => 'Use as ' . $option[ 'singular_name' ] . ' image',
                'filter_items_list'     => 'Filter ' . $option[ 'plural_name' ] . ' list',
                'items_list_navigation' => $option[ 'plural_name' ] . ' list navigation',
                'items_list'            => $option[ 'plural_name' ] . ' list',
                'public'                => isset($option[ 'public' ]) ?: false,
                'has_archive'           => isset($option[ 'has_archive' ]) ?: false,
                'publicly_queryable'    => isset($option[ 'publicly_queryable' ]) ?: false,
                'exclude_from_search'   => isset($option[ 'exclude_from_search' ]) ?: false,
                'can_export'            => isset($option[ 'can_export' ]) ?: false,
                'show_ui'               => isset($option[ 'show_ui' ]) ?: false,
                'show_in_rest'          => isset($option[ 'show_in_rest' ]) ?: false,
                'show_in_menu'          => isset($option[ 'show_in_menu' ]) ?: false,
                'show_in_nav_menus'     => isset($option[ 'show_in_nav_menus' ]) ?: false,
                'show_in_admin_bar'     => isset($option[ 'show_in_admin_bar' ]) ?: false,
                'delete_with_user'      => isset($option[ 'delete_with_user' ]) ?: false,
                'hierarchical'          => isset($option[ 'hierarchical' ]) ?: false,
                'capabilities_type'     => array(
                    'edit_post'                 => 'edit_' . $option[ 'post_type' ],
                    'read_post'                 => 'read_' . $option[ 'post_type' ],
                    'delete_post'               => 'delete_' . $option[ 'post_type' ],
                    'edit_posts'                => 'edit_' . $option[ 'post_type' ] . 's',
                    'edit_others_posts'         => 'edit_others_' . $option[ 'post_type' ] . 's',
                    'publish_posts'             => 'publish_' . $option[ 'post_type' ] . 's',
                    'read_private_posts'        => 'read_private_' . $option[ 'post_type' ] . 's',
                    // 'create_posts'          => 'create_penthouses'
                ),
                'menu_position'         => $option[ 'menu_position' ] ?: 6,
                'supports'              => $option['supports'],
                'menu_icon'             => $option[ 'dash_icons' ],
                'taxonomies'            => $option[ 'taxonomies' ]
            );
        
        }

        
    }


    public function registerCustomPostTypes()
    {

        foreach ( $this->custom_post_types as $post_type ) {

            register_post_type( $post_type[ 'post_type' ],
                array(
                    'labels'                => array(
                        'name'                  => $post_type[ 'name' ],
                        'singular_name'         => $post_type[ 'singular_name' ],
                        'plural_name'           => $post_type[ 'plural_name' ],
                        'menu_name'             => $post_type[ 'menu_name' ],
                        'name_admin_bar'        => $post_type[ 'name_admin_bar' ],
                        'add_new'               => $post_type[ 'add_new' ],
                        'add_new_item'          => $post_type[ 'add_new_item' ],
                        'edit_item'             => $post_type[ 'edit_item' ],
                        'new_item'              => $post_type[ 'new_item' ],
                        'view_item'             => $post_type[ 'view_item' ],
                        'view_items'            => $post_type[ 'view_items' ],
                        'search_items'          => $post_type[ 'search_items' ],
                        'not_found'             => $post_type[ 'not_found' ],
                        'not_found_in_trash'    => $post_type[ 'not_found_in_trash' ],
                        'parent_item_colon'     => $post_type[ 'parent_item_colon' ],
                        'all_items'             => $post_type[ 'all_items' ],
                        'archives'              => $post_type[ 'archives' ],
                        'attributes'            => $post_type[ 'attributes' ],
                        'insert_into_item'      => $post_type[ 'insert_into_item' ],
                        'uploaded_to_this_item' => $post_type[ 'uploaded_to_this_item' ],
                        'featured_image'        => $post_type[ 'featured_image' ],
                        'set_featured_image'    => $post_type[ 'set_featured_image' ],
                        'remove_featured_image' => $post_type[ 'remove_featured_image' ],
                        'use_featured_image'    => $post_type[ 'use_featured_image' ],
                        'filter_items_list'     => $post_type[ 'filter_items_list' ],
                        'items_list_navigation' => $post_type[ 'items_list_navigation' ],
                        'items_list'            => $post_type[ 'items_list' ]
                    ),
                    'public'                => $post_type[ 'public' ],
                    'has_archive'           => $post_type[ 'has_archive' ],
                    'show_ui'               => $post_type[ 'show_ui' ],
                    'show_in_rest'          => $post_type[ 'show_in_rest' ],
                    'show_in_menu'          => $post_type[ 'show_in_menu' ],
                    'show_in_nav_menus'     => $post_type[ 'show_in_nav_menus' ],
                    'show_in_admin_bar'     => $post_type[ 'show_in_admin_bar' ],
                    'delete_with_user'      => $post_type[ 'delete_with_user' ],
                    'hierarchical'          => $post_type[ 'hierarchical' ],
                    'publicly_queryable'    => $post_type[ 'publicly_queryable' ],
                    'exclude_from_search'   => $post_type[ 'exclude_from_search' ],
                    'can_export'            => $post_type[ 'can_export' ],
                    'capabilities_type'     => array(
                        'edit_post'             => $post_type[ 'edit_post' ],
                        'read_post'             => $post_type[ 'read_post' ],
                        'delete_post'           => $post_type[ 'delete_post' ],
                        'edit_posts'            => $post_type[ 'edit_posts' ],
                        'edit_others_posts'     => $post_type[ 'edit_others_posts' ],
                        'publish_posts'         => $post_type[ 'publish_posts' ],
                        'read_private_posts'    => $post_type[ 'read_private_posts' ],
                        // 'create_posts'          => 'create_penthouses'
                    ),
                    'menu_position'     => (int)$post_type[ 'menu_position' ],
                    'supports'          => $post_type[ 'supports' ],
                    'menu_icon'         => $post_type[ 'menu_icon' ],
                    'taxonomies'        => $post_type[ 'taxonomies' ],
                    
                ) 
            );

        }


    }


}
