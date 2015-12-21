<?php 

// add the filter
add_filter( 'template_include', 'sbg_template_chooser' );
 
/**
 * Returns template file
 *
 * @since 0.0.1
 */ 
function sbg_template_chooser( $template ) {
 
    // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'staff-member' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return sbg_get_template_hierarchy( 'single-staff-member' );
    }

    if ( is_archive() ) {
        return sbg_get_template_hierarchy( 'archive-staff-member' );
    }
}

/**
 * Get the custom template from the plugin templates directory
 *
 * @since 0.0.1
 */
 
function sbg_get_template_hierarchy( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // NOTE: THIS FUNCTION SEEMS TO ONLY PARTIALLY WORK. LET'S GET THE BASICS HANDLED FIRST THOUGH
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'plugin_template/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = SBG_BASE_DIR . '/lib/templates/' . $template;
    }
 
    return apply_filters( 'sbg_repl_template_' . $template, $file );
}
