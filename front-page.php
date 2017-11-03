<?php
/**
 * Infinity Pro.
 *
 * This file adds the front page to the Infinity Pro Theme.
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

//* Add Home Top Sections widget area
add_action( 'genesis_after_header', 'home_top_sections_widget',20 );
	function home_top_sections_widget() {	
		genesis_widget_area( 'home-top-sections', array(
			'before' => '<div class="home-top-sections sections widget-area"><div class="wrap">',
			'after' => '</div></div>',
	) );
}

add_filter( 'genesis_attr_body', 'an_sections_body' );

function an_sections_body( $attributes ) {

	if ( is_active_sidebar( 'home-top-sections' )) {
		 $attributes['class'] .= ' has-home-top-sections';
		 return $attributes;
		}

	else {	
		 return $attributes;
		}

}

//* Add Home Bottom Sections widget area
add_action( 'genesis_before_footer', 'home_bottom_sections_widget',20 );
	function home_bottom_sections_widget() {	
		genesis_widget_area( 'home-bottom-sections', array(
			'before' => '<div class="home-bottom-sections sections widget-area"><div class="wrap">',
			'after' => '</div></div>',
	) );
}

//add_action( 'genesis_meta', 'infinity_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function infinity_front_page_genesis_meta() {	

		// Add front-page body class.
		//add_filter( 'body_class', 'infinity_body_class' );
		function infinity_body_class( $classes ) {

			$classes[] = 'front-page';

			return $classes;

		}		

	}

// Run the Genesis loop.
genesis();
