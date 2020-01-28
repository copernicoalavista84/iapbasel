<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );

// tempalte
$tmpl = '<ul class="portfolio">{content}</ul>';

echo '<div class="gallery">';
    
    $this->display_filters( $instance );
    echo $this->query( $instance, $tmpl );
    
echo '</div>';
?>