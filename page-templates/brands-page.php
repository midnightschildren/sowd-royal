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

<div class="brand-title-content row">
	<div class="grid-12 pad-3-vert">
		<a href="http://hannahsowdinc.wpengine.com/shop/">Shop</a> / Brands
		<h1 class="center shop-title"><?php the_title(); ?></h1>
	</div>	
</div>	

<?php echo do_shortcode('[btc class="alignright"]');

get_footer(); ?>