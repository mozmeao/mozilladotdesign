<?php
$current_id = get_the_ID();
$term = get_term_by('name', 'Primary Navigation', 'nav_menu');
$menu_id = $term->term_id;
$links = wp_get_nav_menu_items($term->term_id);
$section_nav_links = array();
$brand_parent_id = get_the_ID();
if( wp_get_post_parent_id($brand_parent_id) ) {
  $brand_parent_id = wp_get_post_parent_id($brand_parent_id);
}

$override_page = false;
if( get_field('display_child_page', $brand_parent_id) ) {
  $override_page = get_field('display_child_page', $brand_parent_id);
}

foreach( $links as $link ) {
  if( $link->post_parent == $brand_parent_id ) {
    $section_nav_links[$link->object_id] = array(
      'post_id' => $link->object_id
    );
  }
}
?>
<div class="section-nav col-xl-3 col-lg-4">
  <div class="section-nav-menu type--h-sm type--mb-h-xxs">
    <ul class="section-nav-menu-links">
      <?php $count = 0; foreach( $section_nav_links as $link ):  $count++; ?>
      <?php
        $permalink = get_permalink($link['post_id']);
        $title = get_the_title($link['post_id']);
        $is_current = ( $current_id == $link['post_id'] ) ? 'current' : '';

        if( $override_page !== false && $override_page[0]->ID == $link['post_id'] ) {
          $permalink = get_permalink($brand_parent_id);
          $is_current = ( $current_id == $brand_parent_id ) ? 'current' : '';
        }
      ?>
      <li><a class="<?php echo $is_current; ?>"href="<?php echo $permalink; ?>"><span class="count">0<?php echo $count; ?></span><span class="link-title"><?php echo $title; ?></span></a></li>
    <?php endforeach; ?>
    </ul>
  </div>
</div>
