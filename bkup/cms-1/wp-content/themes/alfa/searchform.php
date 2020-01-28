<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
     <div id="search-bar" class="clearfix">
       	<input type="text" name="s" placeholder="Search" value="<?php echo get_search_query(); ?>">
        <input type="submit" value="">
    </div>
</form>