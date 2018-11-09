<?php

$options =  array(
	'post_type_options' => require( UXBP_PLUGIN.'/options/op-posttype.php' ),
	'style_options' => array(
		'type' => 'group',
		'heading' => __( 'Style' ),

		'options' => array(
			'style' => array(
				'type' => 'select',
				'heading' => __( 'Style' ),
				'default' => 'medium',
				'options' => require( UXBP_PLUGIN . '/options/op-layouts.php' )
			),

			'style_order' => array(
				'type' => 'radio-buttons',
				'heading' => __( 'Image' ),
				'conditions' => 'style === "vertical"',
				'default' => 'left',
				'options' => array(
					'left'   => array( 'title' => 'LEFT'),
					'right' => array( 'title' => 'RIGHT'),
				)
			),

			'style_title' => array(
				'type' => 'textfield',
				'heading' => __( 'Title' ),
				'conditions' => 'style === "featured"',
				'default' => 'Featured',
			),

			'style_lactroi' => array(
				'type' => 'radio-buttons',
				'heading' => 'Lạc Trôi',
				'default' => 'off',
				'options' => array(
					'off'   => array( 'title' => 'OFF'),
					'on' => array( 'title' => 'ON'),
				)
			),
		),
	),

	'layout_options' => require( UXBP_FLATSOME . '/commons/repeater-options.php' ),
	'layout_options_slider' => require( UXBP_FLATSOME . '/commons/repeater-slider.php' ),
	'post_options' => require( UXBP_FLATSOME . '/commons/repeater-posts.php' ),
	'post_title_options' => array(
		'type' => 'group',
		'heading' => __( 'Title' ),

		'options' => array(
			'title_size' => array(
				'type' => 'select',
				'heading' => 'Title Size',
				'default' => '',
				'options' => require( UXBP_FLATSOME . '/values/sizes.php' )
			),

			'title_length' => array(
				'type' => 'slider',
				'heading' => 'Title Length',
				'default' => 10,
				'max' => 110,
				'min' => 10,
			),

			'title_style' => array(
				'type' => 'radio-buttons',
				'heading' => 'Title Style',
				'default' => '',
				'options' => array(
					''   => array( 'title' => 'Abc'),
					'uppercase' => array( 'title' => 'ABC'),
				)
			),
		)
	),

	'read_more_button' => array(

		'type' => 'group',
		'heading' => __( 'Read More' ),

		'options' => array(
			'readmore' => array(
				'type' => 'textfield',
				'heading' => 'Text',
				'default' => '',
			),

			'readmore_color' => array(
				'type' => 'select',
				'heading' => 'Color',
				'conditions' => 'readmore',
				'default' => 'primary',
				'options' => array(
					'' => 'Blank',
					'primary' => 'Primary',
					'secondary' => 'Secondary',
					'alert' => 'Alert',
					'success' => 'Success',
					'white' => 'White',
				)
			),

			'readmore_style' => array(
				'type' => 'select',
				'heading' => 'Style',
				'conditions' => 'readmore',
				'default' => 'outline',
				'options' => array(
					'' => 'Default',
					'outline' => 'Outline',
					'link' => 'Simple',
					'underline' => 'Underline',
					'shade' => 'Shade',
					'bevel' => 'Bevel',
					'gloss' => 'Gloss',
				)
			),

			'readmore_size' => array(
				'type' => 'select',
				'conditions' => 'readmore',
				'heading' => 'Size',
				'default' => '',
				'options' => require( UXBP_FLATSOME . '/values/sizes.php' ),
			),
		)
	),

	'post_meta_options' => array(
		'type' => 'group',
		'heading' => __( 'Meta' ),
		
		'options' => array(

			'excerpt' => array(
				'type' => 'select',
				'heading' => 'Excerpt',
				'default' => 'visible',
				'options' => array(
					'visible' => 'Visible',
					'false' => 'Hidden',
				)
			),

			'excerpt_length' => array(
				'type' => 'slider',
				'heading' => 'Excerpt Length',
				'default' => 10,
				'max' => 500,
				'min' => 10,
			),

			'show_category' => array(
				'type' => 'select',
				'heading' => 'Category',
				'default' => 'visible',
				'options' => array(
					'visible' => 'Visible',
					'false' => 'Hidden',
				)
			),

			'show_date' => array(
				'type' => 'select',
				'heading' => 'Date',
				'default' => 'visible',
				'options' => array(
					'visible' => 'Visible',
					'false' => 'Hidden',
				)
			),

			'show_image' => array(
				'type' => 'select',
				'heading' => 'Image',
				'default' => 'visible',
				'options' => array(
					'visible' => 'Visible',
					'false' => 'Hidden',
				)
			),
		),
	),

	'image_options' => array(
        'type' => 'group',
        'heading' => __( 'Image' ),
        'conditions' => 'show_image === "visible"',
        'options' => array(

            'image_height' => array(
              'type' => 'scrubfield',
              'heading' => __('Height'),
              'conditions' => 'type !== "grid"',
              'default' => '',
              'placeholder' => __('Auto'),
              'min' => 0,
              'max' => 1000,
              'step' => 1,
              'helpers' => require( UXBP_FLATSOME . '/helpers/image-heights.php' ),
            	'on_change' => array(
                    'selector' => '.box-image-inner',
                    'style' => 'padding-top: {{ value }}'
                )
            ),

            'image_width' => array(
                'type' => 'slider',
                'heading' => __( 'Width' ),
                'unit' => '%',
                'default' => 100,
                'max' => 100,
                'min' => 0,
                'on_change' => array(
                    'selector' => '.box-image',
                    'style' => 'width: {{ value }}%'
                )
            ),

            'image_radius' => array(
                'type' => 'slider',
                'heading' => __( 'Radius' ),
                'unit' => '%',
                'default' => 0,
                'max' => 100,
                'min' => 0,
                'on_change' => array(
                    'selector' => '.box-image-inner',
                    'style' => 'border-radius: {{ value }}%'
                )
            ),

            'image_size' => array(
                'type' => 'select',
                'heading' => __( 'Size' ),
                'default' => '',
                'options' => array(
                    '' => 'Default',
                    'large' => 'Large',
                    'medium' => 'Medium',
                    'thumbnail' => 'Thumbnail',
                    'original' => 'Original',
                )
            ),

            'image_overlay' => array(
                'type' => 'colorpicker',
                'heading' => __( 'Overlay' ),
                'default' => '',
                'alpha' => true,
                'format' => 'rgb',
                'position' => 'bottom right',
                'on_change' => array(
                    'selector' => '.overlay',
                    'style' => 'background-color: {{ value }}'
                )
            ),

            'image_hover' => array(
                'type' => 'select',
                'heading' => __( 'Hover' ),
                'default' => '',
                'options' => require( UXBP_FLATSOME . '/values/image-hover.php' ),
                'on_change' => array(
                    'selector' => '.image-cover',
                    'class' => 'image-{{ value }}'
                )
            ),
            'image_hover_alt' => array(
                'type' => 'select',
                'heading' => __( 'Hover Alt' ),
                'default' => '',
                'conditions' => 'image_hover',
                'options' => require( UXBP_FLATSOME . '/values/image-hover.php' ),
                'on_change' => array(
                    'selector' => '.image-cover',
                    'class' => 'image-{{ value }}'
                )
            ),
        ),
    ),
);

#$box_styles = require( UXBP_FLATSOME . '/commons/box-styles.php' );
#$options = array_merge($options, $box_styles);

add_ux_builder_shortcode( 'be_medium_post', array(
	'name'		=> __( 'Plus Posts' ),
	'category'	=> __( 'UX-Builder Plus' ),
	'priority'	=> -1,
	'info'		=> '{{ title }}',
	'thumbnail'	=> UXBP_builder_thumbnail(),
	'scripts' => array(
		'flatsome-masonry-js' => get_template_directory_uri() .'/assets/libs/packery.pkgd.min.js',
	),
	'options'	=> $options,
));