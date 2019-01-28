<?php

/**
 *  @package niloyPlugin
 */


namespace Inc\Api\Callbacks;



class CfCallbacks
{

    
    public function cfSanitize( $input )
    {



		// var_dump($input);
		// return;

		// $output = get_option('niloy_plugin_cf');


		// if ( isset($_POST["remove"]) ) {
		// 	unset($output[$_POST["remove"]]);

			// return $output;
		// }

		// if ( count($output) == 0 ) {
		// 	$output[$input['post_type']] = $input;

		// 	return $output;
		// }

		// foreach ($output as $key => $value) {
		// 	if ($input['post_type'] === $key) {
		// 		$output[$key] = $input;
		// 	} else {
		// 		$output[$input['post_type']] = $input;
		// 	}
		// }
		
		return $input;
		
    }


    public function cfSectionManager()
    {
        echo '<p class="description">Manage your Custom Fields.</p>';
    }

    public function textField( $args )
	{

        $name = $args['label_for'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );
		
		// $value = $input[$name];

		// $option = get_option( 'niloy_plugin_cf' );
		
		// $value = isset($input[ $name ]) ? $input[ $name ] : '';
		// $value = $input[ $name ];


		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="" placeholder="' . $args[ 'placeholder' ] . '" /><label for="' . $name . '"></label>';


	}

	// function sunset_sidebar_name() {
	// 	$firstName = esc_attr( get_option( 'first_name' ) );
	// 	$lastName = esc_attr( get_option( 'last_name' ) );
	
	// 	echo '<input type="type" name="first_name" value="'.$firstName.'" placeholder="First Name" /> <input type="type" name="last_name" value="'.$lastName.'" placeholder="Last Name" />';
	// }
	


	// function sunset_post_formats() {
	// 	$options = get_option( 'post_formats' );
	// 	$formats = array( 'aside', 'gallery', 'quote', 'video', 'audio', 'image', 'link', 'status', 'chat' );
	// 	$output = '';
	// 	foreach( $formats as $format ) {
	// 		$checked = ( @$options[ $format ] == 1 ? 'checked' : '' );
	// 		$output .= '<label><input type="checkbox" id="' . $format . '" name="post_formats[' . $format . ']" value="1" '. $checked .' /> ' . $format . '</label><br>';
	// 	}
	// 	echo $output;
	// }


	public function dropDownField( $args )
	{
		    
		$related_posts = get_post_types( array( 'show_ui' => true ) );

		$name = $args['label_for'];
		$option_name = $args['option_name'];
		
		// if( isset( $_POST[ 'edit_post' ] ) ) {

		// 	$input = get_option( $option_name );
		// 	$value = $input[ $_POST[ 'edit_post' ] ][ $name ];
			
		// }

		echo '<select name="' . $option_name . '[' . $name . ']">';

        foreach ( $related_posts as $related_post ) {

            echo '<option value="' . $related_post . '" ' . $selected . '>' . $related_post . '</option>';
		}
		
		echo '</select>';




	}


	// public function radioField( $args )
	// {

	// 	$name = $args['label_for'];
	// 	$option_name = $args['option_name'];

	// 	if( isset( $_POST[ 'edit_post' ] ) ) {
	// 		$radio = get_option( $option_name );
	// 	}


	// 	$supports = array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'post-formats', 'comments', 'page-attributes', 'trackbacks', 'custom-fields', 'revisions' );

	// 	$output = '';

	// 	foreach ($supports as $support) {

	// 		if( isset( $_POST[ 'edit_post' ] ) ) {

	// 			$value = $radio[ $_POST[ 'edit_post' ] ][ $name ][$support];
	// 		}

	// 		$output .= '<input type="radio" name="' . $option_name . '[' . $name . '][' . $support . ']" value="' . $support . '"> <span class="description">' . $support . '</span> ';

	// 	}


	// 	echo $output;
		
	// }

	// public function multiCheckboxField( $args )
	// {
	// 	$name = $args['label_for'];
	// 	$classes = $args['class'];
	// 	$option_name = $args['option_name'];

	// 	$supports = array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'post-formats', 'comments', 'page-attributes', 'trackbacks', 'custom-fields', 'revisions' );

	// 	$output = '';

	// 	foreach( $supports as $support ) {
	// 		$checked = ( @$option_name[ $support ] == 1 ? 'checked' : '' );
	// 		$output .= '<label><input type="checkbox" id="' . $support . '" name="' . $option_name . '[' . $support . ']" value="1" '. $checked .' /> ' . $support . '</label><br>';
	// 	}
		
	// 	echo $output;
	// }

    // public function checkboxField( $args )
	// {

	// 	$name = $args['label_for'];
	// 	$classes = $args['class'];
	// 	$option_name = $args['option_name'];
		
	// 	$checked = false;

	// 	if( isset( $_POST[ 'edit_post' ] ) ) {

	// 		$checkbox = get_option( $option_name );
	// 		$checked = isset( $checkbox[ $_POST[ 'edit_post' ] ][ $name ] ) ?: false;

	// 	}

	// 	echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';

	// }


}