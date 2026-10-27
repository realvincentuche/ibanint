<?php
/**
 * Blog index.
 *
 * @package Ibanint
 */

get_header();
?>

<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="post-list">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'post-item' ); ?>>
						<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-excerpt"><?php the_excerpt(); ?></div>
					</article>
					<?php
				endwhile;
				?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts yet.', 'ibanint' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
