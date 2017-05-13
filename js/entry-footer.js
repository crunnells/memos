/**
 * File entry-footer.js
 */

( function( $ ) {
	// Apply classnames to visible content options
	$( '.entry-footer' ).each( function() {
		$( this ).children( 'span' ).each( function() {
			var height = $( this ).css( 'height' ),
				width = $( this ).css( 'width' ),
				overflow = $( this ).css( 'overflow' );

			if ( height != '1px' && width != '1px' && overflow != 'hidden' ){
				$( this ).addClass( 'visible' );
			}
		} );
		$( this ).children( '.visible' ).last().addClass( 'last' );
	} );
} )( jQuery );
