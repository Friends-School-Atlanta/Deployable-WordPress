<?php
// hook into the init action and call create_staff_postitions_taxonomy when it fires
add_action( 'init', 'sbg_create_staff_postitions_taxonomy', 0 );

// create two taxonomies, genres and writers for the post type "staff"
function sbg_create_staff_postitions_taxonomy() {

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Staff Positions', 'taxonomy general name' ),
		'singular_name'     => _x( 'Staff Position', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Staff Positions' ),
		'all_items'         => __( 'All Staff Positions' ),
		'parent_item'       => __( 'Parent Staff Position' ),
		'parent_item_colon' => __( 'Parent Staff Position:' ),
		'edit_item'         => __( 'Edit Staff Position' ),
		'update_item'       => __( 'Update Staff Position' ),
		'add_new_item'      => __( 'Add New Staff Position' ),
		'new_item_name'     => __( 'New Staff Position Name' ),
		'menu_name'         => __( 'Staff Positions' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'staff-positions' ),
	);

	register_taxonomy( 'staff-position', array( 'staff-member' ), $args );
}