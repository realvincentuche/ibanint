<?php
/**
 * News archive (posts page or blog index).
 *
 * @package Ibanint
 */

get_header();

$ibanint_news_id = get_option( 'page_for_posts' );

set_query_var( 'ibanint_banner_title', __( 'Updates & Events', 'ibanint' ) );
set_query_var( 'ibanint_banner_image', 'banner-news.jpg' );
set_query_var( 'ibanint_banner_sub', '' );
get_template_part( 'template-parts/page-banner' );
/* Unsplash free tier: stack of newspapers 1672870153618 (banner-news.jpg) */
?>

<section class="ib-news" id="ib-news">
	<div class="ib-wrap">
		<?php if ( have_posts() ) : ?>
			<div class="ib-news-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'ib-news-card ib-reveal' ); ?>>
						<a class="ib-news-media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<span class="ib-news-fallback"><i class="ph ph-newspaper" aria-hidden="true"></i></span>
							<?php endif; ?>
						</a>
						<div class="ib-news-body">
							<p class="ib-news-meta">
								<?php echo esc_html( get_the_date() ); ?>
								<?php
								$ibanint_cat = get_the_category();
								if ( $ibanint_cat ) :
									?>
									<span aria-hidden="true">·</span>
									<span><?php echo esc_html( $ibanint_cat[0]->name ); ?></span>
								<?php endif; ?>
							</p>
							<h2 class="ib-news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="ib-news-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
							<a class="ib-card-link" href="<?php the_permalink(); ?>">
								<?php esc_html_e( 'Read article', 'ibanint' ); ?>
								<i class="ph ph-arrow-right" aria-hidden="true"></i>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<nav class="ib-pagination" aria-label="<?php esc_attr_e( 'Posts', 'ibanint' ); ?>">
				<?php
				echo paginate_links(
					array(
						'prev_text' => '<i class="ph ph-caret-left" aria-hidden="true"></i>',
						'next_text' => '<i class="ph ph-caret-right" aria-hidden="true"></i>',
					)
				);
				?>
			</nav>
		<?php else : ?>
			<div class="ib-empty">
				<p><?php esc_html_e( 'No news yet. The first story will land here.', 'ibanint' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
