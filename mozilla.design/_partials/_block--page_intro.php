<?php
  // determine #
  $term = get_term_by('name', 'Primary Navigation', 'nav_menu');
  $menu_id = $term->term_id;
  $links = wp_get_nav_menu_items($term->term_id);
  $section_nav_links = array();
  $target_id = get_the_ID();
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
    if( $link['post_id'] == get_the_ID() ) {
      $output_count = $count;
    }
  endforeach;
?>
<div class="page-section page-section--page-intro page-intro">
  <div class="container-fluid">
    <div class="row d-flex align-items-center">
      <div class="col col-xl-7 offset-xl-1 col-lg-8 offset-lg-0">
        <div class="page-intro--title type--h-xxl type--mb-h-md">
          <?php if( $output_count ): ?>
          <span>0<?php echo $output_count; ?></span>
          <?php endif; ?>
          <h1 class="type--h-xxl type--mb-h-md"><?php the_title(); ?></h1>
          <?php if( get_field('tagline') ): ?>
          <div class="tagline">
            <?php the_field('tagline'); ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
