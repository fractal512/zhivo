<?php
function zhivo_create_product_post_type() {

	$labels = array(
		'name' => _x('Products', 'post type general name', 'zhivo'),
		'singular_name' => _x('Product', 'post type singular name', 'zhivo'),
		'menu_name' => _x('Products', 'admin menu', 'zhivo'),
		'name_admin_bar' => _x('Product', 'add new on admin bar', 'zhivo'),
		'add_new' => _x('Add New', 'product', 'zhivo'),
		'add_new_item' => __('Add New Product', 'zhivo'),
		'edit_item' => __('Edit Product', 'zhivo'),
		'new_item' => __('New Product', 'zhivo'),
		'view_item' => __('View Product', 'zhivo'),
		'view_items' => __('View Products', 'zhivo'),
		'all_items' => __('All Products', 'zhivo'),
		'search_items' => __('Search Products', 'zhivo'),
		'not_found' => __('No products found.', 'zhivo'),
		'not_found_in_trash' => __('No products found in Trash.', 'zhivo'),
		//'parent_item_colon' => __('Parent Product:', 'zhivo'), // hierarchical
		'archives' => __('Products Archives', 'zhivo'),
		'attributes' => __('Product Attributes', 'zhivo'),
		'insert_into_item' => __('Insert into product data', 'zhivo'),
		'uploaded_to_this_item' => __('Uploaded to this product', 'zhivo'),
		'featured_image' => __('Product image', 'zhivo'),
		'set_featured_image' => __('Set product image', 'zhivo'),
		'remove_featured_image' => __('Remove product image', 'zhivo'),
		'use_featured_image' => __('Use as product image', 'zhivo'),
		'filter_items_list' => __('Filter products list', 'zhivo'),
		'items_list_navigation' => __('Products list navigation', 'zhivo'),
		'items_list' => __('Products List', 'zhivo')
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'menu_icon' => 'dashicons-cart',
		'hierarchical' => false,
		'taxonomies' => array( 'zhivo_category' ),
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'zhivo-product' ),
		'supports'=> array('title', 'editor', 'thumbnail')
	);

	register_post_type( 'zhivo_product', $args );

}
add_action( 'init', 'zhivo_create_product_post_type' );

function zhivo_product_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['zhivo_product'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Product updated.', 'zhivo' ),
		2 => __( 'Custom field updated.', 'zhivo' ),
		3 => __( 'Custom field deleted.', 'zhivo' ),
		4 => __( 'Product updated.', 'zhivo' ),
		/* translators: %s: date and time of the revision */
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Product restored to revision from %s', 'zhivo' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => __( 'Product published.', 'zhivo' ),
		7 => __( 'Product saved.', 'zhivo' ),
		8 => __( 'Product submitted.', 'zhivo' ),
		9 => sprintf(
			// translators: Formatted date, see http://php.net/date
			__( 'Product scheduled for: <strong>%1$s</strong>.', 'zhivo' ),
			date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $post->post_date ) )
		),
		10 => __( 'Product draft updated.', 'zhivo' )
	);

	if ( $post_type_object->publicly_queryable && 'zhivo_product' === $post_type ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View product', 'zhivo' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview product', 'zhivo' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}
add_filter( 'post_updated_messages', 'zhivo_product_updated_messages' );

// Show and manage columns in admin panel
function zhivo_product_edit_columns( $columns ) {

	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"thumbnail" => __( 'Image', 'zhivo' ),
		"title" => __( 'Product', 'zhivo' ),
		"taxonomy-zhivo_category" => __( 'Product Categories', 'zhivo' ),
		"date" => __( 'Added', 'zhivo' )
		);

	return $columns;

}
add_filter( "manage_zhivo_product_posts_columns", "zhivo_product_edit_columns" );

function zhivo_product_custom_columns( $column ) {

	global $post;
	$custom = get_post_custom();

	switch ($column)
		{
			case "thumbnail":
				edit_post_link( wp_get_attachment_image( $custom["_thumbnail_id"][0], 'zhivo-admin-thumb' ) );
			break;
		}
}
add_action( "manage_zhivo_product_posts_custom_column", "zhivo_product_custom_columns" );
