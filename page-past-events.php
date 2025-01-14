<?php get_header(); ?>
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">
      <?php the_title(); ?></h1>
    <div class="page-banner__intro">
      <p>Welcome to my past events page</p>
    </div>
  </div>  
</div>
<div class="container container--narrow page-section">
  <?php
    $pasttoday =  date('Ymd');
    $pastEventQuery = new WP_Query(
      array(
        "paged" => get_query_var('paged', 1),
        "posts_per_page"  => 2,
        "post_type"       => "event",
        "meta_key"        => "events_date",
        "orderby"         => "meta_value_num",
        "order"           => "ASC",
        "meta_query"      => array (
          array(
            'key' => 'events_date',                 
            'compare' => '<',
            'value' => $pasttoday,                
            'type' => 'numeric',           
          )    
        )
      )
    );

    if($pastEventQuery->have_posts()) :
      while($pastEventQuery->have_posts()) :
        $pastEventQuery->the_post();
        ?>
          <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
              <?php
                $eventDate = new DateTime(get_field("events_date"));
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
      echo paginate_links(array(
        'total' => $pastEventQuery->max_num_pages,
      ));
    endif;
    wp_reset_postdata();
  ?>
</div>
<?php get_footer(); ?>