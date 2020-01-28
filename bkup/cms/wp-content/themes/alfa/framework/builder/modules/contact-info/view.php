<?php

echo '<div class="contact-info clearfix">';

if ( $email )
    echo '<div class="one-third column alpha"><div class="text-and-icon"><div class="icon-c">&#xf003;</div><h4><a href="mailto:' . $email . '"><span>' . $email . '</span></a></h4></div></div>';
if ( $phone )
    echo '<div class="one-third column"><div class="text-and-icon"><div class="icon-c">&#xf10b;</div><h4>' . $phone . '</h4></div></div>';
if ( $address )
    echo '<div class="one-third column omega"><div class="text-and-icon"><div class="icon-c">&#xf015;</div><h4>' . $address . '</h4></div></div>';

echo '</div>';

?>