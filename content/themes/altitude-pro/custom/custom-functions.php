<?php

//register our custom stylesheet, to be called last of course


function fsa_register_styles() {
    wp_register_style( 'fsa-custom', get_stylesheet_directory_uri() . '/custom/css/main.css', array('altitude-pro-theme'), '001', 'screen');
}
add_action( 'wp_enqueue_scripts', 'fsa_register_styles' );

function fsa_enqueue_styles() {
    // wp_enqueue_style( 'fsa-custom' );

}
add_action( 'wp_enqueue_scripts', 'fsa_enqueue_styles' );
