<?php
/*
Template Name: Press Assets Page
*/
?>
<?php get_header(); ?>

<div class="interior-page-wrap">
  <div class="page-body">
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

    <div class="page-section page-section--press-assets press-assets">
      <div class="container-fluid">
        <div class="row">
          <?php while(have_rows('featured_assets')): the_row(); ?>
            <div class="col-12 col-lg-<?php the_sub_field('column_width'); ?>">
              <div class="press-asset">
                <div class="content">
                  <?php
                  $link = get_sub_field('link');
                  if( get_sub_field('file') ) {
                    $file = get_sub_field('file');
                    $link = $file['url'];
                  }
                  ?>
                  <a href="<?php echo $link; ?>">
                    <?php if( get_sub_field('image') ):
                      $image = get_sub_field('image');
                      ?>
                      <div class="image">
                        <noscript>
                          <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
                        </noscript>
                        <img class="lazyload" data-src="<?php echo $image['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $image['ID'], array( 2000, 2000 ) ); ?>" alt="<?php echo $image['alt']; ?>" />
                      </div>
                    <?php endif; ?>
                    <?php if( get_sub_field('caption') ): ?>
                    <div class="caption">
                      <?php the_sub_field('caption'); ?>
                    </div>
                    <?php endif; ?>
                    <div class="text type--sm d-flex align-items-center justify-content-between text-color--<?php echo get_sub_field('cta_text_color'); ?>">
                      <div class="cta_text">
                        <?php the_sub_field('cta_text'); ?>
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
        <div class="row additional-assets-row d-none d-lg-flex">
        <?php while(have_rows('additional_assets')): the_row(); ?>
          <div class="col-12 col-lg-6">
            <h2 class="title type--h-lg<?php echo ( get_sub_field('column_title') == 'Mozilla' ) ? ' type--mz-h-lg' : ''; ?>">
              <?php if( get_sub_field('column_title_image') ): ?>
                <?php $column_image = get_sub_field('column_title_image'); ?>
                <noscript>
                  <img src="<?php echo $column_image['sizes']['large']; ?>" alt="<?php the_sub_field('column_title'); ?>" />
                </noscript>
                <img class="lazyload" data-src="<?php echo $column_image['sizes']['large']; ?>" alt="<?php the_sub_field('column_title'); ?>" />
              <?php else: ?>
              <?php the_sub_field('column_title'); ?>
              <?php endif; ?>
            </h2>
            <div class="additional-assets">
              <?php while(have_rows('assets')):the_row(); ?>
                <div class="additional-asset">
                  <?php
                  $link = get_sub_field('link');
                  if( get_sub_field('file') ) {
                    $file = get_sub_field('file');
                    $link = $file['url'];
                  }
                  ?>
                  <a href="<?php echo $link; ?>">

                    <div class="name type--h-xxs">
                      <?php if( get_sub_field('icon') ): $icon = get_sub_field('icon'); ?>
                        <div class="icon">
                          <noscript>
                            <img src="<?php echo $icon['sizes']['large']; ?>" alt="<?php the_sub_field('description'); ?>" />
                          </noscript>
                          <img class="lazyload" data-src="<?php echo $icon['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $icon['ID'], array( 2000, 2000 ) ); ?>" alt="<?php the_sub_field('description'); ?>" />
                        </div>
                        <?php the_sub_field('name'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="description type--sm">
                      <?php the_sub_field('description'); ?>
                    </div>
                    <div class="filetype type--sm">
                      <?php if( get_sub_field('file') ): ; ?>
                        <?php echo '.'.end(explode('.', $file['filename'])); ?>
                        <?php else: ?>
                        <?php
                          $icon_style = 'link';
                          if( get_sub_field('icon_style') ) {
                            $icon_style = get_sub_field('icon_style');
                          }
                        ?>
                        <i class="icon icon--<?php echo $icon_style; ?>"></i>

                        <?php endif; ?>
                    </div>
                  </a>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
        <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
