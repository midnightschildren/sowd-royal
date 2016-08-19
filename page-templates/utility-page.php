<?php
/**
 * Template Name: Utility Page Template
 *
 * Description: Displays a full-width page, with no sidebar. This template is great for pages
 * containing large amounts of content.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

	<div id="primary" class="shop_menu-content row" role="main">
		

	</div><!-- /#primary.site-content.row -->

	<div id="services" class="site-content row">

	<div class="grid-12 pad-3-vert">	

		<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

		<div class="grid-12 pad-3-vert">
			
	
			<h5 class="center medium hsslate"><?php the_title(); ?></h5>
	
			
		</div>	
		<div class="grid-8 offset-2 pad-3-vert">

			<?php the_content(); ?>	

		</div>

	</div>

		<?php endwhile; // end of the loop. ?>

		<?php endif; // end have_posts() check ?>
		
	</div>	
	

<?php get_footer(); ?>
