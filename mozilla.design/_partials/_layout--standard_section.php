<div class="page-content-layout page-section page-section--standard-section standard-section">
    <?php if( get_sub_field('section_intro') ): ?>
    <div class="row">
      <div class="col-12 col-lg-9">
        <?php include('_field--section_intro.php'); ?>
      </div>
    </div>
    <?php endif; ?>
    <div class="row">
      <?php while(have_rows('columns')): the_row(); ?>
        <?php
          $mobile_col_class = 'col';
          $col_class = 'col-lg';
          if( get_sub_field('mobile_column_width') !== 'auto' ) {
            $mobile_col_class = 'col-'.get_sub_field('mobile_column_width');
          }
          if( get_sub_field('column_width') !== 'auto' ) {
            $col_class = 'col-lg-'.get_sub_field('column_width');
          }
        ?>
      <div class="<?php echo $mobile_col_class; ?> <?php echo $col_class; ?> offset-<?php the_sub_field('mobile_column_offset'); ?> offset-lg-<?php the_sub_field('column_offset'); ?>">

        <?php if( get_row_layout() == 'text_column' ): ?>
          <div class="text wysiwyg-content">
            <?php if( get_sub_field('include_typetester') ): ?>
              <div class="type-controls">
                <div class="select-wrap input">
                  <select>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-light' ) ? 'selected' : ''; ?> value="zillaslab-light">Zilla Slab Light</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-lightitalic' ) ? 'selected' : ''; ?> value="zillaslab-lightitalic">Zilla Slab Light Italic</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-regular' ) ? 'selected' : ''; ?> value="zillaslab-regular">Zilla Slab Regular</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-regularitalic' ) ? 'selected' : ''; ?> value="zillaslab-regularitalic">Zilla Slab Regular Italic</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-medium' ) ? 'selected' : ''; ?> value="zillaslab-medium">Zilla Slab Medium</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-mediumitalic' ) ? 'selected' : ''; ?> value="zillaslab-mediumitalic">Zilla Slab Medium Italic</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-semibold' ) ? 'selected' : ''; ?> value="zillaslab-semibold">Zilla Slab SemiBold</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-semibolditalic' ) ? 'selected' : ''; ?> value="zillaslab-semibolditalic">Zilla Slab SemiBold Italic</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-bold' ) ? 'selected' : ''; ?> value="zillaslab-bold">Zilla Slab Bold</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslab-bolditalic' ) ? 'selected' : ''; ?> value="zillaslab-bolditalic">Zilla Slab Bold Italic</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslabhighlight-bold' ) ? 'selected' : ''; ?> value="zillaslabhighlight-bold">Zilla Slab Highlight Bold</option>
                  <option <?php echo ( get_sub_field('default_font_selection') == 'zillaslabhighlight-regular' ) ? 'selected' : ''; ?> value="zillaslabhighlight-regular">Zilla Slab Highlight Regular</option>
                  </select>
                </div>
                <div class="range-select input">
                  <div class="range-wrap">
                    <input type="range" value="<?php the_sub_field('default_font_size'); ?>" min="1" max="200" />
                  </div>
                  <span class="value"><?php the_sub_field('default_font_size'); ?>px</span>
                </div>
              </div>
              <div class="type-output <?php the_sub_field('default_font_selection'); ?>" style="font-size:<?php the_sub_field('default_font_size');?>px;">
                <?php the_sub_field('text'); ?>
              </div>

            <?php else: ?>
              <?php the_sub_field('text'); ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if( get_row_layout() == 'image_column' ): ?>
          <?php $image = mozilla_gif_check(get_sub_field('image')); ?>
          <div class="image">
            <?php if( get_sub_field('link') ): ?>
              <a href="<?php the_sub_field('link'); ?>">
            <?php endif; ?>
            <noscript>
              <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
            </noscript>
            <img class="lazyload" data-src="<?php echo $image['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $image['ID'], array( 2000, 2000 ) ); ?>" alt="<?php echo $image['alt']; ?>" />
            <?php if( get_sub_field('link') ): ?>
              </a>
            <?php endif; ?>
          </div>
          <?php if( get_sub_field('caption') ): ?>
          <div class="text wysiwyg-content type--mb-xs">
            <?php the_sub_field('caption'); ?>
          </div>
          <?php endif; ?>
        <?php endif; ?>

        <?php if( get_row_layout() == 'code_column' ): ?>
          <div class="code-block">
            <div class="code-tabs">
              <?php $code_tab_count = 0; while(have_rows('code_snippets')): the_row(); $code_tab_count++; ?>
                <a class="type--h-xxs<?php echo ( $code_tab_count == 1 ) ? ' active' : ''; ?>" href="#code-tab-<?php echo $code_tab_count; ?>"><?php the_sub_field('title'); ?></a>
              <?php endwhile; ?>
            </div>
            <?php $code_tab_count = 0; while(have_rows('code_snippets')): the_row(); $code_tab_count++; ?>
            <div id="code-tab-<?php echo $code_tab_count; ?>" class="code-tab-content<?php echo ( $code_tab_count == 1 ) ? ' active' : ''; ?>" data-attr-tab-id="#code-tab-<?php echo $code_tab_count; ?>">
              <div class="code">
                <code><?php echo htmlspecialchars(get_sub_field('code')); ?></code>
              </div>
            </div>
            <?php endwhile; ?>
          </div>

        <?php endif; ?>

        <?php if( get_row_layout() == 'spacing_column' ): ?>
          <div class="spacing" style="height:<?php the_sub_field('size'); ?>"></div>
        <?php endif; ?>

      </div>
      <?php endwhile; ?>
    </div>
</div>
