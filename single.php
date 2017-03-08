<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Memos
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'components/post/content', get_post_format() );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			the_post_navigation(
				array(
					'prev_text'	=> '<span class="meta-nav">' . esc_html_x( 'Previous', 'previous post', 'memos' ) . '</span> <span class="post-title">%title</span>',
					'next_text'	=> '<span class="meta-nav">' . esc_html_x( 'Next', 'next post', 'memos' ) . '</span> <span class="post-title">%title</span>',
				)
			);

		endwhile; // End of the loop.
		?>

		</main>

		<aside id="sidebar-2-widgets" class="sidebar-2-widgets widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</aside>
	</div>
<?php
get_sidebar();
get_footer();
