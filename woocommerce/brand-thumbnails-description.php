<?php
/**
 * Show a grid of thumbnails
 */
?>
<div class="brand-page-content row">


	<?php 
	$i = 0;
	$c = count($brands);
	foreach ( $brands as $index => $brand ) :

		$thumbnail = get_brand_thumbnail_url( $brand->term_id, apply_filters( 'woocommerce_brand_thumbnail_size', 'Large' ) );

		if ( ! $thumbnail )
			$thumbnail = wc_placeholder_img_src();

		$class = '';

		if ( $i == 0 )
			$class = 'first';
		elseif ( $i == $c -1 )
			$class = 'last';
		$i++;
		
		$width = floor( ( ( 100 - ( ( $columns - 1 ) * 2 ) ) / $columns ) * 100 ) / 100;
		?>
		<div class="grid-10 l-grid-8 m-grid-12 s-grid-12 offset-1 l-offset-2 m-offset-0 s-offset-0 pad-3-vert m-pad-3-sides s-pad-3-sides">
		<div class="row brand-row <?php echo $class; ?>">
		<div class="grid-6 m-grid-12 s-grid-12 pad-3">
				<a href="<?php echo get_term_link( $brand->slug, 'product_brand' ); ?>" title="<?php echo $brand->name; ?>" class="term-thumbnail">
					<img src="<?php echo $thumbnail; ?>" alt="<?php echo $brand->name; ?>" />
				</a>
		</div>
		<div class="grid-6 m-grid-12 s-grid-12 pad-3">	
			<div id="term-<?php echo $brand->term_id; ?>" class="term-description">
				<?php echo wpautop( wptexturize( $brand->description ) ); ?>
			</div>
			<div class="center pad-2-vert">
				<a href="<?php echo get_term_link( $brand->slug, 'product_brand' ); ?>" class="vp-button pad-2-vert pad-3-sides" title="<?php echo $brand->name; ?>"> View Products</a>
			</div>
		</div>
		</div>
		</div>
	<?php endforeach; ?>


</div>
