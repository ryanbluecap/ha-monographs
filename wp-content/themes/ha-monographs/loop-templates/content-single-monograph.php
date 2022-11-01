<?php
/**
 * Partial template for content in single-monograph.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<section class="monograph-details">
    <div class="row">
        <div class="col-lg-5 col-img">
            <?php
                the_post_thumbnail();

                $images = get_field('image_carousel');
                if ( ! empty( $images ) ) :
                    ?>
                    <div class="d-flex">
                    <?php
                    foreach ( $images as $image ) {
                        ?>
                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php the_title(); ?>">
                        <?php
                    }
                    ?>
                    </div>
                <?php
                endif;
            ?>
        </div>
        <div class="col-lg-7">
            <?php
                while ( have_rows( 'monograph_meta') ) : the_row();
                    ?>
                    <aside class="monographs-meta">
                        <h5>Common Name:</h5>
                        <p><?php the_sub_field('common_name'); ?></p>

                        <h5>Family:</h5>
                        <p><?php the_sub_field('family'); ?></p>

                        <h5>TCM Name:</h5>
                        <p><?php the_sub_field('tcm_name'); ?></p>

                        <h5>Ayurvedic Name:</h5>
                        <p><?php the_sub_field('ayurvedic_name'); ?></p>

                        <h5>Parts Used:</h5>
                        <p><?php the_sub_field('parts_used'); ?></p>

                        <h5>Native To:</h5>
                        <p><?php the_sub_field('native_to'); ?></p>
                    </aside>
                    <?php
                endwhile;
            ?>

            <h4>Geographic Distribution</h4>
            <?php the_field('geographic_distribution'); ?>

            <h4>Botanical Description</h4>
            <?php the_field('botanical_description'); ?>

            <h4>Key Constituents</h4>
            <?php the_field('key_constituents'); ?>

            <h4>Sustainability Issues</h4>
	        <?php the_field('sustainability_issues'); ?>

            <h4>Harvesting Guidelines</h4>
	        <?php the_field('sustainability_issues'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3>Uses</h3>

            <?php the_field('uses'); ?>

            <hr>

            <h4>References</h4>

            <?php the_field('references'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h5>Adult Dose</h5>
            <?php the_field('adult_dose'); ?>

            <h5>Safety</h5>
            <?php the_field('safety'); ?>
        </div>
        <div class="col-lg-6">
            <h5>Ways to Use</h5>
            <?php the_field('ways_to_use'); ?>

            <h5>Actions</h5>
            <?php the_field('actions'); ?>

            <h5>Taste</h5>
            <?php the_field('taste'); ?>

            <h5>Energy</h5>
            <?php the_field('energy'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h4>Scientific Research</h4>
            <?php the_field('scientific_research'); ?>

            <h4>Where to Buy</h4>
	        <?php the_field('where_to_buy'); ?>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-md-12">
        <h5>Copyright Notice</h5>

        <p>Monographs and articles in The Herbarium are copyrighted and are for personal study only. Content including images, photos, media, graphics, and other media, cannot be re-published or duplicated for personal or commercial use.</p>

        <h5>Disclosure</h5>

        <p>The Herbal Academy supports trusted organizations with the use of affiliate links. Affiliate links are shared throughout the website and the Herbal Academy may receive compensation if you make a purchase with these links.</p>

        <p>Information offered on Herbal Academy websites is for educational purposes only. The Herbal Academy makes neither medical claim, nor intends to diagnose or treat medical conditions. Links to external sites are for informational purposes only. The Herbal Academy neither endorses them nor is in any way responsible for their content. Readers must do their own research concerning the safety and usage of any herbs or supplements.</p>
    </div>
</div>
