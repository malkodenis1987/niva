<?php

return array(
	'id'          => 'team_metaboxes',
	'types'       => array('team'),
	'title'       => __('Настройки команды', 'brushed'),
	'priority'    => 'high',
	'template'    => array(
		array(
			'type' => 'upload',
			'name' => 'team_upload',
			'label' => __('Загрузить фото игрока', 'brushed'),
			'description' => __('', 'brushed'),
			'default' => '',
		),
		array(
			'type' => 'textbox',
			'name' => 'member_name',
			'label' => __('Полное имя', 'brushed'),
			'description' => __('', 'brushed'),
			'default' => '',
			'validation' => 'alpha',
		),
		array(
			'type' => 'textbox',
			'name' => 'member_description',
			'label' => __('Описание игрока', 'brushed'),
			'description' => __('', 'brushed'),
			'default' => '',
			'validation' => 'alpha',
		),
        array(
            'type' => 'textbox',
            'name' => 'member_vk_url',
            'label' => __('Вконтакте URL', 'brushed'),
            'description' => __('', 'brushed'),
            'default' => '',
            'validation' => 'alpha',
        ),
		array(
			'type' => 'textbox',
			'name' => 'member_facebook_url',
			'label' => __('Facebook URL', 'brushed'),
			'description' => __('', 'brushed'),
			'default' => '',
			'validation' => 'alpha',
		),
		array(
			'type' => 'textbox',
			'name' => 'member_twitter_url',
			'label' => __('Twitter URL', 'brushed'),
			'description' => __('', 'brushed'),
			'default' => '',
			'validation' => 'alpha',
		),
		array(
			'type' => 'textbox',
			'name' => 'member_linkedin',
			'label' => __('LinkedIn URL', 'brushed'),
			'description' => __('', 'brushed'),
			'default' => '',
			'validation' => 'alpha',
		),
		array(
			'type' => 'textbox',
			'name' => 'member_googleplus',
			'label' => __('Google Plus URL', 'brushed'),
			'description' => __('', 'brushed'),
			'default' => '',
			'validation' => 'alpha',
		),
		array(
			'type' => 'textbox',
			'name' => 'member_vimeo',
			'label' => __('Vimeo URL', 'brushed'),
			'description' => __('', 'brushed'),
			'default' => '',
			'validation' => 'alpha',
		),


	),
);

/**
 * EOF
 */