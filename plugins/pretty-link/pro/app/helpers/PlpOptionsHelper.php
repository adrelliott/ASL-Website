<?php if(!defined('ABSPATH')) die('You are not allowed to call this page directly.');

class PlpOptionsHelper {
  public static function autocreate_post_options($post_type, $option, $category, $socbtns) {
    // For reverse-compatibility
    if($post_type=='post' || $post_type=='page') {
      $option_name  = "prli_{$post_type}s_auto";
      $category_name   = "prli_{$post_type}s_category";
      $socbtns_name = "prli_social_{$post_type}s_buttons";
    }
    else {
      $option_name  = "prli_autocreate[{$post_type}][enabled]";
      $category_name   = "prli_autocreate[{$post_type}][category]";
      $socbtns_name = "prli_autocreate[{$post_type}][socbtns]";
    }

    $p = get_post_type_object($post_type);

    require(PLP_VIEWS_PATH . '/options/autocreate.php');
  }

  public static function autocreate_all_cpt_options() {
    global $plp_options;

    $post_types = $plp_options->get_post_types(false);

    foreach($post_types as $post_type) {
      $option  = !empty($plp_options->autocreate[$post_type]['enabled']);
      $category   = !empty($plp_options->autocreate[$post_type]['category']) ? $plp_options->autocreate[$post_type]['category'] : '';
      $socbtns = !empty($plp_options->autocreate[$post_type]['socbtns']);

      self::autocreate_post_options($post_type, $option, $category, $socbtns);
    }
  }
}

