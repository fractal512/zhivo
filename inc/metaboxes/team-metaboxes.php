<?php
use Carbon_Fields\Field;
use Carbon_Fields\Container;

function zhivo_team_meta() {
	Container::make( 'post_meta', 'employee_meta', __( 'Employee Meta', 'zhivo' ) )
			->where( 'post_type', '=', 'zhivo_team' )
			->add_fields( array(
				Field::make( 'select', 'zhivo_team_position', __( 'Employee Position', 'zhivo' ) )
				->add_options( array(
					'ceo' => __( 'CEO', 'zhivo' ),
					'manager' => __( 'Manager', 'zhivo' ),
					'accountant' => __( 'Accountant', 'zhivo' ),
					'cleaner' => __( 'Cleaner', 'zhivo' ),
				) )
			) );
}
add_action( 'carbon_fields_register_fields', 'zhivo_team_meta' );

//zhivo_add_meta_to_search('_zhivo_team_first_name');
//zhivo_add_meta_to_search('_zhivo_team_position');
