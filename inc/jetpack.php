<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.me/
 *
 * @package Memos
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function memos_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'memos_infinite_scroll_render',
		'footer'    => 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menus
	add_theme_support( 'jetpack-social-menu' );

	// Add theme support for content options
	add_theme_support( 'jetpack-content-options', array(
	    'blog-display'       => 'content', // the default setting of the theme: 'content', 'excerpt' or array( 'content', 'excerpt' ) for themes mixing both display.
	    'author-bio'         => true, // display or not the author bio: true or false.
	    'author-bio-default' => false, // the default setting of the author bio, if it's being displayed or not: true or false (only required if false).
	    'masonry'            => '.site-main', // a CSS selector matching the elements that triggers a masonry refresh if the theme is using a masonry layout.
	    'post-details'       => array(
	        'stylesheet'      => 'themeslug-style', // name of the theme's stylesheet.
	        'date'            => '.posted-on', // a CSS selector matching the elements that display the post date.
	        'author'          => '.byline', // a CSS selector matching the elements that display the post author.
	    ),
	    'featured-images'    => array(
	        'archive'         => true, // enable or not the featured image check for archive pages: true or false.
	        'post'            => true, // enable or not the featured image check for single posts: true or false.
	        'page'            => true, // enable or not the featured image check for single pages: true or false.
	    ),
	) );

}
add_action( 'after_setup_theme', 'memos_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function memos_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'components/post/content', 'search' );
		else :
			get_template_part( 'components/post/content', get_post_format() );
		endif;
	}
}

function memos_social_menu() {
	if ( ! function_exists( 'jetpack_social_menu' ) ) {
		return;
	} else {
		jetpack_social_menu();
	}
}

