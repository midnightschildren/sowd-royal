<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

	<div id="primary" class="blog-content row">

		<div class="grid-12 pad-3-vert">
			<?php if( get_field('blog_section_title', 23) ): ?>
	
			<h5 class="center medium pad-3-vert"><?php the_field('blog_section_title', 23); ?></h5>
	
			<?php endif; ?>
			
		</div>	
			

	</div><!-- /#primary.site-content.row -->

	<div id="primary" class="blog-posts-content row" role="main">

			<div class="col grid-12">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'blog' ); ?>
					<div class="grid-8 offset-2 pad-3-vert">
					<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) {
						comments_template( '', true );
					}
					?>

					<?php quark_content_nav( 'nav-below' ); ?>
					</div>

				<?php endwhile; // end of the loop. ?>

			</div> <!-- /.col.grid_8_of_12 -->
			<?php get_sidebar(); ?>

	</div> <!-- /#primary.site-content.row -->

<?php get_footer(); ?>
