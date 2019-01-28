<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Pages;


use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\ManagerCallbacks;



class Dashboard extends BaseController
{
    
    public $settings;

    public $callbacks;

    public $callback_managers;

    public $pages = array();

    // public $subpages = array();


    public function register() {

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->callback_managers = new ManagerCallbacks();

        $this->setPages();

        // $this->setSubpages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();




        // $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
        $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->register();

    }
    

    public function setPages() {

        $this->pages = array(
            array(
                'page_title'    => 'Niloy Plugin',
                'menu_title'    => 'Niloy',
                'capability'    => 'manage_options',
                'menu_slug'     => 'niloy_plugin',
                'page_callback' => array( $this->callbacks, 'adminDashboard' ),
                'icon_url'      => 'dashicons-store',
                'position'      => 110 
            )
        );

    }


    public function setSettings()
    {

        $args = array(
            array(
				'option_group' => 'niloy_plugin_settings',
				'option_name' => 'niloy_plugin',
                'callback'          => array( $this->callback_managers, 'checkboxSanitize' )
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
                'id'                => 'admin_index_section',
                'title'             => 'Settings Manager',
                'callback'          => array( $this->callback_managers, 'adminSectionManager' ),
                'page'              => 'niloy_plugin'
            )
        );

        $this->settings->setSections( $args );

    }

        
    public function setFields()
    {

        $args = array();

        foreach ($this->managers as $key => $title) {
            $args[] = array(
                    'id'                => $key,
                    'title'             => $title,
                    'callback'          => array( $this->callback_managers, 'checkboxField' ),
                    'page'              => 'niloy_plugin',
                    'section'           => 'admin_index_section',
                    'args'              => array(
                        'option_name'       => 'niloy_plugin',
                        'label_for'         => $key,
                        'class'             => 'ui-toggle'
                    )
                );
        }
        
        $this->settings->setFields( $args );

    }


}
