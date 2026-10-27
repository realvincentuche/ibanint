<?php
/**
 * Single post.
 *
 * @package Ibanint
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'ib-single' ); ?>>
		<header class="ib-single-head">
			<div class="ib-wrap">
				<p class="ib-news-meta">
					<?php echo esc_html( get_the_date() ); ?>
					<?php $ibanint_cat = get_the_category(); ?>
					<?php if ( $ibanint_cat ) : ?>
						<span aria-hidden="true">·</span>
						<a href="<?php echo esc_url( get_category_link( $ibanint_cat[0] ) ); ?>"><?php echo esc_html( $ibanint_cat[0]->name ); ?></a>
					<?php endif; ?>
				</p>
				<h1 class="ib-single-title"><?php the_title(); ?></h1>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="ib-wrap ib-single-thumb">
				<?php the_post_thumbnail( 'full', array( 'loading' => 'eager' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="ib-wrap">
			<div class="ib-prose">
				<?php the_content(); ?>
			</div>

			<footer class="ib-single-foot">
				<?php if ( get_the_tags() ) : ?>
					<p class="ib-tags"><?php the_tags( '', ' ' ); ?></p>
				<?php endif; ?>
				<?php
				$ibanint_news_url = get_permalink( (int) get_option( 'page_for_posts' ) );
				if ( ! $ibanint_news_url ) {
					$ibanint_news_url = home_url( '/' );
				}
				?>
				<a class="ib-card-link" href="<?php echo esc_url( $ibanint_news_url ); ?>">
					<i class="ph ph-arrow-left" aria-hidden="true"></i>
					<?php esc_html_e( 'Back to News', 'ibanint' ); ?>
				</a>
			</footer>
		</div>
	</article>
<?php endwhile; ?>

<nav class="ib-post-nav" aria-label="<?php esc_attr_e( 'Posts', 'ibanint' ); ?>">
	<div class="ib-wrap ib-post-nav-inner">
		<?php previous_post_link( '<span class="ib-post-prev"><i class="ph ph-arrow-left" aria-hidden="true"></i> %link</span>', '%title' ); ?>
		<?php next_post_link( '<span class="ib-post-next">%link <i class="ph ph-arrow-right" aria-hidden="true"></i></span>', '%title' ); ?>
	</div>
</nav>

<?php
get_footer();
