    </div>
  </div>
    <footer class="page-section page-section--site-footer site-footer" role="contentinfo">

        <div class="container-fluid">

          <div class="row row-1">
            <div class="col-12 type--h-xxxs">
              <a class="site-title" href="<?php echo get_site_url(); ?>"><?php echo get_bloginfo('title'); ?></a>
            </div>
          </div>

          <div class="row row-2">

            <div class="col-lg-4 col-6 type--h-xxxs">

              <?php
              wp_nav_menu( array(
                'theme_location' => 'primary',
                'depth' => 1,
                'container' => false,
              ) ); ?>

            </div>

            <div class="col-lg-4 col-6 type--h-xxxs">
              <div class="supplemental-menu">
                <?php
                wp_nav_menu( array(
                  'theme_location' => 'footer',
                  'depth' => 1,
                  'container' => false,
                ) ); ?>
              </div>
            </div>

            <div class="col-lg-4 col-12 ml-auto">
              <div class="legal type--sm type--mb-xs">
                <?php if( get_field('footer_logo', 'option') ): ?>
                  <?php $image = get_field('footer_logo', 'option'); ?>
                  <noscript>
                    <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
                  </noscript>
                  <img class="lazyload" data-src="<?php echo $image['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $image['ID'], array( 2000, 2000 ) ); ?>" alt="<?php echo $image['alt']; ?>" />
                <?php endif; ?>
                <?php the_field('footer_additional_info', 'option'); ?>
              </div>
            </div>
          </div>

        </div>

    </footer>
  </div>
</div>

    <?php wp_footer(); ?>

</body>
</html>
