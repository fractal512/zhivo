<?php
function zhivo_create_team_post_type() {

	$labels = array(
		'name' => _x('Team', 'post type general name', 'zhivo'),
		'singular_name' => _x('Employee', 'post type singular name', 'zhivo'),
		'menu_name' => _x('Our Team', 'admin menu', 'zhivo'),
		'name_admin_bar' => _x('Employee', 'add new on admin bar', 'zhivo'),
		'add_new' => _x('Add Employee', 'employee', 'zhivo'),
		'add_new_item' => __('Add New Employee', 'zhivo'),
		'edit_item' => __('Edit Employee Data', 'zhivo'),
		'new_item' => __('New Employee', 'zhivo'),
		'view_item' => __('View Employee Data', 'zhivo'),
		'view_items' => __('View Employees', 'zhivo'),
		'all_items' => __('All Employees', 'zhivo'),
		'search_items' => __('Search Employees', 'zhivo'),
		'not_found' => __('No employees found.', 'zhivo'),
		'not_found_in_trash' => __('No employees found in Trash.', 'zhivo'),
		//'parent_item_colon' => __('Parent Employee:', 'zhivo'), // hierarchical
		'archives' => __('Employees Archives', 'zhivo'),
		'attributes' => __('Employee Attributes', 'zhivo'),
		'insert_into_item' => __('Insert into employee data', 'zhivo'),
		'uploaded_to_this_item' => __('Uploaded to this employee', 'zhivo'),
		'featured_image' => __('Employee Photo', 'zhivo'),
		'set_featured_image' => __('Set employee photo', 'zhivo'),
		'remove_featured_image' => __('Remove employee photo', 'zhivo'),
		'use_featured_image' => __('Use as employee photo', 'zhivo'),
		'filter_items_list' => __('Filter employees list', 'zhivo'),
		'items_list_navigation' => __('Employees list navigation', 'zhivo'),
		'items_list' => __('Employees List', 'zhivo')
	);

	$args = array(
		'labels' => $labels,
		'show_ui' => true,
		'menu_icon' => 'dashicons-businessman',
		'hierarchical' => false,
		'rewrite' => false,
		'supports'=> array('title', 'editor', 'thumbnail', 'page-attributes')
	);

	register_post_type( 'zhivo_team', $args );

}
add_action( 'init', 'zhivo_create_team_post_type' );

function zhivo_team_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['zhivo_team'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Employee data updated.', 'zhivo' ),
		2 => __( 'Custom field updated.', 'zhivo' ),
		3 => __( 'Custom field deleted.', 'zhivo' ),
		4 => __( 'Employee data updated.', 'zhivo' ),
		/* translators: %s: date and time of the revision */
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Employee restored to revision from %s', 'zhivo' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => __( 'Employee published.', 'zhivo' ),
		7 => __( 'Employee saved.', 'zhivo' ),
		8 => __( 'Employee submitted.', 'zhivo' ),
		9 => sprintf(
			// translators: Formatted date, see http://php.net/date
			__( 'Employee scheduled for: <strong>%1$s</strong>.', 'zhivo' ),
			date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $post->post_date ) )
		),
		10 => __( 'Employee draft updated.', 'zhivo' )
	);

	if ( $post_type_object->publicly_queryable && 'zhivo_team' === $post_type ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View employee', 'zhivo' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview employee', 'zhivo' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}
add_filter( 'post_updated_messages', 'zhivo_team_updated_messages' );

// Show and manage columns in admin panel
function zhivo_team_edit_columns( $columns ) {

	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"thumbnail" => __( 'Photo', 'zhivo' ),
		"title" => __( 'Employee', 'zhivo' ),
		"_zhivo_team_position" => __( 'Position', 'zhivo' ),
		"menu_order" => __( 'Order', 'zhivo' ),
		"date" => __( 'Added', 'zhivo' )
		);

	return $columns;

}
add_filter( "manage_zhivo_team_posts_columns", "zhivo_team_edit_columns" );

function zhivo_team_custom_columns( $column ) {

	global $post;
	$custom = get_post_custom();
	$position = array(
					'ceo' => __( 'CEO', 'zhivo' ),
					'manager' => __( 'Manager', 'zhivo' ),
					'accountant' => __( 'Accauntant', 'zhivo' ),
					'cleaner' => __( 'Cleaner', 'zhivo' ),
					);

	switch ($column)
		{
			case "thumbnail":
				edit_post_link( wp_get_attachment_image( $custom["_thumbnail_id"][0], 'zhivo-admin-thumb' ) );
			break;
			case "_zhivo_team_position":
				echo $position[$custom["_zhivo_team_position"][0]];
			break;
			case "menu_order":
				echo $post->menu_order;
			break;
		}
}
add_action( "manage_zhivo_team_posts_custom_column", "zhivo_team_custom_columns" );

function zhivo_team_sortable_columns( $columns ) {

	$columns['_zhivo_team_position'] = '_zhivo_team_position';
	$columns['menu_order'] = 'menu_order';

	return $columns;
}
add_filter( 'manage_edit-zhivo_team_sortable_columns', 'zhivo_team_sortable_columns' );

function zhivo_team_default_order( $query ) {
	if( ! is_admin() ) return;
	if ( is_admin() && ! $query->is_main_query() ) {
		return;
	}
	if( $query->get('post_type') == 'zhivo_team' ){
		if( $query->get('orderby') == '' )
			$query->set('orderby','menu_order');

		if( $query->get('order') == '' )
			$query->set('order','ASC');
	}
}
add_action( 'pre_get_posts', 'zhivo_team_default_order' );

/* Sorts the custom post type. */
function zhivo_sort_team( $vars ) {

	/* Check if we're viewing the right post type. */
	if ( isset( $vars['post_type'] ) && 'zhivo_team' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to the needed meta. */
		if ( isset( $vars['orderby'] ) && '_zhivo_team_position' == $vars['orderby'] ) {
			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_zhivo_team_position',
					'orderby' => 'meta_value'
				)
			);
		}

	}

	return $vars;
}

/* Only run our customization on the 'edit.php' page in the admin. */
function zhivo_team_load() {
	add_filter( 'request', 'zhivo_sort_team' );
}
add_action( 'load-edit.php', 'zhivo_team_load' );
