<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.01.15
 * Time: 22:37
 */
add_action( 'init', 'teams_init' );

function teams_init() {
    $labels = array(
        'name'               => _x( 'Команды', 'post type general name', 'brushed' ),
        'singular_name'      => _x( 'Команды', 'post type singular name', 'brushed' ),
        'menu_name'          => _x( 'Команды', 'admin menu', 'brushed' ),
        'name_admin_bar'     => _x( 'Команды', 'add new on admin bar', 'brushed' ),
        'add_new'            => _x( 'Добавить команду', 'portfolio', 'brushed' ),
        'add_new_item'       => __( 'Добавить новую команду', 'brushed' ),
        'new_item'           => __( 'Новая команда', 'brushed' ),
        'edit_item'          => __( 'Редактировать команду', 'brushed' ),
        'view_item'          => __( 'Просмотр команды', 'brushed' ),
        'all_items'          => __( 'Все команды', 'brushed' ),
        'search_items'       => __( 'Поиск команд', 'brushed' ),
        'parent_item_colon'  => __( 'Родительская команда:', 'brushed' ),
        'not_found'          => __( 'Команда не найдена.', 'brushed' ),
        'not_found_in_trash' => __( 'Команды не найдены в корзине.', 'brushed' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'teams' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail')
    );

    register_post_type( 'teams', $args );
}