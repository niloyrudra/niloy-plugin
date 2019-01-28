<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Base;


use \Inc\Base\BaseController;


class Enqueue extends BaseController
{
    
    public function register() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }


    public function enqueue() {

        wp_enqueue_script( 'media-upload' );

        wp_enqueue_media();

        // wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), '4.1.3', 'all' );
        wp_enqueue_style( 'mystyle', $this->plugin_url . 'assets/mystyle.min.css', array(), '1.0.0', 'all' );
        // wp_enqueue_script( 'myscript', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array('jquery'), '3.3.1', true );
        wp_enqueue_script( 'myscript', $this->plugin_url . 'assets/myscript.min.js' );
        wp_enqueue_script( 'myCPTScript', $this->plugin_url . 'assets/cpt.min.js' );
        wp_enqueue_script( 'myCFScript', $this->plugin_url . 'assets/cf.min.js' );
        
    }


}