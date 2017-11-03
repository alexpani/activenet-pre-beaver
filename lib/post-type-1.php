<?php
/*
Mettiamo in colonne il blog
---------------------------------------------------------------------------------------------------- */

/**
 * Custom Genesis Home Loop with Character Limitation on Excerpt
 *
 * @package   Custom Genesis Home Loop with Character Limitation on Excerpt
 * @author    Neil Gee
 * @link      https://wpbeaches.com/custom-genesis-standard-loop-blog-page/
 * @copyright (c)2014, Neil Gee
 */
 
add_action('genesis_before_loop', 'wpb_change_home_loop');
/*
 * Adding in our new home loop.
 */
function wpb_change_home_loop() {
if ( is_home() || is_category() ) {

//* Add class to .entry
add_filter('genesis_attr_entry', 'jive_attributes_st_container');
function jive_attributes_st_container($attributes) {
	$attributes['class'] .= ' element match-height post-type-1'; // La figata è che matcheight risolve anche il problema del float delle colonne e non serve 'first'
	//$attributes['data-anijs'] .= 'if: click, do: $remove, to: target';
	return $attributes;
}

/** Replace the home loop with our custom **/
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'wpb_custom_loop' );

/** Custom  loop **/
function wpb_custom_loop() {
if ( have_posts() ) :

		do_action( 'genesis_before_while' );
		while ( have_posts() ) : the_post();

			do_action( 'genesis_before_entry' );

			genesis_markup( array(
				'open'    => '<article %s>',
				'context' => 'entry',
			) );

			echo genesis_do_post_image(); //Add in featured image

				do_action( 'genesis_entry_header' );

				do_action( 'genesis_before_entry_content' );

				printf( '<div %s>', genesis_attr( 'entry-content' ) );

				//do_action( 'genesis_entry_content' ); //Remove standard excerpt
 
				 
				 
				 echo the_excerpt_max_charlength(100); //change amount of characters to display
				
				echo '</div>';

				do_action( 'genesis_after_entry_content' );

				//do_action( 'genesis_entry_footer' );

			genesis_markup( array(
				'close'   => '</article>',
				'context' => 'entry',
			) );

			do_action( 'genesis_after_entry' );

		endwhile; // End of one post.
		do_action( 'genesis_after_endwhile' );

	else : // If no posts exist.
		do_action( 'genesis_loop_else' );
	endif; // End loop.

}

	}
}
/*
 * Limit the excerpt by character.
 *
 * @link Reference - http://codex.wordpress.org/Function_Reference/get_the_excerpt
 */
function the_excerpt_max_charlength($charlength) {

	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		//echo ' <br><a href="' . get_permalink() . '" class="button button-xsmall" title="Leggi tutto">Leggi tutto</a>';
		echo ' <br><a href="' . get_permalink() . '" class="more-link" title="Leggi tutto">Leggi tutto <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';
	} else {
		echo $excerpt;
	}
}