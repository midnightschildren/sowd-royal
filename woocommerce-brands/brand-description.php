<?php $image_size = wc_get_image_size( 'shop_catalog' ); ?>
<div class="term-description grid-8 m-grid-12 center offset-2 m-offset-0 m-pad-3-sides">

	
	<div class="text">

		<?php echo do_shortcode( wpautop( wptexturize( term_description() ) ) ); ?>
	
	</div>

</div>