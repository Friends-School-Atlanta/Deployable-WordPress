<?php

/**
 * Plugin Name: All-In-One Intranet Premium
 * Plugin URI: http://wp-glogin.com/all-in-one-intranet
 * Description: Instantly turn WordPress into a private corporate intranet 
 * Version: 1.2
 * Author: Dan Lester
 * Author URI: http://wp-glogin.com/
 * License: Premium Paid per WordPress site
 * Network: true
 * 
 * Do not copy, modify, or redistribute without authorization from author Lesterland Ltd (contact@wp-glogin.com)
 * 
 * You need to have purchased a license to install this software on a maxium of the number of computers you specified 
 * when you purchased this software.
 * 
 * You are not authorized to use, modify, or distribute this software beyond the license that you
 * have purchased.
 * 
 * You must not remove or alter any copyright notices on any and all copies of this software.
 * 
 * This software is NOT licensed under one of the public "open source" licenses you may be used to on the web.
 * 
 * For full license details, and to understand your rights, please refer to the agreement you made when you purchased it 
 * from our website at https://wp-glogin.com/
 * 
 * THIS SOFTWARE IS SUPPLIED "AS-IS" AND THE LIABILITY OF THE AUTHOR IS STRICTLY LIMITED TO THE PURCHASE PRICE YOU PAID 
 * FOR YOUR LICENSE.
 * 
 * Please report violations to contact@wp-glogin.com
 * 
 * Copyright Lesterland Ltd, registered company in the UK number 08553880
 * 
 */

if (!class_exists('core_all_in_one_intranet')) {
	require_once( plugin_dir_path(__FILE__).'/core/core_all_in_one_intranet.php' );
}

class aioi_premium_all_in_one_intranet extends core_all_in_one_intranet {
	
	protected $PLUGIN_VERSION = '1.2';
	
	// Singleton
	private static $instance = null;
	
	public static function get_instance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	// PRIVATE SITE
	
	protected function handle_private_loggedin_multisite($options) {
		if (is_multisite() && $options['aioi_ms_requiremember'] && !is_network_admin()) {
			// Need to check logged-in user is a member of this sub-site
			$blogs = get_blogs_of_user( get_current_user_id() );
			if ( !wp_list_filter( $blogs, array( 'userblog_id' => get_current_blog_id() ) ) ) {
				// Not a member
				$blog_name = get_bloginfo( 'name' );
		
				$output = '<p>'.esc_html(sprintf( 'You attempted to access the "%1$s" sub-site, but you are not currently a member of this site. If you believe you should be able to access "%1$s", please contact your network administrator.', $blog_name )).'</p>';
		
				if ( !empty( $blogs ) ) {
		
					$output .= '<p>You <i>are</i> a member of the following sites:</p>';
						
					$output .= '<table>';
						
					foreach ( $blogs as $blog ) {
						$output .= "<tr>";
						$output .= "<td valign='top'>";
						$output .= "<a href='" . esc_url( get_home_url( $blog->userblog_id ) ). "'>". esc_html( $blog->blogname ) . "</a>" ;
						$output .= "</td>";
						$output .= "</tr>";
					}
					$output .= '</table>';
				}
		
				wp_die( $output );
			}
		}
	}
	
	// MEMBERSHIP
	
	// MEMBERSHIP
	
	public function aioi_wpmu_new_user($user_id) {
		error_log("aioi_wpmu_new_user");
		// Add this user to all default sub-sites, if required
		$options = $this->get_option_aioi();
		$default_role = $options['aioi_ms_membersrole'];
		if ($default_role == '') {
			return;
		}
	
		$blogs = $this->get_all_blogids();
	
		foreach ($blogs as $blogid) {
			if (!is_user_member_of_blog($user_id, $blogid)) {
				error_log("Adding user ${user_id} to blog ${blogid}");
				add_user_to_blog($blogid, $user_id, $default_role);
			}
			else {
				error_log("NOT Adding user ${user_id} to blog ${blogid}");
			}
		}
	}
	
	public function aioi_wpmu_new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta) {
		error_log("aioi_wpmu_new_blog");
		// Add all other users to this new sub-site, if required
		$options = $this->get_option_aioi();
		$default_role = $options['aioi_ms_membersrole'];
		if ($default_role == '') {
			return;
		}
	
		foreach ($this->get_all_userids() as $auserid) {
			// Assume only the blog creator has been added so far
			if ($auserid != $user_id) {
				add_user_to_blog($blog_id, $auserid, $default_role);
				error_log("Adding user ${auserid} to blog ${blog_id}");
			}
			else {
				error_log("NOT Adding user ${auserid} to blog ${blog_id}");
			}
		}
	}
	
	private function get_all_blogids() {
		global $wpdb;
		$blogids = $wpdb->get_col( $wpdb->prepare( "SELECT blog_id FROM $wpdb->blogs WHERE site_id = %d AND archived = '0' AND spam = '0' AND deleted = '0'", $wpdb->siteid ) );
		return is_array($blogids) ? $blogids : Array();
	}
	
	private function get_all_userids() {
		global $wpdb;
		$userids = $wpdb->get_col( "SELECT ID FROM $wpdb->users" );
		return is_array($userids) ? $userids : Array();
	}
	
	// ADMIN
	
	protected function get_options_name() {
		return 'aioi_dsl';
	}
	
	protected function display_registration_warning() {
		if (!is_multisite()) {
			parent::display_registration_warning();
		}
		else {
			if (in_array(get_site_option('registration'), Array('all', 'user'))) {
				$limited_domains = get_site_option('limited_email_domains');
				
				if (is_array($limited_domains) && count($limited_domains) > 0) {
					echo '<p><b>Notice:</b> Your site is set so that &quot;Anyone can register&quot; themselves, '
							.'provided they are members of one of the following domains: '.implode(', ', $limited_domains);	
				}
				else {
					echo '<p><b>Severe Warning:</b> Your site is set so that &quot;Anyone can register&quot; themselves. ';
				}
				
				echo ' <a href="'.(is_multisite()
						? network_admin_url( 'settings.php' )
						: admin_url( 'options-general.php' ))
						.'">Change settings here</a>';
				echo '</p>';
			}
		}
	}
	
	protected function aioi_memberssection_text() {
		$options = $this->get_option_aioi();
	
		if (!is_multisite()) {
			return;
		}
	
		echo "<h3>Sub-site Membership</h3>";
	
		echo '<label for="input_aioi_ms_membersrole" class="textbox plain">';
		echo 'Users should default to the following role in all sub-sites';
		echo '</label> ';
	
		echo "<select name='".$this->get_options_name()."[aioi_ms_membersrole]'>";
		echo "<option value=''>-- None --</option>";
		wp_dropdown_roles($options['aioi_ms_membersrole']);
		echo "</select>";
	
		echo "<p>Changing the default role here will not affect existing sub-sites and users</p>";
		echo "<br />";
	}
	
	protected function get_default_options() {
		return array_merge(parent::get_default_options(), Array('aioi_ms_membersrole' => ''));
	}
	
	public function aioi_options_validate($input) {
		$newinput = parent::aioi_options_validate($input);
		
		$newinput['aioi_ms_membersrole'] = isset($input['aioi_ms_membersrole']) ? $input['aioi_ms_membersrole'] : '';
		
		return $newinput;
	}
	
	// ACTIONS
	
	protected function add_actions() {
		parent::add_actions();
		
		if (is_multisite()) {
			add_action( 'wpmu_new_user', array($this, 'aioi_wpmu_new_user'), 10, 1);
			add_action( 'wpmu_new_blog', array($this, 'aioi_wpmu_new_blog'), 10, 6);
		}
	}
		
	// AUX
	
	protected function my_plugin_basename() {
		$basename = plugin_basename(__FILE__);
		if ('/'.$basename == __FILE__) { // Maybe due to symlink
			$basename = basename(dirname(__FILE__)).'/'.basename(__FILE__);
		}
		return $basename;
	}
	
	protected function my_plugin_url() {
		$basename = plugin_basename(__FILE__);
		if ('/'.$basename == __FILE__) { // Maybe due to symlink
			return plugins_url().'/'.basename(dirname(__FILE__)).'/';
		}
		// Normal case (non symlink)
		return plugin_dir_url( __FILE__ );
	}
	
}

// Global accessor function to singleton
function PremiumAllInOneIntranet() {
	return aioi_premium_all_in_one_intranet::get_instance();
}

// Initialise at least once
PremiumAllInOneIntranet();

?>