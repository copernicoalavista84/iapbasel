<?php
/*
Plugin Name: WP Time Remover
Plugin URI: http://www.moelia.com
Description: This is a wordpress plugin that removes or hide time of a particular post or page in your wordpress blog.
Author: Jorge Sanchez
Version: 1.0
Author URI: http://www.moelia.com
*/

//remove date from
$locations = array('is_home','is_single','is_page');

//date functions used in your template
$date_functions = array('the_time','get_the_time');

//call date remover on loop start wordpress action
add_action('loop_start', 'date_remover');

//main date remover function
function date_remover()
{
	global $locations, $date_functions;
	
	foreach($locations as $location)
	{
		if(function_exists($location))
		{
			remove_date($date_functions);
		}
	}
}

//remove date function
function remove_date($date_functions)
{
	foreach ($date_functions as $date_function)
	{
		add_filter($date_function, 'erase_date');
	}
}
//erase function
function erase_date(){}
#END OF PHP FILE