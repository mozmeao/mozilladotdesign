<?php
while ( have_rows( 'page_content' ) ) : the_row();
    get_template_part( '_partials/_layout--'.get_row_layout() );
endwhile; ?>
