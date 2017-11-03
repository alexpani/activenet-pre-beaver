<?php

// Add specific class to header
add_filter( 'genesis_attr_site-header', 'atp_new_header_class' );
function atp_new_header_class( $attributes ) {
 $attributes['class'] = 'site-header header-logo-mid-right';
return $attributes;
}

// Register Header Middle widget area
genesis_register_widget_area(
    array(
        'id'          => 'header-middle',
        'name'        => __( 'Header Middle', 'my-theme-text-domain' ),
        'description' => __( 'This is the header middle widget area', 'my-theme-text-domain' ),
    )
);
 
// Add "one-third" and "first" classes to .title-area
add_filter( 'genesis_attr_title-area', function ( $attributes ) {
    $attributes['class'] .= ' one-third first';
 
    return $attributes;
} );
 
 
// Add "one-third" class to .header-widget-area
add_filter( 'genesis_attr_header-widget-area', 'sk_attributes_one_third' );
function sk_attributes_one_third( $attributes ) {
    $attributes['class'] .= ' one-third';
 
    return $attributes;
}

 
// Re-write default Genesis header
remove_action( 'genesis_header', 'genesis_do_header' );
add_action( 'genesis_header', 'sk_do_header' );
/**
 * Echo the default header, including the #title-area div, along with #title and #description, as well as the middle and right widget areas.
 *
 * Does the `genesis_site_title`, `genesis_site_description` and `genesis_header_right` actions.
 *
 * @since 1.0.2
 *
 * @global $wp_registered_sidebars Holds all of the registered sidebars.
 *
 * @uses genesis_markup() Apply contextual markup.
 */
function sk_do_header() {
 
    global $wp_registered_sidebars;
 
    genesis_markup( array(
        'html5'   => '<div %s>',
        'xhtml'   => '<div id="title-area">',
        'context' => 'title-area',
    ) );
    do_action( 'genesis_site_title' );
    do_action( 'genesis_site_description' );
    echo '</div>';
 
    genesis_widget_area( 'header-middle', array(
        'before'    => '<div class="widget-area header-middle one-third">',
        'after'     => '</div>',
    ) );
 
    if ( ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) || has_action( 'genesis_header_right' ) ) {
 
        genesis_markup( array(
            'html5'   => '<div %s>' . genesis_sidebar_title( 'header-right' ),
            'xhtml'   => '<div class="widget-area header-widget-area">',
            'context' => 'header-widget-area',
        ) );
 
            do_action( 'genesis_header_right' );
            add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
            add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
            dynamic_sidebar( 'header-right' );
            remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
            remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
 
        echo '</div>';
 
    }
 
}