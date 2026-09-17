<?php
/**
 * BrickPoint Elementor demo designs.
 *
 * Builds the full page designs (Home, About, Products, SS7 Bricks, Projects,
 * Locations, Contact) as NATIVE Elementor data (_elementor_data), so every
 * section, heading, text, image and button is visible and editable inside
 * Elementor — nothing is locked in PHP templates.
 *
 * Uses core Elementor widgets (heading, text, image, button, gallery,
 * accordion, shortcode...) plus the theme's own BrickPoint widgets.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ---------------------------------------------------------------------------
 * Element builders
 * ------------------------------------------------------------------------- */

/**
 * Unique 8-char Elementor element id.
 *
 * @return string
 */
function bp_el_id() {
	static $n = 0;
	$n++;
	return substr( md5( uniqid( 'bp' . $n . wp_rand(), true ) ), 0, 8 );
}

/**
 * Section element.
 *
 * @param array $columns  Column elements.
 * @param array $settings Section settings.
 * @return array
 */
function bp_el_section( $columns, $settings = array() ) {
	return array(
		'id'       => bp_el_id(),
		'elType'   => 'section',
		'settings' => $settings,
		'elements' => $columns,
		'isInner'  => false,
	);
}

/**
 * Column element.
 *
 * @param int   $size    Column width %.
 * @param array $widgets Widget elements.
 * @param array $settings Column settings.
 * @return array
 */
function bp_el_col( $size, $widgets, $settings = array() ) {
	// Translate generic style keys to Elementor column keys (_background_*, _border_*, _padding).
	$map = array(
		'background_background' => '_background_background',
		'background_color'      => '_background_color',
		'border_border'         => '_border_border',
		'border_width'          => '_border_width',
		'border_color'          => '_border_color',
		'border_radius'         => '_border_radius',
		'padding'               => '_padding',
	);
	$translated = array();
	foreach ( $settings as $k => $v ) {
		$translated[ isset( $map[ $k ] ) ? $map[ $k ] : $k ] = $v;
	}
	$settings = array_merge(
		array(
			'_column_size' => $size,
			'_inline_size' => null,
		),
		$translated
	);
	return array(
		'id'       => bp_el_id(),
		'elType'   => 'column',
		'settings' => $settings,
		'elements' => $widgets,
		'isInner'  => false,
	);
}

/**
 * Widget element.
 *
 * @param string $type     Widget type.
 * @param array  $settings Widget settings.
 * @return array
 */
function bp_el_widget( $type, $settings = array() ) {
	return array(
		'id'         => bp_el_id(),
		'elType'     => 'widget',
		'settings'   => $settings,
		'elements'   => array(),
		'widgetType' => $type,
	);
}

/* ---------------------------------------------------------------------------
 * Widget shortcuts
 * ------------------------------------------------------------------------- */

/**
 * Heading widget.
 */
function bp_w_heading( $title, $tag = 'h2', $color = '#0F1F3D', $size = 36, $align = 'center' ) {
	return bp_el_widget(
		'heading',
		array(
			'title'                    => $title,
			'header_size'              => $tag,
			'align'                    => $align,
			'title_color'              => $color,
			'typography_typography'    => 'custom',
			'typography_font_family'   => 'Inter',
			'typography_font_size'     => array( 'unit' => 'px', 'size' => $size ),
			'typography_font_weight'   => '800',
			'typography_line_height'   => array( 'unit' => 'em', 'size' => 1.2 ),
		)
	);
}

/**
 * Eyebrow label (small red uppercase).
 */
function bp_w_eyebrow( $text, $align = 'center' ) {
	return bp_el_widget(
		'text-editor',
		array( 'editor' => '<p style="text-align:' . esc_attr( $align ) . ';color:#C0392B;font-size:14px;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;margin:0 0 12px;">' . esc_html( $text ) . '</p>' )
	);
}

/**
 * Paragraph / rich text widget.
 */
function bp_w_text( $html, $color = '#4B5563', $size = 16, $align = 'center', $maxw = 640 ) {
	$style = 'text-align:' . esc_attr( $align ) . ';color:' . esc_attr( $color ) . ';font-size:' . absint( $size ) . 'px;line-height:1.7;margin:0 auto;';
	if ( 'center' === $align ) {
		$style .= 'max-width:' . absint( $maxw ) . 'px;';
	}
	return bp_el_widget( 'text-editor', array( 'editor' => '<div style="' . $style . '">' . $html . '</div>' ) );
}

/**
 * Image widget.
 */
function bp_w_image( $file, $radius = 16 ) {
	$att = brickpoint_import_image( $file );
	$url = $att ? wp_get_attachment_url( $att ) : BRICKPOINT_URI . '/assets/images/' . $file;
	return bp_el_widget(
		'image',
		array(
			'image'         => array( 'url' => $url, 'id' => $att ? $att : '' ),
			'align'         => 'center',
			'border_radius' => array( 'unit' => 'px', 'top' => $radius, 'right' => $radius, 'bottom' => $radius, 'left' => $radius, 'isLinked' => true ),
		)
	);
}

/**
 * Button widget.
 */
function bp_w_button( $label, $url, $bg = '#C0392B', $color = '#FFFFFF', $external = false, $align = 'left', $outline = false ) {
	$settings = array(
		'text'                   => $label,
		'link'                   => array( 'url' => $url, 'is_external' => $external ? 'on' : '', 'nofollow' => '' ),
		'align'                  => $align,
		'size'                   => 'md',
		'button_text_color'      => $color,
		'background_background'  => 'classic',
		'background_color'       => $outline ? 'rgba(0,0,0,0)' : $bg,
		'border_border'          => $outline ? 'solid' : 'none',
		'border_width'           => array( 'unit' => 'px', 'top' => 2, 'right' => 2, 'bottom' => 2, 'left' => 2, 'isLinked' => true ),
		'border_color'           => $bg,
		'border_radius'          => array( 'unit' => 'px', 'top' => 8, 'right' => 8, 'bottom' => 8, 'left' => 8, 'isLinked' => true ),
		'typography_typography'  => 'custom',
		'typography_font_family' => 'Inter',
		'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
		'typography_font_weight' => '600',
		'button_padding'         => array( 'unit' => 'px', 'top' => 14, 'right' => 28, 'bottom' => 14, 'left' => 28, 'isLinked' => false ),
	);
	return bp_el_widget( 'button', $settings );
}

/**
 * Spacer.
 */
function bp_w_spacer( $px = 24 ) {
	return bp_el_widget( 'spacer', array( 'space' => array( 'unit' => 'px', 'size' => $px ) ) );
}

/**
 * Navy / themed section wrapper settings.
 */
function bp_sec_bg( $color, $pad_top = 80, $pad_bottom = 80 ) {
	return array(
		'background_background' => 'classic',
		'background_color'      => $color,
		'padding'               => array( 'unit' => 'px', 'top' => $pad_top, 'right' => 0, 'bottom' => $pad_bottom, 'left' => 0, 'isLinked' => false ),
	);
}

/**
 * BrickPoint custom widget shortcut.
 */
function bp_w_bp( $type, $settings = array() ) {
	return bp_el_widget( $type, $settings );
}

/* ---------------------------------------------------------------------------
 * Shared fragments
 * ------------------------------------------------------------------------- */

/**
 * Inner page hero (navy, breadcrumb, title, subtitle).
 */
function bp_frag_page_hero( $crumb, $title, $sub, $bg_file = 'hero-bricks.jpg' ) {
	$att = brickpoint_import_image( $bg_file );
	$url = $att ? wp_get_attachment_url( $att ) : BRICKPOINT_URI . '/assets/images/' . $bg_file;
	$crumb_html = '<p style="color:#9CA3AF;font-size:14px;margin:0 0 24px;"><a style="color:#9CA3AF;" href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'brickpoint' ) . '</a> &nbsp;/&nbsp; <span style="color:#FFFFFF;">' . esc_html( $crumb ) . '</span></p>';
	return bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_el_widget( 'text-editor', array( 'editor' => $crumb_html ) ),
					bp_w_heading( $title, 'h1', '#FFFFFF', 48, 'left' ),
					bp_w_text( esc_html( $sub ), '#D1D5DB', 18, 'left' ),
				)
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#0F1F3D',
			'background_image'      => array( 'url' => $url, 'id' => $att ? $att : '' ),
			'background_overlay_background' => 'classic',
			'background_overlay_color'      => 'rgba(15,31,61,0.85)',
			'padding'               => array( 'unit' => 'px', 'top' => 64, 'right' => 0, 'bottom' => 64, 'left' => 0, 'isLinked' => false ),
		)
	);
}

/**
 * Feature bullets HTML list.
 */
function bp_bullets( $items, $color = '#D1D5DB' ) {
	$html = '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
	foreach ( $items as $item ) {
		$html .= '<div style="display:flex;align-items:center;gap:8px;color:' . esc_attr( $color ) . ';font-size:14px;"><span style="color:#C0392B;font-weight:800;">✓</span>' . esc_html( $item ) . '</div>';
	}
	return $html . '</div>';
}

/* ---------------------------------------------------------------------------
 * HOME page design
 * ------------------------------------------------------------------------- */

/**
 * Home page Elementor data.
 *
 * @return array
 */
function bp_design_home() {
	$wa    = brickpoint_whatsapp_link();
	$phone = brickpoint_get( 'phone' );
	$shop  = class_exists( 'WooCommerce' ) && wc_get_page_permalink( 'shop' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/products/' );
	$hero_att = brickpoint_import_image( 'hero-bricks.jpg' );
	$hero_url = $hero_att ? wp_get_attachment_url( $hero_att ) : BRICKPOINT_URI . '/assets/images/hero-bricks.jpg';

	$data = array();

	// 1. HERO.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				50,
				array(
					bp_el_widget( 'text-editor', array( 'editor' => '<p style="display:inline-block;background:rgba(192,57,43,0.2);border:1px solid rgba(192,57,43,0.4);color:#F5A8A0;border-radius:999px;padding:6px 16px;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;">● ' . esc_html__( 'SS7 Bricks Now Available', 'brickpoint' ) . '</p>' ) ),
					bp_w_heading( __( 'Building Strong Foundations with Quality Materials', 'brickpoint' ), 'h1', '#FFFFFF', 54, 'left' ),
					bp_w_text( esc_html__( 'From SS7 bricks to essential construction materials, BrickPoint helps builders, contractors, and homeowners build with confidence.', 'brickpoint' ), '#D1D5DB', 18, 'left' ),
					bp_w_button( __( 'Explore Products', 'brickpoint' ), $shop, '#C0392B' ),
					bp_w_button( __( 'Order on WhatsApp', 'brickpoint' ), $wa, '#25D366', '#FFFFFF', true ),
					bp_w_text( '<span style="color:#C0392B;">✓</span> ' . esc_html__( 'Quality Bricks', 'brickpoint' ) . ' &nbsp;•&nbsp; <span style="color:#C0392B;">✓</span> ' . esc_html__( 'Reliable Supply', 'brickpoint' ) . ' &nbsp;•&nbsp; <span style="color:#C0392B;">✓</span> ' . esc_html__( 'Construction Materials', 'brickpoint' ), '#9CA3AF', 14, 'left' ),
				)
			),
			bp_el_col(
				50,
				array(
					bp_w_image( 'ss7-brick.jpg' ),
					bp_w_text( '<strong style="color:#FFFFFF;font-size:20px;">' . esc_html__( 'SS7 Bricks', 'brickpoint' ) . '</strong><br><span style="color:#D1D5DB;font-size:14px;">' . esc_html__( 'Premium quality for strong construction', 'brickpoint' ) . '</span>', '#D1D5DB', 14, 'left' ),
					bp_w_image( 'brick-factory.jpg' ),
					bp_w_text(
						'<strong style="color:#FFFFFF;font-size:18px;">' . esc_html( $phone ) . '</strong><br><span style="color:#9CA3AF;font-size:12px;">' . esc_html__( 'Speak to Sales', 'brickpoint' ) . ' — ' . esc_html( brickpoint_get( 'sales_manager' ) ) . '</span>',
						'#9CA3AF',
						14,
						'left'
					),
					bp_w_button( __( 'Call Sales', 'brickpoint' ), 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ), '#1A3260' ),
				)
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#0F1F3D',
			'background_image'      => array( 'url' => $hero_url, 'id' => $hero_att ? $hero_att : '' ),
			'background_overlay_background' => 'classic',
			'background_overlay_color'      => 'rgba(15,31,61,0.82)',
			'padding'               => array( 'unit' => 'px', 'top' => 72, 'right' => 0, 'bottom' => 88, 'left' => 0, 'isLinked' => false ),
		)
	);

	// 2. TRUST / WHO WE ARE.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-section-heading',
						array(
							'eyebrow' => __( 'Who We Are', 'brickpoint' ),
							'title'   => __( 'Quality Materials. Stronger Foundations.', 'brickpoint' ),
							'lead'    => sprintf(
								/* translators: 1: company, 2: company */
								__( 'BrickPoint represents %1$s and %2$s — supplying SS7 branded bricks and construction materials to builders, contractors, developers, and homeowners.', 'brickpoint' ),
								brickpoint_get( 'company_1' ),
								brickpoint_get( 'company_2' )
							),
							'align'   => 'center',
						)
					),
					bp_w_spacer( 32 ),
					bp_w_bp( 'brickpoint-feature-cards', array( 'columns' => '4' ) ),
					bp_w_spacer( 32 ),
					bp_w_text(
						'<span style="display:inline-block;background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:12px 24px;margin:6px;color:#0F1F3D;font-weight:600;">🔴 ' . esc_html( brickpoint_get( 'company_1' ) ) . '</span> <span style="display:inline-block;background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:12px 24px;margin:6px;color:#0F1F3D;font-weight:600;">🔵 ' . esc_html( brickpoint_get( 'company_2' ) ) . '</span>',
						'#0F1F3D',
						16,
						'center'
					),
				)
			),
		),
		bp_sec_bg( '#FAF8F5' )
	);

	// 3. SS7 FEATURE.
	$data[] = bp_el_section(
		array(
			bp_el_col( 50, array( bp_w_image( 'ss7-brick.jpg' ) ) ),
			bp_el_col(
				50,
				array(
					bp_el_widget( 'text-editor', array( 'editor' => '<p style="display:inline-block;background:#C0392B;color:#fff;border-radius:6px;padding:6px 12px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;">★ ' . esc_html__( 'Featured Brick Brand', 'brickpoint' ) . '</p>' ) ),
					bp_w_heading( __( 'SS7 Bricks — Built for Stronger Foundations', 'brickpoint' ), 'h2', '#FFFFFF', 36, 'left' ),
					bp_w_text( esc_html__( 'Discover SS7 bricks from BrickPoint — a trusted choice for construction projects where quality, consistency, and dependable supply matter.', 'brickpoint' ), '#D1D5DB', 18, 'left' ),
					bp_w_text(
						bp_bullets(
							array(
								__( 'SS7 Branded Quality', 'brickpoint' ),
								__( 'Consistent Dimensions', 'brickpoint' ),
								__( 'Reliable Bulk Supply', 'brickpoint' ),
								__( 'Suitable for All Construction', 'brickpoint' ),
							)
						),
						'#D1D5DB',
						14,
						'left'
					),
					bp_w_button( __( 'View SS7 Bricks', 'brickpoint' ), home_url( '/ss7-bricks/' ), '#C0392B' ),
					bp_w_bp(
						'brickpoint-whatsapp-button',
						array(
							'label'    => __( 'Order on WhatsApp', 'brickpoint' ),
							'mode'     => 'modal',
							'product'  => 'SS7 Bricks',
							'category' => __( 'Bricks', 'brickpoint' ),
							'price'    => __( 'Price on Request', 'brickpoint' ),
							'variant'  => 'primary',
							'align'    => 'left',
						)
					),
				)
			),
		),
		bp_sec_bg( '#0F1F3D', 96, 96 )
	);

	// 4. PRODUCTS.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-section-heading',
						array(
							'eyebrow' => __( 'Our Product Range', 'brickpoint' ),
							'title'   => __( 'Explore Our Construction Materials', 'brickpoint' ),
							'lead'    => __( 'From SS7 bricks to complete construction solutions — everything your project needs, in one place.', 'brickpoint' ),
							'align'   => 'center',
						)
					),
					bp_w_spacer( 32 ),
					bp_w_bp( 'brickpoint-category-grid', array( 'show_desc' => 'yes', 'source' => 'theme' ) ),
					bp_w_spacer( 32 ),
					bp_w_button( __( 'View All Products', 'brickpoint' ), $shop, '#0F1F3D', '#FFFFFF', false, 'center' ),
				)
			),
		),
		bp_sec_bg( '#F0EBE3' )
	);

	// 5. PROJECTS PREVIEW (editable cards).
	$proj_cards = array();
	foreach ( brickpoint_get_projects() as $p ) {
		$img = get_the_post_thumbnail_url( $p->ID, 'brickpoint-card' );
		if ( ! $img ) {
			$img = BRICKPOINT_URI . '/assets/images/construction-project.jpg';
		}
		$loc = get_post_meta( $p->ID, '_bp_location', true );
		$proj_cards[] = array( $p->post_title, $loc, $img );
		if ( count( $proj_cards ) >= 3 ) {
			break;
		}
	}
	if ( ! $proj_cards ) {
		$proj_cards = array(
			array( __( 'Modern Residential Villa — DHA Lahore', 'brickpoint' ), __( 'DHA Lahore', 'brickpoint' ), BRICKPOINT_URI . '/assets/images/construction-project.jpg' ),
			array( __( 'Commercial Development — Bahria Town', 'brickpoint' ), __( 'Bahria Town Lahore', 'brickpoint' ), BRICKPOINT_URI . '/assets/images/hero-bricks.jpg' ),
			array( __( 'Premium Brickwork — Lake City', 'brickpoint' ), __( 'Lake City Lahore', 'brickpoint' ), BRICKPOINT_URI . '/assets/images/bricks-stacked.jpg' ),
		);
	}
	$proj_cols = array();
	foreach ( $proj_cards as $card ) {
		list( $t, $l, $img ) = $card;
		$proj_cols[] = bp_el_col(
			33,
			array(
				bp_el_widget( 'image', array( 'image' => array( 'url' => $img, 'id' => '' ), 'align' => 'center' ) ),
				bp_w_heading( $t, 'h3', '#0F1F3D', 17, 'left' ),
				bp_w_text( '📍 ' . esc_html( $l ), '#6B7280', 13, 'left' ),
			)
		);
	}
	$data[] = bp_el_section(
		array( bp_el_col( 100, array(
			bp_w_eyebrow( __( 'Our Work', 'brickpoint' ), 'left' ),
			bp_w_heading( __( 'Featured Projects', 'brickpoint' ), 'h2', '#0F1F3D', 36, 'left' ),
			bp_w_spacer( 8 ),
		) ) ),
		array( 'padding' => array( 'unit' => 'px', 'top' => 80, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#FAF8F5' )
	);
	$data[] = bp_el_section( $proj_cols, bp_sec_bg( '#FAF8F5', 24, 24 ) );
	$data[] = bp_el_section(
		array( bp_el_col( 100, array( bp_w_button( __( 'View All Projects', 'brickpoint' ), home_url( '/projects/' ), '#C0392B', '#FFFFFF', false, 'center' ) ) ) ),
		array( 'padding' => array( 'unit' => 'px', 'top' => 8, 'right' => 0, 'bottom' => 80, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#FAF8F5' )
	);

	// 6. LOCATIONS STRIP.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				50,
				array(
					bp_w_heading( __( 'Find Our Locations', 'brickpoint' ), 'h3', '#FFFFFF', 22, 'left' ),
					bp_w_text( esc_html__( 'Visit our brick factories or contact us for delivery to your site.', 'brickpoint' ), '#9CA3AF', 14, 'left' ),
				)
			),
			bp_el_col(
				50,
				array(
					bp_w_button( __( 'View All Locations', 'brickpoint' ), home_url( '/locations/' ), '#FFFFFF', '#0F1F3D' ),
					bp_w_button( __( 'Contact on WhatsApp', 'brickpoint' ), $wa, '#25D366', '#FFFFFF', true ),
				)
			),
		),
		bp_sec_bg( '#0F1F3D', 48, 48 )
	);

	// 7. BLOG PREVIEW.
	$posts = get_posts( array( 'numberposts' => 3, 'post_status' => 'publish' ) );
	if ( $posts ) {
		$blog_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
		$blog_cols = array();
		foreach ( $posts as $post ) {
			$img = get_the_post_thumbnail_url( $post->ID, 'brickpoint-card' );
			if ( ! $img ) {
				$img = BRICKPOINT_URI . '/assets/images/bricks-stacked.jpg';
			}
			$blog_cols[] = bp_el_col(
				33,
				array(
					bp_el_widget( 'image', array( 'image' => array( 'url' => $img, 'id' => '' ), 'align' => 'center', 'link' => array( 'url' => get_permalink( $post->ID ) ) ) ),
					bp_w_heading( '<a style="color:#0F1F3D;" href="' . esc_url( get_permalink( $post->ID ) ) . '">' . esc_html( $post->post_title ) . '</a>', 'h3', '#0F1F3D', 17, 'left' ),
					bp_w_text( esc_html( get_the_author_meta( 'display_name', $post->post_author ) ) . ' • ' . esc_html( sprintf( __( '%d min read', 'brickpoint' ), brickpoint_reading_time( $post->ID ) ) ), '#6B7280', 12, 'left' ),
				)
			);
		}
		$data[] = bp_el_section(
			array( bp_el_col( 100, array(
				bp_w_eyebrow( __( 'Knowledge Base', 'brickpoint' ), 'left' ),
				bp_w_heading( __( 'Construction Insights', 'brickpoint' ), 'h2', '#0F1F3D', 36, 'left' ),
				bp_w_spacer( 8 ),
			) ) ),
			array( 'padding' => array( 'unit' => 'px', 'top' => 80, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#FAF8F5' )
		);
		$data[] = bp_el_section( $blog_cols, bp_sec_bg( '#FAF8F5', 24, 24 ) );
		$data[] = bp_el_section(
			array( bp_el_col( 100, array( bp_w_button( __( 'View All Posts', 'brickpoint' ), $blog_url, '#C0392B', '#FFFFFF', false, 'center' ) ) ) ),
			array( 'padding' => array( 'unit' => 'px', 'top' => 8, 'right' => 0, 'bottom' => 80, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#FAF8F5' )
		);
	}

	// 8. CTA.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-cta-banner',
						array(
							'title'         => __( 'Ready to Start Your Project?', 'brickpoint' ),
							'sub'           => __( 'Contact BrickPoint today for SS7 bricks and quality construction materials. Our sales team is ready to help.', 'brickpoint' ),
							'note'          => sprintf( __( 'CEO: %1$s | Sales Manager: %2$s', 'brickpoint' ), brickpoint_get( 'ceo' ), brickpoint_get( 'sales_manager' ) ),
							'primary_label' => __( 'Order on WhatsApp', 'brickpoint' ),
							'show_call'     => 'yes',
						)
					),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ) )
	);

	return $data;
}

/* ---------------------------------------------------------------------------
 * ABOUT page design
 * ------------------------------------------------------------------------- */

/**
 * About page Elementor data.
 *
 * @return array
 */
function bp_design_about() {
	$data = array();
	$data[] = bp_frag_page_hero(
		__( 'About Us', 'brickpoint' ),
		__( 'Your Trusted Partner in Construction Materials', 'brickpoint' ),
		sprintf(
			/* translators: 1: company, 2: company */
			__( 'BrickPoint represents %1$s and %2$s — supplying SS7 bricks and essential construction materials to builders, contractors, and developers.', 'brickpoint' ),
			brickpoint_get( 'company_1' ),
			brickpoint_get( 'company_2' )
		)
	);

	// Story.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				50,
				array(
					bp_w_eyebrow( __( 'Our Story', 'brickpoint' ), 'left' ),
					bp_w_heading( __( 'Building Relationships, One Brick at a Time', 'brickpoint' ), 'h2', '#0F1F3D', 36, 'left' ),
					bp_w_text(
						'<p>' . sprintf(
							/* translators: 1: company, 2: company */
							esc_html__( 'BrickPoint is the digital face of two established brick manufacturing companies in Pakistan — %1$s and %2$s. Together, they operate multiple brick manufacturing facilities (bhattas) producing quality bricks for the construction industry.', 'brickpoint' ),
							'<strong style="color:#0F1F3D;">' . esc_html( brickpoint_get( 'company_1' ) ) . '</strong>',
							'<strong style="color:#0F1F3D;">' . esc_html( brickpoint_get( 'company_2' ) ) . '</strong>'
						) . '</p><p>' . esc_html__( 'Our primary product is the SS7 branded brick — a recognized name among builders, contractors, and construction companies looking for consistent quality and dependable supply.', 'brickpoint' ) . '</p><p>' . esc_html__( 'Through BrickPoint, we bring together our manufacturing expertise and customer service under one brand, making it easier for builders, developers, architects, and homeowners to source quality construction materials efficiently.', 'brickpoint' ) . '</p>',
						'#4B5563',
						16,
						'left'
					),
					bp_w_text(
						bp_bullets(
							array(
								__( 'SS7 Branded Bricks', 'brickpoint' ),
								__( 'Multiple Manufacturing Locations', 'brickpoint' ),
								__( 'Bulk Order Capability', 'brickpoint' ),
								__( 'WhatsApp Ordering', 'brickpoint' ),
								__( 'Direct Manufacturer Access', 'brickpoint' ),
								__( 'Wide Construction Material Range', 'brickpoint' ),
							),
							'#374151'
						),
						'#374151',
						14,
						'left'
					),
				)
			),
			bp_el_col( 50, array( bp_w_image( 'about-team.jpg' ) ) ),
		),
		bp_sec_bg( '#FAF8F5' )
	);

	// Companies.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-section-heading',
						array(
							'eyebrow' => __( 'Our Companies', 'brickpoint' ),
							'title'   => __( 'Under the BrickPoint Brand', 'brickpoint' ),
							'lead'    => __( 'BrickPoint represents two manufacturing companies operating brick production facilities across multiple locations.', 'brickpoint' ),
							'align'   => 'center',
						)
					),
					bp_w_spacer( 24 ),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 80, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#F0EBE3' )
	);
	$data[] = bp_el_section(
		array(
			bp_el_col(
				50,
				array(
					bp_w_heading( brickpoint_get( 'company_1' ), 'h3', '#0F1F3D', 24, 'left' ),
					bp_w_text( esc_html__( 'Masha Allah Bricks Company operates two brick manufacturing facilities (bhattas), producing quality SS7 branded bricks and other construction bricks for the local market.', 'brickpoint' ), '#4B5563', 16, 'left' ),
					bp_w_text( '🔴 ' . esc_html__( 'Bhatta 1 — Ram Thaman', 'brickpoint' ) . '<br>🔴 ' . esc_html__( 'Bhatta 3 — Active Location', 'brickpoint' ), '#4B5563', 14, 'left' ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'isLinked' => true ) )
			),
			bp_el_col(
				50,
				array(
					bp_w_heading( brickpoint_get( 'company_2' ), 'h3', '#0F1F3D', 24, 'left' ),
					bp_w_text( esc_html__( 'Fine Bricks Company operates a brick manufacturing facility (Bhatta 2) producing quality bricks under the SS7 brand and serving construction projects across the region.', 'brickpoint' ), '#4B5563', 16, 'left' ),
					bp_w_text( '🔵 ' . esc_html__( 'Bhatta 2 — Raja Jang', 'brickpoint' ), '#4B5563', 14, 'left' ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'isLinked' => true ) )
			),
		),
		bp_sec_bg( '#F0EBE3', 32, 80 )
	);

	// Who we serve.
	$serve = array(
		__( 'Builders & Contractors', 'brickpoint' ),
		__( 'Developers', 'brickpoint' ),
		__( 'Construction Companies', 'brickpoint' ),
		__( 'Homeowners', 'brickpoint' ),
		__( 'Architects', 'brickpoint' ),
		__( 'Project Managers', 'brickpoint' ),
	);
	$serve_html = '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
	foreach ( $serve as $s ) {
		$serve_html .= '<div style="background:#fff;border:1px solid #F3F4F6;border-radius:12px;padding:12px 16px;color:#0F1F3D;font-weight:500;font-size:14px;">✓ ' . esc_html( $s ) . '</div>';
	}
	$serve_html .= '</div>';
	$data[] = bp_el_section(
		array(
			bp_el_col( 50, array( bp_w_image( 'brick-factory.jpg' ) ) ),
			bp_el_col(
				50,
				array(
					bp_w_eyebrow( __( 'Who We Serve', 'brickpoint' ), 'left' ),
					bp_w_heading( __( 'Built for Every Builder', 'brickpoint' ), 'h2', '#0F1F3D', 36, 'left' ),
					bp_w_text( esc_html__( 'BrickPoint serves a wide range of customers from large-scale construction companies to individual homeowners starting their first project.', 'brickpoint' ), '#4B5563', 16, 'left' ),
					bp_w_text( $serve_html, '#0F1F3D', 14, 'left' ),
				)
			),
		),
		bp_sec_bg( '#FAF8F5' )
	);

	// Leadership.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-section-heading',
						array(
							'eyebrow' => __( 'Our Leadership', 'brickpoint' ),
							'title'   => __( 'Meet the Team', 'brickpoint' ),
							'lead'    => '',
							'align'   => 'center',
							'dark'    => 'yes',
						)
					),
					bp_w_spacer( 24 ),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 80, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#0F1F3D' )
	);
	$data[] = bp_el_section(
		array(
			bp_el_col(
				50,
				array(
					bp_w_heading( brickpoint_get( 'ceo' ), 'h3', '#FFFFFF', 20, 'center' ),
					bp_w_text( esc_html__( 'Chief Executive Officer', 'brickpoint' ), '#C0392B', 14, 'center' ),
					bp_w_text( esc_html__( 'Leading BrickPoint with a vision for quality construction materials and exceptional customer service.', 'brickpoint' ), '#9CA3AF', 14, 'center' ),
				),
				array( 'background_background' => 'classic', 'background_color' => 'rgba(255,255,255,0.05)', 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ), 'border_color' => 'rgba(255,255,255,0.1)', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'isLinked' => true ) )
			),
			bp_el_col(
				50,
				array(
					bp_w_heading( brickpoint_get( 'sales_manager' ), 'h3', '#FFFFFF', 20, 'center' ),
					bp_w_text( esc_html__( 'Sales Manager', 'brickpoint' ), '#C0392B', 14, 'center' ),
					bp_w_text( esc_html__( 'Managing customer relationships and ensuring timely fulfillment of orders for all product categories.', 'brickpoint' ), '#9CA3AF', 14, 'center' ),
				),
				array( 'background_background' => 'classic', 'background_color' => 'rgba(255,255,255,0.05)', 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ), 'border_color' => 'rgba(255,255,255,0.1)', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'isLinked' => true ) )
			),
		),
		bp_sec_bg( '#0F1F3D', 24, 80 )
	);

	// CTA.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-cta-banner',
						array(
							'title'         => __( 'Ready to Order Construction Materials?', 'brickpoint' ),
							'sub'           => __( 'Contact our team on WhatsApp for product pricing, availability, and delivery.', 'brickpoint' ),
							'note'          => '',
							'primary_label' => __( 'Order on WhatsApp', 'brickpoint' ),
							'show_call'     => 'yes',
						)
					),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ) )
	);

	return $data;
}

/* ---------------------------------------------------------------------------
 * PRODUCTS page design
 * ------------------------------------------------------------------------- */

/**
 * Products page Elementor data.
 *
 * @return array
 */
function bp_design_products() {
	$data = array();
	$data[] = bp_frag_page_hero(
		__( 'Products', 'brickpoint' ),
		__( 'Our Construction Materials', 'brickpoint' ),
		__( 'From SS7 bricks to complete construction solutions — quality materials for every project stage.', 'brickpoint' ),
		'bricks-stacked.jpg'
	);

	// Featured bricks banner.
	$bricks_att = brickpoint_import_image( 'bricks-stacked.jpg' );
	$bricks_url = $bricks_att ? wp_get_attachment_url( $bricks_att ) : BRICKPOINT_URI . '/assets/images/bricks-stacked.jpg';
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_el_widget( 'text-editor', array( 'editor' => '<p style="display:inline-block;background:#C0392B;color:#fff;border-radius:6px;padding:6px 12px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;">★ ' . esc_html__( 'SS7 Brand', 'brickpoint' ) . '</p>' ) ),
					bp_w_heading( __( 'Bricks', 'brickpoint' ), 'h2', '#FFFFFF', 36, 'left' ),
					bp_w_text( esc_html__( 'Premium quality bricks including SS7 branded bricks for all construction needs.', 'brickpoint' ), '#D1D5DB', 18, 'left' ),
					bp_w_button( __( 'View Bricks', 'brickpoint' ), brickpoint_cat_url( 'bricks' ), '#C0392B' ),
				)
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#0F1F3D',
			'background_image'      => array( 'url' => $bricks_url, 'id' => $bricks_att ? $bricks_att : '' ),
			'background_overlay_background' => 'classic',
			'background_overlay_color'      => 'rgba(15,31,61,0.72)',
			'padding'               => array( 'unit' => 'px', 'top' => 56, 'right' => 0, 'bottom' => 56, 'left' => 0, 'isLinked' => false ),
		)
	);

	// All categories.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_heading( __( 'All Product Categories', 'brickpoint' ), 'h2', '#0F1F3D', 24, 'left' ),
					bp_w_spacer( 16 ),
					bp_w_bp( 'brickpoint-category-grid', array( 'show_desc' => 'yes', 'source' => 'theme' ) ),
				)
			),
		),
		bp_sec_bg( '#F0EBE3', 56, 56 )
	);

	// Inquiry CTA.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_heading( __( "Can't Find What You're Looking For?", 'brickpoint' ), 'h2', '#FFFFFF', 30, 'center' ),
					bp_w_text( esc_html__( 'Contact us on WhatsApp with your specific requirements. We will help you source the right materials.', 'brickpoint' ), '#D1D5DB', 18, 'center' ),
					bp_w_spacer( 8 ),
					bp_w_button( __( 'Inquire on WhatsApp', 'brickpoint' ), brickpoint_whatsapp_link( __( "Assalam-o-Alaikum BrickPoint,\nI need help finding a specific construction material. Please assist.", 'brickpoint' ) ), '#25D366', '#FFFFFF', true, 'center' ),
				)
			),
		),
		bp_sec_bg( '#0F1F3D', 64, 64 )
	);

	return $data;
}

/* ---------------------------------------------------------------------------
 * SS7 BRICKS page design
 * ------------------------------------------------------------------------- */

/**
 * SS7 page Elementor data.
 *
 * @return array
 */
function bp_design_ss7() {
	$phone = brickpoint_get( 'phone' );
	$data  = array();

	// Hero.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				50,
				array(
					bp_el_widget( 'text-editor', array( 'editor' => '<p style="color:#9CA3AF;font-size:14px;margin:0 0 24px;"><a style="color:#9CA3AF;" href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'brickpoint' ) . '</a> &nbsp;/&nbsp; <span style="color:#FFFFFF;">' . esc_html__( 'SS7 Bricks', 'brickpoint' ) . '</span></p>' ) ),
					bp_el_widget( 'text-editor', array( 'editor' => '<p style="display:inline-block;background:#C0392B;color:#fff;border-radius:999px;padding:8px 16px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;">★ ' . esc_html__( 'Featured Brick Brand — BrickPoint', 'brickpoint' ) . '</p>' ) ),
					bp_w_heading( __( 'SS7 Bricks Trusted Quality for Construction', 'brickpoint' ), 'h1', '#FFFFFF', 50, 'left' ),
					bp_w_text( esc_html__( 'Discover SS7 bricks from BrickPoint — a recognized choice for construction projects where quality, consistency, and dependable supply matter.', 'brickpoint' ), '#D1D5DB', 18, 'left' ),
					bp_w_bp(
						'brickpoint-whatsapp-button',
						array(
							'label'    => __( 'Order on WhatsApp', 'brickpoint' ),
							'mode'     => 'modal',
							'product'  => 'SS7 Bricks',
							'category' => __( 'Bricks', 'brickpoint' ),
							'price'    => __( 'Price on Request', 'brickpoint' ),
							'variant'  => 'primary',
							'align'    => 'left',
						)
					),
					bp_w_button( __( 'View All Bricks', 'brickpoint' ), brickpoint_cat_url( 'bricks' ), '#FFFFFF', '#0F1F3D' ),
					bp_w_text(
						bp_bullets(
							array(
								__( 'SS7 Branded Quality', 'brickpoint' ),
								__( 'Consistent Supply', 'brickpoint' ),
								__( 'Bulk Orders Welcome', 'brickpoint' ),
								__( 'Multiple Locations', 'brickpoint' ),
							)
						),
						'#D1D5DB',
						14,
						'left'
					),
				)
			),
			bp_el_col( 50, array( bp_w_image( 'ss7-brick.jpg' ) ) ),
		),
		bp_sec_bg( '#0F1F3D', 64, 80 )
	);

	// About SS7.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				50,
				array(
					bp_w_eyebrow( __( 'About SS7 Bricks', 'brickpoint' ), 'left' ),
					bp_w_heading( __( 'A Trusted Choice for Strong Construction', 'brickpoint' ), 'h2', '#0F1F3D', 36, 'left' ),
					bp_w_text(
						'<p>' . sprintf(
							/* translators: 1: company, 2: company */
							esc_html__( 'SS7 bricks are available through BrickPoint, representing two established brick manufacturing companies in Pakistan — %1$s and %2$s.', 'brickpoint' ),
							'<strong style="color:#0F1F3D;">' . esc_html( brickpoint_get( 'company_1' ) ) . '</strong>',
							'<strong style="color:#0F1F3D;">' . esc_html( brickpoint_get( 'company_2' ) ) . '</strong>'
						) . '</p><p>' . esc_html__( 'The SS7 mark represents a commitment to consistent dimensions, quality clay, and reliable supply — making them a preferred choice among builders, contractors, and construction companies who need dependable materials.', 'brickpoint' ) . '</p><p>' . esc_html__( 'Whether you are building a residential home, commercial structure, boundary wall, or any other masonry project, SS7 bricks from BrickPoint offer consistent quality and dependable availability.', 'brickpoint' ) . '</p>',
						'#4B5563',
						16,
						'left'
					),
				)
			),
			bp_el_col( 50, array( bp_w_image( 'brick-factory.jpg' ) ) ),
		),
		bp_sec_bg( '#FAF8F5' )
	);

	// Details.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-section-heading',
						array(
							'eyebrow' => '',
							'title'   => __( 'SS7 Brick Details', 'brickpoint' ),
							'lead'    => __( 'Everything you need to know about ordering SS7 bricks from BrickPoint.', 'brickpoint' ),
							'align'   => 'center',
						)
					),
					bp_w_spacer( 24 ),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 80, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#F0EBE3' )
	);
	$data[] = bp_el_section(
		array(
			bp_el_col(
				66,
				array(
					bp_w_image( 'ss7-brick.jpg' ),
					bp_w_heading( __( 'SS7 Bricks — Standard', 'brickpoint' ), 'h3', '#0F1F3D', 22, 'left' ),
					bp_w_text( esc_html__( 'Premium SS7 branded standard bricks for residential and commercial construction. Manufactured under strict quality control with excellent dimensional consistency for walls, foundations, and structural applications.', 'brickpoint' ), '#4B5563', 16, 'left' ),
					bp_w_text(
						bp_bullets(
							array(
								__( 'SS7 Branded Quality', 'brickpoint' ),
								__( 'Consistent Dimensions', 'brickpoint' ),
								__( 'Suitable for Load-Bearing Walls', 'brickpoint' ),
								__( 'Available in Bulk Orders', 'brickpoint' ),
								__( 'Reliable Supply Chain', 'brickpoint' ),
								__( 'Multiple Factory Locations', 'brickpoint' ),
							),
							'#374151'
						),
						'#374151',
						14,
						'left'
					),
					bp_w_bp(
						'brickpoint-whatsapp-button',
						array(
							'label'    => __( 'Order on WhatsApp', 'brickpoint' ),
							'mode'     => 'modal',
							'product'  => 'SS7 Bricks',
							'category' => __( 'Bricks', 'brickpoint' ),
							'price'    => __( 'Price on Request', 'brickpoint' ),
							'variant'  => 'primary',
							'align'    => 'left',
						)
					),
					bp_w_button( __( 'Call to Order', 'brickpoint' ), 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ), '#0F1F3D' ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24, 'isLinked' => true ) )
			),
			bp_el_col(
				33,
				array(
					bp_w_heading( __( 'Product Information', 'brickpoint' ), 'h3', '#0F1F3D', 15, 'left' ),
					bp_w_text(
						esc_html__( 'Brand', 'brickpoint' ) . ': <strong>SS7</strong><br>' . esc_html__( 'Type', 'brickpoint' ) . ': <strong>' . esc_html__( 'Standard Clay Brick', 'brickpoint' ) . '</strong><br>' . esc_html__( 'Product Code', 'brickpoint' ) . ': <strong>SS7-STD</strong><br>' . esc_html__( 'Supplier', 'brickpoint' ) . ': <strong>BrickPoint</strong><br>' . esc_html__( 'Order Unit', 'brickpoint' ) . ': <strong>' . esc_html__( 'Per 1,000 Bricks', 'brickpoint' ) . '</strong>',
						'#4B5563',
						14,
						'left'
					),
					bp_w_spacer( 8 ),
					bp_w_heading( __( 'Quick Order', 'brickpoint' ), 'h3', '#0F1F3D', 15, 'left' ),
					bp_w_button( __( 'Order on WhatsApp', 'brickpoint' ), brickpoint_whatsapp_link( __( "Assalam-o-Alaikum BrickPoint,\nI am interested in SS7 Bricks. Please share the latest price and availability.", 'brickpoint' ) ), '#25D366', '#FFFFFF', true ),
					bp_w_text( esc_html__( 'Sales Manager:', 'brickpoint' ) . ' ' . esc_html( brickpoint_get( 'sales_manager' ) ), '#6B7280', 12, 'left' ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24, 'isLinked' => true ) )
			),
		),
		bp_sec_bg( '#F0EBE3', 24, 80 )
	);

	// Gallery.
	$gallery = array();
	foreach ( array( 'ss7-brick.jpg', 'bricks-stacked.jpg', 'brick-factory.jpg', 'construction-project.jpg' ) as $g ) {
		$att = brickpoint_import_image( $g );
		$gallery[] = array( 'id' => $att ? $att : '', 'url' => $att ? wp_get_attachment_url( $att ) : BRICKPOINT_URI . '/assets/images/' . $g );
	}
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_heading( __( 'SS7 Bricks Gallery', 'brickpoint' ), 'h2', '#0F1F3D', 24, 'left' ),
					bp_w_spacer( 16 ),
					bp_el_widget( 'image-gallery', array( 'gallery' => $gallery, 'gallery_columns' => 4, 'gallery_link' => 'file', 'gallery_rand' => '', 'aspect_ratio' => '1/1' ) ),
				)
			),
		),
		bp_sec_bg( '#FAF8F5', 64, 64 )
	);

	// Applications.
	$apps = array(
		__( 'Residential Homes', 'brickpoint' ),
		__( 'Commercial Buildings', 'brickpoint' ),
		__( 'Boundary Walls', 'brickpoint' ),
		__( 'Villa Construction', 'brickpoint' ),
		__( 'Housing Projects', 'brickpoint' ),
		__( 'General Masonry', 'brickpoint' ),
	);
	$app_cols = array();
	foreach ( array_chunk( $apps, 3 ) as $row ) {
		foreach ( $row as $app ) {
			$app_cols[] = bp_el_col(
				33,
				array(
					bp_w_text( '🧱<br><strong style="color:#fff;font-size:13px;">' . esc_html( $app ) . '</strong>', '#FFFFFF', 13, 'center' ),
				),
				array( 'background_background' => 'classic', 'background_color' => 'rgba(255,255,255,0.05)', 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ), 'border_color' => 'rgba(255,255,255,0.1)', 'border_radius' => array( 'unit' => 'px', 'top' => 12, 'right' => 12, 'bottom' => 12, 'left' => 12, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ) )
			);
		}
	}
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_heading( __( 'SS7 Brick Applications', 'brickpoint' ), 'h2', '#FFFFFF', 30, 'center' ),
					bp_w_text( esc_html__( 'Suitable for a wide range of construction projects', 'brickpoint' ), '#9CA3AF', 16, 'center' ),
					bp_w_spacer( 24 ),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 64, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#0F1F3D' )
	);
	$data[] = bp_el_section( array_slice( $app_cols, 0, 3 ), bp_sec_bg( '#0F1F3D', 0, 12 ) );
	$data[] = bp_el_section( array_slice( $app_cols, 3, 3 ), bp_sec_bg( '#0F1F3D', 0, 64 ) );

	// FAQ.
	$faq_tabs = array();
	foreach ( array(
		array( __( 'What are SS7 bricks?', 'brickpoint' ), __( 'SS7 bricks are a branded variety of red clay construction bricks available through BrickPoint via Masha Allah Bricks Company and Fine Bricks Company. They are recognized for consistent quality and reliable availability.', 'brickpoint' ) ),
		array( __( 'Where can I order SS7 bricks?', 'brickpoint' ), sprintf( __( 'You can order SS7 bricks directly through WhatsApp at %s, by calling the same number, or by visiting our factory locations at Ram Thaman (Bhatta 1 & 3) and Raja Jang (Bhatta 2).', 'brickpoint' ), $phone ) ),
		array( __( 'Do you supply SS7 bricks in bulk?', 'brickpoint' ), __( 'Yes, we supply SS7 bricks in bulk quantities for residential, commercial, and development projects. Contact us on WhatsApp with your quantity requirements for a quotation.', 'brickpoint' ) ),
		array( __( 'What is the price of SS7 bricks?', 'brickpoint' ), __( 'Brick prices can vary based on quantity, location, and market conditions. Contact us on WhatsApp or by phone for the latest pricing and availability.', 'brickpoint' ) ),
		array( __( 'Do you deliver to construction sites?', 'brickpoint' ), __( 'Please contact us directly on WhatsApp or by phone to discuss delivery arrangements and logistics for your project location.', 'brickpoint' ) ),
		array( __( 'What other products does BrickPoint supply?', 'brickpoint' ), __( 'In addition to SS7 bricks, BrickPoint supplies a wide range of construction materials including cement, steel, sand, crush, electric pipes, plumbing fittings, construction chemicals, paints, lights, and more.', 'brickpoint' ) ),
	) as $faq ) {
		$faq_tabs[] = array(
			'tab_title'   => $faq[0],
			'tab_content' => '<p>' . esc_html( $faq[1] ) . '</p>',
			'_id'         => bp_el_id(),
		);
	}
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_heading( __( 'Frequently Asked Questions', 'brickpoint' ), 'h2', '#0F1F3D', 30, 'center' ),
					bp_w_text( esc_html__( 'Common questions about SS7 bricks and ordering', 'brickpoint' ), '#4B5563', 16, 'center' ),
					bp_w_spacer( 24 ),
					bp_el_widget( 'accordion', array( 'tabs' => $faq_tabs, 'title_html_tag' => 'h3' ) ),
				)
			),
		),
		bp_sec_bg( '#FAF8F5' )
	);

	// CTA.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-cta-banner',
						array(
							'title'         => __( 'Order SS7 Bricks Today', 'brickpoint' ),
							'sub'           => __( 'Contact BrickPoint on WhatsApp for pricing, availability, and bulk orders.', 'brickpoint' ),
							'note'          => '',
							'primary_label' => __( 'Order on WhatsApp', 'brickpoint' ),
							'show_call'     => 'yes',
						)
					),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ) )
	);

	return $data;
}

/* ---------------------------------------------------------------------------
 * PROJECTS page design
 * ------------------------------------------------------------------------- */

/**
 * Projects page Elementor data.
 *
 * @return array
 */
function bp_design_projects() {
	$data = array();
	$data[] = bp_frag_page_hero(
		__( 'Projects', 'brickpoint' ),
		__( 'Construction Showcases', 'brickpoint' ),
		__( 'Explore featured construction project inspirations showcasing quality brickwork and construction material applications.', 'brickpoint' ),
		'construction-project.jpg'
	);

	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_text( 'ℹ️ <strong>' . esc_html__( 'Note:', 'brickpoint' ) . '</strong> ' . esc_html__( 'Projects marked as "Illustrative" are representative construction showcases for inspiration purposes. They do not represent confirmed BrickPoint client projects or official supply agreements with the mentioned communities.', 'brickpoint' ), '#92400E', 14, 'left' ),
				)
			),
		),
		bp_sec_bg( '#F0EBE3', 16, 16 )
	);

	$projects = brickpoint_get_projects();
	if ( ! $projects ) {
		// Static fallback cards (same content as theme fallback).
		$cards = array(
			array( __( 'Modern Residential Villa — DHA Lahore', 'brickpoint' ), __( 'Residential', 'brickpoint' ), __( 'DHA Lahore', 'brickpoint' ), 'construction-project.jpg', __( 'A modern residential villa featuring premium SS7 brickwork and quality construction materials.', 'brickpoint' ) ),
			array( __( 'Commercial Development — Bahria Town Lahore', 'brickpoint' ), __( 'Commercial', 'brickpoint' ), __( 'Bahria Town Lahore', 'brickpoint' ), 'hero-bricks.jpg', __( 'A multi-storey commercial building project utilizing quality construction materials.', 'brickpoint' ) ),
			array( __( 'Residential Housing — Lake City Lahore', 'brickpoint' ), __( 'Residential', 'brickpoint' ), __( 'Lake City Lahore', 'brickpoint' ), 'brick-factory.jpg', __( 'Premium residential construction featuring quality brickwork and modern materials.', 'brickpoint' ) ),
			array( __( 'Expert Brickwork — Etihad Town Lahore', 'brickpoint' ), __( 'Brickwork / Masonry', 'brickpoint' ), __( 'Etihad Town Lahore', 'brickpoint' ), 'bricks-stacked.jpg', __( 'Precision masonry and brickwork using SS7 branded bricks.', 'brickpoint' ) ),
			array( __( 'Villa Construction — Al-Kabir Town Lahore', 'brickpoint' ), __( 'Residential', 'brickpoint' ), __( 'Al-Kabir Town Lahore', 'brickpoint' ), 'construction-project.jpg', __( 'Double-storey residential villa construction featuring quality brick masonry.', 'brickpoint' ) ),
			array( __( 'Construction Project — Paragon City Lahore', 'brickpoint' ), __( 'Residential', 'brickpoint' ), __( 'Paragon City Lahore', 'brickpoint' ), 'about-team.jpg', __( 'Residential construction project for a premium community development.', 'brickpoint' ) ),
		);
		$chunks = array_chunk( $cards, 3 );
		foreach ( $chunks as $ci => $chunk ) {
			$cols = array();
			foreach ( $chunk as $card ) {
				list( $t, $c, $l, $img, $d ) = $card;
				$cols[] = bp_el_col(
					33,
					array(
						bp_w_image( $img ),
						bp_el_widget( 'text-editor', array( 'editor' => '<p style="display:inline-block;background:#C0392B;color:#fff;border-radius:999px;padding:4px 12px;font-size:12px;font-weight:600;">' . esc_html( $c ) . '</p>' ) ),
						bp_w_heading( $t, 'h3', '#0F1F3D', 17, 'left' ),
						bp_w_text( '📍 ' . esc_html( $l ), '#6B7280', 13, 'left' ),
						bp_w_text( esc_html( $d ), '#4B5563', 14, 'left' ),
					),
					array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ), 'border_color' => '#F3F4F6', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'isLinked' => true ) )
				);
			}
			$data[] = bp_el_section( $cols, bp_sec_bg( '#FAF8F5', 0 === $ci ? 56 : 12, 12 ) );
		}
	} else {
		$chunks = array_chunk( $projects, 3 );
		foreach ( $chunks as $ci => $chunk ) {
			$cols = array();
			foreach ( $chunk as $p ) {
				$img = get_the_post_thumbnail_url( $p->ID, 'brickpoint-card' );
				if ( ! $img ) {
					$img = BRICKPOINT_URI . '/assets/images/construction-project.jpg';
				}
				$terms = get_the_terms( $p->ID, 'project_category' );
				$cat = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'Project', 'brickpoint' );
				$loc = get_post_meta( $p->ID, '_bp_location', true );
				$cols[] = bp_el_col(
					33,
					array(
						bp_el_widget( 'image', array( 'image' => array( 'url' => $img, 'id' => '' ), 'align' => 'center' ) ),
						bp_el_widget( 'text-editor', array( 'editor' => '<p style="display:inline-block;background:#C0392B;color:#fff;border-radius:999px;padding:4px 12px;font-size:12px;font-weight:600;">' . esc_html( $cat ) . '</p>' ) ),
						bp_w_heading( $p->post_title, 'h3', '#0F1F3D', 17, 'left' ),
						bp_w_text( '📍 ' . esc_html( $loc ), '#6B7280', 13, 'left' ),
						bp_w_text( esc_html( $p->post_excerpt ), '#4B5563', 14, 'left' ),
					),
					array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ), 'border_color' => '#F3F4F6', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'isLinked' => true ) )
				);
			}
			$data[] = bp_el_section( $cols, bp_sec_bg( '#FAF8F5', 0 === $ci ? 56 : 12, 12 ) );
		}
	}

	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_bp(
						'brickpoint-cta-banner',
						array(
							'title'         => __( 'Have a Project in Mind?', 'brickpoint' ),
							'sub'           => __( 'Tell us about your material requirements and get a quotation on WhatsApp.', 'brickpoint' ),
							'note'          => '',
							'primary_label' => __( 'Order on WhatsApp', 'brickpoint' ),
							'show_call'     => 'yes',
						)
					),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 56, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ) )
	);

	return $data;
}

/* ---------------------------------------------------------------------------
 * LOCATIONS page design
 * ------------------------------------------------------------------------- */

/**
 * Locations page Elementor data.
 *
 * @return array
 */
function bp_design_locations() {
	$phone = brickpoint_get( 'phone' );
	$data  = array();
	$data[] = bp_frag_page_hero(
		__( 'Locations', 'brickpoint' ),
		__( 'Find Us', 'brickpoint' ),
		__( 'Visit our brick factories or contact us for delivery to your construction site. Multiple locations for your convenience.', 'brickpoint' ),
		'brick-factory.jpg'
	);

	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_eyebrow( __( 'Manufacturing Facilities', 'brickpoint' ), 'left' ),
					bp_w_heading( __( 'Our Brick Factory Locations', 'brickpoint' ), 'h2', '#0F1F3D', 36, 'left' ),
					bp_w_text( esc_html__( 'BrickPoint operates three brick manufacturing facilities (bhattas) producing SS7 bricks and quality construction materials.', 'brickpoint' ), '#4B5563', 18, 'left' ),
					bp_w_spacer( 24 ),
					bp_w_bp( 'brickpoint-location-grid', array( 'type' => 'factory', 'layout' => 'cards', 'columns' => '3' ) ),
				)
			),
		),
		bp_sec_bg( '#FAF8F5' )
	);

	// Office + help.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_eyebrow( __( 'Main Office', 'brickpoint' ), 'left' ),
					bp_w_heading( __( 'BrickPoint Office', 'brickpoint' ), 'h2', '#0F1F3D', 30, 'left' ),
					bp_w_spacer( 16 ),
				)
			),
		),
		array( 'padding' => array( 'unit' => 'px', 'top' => 56, 'right' => 0, 'bottom' => 0, 'left' => 0, 'isLinked' => false ), 'background_background' => 'classic', 'background_color' => '#F0EBE3' )
	);
	$data[] = bp_el_section(
		array(
			bp_el_col(
				50,
				array(
					bp_w_heading( __( 'BrickPoint Office', 'brickpoint' ), 'h3', '#0F1F3D', 24, 'left' ),
					bp_w_text( esc_html__( 'Main office for BrickPoint — handling sales, inquiries, and customer support.', 'brickpoint' ), '#4B5563', 16, 'left' ),
					bp_w_text( '<span style="color:#6B7280;font-size:12px;">' . esc_html__( 'Phone / WhatsApp', 'brickpoint' ) . '</span><br><a style="color:#0F1F3D;font-weight:600;font-size:18px;" href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>', '#0F1F3D', 16, 'left' ),
					bp_w_button( __( 'Get Directions', 'brickpoint' ), 'https://maps.app.goo.gl/GACXw15YxyV4bK5t8?g_st=awb', '#0F1F3D', '#FFFFFF', true ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'isLinked' => true ) )
			),
			bp_el_col(
				50,
				array(
					bp_w_heading( __( 'Need Help Finding Us?', 'brickpoint' ), 'h3', '#FFFFFF', 24, 'left' ),
					bp_w_text( esc_html__( 'Contact our sales team on WhatsApp or phone for directions and delivery arrangements.', 'brickpoint' ), '#D1D5DB', 16, 'left' ),
					bp_w_text(
						'<span style="color:#9CA3AF;font-size:12px;text-transform:uppercase;">' . esc_html__( 'CEO', 'brickpoint' ) . '</span><br><strong style="color:#fff;">' . esc_html( brickpoint_get( 'ceo' ) ) . '</strong><br><br><span style="color:#9CA3AF;font-size:12px;text-transform:uppercase;">' . esc_html__( 'Sales Manager', 'brickpoint' ) . '</span><br><strong style="color:#fff;">' . esc_html( brickpoint_get( 'sales_manager' ) ) . '</strong><br><br><span style="color:#9CA3AF;font-size:12px;text-transform:uppercase;">' . esc_html__( 'Phone / WhatsApp', 'brickpoint' ) . '</span><br><a style="color:#fff;font-weight:600;font-size:20px;" href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>',
						'#D1D5DB',
						16,
						'left'
					),
					bp_w_button( __( 'WhatsApp Us', 'brickpoint' ), brickpoint_whatsapp_link(), '#25D366', '#FFFFFF', true ),
					bp_w_button( __( 'Call Now', 'brickpoint' ), 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ), '#FFFFFF', '#FFFFFF', false, 'left', true ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#0F1F3D', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'isLinked' => true ) )
			),
		),
		bp_sec_bg( '#F0EBE3', 24, 56 )
	);

	// At a glance.
	$data[] = bp_el_section(
		array(
			bp_el_col(
				100,
				array(
					bp_w_heading( __( 'All Locations at a Glance', 'brickpoint' ), 'h2', '#0F1F3D', 24, 'center' ),
					bp_w_spacer( 24 ),
					bp_w_bp( 'brickpoint-location-grid', array( 'type' => '', 'layout' => 'glance', 'columns' => '4' ) ),
				)
			),
		),
		bp_sec_bg( '#FAF8F5', 56, 56 )
	);

	return $data;
}

/* ---------------------------------------------------------------------------
 * CONTACT page design
 * ------------------------------------------------------------------------- */

/**
 * Contact page Elementor data.
 *
 * @return array
 */
function bp_design_contact() {
	$phone   = brickpoint_get( 'phone' );
	$socials = brickpoint_social_links();
	$data    = array();
	$data[]  = bp_frag_page_hero(
		__( 'Contact Us', 'brickpoint' ),
		__( "Let's Build Something Stronger", 'brickpoint' ),
		__( 'Reach out to our team for product pricing, availability, bulk orders, and general inquiries.', 'brickpoint' ),
		'about-team.jpg'
	);

	$data[] = bp_el_section(
		array(
			bp_el_col(
				33,
				array(
					bp_w_heading( __( 'Order on WhatsApp', 'brickpoint' ), 'h3', '#FFFFFF', 18, 'left' ),
					bp_w_text( esc_html__( 'The fastest way to reach us. Send your order or inquiry directly on WhatsApp.', 'brickpoint' ), '#D1D5DB', 14, 'left' ),
					bp_w_button( __( 'Chat on WhatsApp', 'brickpoint' ), brickpoint_whatsapp_link(), '#25D366', '#FFFFFF', true ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#0F1F3D', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24, 'isLinked' => true ) )
			),
			bp_el_col(
				66,
				array(
					bp_el_widget( 'shortcode', array( 'shortcode' => '[brickpoint_contact_form]' ) ),
				)
			),
		),
		bp_sec_bg( '#FAF8F5', 56, 24 )
	);

	$data[] = bp_el_section(
		array(
			bp_el_col(
				33,
				array(
					bp_w_heading( __( 'Call Us', 'brickpoint' ), 'h3', '#0F1F3D', 18, 'left' ),
					bp_w_text( '<a style="color:#C0392B;font-weight:900;font-size:24px;" href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a><br><span style="color:#6B7280;font-size:14px;">' . esc_html__( 'CEO:', 'brickpoint' ) . ' ' . esc_html( brickpoint_get( 'ceo' ) ) . '<br>' . esc_html__( 'Sales:', 'brickpoint' ) . ' ' . esc_html( brickpoint_get( 'sales_manager' ) ) . '</span>', '#6B7280', 14, 'left' ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ), 'border_color' => '#F3F4F6', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24, 'isLinked' => true ) )
			),
			bp_el_col(
				33,
				array(
					bp_w_heading( __( 'Our Locations', 'brickpoint' ), 'h3', '#0F1F3D', 18, 'left' ),
					bp_w_text(
						'<strong style="color:#0F1F3D;">' . esc_html__( 'Masha Allah Bricks — Bhatta 1', 'brickpoint' ) . '</strong><br>' . esc_html__( 'Ram Thaman', 'brickpoint' ) . '<br><br><strong style="color:#0F1F3D;">' . esc_html__( 'Fine Bricks Co. — Bhatta 2', 'brickpoint' ) . '</strong><br>' . esc_html__( 'Raja Jang', 'brickpoint' ) . '<br><br><a style="color:#C0392B;font-size:12px;" href="' . esc_url( home_url( '/locations/' ) ) . '">' . esc_html__( 'View All Locations →', 'brickpoint' ) . '</a>',
						'#4B5563',
						14,
						'left'
					),
				),
				array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ), 'border_color' => '#F3F4F6', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24, 'isLinked' => true ) )
			),
			bp_el_col(
				33,
				array(
					bp_w_heading( __( 'Follow Us', 'brickpoint' ), 'h3', '#0F1F3D', 18, 'left' ),
					bp_w_text(
						'<a style="color:#0F1F3D;font-size:14px;" href="' . esc_url( $socials['facebook'] ) . '" target="_blank" rel="noopener">Facebook</a> &nbsp;•&nbsp; <a style="color:#0F1F3D;font-size:14px;" href="' . esc_url( $socials['instagram'] ) . '" target="_blank" rel="noopener">Instagram</a> &nbsp;•&nbsp; <a style="color:#0F1F3D;font-size:14px;" href="' . esc_url( $socials['twitter'] ) . '" target="_blank" rel="noopener">X</a> &nbsp;•&nbsp; <a style="color:#0F1F3D;font-size:14px;" href="' . esc_url( $socials['tiktok'] ) . '" target="_blank" rel="noopener">TikTok</a>',
						'#0F1F3D',
						14,
						'left'
					),
					bp_w_button( __( 'Join WhatsApp Channel', 'brickpoint' ), brickpoint_get( 'whatsapp_channel' ), '#25D366', '#FFFFFF', true ),
				),
				array( 'background_background' => 'classic', 'background_color' => '#FFFFFF', 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'isLinked' => true ), 'border_color' => '#F3F4F6', 'border_radius' => array( 'unit' => 'px', 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'isLinked' => true ), 'padding' => array( 'unit' => 'px', 'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24, 'isLinked' => true ) )
			),
		),
		bp_sec_bg( '#FAF8F5', 0, 56 )
	);

	return $data;
}

/* ---------------------------------------------------------------------------
 * Apply designs to pages
 * ------------------------------------------------------------------------- */

/**
 * Map of page slug => [label, design builder].
 *
 * @return array
 */
function bp_elementor_design_map() {
	return array(
		'home'       => array( __( 'Home', 'brickpoint' ), 'bp_design_home' ),
		'about'      => array( __( 'About Us', 'brickpoint' ), 'bp_design_about' ),
		'products'   => array( __( 'Products', 'brickpoint' ), 'bp_design_products' ),
		'ss7-bricks' => array( __( 'SS7 Bricks', 'brickpoint' ), 'bp_design_ss7' ),
		'projects'   => array( __( 'Projects', 'brickpoint' ), 'bp_design_projects' ),
		'locations'  => array( __( 'Locations', 'brickpoint' ), 'bp_design_locations' ),
		'contact'    => array( __( 'Contact Us', 'brickpoint' ), 'bp_design_contact' ),
	);
}

/**
 * Resolve design targets to actual page IDs.
 *
 * Matches pages by slug, plus the assigned front page (whatever its slug is)
 * so the Home design always lands on the real homepage.
 *
 * @return array post_id => [label, builder, slug]
 */
function brickpoint_design_targets() {
	$targets = array();
	$found_home = false;
	foreach ( bp_elementor_design_map() as $slug => $info ) {
		list( $label, $builder ) = $info;
		$page = get_page_by_path( $slug );
		if ( $page && 'page' === $page->post_type ) {
			$targets[ $page->ID ] = array( $label, $builder, $slug );
			if ( 'home' === $slug ) {
				$found_home = true;
			}
		}
	}
	if ( ! $found_home ) {
		$front_id = (int) get_option( 'page_on_front' );
		if ( $front_id && 'page' === get_post_type( $front_id ) && ! isset( $targets[ $front_id ] ) ) {
			$targets[ $front_id ] = array( __( 'Home', 'brickpoint' ), 'bp_design_home', get_post_field( 'post_name', $front_id ) );
		}
	}
	return $targets;
}

/**
 * Whether a page already has Elementor builder content.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function brickpoint_page_has_elementor( $post_id ) {
	$mode = get_post_meta( $post_id, '_elementor_edit_mode', true );
	$data = get_post_meta( $post_id, '_elementor_data', true );
	return ( 'builder' === $mode && ! empty( $data ) && '[]' !== $data );
}

/**
 * Apply Elementor designs to demo pages.
 * Never overwrites existing Elementor content unless $force is true.
 *
 * @param bool $force Rebuild even if page already has Elementor data.
 * @return int Number of pages built.
 */
function brickpoint_apply_elementor_designs( $force = false ) {
	if ( ! brickpoint_has_elementor() ) {
		return 0;
	}
	$count = 0;
	foreach ( brickpoint_design_targets() as $post_id => $info ) {
		list( $label, $builder, $slug ) = $info;
		if ( ! function_exists( $builder ) ) {
			continue;
		}
		if ( ! $force && brickpoint_page_has_elementor( $post_id ) ) {
			continue;
		}
		$data = call_user_func( $builder );
		if ( empty( $data ) ) {
			continue;
		}
		update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
		update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
		update_post_meta( $post_id, '_elementor_template_type', 'wp-page' );
		update_post_meta( $post_id, '_elementor_version', defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0' );
		// Keep default page layout so theme header/footer render.
		delete_post_meta( $post_id, '_elementor_page_settings' );
		$count++;
	}
	if ( $count && class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}
	return $count;
}

/**
 * Auto-apply missing Elementor designs (runs once per designs version).
 * Fills only pages WITHOUT Elementor content — user edits are never touched.
 */
function brickpoint_maybe_auto_apply_designs() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! brickpoint_has_elementor() ) {
		return;
	}
	if ( get_option( 'brickpoint_el_designs_auto', '' ) === BRICKPOINT_EL_DESIGNS_VERSION ) {
		return;
	}
	$count = brickpoint_apply_elementor_designs( false );
	update_option( 'brickpoint_el_designs_auto', BRICKPOINT_EL_DESIGNS_VERSION );
	if ( $count > 0 ) {
		set_transient( 'brickpoint_el_built', $count, 120 );
	}
}
add_action( 'admin_init', 'brickpoint_maybe_auto_apply_designs' );

/**
 * Success notice after auto-apply.
 */
function brickpoint_el_built_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$count = get_transient( 'brickpoint_el_built' );
	if ( ! $count ) {
		return;
	}
	delete_transient( 'brickpoint_el_built' );
	echo '<div class="notice notice-success is-dismissible"><p>';
	printf(
		/* translators: 1: count, 2: pages link */
		esc_html__( 'BrickPoint applied editable Elementor designs to %1$d pages. Open any page with %2$s to edit it visually.', 'brickpoint' ),
		esc_html( $count ),
		'<a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '">' . esc_html__( 'Edit with Elementor', 'brickpoint' ) . '</a>'
	);
	echo '</p></div>';
}
add_action( 'admin_notices', 'brickpoint_el_built_notice' );
