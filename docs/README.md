# BrickPoint WordPress Theme — Setup & Documentation

**BrickPoint** — SS7 Bricks & Construction Materials. A production-ready WordPress theme
faithfully converted from the BrickPoint Next.js website. Same design, same content,
same responsive behavior — now native WordPress + Elementor + WooCommerce.

## 1. Location of the Theme

```
Brickpointz/
├── brickpoint/                  ← installable WordPress theme (this folder → brickpoint.zip)
│   ├── style.css / functions.php / index.php / front-page.php / page.php
│   ├── single.php / archive.php / 404.php / search.php / comments.php
│   ├── header.php / footer.php / screenshot.png / readme.txt
│   ├── page-about.php / page-ss7-bricks.php / page-products.php
│   ├── page-projects.php / page-locations.php / page-contact.php
│   ├── assets/{css,js,images,icons,fonts,videos}
│   ├── inc/{theme-setup,enqueue,customizer,cpt,elementor,woocommerce,contact,demo-import,helpers}.php
│   ├── inc/elementor/widgets/   ← 6 custom Elementor widgets
│   ├── template-parts/{header,footer,content,sections}
│   └── woocommerce/             ← shop, category + single product overrides
├── docs/README.md               ← this file
└── brickpoint-construction-company-website.zip  ← original Next.js source (reference, preserved)
```

## 2. Requirements

| Requirement | Version |
|---|---|
| WordPress | 6.0+ (tested to 6.8) |
| PHP | 7.4+ |
| Elementor (free) | latest — **required for visual editing** |
| WooCommerce | latest — **required for shop/products** |
| Elementor Pro | optional — only for Theme Builder header/footer/single/archive assignment |

## 3. Installation

1. Zip the theme: `cd Brickpointz && zip -r brickpoint.zip brickpoint -x 'brickpoint/.git*'`
   (or download `brickpoint.zip` from the release).
2. WordPress Admin → **Appearance → Themes → Add New → Upload Theme** → select `brickpoint.zip` → Install → Activate.
3. Install & activate **Elementor** and **WooCommerce** (Plugins → Add New).
4. Go to **Appearance → BrickPoint Setup** → **Import BrickPoint Demo Content**.
   This creates: Home, About, Products, SS7 Bricks, Projects, Locations, Blog, Contact pages;
   Primary + Footer menus; 4 Locations; 6 Projects; 5 Blog posts; 14 WooCommerce categories;
   6 starter products; homepage/blog assignments.
5. **Settings → Permalinks** → Post name → Save (flushes rewrites for products/locations/projects).

## 4. What Was Converted (page → WordPress)

| Original route | WordPress equivalent |
|---|---|
| `/` | Front page (`front-page.php` + sections) |
| `/about` | Page + `page-about.php` |
| `/products` | Page + `page-products.php` (+ WooCommerce `/shop`) |
| `/products/{category}` | WooCommerce product-category archive (`taxonomy-product_cat.php`); legacy URLs 301-redirect |
| `/products/{category}/{slug}` | WooCommerce single product; legacy URLs 301-redirect |
| `/ss7-bricks` | Page + `page-ss7-bricks.php` (hero, details, gallery, applications, FAQ, CTA) |
| `/projects` | Page + `page-projects.php` + `project` CPT |
| `/locations` | Page + `page-locations.php` + `location` CPT |
| `/blog`, `/blog/{slug}` | Posts + archive (`index.php`/`archive.php`) + `single.php` |
| `/contact` | Page + `page-contact.php` (AJAX form → Messages + admin email; CF7-compatible) |
| Header/footer/WhatsApp float | `header.php`/`footer.php` + template parts, Elementor-overridable |

Content migrated verbatim: all headings, paragraphs, CTA wording, FAQs, 5 blog articles,
6 projects, 4 locations (with Google Maps links), product details, team (CEO Syed Iftikhar Haider,
Sales Manager Qasim Iqbal), phone `03152850818`, WhatsApp `923152850818`, all social links.

## 5. Elementor Editing

- Open any page → **Edit with Elementor**. All page templates detect Elementor-built content
  and render it instead of the fallback — nothing is locked in PHP.
- **Custom widgets** (BrickPoint category): WhatsApp Button, Section Heading, Locations,
  Categories, CTA Banner, Feature Cards — all with editable text, links, images, colors,
  typography, alignment, responsive controls.
- **Theme Builder** (requires Elementor Pro): create Header / Footer / Single Post /
  Archive / Single Product / Product Archive / 404 templates; the theme yields to them
  automatically via `elementor_theme_do_location()`. Without Pro, the faithful PHP
  fallbacks render — no paid plugin required for basic operation.
- Global kit defaults (navy/red/gold colors, Inter typography, 1280px container) are seeded
  from the original design on activation.

## 6. WooCommerce

- 14 product categories recreated with descriptions + images.
- Starter products use **Price on Request** (WhatsApp-first ordering, as original) with
  per-product **Price Unit** and **SS7 Brand** flags (editable in product → Pricing).
- WhatsApp order popup (quantity / delivery location / message) on single products;
  SS7/Featured badges; related products; cart/checkout/my-account use WooCommerce core
  styled to the brand.
- Product search, filtering (widgets/shortcodes), and Elementor Woo widgets all work.

## 7. Centralized Settings (no hardcoding)

**Customizer → BrickPoint Settings**: phone, WhatsApp number, email, CEO, sales manager,
company names, address, hours, all social URLs, WhatsApp channel, hero video URL.
Changing the WhatsApp number updates header, footer, float button, order popups, and all CTAs.

## 8. Menus, Homepage, Header/Footer

- Import creates **Primary Menu** (with Products dropdown of all 14 categories),
  **Footer Quick Links**; assign under Appearance → Menus.
- Homepage + Blog page assigned automatically by the importer.
- Custom Logo supported (Appearance → Customize → Site Identity); otherwise the
  original SVG brick logo renders.

## 9. Limitations / Notes

- The original repository's `/images/*.jpg` files were referenced but **not included**
  in the source archive, so equivalent royalty-free-style images were generated for the
  theme bundle (same subjects/framing: hero bricks, SS7 brick, stacks, factory, cement,
  steel, project, team) and imported into the Media Library on demo import. Replace any
  via Media Library/Elementor as needed.
- The original hero video file was also absent (poster-only fallback); add an MP4 URL in
  Customizer → BrickPoint Settings → Homepage Hero Video URL.
- Elementor Pro is needed only for Theme Builder template assignment; everything else
  works with free Elementor + WooCommerce.
- Contact form stores messages under Pages → Messages and emails the admin; swap with
  Contact Form 7 shortcode anytime via Elementor.

## 10. Verification

- `php -l` passes on all PHP files.
- Install checklist (§3) + smoke test: activate → import → visit Home, About, Products,
  a category, a product, SS7 Bricks, Projects, Locations, Blog, a post, Contact, Cart,
  Checkout, 404, search; open a page in Elementor; test mobile menu, WhatsApp popup,
  contact form, and responsive breakpoints (desktop/tablet/mobile).
