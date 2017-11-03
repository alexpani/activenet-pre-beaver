/**
 * This script adds the parallax effects to the Parallax Pro theme.
 *
 * @package Parallax\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(function( $ ){

	// Enable parallax and fade effects on homepage sections.
	$(window).scroll(function(){

		scrolltop = $(window).scrollTop()
		scrollwindow = scrolltop + $(window).height();

		$(".parallax-top").css("backgroundPosition", "50% " + -(scrolltop/6) + "px");

		if ( $(".parallax").length ) {

			sectionthreeoffset = $(".parallax").offset().top;

			if( scrollwindow > sectionthreeoffset ) {

				// Enable parallax effect.
				backgroundscroll = scrollwindow - sectionthreeoffset;
				$(".parallax").css("backgroundPosition", "50% " + -(backgroundscroll/6) + "px");

			}

		}

		/*

		if ( $(".parallax-3").length ) {

			sectionfiveoffset = $(".parallax-3").offset().top;

			if( scrollwindow > sectionfiveoffset ) {

				// Enable parallax effect.
				backgroundscroll = scrollwindow - sectionfiveoffset;
				$(".parallax-3").css("backgroundPosition", "50% " + -(backgroundscroll/6) + "px");

			}

		}

		*/

	});

});