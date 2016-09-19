<?php
/**
 * Template Name: Services Page Template
 *
 * Description: Displays a full-width page, with no sidebar. This template is great for pages
 * containing large amounts of content.
 *
 * @package Quark
 * @since Quark 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content row" role="main">

<div class="desktop_gal">
	<div class="grid-12">
		<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '34' ); } ?>
	</div>	
</div>
<div class="mobile_gal">
	<div class="grid-12">
		<?php if ( function_exists( 'envira_gallery' ) ) { envira_gallery( '2022' ); } ?>
	</div>	
</div>		
	

	</div><!-- /#primary.site-content.row -->

	<div id="services" class="services-content row">

	<div class="grid-12 pad-3-vert">	

		<div class="grid-12 pad-3-vert">
			<?php if( get_field('services_section_title') ): ?>
	
			<h5 class="center medium hsslate"><?php the_field('services_section_title'); ?></h5>
	
			<?php endif; ?>
			
		</div>	
		<div class="col grid-8 m-grid-12 s-grid-12 offset-2 m-offset-0 m-pad-3-sides s-pad-2-sides">
			<?php $custom_query = new WP_Query(array('post_type' => 'service', 'posts_per_page' => 0, 'orderby' => 'menu_order', 'order' => 'ASC'  ));
			while($custom_query->have_posts()) : $custom_query->the_post(); ?>
			<div class="pad-3-top pad-2-bottom">

			
			<?php 	
				$content = apply_filters( 'the_content', get_the_content() );
				$content = str_replace( ']]>', ']]&gt;', $content );
				$stitle = apply_filters( 'the_title', get_the_title() );
				$stitle = str_replace( ']]>', ']]&gt;', $stitle );
				$duration = null;
				if (get_field("service_duration")) {
				$duration .= '<span class=\"duration\">';	
				$duration .= get_field( "service_duration" );
				$duration .= ' minutes</span>';
				}
				$price = null;
				if (get_field("service_price")) {
				$price .= ' <span class=\"price\">$';	
				$price .= get_field( "service_price" );
				$price .= '</span>';
				}
				$htmllink = null;
				if (get_field( "service_link" )) {
				$link = get_field( "service_link" );
				$linktext = get_field( "service_link_text" );
				$htmllink = "<p class='book'><a href='{$link}' target='_blank'>$linktext</a></p>";
				}

				if (get_field( "service_link_2" )) {
				$link2 = get_field( "service_link_2" );
				$linktext2 = get_field( "service_link_text_2" );
				$htmllink .= "<p class='book pad-2-top'><a href='{$link2}' target='_blank'>$linktext2</a></p>";
				}

				if (get_field( "service_link_3" )) {
				$link3 = get_field( "service_link_3" );
				$linktext3 = get_field( "service_link_text_3" );
				$htmllink .= "<p class='book pad-2-top'><a href='{$link3}' target='_blank'>$linktext3</a></p>";
				}

				$t = '[toggle title= \'<div class=\"grid-12\"><div class=\"grid-9 m-grid-12 s-grid-12\"><h4>';
				$t.= $stitle;
				$t.= '</h4></div><div class=\"grid-3 m-grid-6 s-grid-8 right m-left s-left\">';
				$t.= $duration;
				$t.= $price;
				$t.= '</div></div>';
				$t.= '\']';
			   	$t.= $content;
			   	$t.= $htmllink;
			   	$t.= '[/toggle]';
			   	echo do_shortcode ($t); ?>

			</div>
			
			<?php endwhile; ?>
			<?php wp_reset_postdata(); // reset the query ?>

		</div>

	</div>
		
	</div>

	<div class="business-content row">

		<div class="grid-8 s-grid-12 offset-2 s-offset-0 s-pad-2-sides pad-3-vert center">

		<?php if( get_field('services_section_2_title') ): ?>
	
			<h5 class="hsslate pad-2-vert"><?php the_field('services_section_2_title'); ?></h5>
	
		<?php endif; ?>	

		<?php if( get_field('services_section_2_content') ): ?>
	
			<div class="hours"><?php the_field('services_section_2_content'); ?></div>
	
		<?php endif; ?>	

		<?php if( get_field('services_section_2_sub_content') ): ?>
	
			<div class="b_info"><?php the_field('services_section_2_sub_content'); ?></div>
	
		<?php endif; ?>	

		<?php if( get_field('services_section_2b_title') ): ?>
	
			<h5 class="hsslate pad-2-vert"><?php the_field('services_section_2b_title'); ?></h5>
	
		<?php endif; ?>	

		<?php if( get_field('services_section_2b_content') ): ?>
	
			<div class="hours"><?php the_field('services_section_2b_content'); ?></div>
	
		<?php endif; ?>	

		</div>	

	</div>	

	<div id="secondaryimage">
		<?php 

		$image = get_field('second_page_image');

		if( !empty($image) ): ?>
		<div class="grid-12">

			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
		</div>	
		<?php endif; ?>
	</div>	

<?php get_footer(); ?>
