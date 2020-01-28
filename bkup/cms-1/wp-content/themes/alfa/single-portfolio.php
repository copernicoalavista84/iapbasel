<?php

get_header();

while( have_posts() ) {
    the_post();
?>
<div id="work">
	<div class="container">
		<div class="sixteen columns">
			<div id="cbp-fwslider" class="cbp-fwslider">
			<?php
                $details = get_post_meta( get_the_ID(), '_portfolio_details', true );
                $excludes = array( get_post_thumbnail_id(), get_attachment_id_by_src( $details['client_logo'] ) );
                $excludes = spyropress_clean_array( $excludes );
                
                echo get_gallery(array(
                    'before'    => '<ul>',
                    'after'     => '</ul>',
                    'exclude'   => $excludes
                ));
            ?>
			</div>
		</div>
		<div class="twelve columns">
			<h6><?php the_title(); ?></h6>
            <?php the_content(); ?>
		</div>
        <?php
            $terms = get_the_terms( get_the_ID(), 'portfolio_tags' );
            
            if( !empty( $terms ) ) {
        ?>
		<div class="services-list arrow-list">	
			<div class="four columns">
				<ul>
				<?php
                    foreach( $terms as $term )
                        echo '<li><p>' . $term->name . '</p></li>';
                ?>
				</ul>	
			</div>	
		</div>
        <?php } ?>		
	</div>
</div>
<?php

}
get_footer();

?>