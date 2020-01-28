<?php
$defaults = array(
    'post_type' => 'post',
    'taxonomy'  => 'post_tag',
    'post_id'   => get_the_ID(),
    'exclude'   => array(),
    'count'     => 4
);

extract( wp_parse_args( $args, $defaults ) );

$terms = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ));

if ( count( ( $terms = array_diff( $terms, $exclude ) ) ) == 0 ) return;

$related_posts = get_posts( array(
    'tax_query' => array(
         array(
              'taxonomy' => $taxonomy,
              'field' => 'id',
              'terms' => $terms,
              'operator' => 'IN'
         )
    ),
    'post_type' => $post_type,
    'posts_per_page' => $count,
    'exclude' => $post_id
) );

if ( count( $related_posts ) == 0 ) return;
?>
<div class="related">
	<h6>Related Posts</h6>
    <?php foreach ( $related_posts as $related_post ) { ?>
        <?php
            get_image(array(
                'post_id' => $related_post->ID,
                'width' => 220,
                'type' => 'url'
            ));
        ?>
    <?php } ?>
</div>