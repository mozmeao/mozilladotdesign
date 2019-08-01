<?php
/*
Template Name: Page Not Found
*/
?>
<?php get_header(); ?>

<?php
$args = array(
  'name' => 'page-not-found',
  'post_type' => 'page',
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
  <?php
    if( get_field('background_image') ) {
      $bg_image = get_field('background_image');
    }
  ?>
  <div class="interior-page-wrap">
    <div class="page-section page-section--error404 error404" style="background-image: url(<?php echo $bg_image['url']; ?>);">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col-md-5">
            <h1 class="type--h-xxl">4<span class="type--mz-h-xxl">0</span><span class="type--mz-h-lg--highlight">4</span></h1>
            <?php the_field('content'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php endwhile; endif; ?>

<?php get_footer(); ?>

