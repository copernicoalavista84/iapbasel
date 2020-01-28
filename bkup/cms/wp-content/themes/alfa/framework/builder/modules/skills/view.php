<?php

if( empty( $skills ) ) return;

echo '<div class="pro-bar-wrap">';
    
    if( $title ) echo '<h6>' . $title . '</h6>';
    
    foreach( $skills as $skill ) {
        
        echo '
        <div class="pro-bar">
			<div class="caption">
				<div>' . $skill['title'] . '</div>	
			</div>
			<div class="progress-bar orange stripes">
				<span style="width: ' . $skill['percentage'] . '%"></span>
			</div>
		</div>';
    }
echo '</div>';
?>