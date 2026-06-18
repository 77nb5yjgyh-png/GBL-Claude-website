<!-- ── NEWSLETTER ── -->
<section class="newsletter-section">
	<div class="container">
		<span class="label-overline">Stay Updated</span>
		<h2 class="section-title">Research Updates & New Peptides</h2>
		<p class="section-subtitle">Get notified about new compounds, protocols, and restocks — no spam, unsubscribe any time.</p>
		<form class="newsletter-form" id="newsletter-form" novalidate>
			<input type="email" placeholder="your@email.com" required autocomplete="email" aria-label="Email address">
			<button type="submit" class="btn btn-primary">Subscribe</button>
		</form>
		<p id="newsletter-msg" style="margin-top:12px;font-size:13px;font-weight:700;display:none;"></p>
	</div>
</section>

<!-- ── SITE FOOTER ── -->
<footer class="site-footer" role="contentinfo">
	<div class="container">
		<div class="footer-grid">

			<!-- Brand -->
			<div class="footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="Home">
					<div class="site-logo-mark">
						<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path d="M10 2C5.58 2 2 5.58 2 10s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 3a2 2 0 110 4 2 2 0 010-4zm0 10.5a6 6 0 01-5-2.69C5.02 11.76 8.27 11 10 11s4.98.76 5 1.81a6 6 0 01-5 2.69z"/>
						</svg>
					</div>
					<div class="site-logo-text">
						<span class="name">Global Bioanalytical</span>
						<span class="sub">Research Peptides</span>
					</div>
				</a>
				<p class="footer-tagline">Premium research-grade peptides and bioanalytical compounds for the Australian scientific community.</p>
			</div>

			<!-- Products column -->
			<div>
				<h3 class="footer-col-title">Products</h3>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer_1',
					'container'      => false,
					'menu_class'     => 'footer-links',
					'fallback_cb'    => function() {
						echo '<ul class="footer-links">';
						$items = [
							'Repair & Recovery' => '/product-category/repair-recovery/',
							'Growth Hormone'    => '/product-category/growth-hormone/',
							'GLP-1 / Metabolic' => '/product-category/glp-1-metabolic/',
							'Cognitive & Sleep' => '/product-category/cognitive-sleep/',
							'Anti-Aging'        => '/product-category/anti-aging/',
							'Stack Blends'      => '/product-category/blends/',
							'Shop All'          => class_exists('WooCommerce') ? get_permalink( wc_get_page_id('shop') ) : '/shop/',
						];
						foreach ( $items as $label => $url ) {
							echo '<li><a href="' . esc_url( home_url( $url ) ) . '">' . esc_html( $label ) . '</a></li>';
						}
						echo '</ul>';
					},
				] );
				?>
			</div>

			<!-- Company column -->
			<div>
				<h3 class="footer-col-title">Company</h3>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer_2',
					'container'      => false,
					'menu_class'     => 'footer-links',
					'fallback_cb'    => function() {
						echo '<ul class="footer-links">';
						$items = [ 'About Us' => '/about/', 'Calculator' => '/calculator/', 'Research Blog' => '/blog/', 'Contact' => '/contact/', 'FAQ' => '/faq/' ];
						foreach ( $items as $label => $url ) {
							echo '<li><a href="' . esc_url( home_url( $url ) ) . '">' . esc_html( $label ) . '</a></li>';
						}
						echo '</ul>';
					},
				] );
				?>
			</div>

			<!-- Legal column -->
			<div>
				<h3 class="footer-col-title">Legal</h3>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer_3',
					'container'      => false,
					'menu_class'     => 'footer-links',
					'fallback_cb'    => function() {
						echo '<ul class="footer-links">';
						$items = [ 'Privacy Policy' => '/privacy-policy/', 'Terms & Conditions' => '/terms-conditions/', 'Shipping Policy' => '/shipping-policy/', 'Refund Policy' => '/refund-policy/', 'Research Disclaimer' => '/disclaimer/' ];
						foreach ( $items as $label => $url ) {
							echo '<li><a href="' . esc_url( home_url( $url ) ) . '">' . esc_html( $label ) . '</a></li>';
						}
						echo '</ul>';
					},
				] );
				?>
			</div>

		</div>

		<!-- Footer bottom bar -->
		<div class="footer-bottom">
			<p class="footer-copyright">
				&copy; <?php echo date( 'Y' ); ?> Global Bioanalytical Pty Ltd. ABN — All rights reserved.
			</p>
			<p class="footer-disclaimer">
				All products are sold strictly for research and laboratory use only. Not for human or animal consumption. Must be 18+ to purchase. Compliant with TGA regulations.
			</p>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
