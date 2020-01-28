<?php

get_header();

while( have_posts() ) {
    the_post();
?>
<a class="back" href="<?php echo home_url('#blog'); ?>"></a>
<div id="blog-post">
	<div class="container">
		<div class="thirteen columns alpha">
		<?php get_image( 'width=1000' ); ?>
		</div>
		<div class="three columns omega">
			<?php spyropress_related_post(); ?>
            <?php
                the_terms( get_the_ID(), 'category', '<h6>Categories</h6>', ', ', '<div class="line"></div>' );
                the_terms( get_the_ID(), 'post_tag', '<h6>Tags</h6>', ', ', '<div class="line"></div>' );
            ?>
		</div>
		<div class="sixteen columns alpha omega">
			<h3><?php the_title(); ?></h3>
		</div>
		<div class="sixteen columns alpha omega">
			<?php the_content(); ?>
		</div>
		<div class="sixteen columns share alpha omega">
			<div class="share-text"><p>Share this story:</p></div>
			<div class="share-icon">
				<div class="left">
					<ul class="list-social">
                        <li class="icon-soc"><a href="http://twitter.com/home?status=<?php the_title(); ?><?php the_permalink(); ?>">&#xf099;</a></li>
						<li class="icon-soc"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>">&#xf09a;</a></li>
					</ul>	
				</div>	
			</div>
			<div class="share-date"><p><?php echo get_the_date( 'F d, Y' ); ?> <em>By <?php the_author(); ?></em></p></div>
		</div>
        <div class="clearfix"></div>
		<?php comments_template( '', true ); ?>	
	</div>
</div>
<?php

}
get_footer();

?>