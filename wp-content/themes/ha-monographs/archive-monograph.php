<?php
/**
 * The template for displaying the monograph archive page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Understrap
 */

// Redirect to access denied page if not logged in as a current Herbarium member.
if(mm_member_decision(array("isMember"=>"false")) || mm_member_decision(array("membershipId"=>"1")))
{
   wp_redirect("/mm-error/?code=100020");
}

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

/* Monographs list page is always full-width - overrides theme setting */
$container = 'container-fluid';
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php // get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">
                <?php get_template_part('search-templates/searchbar' ); ?>

				<?php
				if ( have_posts() ) {
					?>

                    <section class="monographs-list">
                        <?php
                            // Start the loop.
                            while ( have_posts() ) {
                                the_post();

                                get_template_part( 'loop-templates/content', 'monographs-list' );
                            }
                        } else {
                            get_template_part( 'loop-templates/content', 'none' );
                        }
                        ?>
                    </section>

			</main><!-- #main -->

			<?php
			// Display the pagination component.
			understrap_pagination();
			// Do the right sidebar check.
			//get_template_part( 'global-templates/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();
