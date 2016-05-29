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
		
		
	

	</div><!-- /#primary.site-content.row -->

	<div id="testimonials" class="testimonial-content row">

	<div class="grid-12 pad-3-vert">	

		<div class="grid-12 pad-3-vert">
			<?php if( get_field('services_section_title') ): ?>
	
			<h5 class="center hsblue"><?php the_field('services_section_title'); ?></h5>
	
			<?php endif; ?>
			
		</div>	
		<div class="col grid-8 offset-2">
			<?php $custom_query = new WP_Query(array('post_type' => 'service', 'posts_per_page' => 0));
			while($custom_query->have_posts()) : $custom_query->the_post(); ?>
			<div class="pad-3-vert">
			
			<?php the_title(); ?>	
			<?php if( get_field('service_duration') ): ?>
			<?php the_field('service_duration'); ?> minutes $<?php the_field('service_price'); ?>
			<?php endif; ?>
			<?php the_content(); ?>
			
			<?php 	
				$content = apply_filters( 'the_content', get_the_content() );
				$content = str_replace( ']]>', ']]&gt;', $content );
				$stitle = apply_filters( 'the_title', get_the_title() );
				$stitle = str_replace( ']]>', ']]&gt;', $stitle );
				$position = get_field( "service_duration" );
				$t = '[toggle title= \'<div class=\"grid-12\">';
				$t.= $stitle;
				$t.= ', <span class=\"position\">';
				$t.= $position;
				$t.= '</span>';
				$t.= '</div>';
				$t.= '\']';
			   	$t.= $content;
			   	$t.= '[/toggle]';
			   	echo do_shortcode ($t); ?>

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
