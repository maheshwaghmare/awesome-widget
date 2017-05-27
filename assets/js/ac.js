/**
 * Accordion
 */
jQuery( document ).on( 'widget-updated widget-added', function() {
	awesome_widget_accordion_setup();
});

jQuery( document ).ready(function($) {
	awesome_widget_accordion_setup();
});

function awesome_widget_accordion_setup() {

	// jQuery(".accordion").accordion();
	jQuery(".aw-accordion").accordion( {
		header: ".aw-accordion-section h3",
		collapsible: true
	} );

}

/**
 *	Field - ColorPicker
 */
jQuery(document).on('widget-updated widget-added', function(){
    awesome_widgets_colorpicker();
});
jQuery(document).ready(function($) {
	awesome_widgets_colorpicker();
});
function awesome_widgets_colorpicker() {

	// Check 'wpColorPicker' function exist
	if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ){
		jQuery('#widgets-right .aw-colorpicker').wpColorPicker();
	}
}
