<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Base;


use \Inc\Api\SettingsApi;
use \Inc\Base\Basecontroller;
use \Inc\Api\Callbacks\AdminCallbacks;


class MembershipController extends BaseController
{

    public $settings;

    public $callbacks;

    public $subpages = array();

    public function register()
    {

        if( ! $this->activated( 'membership_manager' ) ) return;


        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setSubpages();

        $this->settings->addSubPages( $this->subpages )->register();

    }

    public function setSubpages() {

        $this->subpages = array(
            array(
                'parent_slug'   => 'niloy_plugin',
                'page_title'    => 'Niloy Membership',
                'menu_title'    => 'Membership Manager',
                'capability'    => 'manage_options',
                'menu_slug'     => 'niloy_membership',
                'page_callback' => array( $this->callbacks, 'adminMembership' )
            )

            
            
            
            
            
            
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
