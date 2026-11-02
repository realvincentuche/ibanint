<?php
/**
 * Footer: navy columns, sector list, contact, legal row.
 *
 * @package Ibanint
 */
?>
</main>

<!-- CTA banner (all pages, just before the footer) -->
<section class="ib-cta" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/banner-about.jpg' ); ?>');">
	<div class="ib-cta-shade"></div>
	<div class="ib-wrap ib-cta-inner ib-reveal">
		<h2 class="ib-h2 ib-h2-light"><?php echo ibanint_highlight_heading( __( 'Let’s move your next opportunity forward', 'ibanint' ), 'opportunity forward' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
		<p>
			<?php esc_html_e( 'Share the sector, market or partnership you are exploring. We will help identify the right starting point.', 'ibanint' ); ?>
		</p>
		<div class="ib-slide-actions">
			<?php $ibanint_services_page = get_page_by_path( 'services' ); ?>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="ib-btn ib-btn-gold">
				<?php esc_html_e( 'Partner With Us', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
			<?php if ( $ibanint_services_page ) : ?>
				<a href="<?php echo esc_url( get_permalink( $ibanint_services_page ) ); ?>" class="ib-btn ib-btn-ghost-light">
					<?php esc_html_e( 'Our Businesses', 'ibanint' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>

<footer class="ib-footer" id="ib-footer">
	<div class="ib-wrap">
		<div class="ib-footer-grid">

			<div class="ib-footer-brand">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/ibanint-logo-band-dark.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="ib-footer-logo" width="952" height="424" loading="lazy">
				<p class="ib-footer-tagline">
					<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
				</p>
				<div class="ib-footer-regions">
					<h2 class="ib-footer-h"><?php esc_html_e( 'Our Regions', 'ibanint' ); ?></h2>
					<ul>
						<?php foreach ( array_map( 'trim', explode( '|', ibanint_contact()['regions'] ) ) as $ibanint_region ) : ?>
							<li><?php echo esc_html( $ibanint_region ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="ib-footer-col">
				<h2 class="ib-footer-h"><?php esc_html_e( 'Quick Links', 'ibanint' ); ?></h2>
				<ul class="ib-footer-menu">
					<?php
					foreach ( array( 'home' => 'Home', 'about' => 'About Us', 'news' => 'News', 'contact' => 'Contact Us' ) as $ib_slug => $ib_label ) :
						$ib_page = get_page_by_path( $ib_slug );
						if ( ! $ib_page ) {
							continue;
						}
						?>
						<li><a href="<?php echo esc_url( get_permalink( $ib_page ) ); ?>"><?php echo esc_html( $ib_label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="ib-footer-col">
				<h2 class="ib-footer-h"><?php esc_html_e( 'Our Businesses', 'ibanint' ); ?></h2>
				<ul class="ib-footer-menu ib-footer-sectors">
					<?php foreach ( ibanint_sectors() as $ib_slug => $ib_sector ) : ?>
						<?php $ib_sector_page = get_page_by_path( 'services/' . $ib_slug ); ?>
						<?php if ( $ib_sector_page ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $ib_sector_page ) ); ?>"><?php echo esc_html( $ib_sector['title'] ); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="ib-footer-col ib-footer-contact">
				<h2 class="ib-footer-h"><?php esc_html_e( 'Reach Us', 'ibanint' ); ?></h2>
				<?php $ibanint_contact = ibanint_contact(); ?>
				<ul class="ib-footer-touch">
					<li>
						<a href="<?php echo esc_url( $ibanint_contact['phone_href'] ); ?>">
							<i class="ph ph-phone" aria-hidden="true"></i><span><?php echo esc_html( $ibanint_contact['phone'] ); ?> (WhatsApp)</span>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( $ibanint_contact['website_href'] ); ?>">
							<i class="ph ph-globe" aria-hidden="true"></i><span><?php echo esc_html( $ibanint_contact['website'] ); ?></span>
						</a>
					</li>
					<?php if ( $ibanint_contact['email'] ) : ?>
						<li>
							<a href="<?php echo esc_url( 'mailto:' . $ibanint_contact['email'] ); ?>">
								<i class="ph ph-envelope" aria-hidden="true"></i><span><?php echo esc_html( $ibanint_contact['email'] ); ?></span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="ib-btn ib-btn-gold ib-footer-cta">
					<?php esc_html_e( 'Partner With Us', 'ibanint' ); ?>
					<i class="ph ph-arrow-right" aria-hidden="true"></i>
				</a>
			</div>

		</div>
	</div>

	<div class="ib-footer-legal">
		<div class="ib-wrap ib-footer-legal-inner">
			<p class="ib-footer-copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'ibanint' ); ?></p>
			<nav aria-label="<?php esc_attr_e( 'Legal', 'ibanint' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => '',
						'menu_class'     => 'ib-legal-menu',
						'fallback_cb'    => 'ibanint_footer_fallback',
						'depth'          => 1,
					)
				);
				?>
			</nav>
		</div>
	</div>
</footer>

<button type="button" class="ib-totop" id="ib-totop" aria-label="<?php esc_attr_e( 'Back to top', 'ibanint' ); ?>">
	<i class="ph ph-arrow-up" aria-hidden="true"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>
