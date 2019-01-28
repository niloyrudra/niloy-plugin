<?php

/**
 *  @package niloyPlugin
 */


namespace Inc\Api\Callbacks;


use Inc\Base\Basecontroller;


class TestimonialCallbacks extends BaseController
{

    public function shortcodePage()
    {
        return require_once( "$this->plugin_path/templates/testimonial.php" );
    }

}