<?php

/**
 *  @package niloyPlugin
 */


namespace Inc\Api\Callbacks;


use \Inc\Base\Basecontroller;


class ManagerCallbacks extends BaseController
{
    
    // Sanitize Function
    public function checkboxSanitize( $checkbox )
    {

        // return filter_var( $checkbox, FILTER_SANITIZE_NUMBER_INT );
        // return ( isset( $checkbox ) ? true : false );

        $output = array();

        foreach ($this->managers as $key => $value) {
            $output[ $key ] = isset( $checkbox[ $key ] ) ? true : false;
        }

        return $output;

    }

    public function adminSectionManager()
    {
        echo '<p class="description">Manage the Sections and Features of this Plugin by activating the checkboxes from the following.</p>';
    }

    public function checkboxField( $args )
	{
		$name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args[ 'option_name' ];
        $checkbox = get_option( $option_name );
        
        $checked = isset( $checkbox[$name] ) ? ( $checkbox[$name] ? true : false) : false;
 
		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
	}

}