<?php
/**
 * WordPress.com-specific functions and definitions
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package Memos
 */

/**
 * Adds support for wp.com-specific theme functions.
 *
 * @global array $themecolors
 */
function memos_wpcom_setup() {
	global $themecolors;

	// Set theme colors for third party services.
	if ( ! isset( $themecolors ) ) {
		$themecolors = array(
			'bg'     => 'ffffff',
			'border' => 'e9eff3',
			'text'   => '2e4453',
			'link'   => '007acc',
			'url'    => '007acc',
		);
	}

	/* Add WP.com print styles */
	add_theme_support( 'print-styles' );
}
add_action( 'after_setup_theme', 'memos_wpcom_setup' );

/*
 * WordPress.com-specific styles
 */
function memos_wpcom_styles() {
	wp_enqueue_style( 'memos-wpcom', get_template_directory_uri() . '/inc/style-wpcom.css', '20160411' );
}
add_action( 'wp_enqueue_scripts', 'memos_wpcom_styles' );
