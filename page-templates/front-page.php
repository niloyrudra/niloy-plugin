<?php

get_header();



// foreach ( get_post_types( array( 'show_ui' => true )) as $post_type ) {
foreach ( get_post_types( array( '_builtin' => false, 'publicly_queryable' => true )) as $post_type ) {


    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 3
    );

    $posts = new WP_Query($args);

    if( $posts->have_posts() ):

        echo '<h1>Popular ' . $post_type . '</h1>';

        while( $posts->have_posts() ): $posts->the_post();

        echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
        echo '<small>' . get_the_content() . '</small>';
        if( has_post_thumbnail() ) {
            the_post_thumbnail();
        }

        endwhile;

        ?><hr><?php

    endif;

    wp_reset_postdata();

    

}



get_footer();