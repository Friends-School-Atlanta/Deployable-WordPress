<?php
/**
 * This file adds the custom staff post type single post template.
 *
 */
 
// Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
 
// Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
 
// Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
 
// Remove the post meta function
// remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
 
// Add the featured image
add_action( 'genesis_entry_content', 'sbg_show_featured_image', 9 );
function sbg_show_featured_image() {
	if ( $image = genesis_get_image( 'format=url&size=staff-member-single' ) ) {
		printf( '<div class="staff-featured-image-sigle"><img src="%s" alt="%s" class="alignright" /></div>', $image, the_title_attribute( 'echo=0' ) );
	}
}
 
// Previous and Next Post navigation
// add_action('genesis_before_loop', 'sbg_custom_post_nav', 0);
function sbg_custom_post_nav() {
	echo '<div class="prev-next-post-links">';
		previous_post_link('<div class="previous-post-link">&laquo; %link</div>', '<strong>%title</strong>' );
		next_post_link('<div class="next-post-link">%link &raquo;</div>', '<strong>%title</strong>' );
	echo '</div>';
}
 
genesis();