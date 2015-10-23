<?php
add_action( 'init', 'portfolio_init' );

function portfolio_init() {
$labels = array(
'name'               => _x( 'Матчи', 'post type general name', 'brushed' ),
'singular_name'      => _x( 'Матчи', 'post type singular name', 'brushed' ),
'menu_name'          => _x( 'Матчи', 'admin menu', 'brushed' ),
'name_admin_bar'     => _x( 'Матчи', 'add new on admin bar', 'brushed' ),
'add_new'            => _x( 'Добавить матч', 'portfolio', 'brushed' ),
'add_new_item'       => __( 'Добавить новый матч', 'brushed' ),
'new_item'           => __( 'Новый матч', 'brushed' ),
'edit_item'          => __( 'Редактировать матч', 'brushed' ),
'view_item'          => __( 'Просмотр матча', 'brushed' ),
'all_items'          => __( 'Все матчи', 'brushed' ),
'search_items'       => __( 'Поиск матчей', 'brushed' ),
'parent_item_colon'  => __( 'Родительский матч:', 'brushed' ),
'not_found'          => __( 'Матч не найден.', 'brushed' ),
'not_found_in_trash' => __( 'Матчи не найдены в корзине.', 'brushed' ),
);

$args = array(
'labels'             => $labels,
'public'             => true,
'publicly_queryable' => true,
'show_ui'            => true,
'show_in_menu'       => true,
'query_var'          => true,
'rewrite'            => array( 'slug' => 'portfolio' ),
'capability_type'    => 'post',
'has_archive'        => true,
'hierarchical'       => false,
'menu_position'      => null,
'supports'           => array( 'title')
);

register_post_type( 'portfolio', $args );
}


// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_portfolio_taxonomies');

// create two taxonomies, genres and writers for the post type "book"
function create_portfolio_taxonomies() {


    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Турниры', 'taxonomy general name','brushed' ),
        'singular_name'              => _x( 'Турнир', 'taxonomy singular name','brushed' ),
        'search_items'               => __( 'Поиск турниров','brushed' ),
        'popular_items'              => __( 'Популярные турниры','brushed' ),
        'all_items'                  => __( 'Все турниры','brushed' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Редактировать турнир','brushed' ),
        'update_item'                => __( 'Обновить турнир','brushed' ),
        'add_new_item'               => __( 'Добавить новый турнир','brushed' ),
        'new_item_name'              => __( 'Имя нового турнира','brushed' ),
        'separate_items_with_commas' => __( 'разделите турниры запятыми','brushed' ),
        'add_or_remove_items'        => __( 'Добавить или удалить турнир' ,'brushed'),
        'choose_from_most_used'      => __( 'Выбрать с наиболее используемых турниров','brushed' ),
        'not_found'                  => __( 'Турниры не найдены.','brushed' ),
        'menu_name'                  => __( 'Турниры' ,'brushed'),
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'category' ),
    );

    register_taxonomy( 'categories', 'portfolio', $args );
}