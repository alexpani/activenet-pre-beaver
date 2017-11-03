<?php
/**
 * Active Net.
 *
 * This file adds the default theme settings to the theme.
 *
 * @package Active Net
 * @author  Active Net
 * @license GPL-2.0+
 * @link    https://www.active-net.it
 */

add_filter( 'genesis_theme_settings_defaults', 'activenet_theme_defaults' );
/**
* Updates theme settings on reset.
*
* @since 2.2.3
*/
function activenet_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 20;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 100;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'full-width';

	return $defaults;

}

add_action( 'after_switch_theme', 'genesis_sample_theme_setting_defaults' );
/**
* Updates theme settings on activation.
*
* @since 2.2.3
*/
function genesis_sample_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 20,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 100,
			'content_archive_thumbnail' => 1,
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width',
		) );
		
	} 

	update_option( 'posts_per_page', 20 );

}