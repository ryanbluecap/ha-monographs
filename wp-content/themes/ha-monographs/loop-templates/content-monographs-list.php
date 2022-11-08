<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<article <?php post_class('monograph-card fade p-2'); ?> id="post-<?php the_ID(); ?>">
    <div class="fade shadow-sm h-100">
        <a href="<?php the_permalink(); ?>">
            <?php echo get_the_post_thumbnail( $post->ID, 'monograph_archive' ); ?>

            <span class="p-3">
                <h3><?php the_title(); ?></h3>

                <?php while ( have_rows( 'monograph_meta') ) : the_row(); ?>
                    <?php if ( ! ha_string_is_empty( get_sub_field('common_name' ) ) ) { ?>
                        <p><?php echo wp_trim_words(get_sub_field( 'common_name') , 15); ?></p>
                    <?php } ?>
                <?php endwhile; ?>
            </span>
        </a>

    </div>
</article>
