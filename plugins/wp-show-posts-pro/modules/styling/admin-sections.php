<?php
add_action( 'butterbean_register', 'wpsp_styling_register', 25, 2 );
function wpsp_styling_register( $butterbean, $post_type ) {
	
	if ( function_exists( 'wpsp_get_defaults' ) ) $defaults = wpsp_get_defaults();
	
	$manager = $butterbean->get_manager( 'wp_show_posts' );
	
	$manager->register_control(
        'wpsp_image_overlay_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_images',
            'label'   => esc_html__( 'Image overlay color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-image-overlay' )
        )
    );
	
	$manager->register_setting(
        'wpsp_image_overlay_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_image_overlay_color' ] ? $defaults[ 'wpsp_image_overlay_color' ] : false
        )
    );
	
	$manager->register_control(
        'wpsp_image_overlay_icon', // Same as setting name.
        array(
            'type'    => 'select',
            'section' => 'wpsp_images',
            'label'   => esc_html__( 'Image overlay icon', 'wp-show-posts' ),
            'choices' => array(
				'' => '',
				'plus' => __( 'Plus','wp-show-posts-pro' ),
				'eye' => __( 'Eye','wp-show-posts-pro' ),
				'play' => __( 'Play','wp-show-posts-pro' ),
				'heart' => __( 'Heart','wp-show-posts-pro' ),
				'download' => __( 'Download','wp-show-posts-pro' ),
				'cloud-download' => __( 'Cloud download','wp-show-posts-pro' )
			),
			'attr' => array( 'id' => 'wpsp-overlay-content' )
        )
    );
	
	$manager->register_setting(
        'wpsp_image_overlay_icon', // Same as control name.
        array(
            'sanitize_callback' => 'sanitize_text_field',
			'default' => $defaults[ 'wpsp_image_overlay_icon' ] ? $defaults[ 'wpsp_image_overlay_icon' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_image_hover_effect', // Same as setting name.
        array(
            'type'    => 'select',
            'section' => 'wpsp_images',
            'label'   => esc_html__( 'Image hover effect', 'wp-show-posts' ),
            'choices' => array(
				'' => '',
				'zoom' => __( 'Zoom','wp-show-posts-pro' ),
				'blur' => __( 'Blur','wp-show-posts-pro' ),
				'grayscale' => __( 'Grayscale','wp-show-posts-pro' ),
			),
			'attr' => array( 'id' => 'wpsp-image-effect' )
        )
    );
	
	$manager->register_setting(
        'wpsp_image_hover_effect', // Same as control name.
        array(
            'sanitize_callback' => 'sanitize_text_field',
			'default' => $defaults[ 'wpsp_image_hover_effect' ] ? $defaults[ 'wpsp_image_hover_effect' ] : ''
        )
    );
	
	$manager->register_section(
        'wpsp_styling',
        array(
            'label' => esc_html__( 'Styling', 'wp-show-posts' ),
            'icon'  => 'dashicons-admin-customizer'
        )
    );
	
	$manager->register_control(
        'wpsp_background', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_columns',
            'label'   => esc_html__( 'Background color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-background' )
        )
    );
	
	$manager->register_setting(
        'wpsp_background', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_background' ] ? $defaults[ 'wpsp_background' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_background_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_columns',
            'label'   => esc_html__( 'Background color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-background-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_background_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_background_hover' ] ? $defaults[ 'wpsp_background_hover' ] : ''
        )
    );
	
	// Title color
	$manager->register_control(
        'wpsp_title_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Title color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-title-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_title_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_title_color' ] ? $defaults[ 'wpsp_title_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_title_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Title color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-title-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_title_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_title_color_hover' ] ? $defaults[ 'wpsp_title_color_hover' ] : ''
        )
    );
	
	// Meta color
	$manager->register_control(
        'wpsp_meta_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_post_meta',
            'label'   => esc_html__( 'Meta color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-meta-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_meta_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_meta_color' ] ? $defaults[ 'wpsp_meta_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_meta_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_post_meta',
            'label'   => esc_html__( 'Meta color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-meta-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_meta_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_meta_color_hover' ] ? $defaults[ 'wpsp_meta_color_hover' ] : ''
        )
    );
	
	// Text color
	$manager->register_control(
        'wpsp_text', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Text color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-text' )
        )
    );
	
	$manager->register_setting(
        'wpsp_text', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_text' ] ? $defaults[ 'wpsp_text' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_link', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Link color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-link' )
        )
    );
	
	$manager->register_setting(
        'wpsp_link', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_link' ] ? $defaults[ 'wpsp_link' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_link_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Link color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-link-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_link_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_link_hover' ] ? $defaults[ 'wpsp_link_hover' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_border', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_columns',
            'label'   => esc_html__( 'Border color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-border' ),
        )
    );
	
	$manager->register_setting(
        'wpsp_border', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_border' ] ? $defaults[ 'wpsp_border' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_border_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_columns',
            'label'   => esc_html__( 'Border color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-border-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_border_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_border_hover' ] ? $defaults[ 'wpsp_border_hover' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_padding', // Same as setting name.
        array(
            'type'    => 'text',
            'section' => 'wpsp_columns',
            'label'   => esc_html__( 'Padding (add unit: px, em etc..)', 'wp-show-posts' ),
			'attr' => array( 'id' => 'wpsp-read-more-style' )
        )
    );
	
	$manager->register_setting(
        'wpsp_padding', // Same as control name.
        array(
            'sanitize_callback' => 'sanitize_text_field',
			'default' => $defaults[ 'wpsp_padding' ] ? $defaults[ 'wpsp_padding' ] : ''
        )
    );
	
	// Read more button controls
	$manager->register_control(
        'wpsp_read_more_background_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Read more background', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-read-more-background' )
        )
    );
	
	$manager->register_setting(
        'wpsp_read_more_background_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_read_more_background_color' ] ? $defaults[ 'wpsp_read_more_background_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_read_more_background_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Read more background hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-read-more-background-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_read_more_background_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_read_more_background_color_hover' ] ? $defaults[ 'wpsp_read_more_background_color_hover' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_read_more_text_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Read more text', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-read-more-text-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_read_more_text_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_read_more_text_color' ] ? $defaults[ 'wpsp_read_more_text_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_read_more_text_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Read more text hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-read-more-text-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_read_more_text_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_read_more_text_color_hover' ] ? $defaults[ 'wpsp_read_more_text_color_hover' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_read_more_border_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Read more border', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-read-more-border-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_read_more_border_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_read_more_border_color' ] ? $defaults[ 'wpsp_read_more_border_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_read_more_border_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_content',
            'label'   => esc_html__( 'Read more border hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-read-more-border-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_read_more_border_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_read_more_border_color_hover' ] ? $defaults[ 'wpsp_read_more_border_color_hover' ] : ''
        )
    );
	
	// Social icon colors
	$manager->register_control(
        'wpsp_twitter_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Twitter color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-twitter-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_twitter_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_twitter_color' ] ? $defaults[ 'wpsp_twitter_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_twitter_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Twitter color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-twitter-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_twitter_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_twitter_color_hover' ] ? $defaults[ 'wpsp_twitter_color_hover' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_facebook_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Facebook color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-facebook-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_facebook_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_facebook_color' ] ? $defaults[ 'wpsp_facebook_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_facebook_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Facebook color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-facebook-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_facebook_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_facebook_color_hover' ] ? $defaults[ 'wpsp_facebook_color_hover' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_googleplus_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Google+ color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-googleplus-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_googleplus_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_googleplus_color' ] ? $defaults[ 'wpsp_googleplus_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_googleplus_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Google+ color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-googleplus-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_googleplus_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_googleplus_color_hover' ] ? $defaults[ 'wpsp_googleplus_color_hover' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_pinterest_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Pinterest color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-pinterest-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_pinterest_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_pinterest_color' ] ? $defaults[ 'wpsp_pinterest_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_pinterest_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Pinterest color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-pinterest-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_pinterest_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_pinterest_color_hover' ] ? $defaults[ 'wpsp_pinterest_color_hover' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_love_color', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Love color', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-love-color' )
        )
    );
	
	$manager->register_setting(
        'wpsp_love_color', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_love_color' ] ? $defaults[ 'wpsp_love_color' ] : ''
        )
    );
	
	$manager->register_control(
        'wpsp_love_color_hover', // Same as setting name.
        array(
            'type'    => 'color',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Love color hover', 'wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-love-color-hover' )
        )
    );
	
	$manager->register_setting(
        'wpsp_love_color_hover', // Same as control name.
        array(
            'sanitize_callback' => 'wpsp_pro_sanitize_hex_color',
			'default' => $defaults[ 'wpsp_love_color_hover' ] ? $defaults[ 'wpsp_love_color_hover' ] : ''
        )
    );
}

if ( ! function_exists( 'wpsp_pro_sanitize_hex_color' ) ) :
function wpsp_pro_sanitize_hex_color( $color )
{
	if ( '' === $color )
        return '';
 
    // 3 or 6 hex digits, or the empty string.
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
        return $color;
}
endif;