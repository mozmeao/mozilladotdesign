<?php
  // determine page title, NOTE: this logic is used from nav below as well
  // determine #
$term = get_term_by('name', 'Primary Navigation', 'nav_menu');
$menu_id = $term->term_id;
$links = wp_get_nav_menu_items($term->term_id);
$section_nav_links = array();
$target_id = get_the_ID();
if( wp_get_post_parent_id($target_id) ) {
  $target_id = wp_get_post_parent_id($target_id);
}
$brand_parent_id = $target_id;
$override_page = false;
if( get_field('display_child_page', $brand_parent_id) ) {
  $override_page = get_field('display_child_page', $brand_parent_id);
}
$page_title = get_bloginfo('title');
if( get_the_title($target_id)== 'Firefox Brand') {
  //$page_title = 'firefox dot design';
  $page_title = 'mozilla dot design';
}

?>
<!doctype html>
<!--[if lt IE 7]> <html class="lt-ie10 lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie10 lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie10 lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <?php /* <!-– Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-XXXXXX');</script>
    <!-– End Google Tag Manager --> */ ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <title>

    <?php // WordPress custom title script
    $section_name = get_bloginfo('name');
    if( $page_title == 'firefox dot design' ) {
      //$section_name = 'firefox dot design';
      $section_name = 'mozilla dot design';
    }
    // is the current page a tag archive page?
    if (function_exists('is_tag') && is_tag()) {

      // if so, display this custom title
      echo 'Tag Archive for &quot;'.$tag.'&quot; – ';


    } elseif( is_front_page() ) {
      echo 'Home – ';
    // or, is the page an archive page?
    } elseif (is_archive()) {

      // if so, display this custom title
      wp_title(''); echo ' Archive – ';

    // or, is the page a search page?
    } elseif (is_search()) {

      // if so, display this custom title
      echo 'Search for &quot;'.wp_specialchars($s).'&quot; – ';

    // or, is the page a single post or a literal page?
    } elseif (!(is_404()) && (is_single()) || (is_page())) {

      // if so, display this custom title
      echo get_the_title(); echo ' – ';

    // or, is the page an error page?
    } elseif (is_404()) {

      // yep, you guessed it
      echo 'Not Found – ';

    }
    // finally, display the blog name for all page types
    echo $section_name;
    ?>
  </title>
  <?php
  $favicon_url = get_template_directory_uri().'/assets/images/favicon-mozilla/favicon.ico';
  if( $section_name == 'firefox dot design' ) {
    $favicon_url = get_template_directory_uri().'/assets/images/favicon-firefox/favicon.ico';
  }
  ?>
  <link rel="shortcut icon" href="<?php echo $favicon_url; ?>"  id="favicon" />
  <?php wp_head(); ?>
</head>

<body <?php body_class('nojs'); ?>>
  <?php if( is_front_page() ) : ?>
    <div class="homepage-loader">
      <div class="loader-header">
        <div class="container-fluid">
          <div class="row d-flex align-items-lg-center justify-content-between">
            <div class="col-auto">
              <h1 class="type--ff-h-xxxs type--ff-mb-h-xxs"><a href="<?php echo get_site_url(); ?>" class=""><?php echo $page_title; ?></a></h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <header class="page-section page-section--site-header site-header" role="banner">
    <?php include('_partials/_block--quick-links.php'); ?>
    <div class="container-fluid">

      <div class="background ff-bg">
        <?php include('_partials/_block--interactive-firefox--no-text.php'); ?>
      </div>
      <div class="background mz-bg">
        <?php include('_partials/_block--interactive-mozilla.php'); ?>
      </div>
      <div class="update-content">
        <div class="row d-flex align-items-lg-center justify-content-between">
          <div class="col-auto">
            <h1 class="type--ff-h-xxxs type--ff-mb-h-xxs"><a href="<?php echo get_site_url(); ?>" class=""><?php echo $page_title; ?></a></h1>
          </div>


          <div class="col d-none d-lg-flex type--ff-h-xxxs justify-content-center">
            <div class="desktop-nav">
              <?php
              wp_nav_menu( array(
                'theme_location' => 'primary',
                'depth' => 1,
                'container' => false,
              ) ); ?>
            </div>
          </div>

          <div class="col-auto text-right d-none d-lg-block">
            <a href="#" class="type--ff-h-xxxs quick-links-toggle">Quick Links</a>
          </div>
          <div class="col-auto d-block d-lg-none">
            <a href="#mobile-nav-toggle" class="mobile-nav-toggle">
              <i class="icon icon--bars"><span class="sr-only">Toggle Menu</span></i>
            </a>
          </div>
        </div>
        <?php
        foreach( $links as $link ) {
          if( $link->post_parent == $target_id ) {
            $section_nav_links[$link->object_id] = array(
              'post_id' => $link->object_id
            );
          }
        }
        $output_count = '';
        $count = 0; foreach( $section_nav_links as $link ):
        $count++;
        if( $link['post_id'] == get_the_ID() ) {
          $output_id = $link['post_id'];
          $output_count = $count;
        }
      endforeach;
      if( $target_id ):
        ?>
        <div class="row mobile-interior-section-nav open">
          <div class="col-12">
            <div class="row d-flex align-items-center">
              <div class="col-5 type--h-xxxs">
                <a href="<?php echo get_permalink($target_id); ?>"><?php echo get_the_title($target_id); ?></a>
              </div>
              <div class="col-7 type--h-xxxs visible-links">
                <?php
                if( $output_count == 0 ) {
                  $output_count = 1;
                  $output_id = array_values($section_nav_links)[0]['post_id'];
                }
                ?>
                <a href="#" class="section-toggle"><span class="count">0<?php echo $output_count; ?></span> <span class="link-title"><?php echo get_the_title($output_id); ?></span></a>
              </div>

              <div class="dropdown col-12">
                <div class="row">
                  <div class="col-7 offset-5">
                    <ul class="section-nav-menu-links type--h-xxxs">
                      <?php $count = 0; foreach( $section_nav_links as $link ):  $count++; ?>
                      <?php
                      $permalink = get_permalink($link['post_id']);
                      if( $link['post_id'] == $override_page[0]->ID ) {
                        $permalink = get_permalink($brand_parent_id);
                      }
                      ?>
                      <li><a class="<?php echo ($current_id == $link['post_id']) ? 'current' : ''; ?>"href="<?php echo $permalink; ?>"><span class="count">0<?php echo $count; ?></span><span class="link-title"><?php echo get_the_title($link['post_id']); ?></span></a></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>


<div class="mobile-nav type--ff-h-sm">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <?php
        wp_nav_menu( array(
          'theme_location' => 'primary',
          'depth' => 2,
          'container' => false
        ) ); ?>
      </div>
    </div>
  </div>
</div>

</header>
<div data-barba="wrapper">
  <div class="barba-container" data-barba="container" data-barba-namespace="<?php echo ( is_front_page() ) ? 'home' : 'brand'; ?>">
    <?php /* <!-– Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXX"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-– End Google Tag Manager (noscript) --> */ ?>





    <div id="content" role="main" class="page-section--main">
      <div class="transition-content transition-out">
