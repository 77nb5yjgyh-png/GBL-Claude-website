<?php
/**
 * GBL Peptide — WooCommerce Single Product Page
 */
defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) : the_post();
	global $product;
	if ( ! $product ) $product = wc_get_product( get_the_ID() );

	$id         = $product->get_id();
	$nickname   = gbl_meta( $id, 'nickname' );
	$category   = gbl_meta( $id, 'category' );
	$color      = gbl_meta( $id, 'color', '#2563eb' );
	$half_life  = gbl_meta( $id, 'half_life' );
	$dose       = gbl_meta( $id, 'dose_range' );
	$frequency  = gbl_meta( $id, 'frequency' );
	$routes     = gbl_meta( $id, 'routes' );
	$mechanism  = gbl_meta( $id, 'mechanism' );
	$use        = gbl_meta( $id, 'use' );
	$side_fx    = gbl_meta( $id, 'side_fx' );
	$contraind  = gbl_meta( $id, 'contraind' );
	$pairs      = gbl_meta( $id, 'pairs' );
	$terms      = get_the_terms( $id, 'product_cat' );
	$cat_name   = $category ?: ( $terms && ! is_wp_error( $terms ) ? $terms[0]->name : '' );

	$route_list = $routes ? array_map( 'trim', explode( ',', $routes ) ) : [];
	$pairs_list = $pairs  ? array_map( 'trim', explode( ',', $pairs ) )  : [];
?>

<!-- Page header + breadcrumb -->
<div class="page-header" style="padding:36px 0 40px;">
	<div class="container">
		<?php gbl_breadcrumb(); ?>
		<h1 class="page-title" style="margin-top:10px;"><?php the_title(); ?></h1>
		<?php if ( $nickname ) : ?>
			<p class="page-desc"><?php echo esc_html( $nickname ); ?></p>
		<?php endif; ?>
	</div>
</div>

<!-- ── PRODUCT BODY ── -->
<div class="container section-pad">
	<div class="product-layout" <?php wc_product_class( '', $product ); ?>>

		<!-- ── IMAGES ── -->
		<div class="product-images">
			<div class="product-image-main">
				<?php
				$img_id = $product->get_image_id();
				if ( $img_id ) {
					echo wp_get_attachment_image( $img_id, 'large', false, [
						'alt' => $product->get_name(),
						'style' => 'width:100%;height:100%;object-fit:cover;',
					] );
				} else {
					// Stylised placeholder with peptide color and name
					echo '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;">';
					echo '<div style="width:100px;height:100px;border-radius:50%;background:' . esc_attr( $color ) . '22;display:flex;align-items:center;justify-content:center;">';
					echo '<div style="width:20px;height:20px;border-radius:50%;background:' . esc_attr( $color ) . ';"></div>';
					echo '</div>';
					echo '<div style="font-size:22px;font-weight:800;color:var(--gbl-dark);">' . esc_html( $product->get_name() ) . '</div>';
					if ( $cat_name ) {
						echo '<div style="font-size:12px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:' . esc_attr( $color ) . ';">' . esc_html( $cat_name ) . '</div>';
					}
					echo '</div>';
				}
				?>
			</div>

			<!-- Gallery thumbnails -->
			<?php
			$gallery_ids = $product->get_gallery_image_ids();
			if ( $gallery_ids ) : ?>
				<div class="product-image-thumbs">
					<?php if ( $img_id ) : ?>
						<div class="product-image-thumb active" data-src="<?php echo esc_url( wp_get_attachment_image_url( $img_id, 'medium' ) ); ?>">
							<?php echo wp_get_attachment_image( $img_id, 'thumbnail' ); ?>
						</div>
					<?php endif; ?>
					<?php foreach ( array_slice( $gallery_ids, 0, 3 ) as $gid ) : ?>
						<div class="product-image-thumb" data-src="<?php echo esc_url( wp_get_attachment_image_url( $gid, 'large' ) ); ?>">
							<?php echo wp_get_attachment_image( $gid, 'thumbnail' ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- Research Disclaimer Box -->
			<div style="background:#fefce8;border:1px solid #fde68a;border-radius:var(--radius-md);padding:16px 20px;margin-top:20px;">
				<div style="display:flex;align-items:flex-start;gap:10px;">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;" aria-hidden="true">
						<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
					</svg>
					<p style="font-size:12px;font-weight:700;color:#92400e;margin:0;line-height:1.6;">
						For <strong>research and laboratory use only.</strong> Not for human or animal consumption. Sold to verified research institutions and professionals only.
					</p>
				</div>
			</div>
		</div>

		<!-- ── PRODUCT INFO ── -->
		<div class="product-info">

			<!-- Category -->
			<?php if ( $cat_name ) : ?>
				<div style="font-size:11px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:<?php echo esc_attr( $color ); ?>;margin-bottom:10px;">
					<?php echo esc_html( $cat_name ); ?>
				</div>
			<?php endif; ?>

			<!-- Price -->
			<div class="product-price" aria-label="Price">
				<?php echo $product->get_price_html(); ?>
			</div>

			<!-- Key info pills -->
			<div class="product-info-pills">
				<?php if ( $half_life ) : ?>
					<div class="product-info-pill">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						t½ <?php echo esc_html( $half_life ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $dose ) : ?>
					<div class="product-info-pill">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2l4 4-14.5 14.5L3 21l.5-4.5L18 2z"/></svg>
						<?php echo esc_html( $dose ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $frequency ) : ?>
					<div class="product-info-pill">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
						<?php echo esc_html( $frequency ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $product->is_in_stock() ) : ?>
					<div class="product-info-pill" style="color:var(--gbl-success);">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--gbl-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
						In Stock
					</div>
				<?php endif; ?>
			</div>

			<!-- Routes of administration -->
			<?php if ( $route_list ) : ?>
				<div style="margin-bottom:24px;">
					<span class="product-option-label">Routes of Administration</span>
					<div class="routes-list">
						<?php foreach ( $route_list as $route ) : ?>
							<span class="route-pill"><?php echo esc_html( $route ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Variant / size selection (WooCommerce variable products) -->
			<?php if ( $product->is_type( 'variable' ) ) :
				$attributes = $product->get_variation_attributes();
				foreach ( $attributes as $attr_name => $options ) :
					$attr_label = wc_attribute_label( $attr_name );
			?>
				<div class="product-options">
					<span class="product-option-label"><?php echo esc_html( $attr_label ); ?></span>
					<div class="product-option-btns">
						<?php foreach ( $options as $opt ) : ?>
							<button class="option-btn" data-attr="<?php echo esc_attr( $attr_name ); ?>" data-value="<?php echo esc_attr( $opt ); ?>">
								<?php echo esc_html( $opt ); ?>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; endif; ?>

			<!-- WooCommerce add-to-cart form -->
			<form class="cart" method="post" enctype="multipart/form-data">
				<div class="product-qty-row">
					<div class="qty-input-wrap">
						<button type="button" class="qty-btn qty-minus" aria-label="Decrease quantity">−</button>
						<input type="number" class="qty-input" name="quantity" value="1" min="1" max="99" aria-label="Quantity">
						<button type="button" class="qty-btn qty-plus" aria-label="Increase quantity">+</button>
					</div>
					<button type="submit" name="add-to-cart" value="<?php echo $id; ?>" class="btn btn-primary product-add-btn single_add_to_cart_button">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
							<path d="M1 1h4l2.68 13.39a2 2 0 001.99 1.61h9.66a2 2 0 001.98-1.72L23 6H6"/>
						</svg>
						<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
					</button>
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</div>
			</form>

			<!-- Reassurance row -->
			<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:8px;">
				<?php
				$reassure = [
					[ '🔒', 'Secure Checkout' ],
					[ '🚀', '24h Dispatch'    ],
					[ '🇦🇺', 'AU Stock'        ],
				];
				foreach ( $reassure as $r ) : ?>
					<div style="background:var(--gbl-elevated);border-radius:var(--radius-md);padding:12px;text-align:center;font-size:11px;font-weight:700;color:var(--gbl-muted);letter-spacing:.06em;">
						<div style="font-size:18px;margin-bottom:4px;"><?php echo $r[0]; ?></div>
						<?php echo esc_html( $r[1] ); ?>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Pairs -->
			<?php if ( $pairs_list ) : ?>
				<div style="margin-top:24px;">
					<span class="product-option-label">Commonly Paired With</span>
					<div class="pairs-list">
						<?php foreach ( $pairs_list as $pair ) :
							$pair_product = null;
							$pair_results = wc_get_products( [ 'limit' => 1, 'name' => $pair ] );
							$pair_url     = $pair_results ? get_permalink( $pair_results[0]->get_id() ) : '#';
						?>
							<a href="<?php echo esc_url( $pair_url ); ?>" class="pair-chip"><?php echo esc_html( $pair ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>

	<!-- ── RESEARCH INFO TABS ── -->
	<?php if ( $mechanism || $use || $side_fx || $contraind || get_the_content() ) : ?>
	<div class="product-tabs" id="product-tabs">
		<nav class="tab-nav" role="tablist" aria-label="Product information tabs">
			<?php
			$tabs = [];
			if ( $mechanism || $use )   $tabs[] = [ 'id' => 'mechanism',  'label' => 'Mechanism' ];
			if ( get_the_content() )    $tabs[] = [ 'id' => 'description','label' => 'Description' ];
			if ( $dose || $frequency )  $tabs[] = [ 'id' => 'dosing',     'label' => 'Research Dosing' ];
			if ( $side_fx || $contraind ) $tabs[] = [ 'id' => 'safety',   'label' => 'Safety Profile' ];
			$tabs[] = [ 'id' => 'calculator', 'label' => 'Quick Calculator' ];

			foreach ( $tabs as $i => $tab ) : ?>
				<button
					class="tab-btn<?php echo $i === 0 ? ' active' : ''; ?>"
					role="tab"
					aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
					aria-controls="tab-<?php echo esc_attr( $tab['id'] ); ?>"
					id="tab-btn-<?php echo esc_attr( $tab['id'] ); ?>">
					<?php echo esc_html( $tab['label'] ); ?>
				</button>
			<?php endforeach; ?>
		</nav>

		<!-- Mechanism tab -->
		<?php if ( $mechanism || $use ) : ?>
		<div class="tab-panel<?php echo in_array( 'mechanism', array_column( $tabs, 'id' ) ) ? ( $tabs[0]['id'] === 'mechanism' ? ' active' : '' ) : ''; ?>" id="tab-mechanism" role="tabpanel" aria-labelledby="tab-btn-mechanism">
			<?php if ( $mechanism ) : ?>
				<h3 style="font-size:17px;margin-bottom:14px;">Mechanism of Action</h3>
				<p class="mech-text"><?php echo wp_kses_post( $mechanism ); ?></p>
			<?php endif; ?>
			<?php if ( $use ) : ?>
				<h3 style="font-size:17px;margin:24px 0 14px;">Research Applications</h3>
				<p class="mech-text"><?php echo wp_kses_post( $use ); ?></p>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<!-- Description tab -->
		<?php if ( get_the_content() ) : ?>
		<div class="tab-panel<?php echo ( ! $mechanism && ! $use ) ? ' active' : ''; ?>" id="tab-description" role="tabpanel" aria-labelledby="tab-btn-description">
			<div class="mech-text"><?php the_content(); ?></div>
		</div>
		<?php endif; ?>

		<!-- Dosing tab -->
		<div class="tab-panel" id="tab-dosing" role="tabpanel" aria-labelledby="tab-btn-dosing">
			<div class="info-grid">
				<?php if ( $dose ) : ?>
					<div class="info-card">
						<div class="info-card-label">Research Dose Range</div>
						<div class="info-card-value accent"><?php echo esc_html( $dose ); ?></div>
					</div>
				<?php endif; ?>
				<?php if ( $frequency ) : ?>
					<div class="info-card">
						<div class="info-card-label">Dosing Frequency</div>
						<div class="info-card-value"><?php echo esc_html( $frequency ); ?></div>
					</div>
				<?php endif; ?>
				<?php if ( $half_life ) : ?>
					<div class="info-card">
						<div class="info-card-label">Half-Life</div>
						<div class="info-card-value"><?php echo esc_html( $half_life ); ?></div>
					</div>
				<?php endif; ?>
				<?php if ( $route_list ) : ?>
					<div class="info-card">
						<div class="info-card-label">Routes of Administration</div>
						<div class="routes-list" style="margin-top:6px;">
							<?php foreach ( $route_list as $r ) : ?>
								<span class="route-pill"><?php echo esc_html( $r ); ?></span>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div style="background:var(--gbl-blue-dim);border:1px solid #bfdbfe;border-radius:var(--radius-md);padding:16px 20px;margin-top:8px;">
				<p style="font-size:13px;color:var(--gbl-blue);font-weight:700;margin:0;line-height:1.65;">
					All dosing information is for <strong>in vitro and in vivo research reference only.</strong> Consult peer-reviewed literature for validated protocols.
				</p>
			</div>
		</div>

		<!-- Safety tab -->
		<div class="tab-panel" id="tab-safety" role="tabpanel" aria-labelledby="tab-btn-safety">
			<?php if ( $side_fx ) : ?>
				<h3 style="font-size:17px;margin-bottom:12px;">Reported Side Effects</h3>
				<p class="mech-text" style="margin-bottom:24px;"><?php echo wp_kses_post( $side_fx ); ?></p>
			<?php endif; ?>
			<?php if ( $contraind ) : ?>
				<div class="contraindication-box">
					<div class="label">Contraindications / Precautions</div>
					<p><?php echo wp_kses_post( $contraind ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<!-- Quick Calculator tab -->
		<div class="tab-panel" id="tab-calculator" role="tabpanel" aria-labelledby="tab-btn-calculator">
			<p style="color:var(--gbl-muted);font-size:14px;margin-bottom:24px;">
				Enter your vial size and BAC water to calculate the exact draw volume for your research dose.
			</p>
			<div class="calc-card" id="product-mini-calc" data-product="<?php echo esc_attr( $product->get_name() ); ?>">
				<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:20px;">
					<div class="calc-field">
						<label class="calc-label" for="mc-vial">Vial size <span>mg</span></label>
						<input type="number" id="mc-vial" class="calc-input" placeholder="5" min="0.1" step="0.1">
					</div>
					<div class="calc-field">
						<label class="calc-label" for="mc-bac">BAC water <span>mL</span></label>
						<input type="number" id="mc-bac" class="calc-input" placeholder="2" min="0.1" step="0.1">
					</div>
					<div class="calc-field">
						<label class="calc-label" for="mc-dose">Your dose <span>mcg</span></label>
						<input type="number" id="mc-dose" class="calc-input" placeholder="250" min="1">
					</div>
				</div>
				<button class="btn btn-primary" id="mc-calc-btn" style="width:100%;justify-content:center;">Calculate</button>
				<div class="calc-results" id="mc-results" style="display:none;margin-top:20px;">
					<div class="calc-result-title">Results</div>
					<div class="calc-result-grid">
						<div class="calc-result-item calc-result-featured">
							<div class="calc-result-label">Draw Volume</div>
							<div class="calc-result-value" id="mc-volume">—<span class="unit">mL</span></div>
						</div>
						<div class="calc-result-item">
							<div class="calc-result-label">Insulin Units</div>
							<div class="calc-result-value" id="mc-units">—<span class="unit">IU</span></div>
						</div>
						<div class="calc-result-item">
							<div class="calc-result-label">Concentration</div>
							<div class="calc-result-value" id="mc-conc">—<span class="unit">mcg/mL</span></div>
						</div>
					</div>
					<p class="calc-disclaimer">Reference values only. Verify all calculations before use.</p>
				</div>
			</div>
			<div style="margin-top:16px;text-align:center;">
				<a href="<?php echo esc_url( home_url( '/calculator/' ) ); ?>" class="btn btn-outline btn-sm">
					Open Full Calculator →
				</a>
			</div>
		</div>

	</div>
	<?php endif; ?>

	<!-- Related Products -->
	<?php
	$related_ids = wc_get_related_products( $id, 4 );
	if ( $related_ids ) :
		$related_products = array_map( 'wc_get_product', $related_ids );
		$related_products = array_filter( $related_products );
	?>
		<div style="margin-top:72px;">
			<h2 class="section-title" style="margin-bottom:28px;">Related Compounds</h2>
			<div class="grid-4">
				<?php foreach ( $related_products as $rp ) :
					$r_id    = $rp->get_id();
					$r_nick  = gbl_meta( $r_id, 'nickname' );
					$r_color = gbl_meta( $r_id, 'color', '#2563eb' );
					$r_terms = get_the_terms( $r_id, 'product_cat' );
					$r_cat   = gbl_meta( $r_id, 'category' ) ?: ( $r_terms ? $r_terms[0]->name : '' );
				?>
					<article class="product-card">
						<div class="product-card-image">
							<?php if ( $rp->get_image_id() ) : ?>
								<?php echo $rp->get_image( 'thumbnail' ); ?>
							<?php else : ?>
								<div class="product-card-placeholder">
									<div style="width:14px;height:14px;border-radius:50%;background:<?php echo esc_attr( $r_color ); ?>;"></div>
								</div>
							<?php endif; ?>
							<?php if ( $r_color ) : ?>
								<div class="product-color-dot" style="background:<?php echo esc_attr( $r_color ); ?>"></div>
							<?php endif; ?>
						</div>
						<div class="product-card-body">
							<?php if ( $r_cat ) : ?><div class="product-cat"><?php echo esc_html( $r_cat ); ?></div><?php endif; ?>
							<h3 class="product-name">
								<a href="<?php echo esc_url( get_permalink( $r_id ) ); ?>" style="color:inherit;text-decoration:none;"><?php echo esc_html( $rp->get_name() ); ?></a>
							</h3>
							<?php if ( $r_nick ) : ?><div class="product-nick"><?php echo esc_html( $r_nick ); ?></div><?php endif; ?>
							<div class="product-price-row">
								<div><?php echo $rp->get_price_html(); ?></div>
								<a href="<?php echo esc_url( get_permalink( $r_id ) ); ?>" class="add-to-cart-btn">View</a>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</div>

<?php
endwhile;
get_footer();
?>
