<?php
/**
 * This file adds the custom staff post type archive template.
 *
 */
 
// Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
 
// Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
 
// Remove post title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// add the fullwidth wrapper divs
add_action( 'genesis_before_loop', 'sbg_add_fullwidth_classes' );
function sbg_add_fullwidth_classes() {
	echo '<article class="page type-page status-publish entry">';
}

add_action( 'genesis_after_loop', 'sbg_add_fullwidth_classes_end' );
function sbg_add_fullwidth_classes_end() {
	echo '</article>';
}

// Modify the Excerpt read more link
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
	return '... <a class="more-link" href="' . get_permalink() . '">Read More</a>';
}
 
// Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'sbg_previous_page_link' );
function sbg_previous_page_link ( $text ) {
	return g_ent( '&laquo; ' ) . __( 'Previous Page', CHILD_DOMAIN );
}
 
// Customize the next page link
add_filter ( 'genesis_next_link_text' , 'sbg_next_page_link' );
function sbg_next_page_link ( $text ) {
	return __( 'Next Page', CHILD_DOMAIN ) . g_ent( ' &raquo; ' );
}
 
// Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
 
// Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
 
// Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Remove the post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
 
// Add staff-grid-archive body class
add_filter( 'body_class', 'sbg_add_staff_body_class' );
function sbg_add_staff_body_class( $classes ) {
	$classes[] = 'staff-grid-archive';
	return $classes;
}
 
// Display as columns
add_filter( 'post_class', 'sbg_portfolio_post_class' );
function sbg_portfolio_post_class( $classes ) {
	$columns = 4;
	$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
	$classes[] = $column_classes[$columns];
	global $wp_query;
	if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns )
		$classes[] = 'first';
 
	return $classes;
}

// add the thickbox
add_action ('genesis_before_loop', 'sbg_staff_grid_title');
function sbg_staff_grid_title() {
	add_thickbox();
	// echo '<h1 itemprop="headline" class="staff-section-title">Staff Members</h1>';
}
 
// Featured image, post title and meta
add_action( 'genesis_entry_header', 'sbg_staff_grid' );
function sbg_staff_grid() {
	if ( $image = genesis_get_image( 'format=url&size=staff-member' ) ) {
		printf( '<div class="staff-featured-image"><a class="thickbox"' . 'title="' . get_the_title() . '"' . ' href="#TB_inline?height=300&width=600&inlineId=%s"><img src="%s" alt="%s" /></a></div>', sbg_thethickboxcontent(), $image, the_title_attribute( 'echo=0' ) );
 
		echo '<div class="title-meta">';
			genesis_do_post_title();
			genesis_post_meta();
		echo '</div>';
	} else {
		echo '<div class="staff-featured-image">';

		echo '<img src="' . plugins_url( '/img/sampleimg.jpg', dirname( dirname( __FILE__ ) ) ) . '"/>';

		echo '<div class="title-meta">';
			genesis_do_post_title();
			genesis_post_meta();
		echo '</div>';

		echo '</div>';
	}
 
}

// Construct the link for each featured image. Ex.: #staff-member1 for latest Staff post, #staff-member2 for the post before that and so on..
function sbg_thethickboxcontent() {
	global $wp_query;
	return 'thestaffcontent' . ($wp_query->current_post + 1);
}
 
 
add_action ( 'genesis_entry_footer', 'display_thickbox_content' );
function display_thickbox_content() {
	global $wp_query;
	echo '<div style="display:none;" id="thestaffcontent' . ($wp_query->current_post + 1) . '">';
		echo '<p>'. get_the_content() . '</p>';
	echo '</div>';
}
 
genesis();