<?php

// Setup Instance for view
$instance = spyropress_clean_array( $instance );

// tempalte
$tmpl = '{content}';
    
echo '<div id="works">';
  
    // output content
    echo $this->query( $instance, $tmpl );

echo '</div>';
?>