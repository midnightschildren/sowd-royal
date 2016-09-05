<?php
/**
 * The template for displaying Search Results.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

	<div id="primary" class="about-content row" role="main">


	

		<div class="grid-8 m-grid-12 offset-2 m-offset-0 pad-3-vert m-pad-3-sides">

			<?php query_posts($query_string . '&showposts=3');
				if ( have_posts() ) : ?>

				
				<div class="pad-3-vert">
					<h5 class="center medium hsslate"><?php printf( esc_html__( 'Search Results for: %s', 'quark' ), '<span>&ldquo;' . get_search_query() . '&rdquo;</span>' ); ?></h5>
				</div>
				

				<?php // Start the Loop ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>

				<?php quark_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results' ); // Include the template that displays a message that posts cannot be found ?>

			<?php endif; wp_reset_query(); // end have_posts() check ?>

		</div> <!-- /.col.grid_8_of_12 -->
	
	

	</div> <!-- /#primary.site-content.row -->

<?php get_footer(); ?>
