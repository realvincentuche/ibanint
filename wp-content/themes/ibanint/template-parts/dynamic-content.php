<?php
/**
 * Optional page content strip.
 *
 * Renders the page content (and any shortcode inside it) only when
 * the editor actually contains something.
 *
 * @package Ibanint
 */

$ibanint_content = '';

if ( is_page() && ! is_front_page() ) {
	$ibanint_content = get_the_content();
} elseif ( is_front_page() ) {
	$ibanint_page = get_option( 'page_on_front' );

	if ( $ibanint_page ) {
		$ibanint_content = get_post_field( 'post_content', $ibanint_page );
	}
}

if ( '' === trim( wp_strip_all_tags( $ibanint_content ) ) ) {
	return;
}
?>
<section class="section dynamic-content">
	<div class="wrap prose">
		<?php echo apply_filters( 'the_content', $ibanint_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>
