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
		
		<div class="offset-1 m-offset-0 grid-10 m-grid-12 pad-3-vert pad-2-sides m-pad-3-sides">

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
	
			<h5 class="center hsblue"><?php the_field('testimonial_section_title'); ?></h5>
	
			<?php endif; ?>
			
		</div>	
		<div class="col grid-6 offset-3">
			<?php $custom_query = new WP_Query(array('post_type' => 'testimonial', 'orderby' => 'rand', 'posts_per_page' => '2'));
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

	<div id="featured" class="featured-content row">
		<div class="grid-12 pad-3-vert">
			<div class="grid-12 pad-3-top pad-2-bottom"><h5 class="center pinkorange">featured products</h5></div>
			<div class="offset-1 grid-10">
			<div class="woocommerce columns-2">
			<ul class="products">

			<?php
     $args = array( 'post_type' => 'product', 'meta_key' => '_featured','posts_per_page' => 8,'columns' => '2', 'meta_value' => 'yes' );
     $loop = new WP_Query( $args );
     while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

                        <li data-mh="my-group" <?php post_class(); ?>> 
                        <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">	
                        <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?></a>
                        <?php do_action( 'woocommerce_shop_loop_item_title' );?> 
                        <div data-mh="my-group" class="fpdesc pad-3">
                        <h6 class="center hsslate">hannah says</h6>	
                        <div class="pad-2-vert"><?php the_content();?></div>
                        	<div class="vlink">
                            	<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">View Product</a>
                           	</div> 
                        </div>        



                                
                        </li>
                <?php
            /**
             * woocommerce_pagination hook
             *
             * @hooked woocommerce_pagination - 10
             * @hooked woocommerce_catalog_ordering - 20
             */
            do_action( 'woocommerce_pagination' );
        ?>
<?php endwhile; ?>
<?php wp_reset_query(); ?>

			</ul>
			</div>		
			</div>
	</div>
</div>

<?php get_footer(); ?>
