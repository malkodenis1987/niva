<?php

return array(
    'id'          => 'portfolio_metaboxes',
    'types'       => array('portfolio'),
    'title'       => __('Детали матча', 'brushed'),
    'priority'    => 'high',
    'template'    => array(
        array(
            'type' => 'select',
            'name' => 'sample_select',
            'label' => __('Type', 'brushed'),
            'default' => 1,
            'items' => array(
                array(
                    'value' => 1,
                    'label' => __('Image','brushed')
                ),
                array(
                    'value' => 2,
                    'label' => __('Video','brushed')
                )
            )
        ),
        array(
            'type' => 'upload',
            'name' => 'portfolio_upload',
            'label' => __('Изображение для матча', 'brushed'),
            'description' => __('', 'brushed'),
            'default' => '',
            'dependency'    => array(
                'field' => 'sample_select',
                'function' => 'vp_select1',
            )
        ),
        array(
            'type' => 'textbox',
            'name' => 'portfolio_textarea',
            'label' => __('Краткое описание', 'brushed'),
            'description' => __('', 'brushed'),
            'default' => '',
            'validation' => 'alpha',
            'dependency'    => array(
                'field' => 'sample_select',
                'function' => 'vp_select1',
            )
        ),
        array(
            'type' => 'textbox',
            'name' => 'portfolio_url',
            'label' => __('Your video URL', 'brushed'),
            'description' => __('Warning! To specify that this element is a video, add a \'video\' category!', 'brushed'),
            'default' => '',
            'validation' => 'alpha',
            'dependency'    => array(
                'field' => 'sample_select',
                'function' => 'vp_select2',
            )
        ),


    ),
);

/**
 * EOF
 */