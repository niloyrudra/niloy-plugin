import 'code-prettify';
import App from './modules/app.js';

const app = new App();

window.addEventListener( 'load', () => {

    PR.prettyPrint();

    // Store Tabs Variables
    var tabs = document.querySelectorAll( "ul.nav-tabs > li" );

    for( let i = 0; i < tabs.length; i++ ) {
        tabs[i].addEventListener( 'click', switchTab );
    }

    function switchTab(e) {
        e.preventDefault();
        
        var targetTab = e.currentTarget;
        var anchor = e.target
        var targetID = anchor.getAttribute( 'href' );

        document.querySelector( "ul.nav-tabs li.active" ).classList.remove( "active" );
        document.querySelector( ".tab-pane.active" ).classList.remove( "active" );

        targetTab.classList.add( "active" );
        document.querySelector( targetID ).classList.add( "active" );
        
    }

} );

jQuery(document).ready(function ($) {
	$(document).on('click', '.js-image-upload', function (e) {
		e.preventDefault();
		var $button = $(this);

		var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image' // mime type
			},
			button: {
				text: 'Select Image'
			},
			multiple: false
		});

		file_frame.on('select', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.image-upload').val(attachment.url);
		});

		file_frame.open();
	});
});