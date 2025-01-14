<?php get_header(); ?>
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">
      <?php $category = get_queried_object();
        echo $category->name; 
      ?></h1>
    <div class="page-banner__intro">
      <p><?php echo $category->description; ?></p>
    </div>
  </div>  
</div>
<div class="container container--narrow page-section">
  <?php
    if(have_posts()) {
      while(have_posts()) {
        the_post();
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
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p><?php echo wp_trim_words(get_the_content(), 25); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
        <?php
      }
      echo paginate_links();
    }
  ?>
  <hr>
  <p>Looking for all past events. <a href="<?php echo site_url('/pase-events'); ?>">Check out past event in here</a></p>
</div>
<?php get_footer(); ?>