<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ── RESEARCH DISCLAIMER BAR ── -->
<div class="research-banner" role="note">
	<div class="container">
		<div class="research-banner-inner">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
			</svg>
			<span>All peptides are for <strong>research and laboratory use only</strong> — not for human consumption. Australian customers only.</span>
		</div>
	</div>
</div>

<!-- ── SITE HEADER ── -->
<header class="site-header" role="banner">
	<div class="container">
		<div class="header-inner">

			<!-- Logo -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" rel="home" aria-label="<?php bloginfo( 'name' ); ?> — Home">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<div class="site-logo-mark" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path d="M10 2C5.58 2 2 5.58 2 10s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 3a2 2 0 110 4 2 2 0 010-4zm0 10.5a6 6 0 01-5-2.69C5.02 11.76 8.27 11 10 11s4.98.76 5 1.81a6 6 0 01-5 2.69z"/>
						</svg>
					</div>
					<div class="site-logo-text">
						<span class="name">Global Bioanalytical</span>
						<span class="sub">Research Peptides — Australia</span>
					</div>
				<?php endif; ?>
			</a>

			<!-- Desktop Primary Nav -->
			<nav class="primary-nav" role="navigation" aria-label="Primary">
				<?php
				wp_nav_menu( [
					'theme_location' => 'primary',
					'menu_class'     => 'primary-nav-list',
					'container'      => false,
					'fallback_cb'    => 'gbl_fallback_nav',
				] );
				?>
			</nav>

			<!-- Header Actions -->
			<div class="header-actions">
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-cart-btn" aria-label="Shopping cart">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
							<path d="M1 1h4l2.68 13.39a2 2 0 001.99 1.61h9.66a2 2 0 001.98-1.72L23 6H6"/>
						</svg>
						<?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
						<?php if ( $count > 0 ) : ?>
							<span class="cart-count" aria-label="<?php echo esc_attr( $count ); ?> items in cart"><?php echo $count; ?></span>
						<?php endif; ?>
					</a>
				<?php endif; ?>

				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary btn-sm" style="display:none;" id="header-shop-btn">
					Shop
				</a>

				<!-- Mobile toggle -->
				<button class="menu-toggle" id="menu-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="Toggle menu">
					<span></span><span></span><span></span>
				</button>
			</div>

		</div>
	</div>
</header>

<!-- ── MOBILE NAV DRAWER ── -->
<nav class="mobile-nav" id="mobile-nav" aria-label="Mobile navigation" aria-hidden="true">
	<?php
	wp_nav_menu( [
		'theme_location' => 'primary',
		'container'      => false,
		'fallback_cb'    => 'gbl_fallback_nav',
	] );
	?>
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn btn-outline">
			Cart
			<?php if ( $count > 0 ) : ?>
				(<?php echo $count; ?>)
			<?php endif; ?>
		</a>
	<?php endif; ?>
</nav>

<?php
/**
 * Fallback nav — shown when no menu is assigned to the 'primary' location.
 */
function gbl_fallback_nav() {
	$shop = class_exists( 'WooCommerce' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '#';
	echo '<ul>';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'gbl-peptide' ) . '</a></li>';
	echo '<li><a href="' . esc_url( $shop ) . '">' . __( 'Shop', 'gbl-peptide' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/calculator/' ) ) . '">' . __( 'Calculator', 'gbl-peptide' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">' . __( 'About', 'gbl-peptide' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . __( 'Contact', 'gbl-peptide' ) . '</a></li>';
	echo '</ul>';
}
?>
