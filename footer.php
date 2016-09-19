<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id #maincontentcontainer div and all content after.
 * There are also four footer widgets displayed. These will be displayed from
 * one to four columns, depending on how many widgets are active.
 *
 * @package Quark
 * @since Quark 1.0
 */
?>

		<?php	do_action( 'quark_after_woocommerce' ); ?>
	</div> <!-- /#maincontentcontainer -->

	<div id="footercontainer">

		<footer class="site-footer row" role="contentinfo">
			<div class="offset-1 grid-10 pad-3-vert footer_response">

			<?php
			// Count how many footer sidebars are active so we can work out how many containers we need
			$footerSidebars = 0;
			for ( $x=1; $x<=4; $x++ ) {
				if ( is_active_sidebar( 'sidebar-footer' . $x ) ) {
					$footerSidebars++;
				}
			}

			// If there's one or more one active sidebars, create a row and add them
			if ( $footerSidebars > 0 ) { ?>
				<?php
				// Work out the container class name based on the number of active footer sidebars
				$containerClass = "grid-6 m-grid-12 s-grid-12 pad-3-vert s-padded";

				// Display the active footer sidebars
				for ( $x=1; $x<=4; $x++ ) {
					if ( is_active_sidebar( 'sidebar-footer'. $x ) ) { ?>
						<div class="col <?php echo $containerClass?>">
							<div class="widget-area" role="complementary">
								<?php dynamic_sidebar( 'sidebar-footer'. $x ); ?>
							</div>
						</div> <!-- /.col.<?php echo $containerClass?> -->
					<?php }
				} ?>

			<?php } ?>
			</div>
		</footer> <!-- /.site-footer.row -->

		<?php if ( of_get_option( 'footer_content', quark_get_credits() ) ) {
			echo '<div class="row smallprint">';
			echo apply_filters( 'meta_content', wp_kses_post( of_get_option( 'footer_content', quark_get_credits() ) ) );
			echo '</div> <!-- /.smallprint -->';
		} ?>

	</div> <!-- /.footercontainer -->

</div> <!-- /.#wrapper.hfeed.site -->

<?php wp_footer(); ?>

<style type="text/css">

.gform_wrapper.gf_browser_chrome select {
    padding: 4px 0 4px 3px;
}
.gform_wrapper label.gfield_label {
    font-weight: 400;
    font-size: 21px;
    font-size: 1.3125em;
}
.gform_wrapper .description, .gform_wrapper .gfield_description, .gform_wrapper .gsection_description, .gform_wrapper .instruction, .gform_wrapper .field_sublabel_above .ginput_complex.ginput_container label, .gform_wrapper .field_sublabel_above div[class*=gfield_time_].ginput_container label, .gform_wrapper .field_sublabel_below .ginput_complex.ginput_container label, .gform_wrapper .field_sublabel_below div[class*=gfield_time_].ginput_container label {
    display: block;
    font-size: 13px;
	font-size: .8125rem;
	line-height: 2.46153846;
	text-transform: uppercase;
	letter-spacing: .3em;
	color: #30333c;
    white-space: nowrap;
    font-family: 'News Cycle', Helvetica, Arial, sans-serif;
}

    @media only screen and (min-device-width : 1024px) and (max-device-width : 1366px) {

        .envira-gallery-wrap .envira-gallery-public.envira-gallery-2-columns .envira-gallery-item,
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-3-columns .envira-gallery-item,
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-4-columns .envira-gallery-item,
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-5-columns .envira-gallery-item,
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-6-columns .envira-gallery-item {
            width: 25% !important
        }
    }

     @media only screen and (max-width: 780px)  {
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-2-columns .envira-gallery-item,
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-3-columns .envira-gallery-item,
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-4-columns .envira-gallery-item,
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-5-columns .envira-gallery-item,
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-6-columns .envira-gallery-item {
            width: 50% !important
        }
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-2-columns .envira-gallery-item:nth-child(3n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-2-columns .envira-gallery-item:nth-child(4n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-2-columns .envira-gallery-item:nth-child(5n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-2-columns .envira-gallery-item:nth-child(6n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-3-columns .envira-gallery-item:nth-child(3n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-3-columns .envira-gallery-item:nth-child(4n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-3-columns .envira-gallery-item:nth-child(5n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-3-columns .envira-gallery-item:nth-child(6n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-4-columns .envira-gallery-item:nth-child(3n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-4-columns .envira-gallery-item:nth-child(4n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-4-columns .envira-gallery-item:nth-child(5n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-4-columns .envira-gallery-item:nth-child(6n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-5-columns .envira-gallery-item:nth-child(3n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-5-columns .envira-gallery-item:nth-child(4n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-5-columns .envira-gallery-item:nth-child(5n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-5-columns .envira-gallery-item:nth-child(6n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-6-columns .envira-gallery-item:nth-child(3n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-6-columns .envira-gallery-item:nth-child(4n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-6-columns .envira-gallery-item:nth-child(5n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-6-columns .envira-gallery-item:nth-child(6n+1) {
            clear: none !important
        }
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-2-columns .envira-gallery-item:nth-child(2n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-3-columns .envira-gallery-item:nth-child(2n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-4-columns .envira-gallery-item:nth-child(2n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-5-columns .envira-gallery-item:nth-child(2n+1),
        .envira-gallery-wrap .envira-gallery-public.envira-gallery-6-columns .envira-gallery-item:nth-child(2n+1) {
            clear: both !important
        }
        .envira-gallery-wrap .envira-gallery-public.enviratope .envira-gallery-item {
            clear: none !important
        }
    }



 
</style>

<script>
jQuery(document).ready(function() {
	jQuery("#headercontainer").sticky({
		topSpacing: 0,
		zIndex: '999'
	});

	jQuery('.ucol').matchHeight();
});

jQuery(window).resize(function() {
	

    jQuery('.featured').matchHeight();
	
});


</script>


</body>
</html>
