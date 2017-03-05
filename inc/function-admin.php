<?php

/*
@package digipentheme
	===============================
			ADMIN PAGE
	===============================
*/
//add_menu_page(string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null);

//add_submenu_page(string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '');

//register_setting($option_group, $option_name, $sanitize_callback);

//add_settings_section($id, $title, $callback, $page);

//add_settings_field($id, $title, $callback, $page, $section, $args);

//add_action(string $tag, callable $function_to_add, int $priority = 10, int $accepted_args = 1);

//settings_fields($page, $section);

//do_settings_sections( $page );

//get_option(string $option, mixed $default = false);
function digipen_add_admin_page(){

	//Generate admin page
	add_menu_page( 'DigitalpenPH Theme Options', 'Digipen', 'manage_options', 'mark_digipen', 'digipen_theme_create_page','dashicons-welcome-write-blog', 110 );

	//Generate admin sub page
	add_submenu_page('mark_digipen','Digipen Sidebar','Sidebar','manage_options','mark_digipen','digipen_theme_create_page');

	add_submenu_page('mark_digipen','Digipen Theme Options','Theme Options','manage_options','mark_digipen_theme','digipen_theme_support_page');

	add_submenu_page('mark_digipen','Digipen Contact Form','Contact Form','manage_options','mark_digipen_theme_contact','digipen_contact_form_page');

	add_submenu_page('mark_digipen','Digipen CSS Options','Custom CSS','manage_options','mark_digipen_css','digipen_custom_css_page');


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
	register_setting('digipen-contact-options', 'activate_contact');
	add_settings_section('digipen-contact-section', 'Contact Form', 'digipen_contact_section', 'mark_digipen_theme_contact');
	add_settings_field('activate-form', 'Activate Contact Form', 'digipen_activate_contact', 'mark_digipen_theme_contact', 'digipen-contact-section');
	//CUSTOM CSS
	register_setting('digipen-custom-css-option', 'digipen_css', 'digipen_sanitize_custom_css_handler');
	add_settings_section('digipen-custom-css-section', 'Custom Css', 'digipen_custom_css_section', 'digipen_custom_css_page');
	add_settings_field('custom-css', 'Insert Custom Css', 'digipen_custom_css_callback', 'digipen_custom_css_page', 'digipen-custom-css-section');
} 

function digipen_custom_css_section(){
	echo 'Lets Create Digipen Custom Css';
}

function digipen_custom_css_callback(){
	$css = get_option('digipen_css');
	$value = (empty($css) ? '/*Digipen Theme Custom Csss*/' : $css);
	echo '<div id="customCss">'.$value.'</div><textarea id="digipen_css" name="digipen_css" style="display: none; visibility: hidden;">'.$value.'</textarea>';
}

//Post Formats Callback Function
function digipen_post_formats_callback( $input ){
	return $input;
}

function digipen_theme_options(){
	echo 'Activate and Deactivate specific Theme Support Options';
}

function digipen_contact_section(){
	echo 'Activate and Deactivate Built-in Contact form';
}

function digipen_activate_contact(){
	$options = get_option('activate_contact');
	$checked = (@$options ==1 ? 'checked' : '');
	echo '<label><input type="checkbox" id="activate_contact" name="activate_contact" value="1" '.$checked.'/></label>';
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

function digipen_sanitize_custom_css_handler($input){
	$output = esc_textarea( $input );
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

function digipen_contact_form_page(){
	require_once(get_template_directory() . '/inc/templates/digipen-contact-form.php');
}

function digipen_custom_css_page(){
	require_once(get_template_directory() . '/inc/templates/digipen-custom-css.php');
}


function digipen_theme_settings_page(){

}
