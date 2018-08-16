<?php
use Carbon_Fields\Field;

$zhivo_theme_settings->add_tab( __('Footer', 'zhivo'), array(
		Field::make( 'text', 'zhv_footer_copyright', __('Footer Copyright', 'zhivo') )
			->set_attribute( 'placeholder', __('&copy; All rights reserved.', 'zhivo') )
			->set_default_value( __('&copy; All rights reserved.', 'zhivo') ),
	) );
