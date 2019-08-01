<?php 
$page = get_page_by_path( 'mozilla' );

if( get_field('interactive_fallback_image', $page) ):
  $image = get_field('interactive_fallback_image', $page);
?>
<div class="brand-interactive mozilla-interactive">
  <noscript>
    <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo get_the_title($card['post_id']); ?>" />
  </noscript>
  <img class="lazyload fallback" data-sizes="auto" data-src="<?php echo $image['sizes']['large']; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $image['ID'], array( 2000, 2000 ) ); ?>" alt="<?php echo get_the_title($card['post_id']); ?>" />

  <?php 
  /* 
  <iframe title="Mozilla Animation" src="<?php echo get_template_directory_uri(); ?>/assets/interactives/mozilla-anim/full.html" style="border:0" frameboder="0" border="0" scrolling="no"></iframe> 
  */
  ?>
</div>
<?php endif; ?>
