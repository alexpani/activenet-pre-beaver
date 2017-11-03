/**
 * This script adds the jquery effects to the Infinity Pro Theme.
 *
 * @package Infinity\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

( function($) {

	var $body         = $( 'body' ),
		$content      = $( '.offscreen-content' ),
		$widgetArea   = $( '.widget-area'),
		headerHeight  = $( '.site-header' ).height(),
		$siteHeader   = $( '.site-header' ),
		$siteInner    = $( '.site-inner' ),
		sOpen         = false,
		windowHeight  = $(window).height();

	

	// Add white class to site container after 50px.
	$(document).on( 'scroll', function() {

		if ( $(document).scrollTop() > 50 ) {
			$( '.site-header' ).addClass( 'white' );

		} else {
			$( '.site-header' ).removeClass( 'white' );
		}

	});

	// Push the .site-inner down dependant on the header height.
	if ( (! $body.hasClass( 'sections' ) && (! $widgetArea.hasClass( 'home-top-sections' ))) || !('fixed' == __getPositionValue( '.site-header' ))) {

		__repositionSiteHeader( headerHeight, $siteInner );

		$(window).resize(function() {

			// Update header height value.
			headerHeight = $siteHeader.height();
			__repositionSiteHeader( headerHeight, $siteInner );

		});

	}


		

	// Function to get the CSS value of the position property of the passed element.
	function __getPositionValue( selector ) {

		var position = $( selector ).css( 'position' );

		return position;

	}

	// Function to position the site header.
	function __repositionSiteHeader( headerHeight, $siteInner ) {

		
			$siteInner.css( 'margin-top', headerHeight + 'px' );
		

	}

})(jQuery);
