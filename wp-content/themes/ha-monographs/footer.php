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
        // Open all external links in a new window
        // TODO: scope this to content area only for better performance
        $('.monograph-details a:not(.print)').each(function() {
            var a = new RegExp('/' + window.location.host + '/');
            if(!a.test(this.href)) {
                $(this).click(function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    window.open(this.href, '_blank');
                });
            }
        });

        $('.image-carousel-nav ul').slickLightbox({
            itemSelector: 'li > a'
        });

        // Automatically fade in elements on page load
        $('.fade').addClass('show');

        // Get the total number of paragraphs in the Uses section so we can insert image(s) at evenly spaced points
        var pCount = Math.floor( $('#uses p').length );

        // Place in-content media items at beginning and halfway through Uses content
        var imgCount = $('.in-content-images > img').length;
        var pNum = 0;

        $('.in-content-images > img').each(function(){
            if ( $(this).hasClass('image0') ) {
                // Prepend first image to the beginning of the Uses content
                $('#uses').prepend($(this));
            } else {
                pNum = Math.floor( pCount / imgCount );

                // Prepend any other images evenly throughout the content
                $('#uses p').eq(pNum).after($(this));
                imgCount--;
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

        /* Search Filters  */

        $('.btn-sort, .close').click(function(){
            $('.taxonomy-search').toggle('fast');

            return false;
        });

        $('.taxonomy-search select').change(function(){
           var slug = $(this).attr('name').replace('cat_', '');
           var value = $(this).val();
           var host = 'https://' + window.location.hostname;

           window.location.href = host + '/monograph_' + slug + '/' + value + '/';
        });
    });

</script>

<?php wp_footer(); ?>

</body>

</html>

