<div class="page-content-layout page-section page-section--assets-section assets-section">
  <?php if( get_sub_field('section_intro') ): ?>
    <div class="row">
      <div class="col-12 col-lg-9">
        <?php include('_field--section_intro.php'); ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if( have_rows('assets') ): ?>
    <div class="assets">
      <div class="row">
      <?php while(have_rows('assets')): the_row();
          $mobile_col_class = 'col-12';
          $col_class = 'col-lg';
          if( get_sub_field('column_width') !== 'auto' ) {
            $col_class = 'col-lg-'.get_sub_field('column_width');
          }
          $link = '';
          if( get_sub_field('asset_file') ) {
            $asset = get_sub_field('asset_file');
            $link = $asset['url'];
          }
          if( get_sub_field('asset_link') ) {
            $link = get_sub_field('asset_link');
          }

        ?>
        <div class="<?php echo $mobile_col_class; ?> <?php echo $col_class; ?>">
          <a href="<?php echo esc_url($link); ?>" download>
            <div class="asset">
              <?php if( get_sub_field('thumbnail') ): ?>
                <div class="thumbnail">
                  <div class="content">
                    <?php $asset_thumb = get_sub_field('thumbnail'); ?>
                    <noscript>
                      <img src="<?php echo $asset_thumb['sizes']['medium']; ?>" alt="<?php echo $asset_thumb['alt']; ?>" />
                    </noscript>
                    <img class="lazyload" data-src="<?php echo $asset_thumb['sizes']['medium']; ?>"  data-srcset="<?php echo wp_get_attachment_image_srcset( $asset_thumb['ID'], array( 2000, 2000 ) ); ?>" alt="<?php echo $asset_thumb['alt']; ?>" />
                  </div>
                </div>
              <?php endif; ?>
              <div class="text-wrap">
                <?php if( get_sub_field('text') ): ?>
                  <div class="text type--ff-sm">
                    <?php the_sub_field('text'); ?>
                  </div>
                <?php endif; ?>
                <?php if( get_sub_field('filetype') ): ?>
                  <div class="filetype type--ff-sm">
                    <?php the_sub_field('filetype'); ?>
                  </div>
                <?php endif; ?>

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
      <?php endwhile; ?>
    </div>
  </div>
  <?php endif; ?>
</div>
