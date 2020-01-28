<?php get_header(); ?>
<div id="blog-post">
    <div class="container">
        <div class="sixteen columns alpha omega">
            <h2><?php
            if ( is_category() ) :
    			printf( __( 'Category: <span>%s</span>', 'spyropress' ), single_cat_title( '', false ) );
            elseif ( is_tag() ) :
    			printf( __( 'Tag: <span>%s</span>', 'spyropress' ), single_tag_title( '', false ) );
            elseif ( is_day() ) :
    			printf( __( 'Daily: <span>%s</span>', 'twentythirteen' ), get_the_date() );
    		elseif ( is_month() ) :
    			printf( __( 'Monthly: <span>%s</span>', 'twentythirteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentythirteen' ) ) );
    		elseif ( is_year() ) :
    			printf( __( 'Yearly: <span>%s</span>', 'twentythirteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentythirteen' ) ) );
    		else :
    			_e( 'Archives', 'twentythirteen' );
    		endif;
    	?></h2>
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