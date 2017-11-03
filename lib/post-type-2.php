<?php

// Limit post number in home
add_action( 'pre_get_posts',  'change_posts_number_home_page'  );
function change_posts_number_home_page( $query ) {
   if ($query->is_home() && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 4 );
    return $query;
    }
}

// remove pagination in home
add_action ( 'genesis_after_entry', 'sk_remove_pagination' );
function sk_remove_pagination() {
    if ( is_home() ) { 
        remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' ); 
    }
}

add_action( 'get_header', 'post_type_2' );

function post_type_2() {

if ( is_home() || is_category() ) {

	// Custom excerpt length
	function excerpt( $limit ) {
	    return wp_trim_words( get_the_excerpt(), $limit );
	}


	// Register a custom image size for images on category archives
	add_image_size( 'post-image', 640, 416, true );

	add_filter( 'body_class', 'sk_body_class' );
	/**
	 * Adds a css class to the body element
	 *
	 * @param  array $classes the current body classes
	 * @return array $classes modified classes
	 */

	function sk_body_class( $classes ) {				
			$classes[] = 'wide-grid post-type-2';	
			return $classes;		
	}

	// Customize entry meta in the entry header
	// http://my.studiopress.com/docs/shortcode-reference/#post-shortcodes
	add_filter( 'genesis_post_info', 'sp_post_info_filter' );
	function sp_post_info_filter( $post_info ) {
		$post_info = '[post_date]';
		return $post_info;
	}

	// Customize entry meta in the entry footer
	add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
	function sp_post_meta_filter( $post_meta ) {
		$post_meta = '[post_categories before=""]';
		return $post_meta;
	}
	// Function to display featured image (if present), otherwise a default image
	function sk_featured_image() {
		if ( has_post_thumbnail() ) {
			$image = genesis_get_image( 'format=url&size=post-image' );
		} else {
			$image = get_stylesheet_directory_uri() . '/images/default.jpg';
		}
		printf( '<div class="post-image"><a href="%s"><img src="%s" alt="%s" class="alignright" /></a></div>', get_the_permalink(), $image, the_title_attribute( 'echo=0' ) );
	}
	// Remove the image coming from theme settings
	remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
	// Display featured image (if present), otherwise a default image in entry header
	add_action( 'genesis_entry_header', 'sk_featured_image', 7 );
	// Relocate post info above titles
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	add_action( 'genesis_entry_header', 'genesis_post_info', 7 );
	// Relocate post info from entry footer to entry header, above the post title
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	add_action( 'genesis_entry_header', 'genesis_post_meta', 7 );
	// Force excerpts (used for the latest post)
	add_filter( 'genesis_pre_get_option_content_archive', 'sk_show_excerpts' );
	function sk_show_excerpts() {
		return 'excerpts';
	}

	// Remove standard excerpts from the posts in the loop (section below the latest post) and add custom excerpt function
	add_action( 'genesis_before_entry', 'sk_set_content' );
	function sk_set_content() {
		// if this is not the main query, abort.
		if ( !is_main_query() ) {
			return;
		}
		remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
		add_action( 'genesis_entry_content', 'sk_do_post_content' );
	}
	// Display 15 words of excerpt
	function sk_do_post_content() {
		echo excerpt( '15' );
	}
	// Remove the "Sorry, no content matched your criteria." if there's no post in the default loop
	remove_action( 'genesis_loop_else', 'genesis_do_noposts' );
	// Load and initialize matchHeight jQuery script
	wp_enqueue_script( 'match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'match-height-init', get_stylesheet_directory_uri() . '/js/matchheight-init.js', array( 'match-height' ), '1.0.0', true );

	}
}