<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Memos
 */

if ( ! function_exists( 'memos_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function memos_posted_on() {
	if ( 'post' === get_post_type() && is_single() ) {
		// see Jetpack functions
		memos_author_bio();
	} else {
		echo '
		<span class="byline">
			<span class="screen-reader-text">' . esc_html_x( 'Author', 'post author', 'memos' ) . '</span>
			<span class="author vcard">' . get_avatar( get_the_author_meta( 'user_email' ), 32 ) . '
				<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>
			</span>
		</span>';
	}

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

	if ( ! is_sticky() ) {
		echo '
		<span class="posted-on">
			<span class="screen-reader-text">' . esc_html_x( 'Posted on', 'post date', 'memos' ) . '</span>
			<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>
		</span>';
	}

}
endif;

if ( ! function_exists( 'memos_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function memos_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'memos' ) );
		if ( $categories_list && memos_categorized_blog() ) {
			echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html_x( 'Posted in', 'post categories', 'memos' ) . '</span> ' . $categories_list . '</span>';
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'components' ) );
		if ( $tags_list ) {
			echo '<span class="tags-links"><span class="screen-reader-text">' . esc_html_x( 'Tagged', 'post tags', 'memos' ) . ':</span> ' . $tags_list . '</span>';
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'memos' ), esc_html__( '1 Comment', 'memos' ), esc_html__( '% Comments', 'memos' ) );
		echo '</span>';
	}

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
