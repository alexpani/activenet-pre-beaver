jQuery(function( $ ){

	if ( $(window).width() > 500 ) {
		$('.category .content .entry').matchHeight();
		$('.home.blog .content .entry').matchHeight();
	}

});