<?php
/**
 * Template Name: List Page Template
 *
 * Description: Displays a full-width page, with no sidebar. This template is great for pages
 * containing large amounts of content.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content row" role="main">	
		
	

	</div><!-- /#primary.site-content.row -->

	<div id="services" class="about-content row">

	<div class="grid-12 pad-3-vert">	

		<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

		<div class="grid-12 pad-3-vert">
			
	
			<h5 class="center medium hsslate"><?php the_title(); ?></h5>
	
			
		</div>	
		<div class="grid-6 m-grid-12 s-grid-12 offset-3 m-offset-0 s-offset-0 pad-3-vert m-pad-3-sides s-pad-3-sides">

			<?php the_content(); ?>	

		</div>

	</div>

		<?php endwhile; // end of the loop. ?>

		<?php endif; // end have_posts() check ?>
		
	</div>
	
	<div id="secondaryimage">
		<?php 

		$image = get_field('second_page_image');

		if( !empty($image) ): ?>
		<div class="grid-12">

			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
		</div>	
		<?php endif; ?>
	</div>	

<?php get_footer(); ?>
