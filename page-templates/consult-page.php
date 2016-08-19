<?php
/**
 * Template Name: Consult Page Template
 *
 * Description: Displays a full-width page, with no sidebar. This template is great for pages
 * containing large amounts of content.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

<?php
global $product;
if(is_user_logged_in() && has_bought()) { ?>
	 
		<div id="primary" class="site-content row" role="main">

	<div class="grid-12">
		<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '78' ); } ?>
	</div>	
	

	</div><!-- /#primary.site-content.row -->

	<div id="Consult" class="about-content row">

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

	<div class="about_hannah-content row">

		<div class="grid-12 pad-3-vert">

			<div class="grid-12 pad-3-vert">

				<?php if( get_field('about_section_title') ): ?>
	
					<h5 class="center hsslate pad-2-vert"><?php the_field('about_section_title'); ?></h5>
	
				<?php endif; ?>

			</div>

		<div class="grid-8 offset-2 pad-3-vert">

			<?php if( get_field('about_section_content') ): ?>
	
			<?php the_field('about_section_content'); ?>
	
			<?php endif; ?>		

		</div>	

		</div>

	</div>			


<?php };

if(is_user_logged_in() && !has_bought()) { ?>

		<div id="primary" class="vconsult-content row" role="main">

			<div class="grid-12">
				<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '78' ); } ?>

				<div class="grid-10 offset-1 pad-3-vert">
		
					<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

					<div class="grid-12 pad-3-vert">	
	
						<h5 class="center medium hsslate"><?php the_title(); ?></h5>
			
					</div>

					<?php endwhile; // end of the loop. ?>

					<?php endif; // end have_posts() check ?>

						<p class="center shop-description">Please purchase the <a href="/shop/uncategorized/online-skin-care-consultation/">Virtual Online Consult</a> to view this content. Thank you!</p>

				</div>

			</div>

		</div>

	<?php };    

if(!is_user_logged_in()) { ?> 
    
<div id="primary" class="vconsult-content row" role="main">

	<div class="grid-12">
		<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '78' ); } ?>

		<div class="grid-10 offset-1 pad-3-vert">
		
			<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<div class="grid-12 pad-3-vert">	
	
				<h5 class="center medium hsslate"><?php the_title(); ?></h5>
			
			</div>

			<?php endwhile; // end of the loop. ?>

			<?php endif; // end have_posts() check ?>

				<p class="center shop-description">You must be <a href="/my-account/">logged in</a> to view this content. Thank you!</p>
		</div>

	</div>

</div>

<?php }; ?>
   
<?php get_footer(); ?>
