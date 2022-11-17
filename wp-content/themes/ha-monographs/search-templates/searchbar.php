<aside class="taxonomy-search shadow">
    <a class="close" href="#">View All Monographs <i class="fa fa-close"></i></a>
    <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
        <?php
            $monograph_taxonomies = array(
                    'action'        => 'Actions',
                    'taste'         => 'Taste',
                    'energy'        => 'Energies',
                    'way_to_use'    => 'Ways to Use'
            );

            foreach ( $monograph_taxonomies as $key => $value ) {
                $args = array(
                    'taxonomy'          => 'monograph_' . $key,
                    'value_field'       => 'slug',
                    'name'              => 'cat_'. $key,
                    'show_option_none'  => __( $value ),
                    'option_none_value' => '',
                    'order'             => 'ASC',
                    'hide_empty'        => 0
                );

                wp_dropdown_categories( $args );
            }
        ?>
    </form>
</aside>

<div class="search-bar d-flex align-items-center mb-4">
    <a class="btn btn-sort" href="#">Sort<br>Monographs</a>

    <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Monographs', 'placeholder' ) ?>" value="<?php echo get_query_var('s'); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />

        <input type="hidden" name="post_type" value="monograph" />

        <button type="submit" class="btn btn-default btn-search">
            <span class="sr-only">Search</span><i class="fa fa-search fa-lg"></i>
        </button>
    </form>

    <?php
        $args = array(
                'taxonomy'      => 'alphabetical_letter',
                'hide_empty'    => false
        );

        if ( $terms = get_terms( $args ) ) {
            ?>
            <ul class="search-alphabetical">
                <li class="mx-1"><span>Search by letter</span></li>
                <?php
                    foreach ( $terms as $term ) {
                        ?>
                        <li><a href="<?php echo get_term_link( $term->term_id ); ?>"><?php echo $term->name; ?></a></li>
                    <?php
                    }
                ?>
                <li class="mx-1"><a href="/monographs"><span>View All</span></a></li>
            </ul>
            <?php
        }
    ?>
</div>
