<?php
/**
 * Show a grid of thumbnails
 */
?>
<div class="brand-page-content row">


	<?php foreach ( $brands as $index => $brand ) :

		$thumbnail = get_brand_thumbnail_url( $brand->term_id, apply_filters( 'woocommerce_brand_thumbnail_size', 'Large' ) );

		if ( ! $thumbnail )
			$thumbnail = wc_placeholder_img_src();

		$class = '';

		if ( $index == 0 || $index % $columns == 0 )
			$class = 'first';
		elseif ( ( $index + 1 ) % $columns == 0 )
			$class = 'last';

		$width = floor( ( ( 100 - ( ( $columns - 1 ) * 2 ) ) / $columns ) * 100 ) / 100;
		?>
		<div class="grid-10 m-grid-12 s-grid-12 offset-1 m-offset-0 s-offset-0 pad-3-vert m-pad-3-sides s-pad-3-sides">
		<div class="row brand-row">
		<div class="grid-6 m-grid-12 s-grid-12 pad-3  <?php echo $class; ?>">
				<a href="<?php echo get_term_link( $brand->slug, 'product_brand' ); ?>" title="<?php echo $brand->name; ?>" class="term-thumbnail">
					<img src="<?php echo $thumbnail; ?>" alt="<?php echo $brand->name; ?>" />
				</a>
		</div>
		<div class="grid-6 m-grid-12 s-grid-12 pad-3">	
			<div id="term-<?php echo $brand->term_id; ?>" class="term-description">
				<?php echo wpautop( wptexturize( $brand->description ) ); ?>
			</div>
			<div class="center pad-2-vert">
				<a href="<?php echo get_term_link( $brand->slug, 'product_brand' ); ?>" class="vp-button pad-2" title="<?php echo $brand->name; ?>"> View Products</a>
			</div>
		</div>
		</div>
		</div>
	<?php endforeach; ?>


</div>
