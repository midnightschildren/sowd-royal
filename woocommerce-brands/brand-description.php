<?php $image_size = wc_get_image_size( 'shop_catalog' ); ?>
<div class="term-description grid-8 l-grid-6 m-grid-12 s-grid-12 center offset-2 l-offset-3 m-offset-0 s-offset-0 m-pad-3-sides s-pad-3-sides">

	
	<div class="text">

		<?php echo do_shortcode( wpautop( wptexturize( term_description() ) ) ); ?>
	
	</div>

</div>