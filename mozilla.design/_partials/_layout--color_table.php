<div class="page-content-layout page-section page-section--color-table color-table">
  <?php if( get_sub_field('section_intro') ): ?>
    <div class="row">
      <div class="col-12 col-lg-9">
        <?php include('_field--section_intro.php'); ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="row">
    <?php if( get_sub_field('style') == 'centered' ): ?>
      <div class="col-12">
        <div class="color-table color-table--<?php the_sub_field('style'); ?>">
          <?php
          $display_colors = array(
            '#FF298A' => 'Pink',
            '#FF4F5E' => 'Red',
            '#FF7139' => 'Orange',
            '#FFD567' => 'Yellow',
            '#0060DF' => 'Blue',
            '#9059FF' => 'Violet',
            '#952BB9' => 'Purple',
          );

          foreach( $display_colors as $hex => $label ):
            ?>
            <div class="table-row">
              <div class="color" style="background:<?php echo $hex; ?>"></div>
              <div class="text">
                <p class="type--sm"><?php echo $label;?><br><?php echo $hex; ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if( get_sub_field('style') == 'full' ):

      $rows = array(
        array(
          '#E3FFF3' => '',
          '#D0FFED' => '',
          '#B3FFE3' => '',
          '#88FFD1' => '',
          '#53FEBE' => '',
          '#3FE1B0' => '',
          '#2BC4A2' => '',
          '#068989' => '',
          '#005E5D' => '',
          '#083F37' => ''
        ),
        array(
          '#ACF1FF' => '',
          '#80EAFF' => '',
          '#00DDFF' => '',
          '#00B3F5' => '',
          '#0290EE' => '',
          '#0060E0' => '',
          '#0250BC' => '',
          '#063F96' => '',
          '#073072' => '',
          '#0A214D' => ''
        ),
        array(
          '#E6DFFF' => '',
          '#D9BFFF' => '',
          '#CC9EFF' => '',
          '#C588FF' => '',
          '#AC71FF' => '',
          '#9059FF' => '',
          '#7543E3' => '',
          '#582ACB' => '',
          '#46278E' => '',
          '#321C64' => ''
        ),
        array(
          '#F7E3FF' => '',
          '#F6B9FF' => '',
          '#F690FF' => '',
          '#F564FF' => '',
          '#D64CF1' => '',
          '#B933E1' => '',
          '#962BB9' => '',
          '#712290' => '',
          '#4D1A69' => '',
          '#2B1141' => ''
        ),
        array(
          '#FFDFF0' => '',
          '#FFB4DB' => '',
          '#FF8AC6' => '',
          '#FF6BBB' => '',
          '#FE4AA3' => '',
          '#FF2A8A' => '',
          '#E11586' => '',
          '#C60184' => '',
          '#7F165B' => '',
          '#50134C' => ''
        ),
        array(
          '#FFE0E8' => '',
          '#FFBEC6' => '',
          '#FF9AA2' => '',
          '#FF848C' => '',
          '#FF6A75' => '',
          '#FF505F' => '',
          '#E02950' => '',
          '#C50143' => '',
          '#800220' => '',
          '#440307' => ''
        ),
        array(
          '#FFF4DE' => '',
          '#FFD6B2' => '',
          '#FFB588' => '',
          '#FEA365' => '',
          '#FE8A4F' => '',
          '#FF7139' => '',
          '#E25821' => '',
          '#CD3D00' => '',
          '#9D280C' => '',
          '#7B1604' => ''
        ),
        array(
          '#FFFFCD' => '',
          '#FEFF95' => '',
          '#FFEA7F' => '',
          '#FFD567' => '',
          '#FFBD4F' => '',
          '#FFA537' => '',
          '#E17F2E' => '',
          '#C45A28' => '',
          '#A7341F' => '',
          '#960F18' => ''
        )
      );

      ?>
      <div class="col-12 d-sm-flex">
        <div class="color-table color-table--<?php the_sub_field('style'); ?>">
          <table>
            <tbody>
              <?php foreach( $rows as $row => $colors ): ?>
                <tr>
                  <?php foreach( $colors as $hex => $label ): ?>
                    <td><div class="color" data-hex="<?php echo $hex; ?>" data-label="<?php echo $label; ?>" style="background:<?php echo $hex; ?>;"></div></td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="current">#000000</div>
      </div>
    <?php endif; ?>

    <?php if( get_sub_field('style') == 'gradient' ): ?>
      <div class="col-12">
        <div class="color-table color-table--<?php the_sub_field('style'); ?>">
          <noscript>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/color-table-gradient.png" alt="Gradients" />
          </noscript>
          <img class="lazyload" data-src="<?php echo get_template_directory_uri(); ?>/assets/images/color-table-gradient.png" alt="Gradients" />
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>



