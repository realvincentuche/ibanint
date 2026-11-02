<?php
/**
 * Template Name: Contact Page
 * Contact Us: profile copy, contact rows, then page content (CF7 lives here).
 *
 * @package Ibanint
 */

get_header();

set_query_var( 'ibanint_banner_title', __( 'Contact Us', 'ibanint' ) );
set_query_var( 'ibanint_banner_image', 'banner-contact.jpg' );
set_query_var( 'ibanint_banner_sub', '' );
get_template_part( 'template-parts/page-banner' );
/* Unsplash free tier: two people talking over a table 1630487656049 (banner-contact.jpg) */
?>

<section class="ib-intro ib-intro-contact" id="ib-contact-intro">
	<div class="ib-wrap ib-intro-grid">
		<div class="ib-intro-copy">
			<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Start Here', 'ibanint' ); ?></p>
			<h2 class="ib-h2"><?php echo ibanint_highlight_heading( __( 'Start a conversation about your project', 'ibanint' ), 'your project' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<p class="ib-lead">
				<?php esc_html_e( 'If you have a project, market, resource or partnership in mind, tell us the business area and region. Investors, producers, developers and institutions are welcome to get in touch.', 'ibanint' ); ?>
			</p>
			<?php
			$ibanint_contact_content = get_post_field( 'post_content', get_queried_object_id() );
			if ( trim( $ibanint_contact_content ) ) :
				?>
				<div class="ib-contact-form ib-prose">
					<?php echo apply_filters( 'the_content', $ibanint_contact_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="ib-contact-cards">
			<?php $ibanint_contact = ibanint_contact(); ?>
			<a class="ib-contact-card ib-reveal" href="<?php echo esc_url( $ibanint_contact['phone_href'] ); ?>">
				<i class="ph ph-phone" aria-hidden="true"></i>
				<span class="screen-reader-text"><?php esc_html_e( 'Phone or WhatsApp: ', 'ibanint' ); ?></span>
				<span class="ib-contact-value"><?php echo esc_html( $ibanint_contact['phone'] ); ?></span>
			</a>
			<?php if ( $ibanint_contact['email'] ) : ?>
				<a class="ib-contact-card ib-reveal" href="<?php echo esc_url( 'mailto:' . $ibanint_contact['email'] ); ?>">
					<i class="ph ph-envelope" aria-hidden="true"></i>
					<span class="ib-contact-value"><?php echo esc_html( $ibanint_contact['email'] ); ?></span>
				</a>
			<?php endif; ?>
			<div class="ib-contact-card ib-reveal">
				<i class="ph ph-map-pin" aria-hidden="true"></i>
				<span class="screen-reader-text"><?php esc_html_e( 'Operating regions: ', 'ibanint' ); ?></span>
				<span class="ib-contact-value"><?php echo esc_html( $ibanint_contact['regions'] ); ?></span>
			</div>
			<div class="ib-contact-card ib-reveal">
				<i class="ph ph-globe-hemisphere-west" aria-hidden="true"></i>
				<span class="screen-reader-text"><?php esc_html_e( 'Company locations: ', 'ibanint' ); ?></span>
				<span class="ib-contact-value"><?php esc_html_e( 'Africa · United States', 'ibanint' ); ?></span>
			</div>
			<a class="ib-contact-card ib-reveal" href="<?php echo esc_url( $ibanint_contact['website_href'] ); ?>">
				<i class="ph ph-globe" aria-hidden="true"></i>
				<span class="ib-contact-value"><?php echo esc_html( $ibanint_contact['website'] ); ?></span>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
