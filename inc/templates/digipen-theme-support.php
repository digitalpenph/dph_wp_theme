<h1>Digipen Theme Option</h1>
<?php settings_errors(); ?>

<form method="post" action="options.php">
	<?php settings_fields('digipen-theme-support'); ?>
	<?php do_settings_sections('mark_digipen_theme'); ?>
	<?php submit_button(); ?>
</form>