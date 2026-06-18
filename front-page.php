<?php get_header(); ?>

<!-- ════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════ -->
<section class="hero" aria-labelledby="hero-heading">
	<div class="container">
		<div class="hero-inner">

			<!-- Copy -->
			<div class="hero-copy">
				<div class="hero-badge">
					<span class="dot">
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M9 12l2 2 4-4"/><path d="M12 22C6.48 22 2 17.52 2 12S6.48 2 12 2s10 4.48 10 10-4.48 10-10 10z"/>
						</svg>
					</span>
					Australia's Premier Research Peptide Supplier
				</div>

				<h1 class="hero-title" id="hero-heading">
					Research Grade<br><span class="accent">Peptides</span> &<br>Bioanalyticals
				</h1>

				<p class="hero-subtitle">
					40+ compounds. Lab-tested purity. Australian stock.
					Dedicated to advancing scientific research with premium
					research-grade peptides and bioanalytical tools.
				</p>

				<div class="hero-actions">
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary btn-lg">
							Browse Products
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
						</a>
					<?php endif; ?>
					<a href="<?php echo esc_url( home_url( '/calculator/' ) ); ?>" class="btn btn-outline-white btn-lg">
						Peptide Calculator
					</a>
				</div>

				<div class="hero-stats" role="list">
					<div class="hero-stat" role="listitem">
						<span class="val">40+</span>
						<span class="lbl">Compounds</span>
					</div>
					<div class="hero-stat" role="listitem">
						<span class="val">99%</span>
						<span class="lbl">Purity</span>
					</div>
					<div class="hero-stat" role="listitem">
						<span class="val">AU</span>
						<span class="lbl">Local Stock</span>
					</div>
					<div class="hero-stat" role="listitem">
						<span class="val">24h</span>
						<span class="lbl">Dispatch</span>
					</div>
				</div>
			</div>

			<!-- Visual — decorative peptide card stack -->
			<div class="hero-visual" aria-hidden="true">
				<div class="hero-card-stack">
					<div class="hero-peptide-card">
						<div class="hpc-cat">Growth Hormone</div>
						<div class="hpc-name">CJC-1295</div>
						<div class="hpc-nick">The GH Amplifier</div>
						<div class="hpc-bar"><div class="hpc-bar-fill" style="width:75%"></div></div>
					</div>
					<div class="hero-peptide-card">
						<div class="hpc-cat">Repair & Recovery</div>
						<div class="hpc-name">BPC-157</div>
						<div class="hpc-nick">The Healer</div>
						<div class="hpc-bar"><div class="hpc-bar-fill" style="width:90%"></div></div>
					</div>
					<div class="hero-peptide-card">
						<div class="hpc-cat">GLP-1 / Metabolic</div>
						<div class="hpc-name">Semaglutide</div>
						<div class="hpc-nick">The GLP-1 Agonist</div>
						<div class="hpc-bar"><div class="hpc-bar-fill" style="width:60%"></div></div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- ════════════════════════════════════════════════════
     TRUST BAR
════════════════════════════════════════════════════ -->
<div class="trust-bar" role="list" aria-label="Trust signals">
	<div class="container">
		<div class="trust-bar-inner">

			<?php
			$trust_items = [
				[
					'icon' => '<path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
					'label' => 'Lab Verified Purity',
				],
				[
					'icon' => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>',
					'label' => 'Secure Checkout',
				],
				[
					'icon' => '<path d="M5 12h14M12 5l7 7-7 7"/>',
					'label' => '24hr Express Dispatch',
				],
				[
					'icon' => '<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
					'label' => 'Australian Stock',
				],
				[
					'icon' => '<path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>',
					'label' => 'Expert Support',
				],
			];
			foreach ( $trust_items as $item ) : ?>
				<div class="trust-item" role="listitem">
					<div class="trust-icon" aria-hidden="true">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<?php echo $item['icon']; ?>
						</svg>
					</div>
					<?php echo esc_html( $item['label'] ); ?>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
</div>

<!-- ════════════════════════════════════════════════════
     FEATURED PRODUCTS
════════════════════════════════════════════════════ -->
<?php if ( class_exists( 'WooCommerce' ) ) :
	$featured = wc_get_products( [
		'limit'    => 4,
		'status'   => 'publish',
		'featured' => true,
		'orderby'  => 'menu_order',
	] );
	if ( empty( $featured ) ) {
		$featured = wc_get_products( [ 'limit' => 4, 'status' => 'publish', 'orderby' => 'menu_order' ] );
	}
?>
<section class="section-pad" aria-labelledby="featured-heading">
	<div class="container">
		<div class="section-header has-link">
			<div>
				<span class="label-overline">Most Popular</span>
				<h2 class="section-title" id="featured-heading">Featured Research Compounds</h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-outline">
				View All
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
			</a>
		</div>

		<div class="grid-4">
			<?php foreach ( $featured as $product ) :
				$id       = $product->get_id();
				$nickname = gbl_meta( $id, 'nickname' );
				$category = gbl_meta( $id, 'category' );
				$color    = gbl_meta( $id, 'color', '#2563eb' );
				$dose     = gbl_meta( $id, 'dose_range' );
				$half     = gbl_meta( $id, 'half_life' );
				$badge    = '';
				$terms    = get_the_terms( $id, 'product_cat' );
				$cat_name = ( $category ) ? $category : ( $terms ? $terms[0]->name : '' );
			?>
				<article class="product-card" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
					<div class="product-card-image">
						<?php if ( $product->get_image_id() ) : ?>
							<?php echo $product->get_image( 'gbl-product-card', [ 'alt' => $product->get_name() ] ); ?>
						<?php else : ?>
							<div class="product-card-placeholder">
								<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
								</svg>
							</div>
						<?php endif; ?>
						<?php if ( $product->is_on_sale() ) : ?>
							<div class="product-badge"><span class="badge badge-blue">Sale</span></div>
						<?php endif; ?>
						<?php if ( $color ) : ?>
							<div class="product-color-dot" style="background:<?php echo esc_attr( $color ); ?>" title="<?php echo esc_attr( $product->get_name() ); ?>"></div>
						<?php endif; ?>
					</div>
					<div class="product-card-body">
						<?php if ( $cat_name ) : ?>
							<div class="product-cat"><?php echo esc_html( $cat_name ); ?></div>
						<?php endif; ?>
						<h3 class="product-name">
							<a href="<?php echo esc_url( get_permalink( $id ) ); ?>" style="color:inherit;text-decoration:none;">
								<?php echo esc_html( $product->get_name() ); ?>
							</a>
						</h3>
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
							<div class="product-price">
								<?php echo $product->get_price_html(); ?>
							</div>
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
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════
     CATEGORIES GRID
════════════════════════════════════════════════════ -->
<section class="categories-section section-pad" aria-labelledby="cats-heading">
	<div class="container">
		<div class="section-header centered text-center">
			<span class="label-overline">Browse by Type</span>
			<h2 class="section-title" id="cats-heading">Research Categories</h2>
			<p class="section-subtitle" style="color:rgba(255,255,255,.55)">
				From tissue repair to metabolic research — explore our full compound catalogue organised by mechanism and research application.
			</p>
		</div>

		<div class="grid-4">
			<?php
			$categories = [
				[ 'emoji' => '🔬', 'name' => 'Repair & Recovery',     'slug' => 'repair-recovery',   'count' => 5,  'color' => '#2446C0', 'desc' => 'BPC-157, TB-500, Wolverine blends' ],
				[ 'emoji' => '📈', 'name' => 'Growth Hormone',        'slug' => 'growth-hormone',     'count' => 10, 'color' => '#071D63', 'desc' => 'CJC-1295, Ipamorelin, Sermorelin' ],
				[ 'emoji' => '⚖️', 'name' => 'GLP-1 / Metabolic',    'slug' => 'glp-1-metabolic',    'count' => 5,  'color' => '#7A1E2C', 'desc' => 'Semaglutide, Tirzepatide, Retatrutide' ],
				[ 'emoji' => '🧠', 'name' => 'Cognitive & Sleep',     'slug' => 'cognitive-sleep',    'count' => 4,  'color' => '#1A2C73', 'desc' => 'Semax, Selank, DSIP, Epithalon' ],
				[ 'emoji' => '✨', 'name' => 'Skin & Tissue',         'slug' => 'skin-tissue',        'count' => 3,  'color' => '#0E5C55', 'desc' => 'GHK-Cu, Melanotan, SNAP-8' ],
				[ 'emoji' => '🛡', 'name' => 'Immune System',         'slug' => 'immune-system',      'count' => 3,  'color' => '#4B2E83', 'desc' => 'Thymosin Alpha-1, Thymalin, LL-37' ],
				[ 'emoji' => '⏳', 'name' => 'Anti-Aging & Longevity','slug' => 'anti-aging',         'count' => 8,  'color' => '#545A61', 'desc' => 'Epithalon, SS-31, MOTS-c, NAD+' ],
				[ 'emoji' => '💪', 'name' => 'Growth & Muscle',       'slug' => 'growth-muscle',      'count' => 6,  'color' => '#071D63', 'desc' => 'IGF-1 LR3, PEG-MGF, Follistatin' ],
			];

			foreach ( $categories as $cat ) :
				$cat_url = class_exists( 'WooCommerce' )
					? get_term_link( $cat['slug'], 'product_cat' )
					: home_url( '/product-category/' . $cat['slug'] . '/' );
				$cat_url = is_wp_error( $cat_url ) ? home_url( '/product-category/' . $cat['slug'] . '/' ) : $cat_url;
			?>
				<a href="<?php echo esc_url( $cat_url ); ?>" class="category-card" aria-label="Browse <?php echo esc_attr( $cat['name'] ); ?>">
					<div class="category-icon" style="background:<?php echo esc_attr( $cat['color'] ); ?>22;">
						<?php echo $cat['emoji']; ?>
					</div>
					<div class="category-name"><?php echo esc_html( $cat['name'] ); ?></div>
					<div class="category-count"><?php echo esc_html( $cat['count'] ); ?> compounds &mdash; <?php echo esc_html( $cat['desc'] ); ?></div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ════════════════════════════════════════════════════
     STACKS SECTION
════════════════════════════════════════════════════ -->
<section class="section-pad" aria-labelledby="stacks-heading">
	<div class="container">
		<div class="section-header centered text-center" style="margin-bottom:40px;">
			<span class="label-overline">Multi-Compound Protocols</span>
			<h2 class="section-title" id="stacks-heading">Research Stack Protocols</h2>
			<p class="section-subtitle">
				Curated multi-peptide combinations for specific research applications. Each stack details synergy rationale, dosing schedule, and cycle length.
			</p>
		</div>

		<div class="grid-3">
			<?php
			$stacks = [
				[
					'name'    => 'Wolverine Stack',
					'goal'    => 'Injury Repair & Recovery',
					'badge'   => 'Most Popular',
					'desc'    => 'BPC-157 targets local tissue repair; TB-500 provides systemic healing. Covers both local and systemic repair simultaneously.',
					'peptides'=> ['BPC-157', 'TB-500'],
					'color'   => '#2446C0',
					'slug'    => 'wolverine-stack',
				],
				[
					'name'    => 'GH Stack',
					'goal'    => 'Clean GH Release',
					'badge'   => 'Gold Standard',
					'desc'    => 'CJC-1295 amplifies the GH pulse; Ipamorelin triggers it cleanly without cortisol or prolactin elevation.',
					'peptides'=> ['CJC-1295', 'Ipamorelin'],
					'color'   => '#071D63',
					'slug'    => 'gh-stack',
				],
				[
					'name'    => 'Cognitive Stack',
					'goal'    => 'Focus, Memory & Anxiety',
					'badge'   => null,
					'desc'    => 'Semax drives BDNF and dopamine for focus; Selank modulates GABA for anxiolysis. Stimulation without overstimulation.',
					'peptides'=> ['Semax', 'Selank'],
					'color'   => '#1A2C73',
					'slug'    => 'cognitive-stack',
				],
				[
					'name'    => 'GLO Stack',
					'goal'    => 'Skin & Tissue Regeneration',
					'badge'   => 'Triple Action',
					'desc'    => 'BPC-157, TB-500, and GHK-Cu combine for comprehensive regeneration — tissue repair, systemic healing, and collagen synthesis.',
					'peptides'=> ['BPC-157', 'TB-500', 'GHK-Cu'],
					'color'   => '#0E5C55',
					'slug'    => 'glo-stack',
				],
				[
					'name'    => 'Sleep Stack',
					'goal'    => 'Deep Sleep & Circadian Reset',
					'badge'   => null,
					'desc'    => 'DSIP promotes delta-wave sleep; Epithalon resets the pineal and circadian rhythm. Short-term sleep, long-term normalisation.',
					'peptides'=> ['DSIP', 'Epithalon'],
					'color'   => '#545A61',
					'slug'    => 'sleep-stack',
				],
				[
					'name'    => 'KLOW Stack',
					'goal'    => 'Total Repair & Anti-Inflammation',
					'badge'   => 'Comprehensive',
					'desc'    => 'Four-peptide protocol adding KPV\'s NF-κB inhibition to the GLO triple. The most complete single-vial healing protocol.',
					'peptides'=> ['BPC-157', 'TB-500', 'GHK-Cu', 'KPV'],
					'color'   => '#4B2E83',
					'slug'    => 'klow-stack',
				],
			];

			foreach ( $stacks as $stack ) :
				$stack_url = home_url( '/stacks/' . $stack['slug'] . '/' );
			?>
				<a href="<?php echo esc_url( $stack_url ); ?>" class="stack-card" style="--stack-color:<?php echo esc_attr( $stack['color'] ); ?>">
					<div class="stack-header">
						<h3 class="stack-name"><?php echo esc_html( $stack['name'] ); ?></h3>
						<?php if ( $stack['badge'] ) : ?>
							<span class="stack-badge"><?php echo esc_html( $stack['badge'] ); ?></span>
						<?php endif; ?>
					</div>
					<div class="stack-goal"><?php echo esc_html( $stack['goal'] ); ?></div>
					<p class="stack-desc"><?php echo esc_html( $stack['desc'] ); ?></p>
					<div class="stack-peptides">
						<?php foreach ( $stack['peptides'] as $p ) : ?>
							<span class="stack-peptide-pill"><?php echo esc_html( $p ); ?></span>
						<?php endforeach; ?>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ════════════════════════════════════════════════════
     CALCULATOR CTA
════════════════════════════════════════════════════ -->
<section class="section-pad-sm" aria-labelledby="calc-cta-heading">
	<div class="container">
		<div class="calc-cta">
			<div>
				<h2 class="calc-cta-title" id="calc-cta-heading">Peptide Reconstitution Calculator</h2>
				<p class="calc-cta-text">
					Calculate exact BAC water volumes, draw volumes, and insulin units for any peptide vial — plus intranasal dosing for Semax, Selank, and more.
				</p>
			</div>
			<a href="<?php echo esc_url( home_url( '/calculator/' ) ); ?>" class="btn btn-outline-white btn-lg">
				Open Calculator
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M5 12h14M12 5l7 7-7 7"/>
				</svg>
			</a>
		</div>
	</div>
</section>

<!-- ════════════════════════════════════════════════════
     SOCIAL PROOF / ABOUT STRIP
════════════════════════════════════════════════════ -->
<section class="section-pad-sm" style="background:var(--gbl-card);border-top:1px solid var(--gbl-border);border-bottom:1px solid var(--gbl-border);">
	<div class="container">
		<div class="grid-3" style="gap:40px;align-items:center;">
			<div>
				<span class="label-overline">Who We Are</span>
				<h2 class="section-title" style="font-size:24px;margin-bottom:12px;">Built for the Research Community</h2>
				<p style="color:var(--gbl-muted);font-size:14px;line-height:1.75;margin-bottom:18px;">
					Global Bioanalytical is an Australian supplier of research-grade peptides and bioanalytical compounds.
					Every batch is third-party tested for purity and identity before dispatch.
				</p>
				<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="btn btn-outline btn-sm">About Us</a>
			</div>
			<div style="display:flex;flex-direction:column;gap:16px;">
				<?php
				$points = [
					[ '🔬', 'HPLC purity verified — CoA available on request' ],
					[ '🇦🇺', 'Australian stock — dispatched from Brisbane' ],
					[ '❄️',  'Cold-chain shipping for temperature-sensitive compounds' ],
					[ '📦', 'Discreet packaging — no product names on outer box' ],
				];
				foreach ( $points as $p ) :
				?>
					<div style="display:flex;align-items:flex-start;gap:12px;font-size:14px;font-weight:600;color:var(--gbl-dark);">
						<span style="font-size:18px;flex-shrink:0;"><?php echo $p[0]; ?></span>
						<?php echo esc_html( $p[1] ); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<div style="background:var(--gbl-elevated);border-radius:var(--radius-lg);padding:28px;text-align:center;">
				<div style="font-size:48px;font-weight:800;color:var(--gbl-blue);line-height:1;">40+</div>
				<div style="font-size:12px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--gbl-muted);margin:6px 0 20px;">Research Compounds In Stock</div>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary" style="width:100%;justify-content:center;">
						Shop All Compounds
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
