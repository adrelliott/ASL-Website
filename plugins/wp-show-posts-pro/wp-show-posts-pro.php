<?php
/*
Plugin Name: WP Show Posts Pro
Plugin URI: https://wpshowposts.com
Description: WP Show Posts Pro extends the awesome WP Show Posts plugin. It adds new features like Masonry, AJAX pagination, styling and much more!
Version: 0.5
Author: Tom Usborne
Author URI: https://tomusborne.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-show-posts-pro
*/

define( 'WPSP_PRO_VERSION', 0.5 );

// Show the admin
require_once trailingslashit( dirname( __FILE__ ) ) . 'inc/admin.php';

// Get our defaults
require_once trailingslashit( dirname( __FILE__ ) ) . 'inc/defaults.php';

// Require WP Show Posts free version
require_once trailingslashit( dirname( __FILE__ ) ) . 'inc/class-tgm-plugin-activation.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'inc/require-wpsp.php';

// AJAX pagination
require_once trailingslashit( dirname( __FILE__ ) ) . 'modules/ajax-pagination/ajax-pagination.php';

// Style
require_once trailingslashit( dirname( __FILE__ ) ) . 'modules/styling/styling.php';

// Columns
require_once trailingslashit( dirname( __FILE__ ) ) . 'modules/columns/columns.php';

// Social sharing
require_once trailingslashit( dirname( __FILE__ ) ) . 'modules/social-sharing/social-sharing.php';

// Image gallery
require_once trailingslashit( dirname( __FILE__ ) ) . 'modules/image-gallery/image-gallery.php';

// Compatibility with free plugin
require_once trailingslashit( dirname( __FILE__ ) ) . 'inc/compat.php';

// Filter
//require_once trailingslashit( dirname( __FILE__ ) ) . 'modules/filter/filter.php';

if ( ! function_exists( 'generate_package_setup' ) ) :
/*
 * Make WPSP Pro translatable
 * @since 0.4
 */
add_action( 'plugins_loaded', 'wpsp_pro_languages' );
function wpsp_pro_languages() {
  load_plugin_textdomain( 'wp-show-posts-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
endif;

if ( ! function_exists( 'wpsp_pro_enqueue_scripts' ) ) :
/*
 * Enqueue our CSS to the front end
 * @since 0.1
 */
add_action( 'wp_enqueue_scripts', 'wpsp_pro_enqueue_scripts' );
function wpsp_pro_enqueue_scripts() 
{
	$suffix = ( function_exists( 'wpsp_get_min_suffix' ) ) ? wpsp_get_min_suffix() : '.min';
	wp_enqueue_style( 'wp-show-posts-pro', plugins_url( "css/wp-show-posts{$suffix}.css", __FILE__ ), array( 'wp-show-posts' ), WPSP_PRO_VERSION );
}
endif;

if( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/inc/EDD_SL_Plugin_Updater.php' );
}

add_action( 'admin_init', 'wpsp_pro_updater', 0 );
function wpsp_pro_updater()
{
	// retrieve our license key from the DB
	$license_key = trim( get_option( 'wp_show_posts_license' ) );

	// setup the updater
	$edd_updater = new EDD_SL_Plugin_Updater( 'https://wpshowposts.com', __FILE__, array( 
			'version' 	=> WPSP_PRO_VERSION,
			'license' 	=> $license_key,
			'item_name' => 'WP Show Posts Pro',
			'author' 	=> 'Tom Usborne',
			'url'       => home_url()
		)
	);
}