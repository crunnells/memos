<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Memos
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area <?php echo memos_count_widgets('sidebar-1'); ?>" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
