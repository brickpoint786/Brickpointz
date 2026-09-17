<?php
/**
 * BrickPoint helper functions — centralized company data, WhatsApp links, icons.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default company / contact data (mirrors the original website).
 *
 * @return array
 */
function brickpoint_defaults() {
	return array(
		'phone'            => '03152850818',
		'whatsapp'         => '923152850818',
		'email'            => 'info@brickpoint.pk',
		'ceo'              => 'Syed Iftikhar Haider',
		'sales_manager'    => 'Qasim Iqbal',
		'company_1'        => 'Masha Allah Bricks Company',
		'company_2'        => 'Fine Bricks Company',
		'address'          => 'Ram Thaman & Raja Jang, Lahore, Pakistan',
		'hours'            => 'Mon–Sat: 8:00 AM – 7:00 PM',
		'facebook'         => 'https://www.facebook.com/brickpoint.pk/',
		'instagram'        => 'https://www.instagram.com/brickpoint.pk/',
		'twitter'          => 'https://x.com/BrickPointPK',
		'tiktok'           => 'https://www.tiktok.com/@brickpoint.pk',
		'whatsapp_channel' => 'https://whatsapp.com/channel/0029VbDHPm45a23w88ADzK32',
		'video_url'        => '',
		'video_poster'     => '',
	);
}

/**
 * Get a centralized BrickPoint setting (Customizer > BrickPoint Settings).
 *
 * @param string $key Setting key.
 * @return string
 */
function brickpoint_get( $key ) {
	$defaults = brickpoint_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'brickpoint_' . $key, $default );
}

/**
 * Build a WhatsApp chat/order link.
 *
 * @param string $message Optional pre-filled message (plain text).
 * @return string
 */
function brickpoint_whatsapp_link( $message = '' ) {
	$number = preg_replace( '/[^0-9]/', '', brickpoint_get( 'whatsapp' ) );
	$url    = 'https://wa.me/' . $number;
	if ( '' !== $message ) {
		$url .= '?text=' . rawurlencode( $message );
	}
	return esc_url( $url );
}

/**
 * Build the standard product inquiry message (same wording as original site).
 *
 * @param string $product  Product name.
 * @param string $category Category name.
 * @param string $price    Price display string.
 * @return string
 */
function brickpoint_product_message( $product, $category, $price ) {
	$price_text = ( 'Price on Request' === $price || '' === $price )
		? 'Please share the latest price and availability.'
		: "Price: {$price}";
	/* translators: 1: product, 2: category, 3: price text */
	return sprintf(
		"Assalam-o-Alaikum BrickPoint,\nI am interested in the following product:\n\nProduct: %1\$s\nCategory: %2\$s\n%3\$s\n\nPlease share availability, delivery details, and final quotation.\n\nThank you.",
		$product,
		$category,
		$price_text
	);
}

/**
 * Breadcrumb trail (Home / ... / Current).
 *
 * @param array $trail Array of [label, url|null].
 */
function brickpoint_breadcrumb( $trail ) {
	echo '<nav class="bp-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'brickpoint' ) . '">';
	$last = count( $trail ) - 1;
	foreach ( $trail as $i => $crumb ) {
		list( $label, $url ) = $crumb;
		if ( $i > 0 ) {
			echo '<span class="bp-breadcrumb-sep">/</span>';
		}
		if ( $url && $i !== $last ) {
			echo '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
		} else {
			echo '<span class="bp-breadcrumb-current">' . esc_html( $label ) . '</span>';
		}
	}
	echo '</nav>';
}

/**
 * Inline SVG icons used across the theme (same artwork as original site).
 *
 * @param string $name Icon name.
 * @param int    $size Pixel size.
 * @return string
 */
function brickpoint_icon( $name, $size = 18 ) {
	$size = absint( $size );
	$paths = array(
		'whatsapp'  => 'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z',
		'facebook'  => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
		'instagram' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z',
		'tiktok'    => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z',
		'x'         => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.742l7.73-8.835L1.254 2.25H8.08l4.213 5.567z',
		'phone'     => 'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z',
		'mail'      => 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zm8 7L4 6v12h16V6l-8 5z',
		'map-pin'   => 'M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0zm-8 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6z',
		'check'     => 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3',
		'arrow'     => 'M5 12h14M12 5l7 7-7 7',
		'star'      => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z',
		'menu'      => 'M3 6h18M3 12h18M3 18h18',
		'close'     => 'M18 6L6 18M6 6l12 12',
		'chevron'   => 'M6 9l6 6 6-6',
		'shield'    => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
		'truck'     => 'M1 3h15v13H1zM16 8h4l3 3v5h-7V8zM5.5 21a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm13 0a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z',
		'package'   => 'M21 8l-9-5-9 5v8l9 5 9-5V8zM3.3 8.5L12 13l8.7-4.5M12 22V13',
		'building'  => 'M4 2v20l6-2V4l-6-2zm16 0h-8v20l8 2V2zM10 7H8v3h2V7zm0 5H8v3h2v-3zm8-5h-2v3h2V7zm0 5h-2v3h2v-3z',
		'users'     => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm14 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75',
		'target'    => 'M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20zm0-6a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-6a2 2 0 1 0 0-4 2 2 0 0 0 0 4z',
		'help'      => 'M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3m.08 4h.01M22 12a10 10 0 1 1-20 0 10 10 0 0 1 20 0z',
		'clock'     => 'M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20zm0-14v6l4 2',
		'user'      => 'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z',
		'calendar'  => 'M19 4H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM16 2v4M8 2v4M3 10h18',
		'navigation'=> 'M3 11l19-9-9 19-2-8-8-2z',
		'external'  => 'M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3',
		'tag'       => 'M20.59 13.41L11 3H4v7l9.59 9.59a2 2 0 0 0 2.82 0l4.18-4.18a2 2 0 0 0 0-2.82zM7 7h.01',
		'send'      => 'M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z',
		'info'      => 'M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20zM12 8h.01M12 12v4',
		'search'    => 'M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm10 2l-4.35-4.35',
	);
	$fill_icons = array( 'whatsapp', 'facebook', 'instagram', 'tiktok', 'x', 'star' );
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	if ( in_array( $name, $fill_icons, true ) ) {
		return sprintf(
			'<svg viewBox="0 0 24 24" fill="currentColor" width="%1$d" height="%1$d" aria-hidden="true"><path d="%2$s"/></svg>',
			$size,
			$paths[ $name ]
		);
	}
	return sprintf(
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="%1$d" height="%1$d" aria-hidden="true"><path d="%2$s"/></svg>',
		$size,
		$paths[ $name ]
	);
}

/**
 * BrickPoint logo SVG (header variant: navy tile, red bricks).
 *
 * @param string $variant 'header' or 'footer'.
 * @return string
 */
function brickpoint_logo_svg( $variant = 'header' ) {
	if ( 'footer' === $variant ) {
		return '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><rect width="40" height="40" rx="6" fill="#c0392b"/><rect x="4" y="10" width="15" height="9" rx="1" fill="white"/><rect x="21" y="10" width="15" height="9" rx="1" fill="white"/><rect x="4" y="21" width="15" height="9" rx="1" fill="white" opacity="0.7"/><rect x="21" y="21" width="15" height="9" rx="1" fill="white" opacity="0.7"/></svg>';
	}
	return '<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><rect width="40" height="40" rx="6" fill="#0f1f3d"/><rect x="4" y="10" width="15" height="9" rx="1" fill="#c0392b"/><rect x="21" y="10" width="15" height="9" rx="1" fill="#c0392b"/><rect x="4" y="21" width="15" height="9" rx="1" fill="#c0392b" opacity="0.7"/><rect x="21" y="21" width="15" height="9" rx="1" fill="#c0392b" opacity="0.7"/></svg>';
}

/**
 * Theme asset image URL.
 *
 * @param string $file Filename under assets/images/.
 * @return string
 */
function brickpoint_img( $file ) {
	return esc_url( BRICKPOINT_URI . '/assets/images/' . ltrim( $file, '/' ) );
}

/**
 * Product category meta (mirrors original PRODUCT_CATEGORIES incl. emoji icons).
 *
 * @return array
 */
function brickpoint_category_meta() {
	return array(
		array( 'name' => 'Bricks', 'slug' => 'bricks', 'icon' => '🧱', 'badge' => 'SS7 Brand', 'image' => 'bricks-stacked.jpg', 'desc' => 'Premium quality bricks including SS7 branded bricks for all construction needs.' ),
		array( 'name' => 'Cement', 'slug' => 'cement', 'icon' => '🏗️', 'badge' => '', 'image' => 'cement-bags.jpg', 'desc' => 'High-quality cement from leading brands for residential and commercial projects.' ),
		array( 'name' => 'Crush / Bajri', 'slug' => 'crush', 'icon' => '⛏️', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Construction grade crush and bajri for foundations and concrete mixing.' ),
		array( 'name' => 'Sand / Rait', 'slug' => 'sand', 'icon' => '🪨', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Fine and coarse sand for plastering, concrete, and construction use.' ),
		array( 'name' => 'Steel', 'slug' => 'steel', 'icon' => '🔩', 'badge' => '', 'image' => 'steel-rods.jpg', 'desc' => 'Structural steel, rebar, and reinforcement materials for construction.' ),
		array( 'name' => 'Electric Pipes', 'slug' => 'electric-pipes', 'icon' => '⚡', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Conduit and electrical pipes for safe electrical installations.' ),
		array( 'name' => 'Plumbing Pipes & Fittings', 'slug' => 'plumbing-pipes', 'icon' => '🔧', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Complete plumbing solutions including pipes, fittings, and accessories.' ),
		array( 'name' => 'Construction Chemicals', 'slug' => 'construction-chemicals', 'icon' => '🧪', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Admixtures, waterproofing chemicals, and construction additives.' ),
		array( 'name' => 'Insulation & Membrane', 'slug' => 'insulation-membrane', 'icon' => '🛡️', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Thermal insulation, waterproofing membranes, and protective coatings.' ),
		array( 'name' => 'Cables & Wires', 'slug' => 'cables-wires', 'icon' => '🔌', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Electrical cables and wiring solutions for residential and commercial use.' ),
		array( 'name' => 'Paints', 'slug' => 'paints', 'icon' => '🎨', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Interior and exterior paints, primers, and finishing solutions.' ),
		array( 'name' => 'Lights', 'slug' => 'lights', 'icon' => '💡', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'LED lights, fixtures, and lighting solutions for all spaces.' ),
		array( 'name' => 'Switches & Sockets', 'slug' => 'switches-sockets', 'icon' => '🔲', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Quality switches, sockets, and electrical accessories for modern homes.' ),
		array( 'name' => 'Other Construction Items', 'slug' => 'other-items', 'icon' => '📦', 'badge' => '', 'image' => 'hero-bricks.jpg', 'desc' => 'Additional construction materials and accessories for your project.' ),
	);
}

/**
 * Find category meta by slug.
 *
 * @param string $slug Category slug.
 * @return array|null
 */
function brickpoint_category_by_slug( $slug ) {
	foreach ( brickpoint_category_meta() as $cat ) {
		if ( $cat['slug'] === $slug ) {
			return $cat;
		}
	}
	return null;
}

/**
 * Social links array.
 *
 * @return array
 */
function brickpoint_social_links() {
	return array(
		'facebook'  => brickpoint_get( 'facebook' ),
		'instagram' => brickpoint_get( 'instagram' ),
		'twitter'   => brickpoint_get( 'twitter' ),
		'tiktok'    => brickpoint_get( 'tiktok' ),
		'whatsapp'  => brickpoint_whatsapp_link(),
	);
}

/**
 * Resolve a product category URL (WooCommerce-aware, falls back to /products/).
 *
 * @param string $slug Category slug.
 * @return string
 */
function brickpoint_cat_url( $slug ) {
	if ( class_exists( 'WooCommerce' ) ) {
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$link = get_term_link( $term );
			if ( ! is_wp_error( $link ) ) {
				return $link;
			}
		}
	}
	return home_url( '/products/' . $slug . '/' );
}

/**
 * Estimate reading time for a post.
 *
 * @param int $post_id Post ID.
 * @return int Minutes.
 */
function brickpoint_reading_time( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) round( $words / 200 ) );
}
