<?php

$post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
$posttype = array( 'post' => 'Post', );
foreach ( $post_types  as $post_type ) {
   $posttype = array_merge( $posttype, array( $post_type->name => $post_type->label, ) );
}

return array(
	'type' => 'group',
	'heading' => __( 'Post Type' ),
	'options' => array(
	    'post_type' => array(
	        'type' => 'select',
	        'heading' => __( 'Select Post Type' ),
	        'default' => 'post',
	        'options' => $posttype,
	    )
	)
);