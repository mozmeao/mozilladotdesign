<?php
$override_page = false;

  if( wp_get_post_parent_id(get_the_ID()) ) {
    $parent_id = wp_get_post_parent_id(get_the_ID());

    if( get_field('display_child_page', $parent_id) ) {
      $override_page = get_field('display_child_page', $parent_id);
      if( $override_page[0]->ID == get_the_ID() ) {
        $url = get_permalink($parent_id);
        if( wp_redirect(get_permalink($parent_id), 301) ) {
          exit;
        }
      }
    }


  }
?>

<?php get_header(); ?>

<div class="interior-page-wrap">
  <?php include('_partials/_block-section_nav.php'); ?>
  <div class="page-body">
    <?php include('_partials/_block--page_intro.php'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-xxl-9 col-xl-9 col-lg-8 force-max-width">
          <?php include('_partials/_field--page_content.php'); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if( get_field('custom_bumper') ): ?>

  <?php include('_partials/_block--bumper-custom.php'); ?>

<?php else : ?>

  <?php include('_partials/_block--bumper.php'); ?>

<?php endif; ?>

<?php get_footer(); ?>
