<?php

function mozilla_design_enqueue_style() {
  wp_dequeue_style( 'wp-block-library' );
  wp_register_style( 'style', get_stylesheet_directory_uri().'/assets/css/style.css', '', filemtime( get_stylesheet_directory().'/assets/css/style.css' ), 'screen' );
  wp_enqueue_style( 'style' );
}

add_action( 'wp_enqueue_scripts', 'mozilla_design_enqueue_style' );
