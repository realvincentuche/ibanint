<?php
/**
 * About Us page.
 *
 * @package Ibanint
 */

get_header();

$ibanint_contact_url = home_url( '/contact/' );
$ibanint_services_id = get_page_by_path( 'services' );
$ibanint_services_url = $ibanint_services_id ? get_permalink( $ibanint_services_id ) : home_url( '/services/' );

set_query_var( 'ibanint_banner_title', __( 'About Iban International', 'ibanint' ) );
set_query_var( 'ibanint_banner_image', 'banner-about.jpg' );
set_query_var( 'ibanint_banner_sub', '' );
get_template_part( 'template-parts/page-banner' );
/* Unsplash free tier: London city 1766442055053 (banner-about.jpg) */
?>

<section class="ib-intro" id="ib-intro">
	<div class="ib-wrap ib-intro-grid">
		<div class="ib-intro-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Who We Are', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Growth is what we do. Connecting is how we do it.', 'ibanint' ), 'Connecting is how we do it.' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-lead">
				<?php esc_html_e( 'Iban International has been opening doors for over a decade. We keep you ahead by knowing where the next door is, when to knock, and how to bring the right partners with you.', 'ibanint' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'We are not bound by a single business. We are a growth business with a global scope: a group of practice areas that opens doors between markets, regions, and partners.', 'ibanint' ); ?>
			</p>
		</div>
		<div class="ib-intro-media ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-tease.jpg' ); ?>" alt="<?php esc_attr_e( 'Team members placing their hands together', 'ibanint' ); ?>" width="700" height="880" loading="lazy">
		</div>
	</div>
</section>

<section class="ib-approach" id="ib-approach">
	<div class="ib-wrap">
		<div class="ib-head-center">
			<p class="ib-kicker ib-kicker-center"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Our Approach', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Four pillars hold every door we open', 'ibanint' ), 'every door we open' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-lead ib-lead-center">
				<?php esc_html_e( 'How we work is what sets us apart. Four ideas guide every opportunity we touch.', 'ibanint' ); ?>
			</p>
		</div>
		<div class="ib-pillar-grid">
			<?php
			$ibanint_pillars = array(
				array( 'ph-globe-hemisphere-west', 'Global perspective', 'We look beyond individual markets. We identify connections and opportunities across borders.' ),
				array( 'ph-handshake', 'Local relationships', 'We understand new cultures, network closely with the right partners, and look at things from a local angle.' ),
				array( 'ph-binoculars', 'Wide-reaching insight', 'We never stop at the first opportunity. We look for the second, and the door behind it.' ),
				array( 'ph-gear', 'System thinking', 'We build systems, not silos. One opportunity bigger, one connection deeper.' ),
			);
			foreach ( $ibanint_pillars as $ibanint_pillar ) :
				?>
				<article class="ib-pillar ib-reveal">
					<i class="ph <?php echo esc_attr( $ibanint_pillar[0] ); ?>" aria-hidden="true"></i>
					<h3><?php echo esc_html( $ibanint_pillar[1] ); ?></h3>
					<p><?php echo esc_html( $ibanint_pillar[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ib-mindset" id="ib-mindset">
	<div class="ib-wrap ib-mindset-grid">
		<div class="ib-mindset-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'The Mindset', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'This is not capacity building. It is partnership.', 'ibanint' ), 'It is partnership.' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-quote-big">
				&ldquo;<?php esc_html_e( 'A connection is the surest road to what is next.', 'ibanint' ); ?>&rdquo;
			</p>
			<p>
				<?php esc_html_e( 'Every industry changes over time. We position ourselves accordingly: identifying and developing opportunities before the market dominates the conversation. A site without a market is a cost; a market without a partner is a risk. Iban exists to close both gaps at once.', 'ibanint' ); ?>
			</p>
		</div>
		<div class="ib-mindset-media ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/why-choose.jpg' ); ?>" alt="<?php esc_attr_e( 'Site works and equipment at an infrastructure project', 'ibanint' ); ?>" width="700" height="880" loading="lazy">
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/dynamic-content' ); ?>

<section class="ib-intro-cta">
	<div class="ib-wrap ib-intro-cta-inner">
		<p>
			<?php
			printf(
				/* translators: %s: number of practical areas, here "Eight" */
				esc_html__( '%s practice areas, one group. Where do we fit into your next step?', 'ibanint' ),
				esc_html__( 'Eight', 'ibanint' )
			);
			?>
		</p>
		<div class="ib-slide-actions">
			<a href="<?php echo esc_url( $ibanint_services_url ); ?>" class="ib-btn ib-btn-ghost-dark">
				<?php esc_html_e( 'Our Businesses', 'ibanint' ); ?>
			</a>
			<a href="<?php echo esc_url( $ibanint_contact_url ); ?>" class="ib-btn ib-btn-gold">
				<?php esc_html_e( 'Partner With Us', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
