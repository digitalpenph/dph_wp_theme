<?php

/*
@package digipentheme
	===============================
			THEME 
	===============================
*/

$options = get_option('post_formats');
$formats = array('aside', 'gallery', 'link', 'images', 'quote', 'status', 'video', 'audio', 'chat');
$ouput = array();
	foreach ($formats as  $format) {
		$output[] = ( @$options[$format] == 1 ? $format : '' );
	}
if(!empty($options)){
	add_theme_support('post-formats', $output);
}