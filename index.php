<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo TMP_URL; ?>/images/library-hero.jpg)"></div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
    <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
    <a href="#" class="btn btn--large btn--blue">Find Your Major</a>
  </div>
</div>

<div class="full-width-split group">
  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

      <?php
        $today =  date('Ymd');
        $eventQuery = new WP_Query(
          array(
            "posts_per_page"  => 2,
            "post_type"       => "event",
            "meta_key"        => "events_date",
            "orderby"         => "meta_value_num",
            "order"           => "ASC",
            "meta_query"      => array (
              array(
                'key' => 'events_date',                 
                'compare' => '>=',
                'value' => $today,                
                'type' => 'numeric',           
              )    
            )
          )
        );

        if($eventQuery->have_posts()) :
          while($eventQuery->have_posts()) :
            $eventQuery->the_post();
            ?>
              <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php echo the_permalink(); ?>">
                  <?php
                    $eventDate = new DateTime(get_field("event_date"));
                  ?>
                  <span class="event-summary__month"><?php echo $eventDate->format("M"); ?></span>
                  <span class="event-summary__day"><?php echo $eventDate->format("d"); ?></span>
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h5>
                  <p><?php echo wp_trim_words(get_the_content(), 25); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                </div>
              </div>
            <?php
          endwhile;
        endif;
      ?>
      <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link("event") ?>" class="btn btn--blue">View All Events</a></p>
    </div>
  </div>
  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
      <?php
        // The Query.
        $the_query = new WP_Query( 
          array(
            "posts_per_page" => 2,
            "post_type" => "post",
          )
         );

        // The Loop.
        if ( $the_query->have_posts() ) {
          while ( $the_query->have_posts() ) {
            $the_query->the_post();
            ?>
            <div class="event-summary">
              <a class="event-summary__date event-summary__date--beige t-center" href="#">
                <span class="event-summary__month"><?php the_time('M') ?></span>
                <span class="event-summary__day"><?php the_time('d') ?></span>
              </a>
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?php echo wp_trim_words(get_the_content(), 25); ?><a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
              </div>
            </div>
            <?php
          }
        } else {
          esc_html_e( 'Sorry, no posts matched your criteria.' );
        }
        wp_reset_postdata();
      ?>
      <p class="t-center no-margin"><a href="#" class="btn btn--yellow">View All Blog Posts</a></p>
    </div>
  </div>
</div>

<div class="hero-slider">
  <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
      <div class="hero-slider__slide" style="background-image: url(<?php echo TMP_URL; ?>/images/bus.jpg)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Transportation</h2>
            <p class="t-center">All students have free unlimited bus fare.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide" style="background-image: url(<?php echo TMP_URL; ?>/images/apples.jpg)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">An Apple a Day</h2>
            <p class="t-center">Our dentistry program recommends eating apples.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide" style="background-image: url(<?php echo TMP_URL; ?>/images/bread.jpg)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Food</h2>
            <p class="t-center">Fictional University offers lunch plans for those in need.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
  </div>
</div>
<?php get_footer(); ?>