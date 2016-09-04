<?php
/**
 * Template Name: About Page Template
 *
 * Description: Displays a full-width page, with no sidebar. This template is great for pages
 * containing large amounts of content.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content row" role="main">

	<div class="grid-12">
		<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '78' ); } ?>
	</div>	
		
		
	

	</div><!-- /#primary.site-content.row -->

	<div id="services" class="about-content row">

	<div class="grid-12 pad-3-vert">	

		<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

		<div class="grid-12 pad-3-vert">
			
	
			<h5 class="center medium hsslate"><?php the_title(); ?></h5>
	
			
		</div>	
		<div class="grid-8 m-grid-12 offset-2 m-offset-0 pad-3-vert m-pad-3-sides">

			<?php the_content(); ?>	

		</div>

	</div>

		<?php endwhile; // end of the loop. ?>

		<?php endif; // end have_posts() check ?>
		
	</div>

	<div class="grid-12">
		<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '84' ); } ?>
	</div>	

	<div class="about_hannah-content row">

		<div class="grid-12 pad-3-vert">

			<div class="grid-12 pad-3-vert">

				<?php if( get_field('about_section_title') ): ?>
	
					<h5 class="center bluegreen pad-2-vert"><?php the_field('about_section_title'); ?></h5>
	
				<?php endif; ?>

			</div>

		<div class="grid-8 m-grid-12 offset-2 m-offset-0 pad-3-vert m-pad-3-sides">

			<?php if( get_field('about_section_content') ): ?>
	
			<?php the_field('about_section_content'); ?>
	
			<?php endif; ?>		

		</div>	

		</div>

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
