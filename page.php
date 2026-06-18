<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-header">
	<div class="container">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</div>
</div>

<article class="entry-content" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_content(); ?>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
