<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">

						<?php //understrap_site_info(); ?>

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<script>
    // TODO: move to separate JS, get it to compile correctly
    jQuery(document).ready(function($){
        // Automatically fade in elements on page load
        $('.fade').addClass('show');

        // Get the total number of paragraphs in the Uses section so we can insert image(s) at the halfway point
        var pHalfwayPoint = Math.floor( $('#uses p').length / 2 );

        // Place in-content images at beginning and halfway through Uses content
        $('.in-content-images > img').each(function(){
            if ( $(this).hasClass('image0') ) {
                // Prepend first image to the beginning of the Uses content
                $('#uses').prepend($(this));
            } else {
                // Prepend the second image (and any others added in the future) to the halfway point
                $('#uses p').eq(pHalfwayPoint).after($(this));
            }
        });

        // Expand/contract References section
        $('.btn-expand').click(function(){
            if ( $(this).hasClass('collapsed')) {
                $(this).html('Show More');
            } else {
                $(this).html('Show Less');
            }
        });
    });

</script>

<?php wp_footer(); ?>

</body>

</html>

