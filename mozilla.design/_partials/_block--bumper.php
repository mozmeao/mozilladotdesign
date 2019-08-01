<?php
$term = get_term_by('name', 'Primary Navigation', 'nav_menu');
$menu_id = $term->term_id;
$links = wp_get_nav_menu_items($term->term_id);
$child_links = array();
$target_id = get_the_ID();
if( wp_get_post_parent_id($target_id) ) {
  $target_id = wp_get_post_parent_id($target_id);
}
foreach( $links as $link ) {
  if( $link->post_parent == $target_id ) {
    $child_links[] = array(
      'post_id' => $link->object_id
    );
  }
}

$found = false;
foreach( $child_links as $key => $link ) {
  if( $found == "" ) {
    if( $link['post_id'] == get_the_ID() ) {
      $found = true;
      if( $child_links[$key+1] ) {
        $selected_link = $child_links[$key+1];
      } else {
        $selected_link = '';
      }

    }
  }

  if( $found == false ) {
    $selected_link = $child_links[1];
  }

}
if ($selected_link != ""):
?>
<div class="page-section page-section--bumper bumper" role="navigation">
  <a href="<?php the_permalink($selected_link['post_id']); ?>">
  <div class="container-fluid">
    <div class="row d-flex align-items-center">
      <div class="col-md-6 col-12 offset-md-1">
        <div class="next-link type--h-xxl type--mb-h-lg">
          <span class="type--ff-h-xxl type--ff-mb-h-lg">Next</span><br>
          <?php echo get_the_title($selected_link['post_id']); ?>
        </div>
      </div>
    </div>
  </div>
  </a>
</div>
<?php endif; ?>
