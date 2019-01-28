<?php

/**
 *  @package niloyPlugin
 */


namespace Inc\Api\Callbacks;



class CptCallbacks
{

    
    public function cptSanitize( $input )
    {

		$output = get_option('niloy_plugin_cpt');

		if ( isset($_POST["remove"]) ) {
			unset($output[$_POST["remove"]]);

			return $output;
		}

		if ( count($output) == 0 ) {
			$output[$input['post_type']] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ($input['post_type'] === $key) {
				$output[$key] = $input;
			} else {
				$output[$input['post_type']] = $input;
			}
		}
		
		return $output;
		
    }


    public function cptSectionManager()
    {
        echo '<p class="description">Manage your Custom Post Types.</p>';
    }

    public function textField( $args )
	{

		$name = $args['label_for'];
		$option_name = $args['option_name'];
		
		$value = '';
 
		if( isset( $_POST[ 'edit_post' ] ) ) {

			$input = get_option( $option_name );
			$value = $input[ $_POST[ 'edit_post' ] ][ $name ];
			$disabled = ($name === 'post_type' ? 'disabled' : '' );
			$readonly = ($name === 'post_type' ? 'readonly' : '' );
	
		}

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required ' . $readonly . ' />';

	}



	// protected function selected( $selected, $current = true, $echo = true ) {
	// 	return __checked_selected_helper( $selected, $current, $echo, 'selected' );
	// }
	
	public function optionField( $args )
	{
		$values = array( 6, 7, 8, 9, 11, 12, 13, 14, 16, 17, 18, 19, 21, 22, 23, 24, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58 );

		$name = $args['label_for'];
		$option_name = $args['option_name'];
		
		if( isset( $_POST[ 'edit_post' ] ) ) {

			$input = get_option( $option_name );
			$updated_value = (int)$input[ $_POST[ 'edit_post' ] ][ $name ];
			
		}

		echo '<select name="' . $option_name . '[' . $name . ']">';

		foreach( $values as $value ): ?>
			<option value="<?php echo $value; ?>" <?php if( $value === $updated_value ) {echo 'selected="selected"';} ?>><?php echo $value; ?></option>
		<?php
		endforeach;

		echo '</select>';

		echo "<span class=\"description\"> Your selected Menu Position was: <strong>" . ( $updated_value ? $updated_value : 'NOT DEFINED!') . '</strong></span>';  // Displaying Selected Value
		?>

		<?php
	}

	public function multiRadioField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];

		$supports = array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'post-formats', 'comments', 'page-attributes', 'trackbacks', 'custom-fields', 'revisions' );

		$checked = false;

		if( isset( $_POST[ 'edit_post' ] ) ) {
			$radio = get_option( $option_name );
		}

		foreach ($supports as $support) {
			if( isset( $_POST[ 'edit_post' ] ) ) {
				$checked = isset( $radio[ $_POST[ 'edit_post' ] ][ $name ][ $support ] ) ?: false;
			}
	
			echo '<input type="radio" name="' . $option_name . '[' . $name . '][' . $support . ']" id="' . $name . '" value="' . $support . '" ' . ( $checked ? 'checked' : '' ) . ' /> <label for="' . $name . '"><span class="description capitalize">' . $support . '</span></label><br/>';
		}

	}

    public function checkboxField( $args )
	{

		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		
		$checked = false;

		if( isset( $_POST[ 'edit_post' ] ) ) {

			$checkbox = get_option( $option_name );
			$checked = isset( $checkbox[ $_POST[ 'edit_post' ] ][ $name ] ) ?: false;

		}

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';

	}

	public function radioFieldTax( $args )
	{

		$name = $args['label_for'];
		$option_name = $args['option_name'];

		$taxonomies = get_taxonomies();

		$checked = false;

		if( isset( $_POST[ 'edit_post' ] ) ) {
			$radio = get_option( $option_name );
		}

		foreach ($taxonomies as $taxonomy) {
			if( isset( $_POST[ 'edit_post' ] ) ) {
				$checked = isset( $radio[ $_POST[ 'edit_post' ] ][ $name ][ $taxonomy ] ) ?: false;
			}
			echo '<input type="radio" name="' . $option_name . '[' . $name . '][' . $taxonomy . ']" id="' . $name . '" value="' . $taxonomy .  '" ' . ( $checked ? 'checked' : '' ) . ' /> <span class="description capitalize">' . str_replace( '_', ' ',  $taxonomy ) .  '</span><br/>';
		}

	}


	public function checkboxFieldforDashicons( $args )
	{

		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$icons = array( 'menu', 'admin-site', 'dashboard', 'admin-post', 'admin-media', 'admin-links', 'admin-appearance', 'admin-comments', 'admin-page', 'admin-plugins', 'admin-users', 'admin-tools', 'admin-settings', 'admin-network', 'admin-home', 'admin-generic', 'admin-collapse', 'filter', 'admin-customizer', 'admin-multisite', 'welcome-write-blog', 'welcome-add-page', 'welcome-view-site', 'welcome-widgets-menus', 'welcome-comments', 'welcome-learn-more', 'format-aside', 'format-image', 'format-gallery', 'format-video', 'format-status', 'format-quote', 'format-chat', 'format-audio', 'camera', 'images-alt', 'images-alt2', 'video-alt', 'video-alt2', 'video-alt3', 'media-archive', 'media-audio', 'media-code', 'media-default', 'media-document', 'media-interactive', 'media-spreadsheet', 'media-text', 'media-video', 'playlist-audio', 'playlist-video', 'controls-play', 'controls-pause', 'controls-forward', 'controls-skipforward', 'controls-repeat', 'controls-back', 'controls-skipback', 'controls-volumeon', 'controls-volumeoff', 'image-crop', 'image-rotate', 'image-rotate-left', 'image-rotate-right', 'image-flip-vertical', 'image-flip-horizontal', 'image-filter', 'undo', 'redo', 'image-crop', 'editor-italic', 'editor-ol', 'editor-quote', 'editor-aligncenter', 'editor-alignleft', 'editor-alignright', 'editor-insertmore', 'editor-spellcheck', 'editor-expand', 'editor-contract', 'editor-kitchensink', 'editor-underline', 'editor-justify', 'editor-textcolor', 'editor-paste-word', 'editor-paste-text', 'editor-removeformatting', 'editor-video', 'editor-customchar', 'editor-outdent', 'editor-indent', 'editor-help', 'editor-strikethrough', 'editor-unlink', 'editor-rtl', 'editor-break', 'editor-code', 'editor-paragraph', 'editor-table', 'align-left', 'align-right', 'align-center', 'align-none', 'lock', 'unlock', 'calendar', 'calendar-alt', 'visibility', 'hidden', 'post-status', 'edit', 'trash', 'sticky', 'external', 'arrow-up', 'arrow-down', 'arrow-right', 'arrow-left', 'arrow-up-alt', 'arrow-down-alt', 'arrow-right-alt', 'arrow-left-alt', 'arrow-up-alt2', 'arrow-down-alt2', 'arrow-right-alt2', 'arrow-left-alt2', 'sort', 'leftright', 'randomize', 'list-view', 'exerpt-view', 'grid-view', 'move', 'share', 'share-alt', 'share-alt2', 'twitter', 'rss', 'email', 'email-alt', 'facebook', 'facebook-alt', 'googleplus', 'networking', 'hammer', 'art', 'migrate', 'performance', 'universal-access', 'universal-access-alt', 'tickets', 'nametag', 'clipboard', 'heart', 'megaphone', 'schedule', 'wordpress', 'wordpress-alt', 'pressthis', 'update', 'screenoptions', 'info', 'cart', 'feedback', 'cloud', 'translation', 'tag', 'category', 'archive', 'tagcloud', 'text', 'yes', 'no', 'no-alt', 'plus', 'plus-alt', 'minus', 'dismiss', 'marker', 'star-filled', 'star-half', 'star-empty', 'flag', 'warning', 'location', 'location-alt', 'vault', 'shield', 'shield-alt', 'sos', 'search', 'slides', 'analytics', 'chart-pie', 'chart-bar', 'chart-line', 'chart-area', 'groups', 'businessman', 'id', 'id-alt', 'products', 'awards', 'portfolio', 'forms', 'testimonial', 'book', 'book-alt', 'download', 'upload', 'backup', 'clock', 'lightbulb', 'microphone', 'desktop', 'laptop', 'tablet', 'smartphone', 'phone', 'index-card', 'carrot', 'building', 'store', 'album', 'palmtree', 'tickets-alt', 'money', 'smiley', 'thumbs-up', 'thumbs-down', 'layout', 'paperclip' );
		
		$value = '';
 
		if( isset( $_POST[ 'edit_post' ] ) ) {
			$input = get_option( $option_name );
			$value = $input[ $_POST[ 'edit_post' ] ][ $name ];
		}

		echo '<input type="hidden" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" />';
		echo '<div class="selected-icon"><span class="dashicons' . ' ' . $value . '"></span></div><div class="dashicons-container"><div class="icon-content">';

		foreach ($icons as $icon) {
			echo '<span class="dashicons dashicons-' . $icon . '"></span>';
		}
		
		echo '</div></div>';

	}

}