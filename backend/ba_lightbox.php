<?php

$options = array(

	'heading_style' => array(
		'type' => 'group',
		'heading' => __( 'Heading' ),
		'options' => array(

			'text' => array(
				'type' => 'textfield',
				'heading' => 'Title',
				'default' => 'Nhập tiêu đề của bạn...',
				'auto_focus' => true,
			),

			'classname' => array(
				'type' => 'textfield',
				'heading' => 'Class',
				'default' => '',
				// 'auto_focus' => true,
			),

			'style' => array(
				'type' => 'select',
				'heading' => 'Style',
				'default' => 'normal',
				'options' => array(
					'normal' => 'Normal',
					'full' => 'Full',
					'center' => 'Center',
					'bold' => 'Left Bold',
					'bold-center' => 'Center Bold',
				)
			),

			'heading' => array(
				'type' => 'select',
				'heading' => 'Heading',
				'default' => 'h2',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				)
			),

			'heading_size' => array(
				'type' => 'slider',
				'heading' => __('Heading Size'),
				'default' => 100,
				'unit' => '%',
				'min' => 100,
				'max' => 500,
				'step' => 1,
			),

			'font_weight' => array(
				'type' => 'select',
				'heading' => 'Font Weight',
				'default' => 'bold',
				'options' => array(
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
					'bold' => 'bold',
					'bolder' => 'bolder',
					'inherit' => 'inherit',
					'initial' => 'initial',
					'lighter' => 'lighter',
					'normal' => 'normal',
					'unset' => 'unset',
				)
			),

			'font_style' => array(
				'type' => 'select',
				'heading' => 'Font Style',
				'default' => 'normal',
				'options' => array(
					'inherit' => 'inherit',
					'initial' => 'initial',
					'italic' => 'italic',
					'normal' => 'normal',
					'oblique' => 'oblique',
					'unset' => 'unset',
				)
			),

			'text_transform' => array(
				'type' => 'radio-buttons',
				'heading' => __('Text Transform'),
				'default' => 'uppercase',
				'options' => array(
					'none'  => array( 'title' => 'None'),
					'uppercase'  => array( 'title' => 'UPPERCASE'),
				),
			),

			'color' => array(
				'type' => 'colorpicker',
				'heading' => __('Color'),
				'alpha' => true,
				'format' => 'hex',
				'default' => '',
				'auto_focus' => true,
			),

			
			'background' => array(
				'type' => 'colorpicker',
				'heading' => __('Background'),
				'alpha' => true,
				'format' => 'hex',
				'default' => '',
				'auto_focus' => true,
			),

			'icon' => array(
				'type' => 'select',
				'heading' => 'Icon',
				'options' => require( UXBP_FLATSOME . '/values/icons.php' ),
			),

			'width' => array(
				'type' => 'scrubfield',
				'heading' => __('Width'),
				'default' => '',
				'min' => 0,
				'max' => 1200,
				'step' => 5,
			),

			'border_bottom' => array(
				'type' => 'radio-buttons',
				'heading' => __('Border Bottom'),
				'default' => 'true',
				'options' => array(
					'true'  => array( 'title' => 'On'),
					'false'  => array( 'title' => 'Off'),
				),
			),

			'padding' => require( UXBP_PLUGIN . '/options/op-padding.php' ),
			'margin' => require( UXBP_PLUGIN . '/options/op-margin.php' ),
		),
	),

	// Sub Title
	'subtitle_style' => array(
		'type' => 'group',
		'heading' => __( 'Sub Title' ),
		'options' => array(
			'text_sub' => array(
				'type' => 'textfield',
				'heading' => 'Title',
				'default' => 'Nhập tiêu đề của bạn...',
				// 'auto_focus' => true,
			),
			'text_sub_size' => array(
				'type' => 'slider',
				'heading' => __('Size'),
				'default' => 70,
				'unit' => '%',
				'min' => 50,
				'max' => 100,
				'step' => 1,
			),
			'text_sub_font_weight' => array(
				'type' => 'select',
				'heading' => 'Font Weight',
				'default' => 'bold',
				'options' => array(
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
					'bold' => 'bold',
					'bolder' => 'bolder',
					'inherit' => 'inherit',
					'initial' => 'initial',
					'lighter' => 'lighter',
					'normal' => 'normal',
					'unset' => 'unset',
				)
			),
		),
	),

	// Sub Menu
	'submenu_style' => array(
		'type' => 'group',
		'heading' => __( 'Sub Menu' ),
		'options' => array(

			'size' => array(
				'type' => 'slider',
				'heading' => __('Size'),
				'default' => 70,
				'unit' => '%',
				'min' => 50,
				'max' => 100,
				'step' => 1,
			),

			'cats' => array(
				'type' => 'select',
				'heading' => 'Category',
				'param_name' => 'cats',
				'config' => array(
					'multiple' => true,
					'placeholder' => 'Chọn danh mục...',
					'termSelect' => array(
						'post_type' => array('post'),
						'taxonomies' => array('category')
					),
				)
			),
		),
	),

);


add_ux_builder_shortcode( 'ba_lightbox', array(
	'name'		=> __( 'Plus Lightbox' ),
	'category'	=> __( 'UX-Builder Plus' ),
	'priority'	=> -1,
	'info'		=> '{{ text }}',
	'thumbnail' =>  UXBP_builder_thumbnail('lightbox'),
	'options'	=> $options,
));