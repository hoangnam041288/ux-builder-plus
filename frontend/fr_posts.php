<?php

// Flatsome Products
function fr_medium_post($atts, $content = null, $tag) {
	extract(shortcode_atts(array(

		// My options
		'post_type'		=> 'post',
		'show_image'	=> 'true',
		'style'			=> 'medium',
		'title_length'	=> '100',
		'style_order'	=> 'left',
		'style_lactroi'	=> 'off',
		'style_title'	=> 'Featured',

		// default
		"_id"		=> 'row-'.rand(),
		// 'style'		=> 'default',
		'class' => '',

		// Layout
		"columns" => '4',
		"columns__sm" => '1',
		"columns__md" => '',
		'col_spacing' => '',
		"type" => 'slider', // slider, row, masonery, grid
		'width' => '',
		'grid' => '1',
		'grid_height' => '600px',
		'grid_height__md' => '500px',
		'grid_height__sm' => '400px',
		'slider_nav_style' => 'reveal',
		'slider_nav_position' => '',
		'slider_nav_color' => '',
		'slider_bullets' => 'false',
		'slider_arrows' => 'true',
		'auto_slide' => 'false',
		'infinitive' => 'true',
		'depth' => '',
		'depth_hover' => '',

		// posts
		'posts' => '12',
		'ids' => false, // Custom IDs
		'cat' => '',
		'excerpt' => 'visible',
		'excerpt_length' => 15,
		'offset' => '',

		// Read more
		'readmore' => '',
		'readmore_color' => '',
		'readmore_style' => 'outline',
		'readmore_size' => 'small',

		// div meta
		'post_icon' => 'true',
		'comments' => 'true',
		'show_date' => 'true', // badge, text
		'badge_style' => '',
		'show_category' => 'true',

		//Title
		'title_size' => 'large',
		'title_style' => '',

		// Box styles
		'animate' => '',
		'text_pos' => 'bottom',
		'text_padding' => '',
		'text_bg' => '',
		'text_size' => '',
		'text_color' => '',
		'text_hover' => '',
		'text_align' => 'left',
		'image_size' => 'medium',
		'image_width' => '',
		'image_radius' => '',
		'image_height' => '56%',
		'image_hover' => '',
		'image_hover_alt' => '',
		'image_overlay' => '',
		'image_depth' => '',
		'image_depth_hover' => '',

	), $atts));
	ob_start();

	$classes_box = array();
	$classes_image = array();
	$classes_text = array();

	// Fix overlay color
	if($style == 'text-overlay'){ $image_hover = 'zoom'; }
	$style = str_replace('text-', '', $style);

	// Fix grids
	if($type == 'grid'){
		if(!$text_pos) $text_pos = 'center';
		$columns = 0;
		$current_grid = 0;
		$grid = flatsome_get_grid($grid);
		$grid_total = count($grid);
		echo flatsome_get_grid_height($grid_height, $_id);
	}

	// Fix overlay
	if($style == 'overlay' && !$image_overlay) $image_overlay = 'rgba(0,0,0,.25)';

	// Set box style
	$style = ($style === 'vertical' && wp_is_mobile()) ? 'medium' : $style ;
	if($style) $classes_box[] = 'box-'.$style;
	if($style == 'overlay') $classes_box[] = 'dark';
	if($style == 'shade') $classes_box[] = 'dark';
	if($style == 'badge') $classes_box[] = 'hover-dark';
	if($text_pos) $classes_box[] = 'box-text-'.$text_pos;

	if($image_hover)  $classes_image[] = 'image-'.$image_hover;
	if($image_hover_alt)  $classes_image[] = 'image-'.$image_hover_alt;
	if($image_height) $classes_image[] = 'image-cover';

	// Text classes
	if($text_hover) $classes_text[] = 'show-on-hover hover-'.$text_hover;
	if($text_align) $classes_text[] = 'text-'.$text_align;
	if($text_size) $classes_text[] = 'is-'.$text_size;
	if($text_color == 'dark') $classes_text[] = 'dark';

	$image_width = (wp_is_mobile()) ? '100' : $image_width ;
	$css_args_img = array(
		array( 'attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%' ),
		array( 'attribute' => 'width', 'value' => $image_width, 'unit' => '%' ),
	);

	$image_height = (wp_is_mobile()) ? '50%' : $image_height ;
	$css_image_height = array(
		array( 'attribute' => 'padding-top', 'value' => $image_height),
	);

	$css_args = array(
		array( 'attribute' => 'background-color', 'value' => $text_bg ),
		array( 'attribute' => 'padding', 'value' => $text_padding ),
	);

	// Add Animations
	if($animate) {$animate = 'data-animate="'.$animate.'"';}

	$classes_text = implode(' ', $classes_text);
	$classes_image = implode(' ', $classes_image);
	$classes_box = implode(' ', $classes_box);

	// Repeater styles
	$repeater['id'] = $_id;
	$repeater['tag'] = $tag;
	$repeater['type'] = $type;
	$repeater['class'] = $class;
	$repeater['style'] = $style;
	$repeater['slider_style'] = $slider_nav_style;
	$repeater['slider_nav_position'] = $slider_nav_position;
	$repeater['slider_nav_color'] = $slider_nav_color;
	$repeater['slider_bullets'] = $slider_bullets;
	$repeater['auto_slide'] = $auto_slide;
	$repeater['row_spacing'] = $col_spacing;
	$repeater['row_width'] = $width;
	$repeater['columns'] = $columns;
	$repeater['columns__md'] = (wp_is_mobile() && !$columns__md) ? '2' : $columns__md;
	$repeater['columns__sm'] = $columns__sm;
	$repeater['depth'] = $depth;
	$repeater['depth_hover'] = $depth_hover;

	$args = array(
		'post_status' => 'publish',
		'post_type' => $post_type,
		'offset' => $offset,
		'cat' => $cat,
		'posts_per_page' => $posts,
		'ignore_sticky_posts' => true
	);

	// My Custom Medium
	if ($style === 'popular') {
		$popular = array(
			'meta_key'	=> 'namdh_post_views_count',
			'orderby'	=> 'meta_value_num',
			'order'		=> 'DESC',
		);
		$args = array_merge($args, $popular);
	}

	// If custom ids
	if ( !empty( $ids ) ) {
		$ids = explode( ',', $ids );
		$ids = array_map( 'trim', $ids );
		$posts = 9999;
		$offset = 0;

		$args = array(
			'post__in' => $ids,
			'numberposts' => -1,
			'orderby' => 'post__in',
			'posts_per_page' => 9999,
			'ignore_sticky_posts' => true,
		);
	}

	// Nếu là Portfolio
	if ($post_type == 'featured_item') {
		$class_portfolio = array('post-portfolio');
	}

	if ($style_lactroi=='on') {
		$args['offset'] = array(get_the_id());
	}

	$recentPosts = new WP_Query( $args );

	// Disable slider if less than selected products pr row.
	if ( $recentPosts->post_count < ($repeater['columns']+1) ) {
		if($repeater['type'] == 'slider') $repeater['type'] = 'row';
	}

	if ($style_order==='right') {
		$style_order_img 	= 'style_order-2';
		$style_order_text 	= 'style_order-1';
	}

	// Get Repater Start
	$style_lactroi = (wp_is_mobile()) ? 'off' : $style_lactroi;
	echo '<div class="medium-post lactroi-'.$style_lactroi.' '.$post_type.'">';
	echo get_flatsome_repeater_start($repeater);
	if ($recentPosts->have_posts()) {
		while ( $recentPosts->have_posts() ) : $recentPosts->the_post();

			$col_class = array('post-item');

			if(get_post_format() == 'video') $col_class[] = 'has-post-icon';

			if($type == 'grid'){
				if($grid_total > $current_grid) $current_grid++;

				$current = $current_grid-1;
				$col_class[] = 'grid-col';

				if($grid[$current]['height']) $col_class[] = 'grid-col-'.$grid[$current]['height'];
				if($grid[$current]['span']) $col_class[] = 'large-'.$grid[$current]['span'];
				if($grid[$current]['md']) $col_class[] = 'medium-'.$grid[$current]['md'];
				// Set image size
				if($grid[$current]['size']) $image_size = $grid[$current]['size'];
				// Hide excerpt for small sizes
				if($grid[$current]['size'] == 'thumbnail') $excerpt = 'false';
			}
			?>
			<div class="col col-medium <?php echo implode(' ', $col_class); ?>" <?php echo $animate;?>>
				<div class="col-inner">
					<a href="<?php the_permalink() ?>" class="plain">
						<div class="uxbp-post box <?php echo $classes_box; ?> box-blog-post has-hover">
							<?php if(has_post_thumbnail() && $show_image !== 'false') { ?>
								<div class="box-image <?php if ($style_order==='right') { echo ' '.$style_order_img; } ?>" <?php echo get_shortcode_inline_css($css_args_img); ?>>
									<div class="<?php echo $classes_image; ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
										<?php the_post_thumbnail($image_size); ?>
										<?php if($image_overlay){ ?><div class="overlay" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
									</div>
									<?php if($post_icon && get_post_format()) { ?>
									<div class="absolute no-click x50 y50 md-x50 md-y50 lg-x50 lg-y50">
										<div class="overlay-icon">
											<i class="icon-play"></i>
										</div>
									</div>
									<?php } ?>
								</div><!-- .box-image -->
							<?php } ?>
							<div class="box-text <?php echo $classes_text; if ($style_order==='right') { echo ' '.$style_order_text; }?>" <?php echo get_shortcode_inline_css($css_args); ?><?php if($show_image === 'false') { echo ' style="padding:0;"'; } ?>>
								<?php if($style==='featured') { ?>
									<p class="featured-divider"><span><?php echo$style_title; ?></span></p>
								<?php } ?>
								<div class="box-text-inner blog-post-inner">

									<?php do_action('flatsome_blog_post_before'); ?>
									<?php if ( ($show_category !== 'false' || $show_date !== 'false') && $post_type == 'post') { ?>
									<p class="cat-label <?php if($show_category == 'label') echo 'tag-label'; ?> op-8"><?php
										// if ($show_category !== 'false') {
										// 	echo '<span class="cat"><i class="fa fa-bookmark-o" aria-hidden="true"></i> '.UXBP_primary_cat($post_type).'</span>';
										// }
										if ($show_category !== 'false') { echo cf_get_span('bookmark-o', UXBP_primary_cat($post_type)); }
										// if ($show_date !== 'false') {
										// 	echo '<span class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> '.get_the_date().'</span>';
										// }
									?></p>
									<?php } ?>
									<h5 class="post-title is-<?php echo $title_size.' '.$title_style.' length-'.$title_length;?>"><?php 
										echo UXBP_key_more(get_the_title(), $title_length); 
									?></h5>

									<?php if($excerpt !== 'false') { ?>
									<p class="from_the_blog_excerpt <?php if($excerpt !== 'visible'){ echo 'show-on-hover hover-'.$excerpt; } echo ' length-'.$excerpt_length; ?> op-8"><?php
										echo UXBP_string_more(get_the_excerpt(), $excerpt_length);
									?></p>
									<?php } ?>

									<?php if ($post_type == 'featured_item') { ?>
									<p class="cat-label <?php if($show_category == 'label') echo 'tag-label'; ?> op-8"><?php
										if (!empty(get_field('cf_da_chudautu'))) { echo cf_get_span( 'university', UXBP_string_more( get_field('cf_da_chudautu'), 7) ); }
										echo cf_get_span('building-o', UXBP_primary_cat($post_type));
										if (!empty(get_field('cf_da_dientich'))) { echo cf_get_span('crop', get_field('cf_da_dientich').'ha'); }
										if (!empty(get_field('cf_da_vitri'))) { echo cf_get_span('map-marker', UXBP_string_more( get_field('cf_da_vitri'), 7) ); }
									?>
									<?php } ?>

									<?php do_action('flatsome_blog_post_after'); ?>

								</div><!-- .box-text-inner -->
							</div><!-- .box-text -->
						</div><!-- .box -->
					</a><!-- .link -->
				</div><!-- .col-inner -->
			</div><!-- .col -->
		<?php endwhile;
	} else {
		echo "$post_type: Chưa có bài viết nào!";
		#echo "<pre>"; print_r($args); echo "</pre>";
	}
	wp_reset_query();

	// Get Repater End
	echo get_flatsome_repeater_end($atts);
	echo '</div>';

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('be_medium_post', 'fr_medium_post');