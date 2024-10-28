<?php
get_header();
if (have_posts()) {
  while (have_posts()) {
    the_post();
?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
      </div>
    </div>
    <div class="container container--narrow page-section">
      <div class="generic-content">
        <?php the_content(); ?>
      </div>
      <!-- block -->
      <?php
      $professorsQuery = new WP_Query(
        array(
          "posts_per_page"  => -1,
          "post_type"       => "professors",
          "orderby"         => "title",
          "order"           => "ASC",
          "meta_query"      => array(
            // query related lấy id của bài viết hiện tại so soánh với bài viết trong filed relate related_programs
            // khi mà tạo filed relationship giữa professors và programs thì trong database sẽ tạo ra 1 trường lưu data related_programs
            array(
              'key' => 'related_programs',
              'value' => '"' . get_the_ID() . '"',
              'compare' => 'LIKE'
            )
          )
        ) 
      );

      if ($professorsQuery->have_posts()) :
        echo '<hr class="section-break" />';
        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' professors</h2>';
        echo '<ul class="professor-card_list">';
        while ($professorsQuery->have_posts()) :
          $professorsQuery->the_post();
      ?>
        <li class="professor-card_list-item" style="list-style:none">
          <a href="<?php the_permalink(); ?>" class="professor-card">
            <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title(); ?>" class="professor-card__img">
            <span class="professor-card__name"><?php the_title(); ?></span>
          </a>
        </li>
      <?php
        endwhile;
        wp_reset_postdata();
        echo '</ul>';
      endif;
      ?>
      <!-- block -->
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo site_url("/programmes") ?>"><i class="fa fa-home" aria-hidden="true"></i>All Programmes</a><span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?></span>
      </div>
      <?php
      $today =  date('Ymd');
      $eventQuery = new WP_Query(
        array(
          "posts_per_page"  => -1,
          "post_type"       => "event",
          "meta_key"        => "events_date",
          "orderby"         => "meta_value_num",
          "order"           => "ASC",
          "meta_query"      => array(
            // query bài viết có ngày đã qua
            array(
              'key' => 'events_date',
              'compare' => '<=',
              'value' => $today,
              'type' => 'numeric',
            ),
            // query related lấy id của bài viết hiện tại so soánh với bài viết trong filed relate related_programs
            // khi mà tạo filed relationship giữa even và programs thì trong database sẽ tạo ra 1 trường lưu data related_programs
            array(
              'key' => 'related_programs',
              'value' => '"' . get_the_ID() . '"',
              'compare' => 'LIKE'
            )
          )
        )
      );

      if ($eventQuery->have_posts()) :
        echo '<hr class="section-break" />';
        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' event</h2>';
        while ($eventQuery->have_posts()) :
          $eventQuery->the_post();
      ?>
          <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
              <?php
              $eventDate = new DateTime(get_field("event_date"));
              ?>
              <span class="event-summary__month"><?php echo $eventDate->format("M"); ?></span>
              <span class="event-summary__day"><?php echo $eventDate->format("d"); ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="#"><?php the_title(); ?></a></h5>
              <p><?php echo wp_trim_words(get_the_content(), 25); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
      <?php
        endwhile;
        wp_reset_postdata();

      endif;
      ?>
    </div>
<?php
  }
}
get_footer();
?>