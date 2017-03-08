		<div class="author-info">
			<div class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 64 ); ?></div>
			<div class="author-description">
				<h2 class="author-title">
					<span class="author-heading"><?php esc_html_e( 'Author', 'memos' ); ?>:</span> <?php the_author(); ?>
				</h2>
				<p class="author-bio"><?php the_author_meta( 'description' ); ?>
					<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
						View all posts by <?php the_author(); ?>
					</a>
				</p>
			</div>
		</div>
