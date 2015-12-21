<?php
/**
 * Plugin Name: Genesis Staff Bio Grid
 * Plugin URI: http://redblue.us/staff-bio-grid
 * Description: A plugin to add grid of staff members with popup lightboxes.
 * Version: 1.0.4
 * Author: Jon Schroeder
 * Author URI: http://redblue.us
 * License: GPL2
 */

/*  Copyright 2014 Jon Schroeder (email:jon@redblue.us)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



// set up our constants for the plugin
if ( ! defined( 'SBG_BASE_FILE' ) )
    define( 'SBG_BASE_FILE', __FILE__ );
if ( ! defined( 'SBG_BASE_DIR' ) )
    define( 'SBG_BASE_DIR', dirname( SBG_BASE_FILE ) );
if ( ! defined( 'SBG_PLUGIN_URL' ) )
    define( 'SBG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// create the post type and taxonomy
include( plugin_dir_path( __FILE__ ) . '/lib/register_staff_member_post_type.php' );
include( plugin_dir_path( __FILE__ ) . '/lib/register_staff_position_taxonomy.php' );
include( plugin_dir_path( __FILE__ ) . '/lib/shortcode.php' );

// everything else should only happen if we're in a Genesis theme
add_action( 'genesis_init', 'sbg_genesis_only' );
function sbg_genesis_only() {

    add_action( 'wp_enqueue_scripts', 'sbg_scripts');
    function sbg_scripts() {
        // enqueue the plugin styles
        wp_register_style( 'sbg_style', plugins_url( '/css/sbg_style.css', __FILE__ ) );    
        wp_enqueue_style( 'sbg_style' );

        wp_register_style( 'sbg_genericons', plugins_url( '/css/genericons.css', __FILE__ ) );    
        wp_enqueue_style( 'sbg_genericons' );
    }

    // Add new image size for Staff members
    add_image_size( 'staff-member', 300, 400, true );
    add_image_size( 'staff-member-single', 300, 400, true );
     
    // Show Staff Type custom taxonomy terms and tags in Staff archive pages
    add_filter( 'genesis_post_meta', 'sbg_post_meta' );
    function sbg_post_meta( $post_meta ) {
     
        if ( is_post_type_archive( 'staff-member' ) || is_singular( 'staff-member' ) || is_tax('staff-position') || is_page() )
        $post_meta = '[post_terms taxonomy="staff-position" before=""]';
     
        return $post_meta;
     
    }

    include( plugin_dir_path( __FILE__ ) . '/lib/template_picker.php' );
}

add_action( 'init', 'sbg_initialize_cmb_meta_boxes', 9999 );
function sbg_initialize_cmb_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'lib/metabox/init.php' );
    }
}

function sbg_add_metaboxes( $meta_boxes ) {
    $prefix = '_sbg_'; // Prefix for all fields
    $meta_boxes['contactinfo'] = array(
        'id' => 'contactinfo',
        'title' => 'Contact information',
        'pages' => array('staff-member'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Email address',
                'desc' => "This staff member's email address (this will be linked but not publicly displayed). Example: joe@sloppyjoes.com",
                'id' => $prefix . 'email',
                'type' => 'text'
            ),
            array(
                'name' => 'Facebook link',
                'desc' => 'A link to their Facebook page. Example: https://www.facebook.com/jonschr',
                'id' => $prefix . 'facebook',
                'type' => 'text'
            ),
            array(
                'name' => 'Twitter link',
                'desc' => 'A link to their Twitter page. Example: https://twitter.com/jonschr',
                'id' => $prefix . 'twitter',
                'type' => 'text'
            ),
            array(
                'name' => 'Phone number',
                'desc' => 'Their phone number. This <em>will</em> be displayed publicly.',
                'id' => $prefix . 'phone',
                'type' => 'text'
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'sbg_add_metaboxes' );