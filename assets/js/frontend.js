(function($) {
	$( '.see-more-text' ).click( function() {
		post_id = ( $(this).parent().parent().parent() ).attr('id');
		$( '#' + post_id + ' .bsf-entry-content.content-open' ).css( 'display', 'block');
		$( '#' + post_id + ' .bsf-entry-content.content-closed' ).css( 'display', 'none');
		$( '#' + post_id + ' .see-more-text' ).css( 'display', 'none');
	});
})(jQuery);
