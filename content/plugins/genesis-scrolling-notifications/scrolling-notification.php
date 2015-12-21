<?php 
/*
Plugin Name: Genesis Scrolling Notification 
Plugin URI: http://wpzombies.com/genesis-scrolling-notifications
Description: A simple way to display a notification bar to your users.
Version: 2.0
Author: Juan Rangel
Author URI: http://wpzombies.com/
*/

/**
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

/**
 * Assign Global Variables
 * 
 */

$options = array();

require( 'inc/register_notifications.php' );

/** 
* Load Scripts and Styles for the admin 
*
*/
function wpz_admin_scripts() {	
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'sn-admin', plugins_url( 'genesis-scrolling-notifications/js/admin.js' ), array( 'jquery', 'wp-color-picker' ) );

}
add_action( 'admin_enqueue_scripts', 'wpz_admin_scripts' );

/**
* Load Scripts and Styles the front end 
*
*/
function sn_load_scripts() {

	// enqueue scripts
	wp_register_script( 'quovolver', plugins_url( 'genesis-scrolling-notifications/js/jquery.quovolver.js' ), array( 'jquery' ) );
	wp_enqueue_script( 'main', plugins_url( 'genesis-scrolling-notifications/js/main.js' ), array( 'quovolver' ) );

	// enqueue styles
	wp_enqueue_style( 'sn-front-end', plugins_url( 'genesis-scrolling-notifications/css/main.css' ) );
}
add_action( 'wp_enqueue_scripts', 'sn_load_scripts');

/**
* Adds our menu page 
*
*/
function wpz_add_menu_page() {

	add_options_page( 
		'Scrolling Notification', 
		'Scrolling Notification', 
		'manage_options', 
		'wpz-scrolling-notifications',
		'wpz_display_options_page'
	);
}
add_action( 'admin_menu', 'wpz_add_menu_page' );

function wpz_display_options_page() {

	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficent permission to access this page.' );
	}

	global $options;

	if( isset( $_POST['gsn_form_submitted'] ) ) {

		$hidden_field = esc_html( $_POST['gsn_form_submitted'] );

		if( $hidden_field == 'Y' ) {

			$options['gsn_show_home'] = $_POST['gsn_show_home'];
			$options['gsn_bg_color'] = $_POST['gsn_bg_color'];

			update_option( 'gsn_options', $options );

		}	
	}

	$options = get_option( 'gsn_options' );

	if( $options != '' ) {
		$gsn_show_home = $options['gsn_show_home'];
		$gsn_bg_color = $options['gsn_bg_color'];
	}

	require( 'inc/options-page-wrapper.php' );
}

function wpz_display_notifications() {

	$options = get_option( 'gsn_options' );

	if ( $options['gsn_show_home'] == 1 ) {
		if ( is_singular() ) 
			return;
	}

	$query = new WP_Query( array(
		'post_type' => 'notification',
		'posts_per_page' => 5,
	) );


	if ( $query->have_posts() ) {
		?>
		<div id="sn-notification" class="js-hide" style="background:<?php echo $options['gsn_bg_color']; ?>;">
			<div class="wrap">
				<?php while( $query->have_posts() ) : $query->the_post(); ?>
				<div class="notification-post"><?php the_content(); ?></div>
				<?php endwhile; ?>
			</div>
		</div>
	<?php }
	wp_reset_postdata();
}
add_action( 'genesis_before_header', 'wpz_display_notifications' );