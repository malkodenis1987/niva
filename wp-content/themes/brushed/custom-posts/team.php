<?php
add_action( 'init', 'team_init' );

function team_init() {
	$labels = array(
		'name'               => _x( 'Состав', 'post type general name', 'brushed' ),
		'singular_name'      => _x( 'Состав', 'post type singular name', 'brushed' ),
		'menu_name'          => _x( 'Состав', 'admin menu', 'brushed' ),
		'name_admin_bar'     => _x( 'Состав', 'add new on admin bar', 'brushed' ),
		'add_new'            => _x( 'Добавить игрока', 'portfolio', 'brushed' ),
		'add_new_item'       => __( 'Добавить нового игрока', 'brushed' ),
		'new_item'           => __( 'Новый игрок', 'brushed' ),
		'edit_item'          => __( 'Редактировать игрока', 'brushed' ),
		'view_item'          => __( 'Просмотр игрока', 'brushed' ),
		'all_items'          => __( 'Все игроки', 'brushed' ),
		'search_items'       => __( 'Найти игрока', 'brushed' ),
		'parent_item_colon'  => __( 'Родительский игрок:', 'brushed' ),
		'not_found'          => __( 'Игрок не найден.', 'brushed' ),
		'not_found_in_trash' => __( 'Игрок не найден в корзине.', 'brushed' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'team' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title')
	);

	register_post_type( 'team', $args );
}


// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_team_taxonomies');

// create two taxonomies, genres and writers for the post type "book"
function create_team_taxonomies() {


	$labels = array(
		'name'              => _x( 'Позиция', 'taxonomy general name' , 'brushed'),
		'singular_name'     => _x( 'Позиция', 'taxonomy singular name' , 'brushed'),
		'search_items'      => __( 'Найти позиции', 'brushed' ),
		'all_items'         => __( 'Все позиции', 'brushed' ),
		'parent_item'       => __( 'Родительская позиция' , 'brushed'),
		'parent_item_colon' => __( 'Родительская позиция:' , 'brushed'),
		'edit_item'         => __( 'Резактировать позицию', 'brushed' ),
		'update_item'       => __( 'Обновить позицию', 'brushed' ),
		'add_new_item'      => __( 'Добавить новую позицию' , 'brushed'),
		'new_item_name'     => __( 'Новое имя позиции' , 'brushed'),
		'menu_name'         => __( 'Позиция' , 'brushed'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'function' ),
	);

	register_taxonomy( 'functions', 'team', $args );
}