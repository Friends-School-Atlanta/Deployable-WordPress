<?php 

function register_notification_type() {

	$labels = array(
		'name'               => _x( 'Notifications', 'post type general name', 'scrolling_notifications' ),
		'singular_name'      => _x( 'Notification', 'post type singular name', 'scrolling_notifications' ),
		'menu_name'          => _x( 'Notifications', 'admin menu', 'scrolling_notifications' ),
		'name_admin_bar'     => _x( 'Notification', 'add new on admin bar', 'scrolling_notifications' ),
		'add_new'            => _x( 'Add New', 'Notification', 'scrolling_notifications' ),
		'add_new_item'       => __( 'Add New Notification', 'scrolling_notifications' ),
		'new_item'           => __( 'New Notification', 'scrolling_notifications' ),
		'edit_item'          => __( 'Edit Notification', 'scrolling_notifications' ),
		'view_item'          => __( 'View Notification', 'scrolling_notifications' ),
		'all_items'          => __( 'All Notifications', 'scrolling_notifications' ),
		'search_items'       => __( 'Search Notifications', 'scrolling_notifications' ),
		'parent_item_colon'  => __( 'Parent Notifications:', 'scrolling_notifications' ),
		'not_found'          => __( 'No Notifications found.', 'scrolling_notifications' ),
		'not_found_in_trash' => __( 'No Notifications found in Trash.', 'scrolling_notifications' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'menu_icon'          => 'dashicons-tag',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'notification' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' )
	);

	register_post_type( 'notification', $args );
}
add_action( 'init', 'register_notification_type' );