<?php
/**
 * The template for displaying 404 pages (Not Found).
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

	<div class="grid-12 l-grid-10 l-offset-1 pad-4-vert">
			<div class="grid-8 offset-2">
			<article id="post-0" class="post error404 no-results not-found center">
				<header class="entry-header">
					<h1 class="entry-title"><i class="fa fa-frown-o fa-lg"></i> <?php esc_html_e( 'Uh Oh! This is somewhat embarrassing!', 'quark' ); ?></h1>
				</header>
				<div class="entry-content">
					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'quark' ); ?></p>
<form role="search" method="get" class="search-form_404" action="<?php echo home_url( '/' ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
        <input type="search" class="search-field" style="margin: 0 auto;"
            placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    </label>

</form>
				</div><!-- /.entry-content -->
			</article><!-- /#post -->
		</div>
		</div> <!-- /.col.grid_12_of_12 -->
	</div>
	

<?php get_footer(); ?>
