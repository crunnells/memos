<div class="site-info">
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'memos' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'memos' ), 'WordPress' ); ?></a>
	<span class="sep"> | </span>
	<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'memos' ), 'memos', '<a href="https://automattic.com/" rel="designer">Automattic</a>' ); ?>
</div><!-- .site-info -->

<?php memos_social_menu(); ?>
