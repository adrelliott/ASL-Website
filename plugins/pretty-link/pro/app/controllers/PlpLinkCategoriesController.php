<?php if(!defined('ABSPATH')) { die('You are not allowed to call this page directly.'); }

class PlpLinkCategoriesController extends PrliBaseController {
  public static $ctax = 'pretty-link-category';

  public function load_hooks() {
    add_action('init',   array($this,'register_taxonomy'));
  }

  public function register_taxonomy() {
    $role = PrliUtils::get_minimum_role();

    $args = array(
      'labels' => array(
        'name'              => esc_html_x( 'Link Categories', 'taxonomy general name', 'pretty-link' ),
        'singular_name'     => esc_html_x( 'Link Category', 'taxonomy singular name', 'pretty-link' ),
        'search_items'      => esc_html__( 'Search Link Categories', 'pretty-link' ),
        'all_items'         => esc_html__( 'All Link Categories', 'pretty-link' ),
        'parent_item'       => esc_html__( 'Parent Link Category', 'pretty-link' ),
        'parent_item_colon' => esc_html__( 'Parent Link Category:', 'pretty-link' ),
        'edit_item'         => esc_html__( 'Edit Link Category', 'pretty-link' ),
        'update_item'       => esc_html__( 'Update Link Category', 'pretty-link' ),
        'add_new_item'      => esc_html__( 'Add New Link Category', 'pretty-link' ),
        'new_item_name'     => esc_html__( 'New Link Category Name', 'pretty-link' ),
        'menu_name'         => esc_html__( 'Categories', 'pretty-link' ),
      ),
      'hierarchical'      => true,
      'show_ui'           => true,
      'show_admin_column' => true,
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

