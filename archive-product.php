<?php
/**
 * GBL Peptide — WooCommerce Shop / Archive Page
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<!-- Page header -->
<div class="page-header">
	<div class="container">
		<span class="label-overline">Research Catalogue</span>
		<h1 class="page-title">
			<?php if ( is_product_category() ) {
				single_term_title();
			} elseif ( is_search() ) {
				echo 'Search: ' . get_search_query();
			} else {
				echo 'All Research Compounds';
			} ?>
		</h1>
		<?php if ( is_product_category() ) {
			$desc = term_description();
			if ( $desc ) echo '<p class="page-desc">' . wp_kses_post( $desc ) . '</p>';
		} else { ?>
			<p class="page-desc">40+ research-grade peptides and bioanalyticals — lab tested, Australian stock.</p>
		<?php } ?>
	</div>
</div>

<div class="container section-pad">
	<div class="shop-layout">

		<!-- ── SIDEBAR ── -->
		<aside class="shop-sidebar" aria-label="Shop filters">
			<div class="sidebar-section">
				<h2 class="sidebar-title">Categories</h2>
				<?php
				$cats = get_terms( [
					'taxonomy'   => 'product_cat',
					'hide_empty' => true,
					'exclude'    => [ get_option( 'default_product_cat' ) ],
					'orderby'    => 'name',
				] );
				if ( $cats && ! is_wp_error( $cats ) ) : ?>
					<ul class="sidebar-filter-list">
						<li class="<?php echo ( ! is_product_category() ) ? 'active' : ''; ?>">
							<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" style="color:inherit;text-decoration:none;display:contents;">All Compounds</a>
							<span class="sidebar-count"><?php echo wp_count_posts( 'product' )->publish; ?></span>
						</li>
						<?php foreach ( $cats as $cat ) : ?>
							<li class="<?php echo ( is_product_category( $cat->slug ) ) ? 'active' : ''; ?>">
								<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" style="color:inherit;text-decoration:none;display:contents;">
									<?php echo esc_html( $cat->name ); ?>
								</a>
								<span class="sidebar-count"><?php echo $cat->count; ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="sidebar-section">
				<h2 class="sidebar-title">Quick Links</h2>
				<ul class="sidebar-filter-list">
					<li><a href="<?php echo esc_url( home_url( '/calculator/' ) ); ?>" style="color:inherit;text-decoration:none;display:contents;">Peptide Calculator</a></li>
					<li><a href="<?php echo esc_url( home_url( '/stacks/' ) ); ?>" style="color:inherit;text-decoration:none;display:contents;">Stack Protocols</a></li>
					<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>" style="color:inherit;text-decoration:none;display:contents;">Research FAQ</a></li>
				</ul>
			</div>

			<div class="sidebar-section" style="background:var(--gbl-blue-dim);border-radius:var(--radius-md);padding:18px;">
				<div style="font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gbl-blue);margin-bottom:8px;">Research Note</div>
				<p style="font-size:12px;color:var(--gbl-dark);line-height:1.65;margin:0;font-weight:600;">
					All compounds are for research and laboratory use only. Not for human or animal consumption.
				</p>
			</div>
		</aside>

		<!-- ── MAIN CONTENT ── -->
		<main class="shop-main" role="main">

			<?php if ( woocommerce_product_loop() ) : ?>

				<!-- Toolbar -->
				<div class="shop-toolbar">
					<div class="shop-results-count">
						<?php woocommerce_result_count(); ?>
					</div>
					<div class="shop-sort">
						<?php woocommerce_catalog_ordering(); ?>
					</div>
				</div>

				<!-- Product grid -->
				<div class="grid-3" id="product-grid">
					<?php while ( have_posts() ) : the_post();
						global $product;
						if ( ! $product ) $product = wc_get_product( get_the_ID() );
						$id       = $product->get_id();
						$nickname = gbl_meta( $id, 'nickname' );
						$category = gbl_meta( $id, 'category' );
						$color    = gbl_meta( $id, 'color', '#2563eb' );
						$dose     = gbl_meta( $id, 'dose_range' );
						$half     = gbl_meta( $id, 'half_life' );
						$terms    = get_the_terms( $id, 'product_cat' );
						$cat_name = $category ?: ( $terms ? $terms[0]->name : '' );
					?>
						<article class="product-card" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
							<div class="product-card-image">
								<?php if ( $product->get_image_id() ) : ?>
									<a href="<?php echo esc_url( get_permalink( $id ) ); ?>" tabindex="-1" aria-hidden="true">
										<?php echo $product->get_image( 'gbl-product-card', [ 'alt' => $product->get_name() ] ); ?>
									</a>
								<?php else : ?>
									<div class="product-card-placeholder">
										<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
											<path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
										</svg>
									</div>
								<?php endif; ?>
								<?php if ( $product->is_on_sale() ) : ?>
									<div class="product-badge"><span class="badge badge-blue">Sale</span></div>
								<?php endif; ?>
								<?php if ( $color ) : ?>
									<div class="product-color-dot" style="background:<?php echo esc_attr( $color ); ?>"></div>
								<?php endif; ?>
							</div>
							<div class="product-card-body">
								<?php if ( $cat_name ) : ?>
									<div class="product-cat"><?php echo esc_html( $cat_name ); ?></div>
								<?php endif; ?>
								<h2 class="product-name">
									<a href="<?php echo esc_url( get_permalink( $id ) ); ?>" style="color:inherit;text-decoration:none;">
										<?php echo esc_html( $product->get_name() ); ?>
									</a>
								</h2>
								<?php if ( $nickname ) : ?>
									<div class="product-nick"><?php echo esc_html( $nickname ); ?></div>
								<?php endif; ?>
								<?php if ( $dose || $half ) : ?>
									<div class="product-meta">
										<?php if ( $dose ) : ?><span class="product-meta-tag"><?php echo esc_html( $dose ); ?></span><?php endif; ?>
										<?php if ( $half ) : ?><span class="product-meta-tag">t½ <?php echo esc_html( $half ); ?></span><?php endif; ?>
									</div>
								<?php endif; ?>
								<div class="product-price-row">
									<div><?php echo $product->get_price_html(); ?></div>
									<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
									   data-product_id="<?php echo $id; ?>"
									   class="add-to-cart-btn ajax_add_to_cart"
									   rel="nofollow"
									   aria-label="Add <?php echo esc_attr( $product->get_name() ); ?> to cart">
										Add to Cart
									</a>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<!-- Pagination -->
				<div style="margin-top:40px;text-align:center;">
					<?php woocommerce_pagination(); ?>
				</div>

			<?php else : ?>
				<div style="text-align:center;padding:60px 0;">
					<div style="font-size:48px;margin-bottom:16px;">🔬</div>
					<h2 style="margin-bottom:8px;">No products found</h2>
					<p style="color:var(--gbl-muted);margin-bottom:24px;">Try a different category or <a href="<?php echo esc_url( home_url( '/' ) ); ?>">return home</a>.</p>
				</div>
			<?php endif; ?>

		</main>
	</div>
</div>

<?php get_footer(); ?>
