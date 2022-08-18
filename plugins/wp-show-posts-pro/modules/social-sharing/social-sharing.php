<?php
// Love button
require trailingslashit( dirname( __FILE__ ) ) . 'love-it.php';

add_action( 'butterbean_register', 'wpsp_social_register', 30, 2 );
function wpsp_social_register( $butterbean, $post_type ) {
	
	if ( function_exists( 'wpsp_get_defaults' ) ) $defaults = wpsp_get_defaults();
	
	$manager = $butterbean->get_manager( 'wp_show_posts' );
	
	$manager->register_section(
        'wpsp_social',
        array(
            'label' => esc_html__( 'Social', 'wp-show-posts' ),
            'icon'  => 'dashicons-share'
        )
    );
	
	$manager->register_control(
		'wpsp_social_sharing',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_social',
			'label'       => __( 'Show social sharing buttons','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-social-sharing' )
		)
	);
	
	$manager->register_setting(
		'wpsp_social_sharing',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_social_sharing' ] ? $defaults[ 'wpsp_social_sharing' ] : false
		)
	);
	
	$manager->register_control(
		'wpsp_twitter',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_social',
			'label'       => __( 'Twitter','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-twitter' )
		)
	);
	
	$manager->register_setting(
		'wpsp_twitter',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_twitter' ] ? $defaults[ 'wpsp_twitter' ] : false
		)
	);
	
	$manager->register_control(
		'wpsp_facebook',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_social',
			'label'       => __( 'Facebook','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-facebook' )
		)
	);
	
	$manager->register_setting(
		'wpsp_facebook',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_facebook' ] ? $defaults[ 'wpsp_facebook' ] : false
		)
	);
	
	$manager->register_control(
		'wpsp_googleplus',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_social',
			'label'       => __( 'Google+','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-googleplus' )
		)
	);
	
	$manager->register_setting(
		'wpsp_googleplus',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_googleplus' ] ? $defaults[ 'wpsp_googleplus' ] : false
		)
	);
	
	$manager->register_control(
		'wpsp_pinterest',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_social',
			'label'       => __( 'Pinterest','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-pinterest' )
		)
	);
	
	$manager->register_setting(
		'wpsp_pinterest',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_pinterest' ] ? $defaults[ 'wpsp_pinterest' ] : false
		)
	);
	
	$manager->register_control(
		'wpsp_love',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_social',
			'label'       => __( 'Love','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-love' )
		)
	);
	
	$manager->register_setting(
		'wpsp_love',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_love' ] ? $defaults[ 'wpsp_love' ] : false
		)
	);
	
	$manager->register_control(
        'wpsp_social_sharing_alignment', // Same as setting name.
        array(
            'type'    => 'select',
            'section' => 'wpsp_social',
            'label'   => esc_html__( 'Alignment', 'wp-show-posts' ),
            'choices' => array(
				'left' => __( 'Left','wp-show-posts-pro' ),
				'center' => __( 'Center','wp-show-posts-pro' ),
				'right' => __( 'Right','wp-show-posts-pro' ),
			),
			'attr' => array( 'id' => 'wpsp-social-sharing-alignment' )
        )
    );
	
	$manager->register_setting(
        'wpsp_social_sharing_alignment', // Same as control name.
        array(
            'sanitize_callback' => 'sanitize_text_field',
			'default' => $defaults[ 'wpsp_social_sharing_alignment' ] ? $defaults[ 'wpsp_social_sharing_alignment' ] : 'right'
        )
    );
}
if ( ! function_exists( 'wpsp_social_sharing' ) ) :
function wpsp_social_sharing( $id, $twitter, $facebook, $googleplus, $pinterest, $love, $social_sharing_alignment ) 
{	
	// Get current page URL 
	$url = esc_url( get_permalink( $id ) );

	// Get current page title
	$title = str_replace( ' ', '%20', get_the_title( $id ));
	
	// Get Post Thumbnail for pinterest
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );

	// Construct sharing URL without using any script
	$twitterURL = 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url;
	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$url;
	$googleURL = 'https://plus.google.com/share?url='.$url;
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$url.'&amp;media='.$image[0].'&amp;description='.$title;

	// Construct our buttons
	if ( $twitter || $facebook || $googleplus || $pinterest || $love ) echo '<div class="wpsp-social wpsp-social-' . $social_sharing_alignment . '">';
	
		if ( $twitter )
			echo '<a title="' . __( 'Twitter','wp-show-posts-pro' ) . '" class="wpsp-social-link wpsp-twitter" href="'. $twitterURL .'" target="_blank"><span class="screen-reader-text">Twitter</span></a>';
	
		if ( $facebook )
			echo '<a title="' . __( 'Facebook','wp-show-posts-pro' ) . '" class="wpsp-social-link wpsp-facebook" href="'.$facebookURL.'" target="_blank"><span class="screen-reader-text">Facebook</span></a>';
	
		if ( $googleplus )
			echo '<a title="' . __( 'Google+','wp-show-posts-pro' ) . '" class="wpsp-social-link wpsp-googleplus" href="'.$googleURL.'" target="_blank"><span class="screen-reader-text">Google+</span></a>';
		
		if ( $pinterest )
			echo '<a title="' . __( 'Pinterest','wp-show-posts-pro' ) . '" class="wpsp-social-link wpsp-pinterest" href="'.$pinterestURL.'" target="_blank"><span class="screen-reader-text">Pin It</span></a>';
	
		if ( $love )
			echo wpsp_get_love_button( $id );
		
	if ( $twitter || $facebook || $googleplus || $pinterest || $love ) echo '</div>';
};
endif;

if ( ! function_exists( 'wpsp_add_social_sharing' ) ) :
add_action( 'wpsp_after_content','wpsp_add_social_sharing', 10 );
function wpsp_add_social_sharing()
{
	global $wpsp_id;
	$social_sharing  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_social_sharing' ), FILTER_VALIDATE_BOOLEAN );
	$social_sharing_alignment = sanitize_text_field( wpsp_get_setting( $wpsp_id, 'wpsp_social_sharing_alignment' ) );
	$twitter		  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_twitter' ), FILTER_VALIDATE_BOOLEAN );
	$facebook		  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_facebook' ), FILTER_VALIDATE_BOOLEAN );
	$googleplus		  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_googleplus' ), FILTER_VALIDATE_BOOLEAN );
	$pinterest		  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_pinterest' ), FILTER_VALIDATE_BOOLEAN );
	$love			  		= filter_var( wpsp_get_setting( $wpsp_id, 'wpsp_love' ), FILTER_VALIDATE_BOOLEAN );
	
	if ( $social_sharing && function_exists( 'wpsp_social_sharing' ) ) :
		echo wpsp_social_sharing( get_the_ID(), $twitter, $facebook, $googleplus, $pinterest, $love, $social_sharing_alignment );
		if ( $love ) wp_enqueue_script( 'wpsp-love-it' );
	endif;
}
endif;