<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

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

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<?php if (is_shop()) { ?>

			<div class="shop-content-top row">

				<div id="secondaryimage">
					<?php 

					$image = get_field('second_page_image', 21);

					if( !empty($image) ): ?>
						<div class="grid-12 pad-3-bottom">
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						</div>	
					<?php endif; ?>
				</div>	

					<?php if( get_field('shop_title', 21) ): ?>
						<div class="grid-12 pad-4-vert s-pad-2-vert s-pad-3-sides">
							<h1 class="center shop-title"><?php the_field('shop_title', 21); ?></h1>
						</div>
					<?php endif; ?>

					<?php if( get_field('shop_description', 21) ): ?>

						<div class="grid-8 m-grid-12 s-grid-12 offset-2 m-offset-0 s-offset-0 pad-3-top pad-4-bottom m-pad-3-sides s-pad-3-sides">
	
							<p class="center shop-description pad-4-bottom s-padded-bottom"><?php the_field('shop_description', 21); ?></p>

						</div>
	
					<?php endif; ?>
				

			<?php } else { ?>
			<div class="shop-content-top row">
				<div class="center brand_bc pad-3-top"><?php woocommerce_breadcrumb(); ?></div>
				<h1 class="center page-title pad-2-top pad-3-bottom"><?php woocommerce_page_title(); ?></h1>
				


		<?php } endif; ?>
		
		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>
		</div>
		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
<div class="online-consult-content row">
	<div class="grid-12 pad-3-vert">
	<div class="grid-12 s-grid-10 s-offset-1 pad-4-vert s-pad-2-vert center">

		<?php if( get_field('consult_section_title', 21) ): ?>
	
			<h5 class="center hsblue"><?php the_field('consult_section_title', 21); ?></h5>
	
			<?php endif; ?>
	</div>

	<div class="pad-3-vert grid-8 m-grid-12 s-grid-12 offset-2 m-offset-0 s-offset-0 m-pad-3-sides s-pad-3-sides">

		<div class="grid-2 m-grid-4 s-grid-10 offset-1 m-offset-4 s-offset-1 flow-opposite m-padded-bottom s-padded-bottom" id="headshot">
					<?php 

					$image = get_field('headshot', 21);

					if( !empty($image) ): ?>
						<div class="pad-3-bottom">
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						</div>	
					<?php endif; ?>
		</div>

		<div class="grid-8 m-grid-12 s-grid-12 pad-3-bottom flow-opposite">
			<?php if( get_field('consult_section_intro', 21) ): ?>
	
			<p><?php the_field('consult_section_intro', 21); ?></p>
	
			<?php endif; ?>
		</div>



		<div class="grid-12 pad-3-vert center">
			<div class="clink">
				<a href="/shop/uncategorized/online-skin-care-consultation/">get started</a>
			</div>	

		</div>	
	</div>	

	</div>	
</div>	
<div class="footer-menu-content row">
	<div class="pad-3-vert grid-10 s-grid-12 offset-1 s-offset-0 s-pad-3-sides center border-rule-footer">
	<nav id="product-navigation" class="main-navigation" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-menu' ) ); ?>
	</nav>	
	</div>
</div>

<?php get_footer( 'shop' ); ?>
