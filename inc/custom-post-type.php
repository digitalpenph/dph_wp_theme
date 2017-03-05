<?php

/*
@package digipentheme
	===============================
			THEME CUSTOM POST TYPE
	===============================
*/

$conact = get_option( 'activate_contact' );
if(@$conact ==  1){
	add_action('init', 'digipen_contact_custom_post_type');
	add_filter('manage_digipen-contact_posts_columns', 'digipen_set_digipencontact_columns'); 
	//add_filter('manage_ThisIsYourFiler_posts_columns', 'digipen_set_digipen_contact_columns');
	//Static manage_ _posts_columns filter Note: do not use underscore when naming filter
	add_action('manage_digipen-contact_posts_custom_column', 'digipen_contact_custom_column', 10, 2);
	//it is set to number 10 to triggered after the other codes 
	//it is set to number 2 because of the arguments used by the function digipen_contact_custom_column
	////Static manage_ _custom_column filter Note: do not use underscore when naming filter
	add_action('add_meta_boxes', 'digipen_contact_add_meta_box');
	add_action('save_post', 'digipen_save_contact_email_data'); //to make sure can't use when not save_post
}

/* CONTACT CPT */
function digipen_contact_custom_post_type(){
	$labels = array(
		'name' => 'Messages',
		'singular_name' => 'Message',
		'menu_name' => 'Messages',
		'name_admin_bar' => 'Message'
		);

	$args = array(
		'labels' => $labels,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_icon' => 'dashicons-email',
		'menu_position' => 26,
		'supports' => array( 'title', 'editor', 'author' )
		);
	register_post_type( 'digipen-contact', $args );

}

function digipen_set_digipencontact_columns($columns){
	//unset($columns['author']); to remove specific column in Message Table we remove here author columns
	$newColumns = array();
	$newColumns['title'] = 'Fullname';
	$newColumns['message'] = 'Message';
	$newColumns['email'] = 'Email';
	$newColumns['date'] = 'Date';
	return $newColumns;
}
//This loop through the Message table of each column, and post Id
function digipen_contact_custom_column($column, $post_id){ 
	switch ($column) {
		case 'message':
		//message column
			echo get_the_excerpt();
			//know automatically the post id
			break;
		case 'email': 
		//email column
			$email_val = get_post_meta($post_id, '_contact_email_value_key', true);
			echo '<a href="'.$email_val.'">'.$email_val.'</a>';
			break;
	}
}

/* CONTACT META BOX */
function digipen_contact_add_meta_box(){
//add_meta_box( string $id, string $title, callable $callback, string|array|WP_Screen $screen = null, string $context = 'advanced', string $priority = 'default', array $callback_args = null )
	add_meta_box('contact_email',  'User Email', 'digipen_contact_email_callback', 'digipen-contact', 'side');
}

function digipen_contact_email_callback($post){
	//wp_nonce_field(); is for security, to make sure the data was came from the user
	wp_nonce_field('digipen_save_contact_email_data', 'digipen_contact_email_meta_box_nonce'); //call back function digipen_save_contact_email_data
	$value = get_post_meta($post->ID, '_contact_email_value_key', true); //should always start in underscore _contact_email_value_key
	echo '<label for="digipen_contact_email_field"> User Email Address: </label>';
	echo '<input type="email" id="digipen_contact_email_field" name="digipen_contact_email_field" value="'. esc_attr($value) .'" size="25" />';
}

function digipen_save_contact_email_data($post_id){
	if(!isset($_POST['digipen_contact_email_meta_box_nonce'])){
		return;
	}
	if(!wp_verify_nonce($_POST['digipen_contact_email_meta_box_nonce'], 'digipen_save_contact_email_data')){
		return;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}
	if(!current_user_can('edit_post', $post_id)){
		return;
	}
	if(!isset($_POST['digipen_contact_email_field'])){
		return;
	}
	$my_data = sanitize_text_field($_POST['digipen_contact_email_field']);
	update_post_meta($post_id, '_contact_email_value_key', $my_data);
}

