<?php

/**
 *  @package niloyPlugin
 */


namespace Inc\Base;

class Activate
{

    public static function activate() {

        flush_rewrite_rules();

        
        $default = array();

        if( ! get_option( 'niloy_plugin' ) ) {
            update_option( 'niloy_plugin', $default );
        }

        
        if( ! get_option( 'niloy_plugin_cpt' ) ) {
            update_option( 'niloy_plugin_cpt', $default );
        }

        if( ! get_option( 'niloy_plugin_taxonomy' ) ) {
            update_option( 'niloy_plugin_taxonomy', $default );
        }
        

    }

}