<?php
/**
 * GBL Peptide Theme — functions.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GBL_VERSION', '1.0.0' );
define( 'GBL_URI', get_template_directory_uri() );
define( 'GBL_DIR', get_template_directory() );

/* ──────────────────────────────────────────────────────
   THEME SETUP
────────────────────────────────────────────────────── */
function gbl_theme_setup() {
	load_theme_textdomain( 'gbl-peptide', GBL_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ] );
	add_theme_support( 'custom-logo', [
		'width'       => 180,
		'height'      => 60,
		'flex-width'  => true,
		'flex-height' => true,
	] );

	// WooCommerce
	add_theme_support( 'woocommerce', [
		'thumbnail_image_width' => 600,
		'gallery_thumbnail_image_width' => 100,
	] );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Nav menus
	register_nav_menus( [
		'primary'   => __( 'Primary Navigation', 'gbl-peptide' ),
		'footer_1'  => __( 'Footer — Products', 'gbl-peptide' ),
		'footer_2'  => __( 'Footer — Company', 'gbl-peptide' ),
		'footer_3'  => __( 'Footer — Legal', 'gbl-peptide' ),
	] );
}
add_action( 'after_setup_theme', 'gbl_theme_setup' );

/* ──────────────────────────────────────────────────────
   ENQUEUE STYLES & SCRIPTS
────────────────────────────────────────────────────── */
function gbl_enqueue_assets() {
	// Google Fonts
	wp_enqueue_style(
		'gbl-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap',
		[],
		null
	);

	// Main stylesheet
	wp_enqueue_style( 'gbl-style', get_stylesheet_uri(), [ 'gbl-fonts' ], GBL_VERSION );

	// WooCommerce extra styles
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'gbl-woo', GBL_URI . '/assets/css/woocommerce.css', [ 'gbl-style' ], GBL_VERSION );
	}

	// Main JS
	wp_enqueue_script( 'gbl-main', GBL_URI . '/assets/js/main.js', [], GBL_VERSION, true );

	// Calculator page
	if ( is_page_template( 'page-calculator.php' ) || is_page( 'calculator' ) ) {
		wp_enqueue_script( 'gbl-calculator', GBL_URI . '/assets/js/calculator.js', [ 'gbl-main' ], GBL_VERSION, true );
	}

	// Inline variables for JS
	wp_localize_script( 'gbl-main', 'GBL', [
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'gbl_nonce' ),
		'shop_url' => get_permalink( wc_get_page_id( 'shop' ) ),
		'cart_url' => class_exists( 'WooCommerce' ) ? wc_get_cart_url() : '#',
	] );
}
add_action( 'wp_enqueue_scripts', 'gbl_enqueue_assets' );

/* ──────────────────────────────────────────────────────
   WOOCOMMERCE CONFIG
────────────────────────────────────────────────────── */
// Remove default WC wrapper divs — we use our own layout
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_main_content', 'gbl_woo_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content',  'gbl_woo_wrapper_end', 10 );

function gbl_woo_wrapper_start() { echo '<div class="gbl-woo-content">'; }
function gbl_woo_wrapper_end()   { echo '</div>'; }

// Show 12 products per page
add_filter( 'loop_shop_per_page', fn() => 12, 20 );

// Show 4 columns in the loop
add_filter( 'loop_shop_columns', fn() => 4 );

// Remove default WC product loop hooks we override in templates
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title',  'woocommerce_template_loop_rating', 5 );

/* ──────────────────────────────────────────────────────
   PEPTIDE CUSTOM FIELDS (ACF fallback — plain meta)
────────────────────────────────────────────────────── */
/**
 * Registers peptide meta fields that can be set on WooCommerce products.
 * If you have ACF Pro installed these can be managed in a field group;
 * otherwise they are set via the WooCommerce product custom fields panel.
 *
 * Meta keys:
 *   _gbl_mechanism  — Mechanism of action
 *   _gbl_half_life  — Half-life
 *   _gbl_dose_range — Research dose range
 *   _gbl_frequency  — Dosing frequency
 *   _gbl_routes     — Routes (comma-separated)
 *   _gbl_side_fx    — Side effects
 *   _gbl_contraind  — Contraindications
 *   _gbl_pairs      — Commonly paired peptides (comma-sep)
 *   _gbl_nickname   — Peptide nickname / tagline
 *   _gbl_category   — Peptide category (for display)
 *   _gbl_color      — Brand dot colour (hex)
 *   _gbl_use        — Research use summary
 */
function gbl_register_product_meta() {
	$fields = [
		'_gbl_mechanism', '_gbl_half_life', '_gbl_dose_range',
		'_gbl_frequency', '_gbl_routes',    '_gbl_side_fx',
		'_gbl_contraind', '_gbl_pairs',     '_gbl_nickname',
		'_gbl_category',  '_gbl_color',     '_gbl_use',
	];
	foreach ( $fields as $key ) {
		register_post_meta( 'product', $key, [
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => fn() => current_user_can( 'edit_posts' ),
		] );
	}
}
add_action( 'init', 'gbl_register_product_meta' );

/* ──────────────────────────────────────────────────────
   PRODUCT ADMIN META BOX
────────────────────────────────────────────────────── */
function gbl_add_peptide_meta_box() {
	add_meta_box(
		'gbl_peptide_data',
		__( 'Peptide Research Data', 'gbl-peptide' ),
		'gbl_render_peptide_meta_box',
		'product',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'gbl_add_peptide_meta_box' );

function gbl_render_peptide_meta_box( $post ) {
	wp_nonce_field( 'gbl_save_peptide_meta', 'gbl_peptide_nonce' );
	$fields = [
		'_gbl_nickname'   => 'Nickname / Tagline',
		'_gbl_category'   => 'Peptide Category',
		'_gbl_color'      => 'Brand Dot Colour (hex)',
		'_gbl_half_life'  => 'Half-Life',
		'_gbl_dose_range' => 'Research Dose Range',
		'_gbl_frequency'  => 'Dosing Frequency',
		'_gbl_routes'     => 'Routes (comma-separated)',
		'_gbl_mechanism'  => 'Mechanism of Action',
		'_gbl_use'        => 'Research Use Summary',
		'_gbl_side_fx'    => 'Side Effects',
		'_gbl_contraind'  => 'Contraindications',
		'_gbl_pairs'      => 'Commonly Paired Peptides (comma-separated)',
	];
	echo '<table class="form-table" style="font-family:sans-serif;">';
	foreach ( $fields as $key => $label ) {
		$val = esc_attr( get_post_meta( $post->ID, $key, true ) );
		$long = in_array( $key, [ '_gbl_mechanism', '_gbl_use', '_gbl_side_fx', '_gbl_contraind' ] );
		echo '<tr><th style="width:200px"><label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td>';
		if ( $long ) {
			echo '<textarea id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" rows="3" style="width:100%">' . esc_textarea( get_post_meta( $post->ID, $key, true ) ) . '</textarea>';
		} else {
			echo '<input type="text" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . $val . '" style="width:100%">';
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

function gbl_save_peptide_meta( $post_id ) {
	if ( ! isset( $_POST['gbl_peptide_nonce'] ) || ! wp_verify_nonce( $_POST['gbl_peptide_nonce'], 'gbl_save_peptide_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$fields = [ '_gbl_nickname', '_gbl_category', '_gbl_color', '_gbl_half_life',
	            '_gbl_dose_range', '_gbl_frequency', '_gbl_routes', '_gbl_mechanism',
	            '_gbl_use', '_gbl_side_fx', '_gbl_contraind', '_gbl_pairs' ];

	foreach ( $fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_textarea_field( $_POST[ $key ] ) );
		}
	}
}
add_action( 'save_post', 'gbl_save_peptide_meta' );

/* ──────────────────────────────────────────────────────
   WIDGET AREAS
────────────────────────────────────────────────────── */
function gbl_register_widgets() {
	register_sidebar( [
		'name'          => __( 'Shop Sidebar', 'gbl-peptide' ),
		'id'            => 'shop-sidebar',
		'description'   => __( 'Filters and info shown on the shop and archive pages.', 'gbl-peptide' ),
		'before_widget' => '<div class="sidebar-section">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="sidebar-title">',
		'after_title'   => '</h3>',
	] );
}
add_action( 'widgets_init', 'gbl_register_widgets' );

/* ──────────────────────────────────────────────────────
   NEWSLETTER AJAX
────────────────────────────────────────────────────── */
function gbl_newsletter_signup() {
	check_ajax_referer( 'gbl_nonce', 'nonce' );
	$email = sanitize_email( $_POST['email'] ?? '' );
	if ( ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => __( 'Please enter a valid email address.', 'gbl-peptide' ) ] );
	}
	// Hook your newsletter provider here (Mailchimp, etc.)
	do_action( 'gbl_newsletter_subscribe', $email );
	wp_send_json_success( [ 'message' => __( 'Thank you for subscribing!', 'gbl-peptide' ) ] );
}
add_action( 'wp_ajax_gbl_newsletter',        'gbl_newsletter_signup' );
add_action( 'wp_ajax_nopriv_gbl_newsletter', 'gbl_newsletter_signup' );

/* ──────────────────────────────────────────────────────
   HELPER: get peptide meta safely
────────────────────────────────────────────────────── */
function gbl_meta( $post_id, $key, $default = '' ) {
	$val = get_post_meta( $post_id, "_gbl_{$key}", true );
	return $val !== '' ? $val : $default;
}

/* ──────────────────────────────────────────────────────
   BREADCRUMB (lightweight, no plugin dependency)
────────────────────────────────────────────────────── */
function gbl_breadcrumb() {
	if ( is_front_page() ) return;

	$crumbs = [ '<a href="' . esc_url( home_url() ) . '">' . __( 'Home', 'gbl-peptide' ) . '</a>' ];

	if ( is_shop() ) {
		$crumbs[] = __( 'Shop', 'gbl-peptide' );
	} elseif ( is_product_category() ) {
		$crumbs[] = '<a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . __( 'Shop', 'gbl-peptide' ) . '</a>';
		$crumbs[] = single_term_title( '', false );
	} elseif ( is_singular( 'product' ) ) {
		$crumbs[] = '<a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . __( 'Shop', 'gbl-peptide' ) . '</a>';
		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		if ( $terms ) {
			$crumbs[] = '<a href="' . esc_url( get_term_link( $terms[0] ) ) . '">' . esc_html( $terms[0]->name ) . '</a>';
		}
		$crumbs[] = get_the_title();
	} elseif ( is_page() ) {
		$crumbs[] = get_the_title();
	}

	echo '<nav class="product-breadcrumb" aria-label="Breadcrumb">' . implode( ' <span aria-hidden="true">›</span> ', $crumbs ) . '</nav>';
}

/* ──────────────────────────────────────────────────────
   DOCUMENT TITLE SEPARATOR
────────────────────────────────────────────────────── */
add_filter( 'document_title_separator', fn() => '—' );

/* ──────────────────────────────────────────────────────
   DISABLE EMOJIS (performance)
────────────────────────────────────────────────────── */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/* ──────────────────────────────────────────────────────
   IMAGE SIZES
────────────────────────────────────────────────────── */
add_image_size( 'gbl-product-card', 600, 450, true );
add_image_size( 'gbl-hero',        1600, 900, true );
