<?php
/**
 * Template Name: Utility Page Template
 *
 * Description: Displays a full-width page, with no sidebar. This template is great for pages
 * containing large amounts of content.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

	<div id="primary" class="product-menu-content row" role="main">
		<div class="pad-3-vert grid-10 offset-1 center">
			<nav id="product-navigation" class="main-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>	
		</div>

	</div><!-- /#primary.site-content.row -->

	<div id="services" class="site-content row">

	<div class="grid-12 pad-3-vert">	

		<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

		<div class="grid-12 pad-3-vert">
			
	
			<h1 class="center"><?php the_title(); ?></h1>
	
			
		</div>	
		<div class="grid-8 offset-2 pad-3-vert">

			<?php the_content(); ?>	

		</div>

	</div>

		<?php endwhile; // end of the loop. ?>

		<?php endif; // end have_posts() check ?>
		
	</div>	
	<div class="footer-menu-content row">
		<div class="pad-3-vert grid-10 offset-1 center border-rule-footer">
		<nav id="product-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-menu' ) ); ?>
		</nav>	
		</div>
	</div>

<?php get_footer(); ?>
