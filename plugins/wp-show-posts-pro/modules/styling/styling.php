<?php
// Admin sections
require trailingslashit( dirname( __FILE__ ) ) . 'admin-sections.php';

add_action( 'wpsp_before_wrapper','wpsp_styling' );
function wpsp_styling()
{
	global $wpsp_id;
	$background	= wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_background' ) );
	$background_hover = wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_background_hover' ) );
	$title_color = wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_title_color' ) );
	$title_color_hover = wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_title_color_hover' ) );
	$meta_color	= wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_meta_color' ) );
	$meta_color_hover = wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_meta_color_hover' ) );
	$text = wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_text' ) );
	$link = wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_link' ) );
	$link_hover	= wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_link_hover' ) );
	$border	= wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_border' ) );
	$border_hover = wpsp_sanitize_hex_color( wpsp_get_setting( $wpsp_id, 'wpsp_border_hover' ) );
	$columns_gutter = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_columns_gutter' ) );
	$padding = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_padding' ) );
	
	$read_more_text = wp_kses_post( wpsp_get_setting( $wpsp_id, 'wpsp_read_more_text' ) );
	$read_more_background_color = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_read_more_background_color' ) );
	$read_more_background_color_hover = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_read_more_background_color_hover' ) );
	$read_more_text_color = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_read_more_text_color' ) );
	$read_more_text_color_hover = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_read_more_text_color_hover' ) );
	$read_more_border_color = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_read_more_border_color' ) );
	$read_more_border_color_hover = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_read_more_border_color_hover' ) );
	
	$twitter_color = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_twitter_color' ) );
	$twitter_color_hover = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_twitter_color_hover' ) );
	$facebook_color = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_facebook_color' ) );
	$facebook_color_hover = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_facebook_color_hover' ) );
	$googleplus_color = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_googleplus_color' ) );
	$googleplus_color_hover = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_googleplus_color_hover' ) );
	$pinterest_color = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_pinterest_color' ) );
	$pinterest_color_hover = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_pinterest_color_hover' ) );
	$love_color = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_love_color' ) );
	$love_color_hover = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_love_color_hover' ) );
	
	$social_sharing  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_social_sharing' ), FILTER_VALIDATE_BOOLEAN );
	$twitter		  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_twitter' ), FILTER_VALIDATE_BOOLEAN );
	$facebook		  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_facebook' ), FILTER_VALIDATE_BOOLEAN );
	$googleplus		  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_googleplus' ), FILTER_VALIDATE_BOOLEAN );
	$pinterest		  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_pinterest' ), FILTER_VALIDATE_BOOLEAN );
	$love			  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_love' ), FILTER_VALIDATE_BOOLEAN );
	
	// Start the magic
	$visual_css = array (
	
		'.wp-show-posts-columns#wpsp-' . $wpsp_id => array(
			'margin-left' => ( '' !== $columns_gutter ) ? '-' . $columns_gutter : null
		),
		
		'.wp-show-posts-columns#wpsp-' . $wpsp_id . ' .wp-show-posts-inner' => array(
			'margin' => ( '' !== $columns_gutter ) ? '0 0 ' . $columns_gutter . ' ' . $columns_gutter : null,
		),
	
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-inner'  => array(
			'background-color' => $background,
			'color' => $text,
			'border-color' => $border,
			'padding' => $padding
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-inner:hover' => array(
			'background-color' => $background_hover,
			'border-color' => $border_hover
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-entry-title a' => array(
			'color' => $title_color
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-entry-title a:hover' => array(
			'color' => $title_color_hover
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-entry-meta' => array(
			'color' => $text
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-meta a' => array(
			'color' => $meta_color
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-meta a:hover' => array(
			'color' => $meta_color_hover
		),
		
		'#wpsp-' . $wpsp_id . ' .wpsp-social'  => array(
			'color' => $meta_color
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-entry-summary a, .wp-show-posts-entry-content a' => array(
			'color' => $link
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-entry-summary a:hover, .wp-show-posts-entry-content a:hover' => array(
			'color' => $link_hover
		),
	
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-read-more,
		#wpsp-' . $wpsp_id . ' .wp-show-posts-read-more:visited' => array(
			'background' => ( '' !== $read_more_text ) ? $read_more_background_color : null,
			'border-color' => ( '' !== $read_more_text ) ? $read_more_border_color : null,
			'color' => ( '' !== $read_more_text ) ? $read_more_text_color : null
		),
		
		'#wpsp-' . $wpsp_id . ' .wp-show-posts-read-more:hover,
		#wpsp-' . $wpsp_id . ' .wp-show-posts-read-more:focus' => array(
			'background' => ( '' !== $read_more_text ) ? $read_more_background_color_hover : null,
			'border-color' => ( '' !== $read_more_text ) ? $read_more_border_color_hover : null,
			'color' => ( '' !== $read_more_text ) ? $read_more_text_color_hover : null
		),
		
		'.wpsp-social-link.wpsp-twitter, 
		.wpsp-social-link.wpsp-twitter:visited' => array(
			'color' => ( $social_sharing && $twitter ) ? $twitter_color : null
		),
		
		'.wpsp-social-link.wpsp-twitter:hover, 
		.wpsp-social-link.wpsp-twitter:focus' => array(
			'color' => ( $social_sharing && $twitter ) ? $twitter_color_hover : null
		),
		
		'.wpsp-social-link.wpsp-facebook, 
		.wpsp-social-link.wpsp-facebook:visited' => array(
			'color' => ( $social_sharing && $facebook ) ? $facebook_color : null
		),
		
		'.wpsp-social-link.wpsp-facebook:hover, 
		.wpsp-social-link.wpsp-facebook:focus' => array(
			'color' => ( $social_sharing && $facebook ) ? $facebook_color_hover : null
		),
		
		'.wpsp-social-link.wpsp-googleplus, 
		.wpsp-social-link.wpsp-googleplus:visited' => array(
			'color' => ( $social_sharing && $googleplus ) ? $googleplus_color : null
		),
		
		'.wpsp-social-link.wpsp-googleplus:hover, 
		.wpsp-social-link.wpsp-googleplus:focus' => array(
			'color' => ( $social_sharing && $googleplus ) ? $googleplus_color_hover : null
		),
		
		'.wpsp-social-link.wpsp-pinterest, 
		.wpsp-social-link.wpsp-pinterest:visited' => array(
			'color' => ( $social_sharing && $pinterest ) ? $pinterest_color : null
		),
		
		'.wpsp-social-link.wpsp-pinterest:hover, 
		.wpsp-social-link.wpsp-pinterest:focus' => array(
			'color' => ( $social_sharing && $pinterest ) ? $pinterest_color_hover : null
		),
		
		'.wpsp-li-button, 
		.wpsp-li-button:visited' => array(
			'color' => ( $social_sharing && $love ) ? $love_color : null
		),
		
		'.wpsp-li-button:hover, 
		.wpsp-li-button:focus' => array(
			'color' => ( $social_sharing && $love ) ? $love_color_hover : null
		)
		
	);
	
	// Output the above CSS
	$output = '';
	foreach($visual_css as $k => $properties) {
		if(!count($properties))
			continue;

		$temporary_output = $k . ' {';
		$elements_added = 0;

		foreach($properties as $p => $v) {
			if(empty($v))
				continue;

			$elements_added++;
			$temporary_output .= $p . ': ' . $v . '; ';
		}

		$temporary_output .= "}";

		if($elements_added > 0)
			$output .= $temporary_output;
	}

	$output = str_replace(array("\r", "\n"), '', $output);
	
	if ( '' !== $output ) {
		echo '<style>';
		    echo $output;
		echo '</style>';
	}
}