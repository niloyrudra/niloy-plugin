<?php

/**
 *  @package niloyPlugin
 */


namespace Inc;



final class Init
{

    /**
     *  Store all the classes inside an array
     * @return -array full list of classes
     * 
     */
    public static function get_services()
    {

        return [
            Pages\Dashboard::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Base\CustomPostTypeController::class,
            Base\CustomFieldsController::class,
            Base\WidgetsController::class,
            Base\GalleryController::class,
            Base\TestimonialController::class,
            Base\TemplatesController::class,
            Base\CustomTaxonomyController::class,
            Base\AuthController::class,
            Base\MembershipController::class,
            Base\ChatSysController::class
        ];

    }

    /**
     *  Loop through the classes, initialize them, and call the register()
     *  method if it exists 
     */
    public static function register_services()
    {

        foreach ( self::get_services() as $class ) {

            $service = self::instantiate( $class );

            if( method_exists( $service, 'register' ) ) {
                $service->register();
            }

        }

    }

    /**
     *  Initialize the Class
     * @param -class $class     class from the services array
     * @return -class instance  new instance of the class
     */
    private static function instantiate( $class )
    {

        $service = new $class();

        return $service;

    }

    
}

