<?php
/**
 * 404.
 *
 * @package Ibanint
 */

get_header();
?>

<section class="ib-notfound">
	<div class="ib-wrap ib-notfound-inner">
		<i class="ph ph-compass" aria-hidden="true"></i>
		<h1><?php esc_html_e( 'Page not found', 'ibanint' ); ?></h1>
		<p><?php esc_html_e( 'This door led nowhere. Try one that is already open.', 'ibanint' ); ?></p>
		<div class="ib-slide-actions">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ib-btn ib-btn-gold">
				<?php esc_html_e( 'Back to Home', 'ibanint' ); ?>
				<i class="ph ph-arrow-right" aria-hidden="true"></i>
			</a>
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="ib-btn ib-btn-ghost-dark">
				<?php esc_html_e( 'Our Businesses', 'ibanint' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
