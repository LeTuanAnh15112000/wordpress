<?php 
get_header();
  if(have_posts()) {
    while(have_posts()) {
      the_post();
        mainvisual(array(
          'title'    => 'This is Dr Anh Le',
          'subTitle' => 'Welcome to Dr Anh Le',
          'image'    => get_theme_file_uri( '/images/ocean.jpg' )
        ));
      ?>
        <!-- <div class="page-banner">
          <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
          <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
          </div>  
        </div> -->
        <div class="container container--narrow page-section">
          <div class="generic-content">
            <div class="row group">
              <div class="one-third"><img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title();   ?>"></div>
              <div class="two-thirds"><?php the_content(); ?></div>
            </div>
          </div>
          <?php
            $relatedPrograms = get_field('related_programs');
            if( $relatedPrograms ): ?>
              <hr class="section-break">
              <h3 class="headline headline--medium">Related Programs</h3>
              <ul>
                <?php foreach( $relatedPrograms as $post ): 
                    setup_postdata($post); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endforeach; ?>
              </ul>
              <?php 
              wp_reset_postdata(); ?>
          <?php endif; ?>
        </div>
      <?php
    }
  }
get_footer();
?>