<?php
/**
 * Memos functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Memos
 */

if ( ! function_exists( 'memos_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function memos_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on components, use a find and replace
	 * to change 'memos' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'memos', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'memos-featured-image', 700, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Top', 'memos' ),
	) );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 150,
		'width'       => 500,
		'flex-width'  => false,
		'flex-height' => true,
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'memos_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'editor-style.css', memos_fonts_url() ) );

}
endif;
add_action( 'after_setup_theme', 'memos_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function memos_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'memos_content_width', 676 );
}
add_action( 'after_setup_theme', 'memos_content_width', 0 );

/**
 * Return early if Custom Logos are not available.
 *
 * @todo Remove after WP 4.7
 */
function memos_the_custom_logo() {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	} else {
		the_custom_logo();
	}
}

/**
 * Author Bio Avatar Size.
 */
function memos_author_bio_avatar_size() {
    return 64; // in px
}
add_filter( 'jetpack_author_bio_avatar_size', 'memos_author_bio_avatar_size' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function memos_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'memos' ),
		'id'            => 'sidebar-1',
		'description'   => 'This widget area is at the bottom of the page and displays widgets in two columns.',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'			=> esc_html__( 'Content Bottom', 'memos' ),
		'id'			=> 'sidebar-2',
		'description'	=> 'This widget area is below your post and page content and above the Footer widget area in a single column.',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</section>',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
	) );
}
add_action( 'widgets_init', 'memos_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function memos_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'memos-fonts', memos_fonts_url() );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'memos-style', get_stylesheet_uri() );

	// Handles toggling the navigation menu for small screens and enables TAB key navigation support for dropdown menus.
	wp_enqueue_script( 'memos-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	// Helps with accessibility for keyboard only users.
	wp_enqueue_script( 'memos-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// Only load comment functionality when needed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Add translation strings to
	wp_localize_script( 'memos-navigation', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'memos' ),
		'collapse' => __( 'collapse child menu', 'memos' ),
	) );

}
add_action( 'wp_enqueue_scripts', 'memos_scripts' );


if ( ! function_exists( 'memos_fonts_url' ) ) :
/**
 * Register Google fonts for Memos.
 */
function memos_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Merriweather, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	if ( 'off' !== esc_html_x( 'on', 'Merriweather font: on or off', 'memos' ) ) {
		$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
	}

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Montserrat, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	if ( 'off' !== esc_html_x( 'on', 'Montserrat font: on or off', 'memos' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}

	if ( $fonts ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}
endif;

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom header image support.
 */
require get_template_directory() . '/inc/custom-header.php';
