<?php
/**
 * IBAN International theme setup, helpers and seeder.
 *
 * @package Ibanint
 */

define( 'IBANINT_VERSION', '0.2.28' );

/** Keep the brand capitalized in older WordPress content and site settings. */
function ibanint_capitalize_brand( $name ) {
	return preg_replace( '/\biban\b/i', 'IBAN', $name );
}
add_filter( 'option_blogname', 'ibanint_capitalize_brand' );
add_filter( 'the_title', 'ibanint_capitalize_brand' );
add_filter( 'the_content', 'ibanint_capitalize_brand' );

/**
 * Escape a heading and color one meaningful phrase.
 *
 * @param string $text   Full heading.
 * @param string $phrase Phrase to highlight; defaults to the final word.
 * @return string Safe heading markup.
 */
function ibanint_highlight_heading( $text, $phrase = '' ) {
	if ( '' === $phrase ) {
		$last_space = strrpos( $text, ' ' );
		$phrase     = false === $last_space ? '' : substr( $text, $last_space + 1 );
	}
	$position = $phrase ? strpos( $text, $phrase ) : false;
	if ( false === $position ) {
		return esc_html( $text );
	}
	return esc_html( substr( $text, 0, $position ) ) . '<span class="ib-highlight">' . esc_html( $phrase ) . '</span>' . esc_html( substr( $text, $position + strlen( $phrase ) ) );
}

/**
 * Theme supports and menu locations.
 */
function ibanint_setup() {
	load_theme_textdomain( 'ibanint', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 212,
			'width'       => 952,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'ibanint' ),
			'footer'  => __( 'Footer Legal Menu', 'ibanint' ),
		)
	);
}
add_action( 'after_setup_theme', 'ibanint_setup' );

/**
 * Content width.
 */
function ibanint_content_width() {
	$GLOBALS['content_width'] = 1240;
}
add_action( 'after_setup_theme', 'ibanint_content_width', 0 );

/** Enqueue theme assets. */
function ibanint_assets() {
	wp_enqueue_style( 'ibanint-style', get_stylesheet_uri(), array(), IBANINT_VERSION );
	wp_enqueue_style( 'ibanint-phosphor', get_template_directory_uri() . '/assets/css/phosphor-icon-regular.css', array(), IBANINT_VERSION );
	wp_enqueue_style( 'ibanint-main', get_template_directory_uri() . '/assets/css/main.css', array( 'ibanint-style', 'ibanint-phosphor' ), IBANINT_VERSION );

	wp_enqueue_script( 'ibanint-main', get_template_directory_uri() . '/assets/js/main.js', array(), IBANINT_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'ibanint_assets' );

/**
 * Preload the fonts used for the first screen of content.
 */
function ibanint_preload_fonts() {
	foreach ( array( 'barlow-semi-condensed-700-latin.woff2', 'barlow-semi-condensed-600-latin.woff2', 'dm-sans-400-700-latin.woff2' ) as $font ) {
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( get_template_directory_uri() . '/assets/fonts/' . $font ) );
	}
}
add_action( 'wp_head', 'ibanint_preload_fonts', 1 );

/**
 * Favicon (theme asset, used when the site icon is not set).
 */
function ibanint_site_icon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	printf(
		'<link rel="icon" href="%s" sizes="any" type="image/png">',
		esc_url( get_template_directory_uri() . '/assets/images/favicon.png' )
	);
}
add_action( 'wp_head', 'ibanint_site_icon', 2 );

/** Page-specific summary and image for search and link previews. */
function ibanint_seo_page_data() {
	$default = array(
		'description' => 'IBAN International connects businesses, investors and project partners across trade, energy, food, logistics, infrastructure, real estate, waste and mining.',
		'image'       => 'logistics-banner.jpg',
	);

	if ( is_front_page() ) {
		return $default;
	}
	if ( is_home() ) {
		return array( 'description' => 'News, updates and events from IBAN International Ltd.', 'image' => 'banner-news.jpg' );
	}
	if ( is_singular( 'post' ) ) {
		$excerpt = get_the_excerpt( get_queried_object_id() );
		return array(
			'description' => $excerpt ? wp_trim_words( wp_strip_all_tags( $excerpt ), 28, '' ) : $default['description'],
			'image'       => has_post_thumbnail( get_queried_object_id() ) ? get_the_post_thumbnail_url( get_queried_object_id(), 'full' ) : 'banner-news.jpg',
		);
	}

	$slug    = get_post_field( 'post_name', get_queried_object_id() );
	$sectors = ibanint_sectors();
	if ( isset( $sectors[ $slug ] ) ) {
		return array( 'description' => $sectors[ $slug ]['blurb'], 'image' => $sectors[ $slug ]['banner'] );
	}

	$pages = array(
		'about'          => array( 'description' => 'Learn how IBAN International connects markets, resources and expertise through partnerships across eight business areas.', 'image' => 'banner-about.jpg' ),
		'services'       => array( 'description' => 'Explore the eight business areas of IBAN International, from trade and energy to agriculture, logistics and natural resources.', 'image' => 'banner-services.jpg' ),
		'contact'        => array( 'description' => 'Contact IBAN International Ltd about a project, market or partnership. Email info@ibanint.com or call +255 762 199 712.', 'image' => 'banner-contact.jpg' ),
		'privacy-policy' => array( 'description' => 'How IBAN International Ltd handles website inquiries, technical data and privacy requests.', 'image' => 'banner-privacy.jpg' ),
		'terms-of-use'   => array( 'description' => 'The terms that apply when using the IBAN International Ltd website.', 'image' => 'banner-terms.jpg' ),
	);
	return $pages[ $slug ] ?? $default;
}

/** Avoid duplicate metadata if a dedicated SEO plugin takes over. */
function ibanint_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/** Basic search and social preview metadata. WordPress supplies singular canonicals. */
function ibanint_seo_head() {
	if ( is_admin() || is_search() || is_404() || ibanint_has_seo_plugin() ) {
		return;
	}

	$data  = ibanint_seo_page_data();
	$title = wp_get_document_title();
	if ( is_front_page() ) {
		$url = home_url( '/' );
	} elseif ( is_home() ) {
		$url = get_permalink( get_option( 'page_for_posts' ) );
	} elseif ( is_singular() ) {
		$url = get_permalink( get_queried_object_id() );
	} else {
		$url = get_pagenum_link( max( 1, (int) get_query_var( 'paged' ) ) );
	}
	$image = 0 === strpos( $data['image'], 'http' ) ? $data['image'] : get_template_directory_uri() . '/assets/images/' . $data['image'];

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $data['description'] ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $data['description'] ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $data['description'] ) );

	if ( ! is_singular() ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
	}

	if ( is_front_page() ) {
		$organization = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Organization',
			'name'     => 'IBAN International Ltd',
			'url'      => home_url( '/' ),
			'logo'     => get_template_directory_uri() . '/assets/images/ibanint-logo-transparent.png',
			'email'    => ibanint_contact()['email'],
			'telephone'=> array_column( ibanint_contact()['phones'], 'label' ),
		);
		printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $organization, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
	}
}
add_action( 'wp_head', 'ibanint_seo_head', 5 );

/**
 * Site contact details.
 *
 * @return array
 */
function ibanint_contact() {
	$phones = array(
		array( 'label' => '+255 762 199 712', 'href' => 'tel:+255762199712' ),
		array( 'label' => '+255 767 680 442', 'href' => 'tel:+255767680442' ),
		array( 'label' => '+1 917 566 4723', 'href' => 'tel:+19175664723' ),
	);
	return array(
		'name'        => 'IBAN International Ltd',
		'tagline'     => 'Global Opportunities. Strategic Solutions. Lasting Value.',
		'phone'       => $phones[0]['label'],
		'phone_href'  => $phones[0]['href'],
		'phones'      => $phones,
		'website'     => 'ibanint.com',
		'website_href'=> 'https://ibanint.com',
		'regions'     => 'Africa | Europe | Asia | Middle East | North America',
		'email'       => 'info@ibanint.com',
	);
}

/**
 * The eight practice areas.
 *
 * Title, icon, sector summary, supporting detail, imagery and a
 * cross-sector connection drawn from the company profile.
 *
 * @return array
 */
function ibanint_sectors() {
	return array(
		'international-commodity-trade' => array(
			'title'      => 'International & Commodity Trade',
			'short'      => 'Trade',
			'icon'       => 'ph-arrows-left-right',
			'blurb'      => 'We connect producers and suppliers with buyers in other markets, helping partners develop workable cross-border trade.',
			'detail'     => 'We consider the product, the buyer, the route to market and the relationships needed to make a trade work.',
			'banner'     => 'banner-trade.jpg',
			'connection' => 'A commodity opportunity can create a logistics opportunity.',
		),
		'energy'                        => array(
			'title'      => 'Energy',
			'short'      => 'Energy',
			'icon'       => 'ph-lightning',
			'blurb'      => 'We network with partners to develop energy projects with a clear commercial case.',
			'detail'     => 'Our focus is on opportunities where demand, resources and development partners can come together.',
			'banner'     => 'banner-energy.jpg',
			'connection' => 'Energy can support production and processing.',
		),
		'agriculture-food'              => array(
			'title'      => 'Agriculture & Food',
			'short'      => 'Agriculture',
			'icon'       => 'ph-basket',
			'blurb'      => 'From agricultural production and food processing to packaging and distribution, we support opportunities across the food value chain.',
			'detail'     => 'We consider production, processing, packaging and distribution as connected parts of the same opportunity.',
			'banner'     => 'banner-agriculture.jpg',
			'listing_image' => 'food-hibiscus.jpg',
			'connection' => 'An agricultural project can create processing and distribution opportunities.',
		),
		'transportation-logistics'      => array(
			'title'      => 'Transportation & Logistics',
			'short'      => 'Logistics',
			'icon'       => 'ph-truck',
			'blurb'      => 'We connect transport, distribution and infrastructure partners to help goods move between markets.',
			'detail'     => 'Transport plans need to reflect the routes, partners and markets involved.',
			'banner'     => 'logistics-banner.jpg',
			'intro_image' => 'logistics-intro.jpg',
			'connection' => 'Transport connects producers with buyers.',
		),
		'infrastructure-advisory'       => array(
			'title'      => 'Infrastructure Advisory',
			'short'      => 'Infrastructure',
			'icon'       => 'ph-bridge',
			'blurb'      => 'We advise on infrastructure opportunities, helping partners shape projects and find the resources to develop them.',
			'detail'     => 'We help clarify a project early, when the right partners and resources can still change the outcome.',
			'banner'     => 'banner-infrastructure.jpg',
			'connection' => 'Infrastructure can unlock trade.',
		),
		'real-estate-development'       => array(
			'title'      => 'Real Estate Development',
			'short'      => 'Real Estate',
			'icon'       => 'ph-house-line',
			'blurb'      => 'Identifying and developing commercially valuable real estate opportunities with a focus on sustainable, long-term growth.',
			'detail'     => 'We look for developments with a sound commercial case and room for long-term value.',
			'banner'     => 'banner-realestate.jpg',
			'connection' => 'Real estate can support commercial growth.',
		),
		'waste-management'              => array(
			'title'      => 'Waste Management',
			'short'      => 'Waste',
			'icon'       => 'ph-recycle',
			'blurb'      => 'We work across collection, recovery and recycling to turn waste into usable resources and commercial opportunities.',
			'detail'     => 'Collection and recovery plans work best when there is a clear use or market for the material.',
			'banner'     => 'banner-waste.jpg',
			'connection' => 'Waste can become a resource.',
		),
		'mining-natural-resources'      => array(
			'title'      => 'Mining & Natural Resources',
			'short'      => 'Mining',
			'icon'       => 'ph-mountains',
			'blurb'      => 'We explore mining and natural resource projects with attention to responsible development and long-term value.',
			'detail'     => 'We consider the resource, the development plan and the partners needed to move a project forward.',
			'banner'     => 'banner-mining.jpg',
			'intro_image' => 'mining-site.jpg',
			'listing_image' => 'mining-site.jpg',
			'connection' => 'Resource projects may call for infrastructure and transport.',
		),
	);
}

/**
 * Structured pages: slug => [title, template, parent-slug, is-front, is-posts].
 *
 * @return array
 */
function ibanint_site_pages() {
	$pages = array(
		'home'      => array( 'Home', '', '', 1, 0 ),
		'about'     => array( 'About Us', 'page-about.php', '', 0, 0 ),
		'services'  => array( 'Our Businesses', 'page-services.php', '', 0, 0 ),
		'contact'   => array( 'Contact Us', 'page-contact.php', '', 0, 0 ),
		'news'      => array( 'News', '', '', 0, 1 ),
	);

	foreach ( ibanint_sectors() as $slug => $sector ) {
		$pages[ $slug ] = array( $sector['title'], 'page-sector.php', 'services', 0, 0 );
	}

	return $pages;
}

/**
 * Seed pages, menus and options. Runs on activation or on demand.
 * Existing pages and menus are never overwritten.
 */
function ibanint_seed_site() {
	$pages      = ibanint_site_pages();
	$created    = array();
	$services_id = 0;
	$front_id   = 0;
	$news_id    = 0;

	foreach ( $pages as $slug => $data ) {
		if ( isset( $created[ $slug ] ) ) {
			continue;
		}
		$existing = get_page_by_path( $slug );
		if ( $existing && 'publish' === $existing->post_status ) {
			$created[ $slug ] = (int) $existing->ID;
		} elseif ( $existing ) {
			$created[ $slug ] = (int) $existing->ID;
		} else {
			$page_id = wp_insert_post(
				array(
					'post_title'   => $data[0],
					'post_name'    => $slug,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
				)
			);
			if ( $page_id && ! is_wp_error( $page_id ) ) {
				$created[ $slug ] = (int) $page_id;
			}
		}
	}

	if ( isset( $created['services'] ) ) {
		$services_id = $created['services'];
	}

	// Pass 2: sector children + templates.
	foreach ( ibanint_sectors() as $slug => $sector ) {
		if ( ! isset( $created[ $slug ] ) ) {
			continue;
		}
		$sector_id = $created[ $slug ];

		if ( $services_id && $sector_id ) {
			$post = get_post( $sector_id );
			if ( $post && (int) $post->post_parent !== (int) $services_id ) {
				wp_update_post(
					array(
						'ID'          => $sector_id,
						'post_parent' => $services_id,
					)
				);
			}
		}

		$template = get_post_meta( $sector_id, '_wp_page_template', true );
		if ( ! $template || 'default' === $template ) {
			update_post_meta( $sector_id, '_wp_page_template', 'page-sector.php' );
		}
	}

	if ( isset( $created['about'] ) ) {
		$template = get_post_meta( $created['about'], '_wp_page_template', true );
		if ( ! $template || 'default' === $template ) {
			update_post_meta( $created['about'], '_wp_page_template', 'page-about.php' );
		}
	}
	if ( isset( $created['services'] ) ) {
		$template = get_post_meta( $created['services'], '_wp_page_template', true );
		if ( ! $template || 'default' === $template ) {
			update_post_meta( $created['services'], '_wp_page_template', 'page-services.php' );
		}
	}
	if ( isset( $created['contact'] ) ) {
		$template = get_post_meta( $created['contact'], '_wp_page_template', true );
		if ( ! $template || 'default' === $template ) {
			update_post_meta( $created['contact'], '_wp_page_template', 'page-contact.php' );
		}
	}

	// Reading settings.
	$front_id = isset( $created['home'] ) ? $created['home'] : 0;
	$news_id  = isset( $created['news'] ) ? $created['news'] : 0;

	if ( $front_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_id );
	}
	if ( $news_id ) {
		update_option( 'page_for_posts', $news_id );
	}

	// Site identity.
	update_option( 'blogname', 'IBAN International Ltd' );
	update_option( 'blogdescription', 'Global Opportunities. Strategic Solutions. Lasting Value.' );

	// Publish the existing privacy draft.
	$privacy = get_page_by_path( 'privacy-policy' );
	if ( $privacy && 'draft' === get_post_status( $privacy ) ) {
		wp_update_post(
			array(
				'ID'          => $privacy->ID,
				'post_status' => 'publish',
			)
		);
	}

	// Trash default content.
	$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( ! $hello ) {
		$hello_post = get_posts(
			array(
				'title'        => 'Hello world!',
				'numberposts'  => 1,
				'post_type'    => 'post',
				'post_status'  => 'any',
				'fields'       => 'ids',
			)
		);
		if ( ! empty( $hello_post ) ) {
			wp_trash_post( $hello_post[0] );
		}
	} elseif ( $hello && 'publish' === get_post_status( $hello ) ) {
		wp_trash_post( $hello->ID );
	}

	$sample = get_page_by_path( 'sample-page' );
	if ( $sample && 'publish' === get_post_status( $sample ) ) {
		wp_trash_post( $sample->ID );
	}

	// Primary navigation menu.
	ibanint_seed_menu();

	flush_rewrite_rules();

	return $created;
}

/**
 * Create the primary menu with Our Businesses dropdown, if absent.
 */
function ibanint_seed_menu() {
	$existing = wp_get_nav_menu_object( 'Primary' );
	if ( $existing ) {
		return;
	}

	$menu_id = wp_create_nav_menu( 'Primary' );
	if ( is_wp_error( $menu_id ) || ! $menu_id ) {
		return;
	}

	$items = array(
		array( 'Home', 'home' ),
		array( 'About Us', 'about' ),
		array( 'Our Businesses', 'services' ),
		array( 'News', 'news' ),
		array( 'Contact Us', 'contact' ),
	);

	foreach ( $items as $item ) {
		$page = get_page_by_path( $item[1] );
		if ( ! $page ) {
			continue;
		}
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $item[0],
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page->ID,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	// Child items under Our Businesses.
	$services_page = get_page_by_path( 'services' );
	if ( $services_page ) {
		$parent_item_id = 0;
		foreach ( wp_get_nav_menu_items( $menu_id ) as $candidate ) {
			if ( (int) $candidate->object_id === (int) $services_page->ID ) {
				$parent_item_id = (int) $candidate->ID;
				break;
			}
		}

		if ( $parent_item_id ) {
			foreach ( ibanint_sectors() as $slug => $sector ) {
				$sector_page = get_page_by_path( 'services/' . $slug );
				if ( $sector_page ) {
					wp_update_nav_menu_item(
						$menu_id,
						0,
						array(
							'menu-item-title'     => $sector['title'],
							'menu-item-object'    => 'page',
							'menu-item-object-id' => $sector_page->ID,
							'menu-item-type'      => 'post_type',
							'menu-item-status'    => 'publish',
							'menu-item-parent-id' => $parent_item_id,
						)
					);
				}
			}
		}
	}

	$locations           = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Primary menu fallback matching the seeded structure.
 */
function ibanint_menu_fallback() {
	$items = array(
		array( 'home', __( 'Home', 'ibanint' ) ),
		array( 'about', __( 'About', 'ibanint' ) ),
		array( 'services', __( 'Our Businesses', 'ibanint' ) ),
		array( 'news', __( 'News', 'ibanint' ) ),
		array( 'contact', __( 'Contact', 'ibanint' ) ),
	);

	echo '<ul class="menu">';
	foreach ( $items as $item ) {
		$page = get_page_by_path( $item[0] );
		if ( ! $page ) {
			continue;
		}
		$classes = array( 'menu-item' );
		$is_active = is_page( $item[0] );
		if ( $is_active ) {
			$classes[] = 'current-menu-item';
		}
		if ( 'services' === $item[0] ) {
			$classes[] = 'menu-item-has-children';
		}
		echo '<li class="' . esc_attr( implode( ' ', $classes ) ) . '"><a href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( $item[1] ) . '</a>';

		if ( 'services' === $item[0] ) {
			echo '<ul class="sub-menu">';
			foreach ( ibanint_sectors() as $slug => $sector ) {
				$sector_page = get_page_by_path( 'services/' . $slug );
				if ( $sector_page ) {
					$active = is_page( $slug ) ? ' current-menu-item' : '';
					echo '<li class="menu-item' . esc_attr( $active ) . '"><a href="' . esc_url( get_permalink( $sector_page ) ) . '">' . esc_html( $sector['title'] ) . '</a></li>';
				}
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Is this ID a sector page?
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function ibanint_is_sector_post( $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return false;
	}
	return 'services' === get_post_field( 'post_name', $post->post_parent ) && isset( ibanint_sectors()[ $post->post_name ] );
}

/**
 * Footer legal menu fallback.
 */
function ibanint_footer_fallback() {
	echo '<ul class="menu">';
	$privacy = get_page_by_path( 'privacy-policy' );
	if ( $privacy ) {
		echo '<li><a href="' . esc_url( get_permalink( $privacy ) ) . '">' . esc_html__( 'Privacy Policy', 'ibanint' ) . '</a></li>';
	}
	$terms = get_page_by_path( 'terms-of-use' );
	if ( $terms ) {
		echo '<li><a href="' . esc_url( get_permalink( $terms ) ) . '">' . esc_html__( 'Terms of Use', 'ibanint' ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Full-bleed banner part markup (kept here for reuse).
 * Prefer template-parts/page-banner.php; this is the data helper.
 *
 * @param string $title    Banner title.
 * @param string $image    Image file in assets/images (optional).
 * @param string $sub      Small line under the title (optional).
 * @return void
 */
function ibanint_page_banner( $title, $image = '', $sub = '' ) {
	set_query_var( 'ibanint_banner_title', $title );
	set_query_var( 'ibanint_banner_image', $image );
	set_query_var( 'ibanint_banner_sub', $sub );
	get_template_part( 'template-parts/page-banner' );
}

/**
 * Seed on theme activation.
 */
function ibanint_seed_on_activate() {
	ibanint_seed_site();
}
add_action( 'after_switch_theme', 'ibanint_seed_on_activate' );

/**
 * Replace only the WordPress tutorial and the theme's old terms stub.
 * Existing custom legal text remains editable and is left alone.
 */
function ibanint_sync_legal_pages() {
	if ( '2' === get_option( 'ibanint_legal_content_version' ) ) {
		return;
	}

	$pages = array(
		'privacy-policy' => array( 'Privacy Policy', 'privacy-policy.html', 'privacy-policy-tutorial' ),
		'terms-of-use'  => array( 'Terms of Use', 'terms-of-use.html', 'This page will carry our terms of use' ),
	);

	foreach ( $pages as $slug => $data ) {
		$file = get_template_directory() . '/content/' . $data[1];
		if ( ! is_readable( $file ) ) {
			return;
		}
		$content = file_get_contents( $file );
		if ( false === $content ) {
			return;
		}

		$page = get_page_by_path( $slug );
		if ( $page ) {
			$is_starter = false !== strpos( $page->post_content, $data[2] ) || ( 'privacy-policy' === $slug && false !== strpos( $page->post_content, 'The current website does not use advertising or analytics cookies.' ) );
			if ( $is_starter ) {
				wp_update_post( array( 'ID' => $page->ID, 'post_content' => $content, 'post_status' => 'publish' ) );
			} elseif ( false !== strpos( $page->post_content, 'ibanint.test' ) ) {
				wp_update_post( array( 'ID' => $page->ID, 'post_content' => str_replace( 'ibanint.test', 'ibanint.com', $page->post_content ) ) );
			}
		} else {
			$id = wp_insert_post( array( 'post_title' => $data[0], 'post_name' => $slug, 'post_status' => 'publish', 'post_type' => 'page', 'post_content' => $content ) );
			if ( is_wp_error( $id ) || ! $id ) {
				return;
			}
			$page = get_post( $id );
		}

		if ( 'privacy-policy' === $slug && $page && ! get_option( 'wp_page_for_privacy_policy' ) ) {
			update_option( 'wp_page_for_privacy_policy', (int) $page->ID );
		}
	}

	update_option( 'ibanint_legal_content_version', '2', false );
}
add_action( 'init', 'ibanint_sync_legal_pages', 20 );

/**
 * One-click setup notice for FTP-deployed installs.
 */
function ibanint_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$missing = array();
	foreach ( array( 'home', 'about', 'services', 'contact', 'news' ) as $slug ) {
		if ( ! get_page_by_path( $slug ) ) {
			$missing[] = $slug;
		}
	}

	if ( empty( $missing ) ) {
		return;
	}

	printf(
		'<div class="notice notice-warning"><p><strong>IBAN International setup:</strong> missing pages: %s</p><p><a class="button button-primary" href="%s">Create pages now</a></p></div>',
		esc_html( implode( ', ', $missing ) ),
		esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=ibanint_seed' ), 'ibanint_seed' ) )
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
	ibanint_seed_site();

	wp_safe_redirect( admin_url( 'edit.php?post_type=page&ibanint_seeded=1' ) );
	exit;
}
add_action( 'admin_post_ibanint_seed', 'ibanint_handle_seed' );
