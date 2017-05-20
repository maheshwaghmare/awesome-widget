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
