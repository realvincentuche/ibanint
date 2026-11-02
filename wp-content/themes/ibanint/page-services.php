<?php
/**
 * Template Name: About Page
 * Our Businesses page: profile intro + eight practice detail rows.
 *
 * @package Ibanint
 */

get_header();

$ibanint_contact_url = home_url( '/contact/' );

set_query_var( 'ibanint_banner_title', __( 'Our Businesses', 'ibanint' ) );
set_query_var( 'ibanint_banner_image', 'banner-services.jpg' );
set_query_var( 'ibanint_banner_sub', '' );
get_template_part( 'template-parts/page-banner' );
/* Unsplash free tier: Hong Kong skyline 1759162995281 (banner-services.jpg) */
?>

<section class="ib-intro" id="ib-services-intro">
	<div class="ib-wrap ib-intro-grid">
		<div class="ib-intro-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'What We Do', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Everything from commerce to recycling', 'ibanint' ), 'commerce to recycling' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-lead">
				<?php esc_html_e( 'Our eight business areas span trade, energy, agriculture, logistics, infrastructure, real estate, waste management and mining.', 'ibanint' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'These areas connect. A trade project may need transport; an agricultural project may need processing and distribution.', 'ibanint' ); ?>
			</p>
		</div>
		<div class="ib-intro-stat ib-reveal">
			<span class="ib-intro-stat-num">8</span>
			<span class="ib-intro-stat-label"><?php esc_html_e( 'Practice areas, one connected group', 'ibanint' ); ?></span>
		</div>
	</div>
</section>

<section class="ib-sector-details" id="ib-sector-details">
	<div class="ib-wrap">
		<?php foreach ( ibanint_sectors() as $ib_slug => $ib_sector ) : ?>
			<?php
			$ib_sector_page = get_page_by_path( 'services/' . $ib_slug );
			$ib_sector_url  = $ib_sector_page ? get_permalink( $ib_sector_page ) : home_url( '/services/' . $ib_slug . '/' );
			?>
			<article class="ib-sector-detail ib-reveal" id="<?php echo esc_attr( $ib_slug ); ?>">
				<div class="ib-sector-detail-media">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . ( $ib_sector['listing_image'] ?? $ib_sector['banner'] ) ); ?>" alt="" width="900" height="650" loading="lazy">
					<i class="ph <?php echo esc_attr( $ib_sector['icon'] ); ?>" aria-hidden="true"></i>
				</div>
				<div class="ib-sector-detail-copy">
					<h3><?php echo ibanint_highlight_heading( $ib_sector['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
					<p><?php echo esc_html( $ib_sector['blurb'] ); ?></p>
					<p class="ib-detail-extra"><?php echo esc_html( $ib_sector['detail'] ); ?></p>
					<p class="ib-connection">
						<i class="ph ph-arrows-clockwise" aria-hidden="true"></i>
						<?php echo esc_html( $ib_sector['connection'] ); ?>
					</p>
					<a class="ib-card-link" href="<?php echo esc_url( $ib_sector_url ); ?>">
						<?php
						printf(
							/* translators: %s: sector short name */
							esc_html__( 'Explore %s', 'ibanint' ),
							esc_html( $ib_sector['short'] )
						);
						?>
						<i class="ph ph-arrow-right" aria-hidden="true"></i>
					</a>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<?php get_template_part( 'template-parts/dynamic-content' ); ?>

<section class="ib-intro-cta">
	<div class="ib-wrap ib-intro-cta-inner">
		<p><?php esc_html_e( 'Working across more than one sector? Tell us where the opportunity starts.', 'ibanint' ); ?></p>
		<div class="ib-slide-actions">
			<a href="<?php echo esc_url( $ibanint_contact_url ); ?>" class="ib-btn ib-btn-gold">
				<?php esc_html_e( 'Partner With Us', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
