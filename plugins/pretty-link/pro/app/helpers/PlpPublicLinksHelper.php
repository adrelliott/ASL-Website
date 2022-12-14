<?php
if(!defined('ABSPATH')) { die('You are not allowed to call this page directly.'); }

class PlpPublicLinksHelper {
  public static function display_form($label=null, $button=null, $redirect_type=null, $track=null, $category=null) {
    $label  = is_null($label)?__('Enter a URL:', 'pretty-link'):$label;
    $button = is_null($button)?__('Shrink', 'pretty-link'):$button;
    $track  = is_null($track)?'-1':$track;
    $category  = is_null($category)?'-1':$category;
    $redirect_type = is_null($redirect_type)?'-1':$redirect_type;

    ob_start();
    require(PLP_VIEWS_PATH . '/public/form.php');
    $formhtml = ob_get_clean();

    return $formhtml;
  }
}

