<?php 
add_action( 'init', 'sbg_register_staff_member_post_type' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function sbg_register_staff_member_post_type() {
    $labels = array(
        'name'               => _x( 'Staff Members', 'post type general name', 'staff-bio-grid' ),
        'singular_name'      => _x( 'Staff Member', 'post type singular name', 'staff-bio-grid' ),
        'menu_name'          => _x( 'Staff', 'admin menu', 'staff-bio-grid' ),
        'name_admin_bar'     => _x( 'Staff Member', 'add new on admin bar', 'staff-bio-grid' ),
        'add_new'            => _x( 'Add New', 'book', 'staff-bio-grid' ),
        'add_new_item'       => __( 'Add Staff Member', 'staff-bio-grid' ),
        'new_item'           => __( 'New Staff Member', 'staff-bio-grid' ),
        'edit_item'          => __( 'Edit Staff Member', 'staff-bio-grid' ),
        'view_item'          => __( 'View Staff Member', 'staff-bio-grid' ),
        'all_items'          => __( 'All Staff Members', 'staff-bio-grid' ),
        'search_items'       => __( 'Search Staff', 'staff-bio-grid' ),
        'parent_item_colon'  => __( 'Parent Staff Member:', 'staff-bio-grid' ),
        'not_found'          => __( 'No staff members found.', 'staff-bio-grid' ),
        'not_found_in_trash' => __( 'No staff members found in Trash.', 'staff-bio-grid' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-id-alt',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'staff' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );

    register_post_type( 'staff-member', $args );
}