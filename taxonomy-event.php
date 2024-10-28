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
  
    $the_query = new WP_Query(array(
      "post_type" => "post",
    ));

    if($the_query->have_posts()) {
      while($the_query->have_posts()) {
        $the_query->the_post();
        ?>
        <div class="post-item">
          <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <div class="metabox">
            <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
          </div>
          <div class="generic-content">
            <?php the_excerpt(20); ?>
            <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
          </div>
        </div>
        <?php
      }
      echo paginate_links();
    }
  ?>
</div>
<?php get_footer(); ?>