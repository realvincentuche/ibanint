<?php
/**
 * Dynamic content strip.
 *
 * Renders the page content (and any shortcode inside it, e.g. CF7)
 * only when the editor actually contains something.
 *
 * @package Ibanint
 */

$ibanint_content = '';

if ( is_page() && ! is_front_page() ) {
	$ibanint_content = get_the_content();
} elseif ( is_front_page() ) {
	$ibanint_front_page = get_option( 'page_on_front' );
	if ( $ibanint_front_page ) {
		$ibanint_content = get_post_field( 'post_content', $ibanint_front_page );
	}
}

if ( '' === trim( wp_strip_all_tags( $ibanint_content ) ) ) {
	return;
}
?>
<section class="ib-dynamic" id="ib-dynamic">
	<div class="ib-wrap">
		<div class="ib-prose">
			<?php echo apply_filters( 'the_content', $ibanint_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>
</section>
