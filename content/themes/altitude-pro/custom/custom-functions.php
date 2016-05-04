<?php

//register our custom stylesheet, to be called last of course
function fsa_register_styles() {
    wp_register_style( 'fsa-custom', get_stylesheet_directory_uri() . '/custom/css/main.css', array('altitude-pro-theme'), '001', 'screen');
}
add_action( 'wp_enqueue_scripts', 'fsa_register_styles' );

function fsa_enqueue_styles() {
    wp_enqueue_style( 'fsa-custom' );

}
add_action( 'wp_enqueue_scripts', 'fsa_enqueue_styles' );

//allow for svg mime type through uploads
function fsa_allow_svg_mime( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
// temporarily removed since the crop failed anyway
// add_filter( 'upload_mimes', 'fsa_allow_svg_mime' );


// add our custom home page featured image size 4:3...
add_image_size( 'homepage-feature', 800, 600, false );
add_image_size( 'homepage-blog-banner', 1200, 600, false );

//* Reposition the secondary navigation menu (set in functions)
remove_action( 'genesis_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav', 15 );
