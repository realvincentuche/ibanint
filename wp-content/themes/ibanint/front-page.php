<?php
/**
 * Homepage: hero slider, trust strip, about, sectors, why-choose,
 * value steps, audience carousel, CTA banner, stats.
 *
 * @package Ibanint
 */

get_header();

$ibanint_slides   = ibanint_slides();
$ibanint_sectors  = ibanint_sectors();
$ibanint_about_id = get_page_by_path( 'about' );
$ibanint_about_url = $ibanint_about_id ? get_permalink( $ibanint_about_id ) : home_url( '/about/' );
$ibanint_services_id = get_page_by_path( 'services' );
$ibanint_services_url = $ibanint_services_id ? get_permalink( $ibanint_services_id ) : home_url( '/services/' );
$ibanint_contact_url = home_url( '/contact/' );

/* Image attribution. Unsplash free tier:
 * hero-1  https://unsplash.com/photos/handshake-business-meeting-0639174cdfac (1752159684779)
 * hero-2  https://unsplash.com/photos/containers-port-1770710195407 (1770710195407)
 * hero-3  https://unsplash.com/photos/boardroom-meeting-5d608ba3abdf (1758518732175)
 */
?>

<section class="ib-hero" id="ib-hero">
	<?php foreach ( $ibanint_slides as $ibanint_index => $ibanint_slide ) : ?>
		<div class="ib-slide ib-slide-<?php echo (int) $ibanint_index + 1; ?><?php echo 0 === $ibanint_index ? ' active' : ''; ?>" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $ibanint_slide['image'] ); ?>');">
			<div class="ib-slide-shade"></div>
			<div class="ib-wrap ib-slide-inner">
				<div class="ib-slide-content">
					<p class="ib-slide-kicker"><span class="ib-slide-dash"></span><?php echo esc_html( $ibanint_slide['kicker'] ); ?></p>
					<h2 class="ib-slide-title"><?php echo esc_html( $ibanint_slide['title'] ); ?></h2>
					<p class="ib-slide-text"><?php echo esc_html( $ibanint_slide['text'] ); ?></p>
					<div class="ib-slide-actions">
						<a href="<?php echo esc_url( home_url( $ibanint_slide['link'] ) ); ?>" class="ib-btn ib-btn-gold">
							<?php echo esc_html( $ibanint_slide['cta'] ); ?>
							<i class="ph ph-arrow-right" aria-hidden="true"></i>
						</a>
						<a href="<?php echo esc_url( $ibanint_about_url ); ?>" class="ib-btn ib-btn-ghost-light">
							<?php esc_html_e( 'Who We Are', 'ibanint' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="ib-hero-dots" id="ib-hero-dots"></div>
	<div class="ib-hero-nav">
		<button type="button" class="ib-hero-prev" id="ib-hero-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'ibanint' ); ?>"><i class="ph ph-caret-left" aria-hidden="true"></i></button>
		<button type="button" class="ib-hero-next" id="ib-hero-next" aria-label="<?php esc_attr_e( 'Next slide', 'ibanint' ); ?>"><i class="ph ph-caret-right" aria-hidden="true"></i></button>
	</div>
</section>

<!-- 1. Trust strip -->
<section class="ib-trust" id="ib-trust">
	<div class="ib-wrap ib-trust-grid">
		<?php
		$ibanint_trust = array(
			array( 'ph-globe-hemisphere-west', 'International business' ),
			array( 'ph-strategy', 'Eight practice areas' ),
			array( 'ph-handshake', 'Strategic partnerships' ),
			array( 'ph-arrows-left-right', 'Connections across borders' ),
			array( 'ph-trend-up', 'Endless possibilities' ),
		);
		foreach ( $ibanint_trust as $ibanint_item ) :
			?>
			<div class="ib-trust-item">
				<i class="ph <?php echo esc_attr( $ibanint_item[0] ); ?>" aria-hidden="true"></i>
				<span><?php echo esc_html( $ibanint_item[1] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<!-- 2. About tease -->
<section class="ib-about" id="ib-about">
	<div class="ib-wrap ib-about-grid">
		<div class="ib-about-media ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-tease.jpg' ); ?>" alt="<?php esc_attr_e( 'Business people closing a deal with a handshake', 'ibanint' ); ?>" width="700" height="880" loading="lazy">
			<?php /* Unsplash free tier: handshake deal 1582213782179 (about-tease.jpg) */ ?>
			<div class="ib-about-badge">
				<span class="ib-about-badge-num"><?php echo esc_html( __( '10+', 'ibanint' ) ); ?></span>
				<span class="ib-about-badge-label"><?php echo esc_html( __( 'Years opening doors across borders', 'ibanint' ) ); ?></span>
			</div>
		</div>

		<div class="ib-about-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Who We Are', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php esc_html_e( 'The business is connecting', 'ibanint' ); ?></h2>
			<p class="ib-lead">
				<?php esc_html_e( 'Iban International is not bound by a single business. We are a growth business with a global scope, and our expertise is built on four pillars: we keep you ahead with global perspectives, cross-border relationships, wide-reaching insight, and system thinking.', 'ibanint' ); ?>
			</p>
			<ul class="ib-check-list">
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Global perspective, local focus', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Strong cross-border network', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Wide-reaching insight', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'System thinking', 'ibanint' ); ?></li>
			</ul>
			<a href="<?php echo esc_url( $ibanint_about_url ); ?>" class="ib-btn ib-btn-dark">
				<?php esc_html_e( 'More About Us', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</section>

<!-- 3. Sectors grid -->
<section class="ib-sectors" id="ib-sectors">
	<div class="ib-wrap">
		<div class="ib-sectors-head ib-reveal">
			<p class="ib-kicker ib-kicker-light"><span class="ib-kicker-dash"></span><?php esc_html_e( 'What We Do', 'ibanint' ); ?></p>
			<h2 class="ib-h2 ib-h2-light"><?php esc_html_e( 'Eight doors, one connected group', 'ibanint' ); ?></h2>
			<p class="ib-sector-intro">
				<?php esc_html_e( 'Everything from commerce to recycling. Each practice runs on its own experience, and every one is connected to the others.', 'ibanint' ); ?>
			</p>
			<a href="<?php echo esc_url( $ibanint_services_url ); ?>" class="ib-link-more ib-link-more-light">
				<?php esc_html_e( 'See our businesses', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
		</div>

		<div class="ib-sector-grid">
			<?php foreach ( $ibanint_sectors as $ib_slug => $ib_sector ) : ?>
				<?php
				$ib_sector_page = get_page_by_path( 'services/' . $ib_slug );
				$ib_sector_url  = $ib_sector_page ? get_permalink( $ib_sector_page ) : home_url( '/services/' . $ib_slug . '/' );
				?>
				<article class="ib-sector-card ib-reveal">
					<i class="ph <?php echo esc_attr( $ib_sector['icon'] ); ?>" aria-hidden="true"></i>
					<h3><?php echo esc_html( $ib_sector['title'] ); ?></h3>
					<p><?php echo esc_html( $ib_sector['blurb'] ); ?></p>
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
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 4. Why choose -->
<section class="ib-why" id="ib-why">
	<div class="ib-wrap ib-why-grid">
		<div class="ib-why-media ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/why-choose.jpg' ); ?>" alt="<?php esc_attr_e( 'Site works and equipment at an infrastructure project', 'ibanint' ); ?>" width="700" height="880" loading="lazy">
			<?php /* Unsplash free tier: construction site aerial 1712693600525 (why-choose.jpg) */ ?>
		</div>
		<div class="ib-why-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Why Iban International', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php esc_html_e( 'Others see the market. We see the picture.', 'ibanint' ); ?></h2>
			<p class="ib-lead">
				<?php esc_html_e( 'Be it unlocking trade opportunities, creating cross-border value, or driving sustainable projects, we operate with industry expertise and an unparalleled network across all our business sectors.', 'ibanint' ); ?>
			</p>
			<ul class="ib-check-list">
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Depth in every sector we touch', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'A strong cross-border network', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Sector expertise that compounds', 'ibanint' ); ?></li>
			</ul>
			<a href="<?php echo esc_url( $ibanint_contact_url ); ?>" class="ib-btn ib-btn-dark">
				<?php esc_html_e( 'Get in Touch', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</section>

<!-- 5. Value steps + showcase card -->
<section class="ib-steps" id="ib-steps">
	<div class="ib-wrap ib-steps-grid">
		<div class="ib-steps-main">
			<p class="ib-kicker ib-kicker-light"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Our Approach', 'ibanint' ); ?></p>
			<h2 class="ib-h2 ib-h2-light"><?php esc_html_e( 'We build the staircase, opening every door on the way', 'ibanint' ); ?></h2>
			<div class="ib-step-list">
				<?php
				$ibanint_steps = array(
					array( 'ph-binoculars', 'Identify', 'We research the proverbial backdoor: the opportunity and partnership you cannot see from your side of the border.' ),
					array( 'ph-users-three', 'Connect', 'We do not just see the door; we are a bridge between opportunities and partnerships.' ),
					array( 'ph-strategy', 'Develop', 'We blend new perspectives into the recipe of success and position your business for each market.' ),
					array( 'ph-rocket-launch', 'Execute', 'We keep it simple: define your goal, know each step, time every action, and position for the win.' ),
					array( 'ph-trend-up', 'Grow', 'We are passionate about success and ready to build the layers of growth together.' ),
				);
				foreach ( $ibanint_steps as $ibanint_num => $ibanint_step ) :
					?>
					<div class="ib-step ib-reveal">
						<span class="ib-step-num"><?php echo esc_html( $ibanint_num + 1 ); ?></span>
						<i class="ph <?php echo esc_attr( $ibanint_step[0] ); ?>" aria-hidden="true"></i>
						<div>
							<h3><?php echo esc_html( $ibanint_step[1] ); ?></h3>
							<p><?php echo esc_html( $ibanint_step[2] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<aside class="ib-steps-card ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/showcase-card.jpg' ); ?>" alt="<?php esc_attr_e( 'IBAN debriefing with a partner', 'ibanint' ); ?>" loading="lazy">
			<?php /* Unsplash free tier: businesswoman portrait 1758518727888 (showcase-card.jpg) */ ?>
			<div class="ib-steps-card-body">
				<div class="ib-steps-card-badge">
					<span class="ib-eight-count">8</span>
					<span class="ib-eight-word"><?php esc_html_e( 'Practice areas', 'ibanint' ); ?></span>
				</div>
				<h3><?php esc_html_e( 'The debriefing session for the ambitious', 'ibanint' ); ?></h3>
				<p class="ib-quote">
					<?php esc_html_e( 'A commodity opportunity can create a logistics opportunity. That is the Iban difference.', 'ibanint' ); ?>
				</p>
				<a href="<?php echo esc_url( $ibanint_contact_url ); ?>" class="ib-btn ib-btn-gold ib-btn-block">
					<?php esc_html_e( 'Talk to Iban', 'ibanint' ); ?>
					<i class="ph ph-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
		</aside>
	</div>
</section>

<!-- 6. Audiences carousel -->
<section class="ib-audience" id="ib-audience">
	<div class="ib-wrap">
		<div class="ib-head-center">
			<p class="ib-kicker ib-kicker-center ib-kicker-light"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Our Reach', 'ibanint' ); ?></p>
			<h2 class="ib-h2 ib-h2-light"><?php esc_html_e( 'Built for people who open doors', 'ibanint' ); ?></h2>
			<p class="ib-audience-sub">
				<?php esc_html_e( 'They are not always in a boardroom. They are not always on the map. Sometimes, they are you.', 'ibanint' ); ?>
			</p>
		</div>

		<div class="ib-carousel" id="ib-audience-carousel" tabindex="0" aria-label="<?php esc_attr_e( 'Who we work with', 'ibanint' ); ?>">
			<div class="ib-carousel-track" id="ib-audience-track">
				<?php
				$ibanint_audience = array(
					array( 'ph-plant', 'Producers & farmers', 'Land, water, or hard working hands. Situated in the heart of a new market, or at the edge of a known one.' ),
					array( 'ph-package', 'Importers & exporters', 'A lesson in cross-border trade: when to pull the trigger, and when to go long.' ),
					array( 'ph-factory', 'Manufacturers', 'A plant without a market is a cost. A market without a partner is a risk.' ),
					array( 'ph-diamond', 'Investors', 'Where is the return? The region is rich, but returns go to those who read it closely.' ),
					array( 'ph-bank', 'Institutions & NGOs', 'Where bank risk safeguards touch livelihoods. A partnership is the surest road.' ),
					array( 'ph-flag', 'Governments & regions', 'One region of potential. Many partnerships woven by the people who shape it.' ),
				);
				foreach ( $ibanint_audience as $ibanint_aud ) :
					?>
					<div class="ib-aud-card">
						<i class="ph <?php echo esc_attr( $ibanint_aud[0] ); ?>" aria-hidden="true"></i>
						<h3><?php echo esc_html( $ibanint_aud[1] ); ?></h3>
						<p><?php echo esc_html( $ibanint_aud[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="ib-carousel-dots" id="ib-audience-dots"></div>
		</div>
	</div>
</section>

<!-- 7. CTA banner -->
<section class="ib-cta" id="ib-cta" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/cta-banner.jpg' ); ?>');">
	<?php /* Unsplash free tier: team meeting at table 1716703432455 (cta-banner.jpg) */ ?>
	<div class="ib-cta-shade"></div>
	<div class="ib-wrap ib-cta-inner ib-reveal">
		<h2 class="ib-h2 ib-h2-light"><?php esc_html_e( 'A door can begin with one conversation', 'ibanint' ); ?></h2>
		<p>
			<?php esc_html_e( 'You bring the ambition; we bring the cross-border expertise, the network, and the doors. The conversation is free.', 'ibanint' ); ?>
		</p>
		<div class="ib-slide-actions">
			<a href="<?php echo esc_url( $ibanint_contact_url ); ?>" class="ib-btn ib-btn-gold">
				<?php esc_html_e( 'Partner With Us', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
			<a href="<?php echo esc_url( $ibanint_services_url ); ?>" class="ib-btn ib-btn-ghost-light">
				<?php esc_html_e( 'Our Businesses', 'ibanint' ); ?>
			</a>
		</div>
	</div>
</section>

<!-- 8. Stats -->
<section class="ib-stats" id="ib-stats">
	<div class="ib-wrap ib-stats-grid">
		<?php
		$ibanint_stats = array(
			array( '8', 'Practice areas, one group' ),
			array( '5', 'Regions, from Africa to North America' ),
			array( '10+', 'Years opening doors across borders' ),
			array( '&infin;', 'Possibilities next door', 'raw' ),
		);
		foreach ( $ibanint_stats as $ibanint_stat ) :
			?>
			<div class="ib-stat">
				<span class="ib-stat-num"><?php echo 'raw' === ( $ibanint_stat[2] ?? '' ) ? wp_kses_post( $ibanint_stat[0] ) : esc_html( $ibanint_stat[0] ); ?></span>
				<span class="ib-stat-label"><?php echo esc_html( $ibanint_stat[1] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php
get_footer();
