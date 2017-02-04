<?php

/*
@package digipentheme
	===============================
			ADMIN PAGE
	===============================
*/

function digipen_add_admin_page(){

	add_menu_page( 'DigitalpenPH Theme Options', 'Digipen', 'manage_options', 'mark-digipen', 'digipen_theme_create_page', '', 110 );

}
add_action();
