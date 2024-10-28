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
        <div class="container container--narrow page-section">
          <div class="generic-content">
            <?php the_content(); ?>
          </div>
          <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo site_url("/blog") ?>"><i class="fa fa-home" aria-hidden="true"></i>All Event</a> <span class="metabox__main">
            Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?></span>
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