<?php
require_once('_functions/styles.php');
require_once('_functions/scripts.php');
require_once('_functions/menus.php');
require_once('_functions/helpers.php');

function mozilla_design_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'mozilla_design_mime_types');


function mozilla_design_body_class( $classes ) {
    // add parent id number to the $classes array
    $parent_id = wp_get_post_parent_id( $post_ID );
    $classes[] = 'parent--'.get_post_field( 'post_name', $parent_id );
    // return the $classes array
    return $classes;
}
add_filter( 'body_class', 'mozilla_design_body_class' );

/*
 * ACF Select Fields
 */
function mozilla_design_acf_load_column_width_choices( $field ) {
    $choices = array(
        'auto' => 'auto',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12'
    );

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {

        foreach( $choices as $choice ) {

            $field['choices'][ $choice ] = $choice;

        }

    }

    return $field;
}

add_filter('acf/load_field/name=column_width', 'mozilla_design_acf_load_column_width_choices');
add_filter('acf/load_field/name=mobile_column_width', 'mozilla_design_acf_load_column_width_choices');

function mozilla_design_acf_load_column_offset_choices( $field ) {
    $choices = array(
        'none' => 'none',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
    );

    if( $field['label'] == 'Mobile Column Offset' ) {
        $choices['10'] = '10';
        $choices['11'] = '11';
        $choices['12'] = '12';
    }

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {

        foreach( $choices as $choice ) {

            $field['choices'][ $choice ] = $choice;

        }

    }

    return $field;
}

add_filter('acf/load_field/name=column_offset', 'mozilla_design_acf_load_column_offset_choices');
add_filter('acf/load_field/name=mobile_column_offset', 'mozilla_design_acf_load_column_offset_choices');


function mozilla_design_acf_load_default_font_selection_choices( $field ) {
    $choices = array(
        'zillaslab-light' => 'zillaslab-light',
        'zillaslab-lightitalic' => 'zillaslab-lightitalic',
        'zillaslab-regular' => 'zillaslab-regular',
        'zillaslab-regularitalic' => 'zillaslab-regularitalic',
        'zillaslab-medium' => 'zillaslab-medium',
        'zillaslab-mediumitalic' => 'zillaslab-mediumitalic',
        'zillaslab-semibold' => 'zillaslab-semibold',
        'zillaslab-semibolditalic' => 'zillaslab-semibolditalic',
        'zillaslab-bold' => 'zillaslab-bold',
        'zillaslab-bolditalic' => 'zillaslab-bolditalic',
        'zillaslabhighlight-bold' => 'zillaslabhighlight-bold',
        'zillaslabhighlight-regular' => 'zillaslabhighlight-regular'
    );

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {

        foreach( $choices as $choice ) {

            $field['choices'][ $choice ] = $choice;

        }

    }

    return $field;
}

add_filter('acf/load_field/name=default_font_selection', 'mozilla_design_acf_load_default_font_selection_choices');

function mozilla_design_page_content_flexible_content_layout_title( $title, $field, $layout, $i ) {

    // load text sub field
    if( get_sub_field('section_intro') ) {

        $title .= ': <em>'.strip_tags(wp_trim_words(get_sub_field('section_intro'), 20)).'</em>';

    }


    // return
    return $title;
}

add_filter('acf/fields/flexible_content/layout_title/name=page_content', 'mozilla_design_page_content_flexible_content_layout_title', 10, 4);


/*
 * Image Sizes
 */

add_image_size( 'hero', 1920, 1330, array( 'center', 'center' ) );


/*
 * Alter posts
 */

function mozilla_design_pre_get_posts( $query ) {

    if ( is_admin() ):
        return;
    endif;

    if ( is_archive() ):
        // $query->set( 'posts_per_page', 20 );
    endif;

    if ($query->is_search) {
        // $query->set( 'posts_per_page', 20 );
    }
}
add_action( 'pre_get_posts', 'mozilla_design_pre_get_posts' );


/*
 * Add global content page
 */

if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page(array(
        'page_title'    => 'Global Site Content',
        'position'      => 24,
        'menu_title'    => 'Global Content',
        'menu_slug'     => 'global-content',
        'capability'    => 'edit_posts',
        'redirect'      => false,
    ));
}


/*
 * Add style and style selector to admin editor
 */

function mozilla_design_add_editor_styles() {
    add_editor_style( get_template_directory_uri() .'/../mozilla.design/assets/css/editor.css' );
}
add_action( 'admin_init', 'mozilla_design_add_editor_styles' );

function mozilla_design_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'mozilla_design_mce_buttons_2' );

function mozilla_design_mce_before_init( $init_array ) {
    // Typography Styles
    $typography_styles = array(
        'type--h-mega' => 'Heading - Mega',
        'type--h-xxl' => 'Heading - XXL',
        'type--h-xl' => 'Heading - XL',
        'type--h-lg' => 'Heading - Large',
        'type--h-md' => 'Heading - Medium',
        'type--h-sm' => 'Heading - Small',
        'type--h-xs' => 'Heading - XS',
        'type--h-xxs' => 'Heading - XXS',
        'type--h-xxxs' => 'Heading - XXXS',
        'type--lg' => 'Paragraph - Large',
        'type--sm' => 'Paragraph - Small',
        'type--xs' => 'Paragraph - XS'
    );
    foreach( $typography_styles as $class => $label ) {
        $style_formats[] = array(
            'title' => $label,
            'inline' => 'span',
            'classes' => $class,
            'wrapper' => false
        );
    }
    // $style_formats[] = array(
    //         'title' => 'Button',
    //         'inline' => 'a',
    //         'classes' => 'button',
    //         'wrapper' => false,
    //     )array(
    //     ,
    //     array(
    //         'title' => 'Citation',
    //         'inline' => 'span',
    //         'classes' => 'citation',
    //         'wrapper' => false,
    //     ),
    // );
    $init_array['style_formats'] = json_encode( $style_formats );

    $custom_colors = '
        "FF298A", "Firefox Pink",
        "FF4F5E", "Firefox Red",
        "FF7139", "Firefox Orange",
        "FFD567", "Firefox Yellow",
        "0060DF", "Firefox Blue",
        "9059FF", "Firefox Violet",
        "B833E1", "Firefox Purple",
        "20123A", "Firefox Background",
        "FFFFFF", "White",
        "EDEDED", "Gray 01",
        "C3C3C3", "Gray 02",
        "7B7B7B", "Gray 03",
        "4A4A4A", "Gray 04",
        "000000", "Black",
        "000000", "Black",
        "000000", "Black",
        "00DDFF", "Mozilla Blue",
        "073072", "Mozilla Dark Blue",
        "FFFF98", "Mozilla Yellow",
        "FF4F5E", "Mozilla Red",
        "54FFBD", "Mozilla Green",
        "005E5E", "Mozilla Dark Green",
        "722291", "Mozilla Purple"

    ';

        // build colour grid default+custom colors
    $init_array['textcolor_map'] = '['.$custom_colors.']';

        // change the number of rows in the grid if the number of colors changes
        // 8 swatches per row
    $init_array['textcolor_rows'] = 3;

    return $init_array;
}
add_filter( 'tiny_mce_before_init', 'mozilla_design_mce_before_init' );


/*
 * Remove the jquery migrate console message
 */

add_action( 'wp_default_scripts', function( $scripts ) {
    if ( is_admin() ):
        return;
    endif;
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
} );


/**
 * Remove the WP REST API JSON Endpoints for logged out users
 * We remove the initial routes from the REST api (like /wp-json/v2/users) and plugins (like facet-wp) add their own routes.
 * @link https://stackoverflow.com/questions/37816170/rest-api-plugin-wordpress-disable-default-routes
 */

function mozilla_design_restrict_rest_api_access() {

    if ( !current_user_can('edit_others_pages') ) {
        remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );
    }
}
add_action( 'rest_api_init', 'mozilla_design_restrict_rest_api_access', 1 );


/**
 * Disable the emoji's
 */
function mozilla_design_disable_emojis() {
   remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
   remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
   remove_action( 'wp_print_styles', 'print_emoji_styles' );
   remove_action( 'admin_print_styles', 'print_emoji_styles' );
   remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
   remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
   remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'mozilla_design_disable_emojis' );

/*
 * Set ACF fields directory
 */

function mozilla_design_acf_json_save_point( $path ) {

  $path = get_theme_root().'/mozilla.design/_fields';
  return $path;
}
add_filter('acf/settings/save_json', 'mozilla_design_acf_json_save_point');


function mozilla_design_acf_json_load_point( $paths ) {
    // remove original path (optional)
  unset($paths[0]);
    // append path
  $paths[] = get_theme_root().'/mozilla.design/_fields';
    // return
  return $paths;
}
add_filter('acf/settings/load_json', 'mozilla_design_acf_json_load_point');



/**
 * Filter a few parameters into YouTube oEmbed requests
 *
 * @link http://goo.gl/yl5D3
 */
function mozilla_design_youtube_player( $html, $url, $args ) {
  return str_replace( '?feature=oembed', '?feature=oembed&rel=0', $html );
}
add_filter( 'oembed_result', 'mozilla_design_youtube_player', 10, 3 );


// set up yoast to use hero image if available
function mozilla_design_adjust_og_image($image_url) {

    // check if there is already a custom image set
    $seo_options = WPSEO_Options::get_option( 'wpseo_social' );
    $default_image_url = $seo_options['og_default_image'];

    $term = get_term_by('name', 'Primary Navigation', 'nav_menu');
    $menu_id = $term->term_id;
    $links = wp_get_nav_menu_items($term->term_id);
    $section_nav_links = array();
    $target_id = get_the_ID();
    if( wp_get_post_parent_id($target_id) ) {
      $target_id = wp_get_post_parent_id($target_id);
    }
    $brand_parent_id = $target_id;
    $override_page = false;
    if( get_field('display_child_page', $brand_parent_id) ) {
      $override_page = get_field('display_child_page', $brand_parent_id);
    }
    $page_title = get_the_title($target_id);

    if( $page_title == 'Firefox Brand' ) {
        $image_url = get_template_directory_uri().'/assets/images/OG_Firefox.png';
    }
    if( $page_title == 'Mozilla Brand' ) {
        $image_url = get_template_directory_uri().'/assets/images/OG_Mozilla.png';
    }

    return $image_url;
}
add_filter('wpseo_opengraph_image', 'mozilla_design_adjust_og_image');
add_filter('wpseo_twitter_image', 'mozilla_design_adjust_og_image');


// Enable Zip file uploads
function mozilla_design_upload_zip($mime_types = array()) {
    $mime_types['zip'] = 'application/zip';
    return $mime_types;
}
add_filter('upload_mimes', 'mozilla_design_upload_zip');

function mozilla_gif_check($image) {
  // Full width header images
  if( $image['mime_type'] == 'image/gif' ) {
    foreach ( $image['sizes'] as $key => $val ) {
        if( strpos($key, 'width') == false && strpos($key, 'height') == false ) {
            $image['sizes'][$key] = $image['url'];
        }
    }
  }
  return $image;
}
add_filter('wp_get_attachment_image_attributes', 'my_fix_attachment_size', 10 , 3);
