<?php
use Carbon_Fields\Field;

$zhivo_theme_settings->add_tab( __('Header', 'zhivo'), array(
		Field::make( 'text', 'zhv_header_tagline', __('Site tagline', 'zhivo') )
			->set_attribute( 'placeholder', 'Type site slogan here...' ),

		Field::make( 'complex', 'zhv_header_phones', __('Phones', 'zhivo') )
			->set_layout( 'tabbed-horizontal' )
			->add_fields( array(
				Field::make( 'text', 'phone', __('Phone number', 'zhivo') )
					->set_attribute( 'placeholder', '+380 (44) 123-45-67' )
					->set_default_value( '+380 (44) 123-45-67' ),
			) )
			->set_header_template(__('Phone', 'zhivo') . ' <%- $_index+1 %>'),
	) );
