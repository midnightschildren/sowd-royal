<?php $image_size = wc_get_image_size( 'shop_catalog' ); ?>
<div class="term-description grid-8 center offset-2">

	
	<div class="text">

		<?php echo do_shortcode( wpautop( wptexturize( term_description() ) ) ); ?>
	
	</div>

</div>