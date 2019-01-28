<?php

/**
 *  @package niloyPlugin
 */

namespace Inc\Base;



use Inc\Base\Basecontroller;
use Inc\Api\Widgets\MediaWidget;



class WidgetsController extends BaseController
{

    public $meida_widget;

    public function register()
    {

        if( ! $this->activated( 'widget_manager' ) ) return;

        $this->media_widget = new MediaWidget();

        $this->media_widget->register();

    }


}
