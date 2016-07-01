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

get_header(); 

echo do_shortcode('[product_brand_thumbnails_description class="alignright"]');

get_footer(); ?>