<?php

if( empty( $mates ) ) return;

$atts = array(
    'callback' => 'generate_mate_item',
    'row' => false,
    'columns' => 4,
);
echo spyropress_column_generator( $atts, $mates );
?>