<?php
// [title]
function fr_title_shortcode( $atts, $content = null ){
	extract(
		shortcode_atts(
			array(

				// My custom
				'heading'		=> 'h2',
				'heading_size'	=> '100',
				'background'	=> '',
				'cats'			=> false,
				'padding'		=> '5px',
				'margin'		=> '0px',
				'border_bottom'	=> '',
				'font_weight'	=> '',
				'font_style'	=> '',
				'text_transform' => 'uppercase',
				'classname'		=> '',

				// Sub title
				'text_sub'		=> '',
				'text_sub_size'	=> '100',
				'text_sub_font_weight'	=> '',

				// default
				'_id' => 'title-'.rand(),
				'text' => 'Nhập tiêu đề của bạn...',
				'color' => '',
				'sub_text' => '',
				'style' => 'normal',
				'size' => '70',
				'link' => '',
				'link_text' => '',
				'target' => '',
				'margin_top' => '0px',
				'margin_bottom' => '0px',
				'letter_case' => '',
				'width' => '',
				'icon' => '',
				'tag'

			),
			$atts
		)
	);

	if(!$text && !$link_text) return;

	$link_output = '';
	if($link) $link_output = '<a href="'.$link.'" target="'.$target.'">'.$link_text.get_flatsome_icon('icon-angle-right').'</a>';

	$small_text = '';
	if($sub_text) $small_text = '<small class="sub-title">'.$atts['sub_text'].'</small>';

	if($icon) $icon = get_flatsome_icon($icon);

	// fix old
	if($style == 'bold_center') $style = 'bold-center';

	$css_title = $css_title_sub = $css_heading = $css_ul = $css_b = array();

	$css_args = array(
		array( 'attribute' => 'margin-top', 'value' => $margin_top ),
		array( 'attribute' => 'margin-bottom', 'value' => $margin_bottom ),
		array( 'attribute' => 'margin', 'value' => $margin ),
	);

	$css_heading = array(
		array( 'attribute' => 'font-size', 'value' => $heading_size.'%' ),
	);

	if(!empty($width)) {
		$css_args[] = array( 'attribute' => 'max-width', 'value' => $width );
	}

	if(!empty($size)){
		$css_ul[] = array( 'attribute' => 'font-size', 'value' => $size, 'unit' => '%' );
	}
	if(!empty($background)){
		$css_heading[] = array('attribute' => 'border-bottom-color', 'value' => $background );
		$css_title[] = array( 'attribute' => 'background', 'value' => $background );
	}
	if(!empty($color)){
		$css_title[] = array( 'attribute' => 'color', 'value' => $color );
	}
	if(!empty($padding)){
		$css_title[] = array( 'attribute' => 'padding', 'value' => $padding );
	}
	if(!empty($border_bottom)) {
		$css_heading[] = array( 'attribute' => 'border-bottom', 'value' => '0px' );
		$css_title[] = array( 'attribute' => 'border-bottom', 'value' => '0px');
		$css_b[] = array( 'attribute' => 'height', 'value' => '0px');
	}
	if (!empty($font_weight)) {
		$css_title[] = array( 'attribute' => 'font-weight', 'value' => $font_weight );
	}
	if (!empty($font_style)) {
		$css_title[] = array( 'attribute' => 'font-style', 'value' => $font_style );
	}
	if (!empty($text_transform)) {
		$css_title[] = array( 'attribute' => 'text-transform', 'value' => $text_transform );
	}

	if($style == 'full') {
		$css_title[] = array( 'attribute' => 'width', 'value' => '100%' );
		$css_title[] = array( 'attribute' => 'margin', 'value' => '0px' );
		$css_heading[] = array( 'attribute' => 'margin', 'value' => '0px' );
	}

	if(!empty($text_sub)){
		$css_title_sub = $css_title;
		$css_title_sub[] = array( 'attribute' => 'font-weight', 'value' => $text_sub_font_weight );
		$css_title_sub[] = array( 'attribute' => 'font-size', 'value' => $text_sub_size.'%' );
		$sub_text_html = '<span '.get_shortcode_inline_css($css_title_sub).'>'.$text_sub.'</span>';
	}

	// My Custom
	if ($cats) {
		$cats = explode( ',', $cats );
		$cats = array_map( 'trim', $cats );
		$link_output .= '<ul class="nav category">';
		foreach ($cats as $key => $value) {
			$cat_ID = (int) $value;
			$term = get_term( $cat_ID, 'category' );
			$link_output .= '<li><a href="'.esc_url(get_category_link($term->term_id)).'" '.get_shortcode_inline_css($css_ul).'>'.$term->name.'</a></li>';
		}
		$link_output .= '</ul>';
	}

	return '<div class="uxbp-title container section-title-container '.$classname.'" '.get_shortcode_inline_css($css_args).'>
		<'.$heading.' class="section-title section-title-'.$style.' '.$heading_size.'" '.get_shortcode_inline_css($css_heading).'>
			<b '.get_shortcode_inline_css($css_b).'></b>
			<span class="section-title-main" '.get_shortcode_inline_css($css_title).'>'.$icon.$text.$small_text.'</span>
			'.$sub_text_html.'
			<b '.get_shortcode_inline_css($css_b).'></b>
			'.$link_output.'
			</'.$heading.'>
		</div><!-- .section-title()-->';

}
add_shortcode('ba_title', 'fr_title_shortcode');