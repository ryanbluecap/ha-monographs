<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	// Custom fonts
	wp_enqueue_style( ' adobe-trajan', 'https://use.typekit.net/wjr1kod.css' );

	// Load Dashicons on frontend (prev/next arrows, print icon, etc.)
	wp_enqueue_style( 'dashicons' );

	// Slick and Slick Lightbox for image carousels
	wp_enqueue_style( 'slick', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css' );
	wp_enqueue_style( 'slick-theme', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array('slick') );
	wp_enqueue_style( 'slick-lightbox', '//cdnjs.cloudflare.com/ajax/libs/slick-lightbox/0.2.12/slick-lightbox.css', array('slick', 'slick-theme') );
	wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery') );
	wp_enqueue_script( 'slick-lightbox', '//cdnjs.cloudflare.com/ajax/libs/slick-lightbox/0.2.12/slick-lightbox.min.js', array('jquery', 'slick') );

 	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	wp_enqueue_script( 'ha-monographs', get_stylesheet_directory_uri() . "/js/ha-monographs{$suffix}.js", array('jquery', 'slick', 'slick-lightbox'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @param string $current_mod The current value of the theme_mod.
 * @return string
 */
function understrap_default_bootstrap_version( $current_mod ) {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );

/**
 * Check if string is empty, with accommodation for extra quirks from the old HANE DB import.
 */
function ha_string_is_empty( $text ) {
	$text = wp_strip_all_tags( $text );

	if ( empty( $text ) ) {
		return true;
	}

	if ( $text == 'NULL' ) {
		return true;
	}

	return false;
}

/**
 * Sort monographs archive alphabetically
 */
add_action( 'pre_get_posts', 'ha_monographs_sort_order');
function ha_monographs_sort_order($query){
	if( is_archive()  ) :
		//If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
		//Set the order ASC or DESC
		$query->set( 'order', 'ASC' );
		//Set the orderby
		$query->set( 'orderby', 'name' );
	endif;
}

/**
 * Custom image sizes for HA Monographs
 */
add_image_size('monograph_main', 800, 1200, true );
add_image_size('monograph_archive', 400, 600, true );
add_image_size('monograph_in_content', 500, 800 );

/*
 * Replacement next/previous post nat to order alphabetically.
 */
if ( ! function_exists( 'ha_monographs_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function ha_monographs_post_nav() {
		// Post Link Plus plugin: we have to include all these keys to avoid PHP warnings...
		$args = array(
			'order_by' => 'post_name',
			'order_2nd' => NULL,
			'num_results' => NULL,
			'in_same_meta' => NULL,
			'ex_cats' => NULL,
			'in_cats' => NULL,
			'ex_posts' => NULL,
			'in_posts' => NULL,
			'in_same_cat' => NULL,
			'in_same_tax' => NULL,
			'in_same_format' => NULL,
			'in_same_author' => NULL,
			'end_post' => NULL,
			'loop' => NULL
		);

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post_plus( $args, true );
		$next     = get_adjacent_post_plus( $args, false );
		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="container navigation post-navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'understrap' ); ?></h2>
			<div class="d-flex nav-links justify-content-between">
				<?php
				if ( get_previous_post_link() ) {
					$args = array(
						'order_by' => 'post_name',
						'order_2nd' => NULL,
						'format' => '<span class="nav-previous">%link</span>',
						'link' => _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'understrap' )
					);

					adjacent_post_link_plus( $args, '', true );
				}
				if ( get_next_post_link() ) {
					$args = array(
						'order_by' => 'post_name',
						'order_2nd' => NULL,
						'format' => '<span class="nav-next">%link</span>',
						'link' => _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'understrap' )
					);
					adjacent_post_link_plus( $args, '', false );
				}
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}


/*
 * Add alphabetical letters for indexing monographs
*/

add_action('save_post', 'ha_monograph_save_first_letter');
function ha_monograph_save_first_letter( $post_id ){
	// verify if this is an auto save routine.
	// If it is our form has not been submitted, so we don't want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	//check location (only run for monographs)
	$limitPostTypes = array('monograph');

	if (! in_array( get_post_type( $post_id ), $limitPostTypes) )
		return $post_id;

	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// OK, we're authenticated: we need to find and save the data
	$taxonomy = 'alphabetical_letter';

	wp_set_post_terms( $post_id, strtolower(substr( get_the_title( $post_id ), 0, 1)), $taxonomy );

    // delete the transient that is storing the alphabet letters
	delete_transient( 'ha_archive_alphabet');
}

add_filter('manage_monograph_posts_columns', 'ha_add_featured_image_column');
function ha_add_featured_image_column($defaults) {
	$defaults['featured_image'] = 'Image';
	return $defaults;
}

add_action('manage_monograph_posts_custom_column', 'ha_show_featured_image_column', 10, 2);
function ha_show_featured_image_column($column_name, $post_id) {
	if ($column_name == 'featured_image') {
		echo get_the_post_thumbnail($post_id, array(75, 75) );
	}
}
