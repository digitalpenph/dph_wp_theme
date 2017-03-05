<h1>Digipen Custom Css</h1>
<?php settings_errors(); ?>

<form id="save-custom-css-form" method="post" action="options.php">
	<?php settings_fields('digipen-custom-css-option'); ?>
	<?php do_settings_sections('digipen_custom_css_page'); ?>
	<?php submit_button(); ?>
</form>