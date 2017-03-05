<?php
//settings_fields($page, $section);
//do_settings_sections( $page );
//get_option(string $option, mixed $default = false);
?>
<h1>Digipen Sidebar Option</h1>
<?php settings_errors(); ?>
<?php $firstname = esc_attr( get_option('first_name') ); ?>
<?php $lastname = esc_attr( get_option('last_name') ); ?>
<?php $description = esc_attr( get_option('description') ); ?>
<?php $picture = esc_attr( get_option('profile_picture') ); ?>

<?php $fullname = $firstname.' '.$lastname; ?>

<div class="digipen-sidebar-preview">
	<div class="digipen-sidebar">
		<div class="image-container">
			<div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?php print $picture ?>);"></div>
		</div>
		<h1 class="digipen-username"><?php print $fullname ?></h1>
		<h2 class="digipen-description"><?php print $description ?></h2>
		<div class="icons-wrapper">
		</div>
	</div>
</div>
<form id="submitForm" method="post" action="options.php" class="digipen-general-form">
	<?php settings_fields('digipen-settings-group'); ?>
	<?php do_settings_sections('mark_digipen'); ?>
	<?php submit_button('Save Changes', 'primary', 'btnSubmit'); ?>
</form>