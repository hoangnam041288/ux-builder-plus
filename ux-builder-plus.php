<?php
/**
 * Plugin Name: UX Builder Plus
 * Plugin URI: #
 * Description: Plugin thêm các lựa chọn mới cho UX Builder cơ bản của Flatsome
 * Version: 1.0.0
 * Author: Nam Coder Net
 * Author URI: https://namcoder.net
 * License: GPLv2 or later
 */

// UXBP_FLATSOME: Dùng để gọi /inc/ của themes gốc
define( 'UXBP_FLATSOME', get_template_directory().'/inc/builder/shortcodes' );
define( 'UXBP_PLUGIN', dirname(__FILE__) );
// UXBP_BACKEND: Gọi tất cả các file có trong thư mục /backend/
define( 'UXBP_BACKEND', UXBP_PLUGIN.'/backend' );
// UXBP_FRONTEND: Gọi tất cả các file có trong thư mục /frontend/
define( 'UXBP_FRONTEND', UXBP_PLUGIN.'/frontend' );

// Gọi file B
function UXBP_builder_element(){
	foreach (glob(UXBP_BACKEND."/ba_*.php") as $file) { require_once $file; }
}
add_filter('ux_builder_setup', 'UXBP_builder_element');
foreach (glob(UXBP_FRONTEND."/fr_*.php") as $file) { require_once $file; }

// GỌI ICON CỦA CÁC CUSTOM
function UXBP_builder_thumbnail($name='thumbnail'){
	return plugins_url('/assets/img/ux_'.$name.'.png', __FILE__ );
}

// GỌI CSS VÀ JS
function UXBP_builder_styles_script() {
	wp_register_style( 'UXBP_builder_styles', plugins_url('/ux-builder-plus/assets/css/style.css'), __FILE__ );
	wp_enqueue_style( 'UXBP_builder_styles' );
	wp_register_style( 'UXBP_builder_portfolio', plugins_url('/ux-builder-plus/assets/css/portfolio.css'), __FILE__ );
	wp_enqueue_style( 'UXBP_builder_portfolio' );
	wp_enqueue_script('jquery');
    wp_register_script( 'UXBP_builder_script', plugins_url('/ux-builder-plus/assets/js/script.js'), array('jquery'));
    wp_enqueue_script( 'UXBP_builder_script');
}
add_filter( 'wp_enqueue_scripts', 'UXBP_builder_styles_script' );

// --FUNCTION AUTO-------------------------------------------------------------------------------
// ĐỔI [] THÀNH …
function UXBP_excerpt_more( $more ) { return '…'; }
add_filter( 'excerpt_more', 'UXBP_excerpt_more' );

// Đếm số lần xem post
function UXBP_post_views_count($postID) {
    $count_key = 'UXBP_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function UXBP_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    UXBP_post_views_count($post_id);
}
add_action( 'wp_head', 'UXBP_track_post_views');

// --FUNCTION CALL-------------------------------------------------------------------------------
// Độ dài chuỗi: Từ
function UXBP_string_more($string, $limit) {
	$words = explode( ' ', $string, ($limit+1));
	if(count($words) > $limit) {
		array_pop($words);
		return implode(' ', $words).'...';
	} else {
		return implode(' ', $words);
	}
}
// Độ dài chuỗi: Ký tự
function UXBP_key_more($string, $limit){
	$title = html_entity_decode($string, ENT_QUOTES, "UTF-8");
	$strlen = strlen($title);
	$limit = (wp_is_mobile() && $strlen <= 110) ? 110 : $limit;
	if( $strlen > $limit ) {
		$title = mb_substr($title, 0, $limit).'…';
	}
	return '<i class="hidden note-'.$limit.'_'.$strlen.'"></i>'.$title;
}

// UXBP_get_style_post_in_cat
function UXBP_array_slice($ids_cut, $finish)
{
	$ids_get = array_slice($ids_cut, 0, $finish);
	$ids_cut = array_slice($ids_cut, $finish, count($ids_cut));
	return array(
		'ids_get'	=> $ids_get,
		'ids_cut'	=> $ids_cut,
	);
}

// Kiểm tra có phải là trong blog_page không?
function UXBP_is_blog_page() {

    global $post;
    //Post type must be 'post'.
    $post_type = get_post_type($post);
    //Check all blog-related conditional tags, as well as the current post type, 
    //to determine if we're viewing a blog page.
    return (
        ( is_home() || is_archive() || is_single() )
        && ($post_type == 'post')
    ) ? true : false ;

}

// Lấy Cat chính của post dự vào plugin YOAST SEO
function UXBP_primary_cat($post_type = 'category')
{
	// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
	if ($post_type == 'post') {
		$term_name = 'category';
		$category = get_the_category();
	} else {
		$term_name = 'featured_item_category';
		$category = get_the_terms( get_the_id(), $term_name );
	}
	// $category = get_the_category();
	
	$useCatLink = true;
	// If post has a category assigned.
	if ($category){
		$category_display = '';
		$category_link = '';
		if ( class_exists('WPSEO_Primary_Term') ){
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( $term_name , get_the_id() );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if (is_wp_error($term)) { 
				// Default to first category (not Yoast) if an error is returned
				$category_display = $category[0]->name;
				$category_link = get_category_link( $category[0]->term_id );
			} else { 
				// Yoast Primary category
				$category_display = $term->name;
				$category_link = get_category_link( $term->term_id );
			}
		} 
		else {
			// Default, display the first category in WP's list of assigned categories
			$category_display = $category[0]->name;
			$category_link = get_category_link( $category[0]->term_id );
		}
		// Display category
		if ( !empty($category_display) ){
			return htmlspecialchars($category_display);
		}
		
	}
}

function cf_get_span($fa_icon='', $text='')
{
	return '<span class="featured_fa"><i class="fa fa-'.$fa_icon.'" aria-hidden="true"></i>'.$text.'</span>';
}