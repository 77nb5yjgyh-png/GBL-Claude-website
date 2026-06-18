<?php
/**
 * Fallback template — WordPress requires index.php.
 * All main page routing is handled by front-page.php,
 * woocommerce/ templates, and page.php.
 */
get_header();

if ( have_posts() ) : ?>
<div class="page-header">
	<div class="container">
		<h1 class="page-title"><?php
			if ( is_archive() )      { the_archive_title(); }
			elseif ( is_search() )   { printf( 'Search results for: %s', get_search_query() ); }
			elseif ( is_home() )     { echo 'Latest Posts'; }
			else                     { the_title(); }
		?></h1>
	</div>
</div>
<div class="container section-pad">
	<div style="max-width:760px;margin:0 auto;display:flex;flex-direction:column;gap:32px;">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class('card'); ?> style="padding:28px;">
				<div style="font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gbl-muted);margin-bottom:10px;">
					<?php echo get_the_date(); ?> &middot; <?php the_category( ' ' ); ?>
				</div>
				<h2 style="font-size:20px;margin-bottom:10px;">
					<a href="<?php the_permalink(); ?>" style="color:var(--gbl-dark);text-decoration:none;"><?php the_title(); ?></a>
				</h2>
				<div style="color:var(--gbl-muted);font-size:14px;line-height:1.7;"><?php the_excerpt(); ?></div>
				<a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm" style="margin-top:16px;">Read More</a>
			</article>
		<?php endwhile; ?>
		<div><?php the_posts_navigation(); ?></div>
	</div>
</div>
<?php else : ?>
<div class="container section-pad" style="text-align:center;">
	<div style="font-size:48px;margin-bottom:16px;">🔬</div>
	<h1 style="margin-bottom:8px;">Nothing found</h1>
	<p style="color:var(--gbl-muted);margin-bottom:24px;">Try searching or <a href="<?php echo esc_url( home_url() ); ?>">return home</a>.</p>
</div>
<?php endif; ?>

<?php get_footer(); ?>
