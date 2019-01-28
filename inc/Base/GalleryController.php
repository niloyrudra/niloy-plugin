<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Base;


use \Inc\Api\SettingsApi;
use \Inc\Base\Basecontroller;
use \Inc\Api\Callbacks\AdminCallbacks;


class GalleryController extends BaseController
{

    public $settings;

    public $callbacks;

    public $subpages = array();

    public function register()
    {

        if( ! $this->activated( 'gallery_manager' ) ) return;


        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setSubpages();

        $this->settings->addSubPages( $this->subpages )->register();

    }

    public function setSubpages() {

        $this->subpages = array(
            array(
                'parent_slug'   => 'niloy_plugin',
                'page_title'    => 'Niloy Gallery',
                'menu_title'    => 'Gallery Manager',
                'capability'    => 'manage_options',
                'menu_slug'     => 'niloy_gallery',
                'page_callback' => array( $this->callbacks, 'adminGallery' )
            )

            // array(
            //     'parent_slug'   => 'niloy_plugin',
            //     'page_title'    => 'Niloy Taxonomy',
            //     'menu_title'    => 'Taxonomy Manager',
            //     'capability'    => 'manage_options',
            //     'menu_slug'     => 'niloy_taxonomy',
            //     'page_callback' => array( $this->callbacks, 'adminTaxonomy' )
            // ),
            // array(
            //     'parent_slug'   => 'niloy_plugin',
            //     'page_title'    => 'Niloy Testimonial',
            //     'menu_title'    => 'Testimonial Manager',
            //     'capability'    => 'manage_options',
            //     'menu_slug'     => 'niloy_testimonial',
            //     'page_callback' => array( $this->callbacks, 'adminTestimonial' )
            // ),
            // array(
            //     'parent_slug'   => 'niloy_plugin',
            //     'page_title'    => 'Niloy Membership',
            //     'menu_title'    => 'Membership Manager',
            //     'capability'    => 'manage_options',
            //     'menu_slug'     => 'niloy_membership',
            //     'page_callback' => array( $this->callbacks, 'adminMembership' )
            // ),
            
            
            // array(
            //     'parent_slug'   => 'niloy_plugin',
            //     'page_title'    => 'Niloy Custom Template',
            //     'menu_title'    => 'Custom Template Manager',
            //     'capability'    => 'manage_options',
            //     'menu_slug'     => 'niloy_custom_templates',
            //     'page_callback' => array( $this->callbacks, 'adminCustomTemplate' )
            // ),
            // array(
            //     'parent_slug'   => 'niloy_plugin',
            //     'page_title'    => 'Niloy Login',
            //     'menu_title'    => 'Login Manager',
            //     'capability'    => 'manage_options',
            //     'menu_slug'     => 'niloy_ajax_login',
            //     'page_callback' => array( $this->callbacks, 'adminAjaxLogin' )
            // ),
            // array(
            //     'parent_slug'   => 'niloy_plugin',
            //     'page_title'    => 'Niloy Chat System',
            //     'menu_title'    => 'Chat System Manager',
            //     'capability'    => 'manage_options',
            //     'menu_slug'     => 'niloy_chat',
            //     'page_callback' => array( $this->callbacks, 'adminChatSys' )
            // )
        );

    }



}
