<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Memos
 */

if ( ! function_exists( 'memos_content_bottom_widgets' ) ) :
/**
 * Prints a secondary widget area in #primary below <main>
 */
function memos_content_bottom_widgets() {
	// check if sidebar has items before displaying
	if ( is_active_sidebar( 'left-sidebar' ) ) {
		echo '<aside id="content-bottom-widgets" class="content-bottom-widgets" role="complementary">' . dynamic_sidebar( 'content-bottom' ) . '</aside>';
	}
}
endif;

if ( ! function_exists( 'memos_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function memos_posted_on() {
	if ( 'post' === get_post_type() && is_single() ) {
		echo '
		<div class="author-info">
			<div class="author-avatar">' . get_avatar( get_the_author_meta( 'user_email' ), 42 ) . '</div>
			<div class="author-description">
				<h2 class="author-title"><span class="author-heading">Author:</span> ' . get_the_author() . '</h2>
				<p class="author-bio">' . get_the_author_description() . ' <a class="author-link" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '">View all posts by ' .  get_the_author() . '</a></p>
			</div>
		</div>';
	} else {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'memos' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( '%s', 'post author', 'memos' ),
			'<span class="author vcard">' . get_avatar( get_the_author_meta( 'user_email' ), 32 ) . '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"><span class="screen-reader-text">' . esc_html__( 'Author', 'memos' ) . '</span> ' . $byline . '</span>';
		echo '<span class="posted-on"><span class="screen-reader-text">' . esc_html__( 'Posted on', 'memos' ) . '</span> ' . $posted_on . '</span>';
	}
}
endif;

if ( ! function_exists( 'memos_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function memos_entry_footer() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'memos' ), esc_html__( '1 Comment', 'memos' ), esc_html__( '% Comments', 'memos' ) );
		echo '</span>';

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'memos' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
}
endif;

if ( ! function_exists( 'memos_post_navigation' ) ) :
/**
 * Customize post navigation to include "Previous" and "Next" before nav links.
 */
function memos_post_navigation() {
    $navigation = '';
    // Who knew you could change the nav links this much?
    $previous   = get_previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">Previous</span> <span class="post-title">%title</span></span>' );
    $next       = get_next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">Next</span> <span class="post-title">%title</span></span>' );

    // Only add markup if there's somewhere to navigate to.
    if ( $previous || $next ) {
	    // Wrap the links up in a nice tidy <nav> element
        $navigation = _navigation_markup( $previous . $next, 'post-navigation' );
    }

    echo $navigation;
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function memos_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'memos_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'memos_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so memos_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so memos_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in memos_categorized_blog.
 */
function memos_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'memos_categories' );
}
add_action( 'edit_category', 'memos_category_transient_flusher' );
add_action( 'save_post',     'memos_category_transient_flusher' );
