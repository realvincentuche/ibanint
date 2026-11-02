<?php
/**
 * Interior page banner.
 *
 * Call before this part:
 *   set_query_var( 'ibanint_banner_title', 'Text' );
 *   set_query_var( 'ibanint_banner_image', 'banner-about.jpg' ); // optional
 *   set_query_var( 'ibanint_banner_sub', 'Line' );              // optional
 *
 * @package Ibanint
 */

$ibanint_title = get_query_var( 'ibanint_banner_title' );
$ibanint_image = get_query_var( 'ibanint_banner_image' );
$ibanint_sub   = get_query_var( 'ibanint_banner_sub' );

?>
<section class="ib-banner" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $ibanint_image ); ?>');">
	<div class="ib-banner-shade"></div>
	<div class="ib-wrap ib-banner-inner">
		<p class="ib-kicker ib-kicker-light"><span class="ib-kicker-dash"></span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
		<h1 class="ib-banner-title"><?php echo ibanint_highlight_heading( $ibanint_title ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
		<?php if ( $ibanint_sub ) : ?>
			<p class="ib-banner-sub"><?php echo esc_html( $ibanint_sub ); ?></p>
		<?php endif; ?>
	</div>
</section>
