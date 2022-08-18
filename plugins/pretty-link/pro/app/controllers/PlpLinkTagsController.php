<?php if(!defined('ABSPATH')) { die('You are not allowed to call this page directly.'); }

class PlpLinkTagsController extends PrliBaseController {
  public static $ctax = 'pretty-link-tag';

  public function load_hooks() {
    add_action('init', array($this,'register_taxonomy'));
  }

  public function register_taxonomy() {
    $role = PrliUtils::get_minimum_role();

    $args = array(
      'labels' => array(
        'name'              => esc_html_x( 'Link Tags', 'taxonomy general name', 'pretty-link' ),
        'singular_name'     => esc_html_x( 'Link Tag', 'taxonomy singular name', 'pretty-link' ),
        'search_items'      => esc_html__( 'Search Link Tags', 'pretty-link' ),
        'all_items'         => esc_html__( 'All Link Tags', 'pretty-link' ),
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => esc_html__( 'Edit Link Tag', 'pretty-link' ),
        'update_item'       => esc_html__( 'Update Link Tag', 'pretty-link' ),
        'add_new_item'      => esc_html__( 'Add New Link Tag', 'pretty-link' ),
        'new_item_name'     => esc_html__( 'New Link Tag Name', 'pretty-link' ),
        'separate_items_with_commas' => esc_html__( 'Separate Link Tags with commas', 'pretty-link' ),
        'add_or_remove_items'        => esc_html__( 'Add or remove Link Tags', 'pretty-link' ),
        'choose_from_most_used'      => esc_html__( 'Choose from the most used Link Tags', 'pretty-link' ),
        'not_found'         => esc_html__( 'No Link Tags found.', 'pretty-link' ),
        'menu_name'         => esc_html__( 'Tags', 'pretty-link' ),
      ),
      'hierarchical'      => false,
      'show_ui'           => true,
      'show_admin_column' => true,
      'update_count_callback' => '_update_post_term_count',
      'query_var'         => false,
      'rewrite'           => false,
      'capabilities'      => array(
        'manage_terms' => $role,
        'edit_terms'   => $role,
        'delete_terms' => $role,
        'assign_terms' => $role
      )
    );


    register_taxonomy( self::$ctax, PrliLink::$cpt, $args );
  }
}


