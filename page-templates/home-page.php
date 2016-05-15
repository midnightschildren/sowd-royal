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
		
	</div><!-- /#primary.site-content.row -->

<?php get_footer(); ?>
