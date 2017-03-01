<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @package Memos
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses memos_header_style()
 */
function memos_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'memos_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '2e4453',
		'width'                  => 2000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'memos_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'memos_custom_header_setup' );

if ( ! function_exists( 'memos_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see memos_custom_header_setup().
 */
function memos_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
	if ( HEADER_TEXTCOLOR === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' === $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // memos_header_style

if ( ! function_exists( 'memos_custom_header' ) ) :
/**
 * Displays a custom header image.
 */
function memos_custom_header() {
	if ( ! get_header_image() ) {
		return;
	}

	echo '<div class="header-image"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
	echo '<img src="' . esc_url( get_header_image() ) . '" width="' . esc_attr( get_custom_header()->width ) . '" height="' . esc_attr( get_custom_header()->height ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
	echo '</a></div>';
}

endif; // memos_custom_header
