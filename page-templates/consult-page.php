<?php
/**
 * Template Name: Consult Page Template
 *
 * Description: Displays a full-width page, with no sidebar. This template is great for pages
 * containing large amounts of content.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

<?php
global $product;
if(is_user_logged_in() && has_bought()) {
	 
	echo '<p>test - bought item</p>';

 };

if(is_user_logged_in() && !has_bought()) { ?>

		<div id="primary" class="site-content row" role="main">

			<div class="grid-12">
				<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '78' ); } ?>

				<h5 class="center medium hsslate">Please purchase the <a href="/shop/uncategorized/online-skin-care-consultation/">Virtual Online Consult</a> to view this content. Thank you!</h5>
			</div>

		</div>

	<?php };    

if(!is_user_logged_in()) { ?> 
    
<div id="primary" class="site-content row" role="main">

	<div class="grid-12">
		<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '78' ); } ?>

		<h5 class="center medium hsslate">You must be logged in to view this content. Thank you!</h5>
	</div>

</div>

<?php }; ?>
   
<?php get_footer(); ?>
