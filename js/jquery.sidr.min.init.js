jQuery(document).ready(function($) {

	$('#primary-nav-link').sidr({
		name: 'sidr-primary-nav',
		source: '.nav-header' // .nav-header se il sito usa il menu nell'header o #primary-nav-container se usa il primary, anzi .nav-primary
	});

});