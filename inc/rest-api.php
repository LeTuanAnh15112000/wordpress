<?php
add_action( 'rest_api_init', function () {
  register_rest_route( 'university/v1', 'schools', array(
    'methods' => 'GET',
    'callback' => 'getResults',
  ) );
} );

function getResults($data) {
  $university = new WP_Query(array(
    "post_type" => ["post", "page", "event", "programmes", "professors"],
    "s" => $data["term"]
  ));
  $newArray = [
    "general_info" => [],
    "event" => [],
    "programmes" => [],
    "professors" => [],
  ];
  while($university->have_posts()):
    $university->the_post();
    // array_push($newArray, array(
    //   "title" => get_the_title(),
    //   "permalink" => get_the_permalink()
    // ));
    if(get_post_type() === "post" or get_post_type() == "page") {
      array_push( $newArray["general_info"], array(
        "title" => get_the_title(),
        "permalink" => get_the_permalink(),
        "post-type" => get_post_type()
      ));
    }
    if(get_post_type() == "event") {
      array_push( $newArray["event"], array(
        "title" => get_the_title(),
        "permalink" => get_the_permalink(),
        "post-type" => get_post_type()
      ));
    }
    if(get_post_type() == "programmes") {
      array_push( $newArray["programmes"], array(
        "title" => get_the_title(),
        "permalink" => get_the_permalink(),
        "post-type" => get_post_type()
      ));
    }
    if(get_post_type() == "professors") {
      array_push( $newArray["professors"], array(
        "title" => get_the_title(),
        "permalink" => get_the_permalink(),
        "post-type" => get_post_type(),
        "image" => get_the_post_thumbnail_url()
      ));
    }
  endwhile;
  return $newArray;
}