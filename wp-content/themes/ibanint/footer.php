<?php
/**
 * Footer template.
 *
 * @package Ibanint
 */
?>
</main>

<footer class="site-footer">
	<div class="wrap footer-inner">
		<p class="footer-copy">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
			<?php esc_html_e( 'All rights reserved.', 'ibanint' ); ?>
		</p>

		<nav aria-label="<?php esc_attr_e( 'Footer', 'ibanint' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => 'ibanint_footer_fallback',
				)
			);
			?>
		</nav>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
