<div class="d-none d-lg-block page-section page-section--quick-links quick-links" role="navigation">
  <div class="container-fluid">
    <div class="row d-flex">
      <?php while(have_rows('quick_links', 'option')): the_row(); ?>
        <div class="col-6">

              <h2 class="title type--ff-h-lg<?php echo ( get_sub_field('column_title') == 'Mozilla' ) ? ' type--mz-h-lg' : ''; ?>">
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
            <div class="additional-assets d-flex flex-wrap">
              <?php while(have_rows('assets')):the_row(); ?>
                <div class="additional-asset col-<?php the_sub_field('column_width'); ?>">
                  <?php
                  $link = get_sub_field('link');
                  if( get_sub_field('file') ) {
                    $file = get_sub_field('file');
                    $link = $file['url'];
                  }
                  ?>
                  <a href="<?php echo $link; ?>" class="prevent d-flex align-items-center <?php echo ( get_sub_field('file') ) ? 'justify-space-between' : ' justify-content-center'; ?>">

                    <div class="name type--sm">
                      <?php if( get_sub_field('icon') ): $icon = get_sub_field('icon'); ?>
                        <div class="icon">
                          <noscript>
                            <img src="<?php echo $icon['sizes']['large']; ?>" alt="<?php the_sub_field('description'); ?>" />
                          </noscript>
                          <img class="lazyload" data-src="<?php echo $icon['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $icon['ID'], array( 2000, 2000 ) ); ?>" alt="<?php the_sub_field('description'); ?>" />
                        </div>
                      <?php endif; ?>
                        <?php the_sub_field('name'); ?>
                    </div>
                    <?php if( get_sub_field('description')): ?>
                    <div class="description type--sm">
                      <?php the_sub_field('description'); ?>
                    </div>
                    <?php endif; ?>

                    <div class="filetype type--sm">
                      <?php if( get_sub_field('file') ): ; ?>
                        <?php echo '.'.end(explode('.', $file['filename'])); ?>
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
