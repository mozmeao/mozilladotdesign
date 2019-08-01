<div class="page-content-layout page-section page-section--image-grid-section image-grid-section">
  <?php if( get_sub_field('section_intro') ): ?>
    <div class="row">
      <div class="col-12 col-lg-9">
        <?php include('_field--section_intro.php'); ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if( have_rows('images') ): ?>
    <div class="image-grid">
      <?php while(have_rows('images')): the_row(); ?>
        <div class="image">
          <?php if( get_sub_field('link') ): ?>
            <a href="<?php the_sub_field('link'); ?>">
          <?php endif; ?>
          <?php $image = get_sub_field('image'); ?>
          <noscript>
            <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php the_sub_field('caption'); ?>" />
          </noscript>
          <img class="lazyload" data-src="<?php echo $image['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $image['ID'], array( 2000, 2000 ) ); ?>" alt="<?php the_sub_field('caption'); ?>" />
          <?php if( get_sub_field('link') ): ?>
            </a>
          <?php endif; ?>
          <?php if( get_sub_field('caption') ): ?>
            <div class="text wysiwyg-text">
              <?php the_sub_field('caption'); ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>
