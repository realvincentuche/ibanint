<?php
/**
 * Homepage: hero, about,
 * sector panel, why-choose, approach panel, audience carousel.
 * CTA banner lives in footer.php so it appears on every page.
 *
 * @package Ibanint
 */

get_header();

$ibanint_sectors  = ibanint_sectors();
$ibanint_about_id = get_page_by_path( 'about' );
$ibanint_about_url = $ibanint_about_id ? get_permalink( $ibanint_about_id ) : home_url( '/about/' );
$ibanint_services_id = get_page_by_path( 'services' );
$ibanint_services_url = $ibanint_services_id ? get_permalink( $ibanint_services_id ) : home_url( '/services/' );
$ibanint_contact_url = home_url( '/contact/' );

$ibanint_hero_slides = array(
	array( 'image' => 'logistics-banner.jpg', 'width' => 1600, 'height' => 1200, 'alt' => 'Volvo truck at a transport yard', 'kicker' => 'International business development', 'title' => 'Connecting markets. Developing opportunity.', 'text' => 'We bring partners together across trade, infrastructure, energy and five other business areas.', 'cta' => 'Explore our businesses', 'url' => $ibanint_services_url ),
	array( 'image' => 'banner-infrastructure.jpg', 'width' => 1920, 'height' => 1371, 'alt' => 'Infrastructure development site seen from above', 'kicker' => 'Connected expertise', 'title' => 'Where sectors meet, progress begins.', 'text' => 'Our work connects infrastructure, logistics and investment opportunities across borders.', 'cta' => 'How we work', 'url' => $ibanint_about_url ),
	array( 'image' => 'banner-agriculture.jpg', 'width' => 1920, 'height' => 1080, 'alt' => 'Combine harvester working in a field', 'kicker' => 'Partnerships with purpose', 'title' => 'The right partners change what is possible.', 'text' => 'We look across the value chain to find the people and capabilities that move projects forward.', 'cta' => 'Start a conversation', 'url' => $ibanint_contact_url ),
);
$ibanint_marquee = array(
	'Connecting producers with markets',
	'Advancing viable energy projects',
	'Strengthening food value chains',
	'Moving goods across borders',
	'Guiding infrastructure investment',
	'Developing commercial places',
	'Turning waste into resources',
	'Creating responsible resource value',
);
?>

	<section class="ib-hero" id="ib-hero" aria-label="<?php esc_attr_e( 'Featured IBAN International stories', 'ibanint' ); ?>" tabindex="0">
	<div class="ib-hero-slides">
		<?php foreach ( $ibanint_hero_slides as $ibanint_index => $ibanint_slide ) : ?>
			<article class="ib-hero-slide<?php echo 0 === $ibanint_index ? ' is-active' : ''; ?>" aria-hidden="<?php echo 0 === $ibanint_index ? 'false' : 'true'; ?>" <?php echo 0 === $ibanint_index ? '' : 'inert'; ?>>
				<img class="ib-hero-image" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $ibanint_slide['image'] ); ?>" alt="<?php echo esc_attr( $ibanint_slide['alt'] ); ?>" width="<?php echo esc_attr( $ibanint_slide['width'] ); ?>" height="<?php echo esc_attr( $ibanint_slide['height'] ); ?>" <?php echo 0 === $ibanint_index ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
				<div class="ib-hero-shade"></div>
				<div class="ib-wrap ib-slide-inner">
					<div class="ib-slide-content">
						<p class="ib-slide-kicker"><?php echo esc_html( $ibanint_slide['kicker'] ); ?></p>
						<?php if ( 0 === $ibanint_index ) : ?><h1 class="ib-slide-title"><?php echo ibanint_highlight_heading( $ibanint_slide['title'], 'Developing opportunity.' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1><?php else : ?><h2 class="ib-slide-title"><?php echo ibanint_highlight_heading( $ibanint_slide['title'], 1 === $ibanint_index ? 'progress begins.' : 'change what is possible.' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2><?php endif; ?>
						<p class="ib-slide-text"><?php echo esc_html( $ibanint_slide['text'] ); ?></p>
						<a href="<?php echo esc_url( $ibanint_slide['url'] ); ?>" class="ib-btn ib-btn-gold"><?php echo esc_html( $ibanint_slide['cta'] ); ?><i class="ph ph-arrow-right" aria-hidden="true"></i></a>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
	<div class="ib-hero-controls ib-wrap">
		<div class="ib-hero-arrows"><button type="button" id="ib-hero-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'ibanint' ); ?>"><i class="ph ph-arrow-left" aria-hidden="true"></i></button><button type="button" id="ib-hero-next" aria-label="<?php esc_attr_e( 'Next slide', 'ibanint' ); ?>"><i class="ph ph-arrow-right" aria-hidden="true"></i></button><button type="button" id="ib-hero-pause" aria-label="<?php esc_attr_e( 'Pause slides', 'ibanint' ); ?>"><i class="ph ph-pause" aria-hidden="true"></i></button></div>
	</div>
</section>
<div class="ib-service-marquee" aria-label="<?php esc_attr_e( 'Our business areas', 'ibanint' ); ?>">
	<div class="ib-service-marquee-track">
		<?php for ( $ibanint_repeat = 0; $ibanint_repeat < 2; $ibanint_repeat++ ) : ?>
			<div class="ib-service-marquee-group" <?php echo 1 === $ibanint_repeat ? 'aria-hidden="true"' : ''; ?>>
				<?php foreach ( $ibanint_marquee as $ibanint_phrase ) : ?><span><?php echo esc_html( $ibanint_phrase ); ?></span><?php endforeach; ?>
			</div>
		<?php endfor; ?>
	</div>
</div>

<!-- Who we are -->
<section class="ib-about" id="ib-about">
	<div class="ib-wrap ib-about-grid">
		<div class="ib-about-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Who We Are', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'One group, connected across sectors', 'ibanint' ), 'connected across sectors' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-lead">
				<?php esc_html_e( 'IBAN International works across eight business areas. We connect businesses, investors and project partners across regions, so an opportunity in one sector can open another.', 'ibanint' ); ?>
			</p>
			<ul class="ib-check-list">
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'International outlook', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Local relationships', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Opportunities across sectors', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Long-term thinking', 'ibanint' ); ?></li>
			</ul>
			<a href="<?php echo esc_url( $ibanint_about_url ); ?>" class="ib-btn ib-btn-dark">
				<?php esc_html_e( 'More About Us', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
		</div>

		<div class="ib-about-media ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/home-field-team.jpg' ); ?>" alt="<?php esc_attr_e( 'Two engineers reviewing plans at an infrastructure site', 'ibanint' ); ?>" width="1400" height="2100" loading="lazy">
		</div>
	</div>
</section>

<!-- What we do -->
<section class="ib-sectors" id="ib-sectors">
	<div class="ib-sectors-panel ib-reveal">
		<div class="ib-wrap">
			<div class="ib-sectors-head">
				<div class="ib-sectors-heading">
					<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'What We Do', 'ibanint' ); ?></p>
					<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Eight businesses. Shared perspective.', 'ibanint' ), 'Shared perspective.' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
				</div>
				<p class="ib-sector-intro">
					<?php esc_html_e( 'Our work spans trade, energy, food, logistics, infrastructure, real estate, waste management and mining. A project in one area may call for partners in another.', 'ibanint' ); ?>
				</p>
				<a href="<?php echo esc_url( $ibanint_services_url ); ?>" class="ib-btn ib-btn-gold">
					<?php esc_html_e( 'See our businesses', 'ibanint' ); ?>
					<i class="ph ph-arrow-right" aria-hidden="true"></i>
				</a>
			</div>

			<div class="ib-sector-carousel-shell" id="ib-sector-carousel">
			<button class="ib-sector-control ib-sector-prev" id="ib-sector-prev" type="button" aria-label="<?php esc_attr_e( 'Previous businesses', 'ibanint' ); ?>"><i class="ph ph-arrow-left" aria-hidden="true"></i></button>
			<div class="ib-sector-viewport">
			<div class="ib-sector-grid" id="ib-sector-track">
				<?php foreach ( $ibanint_sectors as $ib_slug => $ib_sector ) : ?>
					<?php
					$ib_sector_page = get_page_by_path( 'services/' . $ib_slug );
					$ib_sector_url  = $ib_sector_page ? get_permalink( $ib_sector_page ) : home_url( '/services/' . $ib_slug . '/' );
					?>
					<article class="ib-sector-card">
						<div class="ib-sector-card-media" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . ( $ib_sector['listing_image'] ?? $ib_sector['banner'] ) ); ?>');" role="img" aria-label="<?php echo esc_attr( $ib_sector['title'] ); ?>"></div>
						<div class="ib-sector-card-body">
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
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			</div>
			<button class="ib-sector-control ib-sector-next" id="ib-sector-next" type="button" aria-label="<?php esc_attr_e( 'Next businesses', 'ibanint' ); ?>"><i class="ph ph-arrow-right" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</section>

<!-- Why IBAN International -->
<section class="ib-why" id="ib-why">
	<div class="ib-wrap ib-why-grid">
		<div class="ib-why-media ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logistics-intro.jpg' ); ?>" alt="<?php esc_attr_e( 'Volvo truck in a transport yard', 'ibanint' ); ?>" width="1200" height="1600" loading="lazy">
		</div>
		<div class="ib-why-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Why IBAN International', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Built to see what connects', 'ibanint' ), 'what connects' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-lead">
					<?php esc_html_e( 'A trade opportunity may need logistics. An agricultural project may need processing and distribution. We look across sectors to identify the partners each project needs.', 'ibanint' ); ?>
			</p>
			<ul class="ib-check-list">
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Markets viewed across borders', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Room for cross-sector collaboration', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Relationships built for the long term', 'ibanint' ); ?></li>
				<li><i class="ph ph-check-circle" aria-hidden="true"></i><?php esc_html_e( 'Local market knowledge', 'ibanint' ); ?></li>
			</ul>
			<a href="<?php echo esc_url( $ibanint_contact_url ); ?>" class="ib-btn ib-btn-dark">
				<?php esc_html_e( 'Get in Touch', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</section>

<!-- Our approach (overlapping panel) -->
<section class="ib-steps" id="ib-steps">
	<div class="ib-steps-panel">
		<div class="ib-wrap">
			<div class="ib-steps-grid">
				<div class="ib-steps-main">
					<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Our Approach', 'ibanint' ); ?></p>
					<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'How we move an opportunity forward', 'ibanint' ), 'opportunity forward' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
					<div class="ib-step-list">
						<?php
						$ibanint_steps = array(
							array( 'ph-binoculars', 'Identify', 'We identify opportunities, market needs, resources and gaps across our business areas.' ),
							array( 'ph-users-three', 'Connect', 'We bring together partners with the expertise, resources and market access a project needs.' ),
							array( 'ph-strategy', 'Develop', 'We shape opportunities into initiatives with clear commercial objectives.' ),
							array( 'ph-rocket-launch', 'Execute', 'We work with partners to move agreed plans into action.' ),
							array( 'ph-trend-up', 'Grow', 'We look for value that lasts beyond a single transaction.' ),
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
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/approach-partnership.jpg' ); ?>" alt="<?php esc_attr_e( 'Business partners discussing a project around a table', 'ibanint' ); ?>" loading="lazy">
					<div class="ib-steps-card-body">
						<div class="ib-steps-card-badge">
							<span class="ib-eight-count">8</span>
							<span class="ib-eight-word"><?php esc_html_e( 'Practice areas', 'ibanint' ); ?></span>
						</div>
							<h3><?php esc_html_e( 'One conversation can connect several opportunities', 'ibanint' ); ?></h3>
						<p class="ib-quote">
							<?php esc_html_e( 'A commodity opportunity can create a logistics opportunity.', 'ibanint' ); ?>
						</p>
						<a href="<?php echo esc_url( $ibanint_contact_url ); ?>" class="ib-btn ib-btn-gold ib-btn-block">
							<?php esc_html_e( 'Talk to IBAN', 'ibanint' ); ?>
							<i class="ph ph-arrow-right" aria-hidden="true"></i>
						</a>
					</div>
				</aside>
			</div>
		</div>
	</div>
</section>

<!-- Our reach -->
<section class="ib-audience" id="ib-audience">
	<div class="ib-wrap">
		<div class="ib-head-center">
			<p class="ib-kicker ib-kicker-center"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Our Reach', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Who we work with', 'ibanint' ), 'work with' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-audience-sub">
				<?php esc_html_e( 'We work with people and organisations building value across markets and communities.', 'ibanint' ); ?>
			</p>
		</div>
		<?php
		$ibanint_audience = array(
			array( 'ph-trend-up', 'Investors', 'Capital partners seeking opportunities across our business areas.' ),
			array( 'ph-basket', 'Producers & suppliers', 'Businesses looking for new markets and commercial relationships.' ),
			array( 'ph-buildings', 'Developers', 'Organizations developing projects across strategic sectors.' ),
			array( 'ph-bank', 'Financial institutions', 'Institutions looking for credible projects and commercial partners.' ),
			array( 'ph-globe-hemisphere-west', 'Governments & public-sector organizations', 'Partners working toward trade, infrastructure and development objectives.' ),
			array( 'ph-users-three', 'International organizations', 'Organizations seeking local relationships and cross-border capabilities.' ),
		);
		?>
		<ul class="ib-audience-list">
			<?php foreach ( $ibanint_audience as $ibanint_aud ) : ?>
				<li class="ib-audience-item ib-reveal">
					<span class="ib-audience-icon"><i class="ph <?php echo esc_attr( $ibanint_aud[0] ); ?>" aria-hidden="true"></i></span>
					<h3><?php echo esc_html( $ibanint_aud[1] ); ?></h3>
					<p><?php echo esc_html( $ibanint_aud[2] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
get_footer();
