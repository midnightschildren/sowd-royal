<?php
/**
 * Template Name: Brand Page Template
 * The Template for displaying products in a brands category. 
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce;

get_header(); ?>

<div class="product-menu-content row">
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
</div>
<div class="brand-title-content row">
	<div class="grid-12 pad-3-vert s-pad-3-sides">
		<div class="center brand_bc pad-3-bottom"><a href="https://hannahsowd.com/shop/">Shop</a> / Brands</div>
		<h1 class="center shop-title pad-2-bottom"><?php the_title(); ?></h1>
	</div>	
</div>	

<?php echo do_shortcode('[btc class="alignright"]'); ?>

<div class="footer-menu-content row">
	<div class="pad-3-vert grid-10 offset-1 center border-rule-footer">
	<nav id="product-navigation" class="main-navigation" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-menu' ) ); ?>
	</nav>	
	</div>
</div>

<?php get_footer(); ?>