<?php
/**
 * Template Name: Sector Page
 * Practice-area page used by the eight children of Our Businesses.
 *
 * @package Ibanint
 */

get_header();

global $post;

$ibanint_slug   = $post->post_name;
$ibanint_sectors = ibanint_sectors();
$ibanint_sector  = isset( $ibanint_sectors[ $ibanint_slug ] ) ? $ibanint_sectors[ $ibanint_slug ] : null;
$ibanint_contact_url = home_url( '/contact/' );

if ( $ibanint_sector ) {
	set_query_var( 'ibanint_banner_title', $ibanint_sector['title'] );
	set_query_var( 'ibanint_banner_image', $ibanint_sector['banner'] );
	set_query_var( 'ibanint_banner_sub', '' );
	get_template_part( 'template-parts/page-banner' );
	?>
	<section class="ib-intro" id="ib-sector-intro">
		<div class="ib-wrap ib-intro-grid">
			<div class="ib-intro-copy">
				<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Our Businesses', 'ibanint' ); ?></p>
				<h2 class="ib-h2"><?php echo esc_html( $ibanint_sector['title'] ); ?></h2>
				<p class="ib-lead"><?php echo esc_html( $ibanint_sector['blurb'] ); ?></p>
				<p>
					<?php esc_html_e( 'Every market looks different from the inside. We bring the cross-border view: the partners, the timing, and the doors that make this practice area work in your favour.', 'ibanint' ); ?>
				</p>
				<div class="ib-connection ib-connection-block">
					<i class="ph ph-arrows-clockwise" aria-hidden="true"></i>
					<p><?php echo esc_html( $ibanint_sector['connection'] ); ?></p>
				</div>
				<div class="ib-slide-actions">
					<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="ib-btn ib-btn-ghost-dark">
						<i class="ph ph-arrow-left" aria-hidden="true"></i>
						<?php esc_html_e( 'All businesses', 'ibanint' ); ?>
					</a>
					<a href="<?php echo esc_url( $ibanint_contact_url ); ?>" class="ib-btn ib-btn-gold">
						<?php esc_html_e( 'Partner With Us', 'ibanint' ); ?>
						<i class="ph ph-arrow-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
			<div class="ib-intro-media ib-reveal">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $ibanint_sector['banner'] ); ?>" alt="<?php echo esc_attr( $ibanint_sector['title'] ); ?>" loading="lazy">
			</div>
		</div>
	</section>

	<section class="ib-sector-nav-section" id="ib-sector-nav">
		<div class="ib-wrap">
			<h2 class="ib-h2 ib-h2-small"><?php esc_html_e( 'Connected across the group', 'ibanint' ); ?></h2>
			<div class="ib-sector-nav-grid">
				<?php
				$ib_slugs = array_keys( $ibanint_sectors );
				$ib_pos   = array_search( $ibanint_slug, $ib_slugs, true );
				$ib_nav   = array(
					array( 'ph-arrow-left', $ib_slugs[ ( $ib_pos - 1 + count( $ib_slugs ) ) % count( $ib_slugs ) ] ),
					array( 'ph-arrow-right', $ib_slugs[ ( $ib_pos + 1 ) % count( $ib_slugs ) ] ),
				);
				foreach ( $ib_nav as $ib_item ) :
					$ib_sector = $ibanint_sectors[ $ib_item[1] ];
					$ib_page   = get_page_by_path( 'services/' . $ib_item[1] );
					if ( ! $ib_page ) {
						continue;
					}
					?>
					<a class="ib-sector-nav-card" href="<?php echo esc_url( get_permalink( $ib_page ) ); ?>">
						<i class="ph <?php echo esc_attr( $ib_item[0] ); ?>" aria-hidden="true"></i>
						<span class="ib-sector-nav-label"><?php echo esc_html( 0 === strpos( $ib_item[0], 'ph-arrow-l' ) ? __( 'Previous', 'ibanint' ) : __( 'Next', 'ibanint' ) ); ?></span>
						<span class="ib-sector-nav-title"><?php echo esc_html( $ib_sector['title'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
} else {
	set_query_var( 'ibanint_banner_title', get_the_title() );
	set_query_var( 'ibanint_banner_image', 'banner-services.jpg' );
	set_query_var( 'ibanint_banner_sub', '' );
	get_template_part( 'template-parts/page-banner' );
}
?>

<?php get_template_part( 'template-parts/dynamic-content' ); ?>

<?php
get_footer();
