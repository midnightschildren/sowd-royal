<?php
/**
 * The template used for displaying page content in blog-page.php
 *
 * @package Quark
 * @since Quark 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( !is_front_page() ) { ?>
		<header class="entry-header">

		<div id="primary" class="blog_header-content row">
			
			<div class="grid-12 parent">

				
				<div class="child">
          			<h1 class="blog-title"><?php the_title(); ?></h1>
          			<p class="p_time hsblue"><?php the_date('F j, Y'); ?> / <?php the_time('g:i a'); ?></p>
          		</div>
          		
					
			

			<div class="child_image">
				<?php if ( has_post_thumbnail() && !is_search() && !post_password_required() ) { ?>
					<?php the_post_thumbnail( 'post_feature_full_width' ); ?>
				<?php } ?>
			</div>
		</div>

		</div>
		</header>
	<?php } ?>
	<div class="entry-content">
		<div class="grid-8 offset-2 pad-3-vert">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'quark' ),
				'after' => '</div>',
				'link_before' => '<span class="page-numbers">',
				'link_after' => '</span>'
			) ); ?>
		</div>
	</div><!-- /.entry-content -->
	<footer class="entry-meta">
		<?php edit_post_link( esc_html__( 'Edit', 'quark' ) . ' <i class="fa fa-angle-right" aria-hidden="true"></i>', '<div class="edit-link">', '</div>' ); ?>
	</footer><!-- /.entry-meta -->
</article><!-- /#post -->
