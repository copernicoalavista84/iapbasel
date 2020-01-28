<?php if( is_single() ) return; ?>
<div id="copyright">
	<div class="container">	
    	<?php
            $socials = get_setting_array( 'socials' );
            
            if( !empty( $socials ) ) {
        ?>
        <div class="sixteen columns">
			<div class="left">
				<ul class="list-social-contact">
                <?php foreach( $socials as $item ) { ?>
					<li class="icon-soc-contact"><a href="<?php echo $item['link']; ?>"><img src="<?php echo assets_img() . 'soc/' . $item['icon'] . '.png'; ?>" alt="" /></a></li>
                <?php } ?>
				</ul>	
			</div>
		</div>
        <?php } ?>
		<div class="sixteen columns">
			<div class="border-footer"></div>
		</div>
		<div class="sixteen columns">
		<?php
            echo do_shortcode( get_setting( 'copyright_text' ) ); 
        ?>
		</div>
	</div>
</div>