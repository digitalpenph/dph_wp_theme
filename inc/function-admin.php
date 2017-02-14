<?php

/*
@package digipentheme
	===============================
			ADMIN PAGE
	===============================
*/

function digipen_add_admin_page(){

	//Generate admin page
	add_menu_page( 'DigitalpenPH Theme Options', 'Digipen', 'manage_options', 'mark_digipen', 'digipen_theme_create_page','dashicons-welcome-write-blog', 110 );

	//Generate admin sub page
	add_submenu_page('mark_digipen','Digipen Sidebar','Sidebar','manage_options','mark_digipen','digipen_theme_create_page');

	add_submenu_page('mark_digipen','Digipen Theme Options','Theme Options','manage_options','mark_digipen_theme','digipen_theme_support_page');

	add_submenu_page('mark_digipen','Digipen Contact Form','Contact Form','manage_options','mark_digipen_theme_contact','digipen_theme_support_page');

	add_submenu_page('mark_digipen','Digipen CSS Options','Custom CSS','manage_options','mark_digipen_css','digipen_theme_settings_page');


	//Activate Custom Settings
	add_action('admin_init', 'digipen_custom_settings');
}

add_action('admin_menu', 'digipen_add_admin_page');

function digipen_custom_settings(){
	//Sidebar Options
	register_setting('digipen-settings-group','profile_picture');
	register_setting('digipen-settings-group','first_name');
	register_setting('digipen-settings-group','last_name');
	register_setting('digipen-settings-group','description');
	register_setting('digipen-settings-group','twitter', 'digipen_sanitize_twitter_handler');
	register_setting('digipen-settings-group','facebook');
	register_setting('digipen-settings-group','googleplus');

	add_settings_section('digipen-sidebar-options','Sidebar Options','digipen_sidebar_options','mark_digipen');

	add_settings_field('sidebar-profile-picture','Picture','digipen_sidebar_profile','mark_digipen','digipen-sidebar-options');
	add_settings_field('sidebar-name','Full Name','digipen_sidebar_name','mark_digipen','digipen-sidebar-options');
	add_settings_field('sidebar-description','Description','digipen_sidebar_description','mark_digipen','digipen-sidebar-options');
	add_settings_field('sidebar-twitter','Twitter handler','digipen_sidebar_twitter','mark_digipen','digipen-sidebar-options');
	add_settings_field('sidebar-facebook','Facebook handler','digipen_sidebar_facebook','mark_digipen','digipen-sidebar-options');
	add_settings_field('sidebar-googleplus','Google Plus handler','digipen_sidebar_googleplus','mark_digipen','digipen-sidebar-options');

	register_setting('digipen-theme-support', 'post_formats', 'digipen_post_formats_callback');

	add_settings_section('digipen-theme-options', 'Theme Options', 'digipen_theme_options', 'mark_digipen_theme');

	add_settings_field('post-formats', 'Post Formats', 'digipen_post_formats', 'mark_digipen_theme', 'digipen-theme-options');

	//Contact Form Options
	register_setting('digipen-contact-options', 'activate');
	add_settings_section('digipen-contact-section', 'Contact Form', 'digipen_contact_section', 'mark_digipen_theme_contact');
	add_settings_field('activate-form', 'Activate Contact Form', 'digipen_activate_contact', 'mark_digipen_theme_contact', 'digipen-contact-section');
} 

//Post Formats Callback Function
function digipen_post_formats_callback( $input ){
	return $input;
}

function digipen_theme_options(){
	echo 'Activate and Deactivate specific Theme Support Options';
}

function digipen_post_formats(){
	$options = get_option('post_formats');
	$formats = array('aside', 'gallery', 'link', 'images', 'quote', 'status', 'video', 'audio', 'chat');
	$output = '';
	foreach ($formats as  $format) {
		$checked = ( @$options[$format] == 1 ? 'checked' : '' );
		$output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.'> '.$format.'</label><br>';
	}
	echo $output;
}

// Sidebar Options Fucntions
function digipen_sidebar_options(){
	echo 'Customize your sidebar';
}

function digipen_sidebar_profile(){
	$picture = esc_attr( get_option('profile_picture') );
	if(empty($picture)){
		echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button"/>
		<input type="hidden" id="profile-picture" name="profile_picture" value=""/>';
	} else {
		echo '<input type="button" class="button button-secondary" value="Replace" id="upload-button"/>
		<input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'"/>
		<input type="button" class="button button-secondary" value="Remove" id="remove-picture"/>';
	}
}

function digipen_sidebar_name(){
	$firstname = esc_attr( get_option('first_name') );
	$lastname = esc_attr( get_option('last_name') );
	echo '<input type="text" name="first_name" value="'.$firstname.'" placeholder="First Name"/><input type="text" name="last_name" value="'.$lastname.'" placeholder="First Name"/>';
}

function digipen_sidebar_description(){
	$description = esc_attr( get_option('description') );
	echo '<textarea name="description">'.$description.'</textarea>';
}

function digipen_sidebar_twitter(){
	$twitter = esc_attr( get_option('twitter') );
	echo '<input type="text" name="twitter" value="'.$twitter.'" placeholder="Twitter"/><p class="description">Input something new</p>';
}

function digipen_sidebar_facebook(){
	$facebook = esc_attr( get_option('facebook') );
	echo '<input type="text" name="facebook" value="'.$facebook.'" placeholder="Facebook"/>';
}

function digipen_sidebar_googleplus(){
	$googleplus = esc_attr( get_option('googleplus') );
	echo '<input type="text" name="googleplus" value="'.$googleplus.'" placeholder="Google Plus"/>';
}

function digipen_sanitize_twitter_handler($input){
	$output = sanitize_text_field( $input );
	$output = str_replace('@', '', $output);
	return $output;
}

//Template submenu functions
function digipen_theme_create_page(){
	//generation of admin page
	require_once(get_template_directory() . '/inc/templates/digipen-admin.php');
}

function digipen_theme_support_page(){
	require_once(get_template_directory() . '/inc/templates/digipen-theme-support.php');
}

function digipen_theme_settings_page(){

}
