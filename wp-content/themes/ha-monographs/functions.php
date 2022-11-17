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
	wp_enqueue_style( 'slick', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.csss' );
	wp_enqueue_style( 'slick-theme', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array('slick') );
	wp_enqueue_style( 'slick-lightbox', '//cdnjs.cloudflare.com/ajax/libs/slick-lightbox/0.2.12/slick-lightbox.css', array('slick', 'slick-theme') );
	wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery') );
	wp_enqueue_script( 'slick-lightbox', '//cdnjs.cloudflare.com/ajax/libs/slick-lightbox/0.2.12/slick-lightbox.min.js', array('jquery', 'slick') );

 	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
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

	if ( $text == 'N/A' || $text == 'NULL' ) {
		return true;
	}

	return false;
}

/**
 * Sort monographs archive alphabetically
 */
add_action( 'pre_get_posts', 'ha_monographs_sort_order');
function ha_monographs_sort_order($query){
	if( is_post_type_archive( 'monograph' ) ) :
		//If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
		//Set the order ASC or DESC
		$query->set( 'order', 'ASC' );
		//Set the orderby
		$query->set( 'orderby', 'title' );
	endif;
}

/**
 * Custom image sizes for HA Monographs
 */
add_image_size('monograph_main', 800, 1200, true );
add_image_size('monograph_archive', 400, 600, true );
add_image_size('monograph_in_content', 500, 800 );

/*
 * Add alphabetical letters for indexing monographs
*/

//add_action('init', 'ha_alphabetical_monographs');
function ha_alphabetical_monographs(){
	$args = array(
		'post_type'     => 'monograph',
		'numberposts'   => -1
		);

	$monographs = get_posts( $args );
	$taxonomy = 'alphabetical_letter';

	foreach ( $monographs as $monograph ) {
		//wp_set_post_terms( $monograph->ID, strtolower(substr($monograph->post_title, 0, 1)), $taxonomy );
	}
}
