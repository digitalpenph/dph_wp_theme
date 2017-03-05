<h1>Digipen Contact Form</h1>
<?php settings_errors(); ?>

<form method="post" action="options.php">
	<?php settings_fields('digipen-contact-options'); ?>
	<?php do_settings_sections('mark_digipen_theme_contact'); ?>
	<?php submit_button(); ?>
</form>