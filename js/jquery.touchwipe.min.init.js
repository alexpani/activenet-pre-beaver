jQuery(document).ready(function($) {

	$(window).touchwipe({
		wipeLeft: function() {
			// Close
			$.sidr('close', 'sidr-primary-nav');
		},
		wipeRight: function() {
			// Open
			$.sidr('open', 'sidr-primary-nav');
		},
		preventDefaultEvents: false
	});

});