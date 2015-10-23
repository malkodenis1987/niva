<?php


return array(
    'title' => __('Настройки темы', 'brushed'),
    'logo' => '',
    'menus' => array(
	    array(
		    'title' => __('Основные настройки', 'brushed'),
		    'name' => 'general',
		    'icon' => 'font-awesome:fa-cogs',
		    'controls' => array(

					    array(
						    'type' => 'textbox',
						    'name' => 'title',
						    'label' => __('Название страницы', 'brushed'),
						    'description' => __('', 'brushed'),
						    'default' => '',
					    ),
					    array(
						    'type' => 'upload',
						    'name' => 'favicon',
						    'label' => __('Загрузить Favicon', 'brushed'),
						    'description' => __('.png или .ico изображение', 'brushed'),
						    'default' => '',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'primary_color',
						    'label' => __('Основной цвет Body', 'brushed'),
						    'description' => __('Выберете цвет и прозрачность!', 'brushed'),
						    'default' => '',
						    'format' => 'rgba',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'secondary_color',
						    'label' => __('Второстепенный цвет Body', 'brushed'),
						    'description' => __('Выберете цвет и прозрачность!', 'brushed'),
						    'default' => '',
						    'format' => 'rgba',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'hover_color',
						    'label' => __('Цвет при наведении', 'brushed'),
						    'description' => __('Выберете цвет и прозрачность!', 'brushed'),
						    'default' => '',
						    'format' => 'rgba',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'preloader_background',
						    'label' => __('Цвет Preloader', 'brushed'),
						    'description' => __('', 'brushed'),
						    'default' => '#98ed28',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'circle_background',
						    'label' => __('Preloader загрузки', 'brushed'),
						    'description' => __('Circle Background Color.', 'brushed'),
						    'default' => '#98ed28',
					    ),
					    array(
						    'type' => 'toggle',
						    'name' => 'to_top',
						    'label' => __('Кнопка "Вверх"', 'brushed'),
						    'description' => __('', 'brushed'),
						    'default' => '1',
					    ),
					    array(
						    'type' => 'toggle',
						    'name' => 'smooth',
						    'label' => __('Эфект плавной прокрутки', 'brushed'),
						    'description' => __('', 'brushed'),
						    'default' => '1',
					    ),
					    array(
						    'type' => 'codeeditor',
						    'name' => 'analytics',
						    'label' => __('Analytics Code', 'brushed'),
						    'description' => __('Write without "script" tags', 'brushed'),
						    'theme' => 'twilight',
						    'mode' => 'javascript',
					    ),
					    array(
						    'type' => 'codeeditor',
						    'name' => 'custom_css',
						    'label' => __('Custom CSS', 'brushed'),
						    'description' => __('Write without "style" tags', 'brushed'),
						    'theme' => 'github',
						    'mode' => 'css',
					    ),
					    array(
						    'type' => 'codeeditor',
						    'name' => 'custom_js',
						    'label' => __('Custom JS', 'brushed'),
						    'description' => __('Write without "script" tags', 'brushed'),
						    'theme' => 'twilight',
						    'mode' => 'javascript',
					    ),

		    ),
	    ),

	    array(
		    'title' => __('Настройки слайдера', 'brushed'),
		    'name' => 'slider',
		    'icon' => 'font-awesome:fa-picture-o',
		    'controls' => array(
			    array(
				    'type' => 'select',
				    'name' => 'select_slider_effect',
				    'label' => __('Select Slider Effect', 'brushed'),
				    'items' => array(
					    array(
						    'value' => '1',
						    'label' => __('Fade', 'brushed'),
					    ),
					    array(
						    'value' => '2',
						    'label' => __('Slide Top', 'brushed'),
					    ),
					    array(
						    'value' => '3',
						    'label' => __('Slide Right', 'brushed'),
					    ),
					    array(
						    'value' => '4',
						    'label' => __('Slide Bottom', 'brushed'),
					    ),
					    array(
						    'value' => '5',
						    'label' => __('Slide Left', 'brushed'),
					    ),
					    array(
						    'value' => '6',
						    'label' => __('Carousel Right', 'brushed'),
					    ),
					    array(
						    'value' => '7',
						    'label' => __('Carousel Left', 'brushed'),
					    ),
				    ),
				    'default' => array(
					    '1',
				    ),
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'slide_interval',
				    'label' => __('Slide Interval', 'brushed'),
				    'description' => __('Length between transitions, in milliseconds', 'brushed'),
				    'default' => '',
				    'validation' => 'numeric',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'transition_speed',
				    'label' => __('Transition Speed', 'brushed'),
				    'description' => __('in milliseconds', 'brushed'),
				    'default' => '',
				    'validation' => 'numeric',
			    ),
			    array(
				    'type' => 'toggle',
				    'name' => 'keyboard_nav',
				    'label' => __('Keyboard navigation', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
			    ),
			    array(
				    'type' => 'select',
				    'name' => 'number_slides',
				    'label' => __('Number Slides', 'brushed'),
				    'default' => 1,
				    /*'items' => array(
					'data' => array(
						array(
							'source' => 'function',
							'value'  => 'vp_get_pages',
						),
					),
				),*/
				    'items' => array(
					    array(
						    'value' => 1,
						    'label' => __('1 Slide','brushed')
					    ),
					    array(
						    'value' => 2,
						    'label' => __('2 Slides','brushed')
					    ),
					    array(
						    'value' => 3,
						    'label' => __('3 Slides','brushed')
					    ),
					    array(
						    'value' => 4,
						    'label' => __('4 Slides','brushed')
					    ),
					    array(
						    'value' => 5,
						    'label' => __('5 Slides','brushed')
					    ),
					    array(
						    'value' => 6,
						    'label' => __('6 Slides','brushed')
					    ),
					    array(
						    'value' => 7,
						    'label' => __('7 Slides','brushed')
					    ),
					    array(
						    'value' => 8,
						    'label' => __('8 Slides','brushed')
					    ),
					    array(
						    'value' => 9,
						    'label' => __('9 Slides','brushed')
					    ),

					    array(
						    'value' => 10,
						    'label' => __('10 Slides','brushed')
					    )
				    )
			    ),
			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload1',
				    'label' => __('Upload image nr. 1', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select10',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload2',
				    'label' => __('Upload image nr.2', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select9',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload3',
				    'label' => __('Upload image nr.3', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select8',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload4',
				    'label' => __('Upload image nr.4', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select7',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload5',
				    'label' => __('Upload image nr.5', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select6',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload6',
				    'label' => __('Upload image nr.6', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select5',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload7',
				    'label' => __('Upload image nr.7', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select4',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload8',
				    'label' => __('Upload image nr.8', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select3',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload9',
				    'label' => __('Upload image nr.9', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select2',
				    )
			    ),

			    array(
				    'type' => 'upload',
				    'name' => 'slide_upload10',
				    'label' => __('Upload image nr.10', 'brushed'),
				    'description' => __('', 'brushed'),
				    'default' => '',
				    'dependency'    => array(
					    'field' => 'number_slides',
					    'function' => 'vp_vz_select1',
				    )
			    ),

			    ),


			    ),

	    array(
		    'title' => __('Настройки типографии', 'brushed'),
		    'name' => 'typography',
		    'icon' => 'font-awesome:fa-pencil',
		    'controls' => array(
			    array(
				    'type' => 'section',
				    'title' => __('Body', 'brushed'),
				    'fields' => array(
					    array(
						    'type' => 'html',
						    'name' => 'body_font_preview',
						    'binding' => array(
							    'field'    => 'body_font_face,body_font_style,body_font_weight,body_font_size, body_line_height',
							    'function' => 'vp_font_preview',
						    ),
					    ),
					    array(
						    'type' => 'select',
						    'name' => 'body_font_face',
						    'label' => __('Body Font Face', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'function',
									    'value' => 'vp_get_gwf_family',
								    ),
							    ),
						    ),
						    'default' => '{{first}}'
					    ),
					    array(
						    'type' => 'radiobutton',
						    'name' => 'body_font_style',
						    'label' => __('Body Font Style', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'binding',
									    'field' => 'body_font_face',
									    'value' => 'vp_get_gwf_style',
								    ),
							    ),
						    ),
						    'default' => array(
							    '{{first}}',
						    ),
					    ),
					    array(
						    'type' => 'radiobutton',
						    'name' => 'body_font_weight',
						    'label' => __('Body Font Weight', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'binding',
									    'field' => 'body_font_face',
									    'value' => 'vp_get_gwf_weight',
								    ),
							    ),
						    ),
					    ),
					    array(
						    'type'    => 'slider',
						    'name'    => 'body_font_size',
						    'label'   => __('Body Font Size (px)', 'brushed'),
						    'min'     => '5',
						    'max'     => '32',
						    'default' => '16',
					    ),
					    array(
						    'type'    => 'slider',
						    'name'    => 'body_line_height',
						    'label'   => __('Body Line Height (em)', 'brushed'),
						    'min'     => '0',
						    'max'     => '3',
						    'default' => '1.5',
						    'step'    => '0.1',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'body_color',
						    'label' => __('Body Text Color', 'brushed'),
						    'description' => __('', 'brushed'),
						    'default' => '',
					    ),
				    ),
			    ),

			    array(
				    'type' => 'section',
				    'title' => __('Menu Item', 'brushed'),
				    'fields' => array(
					    array(
						    'type' => 'html',
						    'name' => 'menu_font_preview',
						    'binding' => array(
							    'field'    => 'menu_font_face,menu_font_style,menu_font_weight,menu_font_size, menu_line_height',
							    'function' => 'vp_font_preview',
						    ),
					    ),
					    array(
						    'type' => 'select',
						    'name' => 'menu_font_face',
						    'label' => __('Menu Font Face', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'function',
									    'value' => 'vp_get_gwf_family',
								    ),
							    ),
						    ),
						    'default' => '{{first}}'
					    ),
					    array(
						    'type' => 'radiobutton',
						    'name' => 'menu_font_style',
						    'label' => __('Menu Font Style', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'binding',
									    'field' => 'menu_font_face',
									    'value' => 'vp_get_gwf_style',
								    ),
							    ),
						    ),
						    'default' => array(
							    '{{first}}',
						    ),
					    ),
					    array(
						    'type' => 'radiobutton',
						    'name' => 'menu_font_weight',
						    'label' => __('Menu Font Weight', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'binding',
									    'field' => 'menu_font_face',
									    'value' => 'vp_get_gwf_weight',
								    ),
							    ),
						    ),
					    ),
					    array(
						    'type'    => 'slider',
						    'name'    => 'menu_font_size',
						    'label'   => __('Menu Font Size (px)', 'brushed'),
						    'min'     => '5',
						    'max'     => '32',
						    'default' => '16',
					    ),
					    array(
						    'type'    => 'slider',
						    'name'    => 'menu_line_height',
						    'label'   => __('Menu Line Height (em)', 'brushed'),
						    'min'     => '0',
						    'max'     => '3',
						    'default' => '1.5',
						    'step'    => '0.1',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'menu_color',
						    'label' => __('Menu Text Color', 'brushed'),
						    'description' => __('', 'brushed'),
						    'default' => '',
					    ),
				    ),
			    ),

			    array(
				    'type' => 'section',
				    'title' => __('H2', 'brushed'),
				    'fields' => array(
					    array(
						    'type' => 'html',
						    'name' => 'h2_font_preview',
						    'binding' => array(
							    'field'    => 'h2_font_face,h2_font_style,h2_font_weight,h2_font_size, h2_line_height',
							    'function' => 'vp_font_preview',
						    ),
					    ),
					    array(
						    'type' => 'select',
						    'name' => 'h2_font_face',
						    'label' => __('H2 Font Face', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'function',
									    'value' => 'vp_get_gwf_family',
								    ),
							    ),
						    ),
						    'default' => '{{first}}'
					    ),
					    array(
						    'type' => 'radiobutton',
						    'name' => 'h2_font_style',
						    'label' => __('H2 Font Style', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'binding',
									    'field' => 'h2_font_face',
									    'value' => 'vp_get_gwf_style',
								    ),
							    ),
						    ),
						    'default' => array(
							    '{{first}}',
						    ),
					    ),
					    array(
						    'type' => 'radiobutton',
						    'name' => 'h2_font_weight',
						    'label' => __('H2 Font Weight', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'binding',
									    'field' => 'h2_font_face',
									    'value' => 'vp_get_gwf_weight',
								    ),
							    ),
						    ),
					    ),
					    array(
						    'type'    => 'slider',
						    'name'    => 'h2_font_size',
						    'label'   => __('H2 Font Size (px)', 'brushed'),
						    'min'     => '5',
						    'max'     => '32',
						    'default' => '16',
					    ),
					    array(
						    'type'    => 'slider',
						    'name'    => 'h2_line_height',
						    'label'   => __('H2 Line Height (em)', 'brushed'),
						    'min'     => '0',
						    'max'     => '3',
						    'default' => '1.5',
						    'step'    => '0.1',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'h2_color',
						    'label' => __('H2 Text Color', 'brushed'),
						    'description' => __('', 'brushed'),
						    'default' => '',
					    ),
				    ),
			    ),

			    array(
				    'type' => 'section',
				    'title' => __('H3', 'brushed'),
				    'fields' => array(
					    array(
						    'type' => 'html',
						    'name' => 'h3_font_preview',
						    'binding' => array(
							    'field'    => 'h3_font_face,h3_font_style,h3_font_weight,h3_font_size, h3_line_height',
							    'function' => 'vp_font_preview',
						    ),
					    ),
					    array(
						    'type' => 'select',
						    'name' => 'h3_font_face',
						    'label' => __('H3 Font Face', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'function',
									    'value' => 'vp_get_gwf_family',
								    ),
							    ),
						    ),
						    'default' => '{{first}}'
					    ),
					    array(
						    'type' => 'radiobutton',
						    'name' => 'h3_font_style',
						    'label' => __('H3 Font Style', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'binding',
									    'field' => 'h3_font_face',
									    'value' => 'vp_get_gwf_style',
								    ),
							    ),
						    ),
						    'default' => array(
							    '{{first}}',
						    ),
					    ),
					    array(
						    'type' => 'radiobutton',
						    'name' => 'h3_font_weight',
						    'label' => __('H3 Font Weight', 'brushed'),
						    'items' => array(
							    'data' => array(
								    array(
									    'source' => 'binding',
									    'field' => 'h3_font_face',
									    'value' => 'vp_get_gwf_weight',
								    ),
							    ),
						    ),
					    ),
					    array(
						    'type'    => 'slider',
						    'name'    => 'h3_font_size',
						    'label'   => __('H3 Font Size (px)', 'brushed'),
						    'min'     => '5',
						    'max'     => '32',
						    'default' => '16',
					    ),
					    array(
						    'type'    => 'slider',
						    'name'    => 'h3_line_height',
						    'label'   => __('H3 Line Height (em)', 'brushed'),
						    'min'     => '0',
						    'max'     => '3',
						    'default' => '1.5',
						    'step'    => '0.1',
					    ),
					    array(
						    'type' => 'color',
						    'name' => 'h3_color',
						    'label' => __('H3 Text Color', 'brushed'),
						    'description' => __('', 'brushed'),
						    'default' => '',
					    ),
				    ),
			    ),
		    ),
	    ),


	    array(
		    'title' => __('Настройки шапки', 'brushed'),
		    'name' => 'header',
		    'icon' => 'font-awesome:fa-umbrella',
		    'controls' => array(
			    array(
				    'type' => 'radiobutton',
				    'name' => 'menu_type',
				    'label' => __('Menu Position', 'brushed'),
				    'description' => __('', 'brushed'),
				    'items' => array(
					    array(
						    'value' => 1,
						    'label' => __('Static','brushed')
					    ),
					    array(
						    'value' => 0,
						    'label' => __('Sticky','brushed')
					    ),

				    ),
			    ),

			    array(
				    'type' => 'section',
				    'title' => __('Logo', 'brushed'),
				    'name' => 'section_single_field_deps',
				    'fields' => array(
					    array(
						    'type' => 'toggle',
						    'name' => 'logo',
						    'label' => __('Use Custom Logo', 'brushed'),
						    'description' => __('Use custom logo or not', 'brushed'),
					    ),
					    array(
						    'type' => 'upload',
						    'name' => 'upload_logo',
						    'label' => __('Custom Logo', 'brushed'),
						    'dependency' => array(
							    'field' => 'logo',
							    'function' => 'vp_dep_boolean',
						    ),
						    'description' => __('Upload or choose custom logo', 'brushed'),
					    ),
					    array(
						    'type' => 'textbox',
						    'name' => 'margin_left',
						    'label' => __('Margin Left for Logo', 'brushed'),
						    'description' => __('Only numbers allowed here, in px.', 'brushed'),
						    'default' => '',
						    'dependency' => array(
							    'field' => 'logo',
							    'function' => 'vp_dep_boolean',
						    ),
						    'validation' => 'numeric',
					    ),
					    array(
						    'type' => 'textbox',
						    'name' => 'margin_top',
						    'label' => __('Margin Top for Logo', 'brushed'),
						    'description' => __('Only numbers allowed here, in px.', 'brushed'),
						    'default' => '',
						    'dependency' => array(
							    'field' => 'logo',
							    'function' => 'vp_dep_boolean',
						    ),
						    'validation' => 'numeric',
					    ),
				    ),
			    ),
		    ),
	    ),

	    array(
		    'title' => __('Настройки Матчей', 'brushed'),
		    'name' => 'portfolio',
		    'icon' => 'font-awesome:fa-camera',
		    'controls' => array(
			    array(
				    'type' => 'textbox',
				    'name' => 'portfolio_h2',
				    'label' => __('H2 Text for Portfolio Section', 'brushed'),
				    'description' => __('HTML Supported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'portfolio_h3',
				    'label' => __('H3 Text for Portfolio Section', 'brushed'),
				    'description' => __('HTML Supported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'portfolio_work_type',
				    'label' => __('Text for Work Type of Portfolio Section', 'brushed'),
				    'description' => __('HTML Suppported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'portfolio_all',
				    'label' => __('All Categories in One', 'brushed'),
				    'description' => __('HTML Supported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'items_per_page',
				    'label' => __('Items Per Page', 'brushed'),
				    'description' => __('Only numbers allowed! Default is 3000.', 'brushed'),
				    'default' => '',
				    'validation' => 'numeric',
			    ),
			    array(
				    'type' => 'select',
				    'name' => 'portfolio_order',
				    'label' => __('Order By', 'brushed'),
				    'items' => array(
					    array(
						    'value' => 'post_date',
						    'label' => __('Date', 'brushed'),
					    ),
					    array(
						    'value' => 'ID',
						    'label' => __('Id', 'brushed'),
					    ),
					    array(
						    'value' => 'rand',
						    'label' => __('Random', 'brushed'),
					    ),

				    ),
				    'default' => array(
					    'post_date',
				    ),
			    ),
			    array(
				    'type' => 'select',
				    'name' => 'portfolio_type_order',
				    'label' => __('Order', 'brushed'),
				    'items' => array(
					    array(
						    'value' => 'ASC',
						    'label' => __('ASC', 'brushed'),
					    ),
					    array(
						    'value' => 'DESC',
						    'label' => __('DESC', 'brushed'),
					    ),

				    ),
				    'default' => array(
					    'DESC',
				    ),
			    ),

		    ),
	    ),

	    array(
		    'title' => __('Настройки Команды', 'brushed'),
		    'name' => 'team',
		    'icon' => 'font-awesome:fa-group',
		    'controls' => array(
			    array(
				    'type' => 'textbox',
				    'name' => 'team_h2',
				    'label' => __('H2 Text for Team Section', 'brushed'),
				    'description' => __('HTML Supported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'team_h3',
				    'label' => __('H3 Text for Team Section', 'brushed'),
				    'description' => __('HTML Supported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'team_items_per_page',
				    'label' => __('Items Per Page', 'brushed'),
				    'description' => __('Only numbers allowed! Default is 9.', 'brushed'),
				    'default' => '',
				    'validation' => 'numeric',
			    ),
			    array(
				    'type' => 'select',
				    'name' => 'team_order',
				    'label' => __('Order By', 'brushed'),
				    'items' => array(
					    array(
						    'value' => 'post_date',
						    'label' => __('Date', 'brushed'),
					    ),
					    array(
						    'value' => 'ID',
						    'label' => __('Id', 'brushed'),
					    ),
					    array(
						    'value' => 'rand',
						    'label' => __('Random', 'brushed'),
					    ),

				    ),
				    'default' => array(
					    'post_date',
				    ),
			    ),
			    array(
				    'type' => 'select',
				    'name' => 'team_type_order',
				    'label' => __('Order', 'brushed'),
				    'items' => array(
					    array(
						    'value' => 'ASC',
						    'label' => __('ASC', 'brushed'),
					    ),
					    array(
						    'value' => 'DESC',
						    'label' => __('DESC', 'brushed'),
					    ),

				    ),
				    'default' => array(
					    'DESC',
				    ),
			    ),

		    ),
	    ),

	    array(
		    'title' => __('Контактные данные', 'brushed'),
		    'name' => 'contact',
		    'icon' => 'font-awesome:fa-info',
		    'controls' => array(
			    array(
				    'type' => 'textbox',
				    'name' => 'contact_h2',
				    'label' => __('H2 Text for Contact Section', 'brushed'),
				    'description' => __('HTML Supported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'contact_h3',
				    'label' => __('H3 Text for Contact Section', 'brushed'),
				    'description' => __('HTML Supported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),
			    array(
				    'type' => 'textbox',
				    'name' => 'contact_details',
				    'label' => __('Text for Details of Contact Section', 'brushed'),
				    'description' => __('HTML Suppported', 'brushed'),
				    'default' => '',
				    'validation' => 'alpha',
			    ),

                    array(
                        'type' => 'textbox',
                        'name' => 'email',
                        'label' => __('Email on Page', 'brushed'),
                        'description' => __('', 'brushed'),
                        'default' => '',
                        'validation' => 'email',
                    ),
                array(
                    'type' => 'textbox',
                    'name' => 'telephone',
                    'label' => __('Telephone', 'brushed'),
                    'description' => __('', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),
                array(
                    'type' => 'textbox',
                    'name' => 'address',
                    'label' => __('Address', 'brushed'),
                    'description' => __('HTML Suppported', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),

                array(
                    'type' => 'textbox',
                    'name' => 'email_submit',
                    'label' => __('Set Email for Contact Form', 'brushed'),
                    'description' => __('Email where messages are sent from Contact Form', 'brushed'),
                    'default' => 'email@domain.com',
                    'validation' => 'email',
                ),
                array(
                    'type' => 'textbox',
                    'name' => 'subject',
                    'label' => __('Subject for Contact Form', 'brushed'),
                    'description' => __('Topic of messages received from this form', 'brushed'),
                    'default' => 'From my Site',
                    'validation' => 'alpha',
                ),



		    ),
	    ),


        array(
            'title' => __('Социальные иконки', 'brushed'),
            'name' => 'socialize',
            'icon' => 'font-awesome:fa-facebook',
            'controls' => array(
                array(
                    'type' => 'textbox',
                    'name' => 'twitter',
                    'label' => __('Twitter URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),
                array(
                    'type' => 'textbox',
                    'name' => 'dribbble',
                    'label' => __('Dribbble URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),
                array(
                    'type' => 'textbox',
                    'name' => 'forrst',
                    'label' => __('Forrst URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),

                array(
                    'type' => 'textbox',
                    'name' => 'behance',
                    'label' => __('Behance URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),
                array(
                    'type' => 'textbox',
                    'name' => 'facebook',
                    'label' => __('Facebook URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),

                array(
                    'type' => 'textbox',
                    'name' => 'google_plus',
                    'label' => __('Google Plus URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),

                array(
                    'type' => 'textbox',
                    'name' => 'linkedin',
                    'label' => __('LinkedIn URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),

                array(
                    'type' => 'textbox',
                    'name' => 'themeforest',
                    'label' => __('Themeforest URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),

                array(
                    'type' => 'textbox',
                    'name' => 'zerply',
                    'label' => __('Zerply URL', 'brushed'),
                    'description' => __('If not set it will not appear on the page.', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),



            ),
        ),

        array(
            'title' => __('Подвал', 'brushed'),
            'name' => 'Footer',
            'icon' => 'font-awesome:fa-level-down',
            'controls' => array(
                array(
                    'type' => 'textbox',
                    'name' => 'copyright',
                    'label' => __('Copyright Text', 'brushed'),
                    'description' => __('HTML Supported', 'brushed'),
                    'default' => '',
                    'validation' => 'alpha',
                ),
            ),
        ),




    )
);


/**
 *EOF
 */