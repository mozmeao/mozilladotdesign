<?php
/*
Template Name: Brand Landing Page
*/
?>
<?php get_header(); ?>

<?php
  $fallback_image = get_field('interactive_fallback_image');
?>
<div class="interior-page-wrap">
  <?php include('_partials/_block-section_nav.php'); ?>
  <div class="page-section page-section--brand-interactive brand-interactive">
    <?php if( get_the_title() == 'Firefox Brand' ): ?>
    <?php include('_partials/_block--interactive-firefox.php'); ?>
    <?php endif; ?>
    <?php if( get_the_title() == 'Mozilla Brand' ): ?>
    <?php include('_partials/_block--interactive-mozilla.php'); ?>
    <?php endif; ?>
    <div class="container-fluid">
      <?php if( get_the_title() == 'Mozilla Brand' ): ?>
        <div class="row d-flex w-100">
          <div class="col offset-xl-1">
            <h1 class="type--mz-h-mega--highlight type--mz-mb-h-mega--highlight extra-lh">moz://a<br>&#8202;brand&#8202;</h1>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php
  // only for firefox, we'll show the first sub page below the intro
  if( get_field('display_child_page') ):
    $child_page = get_field('display_child_page');
    $selected_page = new WP_Query(array(
      'posts_per_page' => 1,
      'page_id' => $child_page[0]->ID
    ));
    while( $selected_page->have_posts() ): $selected_page->the_post();
  ?>
  <div class="page-body" data-section-url="<?php the_permalink(); ?>">
    <?php include('_partials/_block--page_intro.php'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-xxl-9 col-xl-9 col-lg-8 force-max-width">
          <?php include('_partials/_field--page_content.php'); ?>
        </div>
      </div>
    </div>
  </div>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</div>
<?php include('_partials/_block--bumper.php'); ?>

<?php get_footer(); ?>
