<?php 
  get_header();
  mainvisual(array(
    'title'    => 'This is Dr Anh Le',
    'subTitle' => 'Welcome to Dr Anh Le',
    'image'    => get_theme_file_uri( '/images/ocean.jpg' )
  ));
?>

<div class="container container--narrow page-section">
  <ul class="link-list min-list">
  <?php
    while(have_posts()) {
      the_post();
      ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
      <?php
    }
  ?>
  </ul>
</div>
<?php get_footer(); ?>