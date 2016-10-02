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
			<div class="pad-3-vert grid-10 s-grid-12 offset-1 s-offset-0 s-pad-2 center">
	<div class="desk_product_menu">	
	<nav id="product-navigation" class="main-navigation" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_class' => 'nav-menu' ) ); ?>
	</nav>
	</div>
	<div class="rep_product_menu">
	<nav id="product-navigation" class="main-navigation" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'responsive', 'menu_class' => 'nav-menu' ) ); ?>
	</nav>
	</div>	
	</div>

	</div><!-- /#primary.site-content.row -->

	<div id="services" class="site-content row">

	<div class="grid-12 l-grid-10 l-offset-1 pad-3-vert">	
		<div class="center brand_bc pad-3-bottom"><a href="http://hannahsowdinc.wpengine.com/shop/">Shop</a> / <?php the_title(); ?></div>
		<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

		<div class="grid-12 pad-3-vert">
			
	
			<h1 class="center"><?php the_title(); ?></h1>
	
			
		</div>	
		<div class="grid-10 m-grid-12 s-grid-12 offset-1 m-offset-0 s-offset-0 pad-3-vert m-pad-3-sides s-pad-2-sides">

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
