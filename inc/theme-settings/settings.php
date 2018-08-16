<?php
use Carbon_Fields\Field;
use Carbon_Fields\Container;

function zhivo_attach_theme_settings() {
	$zhivo_theme_settings = Container::make( 'theme_options', 'theme_settings', __('Theme settings', 'zhivo') )->set_page_parent('themes.php');

	require get_template_directory() . '/inc/theme-settings/header-settings.php';
	require get_template_directory() . '/inc/theme-settings/footer-settings.php';
}
add_action( 'carbon_fields_register_fields', 'zhivo_attach_theme_settings' );
