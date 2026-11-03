<?php
/**
 * Header shared by image banners and content pages.
 *
 * @package Ibanint
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ibanint' ); ?></a>

<header class="ib-header<?php echo ( is_front_page() || is_page() || is_home() || is_singular( 'post' ) ) ? ' ib-header-overlay' : ''; ?>" id="ib-header">
	<div class="ib-wrap ib-header-inner">

		<div class="ib-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/ibanint-logo-band-dark.png' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="ib-logo ib-logo-overlay" width="952" height="424" loading="eager">';
					echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/ibanint-logo-band-light.png' ) . '" alt="" aria-hidden="true" class="ib-logo ib-logo-solid" width="952" height="424" loading="eager">';
				}
				?>
			</a>
		</div>

		<nav class="ib-nav" aria-label="<?php esc_attr_e( 'Primary', 'ibanint' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => '',
					'menu_class'     => 'ib-menu',
					'fallback_cb'    => 'ibanint_menu_fallback',
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="ib-btn ib-btn-gold ib-header-cta">
			<?php esc_html_e( 'Partner With Us', 'ibanint' ); ?>
			<i class="ph ph-arrow-right" aria-hidden="true"></i>
		</a>

		<button type="button" class="ib-burger" id="ib-burger" aria-expanded="false" aria-controls="ib-offcanvas" aria-label="<?php esc_attr_e( 'Open menu', 'ibanint' ); ?>">
			<span></span><span></span><span></span>
		</button>

	</div>
</header>

<div class="ib-offcanvas" id="ib-offcanvas" aria-hidden="true">
	<div class="ib-offcanvas-head">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/ibanint-logo-band-dark.png' ); ?>" alt="" class="ib-offcanvas-logo" width="952" height="424" loading="eager">
		<button type="button" class="ib-offcanvas-close" id="ib-offcanvas-close" aria-label="<?php esc_attr_e( 'Close menu', 'ibanint' ); ?>">&times;</button>
	</div>
	<nav class="ib-offcanvas-nav" aria-label="<?php esc_attr_e( 'Mobile', 'ibanint' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_class'     => 'ib-menu ib-menu-mobile',
				'fallback_cb'    => 'ibanint_menu_fallback',
				'depth'          => 2,
			)
		);
		?>
	</nav>
	<div class="ib-offcanvas-foot">
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="ib-btn ib-btn-gold ib-btn-block">
			<?php esc_html_e( 'Partner With Us', 'ibanint' ); ?>
			<i class="ph ph-arrow-right" aria-hidden="true"></i>
		</a>
		<?php $ibanint_c = ibanint_contact(); ?>
		<a class="ib-offcanvas-phone" href="<?php echo esc_url( $ibanint_c['phone_href'] ); ?>">
			<i class="ph ph-phone" aria-hidden="true"></i>
			<span><?php echo esc_html( $ibanint_c['phone'] ); ?></span>
		</a>
	</div>
</div>
<div class="ib-scrim" id="ib-scrim" hidden></div>
