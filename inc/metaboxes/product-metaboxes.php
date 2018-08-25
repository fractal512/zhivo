<?php
use Carbon_Fields\Field;
use Carbon_Fields\Container;

function zhivo_product_meta() {
	Container::make( 'post_meta', 'product_meta', __( 'Product Meta', 'zhivo' ) )
			->where( 'post_type', '=', 'zhivo_product' )
			->add_fields( array(
				Field::make( 'text', 'price', __( 'Product Price', 'zhivo' ) )
			) );
}
add_action( 'carbon_fields_register_fields', 'zhivo_product_meta' );
