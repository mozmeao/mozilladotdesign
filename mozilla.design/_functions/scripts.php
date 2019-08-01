<?php

function mozilla_design_enqueue_scripts() {
    wp_register_script( 'script', get_template_directory_uri().'/assets/js/index.js', '', filemtime( get_stylesheet_directory().'/assets/js/index.js' ) );
    wp_enqueue_script( 'script', '', '', '', true );
}
add_action( 'wp_enqueue_scripts', 'mozilla_design_enqueue_scripts', 9999 );
