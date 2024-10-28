<?php
require get_theme_file_path('/inc/rest-api.php');
// thêm field vào rest api của wordpress
function registerField()
{
    register_rest_field("post", "authorName", array(
        "get_callback" => function () {
            return get_author_name();
        },
    ));
    register_rest_field("post", "thumbnail", array(
        "get_callback" => function () {
            return get_the_post_thumbnail_url();
        },
    ));
}
add_action("rest_api_init", "registerField");

add_theme_support('post-thumbnails');

//tắt thanh bar
add_filter('show_admin_bar', '__return_false');

// add js and css
function load_assets()
{
    wp_enqueue_style('index', get_theme_file_uri('/build/index.css'));
    wp_enqueue_style('style-index', get_theme_file_uri('/build/style-index.css'));

    // ========== JAVASCRIPT ==========
    wp_enqueue_script('build-js', get_theme_file_uri('/build/index.js'), array(), '', 1);

    wp_localize_script('build-js', 'universityData', array(
        'root_url' => get_site_url()
    ));
}
add_action('wp_enqueue_scripts', 'load_assets');

// add menu

function add_menu()
{
    add_theme_support('menus');
    register_nav_menus(
        array(
            'menu-explore' => esc_html__('Explore', 'nav_menu'),
            'menu-learn' => esc_html__('Learn', 'nav_menu'),
        )
    );
}

add_action('init', 'add_menu');

//add class active in menu
add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);

function special_nav_class($classes, $item)
{
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active ';
    }
    return $classes;
}

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int ( Maybe ) modified excerpt length.
 */

function wpdocs_custom_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'wpdocs_custom_excerpt_length', 999);

//tạo mới 1 main query
function event_query($query)
{
    $today = date('ymd');
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('event')) {
        $query->set('meta_key', 'events_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'events_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric',
            )
        ));
    } else if (!is_admin() && $query->is_main_query() && is_post_type_archive('programmes')) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }
}

add_action('pre_get_posts', 'event_query');

//xử lý hình ảnh cho post type = professors
add_action('after_setup_theme', 'wpdocs_theme_setup');
function wpdocs_theme_setup()
{
    // add_theme_support( 'post-thumbnails' );
    add_image_size('professorsLandscape', 400, 260, true);
    add_image_size('professorsPortrail', 480, 650, true);
}

//khai báo get mainvisual
function mainvisual($arr)
{
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $arr['image']; ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <?php if (!empty($arr['title'])): ?>
                <h1 class="page-banner__title"><?php echo $arr['title']; ?></h1>
            <?php endif ?>
            <?php if (!empty($arr['subTitle'])): ?>
                <div class="page-banner__intro">
                    <p><?php echo $arr['subTitle']; ?></p>
                </div>
            <?php endif ?>
        </div>
    </div>
    <?php
}

//Search multiple posts type