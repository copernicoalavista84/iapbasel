<?php get_header(); ?>
<div id="blog-post">
    <div class="container">
        <div class="sixteen columns alpha omega">
            <h2><?php echo 'Search results: <span>' . get_search_query() . '</span>';?></h2>
		</div>
    </div>
    <div id="posts">
    <?php
        while( have_posts() ) {
            the_post();
    ?>
    <div class="post-entry">
    	<div class="container">
    		<div class="three columns">
    			<div class="client">
                    <p><?php the_date( 'd.m.Y.' ) ?></p>
                    <h4><?php the_time() ?></h4>
    			</div>
    		</div>
    		<div class="nine columns">
   			<?php
               $image = array(
                    'echo' => false,
                    'width' => 600
                );
                $image_tag = get_image( $image );
                echo ( $image_tag ) ? $image_tag : '&nbsp;'; 
            ?>
    		</div>
    		<div class="four columns">
    			<div class="info-blog">
    				<h6><?php the_title(); ?></h6>
    				<p><?php the_excerpt(); ?></p>
                    <a class="inner-button-blog" href="<?php the_permalink(); ?>">View Post</a>
    			</div>
    		</div>
    	</div>
    </div>
    <?php
        }
        wp_pagenavi(array(
            'before'    => '<div class="post-entry clearfix"><div class="container">',
            'after'     => '</div></div>'
        ));
    ?>
    </div>
</div>
<?php get_footer(); ?>