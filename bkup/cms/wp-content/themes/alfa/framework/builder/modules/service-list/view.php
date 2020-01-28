<?php

if( empty( $list ) ) return;

echo '<div class="services-list ' . $style . '-list">';

    if( $title ) echo '<h6><span>' . $title . '</span></h6>';
    
    echo '<ul>';
        foreach( $list as $item ) {
            
            echo '<li><p>' . $item['content'] . '</p></li>';
        }
    echo '</ul>';
    
echo '</div>';
?>