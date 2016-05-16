<?php
/**
 * Template Name: Home Page Template
 *
 * Description: Displays a full-width page, with no sidebar. This template is great for pages
 * containing large amounts of content.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content row" role="main">
		
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
	
	<div id="secondaryimage">
		<?php 

		$image = get_field('second_page_image');

		if( !empty($image) ): ?>

			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

		<?php endif; ?>
	</div>	

	</div><!-- /#primary.site-content.row -->

	<div id="testimonials" class="testimonial-content row">

	<div class="grid-12 pad-3-vert">	

		<div class="grid-12 pad-3-vert">
			<?php if( get_field('testimonial_section_title') ): ?>
	
			<h4 class="center"><?php the_field('testimonial_section_title'); ?></h4>
	
			<?php endif; ?>
			
		</div>	
		<div class="col grid-12 pad-3-vert">
			<?php $custom_query = new WP_Query(array('post_type' => 'testimonial', 'posts_per_page' => 0));
			while($custom_query->have_posts()) : $custom_query->the_post(); ?>

			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2 class="eccWhite"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php the_content(); ?>

			</div>

			<?php endwhile; ?>
			<?php wp_reset_postdata(); // reset the query ?>

		</div>

	</div>
		
	</div>	

<?php get_footer(); ?>
