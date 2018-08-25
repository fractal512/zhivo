<?php
function zhivo_create_product_taxonomies() {

	$labels = array(
		'name' => _x( 'Product Categories', 'taxonomy general name', 'zhivo' ),
		'singular_name' => _x( 'Product Category', 'taxonomy singular name', 'zhivo' ),
		'search_items' => __( 'Search Categories', 'zhivo' ),
		//'popular_items' => __( 'Popular Categories', 'zhivo' ), // non-hierarchical
		//'separate_items_with_commas' => __( 'Separate categories with commas', 'zhivo' ), // non-hierarchical
		//'add_or_remove_items' => __( 'Add or remove categories', 'zhivo' ), // non-hierarchical
		//'choose_from_most_used' => __( 'Choose from the most used categories', 'zhivo' ), // non-hierarchical
		'all_items' => __( 'All Categories', 'zhivo' ),
		'not_found' => __( 'No categories found.', 'zhivo' ),
		'back_to_items' => __( '&larr; Back to categories', 'zhivo' ),
		'parent_item' => __( 'Parent Category', 'zhivo' ), // hierarchical
		'parent_item_colon' => __( 'Parent Category:', 'zhivo' ), // hierarchical
		'edit_item' => __( 'Edit Category', 'zhivo' ),
		'view_item' => __( 'View Category', 'zhivo' ),
		'update_item' => __( 'Update Category', 'zhivo' ),
		'add_new_item' => __( 'Add New Category', 'zhivo' ),
		'new_item_name' => __( 'New Category Name', 'zhivo' ),
		'menu_name' => __( 'Categories', 'zhivo' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_admin_column' => true,
		'rewrite'           => array(
									'slug' => 'product-category',
									'hierarchical' => true
									)
	);

	register_taxonomy( 'zhivo_category', null, $args );

}
add_action( 'init', 'zhivo_create_product_taxonomies' );
