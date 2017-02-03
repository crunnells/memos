<div class="site-info">
	<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'memos' ), 'Memos', '<a href="http://automattic.com/" rel="designer">Automattic</a>' ); ?>
	<a href="<?php echo esc_url( home_url() ); ?>" rel="home"><?php echo esc_html( bloginfo( 'name' ) ); ?></a>
	<span class="sep"> / </span>
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'memos' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'memos' ), 'WordPress' ); ?></a>
</div><!-- .site-info -->

<?php memos_social_menu(); ?>
