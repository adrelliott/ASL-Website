<?php
if ( ! function_exists( 'wpsp_image_lightbox_register' ) ) :
add_action( 'butterbean_register', 'wpsp_image_lightbox_register', 40, 2 );
function wpsp_image_lightbox_register( $butterbean, $post_type ) 
{
	if ( function_exists( 'wpsp_get_defaults' ) ) $defaults = wpsp_get_defaults();
	
	$manager = $butterbean->get_manager( 'wp_show_posts' );
	
	$manager->register_control(
		'wpsp_image_lightbox',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_images',
			'label'       => __( 'Image lightbox','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-image-lightbox' )
		)
	);
	
	$manager->register_setting(
		'wpsp_image_lightbox',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_image_lightbox' ] ? $defaults[ 'wpsp_image_lightbox' ] : false
		)
	);
	
	$manager->register_control(
		'wpsp_image_gallery',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_images',
			'label'       => __( 'Image lightbox gallery','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-image-lightbox-gallery' )
		)
	);
	
	$manager->register_setting(
		'wpsp_image_gallery',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_image_gallery' ] ? $defaults[ 'wpsp_image_gallery' ] : false
		)
	);
}
endif;

if ( ! function_exists( 'wpsp_image_lightbox' ) ) :
add_filter( 'wpsp_image_href','wpsp_image_lightbox' );
function wpsp_image_lightbox()
{
	global $wpsp_id;
	$image_lightbox = wpsp_get_setting( $wpsp_id, 'wpsp_image_lightbox' );
	
	if ( $image_lightbox && function_exists( 'get_the_post_thumbnail_url' ) ) {
		return esc_url( get_the_post_thumbnail_url() );
	}
	
	return esc_url( get_the_permalink() );
}
endif;

if ( ! function_exists( 'wpsp_image_lightbox_data' ) ) :
add_filter( 'wpsp_image_data','wpsp_image_lightbox_data' );
function wpsp_image_lightbox_data()
{
	global $wpsp_id;
	$image_lightbox = wpsp_get_setting( $wpsp_id, 'wpsp_image_lightbox' );
	$image_gallery = wpsp_get_setting( $wpsp_id, 'wpsp_image_gallery' );
	
	if ( $image_lightbox && ! $image_gallery ) {
		return 'data-featherlight="image"';
	}
	
	return '';
}
endif;

if ( ! function_exists( 'wpsp_lightbox_scripts' ) ) :
add_action( 'wp_enqueue_scripts','wpsp_lightbox_scripts' );
function wpsp_lightbox_scripts()
{
	wp_register_script( 'wpsp-featherlight', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'featherlight/featherlight.js', array( 'jquery' ) );
	wp_register_script( 'wpsp-featherlight-gallery', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'featherlight/featherlight.gallery.js', array( 'wpsp-featherlight' ) );
	wp_add_inline_script( 'wpsp-featherlight-gallery', 'jQuery(function(a){a(".wp-show-posts-image a").featherlightGallery({previousIcon:"",nextIcon:""})}),jQuery("body").on("wpsp_items_loaded",function(){jQuery(function(a){jQuery(".wp-show-posts-image a").featherlightGallery({previousIcon:"",nextIcon:""})})});' );
	wp_register_style( 'wpsp-featherlight', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'featherlight/featherlight.css', array() );
	wp_register_style( 'wpsp-featherlight-gallery', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'featherlight/featherlight.gallery.css', array( 'wpsp-featherlight' ) );
}
endif;