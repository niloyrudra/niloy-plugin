<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Base;


class BaseController
{

    public $plugin_path;

    public $plugin_url;

    public $plugin;

    public $managers = array();

    public function __construct() {
        $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
        $this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
        $this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/niloy-plugin.php';
    
        $this->managers = array(
            'cpt_manager'           => 'Activate CPT Manager',
            'cf_manager'            => 'Activate CF Manager',
            'widget_manager'        => 'Activate Widgets Manager',
            'gallery_manager'       => 'Activate Gallery Manager',
            'testimonial_manager'   => 'Activate Testimonial Manager',
            'taxonomy_manager'      => 'Activate Taxonomy Manager',
            'template_manager'      => 'Activate Custom Templates',
            'login_manager'         => 'Activate Ajax Login/Signup',
            'membership_manager'    => 'Activate Membership Manager',
            'chat_manager'          => 'Activate Chat Manager'
        );

    }

    public function activated( string $key ) {

        $option = get_option( 'niloy_plugin' );

        return isset( $option[ $key ] ) ? $option[ $key ] : false;

    }

}
    