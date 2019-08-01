<?php
/*
Template Name: Editorial Page
*/
?>
<?php get_header(); ?>

<div class="interior-page-wrap">
  <div class="page-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php include('_partials/_field--page_content.php'); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if( get_field('custom_bumper') ): ?>

  <?php include('_partials/_block--bumper-custom.php'); ?>

<?php endif; ?>

<?php get_footer(); ?>
