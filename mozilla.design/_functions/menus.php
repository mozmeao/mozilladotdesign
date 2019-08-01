<?php

function mozilla_design_custom_menu_page_removing() {
    remove_menu_page( 'edit-comments.php' );
    remove_submenu_page( 'themes.php', 'customize.php?return=%2Fwp-admin%2F' );
}
add_action( 'admin_menu', 'mozilla_design_custom_menu_page_removing' );

// Create primary nav menu
register_nav_menus(array('primary' => 'Primary Navigation'));

// Create footer nav menu
register_nav_menus(array('footer' => 'Footer Navigation'));

// allow editors to manage theme options (edit menus)
$role_object = get_role( 'editor' ); // get the the role object
$role_object->add_cap( 'edit_theme_options' ); // add $cap capability to this role object


function mozilla_design_nav_item_title( $title, $item, $args, $depth ) {
  if( $depth == 1 ) {
    $term = get_term_by('name', 'Primary Navigation', 'nav_menu');
    $menu_id = $term->term_id;
    $links = wp_get_nav_menu_items($term->term_id);
    $section_nav_links = array();
    $target_id = $item->object_id;
    if( wp_get_post_parent_id($target_id) ) {
      $target_id = wp_get_post_parent_id($target_id);
    }
    foreach( $links as $link ) {
      if( $link->post_parent == $target_id ) {
        $section_nav_links[$link->object_id] = array(
          'post_id' => $link->object_id
        );
      }
    }
    $output_count = '';
    $count = 0; foreach( $section_nav_links as $link ):
      $count++;
      if( $link['post_id'] == $item->object_id ) {
        $output_count = $count;
      }
    endforeach;
    return '<span>0'.$output_count.'</span>'.$title;
  } else {
    return $title;
  }
}
add_filter( 'nav_menu_item_title', 'mozilla_design_nav_item_title', 10, 4 );

function mozilla_design_setup_nav_menu_item( $post ) {
  if( $post->post_parent ) {
    $brand_parent_id = $post->post_parent;
    $override_page = false;
    if( get_field('display_child_page', $brand_parent_id) ) {
      $override_page = get_field('display_child_page', $brand_parent_id);
    }

    if( $post->object_id == $override_page[0]->ID ) {
      $post->url = get_permalink($brand_parent_id);
    }
  }

  return $post;
}
add_filter( 'wp_setup_nav_menu_item', 'mozilla_design_setup_nav_menu_item', 10, 1 );
