<?php

/**
 *  @package niloyPlugin
 */


namespace Inc\Api\Callbacks;


use \Inc\Base\Basecontroller;


class AdminCallbacks extends BaseController
{

    public function adminDashboard()
    {
        return require_once( "$this->plugin_path/templates/admin.php" );
    }
    
    public function adminCptManager()
    {
        return require_once( "$this->plugin_path/templates/CPT.php" );
    }

    public function adminCfManager()
    {
        return require_once( "$this->plugin_path/templates/CF.php" );
    }

    public function adminAjaxLogin()
    {
        return require_once( "$this->plugin_path/templates/ajax_login.php" );
    }

    public function adminChatSys()
    {
        return require_once( "$this->plugin_path/templates/chat_sys.php" );
    }

    public function adminCustomTemplate()
    {
        return require_once( "$this->plugin_path/templates/custom_templates.php" );
    }

    public function adminGallery()
    {
        return require_once( "$this->plugin_path/templates/gallery.php" );
    }

    public function adminMembership()
    {
        return require_once( "$this->plugin_path/templates/membership.php" );
    }

    public function adminTaxonomy()
    {
        return require_once( "$this->plugin_path/templates/taxonomy.php" );
    }

    public function adminTestimonial()
    {
        return require_once( "$this->plugin_path/templates/testimonial.php" );
    }

    public function adminwidget()
    {
        return require_once( "$this->plugin_path/templates/widget.php" );
    }


}