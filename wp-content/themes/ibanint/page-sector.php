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
$ibanint_is_food = 'agriculture-food' === $ibanint_slug;
$ibanint_is_logistics = 'transportation-logistics' === $ibanint_slug;
$ibanint_is_mining = 'mining-natural-resources' === $ibanint_slug;
$ibanint_is_real_estate = 'real-estate-development' === $ibanint_slug;
$ibanint_intro_alt = $ibanint_sector ? $ibanint_sector['title'] : '';
if ( $ibanint_is_logistics ) {
	$ibanint_intro_alt = __( 'White Volvo truck viewed from the front', 'ibanint' );
} elseif ( $ibanint_is_mining ) {
	$ibanint_intro_alt = __( 'People at an open excavation site', 'ibanint' );
}

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
				<h2 class="ib-h2"><?php echo ibanint_highlight_heading( $ibanint_sector['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
				<p class="ib-lead"><?php echo esc_html( $ibanint_sector['blurb'] ); ?></p>
				<p>
					<?php echo esc_html( $ibanint_sector['detail'] ); ?>
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
				<?php if ( $ibanint_is_food ) : ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food-hibiscus.jpg' ); ?>" alt="<?php esc_attr_e( 'Dried hibiscus flowers being handled over a sack', 'ibanint' ); ?>" width="1200" height="1800" loading="lazy">
					<p class="ib-food-image-note"><?php esc_html_e( 'Hibiscus (roselle) · Illustrative photograph', 'ibanint' ); ?></p>
				<?php else : ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . ( $ibanint_sector['intro_image'] ?? $ibanint_sector['banner'] ) ); ?>" alt="<?php echo esc_attr( $ibanint_intro_alt ); ?>" loading="lazy">
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ( $ibanint_is_food ) : ?>
	<section class="ib-food-media" id="ib-food-media" aria-labelledby="ib-food-media-title">
		<div class="ib-wrap">
			<div class="ib-food-media-head">
				<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Product perspectives', 'ibanint' ); ?></p>
				<h2 class="ib-h2" id="ib-food-media-title"><?php echo ibanint_highlight_heading( __( 'Agriculture in focus', 'ibanint' ), 'in focus' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
				<p><?php esc_html_e( 'A closer view of dried hibiscus handling and cashew kernels.', 'ibanint' ); ?></p>
			</div>
			<div class="ib-food-media-grid">
				<figure class="ib-food-media-item ib-food-media-video ib-reveal">
					<div class="ib-food-media-visual">
						<video controls playsinline preload="none" poster="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food-hibiscus-video-poster.jpg' ); ?>" width="352" height="624" aria-label="<?php esc_attr_e( 'Dried hibiscus product footage', 'ibanint' ); ?>">
							<source src="<?php echo esc_url( get_template_directory_uri() . '/assets/video/food-hibiscus.mp4' ); ?>" type="video/mp4">
							<a href="<?php echo esc_url( get_template_directory_uri() . '/assets/video/food-hibiscus.mp4' ); ?>"><?php esc_html_e( 'Download the hibiscus video', 'ibanint' ); ?></a>
						</video>
					</div>
					<figcaption>
						<span class="ib-food-media-label"><?php esc_html_e( '01 / Product footage', 'ibanint' ); ?></span>
						<h3><?php esc_html_e( 'Hibiscus handling', 'ibanint' ); ?></h3>
						<p><?php esc_html_e( 'A closer look at hibiscus (roselle) handling and packed stock.', 'ibanint' ); ?></p>
					</figcaption>
				</figure>
				<figure class="ib-food-media-item ib-food-media-photo ib-reveal">
					<div class="ib-food-media-visual">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food-hibiscus-client.jpg' ); ?>" alt="<?php esc_attr_e( 'Close-up of dried hibiscus calyces', 'ibanint' ); ?>" width="769" height="1080" loading="lazy">
					</div>
					<figcaption>
						<span class="ib-food-media-label"><?php esc_html_e( '02 / Product image', 'ibanint' ); ?></span>
						<h3><?php esc_html_e( 'Dried hibiscus', 'ibanint' ); ?></h3>
						<p><?php esc_html_e( 'A close view of the dried product.', 'ibanint' ); ?></p>
					</figcaption>
				</figure>
				<figure class="ib-food-media-item ib-food-media-photo ib-reveal">
					<div class="ib-food-media-visual">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food-cashews.jpg' ); ?>" alt="<?php esc_attr_e( 'Packaged cashew kernels with a W240 sample label', 'ibanint' ); ?>" width="607" height="1080" loading="lazy">
					</div>
					<figcaption>
						<span class="ib-food-media-label"><?php esc_html_e( '03 / Product image', 'ibanint' ); ?></span>
						<h3><?php esc_html_e( 'Cashew kernels', 'ibanint' ); ?></h3>
						<p><?php esc_html_e( 'A close view of a cashew product sample.', 'ibanint' ); ?></p>
					</figcaption>
				</figure>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $ibanint_is_real_estate ) : ?>
	<section class="ib-estate-media" id="ib-estate-media" aria-labelledby="ib-estate-media-title">
		<div class="ib-wrap ib-estate-media-grid">
			<div class="ib-estate-media-copy ib-reveal">
				<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Location perspective', 'ibanint' ); ?></p>
				<h2 class="ib-h2" id="ib-estate-media-title"><?php echo ibanint_highlight_heading( __( 'See the setting', 'ibanint' ), 'the setting' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
				<p><?php esc_html_e( 'A short view of a coastal setting, captured during a location visit.', 'ibanint' ); ?></p>
				<div class="ib-estate-media-rule" aria-hidden="true"></div>
				<span class="ib-estate-media-meta"><?php esc_html_e( '01 / Location footage', 'ibanint' ); ?></span>
			</div>
			<div class="ib-estate-media-player ib-reveal">
				<video controls playsinline preload="none" poster="<?php echo esc_url( get_template_directory_uri() . '/assets/images/real-estate-visit-poster.jpg' ); ?>" width="464" height="832" aria-label="<?php esc_attr_e( 'Video of a coastal location visit', 'ibanint' ); ?>">
					<source src="<?php echo esc_url( get_template_directory_uri() . '/assets/video/real-estate-visit.mp4' ); ?>" type="video/mp4">
					<a href="<?php echo esc_url( get_template_directory_uri() . '/assets/video/real-estate-visit.mp4' ); ?>"><?php esc_html_e( 'Download the location video', 'ibanint' ); ?></a>
				</video>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $ibanint_is_mining ) : ?>
	<section class="ib-mining-media" id="ib-mining-media" aria-labelledby="ib-mining-media-title">
		<div class="ib-wrap">
			<div class="ib-mining-media-head">
				<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'From the field', 'ibanint' ); ?></p>
				<h2 class="ib-h2" id="ib-mining-media-title"><?php echo ibanint_highlight_heading( __( 'Mining in motion', 'ibanint' ), 'in motion' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
				<p><?php esc_html_e( 'Field footage, metal processing and two product photographs.', 'ibanint' ); ?></p>
			</div>
			<div class="ib-mining-media-grid">
				<figure class="ib-mining-media-video ib-reveal">
					<div class="ib-mining-media-video-frame">
						<video controls playsinline preload="none" poster="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mining-operation-poster.jpg' ); ?>" width="848" height="480" aria-label="<?php esc_attr_e( 'Excavator loading a truck at a mining site', 'ibanint' ); ?>">
							<source src="<?php echo esc_url( get_template_directory_uri() . '/assets/video/mining-operation.mp4' ); ?>" type="video/mp4">
							<a href="<?php echo esc_url( get_template_directory_uri() . '/assets/video/mining-operation.mp4' ); ?>"><?php esc_html_e( 'Download the mining operation video', 'ibanint' ); ?></a>
						</video>
					</div>
					<figcaption><span>01 / <?php esc_html_e( 'Field footage', 'ibanint' ); ?></span><strong><?php esc_html_e( 'On-site operations', 'ibanint' ); ?></strong><p><?php esc_html_e( 'Excavation and haulage equipment at work.', 'ibanint' ); ?></p></figcaption>
				</figure>
				<figure class="ib-mining-media-photo ib-reveal">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mining-gold.jpg' ); ?>" alt="<?php esc_attr_e( 'Three gold-coloured metal bars on a table', 'ibanint' ); ?>" width="810" height="1080" loading="lazy">
					<figcaption><span>02 / <?php esc_html_e( 'Material sample', 'ibanint' ); ?></span><strong><?php esc_html_e( 'Gold sample', 'ibanint' ); ?></strong><p><?php esc_html_e( 'A closer view of a supplied material photograph.', 'ibanint' ); ?></p></figcaption>
				</figure>
			</div>
			<div class="ib-mining-media-grid ib-mining-media-grid-secondary">
				<figure class="ib-mining-media-photo ib-reveal">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mining-gold-scale.jpg' ); ?>" alt="<?php esc_attr_e( 'Two gold-coloured bars on a digital scale', 'ibanint' ); ?>" width="1080" height="810" loading="lazy">
					<figcaption><span>03 / <?php esc_html_e( 'Material detail', 'ibanint' ); ?></span><strong><?php esc_html_e( 'Gold on the scale', 'ibanint' ); ?></strong><p><?php esc_html_e( 'A second view of the supplied bars.', 'ibanint' ); ?></p></figcaption>
				</figure>
				<figure class="ib-mining-media-video ib-mining-media-video-portrait ib-reveal">
					<div class="ib-mining-media-video-frame">
						<video controls playsinline preload="none" poster="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mining-process-poster.jpg' ); ?>" width="480" height="848" aria-label="<?php esc_attr_e( 'High-temperature metal processing footage', 'ibanint' ); ?>">
							<source src="<?php echo esc_url( get_template_directory_uri() . '/assets/video/mining-process.mp4' ); ?>" type="video/mp4">
							<a href="<?php echo esc_url( get_template_directory_uri() . '/assets/video/mining-process.mp4' ); ?>"><?php esc_html_e( 'Download the metal processing video', 'ibanint' ); ?></a>
						</video>
					</div>
					<figcaption><span>04 / <?php esc_html_e( 'Processing footage', 'ibanint' ); ?></span><strong><?php esc_html_e( 'Metal processing', 'ibanint' ); ?></strong><p><?php esc_html_e( 'Molten metal being handled at high temperature.', 'ibanint' ); ?></p></figcaption>
				</figure>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $ibanint_is_logistics ) : ?>
	<section class="ib-logistics-media" id="ib-logistics-media" aria-labelledby="ib-logistics-media-title">
		<div class="ib-wrap">
			<div class="ib-logistics-media-head">
				<div>
					<p class="ib-kicker"><span class="ib-kicker-dash"></span><?php esc_html_e( 'Road transport', 'ibanint' ); ?></p>
					<h2 class="ib-h2" id="ib-logistics-media-title"><?php echo ibanint_highlight_heading( __( 'A closer view of logistics', 'ibanint' ), 'logistics' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
				</div>
				<p><?php esc_html_e( 'Selected views of the vehicles and equipment behind road transport.', 'ibanint' ); ?></p>
			</div>
			<div class="ib-logistics-media-grid">
				<figure class="ib-logistics-media-item ib-logistics-media-wide ib-reveal">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logistics-lineup.jpg' ); ?>" alt="<?php esc_attr_e( 'Several heavy trucks parked in a transport yard', 'ibanint' ); ?>" width="1600" height="738" loading="lazy">
					<figcaption><span>01 / <?php esc_html_e( 'Fleet', 'ibanint' ); ?></span><?php esc_html_e( 'Road transport equipment', 'ibanint' ); ?></figcaption>
				</figure>
				<figure class="ib-logistics-media-item ib-reveal">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logistics-scania.jpg' ); ?>" alt="<?php esc_attr_e( 'White Scania truck photographed in a vehicle yard', 'ibanint' ); ?>" width="1600" height="738" loading="lazy">
					<figcaption><span>02 / <?php esc_html_e( 'Vehicle', 'ibanint' ); ?></span><?php esc_html_e( 'Heavy-duty truck', 'ibanint' ); ?></figcaption>
				</figure>
				<figure class="ib-logistics-media-item ib-reveal">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logistics-chassis.jpg' ); ?>" alt="<?php esc_attr_e( 'Rear view of a heavy truck chassis', 'ibanint' ); ?>" width="1600" height="1200" loading="lazy">
					<figcaption><span>03 / <?php esc_html_e( 'Detail', 'ibanint' ); ?></span><?php esc_html_e( 'Truck chassis', 'ibanint' ); ?></figcaption>
				</figure>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="ib-sector-nav-section" id="ib-sector-nav">
		<div class="ib-wrap">
			<h2 class="ib-h2 ib-h2-small"><?php echo ibanint_highlight_heading( __( 'Connected across the group', 'ibanint' ), 'across the group' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
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
