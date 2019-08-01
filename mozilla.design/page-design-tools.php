<?php
/*
Template Name: Design Tools Page
*/
?>
<?php get_header(); ?>

<?php
  if( get_field('background_image') ) {
    $bg_image = get_field('background_image');
    $bg_image_mobile = $bg_image;
  }
  if( get_field('background_image_mobile')) {
    $bg_image_mobile = get_field('background_image_mobile');
  }
?>
<style type="text/css">
  .page-template-page-design-tools .page-body.design-tools-bg {
    background-image: url(<?php echo $bg_image['url']; ?>);
  }
  @media(max-width: 1019px) {
    .page-template-page-design-tools .page-body.design-tools-bg {
      background-image: url(<?php echo $bg_image_mobile['url']; ?>);
    }
  }
</style>
<div class="interior-page-wrap">
  <div class="page-body design-tools-bg">
    <div class="page-section page-section--page-intro page-intro half">
      <div class="container-fluid">
        <div class="row d-flex align-items-center">
          <div class="col col-xl-7 offset-xl-1 col-lg-8 offset-lg-0">
            <div class="page-intro--title type--h-xxl">
              <h1 class="type--h-xxl type--mb-h-lg alt-size"><?php the_title(); ?></h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-section page-section--design-tools design-tools">
      <div class="container-fluid">
        <div class="row">
          <?php while(have_rows('design_tools')): the_row(); ?>
          <div class="col-12 col-lg-4">
            <?php
              $bg_color = '#ffffff';
              if( get_sub_field('background_color') ){
                $bg_color = get_sub_field('background_color');
              }
            ?>
            <div class="design-asset" style="background-color:<?php echo $bg_color; ?>;">
              <div class="content">
                <a href="<?php the_sub_field('link'); ?>">
                  <?php if( get_sub_field('image') ):
                    $image = get_sub_field('image');
                    ?>
                  <div class="image">
                    <noscript>
                      <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
                    </noscript>
                    <img class="lazyload" data-src="<?php echo $image['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $image['ID'], array( 2000, 2000 ) ); ?>" alt="<?php the_sub_field('caption'); ?>" />
                  </div>
                <?php endif; ?>
                <div class="text type--sm d-flex align-items-center justify-content-between">
                  <div class="caption">
                    <?php the_sub_field('caption'); ?>
                  </div>
                  <div class="link">
                    <?php
                      $icon_style = 'link';
                      if( get_sub_field('icon_style') ) {
                        $icon_style = get_sub_field('icon_style');
                      }
                    ?>
                    <i class="icon icon--<?php echo $icon_style; ?>"></i>
                  </div>
                </div>
                </a>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
