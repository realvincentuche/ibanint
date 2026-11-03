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

set_query_var( 'ibanint_banner_title', __( 'About IBAN International', 'ibanint' ) );
set_query_var( 'ibanint_banner_image', 'banner-about.jpg' );
set_query_var( 'ibanint_banner_sub', '' );
get_template_part( 'template-parts/page-banner' );
/* Unsplash free tier: London city 1766442055053 (banner-about.jpg) */
?>

<section class="ib-intro" id="ib-intro">
	<div class="ib-wrap ib-intro-grid">
		<div class="ib-intro-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Who We Are', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Connecting markets, resources and expertise', 'ibanint' ), 'resources and expertise' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-lead">
				<?php esc_html_e( 'IBAN International is a diversified company active across strategic industries and regions. We connect businesses with investors, producers, developers and other partners.', 'ibanint' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Our work connects trade, infrastructure, resource development, food, logistics and other business areas. We look for opportunities that make commercial sense and create long-term value.', 'ibanint' ); ?>
			</p>
		</div>
		<div class="ib-intro-media ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-markets-port.jpg' ); ?>" alt="<?php esc_attr_e( 'Cargo terminal and cranes seen from above', 'ibanint' ); ?>" width="2200" height="3302" loading="lazy">
		</div>
	</div>
</section>

<section class="ib-approach" id="ib-approach">
	<div class="ib-wrap">
		<div class="ib-head-center">
			<p class="ib-kicker ib-kicker-center"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Our Approach', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Four principles guide our work', 'ibanint' ), 'guide our work' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-lead ib-lead-center">
				<?php esc_html_e( 'We weigh each opportunity against the market, the partners involved and the value it can create over time.', 'ibanint' ); ?>
			</p>
		</div>
		<div class="ib-pillar-grid">
			<?php
			$ibanint_pillars = array(
				array( 'ph-globe-hemisphere-west', 'Global perspective', 'We look across borders for connections between markets, resources and expertise.' ),
				array( 'ph-handshake', 'Strategic partnerships', 'We build relationships around shared commercial interests and clear responsibilities.' ),
				array( 'ph-leaf', 'Responsible growth', 'We consider long-term commercial value and the wider effects of each project we support.' ),
				array( 'ph-check-circle', 'Excellence', 'We set clear objectives, bring the right knowledge to the table and follow through.' ),
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
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'The IBAN advantage', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'One group. Connected opportunities.', 'ibanint' ), 'Connected opportunities.' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-quote-big">
				&ldquo;<?php esc_html_e( 'A commodity opportunity can create a logistics opportunity.', 'ibanint' ); ?>&rdquo;
			</p>
			<p>
				<?php esc_html_e( 'Agricultural production may lead to processing and distribution. Infrastructure may help trade reach a new market. We look across our business areas to connect projects with the partners and resources they need.', 'ibanint' ); ?>
			</p>
		</div>
		<div class="ib-mindset-media ib-reveal">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-advantage-freight.jpg' ); ?>" alt="<?php esc_attr_e( 'Freight containers crossing a road on an elevated route', 'ibanint' ); ?>" width="2200" height="1469" loading="lazy">
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
				esc_html__( '%s business areas, one group. Tell us what you are working on.', 'ibanint' ),
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
