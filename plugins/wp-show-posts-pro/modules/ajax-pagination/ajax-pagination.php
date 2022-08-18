<?php
add_action( 'wp_enqueue_scripts','wpsp_pro_pagination_enqueue_scripts' );
function wpsp_pro_pagination_enqueue_scripts()
{
	wp_register_script( 'wpsp-imagesloaded', plugin_dir_url( __FILE__ ) . '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'wpsp-ajax-pagination', plugin_dir_url( __FILE__ ) . '/js/pagination.js', array( 'jquery', 'wpsp-imagesloaded' ), '', true );
	wp_localize_script( 'wpsp-ajax-pagination', 'ajaxpagination', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'more'  => apply_filters( 'wpsp_ajax_load_more', __( 'Load More','wp-show-posts-pro') ),
		'loading' => apply_filters( 'wpsp_ajax_loading', __( 'Loading...', 'wp-show-posts-pro' ) ),
	));
}

function wpsp_ajax_pagination( $next_page_url, $paged, $max_page )
{
	?>
	<div class="wpsp-load-more">
		<a class="wp-show-posts-read-more" data-link="<?php echo esc_url( $next_page_url ); ?>" data-page="<?php echo $paged;?>" data-pages="<?php echo $max_page;?>" href="#"><?php echo apply_filters( 'wpsp_ajax_load_more', __( 'Load more','wp-show-posts-pro' ) ); ?></a>
	</div>
	<?php
}

add_action( 'butterbean_register', 'wpsp_pagination_register', 20, 2 );
function wpsp_pagination_register( $butterbean, $post_type ) 
{
	if ( function_exists( 'wpsp_get_defaults' ) ) $defaults = wpsp_get_defaults();
	$manager = $butterbean->get_manager( 'wp_show_posts' );
	
	$manager->register_control(
		'wpsp_ajax_pagination',
		array(
			'type'        => 'checkbox',
			'section'     => 'wpsp_posts',
			'label'       => __( 'AJAX Pagination','wp-show-posts-pro' ),
			'attr' => array( 'id' => 'wpsp-ajax-pagination' )
		)
	);
	
	$manager->register_setting(
		'wpsp_ajax_pagination',
		array( 
			'sanitize_callback' => 'butterbean_validate_boolean',
			'default' => $defaults[ 'wpsp_ajax_pagination' ] ? $defaults[ 'wpsp_ajax_pagination' ] : false
		)
	);
}