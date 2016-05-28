<?php
/**
 * Template Name: Services Page Template
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
		<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '34' ); } ?>
	</div>	
		
		<div class="offset-1 grid-10 pad-3-vert pad-2-sides">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'quark' ),
					'after' => '</div>',
					'link_before' => '<span class="page-numbers">',
					'link_after' => '</span>'
					) ); ?>
				</div><!-- /.entry-content -->
	
				</article><!-- /#post -->		
				<?php endwhile; // end of the loop. ?>

			<?php endif; // end have_posts() check ?>

		</div> <!-- /.col.grid_12_of_12 -->
	
	

	</div><!-- /#primary.site-content.row -->

	<div id="testimonials" class="testimonial-content row">

	<div class="grid-12 pad-3-vert">	

		<div class="grid-12 pad-3-vert">
			<?php if( get_field('services_section_title') ): ?>
	
			<h5 class="center hsblue"><?php the_field('services_section_title'); ?></h5>
	
			<?php endif; ?>
			
		</div>	
		<div class="col grid-6 offset-3">
			<?php $custom_query = new WP_Query(array('post_type' => 'testimonial', 'posts_per_page' => 0));
			while($custom_query->have_posts()) : $custom_query->the_post(); ?>
			<div class="pad-3-vert">
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<?php the_content(); ?>
			<?php if( get_field('testimonial_author') ): ?>
			<h6 class="hsgray"><a href="http://www.genbook.com/bookings/slot/reservation/30051977/reviews/?bookingSourceId=1000"><?php the_field('testimonial_author'); ?> — customer since <?php the_field('testimonial_date'); ?></a></h6>
			<?php endif; ?>

			</div>
			</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); // reset the query ?>

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
