<?php
/**
 * Quark functions and definitions
 *
 * @package Quark
 * @since Quark 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Quark 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 790; /* Default the embedded content width to 790px */



remove_filter(‘the_content’, ‘wptexturize’);


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Quark 1.0
 *
 * @return void
 */
if ( ! function_exists( 'quark_setup' ) ) {
	function quark_setup() {
		global $content_width;

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on Quark, use a find and replace
		 * to change 'quark' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'quark', trailingslashit( get_template_directory() ) . 'languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );

		// Create an extra image size for the Post featured image
		add_image_size( 'post_feature_full_width', 1000, 1000, true );

		// This theme uses wp_nav_menu() in one location
		register_nav_menus( array(
				'primary' => esc_html__( 'Primary Menu', 'quark' ),
				'secondary' => esc_html__( 'Product Menu', 'quark' ),
				'footer' => esc_html__( 'Footer Nav Menu', 'quark' )
			) );

		// This theme supports a variety of post formats
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

        add_filter('pre_get_posts', 'query_post_type');
        function query_post_type($query) {
          if(is_category() || is_tag() || is_home() && empty( $query->query_vars['suppress_filters'] ) ) {
            $post_type = get_query_var('post_type');
        	if($post_type)
        	    $post_type = $post_type;
        	else
        	    $post_type = array('post');
            $query->set('post_type',$post_type);
        	return $query;
            }
        } 


		// Add theme support for HTML5 markup for the search forms, comment forms, comment lists, gallery, and caption
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		// Enable support for Custom Backgrounds
		add_theme_support( 'custom-background', array(
				// Background color default
				'default-color' => 'fff',
				// Background image default
				'default-image' => trailingslashit( get_template_directory_uri() ) . 'images/faint-squares.jpg'
			) );

		// Enable support for Custom Headers (or in our case, a custom logo)
		add_theme_support( 'custom-header', array(
				// Header image default
				'default-image' => trailingslashit( get_template_directory_uri() ) . 'images/logo.png',
				// Header text display default
				'header-text' => false,
				// Header text color default
				'default-text-color' => '000',
				// Flexible width
				'flex-width' => true,
				// Header image width (in pixels)
				'width' => 300,
				// Flexible height
				'flex-height' => true,
				// Header image height (in pixels)
				'height' => 80
			) );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Enable support for WooCommerce
		add_theme_support( 'woocommerce' );

		// Enable support for Theme Options.
		// Rather than reinvent the wheel, we're using the Options Framework by Devin Price, so huge props to him!
		// http://wptheming.com/options-framework-theme/
		if ( !function_exists( 'optionsframework_init' ) ) {
			define( 'OPTIONS_FRAMEWORK_DIRECTORY', trailingslashit( get_template_directory_uri() ) . 'inc/' );
			require_once trailingslashit( dirname( __FILE__ ) ) . 'inc/options-framework.php';

			// Loads options.php from child or parent theme
			$optionsfile = locate_template( 'options.php' );
			load_template( $optionsfile );
		}

		// If WooCommerce is running, check if we should be displaying the Breadcrumbs
		if( quark_is_woocommerce_active() && !of_get_option( 'woocommerce_breadcrumbs', '1' ) ) {
			add_action( 'init', 'quark_remove_woocommerce_breadcrumbs' );
		}
	}
}
add_action( 'after_setup_theme', 'quark_setup' );

/**
 * Remove Howdy Text + Customize menu
 *
 * @since Quark 1.3
 *
 * @return void
 */


add_filter('admin_bar_menu','change_howdy_text_toolbar');
function change_howdy_text_toolbar($wp_admin_bar)
{
	$getgreetings = $wp_admin_bar->get_node('my-account');
	$rpctitle = str_replace('Howdy,','',$getgreetings->title);
	$wp_admin_bar->add_node(array("id"=>"my-account","title"=>$rpctitle));
}

add_action( 'admin_bar_menu', 'remove_some_nodes_from_admin_top_bar_menu', 999 );
function remove_some_nodes_from_admin_top_bar_menu( $wp_admin_bar ) {
    $wp_admin_bar->remove_menu( 'customize' );
}

/**
 * Enable backwards compatability for title-tag support
 *
 * @since Quark 1.3
 *
 * @return void
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function quark_slug_render_title() { ?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php }
	add_action( 'wp_head', 'quark_slug_render_title' );
}


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of PT Sans and Arvo by default is localized. For languages that use characters not supported by the fonts, the fonts can be disabled.
 *
 * @since Quark 1.2.5
 *
 * @return string Font stylesheet or empty string if disabled.
 */
if ( ! function_exists( 'quark_fonts_url' ) ) {
	function quark_fonts_url() {
		$fonts_url = '';
		$subsets = 'latin';

		/* translators: If there are characters in your language that are not supported by PT Sans, translate this to 'off'.
		 * Do not translate into your own language.
		 */
		$pt_sans = _x( 'on', 'PT Sans font: on or off', 'quark' );

		/* translators: To add an additional PT Sans character subset specific to your language, translate this to 'greek', 'cyrillic' or 'vietnamese'.
		 * Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'PT Sans font: add new subset (cyrillic)', 'quark' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic';

		/* translators: If there are characters in your language that are not supported by Arvo, translate this to 'off'.
		 * Do not translate into your own language.
		 */
		$arvo = _x( 'on', 'Arvo font: on or off', 'quark' );

		if ( 'off' !== $pt_sans || 'off' !== $arvo ) {
			$font_families = array();

			if ( 'off' !== $pt_sans )
				$font_families[] = 'PT+Sans:400,400italic,700,700italic';

			if ( 'off' !== $arvo )
				$font_families[] = 'Arvo:400';

			$protocol = is_ssl() ? 'https' : 'http';
			$query_args = array(
				'family' => implode( '|', $font_families ),
				'subset' => $subsets,
			);
			$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
		}

		return $fonts_url;
	}
}

/**
* Remove image links on all Envira Gallery images if the Lightbox is disabled for mobile devices
*
* @since 1.0.0
*/
function envira_gallery_remove_image_links_mobile( $item, $id, $data, $i ) {

	// Don't do anything if we're not on a mobile device
//	if ( ! wp_is_mobile() ) {
//		return $item;
//	}

	// Don't do anything if the Lightbox is enabled on mobile
	if ( Envira_Gallery_Shortcode::get_instance()->get_config( 'mobile_lightbox', $data ) ) {
		return $item;
	}

	// Remove the link from the image and return
	$item['link'] = '';
	return $item;

}

add_filter( 'envira_gallery_output_item_data', 'envira_gallery_remove_image_links_mobile', 10, 4 );


/**
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @since Quark 1.2.5
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string The filtered CSS paths list.
 */
function quark_mce_css( $mce_css ) {
	$fonts_url = quark_fonts_url();

	if ( empty( $fonts_url ) ) {
		return $mce_css;
	}

	if ( !empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $fonts_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'quark_mce_css' );


/**
 * Register widgetized areas
 *
 * @since Quark 1.0
 *
 * @return void
 */
if ( ! function_exists( 'quark_widgets_init' ) ) {
	function quark_widgets_init() {
		register_sidebar( array(
				'name' => esc_html__( 'Main Sidebar', 'quark' ),
				'id' => 'sidebar-main',
				'description' => esc_html__( 'Appears in the sidebar on posts and pages except the optional Front Page template, which has its own widgets', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Blog Sidebar', 'quark' ),
				'id' => 'sidebar-blog',
				'description' => esc_html__( 'Appears in the sidebar on the blog and archive pages only', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Single Post Sidebar', 'quark' ),
				'id' => 'sidebar-single',
				'description' => esc_html__( 'Appears in the sidebar on single posts only', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Page Sidebar', 'quark' ),
				'id' => 'sidebar-page',
				'description' => esc_html__( 'Appears in the sidebar on pages only', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'First Front Page Banner Widget', 'quark' ),
				'id' => 'frontpage-banner1',
				'description' => esc_html__( 'Appears in the banner area on the Front Page', 'quark' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Second Front Page Banner Widget', 'quark' ),
				'id' => 'frontpage-banner2',
				'description' => esc_html__( 'Appears in the banner area on the Front Page', 'quark' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'First Front Page Widget Area', 'quark' ),
				'id' => 'sidebar-homepage1',
				'description' => esc_html__( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Second Front Page Widget Area', 'quark' ),
				'id' => 'sidebar-homepage2',
				'description' => esc_html__( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Third Front Page Widget Area', 'quark' ),
				'id' => 'sidebar-homepage3',
				'description' => esc_html__( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Fourth Front Page Widget Area', 'quark' ),
				'id' => 'sidebar-homepage4',
				'description' => esc_html__( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'First Footer Widget Area', 'quark' ),
				'id' => 'sidebar-footer1',
				'description' => esc_html__( 'Appears in the footer sidebar', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Second Footer Widget Area', 'quark' ),
				'id' => 'sidebar-footer2',
				'description' => esc_html__( 'Appears in the footer sidebar', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Third Footer Widget Area', 'quark' ),
				'id' => 'sidebar-footer3',
				'description' => esc_html__( 'Appears in the footer sidebar', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );

		register_sidebar( array(
				'name' => esc_html__( 'Fourth Footer Widget Area', 'quark' ),
				'id' => 'sidebar-footer4',
				'description' => esc_html__( 'Appears in the footer sidebar', 'quark' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			) );
	}
}
add_action( 'widgets_init', 'quark_widgets_init' );

/**
 * BOP Search Box
 *
 * @since Sowd 1.0
 *
 * Hide Submit button  for search
 */

add_filter( 'bop_nav_search_show_submit_button', function( $bool, $item, $depth, $args ){
  $bool = false;
  return $bool;
}, 10, 4 );

/**
 * SVG
 *
 * @since Sowd 1.0
 *
 * 
 */

function cc_mime_types( $mimes ){
$mimes['svg'] = 'image/svg+xml';
return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );


/**
 * Enqueue scripts and styles
 *
 * @since Quark 1.0
 *
 * @return void
 */
if ( ! function_exists( 'quark_scripts_styles' ) ) {
	function quark_scripts_styles() {

		/**
		 * Register and enqueue our stylesheets
		 */

		// Start off with a clean base by using normalise. If you prefer to use a reset stylesheet or something else, simply replace this
		wp_register_style( 'normalize', trailingslashit( get_template_directory_uri() ) . 'css/normalize.css' , array(), '4.1.1', 'all' );
		wp_enqueue_style( 'normalize' );

		// Register and enqueue our icon font
		// We're using the awesome Font Awesome icon font. http://fortawesome.github.io/Font-Awesome
		wp_register_style( 'fontawesome', trailingslashit( get_template_directory_uri() ) . 'css/font-awesome.min.css' , array( 'normalize' ), '4.6.3', 'all' );
		wp_enqueue_style( 'fontawesome' );

		// Our styles for setting up the grid.
		// If you prefer to use a different grid system, simply replace this and perform a find/replace in the php for the relevant styles. I'm nice like that!
		wp_register_style( 'gridsystem', trailingslashit( get_template_directory_uri() ) . 'css/grid.css' , array( 'fontawesome' ), '1.0.0', 'all' );
		wp_enqueue_style( 'gridsystem' );

		/*
		 * Load our Google Fonts.
		 *
		 * To disable in a child theme, use wp_dequeue_style()
		 * function mytheme_dequeue_fonts() {
		 *     wp_dequeue_style( 'quark-fonts' );
		 * }
		 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
		 */
		$fonts_url = quark_fonts_url();
		if ( !empty( $fonts_url ) ) {
			wp_enqueue_style( 'quark-fonts', esc_url_raw( $fonts_url ), array(), null );
		}

		// If using a child theme, auto-load the parent theme style.
		// Props to Justin Tadlock for this recommendation - http://justintadlock.com/archives/2014/11/03/loading-parent-styles-for-child-themes
		if ( is_child_theme() ) {
			wp_enqueue_style( 'parent-style', trailingslashit( get_template_directory_uri() ) . 'style.css' );
		}

		// Enqueue the default WordPress stylesheet
		wp_enqueue_style( 'style', get_stylesheet_uri() , false , filemtime( get_stylesheet_directory() . '/style.css' ) );



		/**
		 * Register and enqueue our scripts
		 */

		// Load Modernizr at the top of the document, which enables HTML5 elements and feature detects
		wp_register_script( 'modernizr', trailingslashit( get_template_directory_uri() ) . 'js/modernizr-min.js', array(), '3.3.1', false );
		wp_enqueue_script( 'modernizr' );

		// Load Stick.js & matchHeight.js for Sowd-royal
		wp_register_script( 'sticky', trailingslashit( get_template_directory_uri() ) . 'js/jquery.sticky.js', array('jquery'), '1.0.4', true );
		wp_enqueue_script( 'sticky' );
		wp_register_script( 'match', trailingslashit( get_template_directory_uri() ) . 'js/jquery.matchHeight.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'match' );
		// Adds JavaScript to pages with the comment form to support sites with threaded comments (when in use)
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Load jQuery Validation as well as the initialiser to provide client side comment form validation
		// You can change the validation error messages below
		if ( is_singular() && comments_open() ) {
			wp_register_script( 'validate', trailingslashit( get_template_directory_uri() ) . 'js/jquery.validate.min.1.13.0.js', array( 'jquery' ), '1.13.0', true );
			wp_register_script( 'commentvalidate', trailingslashit( get_template_directory_uri() ) . 'js/comment-form-validation.js', array( 'jquery', 'validate' ), '1.13.0', true );

			wp_enqueue_script( 'commentvalidate' );
			wp_localize_script( 'commentvalidate', 'comments_object', array(
				'req' => get_option( 'require_name_email' ),
				'author'  => esc_html__( 'Please enter your name', 'quark' ),
				'email'  => esc_html__( 'Please enter a valid email address', 'quark' ),
				'comment' => esc_html__( 'Please add a comment', 'quark' ) )
			);
		}

		// Include this script to envoke a button toggle for the main navigation menu on small screens
		//wp_register_script( 'small-menu', trailingslashit( get_template_directory_uri() ) . 'js/small-menu.js', array( 'jquery' ), '20130130', true );
		//wp_enqueue_script( 'small-menu' );

	}

}
add_action( 'wp_enqueue_scripts', 'quark_scripts_styles' );

/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Quark 1.0
 *
 * @param string html ID
 * @return void
 */
if ( ! function_exists( 'quark_content_nav' ) ) {
	function quark_content_nav( $nav_id ) {
		global $wp_query;
		$big = 999999999; // need an unlikely integer

		$nav_class = 'site-navigation paging-navigation';
		if ( is_single() ) {
			$nav_class = 'site-navigation post-navigation nav-single';
		}
		?>
		<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
			<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'quark' ); ?></h3>

			<?php if ( is_single() ) { // navigation links for single posts ?>

				<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '<i class="fa fa-angle-left" aria-hidden="true"></i>', 'Previous post link', 'quark' ) . '</span> %title' ); ?>
				<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '<i class="fa fa-angle-right" aria-hidden="true"></i>', 'Next post link', 'quark' ) . '</span>' ); ?>

			<?php }
			elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) { // navigation links for home, archive, and search pages ?>

				<?php echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var( 'paged' ) ),
					'total' => $wp_query->max_num_pages,
					'type' => 'list',
					'prev_text' => wp_kses( __( '<i class="fa fa-angle-left" aria-hidden="true"></i> Previous', 'quark' ), array( 'i' => array(
						'class' => array(), 'aria-hidden' => array() ) ) ),
					'next_text' => wp_kses( __( 'Next <i class="fa fa-angle-right" aria-hidden="true"></i>', 'quark' ), array( 'i' => array(
						'class' => array(), 'aria-hidden' => array() ) ) )
				) ); ?>

			<?php } ?>

		</nav><!-- #<?php echo $nav_id; ?> -->
		<?php
	}
}


/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own quark_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 * (Note the lack of a trailing </li>. WordPress will add it itself once it's done listing any children and whatnot)
 *
 * @since Quark 1.0
 *
 * @param array Comment
 * @param array Arguments
 * @param integer Comment depth
 * @return void
 */
if ( ! function_exists( 'quark_comment' ) ) {
	function quark_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) {
		case 'pingback' :
		case 'trackback' :
			// Display trackbacks differently than normal comments ?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="pingback">
					<p><?php esc_html_e( 'Pingback:', 'quark' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'quark' ), '<span class="edit-link">', '</span>' ); ?></p>
				</article> <!-- #comment-##.pingback -->
			<?php
			break;
		default :
			// Proceed with normal comments.
			global $post; ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<header class="comment-meta comment-author vcard">
						<?php
						echo get_avatar( $comment, 44 );
						printf( '<cite class="fn">%1$s %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span> ' . esc_html__( 'Post author', 'quark' ) . '</span>' : '' );
						printf( '<a href="%1$s" title="Posted %2$s"><time itemprop="datePublished" datetime="%3$s">%4$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							sprintf( esc_html__( '%1$s @ %2$s', 'quark' ), esc_html( get_comment_date() ), esc_attr( get_comment_time() ) ),
							get_comment_time( 'c' ),
							/* Translators: 1: date, 2: time */
							sprintf( esc_html__( '%1$s at %2$s', 'quark' ), get_comment_date(), get_comment_time() )
						);
						?>
					</header> <!-- .comment-meta -->

					<?php if ( '0' == $comment->comment_approved ) { ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'quark' ); ?></p>
					<?php } ?>

					<section class="comment-content comment">
						<?php comment_text(); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'quark' ), '<p class="edit-link">', '</p>' ); ?>
					</section> <!-- .comment-content -->

					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => wp_kses( __( 'Reply <span>&darr;</span>', 'quark' ), array( 'span' => array() ) ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div> <!-- .reply -->
				</article> <!-- #comment-## -->
			<?php
			break;
		} // end comment_type check
	}
}


/**
 * Update the Comments form so that the 'required' span is contained within the form label.
 *
 * @since Quark 1.0
 *
 * @param string Comment form fields html
 * @return string The updated comment form fields html
 */
function quark_comment_form_default_fields( $fields ) {

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? ' aria-required="true"' : "" );

	$fields[ 'author' ] = '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'quark' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';

	$fields[ 'email' ] =  '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'quark' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';

	$fields[ 'url' ] =  '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'quark' ) . '</label>' . '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

	return $fields;

}
add_action( 'comment_form_default_fields', 'quark_comment_form_default_fields' );


/**
 * Update the Comments form to add a 'required' span to the Comment textarea within the form label, because it's pointless
 * submitting a comment that doesn't actually have any text in the comment field!
 *
 * @since Quark 1.0
 *
 * @param string Comment form textarea html
 * @return string The updated comment form textarea html
 */
function quark_comment_form_field_comment( $field ) {

	if ( !quark_is_woocommerce_active() || ( quark_is_woocommerce_active() && !is_product() ) ) {
		$field = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'quark' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
	}
	return $field;

}
add_action( 'comment_form_field_comment', 'quark_comment_form_field_comment' );


/**
 * Prints HTML with meta information for current post: author and date
 *
 * @since Quark 1.0
 *
 * @return void
 */
if ( ! function_exists( 'quark_posted_on' ) ) {
	function quark_posted_on() {
		$post_icon = '';
		switch ( get_post_format() ) {
			case 'aside':
				$post_icon = 'fa-file-o';
				break;
			case 'audio':
				$post_icon = 'fa-volume-up';
				break;
			case 'chat':
				$post_icon = 'fa-comment';
				break;
			case 'gallery':
				$post_icon = 'fa-camera';
				break;
			case 'image':
				$post_icon = 'fa-picture-o';
				break;
			case 'link':
				$post_icon = 'fa-link';
				break;
			case 'quote':
				$post_icon = 'fa-quote-left';
				break;
			case 'status':
				$post_icon = 'fa-user';
				break;
			case 'video':
				$post_icon = 'fa-video-camera';
				break;
			default:
				$post_icon = 'fa-calendar';
				break;
		}

		// Translators: 1: Icon 2: Permalink 3: Post date and time 4: Publish date in ISO format 5: Post date
		$date = sprintf( '<i class="fa %1$s" aria-hidden="true"></i> <a href="%2$s" title="Posted %3$s" rel="bookmark"><time class="entry-date" datetime="%4$s" itemprop="datePublished">%5$s</time></a>',
			$post_icon,
			esc_url( get_permalink() ),
			sprintf( esc_html__( '%1$s @ %2$s', 'quark' ), esc_html( get_the_date() ), esc_attr( get_the_time() ) ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		// Translators: 1: Date link 2: Author link 3: Categories 4: No. of Comments
		$author = sprintf( '<i class="fa fa-pencil" aria-hidden="true"></i> <address class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></address>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( esc_html__( 'View all posts by %s', 'quark' ), get_the_author() ) ),
			get_the_author()
		);

		// Return the Categories as a list
		$categories_list = get_the_category_list( esc_html__( ' ', 'quark' ) );

		// Translators: 1: Permalink 2: Title 3: No. of Comments
		$comments = sprintf( '<span class="comments-link"> <a href="%1$s" class="c_link" title="%2$s">Leave a Comment</a>&nbsp; / %3$s</span>',
			esc_url( get_comments_link() ),
			esc_attr( esc_html__( 'Comment on ' , 'quark' ) . the_title_attribute( 'echo=0' ) ),
			( get_comments_number() > 0 ? sprintf( _n( '%1$s Comment', '%1$s Comments', get_comments_number(), 'quark' ), get_comments_number() ) : esc_html__( 'No Comments Yet!', 'quark' ) )
		);

		// Translators: 1: Date 2: Author 3: Categories 4: Comments
		printf( wp_kses( __( '<div class="header-meta row">%1$s%2$s<span class="post-categories">%3$s</span>%4$s</div>', 'quark' ), array(
			'div' => array (
				'class' => array() ),
			'span' => array(
				'class' => array() ) ) ),
			$date,
			$author,
			$categories_list,
			( is_search() ? '' : $comments )
		);
	}
}


/**
 * Prints HTML with meta information for current post: categories, tags, permalink
 *
 * @since Quark 1.0
 *
 * @return void
 */
if ( ! function_exists( 'quark_entry_meta' ) ) {
	function quark_entry_meta() {
		// Return the Tags as a list
		$tag_list = "";
		if ( get_the_tag_list() ) {
			$tag_list = get_the_tag_list( '<span class="post-tags">', esc_html__( ' ', 'quark' ), '</span>' );
		}

		// Translators: 1 is tag
		if ( $tag_list ) {
			printf( wp_kses( __( '<i class="fa fa-tag" aria-hidden="true"></i> %1$s', 'quark' ), array( 'i' => array( 'class' => array() ) ) ), $tag_list );
		}
	}
}



/**
 * Adjusts content_width value for full-width templates and attachments
 *
 * @since Quark 1.0
 *
 * @return void
 */
if ( ! function_exists( 'quark_content_width' ) ) {
	function quark_content_width() {
		if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() ) {
			global $content_width;
			$content_width = 1200;
		}
	}
}
add_action( 'template_redirect', 'quark_content_width' );


/**
 * Change the "read more..." link so it links to the top of the page rather than part way down
 *
 * @since Quark 1.0
 *
 * @param string The 'Read more' link
 * @return string The link to the post url without the more tag appended on the end
 */
function quark_remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ( $offset ) {
		$end = strpos( $link, '"', $offset );
	}
	if ( $end ) {
		$link = substr_replace( $link, '', $offset, $end-$offset );
	}
	return $link;
}
add_filter( 'the_content_more_link', 'quark_remove_more_jump_link' );


/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Quark 1.0
 *
 * @return string The 'Continue reading' link
 */
function quark_continue_reading_link() {
	return '&hellip;<p><a class="more-link" href="'. esc_url( get_permalink() ) . '" title="' . esc_html__( 'Continue reading', 'quark' ) . ' &lsquo;' . get_the_title() . '&rsquo;">' . wp_kses( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quark' ), array( 'span' => array(
			'class' => array() ) ) ) . '</a></p>';
}


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with the quark_continue_reading_link().
 *
 * @since Quark 1.0
 *
 * @param string Auto generated excerpt
 * @return string The filtered excerpt
 */
function quark_auto_excerpt_more( $more ) {
	return quark_continue_reading_link();
}
add_filter( 'excerpt_more', 'quark_auto_excerpt_more' );


/**
 * Extend the user contact methods to include Twitter, Facebook and Google+
 *
 * @since Quark 1.0
 *
 * @param array List of user contact methods
 * @return array The filtered list of updated user contact methods
 */
 if ( ! function_exists( 'quark_new_contactmethods' ) ) {
	function quark_new_contactmethods( $contactmethods ) {
		// Add Twitter
		$contactmethods['twitter'] = 'Twitter';

		//add Facebook
		$contactmethods['facebook'] = 'Facebook';

		//add Google Plus
		$contactmethods['googleplus'] = 'Google+';

		return $contactmethods;
	}
}
add_filter( 'user_contactmethods', 'quark_new_contactmethods', 10, 1 );

/**
 * Add a filter for wp_nav_menu to add an extra class for menu items that have children (ie. sub menus)
 * This allows us to perform some nicer styling on our menu items that have multiple levels (eg. dropdown menu arrows)
 *
 * @since Quark 1.0
 *
 * @param Menu items
 * @return array An extra css class is on menu items with children
 */
function quark_add_menu_parent_class( $items ) {

	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}

	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-parent-item';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'quark_add_menu_parent_class' );


/**
 * Add Filter to allow Shortcodes to work in the Sidebar
 *
 * @since Quark 1.0
 */
add_filter( 'widget_text', 'do_shortcode' );


/**
 * Return an unordered list of linked social media icons, based on the urls provided in the Theme Options
 *
 * @since Quark 1.0
 *
 * @return string Unordered list of linked social media icons
 */
if ( ! function_exists( 'quark_get_social_media' ) ) {
	function quark_get_social_media() {
		$output = '';
		$icons = array(
			array( 'url' => of_get_option( 'social_twitter', '' ), 'icon' => 'fa-twitter', 'title' => esc_html__( 'Follow me on Twitter', 'quark' ) ),
			array( 'url' => of_get_option( 'social_facebook', '' ), 'icon' => 'fa-facebook', 'title' => esc_html__( 'Friend me on Facebook', 'quark' ) ),
			array( 'url' => of_get_option( 'social_googleplus', '' ), 'icon' => 'fa-google-plus', 'title' => esc_html__( 'Connect with me on Google+', 'quark' ) ),
			array( 'url' => of_get_option( 'social_linkedin', '' ), 'icon' => 'fa-linkedin', 'title' => esc_html__( 'Connect with me on LinkedIn', 'quark' ) ),
			array( 'url' => of_get_option( 'social_slideshare', '' ), 'icon' => 'fa-slideshare', 'title' => esc_html__( 'Follow me on SlideShare', 'quark' ) ),
			array( 'url' => of_get_option( 'social_slack', '' ), 'icon' => 'fa-slack', 'title' => esc_html__( 'Join me on Slack', 'quark' ) ),
			array( 'url' => of_get_option( 'social_dribbble', '' ), 'icon' => 'fa-dribbble', 'title' => esc_html__( 'Follow me on Dribbble', 'quark' ) ),
			array( 'url' => of_get_option( 'social_tumblr', '' ), 'icon' => 'fa-tumblr', 'title' => esc_html__( 'Follow me on Tumblr', 'quark' ) ),
			array( 'url' => of_get_option( 'social_reddit', '' ), 'icon' => 'fa-reddit', 'title' => esc_html__( 'Join me on Reddit', 'quark' ) ),
			array( 'url' => of_get_option( 'social_twitch', '' ), 'icon' => 'fa-twitch', 'title' => esc_html__( 'Follow me on Twitch', 'quark' ) ),
			array( 'url' => of_get_option( 'social_github', '' ), 'icon' => 'fa-github', 'title' => esc_html__( 'Fork me on GitHub', 'quark' ) ),
			array( 'url' => of_get_option( 'social_bitbucket', '' ), 'icon' => 'fa-bitbucket', 'title' => esc_html__( 'Fork me on Bitbucket', 'quark' ) ),
			array( 'url' => of_get_option( 'social_stackoverflow', '' ), 'icon' => 'fa-stack-overflow', 'title' => esc_html__( 'Join me on Stack Overflow', 'quark' ) ),
			array( 'url' => of_get_option( 'social_codepen', '' ), 'icon' => 'fa-codepen', 'title' => esc_html__( 'Follow me on CodePen', 'quark' ) ),
			array( 'url' => of_get_option( 'social_foursquare', '' ), 'icon' => 'fa-foursquare', 'title' => esc_html__( 'Follow me on Foursquare', 'quark' ) ),
			array( 'url' => of_get_option( 'social_youtube', '' ), 'icon' => 'fa-youtube', 'title' => esc_html__( 'Subscribe to me on YouTube', 'quark' ) ),
			array( 'url' => of_get_option( 'social_vimeo', '' ), 'icon' => 'fa-vimeo', 'title' => esc_html__( 'Follow me on Vimeo', 'quark' ) ),
			array( 'url' => of_get_option( 'social_instagram', '' ), 'icon' => 'fa-instagram', 'title' => esc_html__( 'Follow me on Instagram', 'quark' ) ),
			array( 'url' => of_get_option( 'social_vine', '' ), 'icon' => 'fa-vine', 'title' => esc_html__( 'Follow me on Vine', 'quark' ) ),
			array( 'url' => of_get_option( 'social_snapchat', '' ), 'icon' => 'fa-snapchat', 'title' => esc_html__( 'Add me on Snapchat', 'quark' ) ),
			array( 'url' => of_get_option( 'social_flickr', '' ), 'icon' => 'fa-flickr', 'title' => esc_html__( 'Connect with me on Flickr', 'quark' ) ),
			array( 'url' => of_get_option( 'social_pinterest', '' ), 'icon' => 'fa-pinterest', 'title' => esc_html__( 'Follow me on Pinterest', 'quark' ) ),
			array( 'url' => of_get_option( 'social_rss', '' ), 'icon' => 'fa-rss', 'title' => esc_html__( 'Subscribe to my RSS Feed', 'quark' ) )
		);

		foreach ( $icons as $key ) {
			$value = $key['url'];
			if ( !empty( $value ) ) {
				$output .= sprintf( '<li><a href="%1$s" title="%2$s"%3$s><span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa %4$s fa-stack-1x fa-inverse"></i></span></a></li>',
					esc_url( $value ),
					$key['title'],
					( !of_get_option( 'social_newtab', '0' ) ? '' : ' target="_blank"' ),
					$key['icon']
				);
			}
		}

		if ( !empty( $output ) ) {
			$output = '<ul>' . $output . '</ul>';
		}

		return $output;
	}
}


/**
 * Return a string containing the footer credits & link
 *
 * @since Quark 1.0
 *
 * @return string Footer credits & link
 */
if ( ! function_exists( 'quark_get_credits' ) ) {
	function quark_get_credits() {
		$output = '';
		$output = sprintf( '%1$s <a href="%2$s" title="%3$s">%4$s</a>',
			esc_html__( 'Proudly powered by', 'quark' ),
			esc_url( esc_html__( 'http://wordpress.org/', 'quark' ) ),
			esc_attr( esc_html__( 'Semantic Personal Publishing Platform', 'quark' ) ),
			esc_html__( 'WordPress', 'quark' )
		);

		return $output;
	}
}


/**
 * Outputs the selected Theme Options inline into the <head>
 *
 * @since Quark 1.0
 *
 * @return void
 */
function quark_theme_options_styles() {
	$output = '';
	$imagepath =  trailingslashit( get_template_directory_uri() ) . 'images/';
	$background_defaults = array(
		'color' => '#222222',
		'image' => $imagepath . 'dark-noise.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' );

	$background = of_get_option( 'banner_background', $background_defaults );
	if ( $background ) {
		$bkgrnd_color = apply_filters( 'of_sanitize_color', $background['color'] );
		$output .= "#bannercontainer { ";
		$output .= "background: " . $bkgrnd_color . " url('" . esc_url( $background['image'] ) . "') " . $background['repeat'] . " " . $background['attachment'] . " " . $background['position'] . ";";
		$output .= " }";
	}

	$footerColour = apply_filters( 'of_sanitize_color', of_get_option( 'footer_color', '#222222' ) );
	if ( !empty( $footerColour ) ) {
		$output .= "\n#footercontainer { ";
		$output .= "background-color: " . $footerColour . ";";
		$output .= " }";
	}

	if ( of_get_option( 'footer_position', 'center' ) ) {
		$output .= "\n.smallprint { ";
		$output .= "text-align: " . sanitize_text_field( of_get_option( 'footer_position', 'center' ) ) . ";";
		$output .= " }";
	}

	if ( $output != '' ) {
		$output = "\n<style>\n" . $output . "\n</style>\n";
		echo $output;
	}
}
add_action( 'wp_head', 'quark_theme_options_styles' );


/**
 * Recreate the default filters on the_content
 * This will make it much easier to output the Theme Options Editor content with proper/expected formatting.
 * We don't include an add_filter for 'prepend_attachment' as it causes an image to appear in the content, on attachment pages.
 * Also, since the Theme Options editor doesn't allow you to add images anyway, no big deal.
 *
 * @since Quark 1.0
 */
add_filter( 'meta_content', 'wptexturize' );
add_filter( 'meta_content', 'convert_smilies' );
add_filter( 'meta_content', 'convert_chars'  );
add_filter( 'meta_content', 'wpautop' );
add_filter( 'meta_content', 'shortcode_unautop' );
add_filter( 'meta_content', 'do_shortcode' );

/**
* Show an archive description on taxonomy archives.
*
* @subpackage  Archives
*/
    function woocommerce_taxonomy_archive_description() {
        if ( is_tax( array( 'product_cat', 'product_tag' ) ) && 0 === absint( get_query_var( 'paged' ) ) ) {
            $description = wc_format_content( term_description() );
            if ( $description ) {
            	echo '<div class="grid-8 center offset-2 pad-3-vert">';
                echo '<div class="term-description">' . $description . '</div>';
                echo '</div>';
            }
        }
    }

/**
 * WooCommerce Breadcrumb Home Text
 */

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_home_text' );
function jk_change_breadcrumb_home_text( $defaults ) {
    // Change the breadcrumb home text from 'Home' to ''
	$defaults['home'] = '';
	return $defaults;
}


/**
 * Add product's brand name below thumbnail and above title on product list pages.
 */
add_action( 'woocommerce_shop_loop_item_title', 'mycode_add_brand_above_product_title', 5 );
function mycode_add_brand_above_product_title() {
	global $product;
	$brand = array_shift( wc_get_product_terms( $product->id, 'product_brand', array( 'fields' => 'names' ) ) );
	$link = array_shift( wc_get_product_terms( $product->id, 'product_brand', array( 'fields' => 'slugs' ) ) );
	$url = get_term_link( $link, 'product_brand' );

	if (!empty($brand)) {
	echo '<a href="' . $url .'">';
	echo '<h6 class="br_title">' . $brand . '</h6></a>';
	}
	else {
	echo '<h6 class="br_title">&nbsp;</h6>';	
	}
}

/**
	 * output_product_brand_thumbnails_description function for reference.
	 *
	 * @access public
	 * @param mixed $atts
	 * @return void
	 */


function shortcode_handler($atts) {
  //code goes here


		extract( shortcode_atts( array(
			'show_empty' => true,
			'columns'    => 1,
			'hide_empty' => 0,
			'orderby'    => 'name',
			'exclude'    => '',
			'number'     => ''
		 ), $atts ) );

		$exclude = array_map( 'intval', explode(',', $exclude) );
		$order = $orderby == 'name' ? 'asc' : 'desc';
		
		$brands = get_terms( 'product_brand', array( 'hide_empty' => $hide_empty, 'orderby' => $orderby, 'exclude' => $exclude, 'number' => $number, 'order' => $order ) );

		if ( ! $brands )
			return;

		ob_start();

		woocommerce_get_template( 'brand-thumbnails-description.php', array(
			'brands'  => $brands,
			'columns' => $columns
		), 'woocommerce-brands', untrailingslashit( get_stylesheet_directory ( dirname( __FILE__ ) ) ) . '/woocommerce/' );

		return ob_get_clean();
 }

add_shortcode('btc','shortcode_handler');




/**
 * Unhook the WooCommerce Wrappers + Other Modifications
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 1 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 3 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 8 );
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 25 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
/**
 * Product Tabs
 */


add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['description']['title'] = __( 'Hannah Says' );		// Rename the description tab
	$tabs['reviews']['title'] = __( 'Customer Reviews' );				// Rename the reviews tab
	$tabs['reviews']['priority'] = 10;			// Reviews second
	$tabs['description']['priority'] = 5;			// Description first
	//$tabs['additional_information']['title'] = __( 'Additional Information' );	// Rename the additional information tab

	return $tabs;

}

add_filter( 'woocommerce_custom_product_tabs_lite_heading', '__return_empty_string' );

/* This snippet removes the action that inserts thumbnails to products in teh loop
 * and re-adds the function customized with our wrapper in it.
 * It applies to all archives with products.
 *
 * @original plugin: WooCommerce
 * @author of snippet: Brian Krogsard
 */

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);


if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
    function woocommerce_template_loop_product_thumbnail() {
        echo woocommerce_get_product_thumbnail();
    } 
}
if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {   
    function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
        global $post, $woocommerce;
        $output = '<div class="imagewrapper">';

        if ( has_post_thumbnail() ) {               
            $output .= get_the_post_thumbnail( $post->ID, $size );              
        }                       
        $output .= '</div>';
        return $output;
    }
}


/**
 * Outputs the opening container div for WooCommerce
 *
 * @since Quark 1.3
 *
 * @return void
 */
if ( ! function_exists( 'quark_before_woocommerce_wrapper' ) ) {
	function quark_before_woocommerce_wrapper() {
		echo '<div id="primary" class="site-content row" role="main">';
	}
}


/**
 * Outputs the closing container div for WooCommerce
 *
 * @since Quark 1.3
 *
 * @return void
 */
if ( ! function_exists( 'quark_after_woocommerce_wrapper' ) ) {
	function quark_after_woocommerce_wrapper() {
		echo '</div> <!-- /#primary.site-content.row -->';
	}
}


/**
 * Check if WooCommerce is active
 *
 * @since Quark 1.3
 *
 * @return void
 */
function quark_is_woocommerce_active() {
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		return true;
	}
	else {
		return false;
	}
}


/**
 * Check if WooCommerce is active and a WooCommerce template is in use and output the containing div
 *
 * @since Quark 1.3
 *
 * @return void
 */
if ( ! function_exists( 'quark_setup_woocommerce_wrappers' ) ) {
	function quark_setup_woocommerce_wrappers() {
		if ( quark_is_woocommerce_active() && is_woocommerce() ) {
				add_action( 'quark_before_woocommerce', 'quark_before_woocommerce_wrapper', 10, 0 );
				add_action( 'quark_after_woocommerce', 'quark_after_woocommerce_wrapper', 10, 0 );
		}
	}
	add_action( 'template_redirect', 'quark_setup_woocommerce_wrappers', 9 );
}


/**
 * Outputs the opening wrapper for the WooCommerce content
 *
 * @since Quark 1.3
 *
 * @return void
 */
if ( ! function_exists( 'quark_woocommerce_before_main_content' ) ) {
	function quark_woocommerce_before_main_content() {
		if( ( is_shop() && !of_get_option( 'woocommerce_shopsidebar', '1' ) ) ) {
			echo '<div class="grid-12">';
		}
		else {
			echo '<div class="grid-12">';
		}
	}
	add_action( 'woocommerce_before_main_content', 'quark_woocommerce_before_main_content', 10 );
}


/**
 * Outputs the closing wrapper for the WooCommerce content
 *
 * @since Quark 1.3
 *
 * @return void
 */
if ( ! function_exists( 'quark_woocommerce_after_main_content' ) ) {
	function quark_woocommerce_after_main_content() {
		echo '</div>';
	}
	add_action( 'woocommerce_after_main_content', 'quark_woocommerce_after_main_content', 10 );
}


/**
 * Remove the sidebar from the WooCommerce templates
 *
 * @since Quark 1.3
 *
 * @return void
 */
if ( ! function_exists( 'quark_remove_woocommerce_sidebar' ) ) {
	function quark_remove_woocommerce_sidebar() {
		if( ( is_shop() && !of_get_option( 'woocommerce_shopsidebar', '1' ) ) || ( is_product() && !of_get_option( 'woocommerce_productsidebar', '1' ) ) ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		}
	}
	add_action( 'woocommerce_before_main_content', 'quark_remove_woocommerce_sidebar' );
}


/**
 * Remove the breadcrumbs from the WooCommerce pages
 *
 * @since Quark 1.3
 *
 * @return void
 */
if ( ! function_exists( 'quark_remove_woocommerce_breadcrumbs' ) ) {
	function quark_remove_woocommerce_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
}

/**
 * Custom Breadcrumbs
 *
 * @since Quark 1.3
 *
 * @return void
 */

function woocommerce_custom_breadcrumb(){
    woocommerce_breadcrumb();
}

add_action( 'woo_custom_breadcrumb', 'woocommerce_custom_breadcrumb' );

/**
 * Online Consult
 */

function has_bought() {

    $count = 0;
    $bought = false;

    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => array('wc-completed', 'wc-processing') // Only orders with status "completed"
    ) );

    // Going through each current customer orders
    foreach ( $customer_orders as $customer_order ) {
        $count++;
    }

    // return "true" when customer has already one order
    if ( $count > 0 ) {
        $bought = true;
    }
    return $bought;
}

// Add login buttons to the Product Reviews Pro login modal
function add_wc_social_login_buttons_prpro() {
 
	if ( is_product() && function_exists( 'woocommerce_social_login_buttons' ) ) {
		woocommerce_social_login_buttons( home_url( add_query_arg( array() ) ) . '#tab-reviews#comment-1' );
	}
}
add_action( 'woocommerce_login_form_end', 'add_wc_social_login_buttons_prpro' );


// Change the login text from what's set in our WooCommerce settings so we're not talking about checkout for a review.
function prpro_change_social_login_text_option( $login_text ) {

	// Only modify the text from this option if we're on a product page
	if ( is_product() ) {
   		$login_text = __( 'You can also create an account or log in with a social network.', 'woocommerce' );
   		// Adjust the login text as desired
   	}
 
 	return $login_text;
}
add_filter( 'pre_option_wc_social_login_text', 'prpro_change_social_login_text_option' );



/**
 * Set the number of products to display on the WooCommerce shop page
 *
 * @since Quark 1.3.1
 *
 * @return void
 */
if ( ! function_exists( 'quark_set_number_woocommerce_products' ) ) {
	function quark_set_number_woocommerce_products() {
		if ( of_get_option( 'shop_products', '12' ) ) {
			$numprods = "return " . sanitize_text_field( of_get_option( 'shop_products', '12' ) ) . ";";
			add_filter( 'loop_shop_per_page', create_function( '$cols', $numprods ), 20 );
		}
	}
	add_action( 'init', 'quark_set_number_woocommerce_products' );
}

?>
