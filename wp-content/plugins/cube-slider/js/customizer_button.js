jQuery(document).ready(function() {

	jQuery( "#sortable" ).sortable();
	
	jQuery( "#sortable" ).disableSelection();
	
	jQuery('.wp-full-overlay-sidebar-content').prepend('<a style="margin-top: 5px;margin-bottom: 5px; margin-left: 93px;"href="http://extendyourweb.com/" class="button" target="_blank">{documentation}</a>'.replace('{documentation}',objectL10n.documentation));
	
	jQuery( '.ui-state-default' ).on( 'mousedown', function() {

		jQuery( '#customize-header-actions #save' ).trigger( 'click' );

	});
	
});