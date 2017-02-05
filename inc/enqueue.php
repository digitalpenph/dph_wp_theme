<?php

/*
@package digipentheme
	===============================
			ADMIN ENQUEUE FUNCTIONS
	===============================
*/

function digipen_load_admin_scripts( $hook ){

	if('toplevel_page_mark_digipen' != $hook){ return; }
	
	wp_register_style('site_admin', get_template_directory_uri() . '/css/digipentheme-admin.css', array(), '1.0.0', 'all');
	wp_enqueue_style('site_admin');

	wp_enqueue_media();

	wp_register_script('digipen_admin_script', get_template_directory_uri() . '/js/digipentheme-admin.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('digipen_admin_script');
}
add_action('admin_enqueue_scripts', 'digipen_load_admin_scripts');