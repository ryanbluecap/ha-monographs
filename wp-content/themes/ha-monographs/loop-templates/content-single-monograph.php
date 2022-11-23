<?php
/**
 * Partial template for content in single-monograph.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<a class="d-block my-4 back" href="<?php bloginfo('url'); ?>/monographs/">&laquo; Back to Monographs List</a>

<section class="monograph-details shadow">
    <div class="row">
        <div class="col-lg-5 col-img">
            <?php
                if ( $images = get_field('image_carousel') ) :
                    $featured_image_id = get_post_thumbnail_id();
                    $primary_image_url = get_the_post_thumbnail_url();
            ?>
                <img class="primary mb-2 shadow-sm fade" src="<?php echo $primary_image_url; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">

                <div class="d-flex image-carousel-nav">
                    <ul>
                    <?php
                        // Show featured image first, if set
                        if ( $featured_image = wp_get_attachment_image($featured_image_id, 'monograph_main') ) {
                            ?>
                            <li><a href="<?php echo $primary_image_url; ?>"><?php echo $featured_image; ?></a></li>
                    <?php
                        }

                        foreach ( $images as $image ) {
                            if ( $image['id'] !== $featured_image_id ) {
                                $image_url = wp_get_attachment_image_src($image['id'], 'monograph_main');
                                ?>
                                <li><a href="<?php echo esc_url( $image_url[0] ); ?>"><img class="secondary" src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>"></a></li>
                                <?php
                            }
                        }
                    ?>
                    </ul>
                </div>
            <?php
                endif;

                if ( $video  = get_field( 'video_embed') ) :
                    ?>
                    <?php the_field('video_embed'); ?>
                    <?php
	            endif;
	        ?>
        </div>
        <div class="col-lg-7">
            <a class="print dashicons-before dashicons-printer" href="javascript:window.print()">Print</a>

           <?php ha_monographs_post_nav(); ?>

            <div class="monograph-name">
                <h1 class="mt-5 fade"><?php the_title(); ?></h1>
                <h4 class="fade"><em><?php the_field('latin_name'); ?></em></h4>
            </div>

            <?php
                while ( have_rows( 'monograph_meta') ) : the_row();
                    ?>
                    <aside class="mt-5 monograph-meta fade">
	                    <?php if ( ! ha_string_is_empty( get_sub_field('common_name' ) ) ) { ?>
                            <h5>Common Name</h5>
                            <p><?php the_sub_field('common_name'); ?></p>
                        <?php } ?>

	                    <?php if ( ! ha_string_is_empty( get_sub_field('family' ) ) ) { ?>
                            <h5>Family</h5>
                            <p><?php the_sub_field('family'); ?></p>
                        <?php } ?>

	                    <?php if ( ! ha_string_is_empty( get_sub_field('tcm_name' ) ) ) { ?>
                            <h5>Chinese Medicine Name</h5>
                            <p><?php the_sub_field('tcm_name'); ?></p>
                        <?php } ?>

	                    <?php if ( ! ha_string_is_empty( get_sub_field('ayurvedic_name' ) ) ) { ?>
                            <h5>Ayurvedic Name</h5>
                            <p><?php the_sub_field('ayurvedic_name'); ?></p>
                        <?php } ?>

	                    <?php if ( ! ha_string_is_empty( get_sub_field('parts_used' ) ) ) { ?>
                            <h5>Parts Used</h5>
                            <p><?php the_sub_field('parts_used'); ?></p>
                        <?php } ?>

	                    <?php if ( ! ha_string_is_empty( get_sub_field('native_to' ) ) ) { ?>
                            <h5>Native To</h5>
                            <p><?php the_sub_field('native_to'); ?></p>
                        <?php } ?>

                        <hr class="my-4">

	                    <?php if ( ! ha_string_is_empty( get_field('geographic_distribution' ) ) ) { ?>
                            <h5 class="print-margin">Geographic Distribution</h5>
                            <?php the_field('geographic_distribution'); ?>
                        <?php } ?>

	                    <?php if ( ! ha_string_is_empty( get_field('botanical_description' ) ) ) { ?>
                            <h5>Botanical Description</h5>
                            <?php the_field('botanical_description'); ?>
                        <?php } ?>

	                    <?php if ( ! ha_string_is_empty( get_field('key_constituents' ) ) ) { ?>
                            <h5>Key Constituents</h5>
                            <?php the_field('key_constituents'); ?>
                        <?php } ?>

	                    <?php if ( ! ha_string_is_empty( get_field('sustainability_issues' ) ) ) { ?>
                            <h5>Sustainability Issues</h5>
                            <?php the_field('sustainability_issues'); ?>
                        <?php } ?>

                        <?php if ( ! ha_string_is_empty( get_field('veterinary_use' ) ) ) { ?>
                            <h5>Veterinary Use</h5>
                            <?php the_field('veterinary_use'); ?>
                        <?php } ?>

                        <?php if ( ! ha_string_is_empty( get_field('harvesting_guidelines' ) ) ) { ?>
                            <h5>Harvesting Guidelines</h5>
                            <?php the_field('harvesting_guidelines'); ?>
                        <?php } ?>
                    </aside>
                    <?php
                endwhile;
            ?>


        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <hr class="my-4">

            <h3>Uses</h3>

            <div id="uses">
                <?php the_field('uses'); ?>
            </div>

            <aside class="d-none in-content-images">
	            <?php
		        if ( $images = get_field('in_content_images') ) :
                    $i = 0;
			        foreach ( $images as $image ) {
				        $image_url = wp_get_attachment_image_src( $image['id'], 'monograph_in_content' );
				        ?>
                        <img class="mb-4 alignright fade image<?php echo $i; ?>" src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>">
				        <?php
                        $i++;
			        }
		        endif;
		        ?>
            </aside>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <hr class="my-4">

            <h4>References</h4>

            <div id="references" class="collapse" aria-expanded="false">
                <?php the_field('references'); ?>
            </div>

            <a class="btn btn-primary btn-expand collapsed" data-bs-toggle="collapse" href="#references" role="button" aria-expanded="false" aria-controls="references">
                Show More
            </a>
        </div>
    </div>

    <hr class="my-4">

    <aside class="usage-details">
        <div class="row">
            <div class="col-lg-6">
                <h4 class="mt-4">Adult Dose</h4>
                <?php the_field('adult_dose'); ?>

                <h4 class="mt-4">Safety</h4>
                <?php the_field('safety'); ?>
            </div>
            <div class="col-lg-6">
                <h4 class="mt-4">Ways to Use</h4>
                <?php
                    $ways_to_use = get_the_terms($post->ID, 'monograph_way_to_use');

                    foreach ( $ways_to_use as $item ) {
                        ?>
                        <a href="<?php echo get_term_link( $item->term_id ); ?>"><?php echo $item->name; ?></a>
                        <?php
                    }
                ?>

                <h4 class="mt-4">Actions</h4>
	            <?php
                    $actions = get_the_terms($post->ID, 'monograph_action');

                    foreach ( $actions as $item ) {
                        ?>
                        <a href="<?php echo get_term_link( $item->term_id ); ?>"><?php echo $item->name; ?></a>
                        <?php
                    }
	            ?>

                <h4 class="mt-4">Taste</h4>
	            <?php
                    $taste = get_the_terms($post->ID, 'monograph_taste');

                    foreach ( $taste as $item ) {
                        ?>
                        <a href="<?php echo get_term_link( $item->term_id ); ?>"><?php echo $item->name; ?></a>
                        <?php
                    }
	            ?>

                <h4 class="mt-4">Energy</h4>
	            <?php
                    $energy = get_the_terms($post->ID, 'monograph_energetic');

                    foreach ( $energy as $item ) {
                        ?>
                        <a href="<?php echo get_term_link( $item->term_id ); ?>"><?php echo $item->name; ?></a>
                        <?php
                    }
	            ?>
            </div>
        </div>
    </aside>

    <div class="row">
        <div class="col-lg-12">
            <aside class="external-links">
                <hr class="my-4">

                <h4 class="mt-4">Scientific Research</h4>

                <div id="scientific-research" class="collapse" aria-expanded="false">
		            <?php the_field('scientific_research'); ?>
                </div>

                <a class="btn btn-primary btn-expand collapsed" data-bs-toggle="collapse" href="#scientific-research" role="button" aria-expanded="false" aria-controls="scientific-research">
                    Show More
                </a>

                <h4 class="mt-4">Where to Buy</h4>
                <?php the_field('where_to_buy'); ?>
            </aside>
        </div>
    </div>
</section>

<section class="copyright shadow">
    <div class="row">
        <div class="col-md-12">
            <h5>Copyright Notice</h5>

            <p>Monographs and articles in The Herbarium are copyrighted and are for personal study only. Content including images, photos, media, graphics, and other media, cannot be re-published or duplicated for personal or commercial use.</p>

            <h5>Disclosure</h5>

            <p>The Herbal Academy supports trusted organizations with the use of affiliate links. Affiliate links are shared throughout the website and the Herbal Academy may receive compensation if you make a purchase with these links.</p>

            <p>Information offered on Herbal Academy websites is for educational purposes only. The Herbal Academy makes neither medical claim, nor intends to diagnose or treat medical conditions. Links to external sites are for informational purposes only. The Herbal Academy neither endorses them nor is in any way responsible for their content. Readers must do their own research concerning the safety and usage of any herbs or supplements.</p>
        </div>
    </div>
</section>
