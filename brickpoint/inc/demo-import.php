<?php
/**
 * BrickPoint Setup: admin page + optional one-click demo content import.
 * Recreates pages, menus, locations, projects, blog posts, WooCommerce
 * categories/products from the original website content.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'brickpoint_setup_menu' );
/**
 * Setup menu.
 */
function brickpoint_setup_menu() {
	add_theme_page(
		__( 'BrickPoint Setup', 'brickpoint' ),
		__( 'BrickPoint Setup', 'brickpoint' ),
		'manage_options',
		'brickpoint-setup',
		'brickpoint_setup_page'
	);
}

/**
 * Setup page.
 */
function brickpoint_setup_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$message = '';
	if ( isset( $_POST['brickpoint_import'] ) && check_admin_referer( 'brickpoint_import' ) ) {
		$result  = brickpoint_run_import();
		$message = $result ? __( 'Demo content imported successfully.', 'brickpoint' ) : __( 'Import finished with warnings — see content lists to verify.', 'brickpoint' );
	}
	$has_elementor = brickpoint_has_elementor();
	$has_woo       = class_exists( 'WooCommerce' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'BrickPoint Setup', 'brickpoint' ); ?></h1>
		<?php if ( $message ) : ?>
			<div class="notice notice-success"><p><?php echo esc_html( $message ); ?></p></div>
		<?php endif; ?>
		<div class="card" style="max-width:800px">
			<h2><?php esc_html_e( '1. Required Plugins', 'brickpoint' ); ?></h2>
			<p>
				Elementor: <strong><?php echo $has_elementor ? esc_html__( 'Installed ✓', 'brickpoint' ) : esc_html__( 'Not installed', 'brickpoint' ); ?></strong><br>
				WooCommerce: <strong><?php echo $has_woo ? esc_html__( 'Installed ✓', 'brickpoint' ) : esc_html__( 'Not installed', 'brickpoint' ); ?></strong>
			</p>
			<?php if ( ! $has_elementor || ! $has_woo ) : ?>
				<p><a class="button" href="<?php echo esc_url( admin_url( 'plugin-install.php?s=elementor&tab=search&type=term' ) ); ?>"><?php esc_html_e( 'Install Elementor', 'brickpoint' ); ?></a>
				<a class="button" href="<?php echo esc_url( admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) ); ?>"><?php esc_html_e( 'Install WooCommerce', 'brickpoint' ); ?></a></p>
			<?php endif; ?>
		</div>
		<div class="card" style="max-width:800px">
			<h2><?php esc_html_e( '2. Import Demo Content', 'brickpoint' ); ?></h2>
			<p><?php esc_html_e( 'Creates pages (Home, About, Products, SS7 Bricks, Projects, Locations, Blog, Contact), navigation menus, 4 locations, 6 projects, 5 blog posts, 14 WooCommerce product categories and starter products — matching the original BrickPoint website. Safe to run once; existing content with the same slugs is skipped.', 'brickpoint' ); ?></p>
			<form method="post">
				<?php wp_nonce_field( 'brickpoint_import' ); ?>
				<p><button type="submit" name="brickpoint_import" value="1" class="button button-primary button-large"><?php esc_html_e( 'Import BrickPoint Demo Content', 'brickpoint' ); ?></button></p>
			</form>
		</div>
		<div class="card" style="max-width:800px">
			<h2><?php esc_html_e( '3. Elementor Page Designs', 'brickpoint' ); ?></h2>
			<p><?php esc_html_e( 'Builds the full Home, About, Products, SS7 Bricks, Projects, Locations and Contact designs as native, editable Elementor content. Run this after import (or anytime to restore the designs — your Elementor edits on those pages will be overwritten).', 'brickpoint' ); ?></p>
			<form method="post">
				<?php wp_nonce_field( 'brickpoint_import' ); ?>
				<p><button type="submit" name="brickpoint_build_elementor" value="1" class="button button-secondary button-large"><?php esc_html_e( 'Build Elementor Page Designs', 'brickpoint' ); ?></button></p>
			</form>
		</div>
		<div class="card" style="max-width:800px">
			<h2><?php esc_html_e( '4. Elementor Header & Footer (optional)', 'brickpoint' ); ?></h2>
			<p><?php esc_html_e( 'The theme ships with pixel-faithful fallback header/footer. To manage them visually, go to Elementor → Theme Builder and create Header/Footer templates — they automatically override the theme fallback. Elementor Pro is required for Theme Builder locations; without it the fallback header/footer remain fully functional.', 'brickpoint' ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * Sideload a theme bundle image into the Media Library (once per filename).
 *
 * @param string $file Filename under assets/images/.
 * @return int Attachment ID (0 on failure).
 */
function brickpoint_import_image( $file ) {
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'meta_key'       => '_bp_source_file',
			'meta_value'     => $file,
		)
	);
	if ( $existing ) {
		return $existing[0]->ID;
	}
	$path = BRICKPOINT_DIR . '/assets/images/' . $file;
	if ( ! file_exists( $path ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$tmp = wp_tempnam( $file );
	if ( ! $tmp ) {
		return 0;
	}
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_put_contents
	file_put_contents( $tmp, file_get_contents( $path ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_get_contents
	$file_array = array(
		'name'     => sanitize_file_name( $file ),
		'tmp_name' => $tmp,
	);
	$att_id = media_handle_sideload( $file_array, 0, sanitize_file_name( pathinfo( $file, PATHINFO_FILENAME ) ) );
	if ( is_wp_error( $att_id ) ) {
		return 0;
	}
	update_post_meta( $att_id, '_bp_source_file', $file );
	return (int) $att_id;
}

/**
 * Run the full import.
 *
 * @return bool
 */
function brickpoint_run_import() {
	brickpoint_import_pages();
	brickpoint_import_menus();
	brickpoint_import_locations();
	brickpoint_import_projects();
	brickpoint_import_posts();
	if ( class_exists( 'WooCommerce' ) ) {
		brickpoint_import_woo();
	}
	flush_rewrite_rules();
	return true;
}

/**
 * Create pages.
 */
function brickpoint_import_pages() {
	$pages = array(
		array( 'title' => 'Home', 'slug' => 'home', 'template' => 'front-page.php', 'front' => true ),
		array( 'title' => 'About Us', 'slug' => 'about', 'template' => 'page-about.php' ),
		array( 'title' => 'Products', 'slug' => 'products', 'template' => 'page-products.php' ),
		array( 'title' => 'SS7 Bricks', 'slug' => 'ss7-bricks', 'template' => 'page-ss7-bricks.php' ),
		array( 'title' => 'Projects', 'slug' => 'projects', 'template' => 'page-projects.php' ),
		array( 'title' => 'Locations', 'slug' => 'locations', 'template' => 'page-locations.php' ),
		array( 'title' => 'Blog', 'slug' => 'blog', 'template' => '', 'posts' => true ),
		array( 'title' => 'Contact Us', 'slug' => 'contact', 'template' => 'page-contact.php' ),
	);
	foreach ( $pages as $p ) {
		$existing = get_page_by_path( $p['slug'] );
		if ( $existing ) {
			$id = $existing->ID;
		} else {
			$id = wp_insert_post(
				array(
					'post_type'   => 'page',
					'post_title'  => $p['title'],
					'post_name'   => $p['slug'],
					'post_status' => 'publish',
				)
			);
		}
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		if ( $p['template'] ) {
			update_post_meta( $id, '_wp_page_template', $p['template'] );
		}
		if ( ! empty( $p['front'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $id );
		}
		if ( ! empty( $p['posts'] ) ) {
			update_option( 'page_for_posts', $id );
		}
	}
}

/**
 * Create menus.
 */
function brickpoint_import_menus() {
	$menu_name = 'Primary Menu';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = $menu->term_id;
	}
	if ( ! $menu_id || is_wp_error( $menu_id ) ) {
		return;
	}
	$has_items = wp_get_nav_menu_items( $menu_id );
	if ( $has_items ) {
		brickpoint_assign_menu( $menu_id );
		return;
	}
	$add = function ( $title, $url, $parent = 0 ) use ( $menu_id ) {
		return wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => $title,
				'menu-item-url'    => $url,
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
				'menu-item-parent-id' => $parent,
			)
		);
	};
	$add( 'Home', home_url( '/' ) );
	$add( 'About Us', home_url( '/about/' ) );
	$shop_link = class_exists( 'WooCommerce' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/products/' );
	$products_parent = $add( 'Products', $shop_link ? $shop_link : home_url( '/products/' ) );
	foreach ( brickpoint_category_meta() as $cat ) {
		$add( $cat['name'], brickpoint_cat_url( $cat['slug'] ), $products_parent );
	}
	$add( 'SS7 Bricks', home_url( '/ss7-bricks/' ) );
	$add( 'Projects', home_url( '/projects/' ) );
	$add( 'Locations', home_url( '/locations/' ) );
	$add( 'Blog', home_url( '/blog/' ) );
	$add( 'Contact Us', home_url( '/contact/' ) );
	brickpoint_assign_menu( $menu_id );

	// Footer quick links.
	$footer = wp_get_nav_menu_object( 'Footer Quick Links' );
	if ( ! $footer ) {
		$fid = wp_create_nav_menu( 'Footer Quick Links' );
		if ( $fid && ! is_wp_error( $fid ) ) {
			foreach ( array(
				array( 'Home', home_url( '/' ) ),
				array( 'About Us', home_url( '/about/' ) ),
				array( 'SS7 Bricks', home_url( '/ss7-bricks/' ) ),
				array( 'Projects', home_url( '/projects/' ) ),
				array( 'Locations', home_url( '/locations/' ) ),
				array( 'Blog', home_url( '/blog/' ) ),
				array( 'Contact Us', home_url( '/contact/' ) ),
			) as $l ) {
				wp_update_nav_menu_item(
					$fid,
					0,
					array(
						'menu-item-title'  => $l[0],
						'menu-item-url'    => $l[1],
						'menu-item-status' => 'publish',
						'menu-item-type'   => 'custom',
					)
				);
			}
			$locs = get_theme_mod( 'nav_menu_locations', array() );
			$locs['footer'] = $fid;
			set_theme_mod( 'nav_menu_locations', $locs );
		}
	}
}

/**
 * Assign primary menu location.
 *
 * @param int $menu_id Menu ID.
 */
function brickpoint_assign_menu( $menu_id ) {
	$locs = get_theme_mod( 'nav_menu_locations', array() );
	if ( empty( $locs['primary'] ) ) {
		$locs['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locs );
	}
}

/**
 * Import locations.
 */
function brickpoint_import_locations() {
	$locations = array(
		array(
			'name' => 'Masha Allah Bricks Company — Bhatta 1',
			'slug' => 'bhatta-1-ram-thaman',
			'company' => 'Masha Allah Bricks Company',
			'area'    => 'Ram Thaman',
			'type'    => 'factory',
			'maps'    => 'https://maps.app.goo.gl/6Pi5BNTsxPRkn1cn7?g_st=awb',
		),
		array(
			'name' => 'Masha Allah Bricks Company — Bhatta 3',
			'slug' => 'bhatta-3',
			'company' => 'Masha Allah Bricks Company',
			'area'    => '',
			'type'    => 'factory',
			'maps'    => 'https://google.com/maps?q=31.2328,74.3169424&z=17&hl=en',
		),
		array(
			'name' => 'Fine Bricks Company — Bhatta 2',
			'slug' => 'bhatta-2-raja-jang',
			'company' => 'Fine Bricks Company',
			'area'    => 'Raja Jang',
			'type'    => 'factory',
			'maps'    => 'https://maps.app.goo.gl/SDaxqVM55qXt66wW8?g_st=awb',
		),
		array(
			'name' => 'BrickPoint Office',
			'slug' => 'brickpoint-office',
			'company' => 'BrickPoint',
			'area'    => '',
			'type'    => 'office',
			'maps'    => 'https://maps.app.goo.gl/GACXw15YxyV4bK5t8?g_st=awb',
		),
	);
	foreach ( $locations as $i => $l ) {
		$existing = get_page_by_path( $l['slug'], OBJECT, 'location' );
		if ( $existing ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'   => 'location',
				'post_title'  => $l['name'],
				'post_name'   => $l['slug'],
				'post_status' => 'publish',
				'menu_order'  => $i,
			)
		);
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_bp_company', $l['company'] );
		update_post_meta( $id, '_bp_area', $l['area'] );
		update_post_meta( $id, '_bp_type', $l['type'] );
		update_post_meta( $id, '_bp_maps_link', $l['maps'] );
		update_post_meta( $id, '_bp_phone', brickpoint_get( 'phone' ) );
		$thumb = brickpoint_import_image( 'brick-factory.jpg' );
		if ( $thumb ) {
			set_post_thumbnail( $id, $thumb );
		}
	}
}

/**
 * Import projects.
 */
function brickpoint_import_projects() {
	$cats = array( 'Residential', 'Commercial', 'Brickwork / Masonry' );
	$cat_ids = array();
	foreach ( $cats as $c ) {
		$term = term_exists( $c, 'project_category' );
		if ( ! $term ) {
			$term = wp_insert_term( $c, 'project_category' );
		}
		if ( ! is_wp_error( $term ) ) {
			$cat_ids[ $c ] = (int) $term['term_id'];
		}
	}
	$projects = array(
		array(
			'title' => 'Modern Residential Villa — DHA Lahore',
			'slug'  => 'modern-villa-dha-lahore',
			'cat'   => 'Residential',
			'loc'   => 'DHA Lahore',
			'desc'  => 'A modern residential villa featuring premium SS7 brickwork and quality construction materials. The clean brick facade showcases consistent quality and professional execution.',
			'mats'  => 'SS7 Bricks, Cement, Steel, Sand, Crush',
			'img'   => 'construction-project.jpg',
		),
		array(
			'title' => 'Commercial Development — Bahria Town Lahore',
			'slug'  => 'commercial-development-bahria-town',
			'cat'   => 'Commercial',
			'loc'   => 'Bahria Town Lahore',
			'desc'  => 'A multi-storey commercial building project utilizing quality construction materials including bricks, cement, and structural steel for a robust and durable structure.',
			'mats'  => 'Bricks, Cement, Steel Rebar, Construction Chemicals',
			'img'   => 'hero-bricks.jpg',
		),
		array(
			'title' => 'Residential Housing — Lake City Lahore',
			'slug'  => 'housing-project-lake-city',
			'cat'   => 'Residential',
			'loc'   => 'Lake City Lahore',
			'desc'  => "Premium residential construction featuring quality brickwork and modern construction materials in one of Lahore's premium residential communities.",
			'mats'  => 'SS7 Bricks, Cement, Plumbing Pipes, Paints',
			'img'   => 'brick-factory.jpg',
		),
		array(
			'title' => 'Expert Brickwork — Etihad Town Lahore',
			'slug'  => 'brickwork-etihad-town',
			'cat'   => 'Brickwork / Masonry',
			'loc'   => 'Etihad Town Lahore',
			'desc'  => 'Precision masonry and brickwork using SS7 branded bricks, demonstrating the consistent quality and clean finish achievable with properly sourced construction bricks.',
			'mats'  => 'SS7 Bricks, Cement, Sand',
			'img'   => 'bricks-stacked.jpg',
		),
		array(
			'title' => 'Villa Construction — Al-Kabir Town Lahore',
			'slug'  => 'villa-construction-al-kabir',
			'cat'   => 'Residential',
			'loc'   => 'Al-Kabir Town Lahore',
			'desc'  => 'Double-storey residential villa construction featuring quality brick masonry, structural steel, and comprehensive construction material supply.',
			'mats'  => 'Bricks, Steel, Cement, Crush',
			'img'   => 'construction-project.jpg',
		),
		array(
			'title' => 'Construction Project — Paragon City Lahore',
			'slug'  => 'construction-paragon-city',
			'cat'   => 'Residential',
			'loc'   => 'Paragon City Lahore',
			'desc'  => 'Residential construction project featuring quality masonry and modern construction material application for a premium community development.',
			'mats'  => 'Bricks, Cement, Sand, Steel',
			'img'   => 'about-team.jpg',
		),
	);
	foreach ( $projects as $i => $p ) {
		$existing = get_page_by_path( $p['slug'], OBJECT, 'project' );
		if ( $existing ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'project',
				'post_title'   => $p['title'],
				'post_name'    => $p['slug'],
				'post_status'  => 'publish',
				'post_excerpt' => $p['desc'],
				'post_content' => $p['desc'],
				'menu_order'   => $i,
			)
		);
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		if ( isset( $cat_ids[ $p['cat'] ] ) ) {
			wp_set_post_terms( $id, array( $cat_ids[ $p['cat'] ] ), 'project_category' );
		}
		update_post_meta( $id, '_bp_location', $p['loc'] );
		update_post_meta( $id, '_bp_materials', $p['mats'] );
		update_post_meta( $id, '_bp_illustrative', '1' );
		$thumb = brickpoint_import_image( $p['img'] );
		if ( $thumb ) {
			set_post_thumbnail( $id, $thumb );
		}
	}
}

/**
 * Import blog posts (original content verbatim).
 */
function brickpoint_import_posts() {
	$posts = array(
		array(
			'title'   => 'How to Choose Quality Bricks for Your Home Construction',
			'slug'    => 'how-to-choose-quality-bricks',
			'excerpt' => 'Choosing the right bricks is one of the most important decisions in home construction. Learn what to look for when selecting bricks for your project.',
			'cat'     => 'Bricks',
			'img'     => 'bricks-stacked.jpg',
			'sticky'  => true,
			'content' => '<p>When building a home, the quality of bricks you use will directly impact the strength, durability, and appearance of your walls. Here are the key factors to consider when choosing bricks for your construction project.</p><h2>1. Check Dimensional Consistency</h2><p>Good quality bricks should have consistent dimensions. Inconsistent brick sizes make it difficult for masons to build straight walls and can affect the structural integrity of your building.</p><h2>2. Look at Surface Quality</h2><p>The surface of quality bricks should be smooth and free from large cracks. Minor surface variations are acceptable, but deep cracks or crumbling edges indicate poor quality.</p><h2>3. Consider the Source</h2><p>Always buy bricks from a reputable supplier. Established suppliers like BrickPoint ensure that you receive genuine quality bricks from trusted manufacturers.</p><h2>4. SS7 Bricks — A Reliable Choice</h2><p>SS7 branded bricks from BrickPoint\'s Masha Allah Bricks Company and Fine Bricks Company are a reliable choice for residential and commercial construction. They are known for consistency and dependable supply.</p><h2>Conclusion</h2><p>Choosing the right bricks from the start will save you time, money, and headaches during construction. Contact BrickPoint on WhatsApp at 03152850818 to discuss your brick requirements.</p>',
		),
		array(
			'title'   => 'SS7 Bricks and Their Role in Construction',
			'slug'    => 'ss7-bricks-role-in-construction',
			'excerpt' => 'SS7 bricks have become a recognized name in the construction industry. Discover what makes them a preferred choice for builders and contractors.',
			'cat'     => 'Bricks',
			'img'     => 'ss7-brick.jpg',
			'sticky'  => false,
			'content' => '<p>In the construction industry, the SS7 brick brand has built a reputation for quality and consistency. BrickPoint, through Masha Allah Bricks Company and Fine Bricks Company, is proud to supply SS7 branded bricks to builders and contractors across the region.</p><h2>What Are SS7 Bricks?</h2><p>SS7 bricks are a branded variety of red clay bricks manufactured under quality-focused production processes. The SS7 mark signifies a commitment to consistency in dimensions, quality, and supply reliability.</p><h2>Why Choose SS7 Bricks?</h2><p>Builders and contractors choose SS7 bricks because of their consistent quality and reliable availability. When you order SS7 bricks from BrickPoint, you can trust that the supply will be consistent throughout your project.</p><h2>Applications</h2><p>SS7 bricks are suitable for a wide range of construction applications including residential homes, commercial buildings, boundary walls, and general masonry work.</p><h2>Order SS7 Bricks</h2><p>To order SS7 bricks or inquire about pricing and availability, contact BrickPoint on WhatsApp: 03152850818</p>',
		),
		array(
			'title'   => 'Essential Construction Materials for Building a House in Pakistan',
			'slug'    => 'essential-construction-materials-pakistan',
			'excerpt' => 'Planning to build a house? Here is a comprehensive overview of the essential construction materials you will need for a successful project.',
			'cat'     => 'Construction Materials',
			'img'     => 'construction-project.jpg',
			'sticky'  => false,
			'content' => '<p>Building a house requires careful planning and the right materials. Here is an overview of the essential construction materials needed for most residential construction projects in Pakistan.</p><h2>1. Bricks</h2><p>Bricks are the foundation of most walls in Pakistani homes. Quality bricks like SS7 bricks from BrickPoint provide the structural base for your entire building.</p><h2>2. Cement</h2><p>Cement is essential for binding bricks, preparing concrete, and plastering walls. OPC (Ordinary Portland Cement) is the most common choice for general construction.</p><h2>3. Sand (Rait)</h2><p>Sand is used in concrete mixes and plastering. Different grades of sand are used for different applications.</p><h2>4. Crush (Bajri)</h2><p>Crush or bajri is an essential component of concrete mixes, particularly for foundations, slabs, and structural elements.</p><h2>5. Steel Rebar</h2><p>Steel reinforcement bars are used in reinforced concrete for foundations, beams, columns, and slabs to add tensile strength.</p><h2>Contact BrickPoint</h2><p>BrickPoint supplies a comprehensive range of construction materials. Contact us on WhatsApp at 03152850818 for pricing and availability.</p>',
		),
		array(
			'title'   => 'Construction Material Buying Guide for Homeowners',
			'slug'    => 'construction-material-buying-guide',
			'excerpt' => 'A practical guide for homeowners on how to buy construction materials efficiently, avoid common mistakes, and get the best value.',
			'cat'     => 'Building Tips',
			'img'     => 'brick-factory.jpg',
			'sticky'  => false,
			'content' => '<p>Buying construction materials for the first time can be overwhelming. This guide will help you navigate the process more confidently.</p><h2>Plan Before You Buy</h2><p>Always have a detailed plan and quantity estimate before purchasing materials. Over-buying wastes money; under-buying causes project delays.</p><h2>Buy from Reputable Suppliers</h2><p>Always source your materials from established, reputable suppliers. BrickPoint has been serving builders and contractors through Masha Allah Bricks Company and Fine Bricks Company.</p><h2>Compare Prices</h2><p>Get price quotes from multiple suppliers before finalizing your purchase. BrickPoint offers competitive pricing — contact us on WhatsApp for the latest rates.</p><h2>Plan Your Deliveries</h2><p>Coordinate material deliveries with your construction schedule to minimize storage issues and material damage.</p><h2>Get in Touch</h2><p>For construction material inquiries and pricing, contact BrickPoint on WhatsApp: 03152850818</p>',
		),
		array(
			'title'   => 'Understanding Bricks, Cement, Sand, and Crush in Construction',
			'slug'    => 'understanding-bricks-cement-sand-crush',
			'excerpt' => 'Learn about the four fundamental construction materials — bricks, cement, sand, and crush — and how they work together in building construction.',
			'cat'     => 'Construction Planning',
			'img'     => 'bricks-stacked.jpg',
			'sticky'  => false,
			'content' => '<p>Every construction project relies on a combination of essential materials. Understanding how bricks, cement, sand, and crush work together will help you make better decisions for your project.</p><h2>Bricks</h2><p>Bricks form the walls of your building. Quality bricks provide structural strength and a clean finish. SS7 bricks from BrickPoint are a trusted choice for many construction projects.</p><h2>Cement</h2><p>Cement acts as the binding agent. It holds bricks together in mortar and binds aggregates in concrete. The quality and grade of cement significantly impacts structural performance.</p><h2>Sand (Rait)</h2><p>Sand is mixed with cement to create mortar for bricklaying and plaster for wall finishing. Different applications require different sand grades.</p><h2>Crush / Bajri</h2><p>Crush is mixed with cement and sand to create concrete for foundations, slabs, columns, and beams. The correct ratio of these materials is essential for structural integrity.</p><h2>Get All Your Materials from One Source</h2><p>BrickPoint can help you source all these essential construction materials. Contact us on WhatsApp at 03152850818 for pricing and delivery information.</p>',
		),
	);
	foreach ( $posts as $p ) {
		$existing = get_page_by_path( $p['slug'], OBJECT, 'post' );
		if ( $existing ) {
			continue;
		}
		$cat_id = 0;
		$term = term_exists( $p['cat'], 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $p['cat'], 'category' );
		}
		if ( ! is_wp_error( $term ) ) {
			$cat_id = (int) $term['term_id'];
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'post',
				'post_title'   => $p['title'],
				'post_name'    => $p['slug'],
				'post_status'  => 'publish',
				'post_excerpt' => $p['excerpt'],
				'post_content' => $p['content'],
				'post_category' => $cat_id ? array( $cat_id ) : array(),
			)
		);
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		if ( $p['sticky'] ) {
			stick_post( $id );
		}
		$thumb = brickpoint_import_image( $p['img'] );
		if ( $thumb ) {
			set_post_thumbnail( $id, $thumb );
		}
	}
}

/**
 * Import WooCommerce categories + starter products.
 */
function brickpoint_import_woo() {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return;
	}
	// Categories.
	foreach ( brickpoint_category_meta() as $i => $cat ) {
		$term = get_term_by( 'slug', $cat['slug'], 'product_cat' );
		if ( ! $term ) {
			$res = wp_insert_term(
				$cat['name'],
				'product_cat',
				array( 'slug' => $cat['slug'], 'description' => $cat['desc'] )
			);
			if ( is_wp_error( $res ) ) {
				continue;
			}
			$term_id = (int) $res['term_id'];
			$thumb = brickpoint_import_image( $cat['image'] );
			if ( $thumb ) {
				update_term_meta( $term_id, 'thumbnail_id', $thumb );
			}
		}
		update_option( 'brickpoint_woo_imported_cats', 1 );
	}

	// Starter products (from original catalog).
	$products = array(
		array(
			'name' => 'SS7 Bricks — Standard', 'slug' => 'ss7-bricks-standard', 'cat' => 'bricks',
			'short' => 'Premium SS7 branded standard bricks for residential and commercial construction.',
			'desc'  => "SS7 Bricks are a trusted choice for construction projects where quality, consistency, and dependable supply matter. Manufactured under strict quality control, these bricks offer excellent dimensional consistency and reliable performance for walls, foundations, and structural applications.\n\nBrickPoint is the authorized supplier of SS7 branded bricks through Masha Allah Bricks Company and Fine Bricks Company, ensuring you receive genuine SS7 bricks with every order.",
			'code' => 'SS7-STD', 'unit' => 'Per 1,000 Bricks', 'ss7' => true, 'featured' => true,
			'imgs' => array( 'ss7-brick.jpg', 'bricks-stacked.jpg' ),
			'features' => array( 'SS7 Branded Quality', 'Consistent Dimensions', 'Reliable Supply', 'Suitable for Load-Bearing Walls', 'Available in Bulk Orders' ),
		),
		array(
			'name' => 'Standard Construction Bricks', 'slug' => 'standard-construction-bricks', 'cat' => 'bricks',
			'short' => 'Quality standard bricks for general construction use.',
			'desc'  => 'High quality standard construction bricks suitable for residential and commercial buildings. Consistent in size and strength, these bricks are ideal for walls, partitions, and general construction work.',
			'code' => 'BRICK-STD', 'unit' => 'Per 1,000 Bricks', 'ss7' => false, 'featured' => false,
			'imgs' => array( 'bricks-stacked.jpg' ),
			'features' => array( 'Consistent Quality', 'Bulk Availability', 'Suitable for All Construction Types' ),
		),
		array(
			'name' => 'Ordinary Portland Cement (OPC)', 'slug' => 'ordinary-portland-cement', 'cat' => 'cement',
			'short' => 'Premium Ordinary Portland Cement for all construction applications.',
			'desc'  => 'High-quality Ordinary Portland Cement suitable for general construction, concrete work, plastering, and masonry. Available in standard 50kg bags from leading brands.',
			'code' => 'CEM-OPC', 'unit' => 'Per Bag (50kg)', 'ss7' => false, 'featured' => false,
			'imgs' => array( 'cement-bags.jpg' ),
			'features' => array( 'Standard 50kg Bags', 'For General Construction', 'Plastering & Concrete', 'Reliable Brands Available' ),
		),
		array(
			'name' => 'Deformed Steel Bars (Rebar)', 'slug' => 'deformed-steel-bars', 'cat' => 'steel',
			'short' => 'Structural deformed steel bars for reinforced concrete construction.',
			'desc'  => 'High-quality deformed steel reinforcement bars (rebar) available in various sizes for structural concrete applications. Suitable for foundations, beams, columns, and slabs.',
			'code' => 'STEEL-REBAR', 'unit' => 'Per Ton', 'ss7' => false, 'featured' => false,
			'imgs' => array( 'steel-rods.jpg' ),
			'features' => array( 'Available in Multiple Sizes', 'High Tensile Strength', 'For Structural Use', 'Bulk Orders Available' ),
		),
		array(
			'name' => 'Construction Crush (Bajri)', 'slug' => 'construction-crush', 'cat' => 'crush',
			'short' => 'Quality crush/bajri for concrete mixing and foundation work.',
			'desc'  => 'Construction grade crush (bajri) suitable for concrete mixing, foundation filling, and road base applications. Available in various grades.',
			'code' => 'CRUSH-01', 'unit' => 'Per Cubic Foot', 'ss7' => false, 'featured' => false,
			'imgs' => array( 'hero-bricks.jpg' ),
			'features' => array( 'Multiple Grades Available', 'For Concrete Mixing', 'Foundation Use', 'Bulk Delivery' ),
		),
		array(
			'name' => 'Construction Sand (Rait)', 'slug' => 'construction-sand', 'cat' => 'sand',
			'short' => 'Fine construction sand for plastering and concrete work.',
			'desc'  => 'Quality construction sand (rait) for plastering, concrete mixing, and masonry work. Available in fine and coarse grades.',
			'code' => 'SAND-01', 'unit' => 'Per Cubic Foot', 'ss7' => false, 'featured' => false,
			'imgs' => array( 'hero-bricks.jpg' ),
			'features' => array( 'Fine & Coarse Grades', 'For Plastering & Concrete', 'Bulk Delivery' ),
		),
	);

	foreach ( $products as $p ) {
		$existing = get_page_by_path( $p['slug'], OBJECT, 'product' );
		if ( $existing ) {
			continue;
		}
		$product = new WC_Product_Simple();
		$product->set_name( $p['name'] );
		$product->set_slug( $p['slug'] );
		$product->set_status( 'publish' );
		$product->set_short_description( $p['short'] );
		$product->set_description( $p['desc'] );
		$product->set_sku( $p['code'] );
		$product->set_featured( $p['featured'] );
		$product->set_manage_stock( false );
		$product->set_stock_status( 'instock' );
		$term = get_term_by( 'slug', $p['cat'], 'product_cat' );
		if ( $term ) {
			$product->set_category_ids( array( (int) $term->term_id ) );
		}
		$id = $product->save();
		if ( ! $id ) {
			continue;
		}
		update_post_meta( $id, '_bp_price_on_request', 'yes' );
		update_post_meta( $id, '_bp_price_unit', $p['unit'] );
		if ( $p['ss7'] ) {
			update_post_meta( $id, '_bp_is_ss7', 'yes' );
		}
		// Key features → displayed via short description appendix + product attributes area.
		if ( $p['features'] ) {
			update_post_meta( $id, '_bp_features', $p['features'] );
		}
		$gallery = array();
		foreach ( $p['imgs'] as $i => $img ) {
			$att = brickpoint_import_image( $img );
			if ( ! $att ) {
				continue;
			}
			if ( 0 === $i ) {
				set_post_thumbnail( $id, $att );
			} else {
				$gallery[] = $att;
			}
		}
		if ( $gallery ) {
			update_post_meta( $id, '_product_image_gallery', implode( ',', $gallery ) );
		}
	}
}
