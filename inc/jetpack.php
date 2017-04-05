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
		'container'			=> 'main',
		'render'			=> 'memos_infinite_scroll_render',
		'footer_widgets'	=> 'sidebar-1',
		'footer'			=> 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menus
	add_theme_support( 'jetpack-social-menu' );

	// Add theme support for content options
	add_theme_support( 'jetpack-content-options', array(
		'blog-display'			=> 'content',
		'author-bio'			=> true,
		'post-details'			=> array(
			'stylesheet'		=> 'memos-style',
			'author'			=> '.byline, .byline:after',
			'date'				=> '.posted-on, .posted-on:after',
			'categories'		=> '.cat-links',
			'tags'				=> '.tags-links, .tags-links:after',
		),
		'featured-images'		=> array(
			'post'				=> true,
			'page'				=> true,
		),
	) );
}
add_action( 'after_setup_theme', 'memos_jetpack_setup' );


/**
 * Filter the Jetpack Gallery width to fit the full-size widget area
 */
add_filter( 'gallery_widget_content_width', 'memos_widget_content_width' );
function memos_widget_content_width() {
	return $GLOBALS['content_width'];
}

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

/**
 * Uses jetpack_author_bio function if available with a fallback if not.
 */
function memos_author_bio() {
	if ( ! function_exists( 'jetpack_author_bio' ) ) {
		get_template_part( 'components/post/content', 'author' );
	} else {
		jetpack_author_bio();
	}
}
