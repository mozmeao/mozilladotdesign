<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>

<div class="page-section page-section--card-listing card-listing">
  <div class="container-fluid">
    <div class="row">
      <?php
      $term = get_term_by('name', 'Primary Navigation', 'nav_menu');
      $menu_id = $term->term_id;

      $links = wp_get_nav_menu_items($menu_id);
      $cards = array();
      foreach( $links as $link ) {
        if( !$link->post_parent ) {
          $cards[$link->object_id] = array(
            'post_id' => $link->object_id
          );
        } else {
          $cards[$link->post_parent]['children'][$link->object_id] = array(
            'post_id' => $link->object_id
          );
        }
      }
      foreach ( $cards as $card ):
        ?>
        <div class="col-12 col-md-6 card-col">
          <div class="card-listing--card card">

            <?php if( get_field('listing_background', $card['post_id']) ):
              $image = get_field('listing_background', $card['post_id']);
              ?>
              <div class="card--image">
                <noscript>
                  <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo get_the_title($card['post_id']); ?>" />
                </noscript>
                <img class="lazyload" data-sizes="auto" data-src="<?php echo $image['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $image['ID'], array( 2000, 2000 ) ); ?>" alt="<?php echo get_the_title($card['post_id']); ?>" />
                <?php if( get_the_title($card['post_id']) == 'Firefox Brand' ): ?>
                <?php include('_partials/_block--interactive-firefox--no-text.php'); ?>
                <?php endif; ?>
                <?php if( get_the_title($card['post_id']) == 'Mozilla Brand' ): ?>
                <?php include('_partials/_block--interactive-mozilla.php'); ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <div class="card--content<?php echo (get_field('dark_text', $card['post_id'])) ? ' black' : ' white'; ?>">
              <a class="card-title<?php echo (get_the_title($card['post_id']) == "Firefox Brand") ? ' card-title--firefox' : ''; ?>" href="<?php the_permalink($card['post_id']); ?>"><span class="sr-only"><?php echo get_the_title($card['post_id']); ?></span></a>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12 d-flex flex-column">

                      <?php if( get_the_title($card['post_id']) == "Mozilla Brand" ): ?>
                        <h2 class="type--h-xxl type--mb-h-lg mozilla-logo">Mozilla</h2>
                        <?php elseif( get_the_title($card['post_id']) == "Firefox Brand" ): ?>
                          <h2 class="type--h-lg type--mb-h-lg">
                            <img class="firefox-logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-firefox-white.svg" alt="Firefox" width="235px" />
                          </h2>
                          <?php else: ?>
                            <h2 class="type--h-lg type--mb-h-lg"><?php echo get_the_title($card['post_id']); ?></h2>
                          <?php endif; ?>


                        <?php if( !empty($card['children'] ) ): ?>
                          <div class="card--menu section-nav-menu <?php echo ( get_the_title($card['post_id']) == "Mozilla Brand" ) ? ' style--mozilla type--mz-h-md type--mb-mz-h-xxs' : ' style--normal type--h-md type--mb-h-xxs'; ?>">
                            <?php
                            $brand_parent_id = $card['post_id'];
                            $override_page = false;
                            if( get_field('display_child_page', $brand_parent_id) ) {
                              $override_page = get_field('display_child_page', $brand_parent_id);
                            }
                            ?>
                            <ul class="menu">
                              <?php $count = 0; foreach( $card['children'] as $child ) : $count++; ?>
                              <?php
                              $permalink = get_permalink($child['post_id']);
                              if( $override_page !== false && $override_page[0]->ID == $child['post_id'] ) {
                                $permalink = get_permalink($brand_parent_id);
                              }
                              ?>
                              <li><a href="<?php echo $permalink; ?>"><span class="count">0<?php echo $count; ?></span><span class="link-title"><?php echo get_the_title($child['post_id']); ?></span></a></li>
                              <?php endforeach; ?>
                            </ul>
                          </div>
                        <?php endif; ?>

                        <?php if( get_field('tagline', $card['post_id'])): ?>

                          <div class="card--tagline mt-auto<?php echo ( get_the_title($card['post_id']) == "Mozilla Brand" ) ? ' type--mz-h-sm type--mz-mb-h-xs' : ' type--h-sm type--mb-h-xs'; ?>">
                            <?php the_field('tagline', $card['post_id']); ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php get_footer(); ?>
