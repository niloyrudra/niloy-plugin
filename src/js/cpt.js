
jQuery(document).ready(function($) {

    $(document).find( '.dashicons-container .icon-content' ).on( 'click', function(e) {
        
        var iconHolder = $( '.selected-icon span' );
 
        iconHolder.removeAttr( 'class' );

        var value = e.target.className.split('').slice( 10 ).join('');
            iconHolder.addClass( 'dashicons ' + value );

       
        $(document).find( 'input[name="niloy_plugin_cpt[dash_icons]"]' ).val(value);
        
        
    } );

});