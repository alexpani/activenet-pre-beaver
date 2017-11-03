<?php
/**
 * Woocommerce for Active Net framework
 *
 * Nota: Tutti gli hook si trovano su includes/wc-template-hooks.php
 */

//* Explicitly declare WooCommerce Support
add_action( 'after_setup_theme', 'wsm_woocommerce_support' );
function wsm_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

//* Add Active Net styles
function wp_enqueue_woocommerce_style(){
	wp_register_style( 'poppy-woocommerce', get_stylesheet_directory_uri() . '/woocommerce/css/an_woocommerce.css' );	
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'poppy-woocommerce' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );

//* Add support for WooCommerce 3.0 gallery feature
add_action( 'after_setup_theme', 'yourtheme_setup' );
function yourtheme_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

/* Print an inline script to the footer to keep elements at the same height.
*  Usage: assign .match-height class to the elements
*/
add_action( 'wp_enqueue_scripts', 'activenet_match_height', 99 );
function activenet_match_height() {
	// If Woocommerce is not activated exit early
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	wp_enqueue_script( 'activenet-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_add_inline_script( 'activenet-match-height', "jQuery(document).ready( function() { jQuery( '.match-height').matchHeight(); });" );
}

//* Add subcategories widget area
genesis_register_sidebar( array(
	'id'            => 'subcategories',
	'name'          => __( 'Subcategories', 'poppy' ),
	'description'   => __( 'Subcategories above products', 'poppy' ),
) );

add_action( 'woocommerce_before_shop_loop', 'subcategories_widget',10 );
	function subcategories_widget() {	
		genesis_widget_area( 'subcategories', array(
			'before' => '<div class="subcategories widget-area"><div class="wrap">',
			'after' => '</div></div>',
	) );
}

//* Force Fullwidth in some page
function poppy_fullwidth() {
    if( 'product' == get_post_type()&&is_single()||is_page('carrello')||is_page('mio-account')||is_page('checkout')) {
        return 'full-width-content';
    }
}
add_filter( 'genesis_site_layout', 'poppy_fullwidth' );

//* Reposition star rating after price in single product pages
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

//* Change number of related products on product page
add_filter( 'woocommerce_output_related_products_args', 'an_related_products_args' );
  function an_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // spreaded in 4 columns
	return $args;
}

//* Reposition the Genesis Simple Share buttons in WooCommerce Products
add_action( 'woocommerce_single_product_summary', 'wpb_reposition_simple_share_product', 50 );
function wpb_reposition_simple_share_product() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
 	if (is_plugin_active('genesis-simple-share/plugin.php')) {
 		global $Genesis_Simple_Share;
 		echo genesis_share_icon_output( 'product', $Genesis_Simple_Share->icons  ); //output the default icons as set in the plugin settings - and the first parameter 'product' forms the CSS name
	}
}

/**
 * Place a cart icon with number of items and total cost in the menu bar.
 *
 * Source: http://wordpress.org/plugins/woocommerce-menu-bar-cart/
 */
add_filter('wp_nav_menu_items','sk_wcmenucart', 10, 2);
function sk_wcmenucart($menu, $args) {

	// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'primary' !== $args->theme_location )
		return $menu;

	ob_start();
		global $woocommerce;
		$viewing_cart = __('Vedi il carrello', 'poppy');
		$start_shopping = __('Inizia ad acquistare', 'poppy');
		$cart_url = $woocommerce->cart->get_cart_url();
		$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		$cart_contents = sprintf(_n('%d prodotto', '%d prodotti', $cart_contents_count, 'poppy'), $cart_contents_count);
		$cart_total = $woocommerce->cart->get_cart_total();
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// if ( $cart_contents_count > 0 ) {
			if ($cart_contents_count == 0) {
				$menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
			} else {
				$menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
			}

			$menu_item .= '<i class="fa fa-shopping-cart"></i> ';

			$menu_item .= $cart_contents.' - '. $cart_total;
			$menu_item .= '</a></li>';
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// }
		echo $menu_item;
	$social = ob_get_clean();
	return $menu . $social;
}

//* Disable these, if you don't use WooCommerce Quantity Increment plugin
add_action( 'wp_enqueue_scripts', 'wcqi_enqueue_polyfill' );
function wcqi_enqueue_polyfill() {
    wp_enqueue_script( 'wcqi-number-polyfill' );
}
add_action( 'wp_enqueue_scripts', 'wcs_dequeue_quantity' );
function wcs_dequeue_quantity() {
    wp_dequeue_style( 'wcqi-css' );
}

//* Customize the search field
add_filter( 'get_product_search_form' , 'woo_custom_product_searchform' );

function woo_custom_product_searchform( $form ) {	
	$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div>
			<label class="screen-reader-text" for="s">' . __( 'Search for:', 'woocommerce' ) . '</label>
			<input class="search-box" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Cerca un prodotto', 'woocommerce' ) . '" />
			<button class="button button-search" type="submit" id="searchsubmit" value="Irrilevante" />
			<input type="hidden" name="post_type" value="product" />
		</div>
	</form>';	
	return $form;	
}