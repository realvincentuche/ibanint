<?php
/**
 * Ibanint theme setup.
 *
 * @package Ibanint
 */

define( 'IBANINT_VERSION', '0.1.0' );

/**
 * Theme supports, menus.
 */
function ibanint_setup() {
	load_theme_textdomain( 'ibanint', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'ibanint' ),
			'footer'  => __( 'Footer Menu', 'ibanint' ),
		)
	);
}
add_action( 'after_setup_theme', 'ibanint_setup' );

/**
 * Enqueue theme assets.
 */
function ibanint_assets() {
	wp_enqueue_style(
		'ibanint-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		IBANINT_VERSION
	);

	wp_enqueue_script(
		'ibanint-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		IBANINT_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ibanint_assets' );

/**
 * Primary menu fallback.
 */
function ibanint_menu_fallback() {
	echo '<ul class="menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'ibanint' ) . '</a></li>';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 1,
		)
	);
	echo '</ul>';
}

/**
 * Footer menu fallback.
 */
function ibanint_footer_fallback() {
	echo '<ul class="menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'ibanint' ) . '</a></li>';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 1,
		)
	);
	echo '</ul>';
}

/**
 * Required pages for this site.
 *
 * @return array
 */
function ibanint_required_pages() {
	return array(
		'home'     => array( 'Home', '' ),
		'about'    => array( 'About', 'about' ),
		'services' => array( 'Services', 'services' ),
		'contact'  => array( 'Contact', 'contact' ),
	);
}

/**
 * Create pages, set the static front page, flush rewrites.
 */
function ibanint_seed_pages() {
	$front_id = 0;

	foreach ( ibanint_required_pages() as $key => $page ) {
		$slug     = $page[1] ? $page[1] : 'home';
		$existing = get_page_by_path( $slug );

		if ( $existing ) {
			if ( 'home' === $key ) {
				$front_id = (int) $existing->ID;
			}
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'   => $page[0],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);

		if ( $page_id && ! is_wp_error( $page_id ) && 'home' === $key ) {
			$front_id = (int) $page_id;
		}
	}

	if ( $front_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_id );
	}

	flush_rewrite_rules();
}

/**
 * Seed on activation.
 */
function ibanint_seed_on_activate() {
	ibanint_seed_pages();
}
add_action( 'after_switch_theme', 'ibanint_seed_on_activate' );

/**
 * One-click setup notice for FTP-deployed installs.
 */
function ibanint_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$missing = array();

	foreach ( ibanint_required_pages() as $page ) {
		if ( ! get_page_by_path( $page[1] ? $page[1] : 'home' ) ) {
			$missing[] = $page[0];
		}
	}

	if ( ! $missing ) {
		return;
	}

	printf(
		'<div class="notice notice-warning"><p><strong>%s</strong> %s</p><p><a class="button button-primary" href="%s">%s</a></p></div>',
		esc_html__( 'Ibanint setup:', 'ibanint' ),
		esc_html( sprintf( __( 'Missing pages: %s', 'ibanint' ), implode( ', ', $missing ) ) ),
		esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=ibanint_seed' ), 'ibanint_seed' ) ),
		esc_html__( 'Create pages now', 'ibanint' )
	);
}
add_action( 'admin_notices', 'ibanint_setup_notice' );

/**
 * Handle the setup notice action.
 */
function ibanint_handle_seed() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'ibanint' ) );
	}

	check_admin_referer( 'ibanint_seed' );

	ibanint_seed_pages();

	wp_safe_redirect( admin_url( 'edit.php?post_type=page&ibanint_seeded=1' ) );
	exit;
}
add_action( 'admin_post_ibanint_seed', 'ibanint_handle_seed' );
