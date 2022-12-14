<?php
if(!defined('ABSPATH'))
  die('You are not allowed to call this page directly.');

class PlpLinkRotation {
  public $table_name;
  public $cr_table_name;

  public function __construct() {
    global $wpdb;
    $this->table_name    = "{$wpdb->prefix}prli_link_rotations";
    $this->cr_table_name = "{$wpdb->prefix}prli_clicks_rotations";
  }

  public function create( $url, $weight, $r_index, $link_id ) {
    global $wpdb;

    $query_str = "INSERT INTO {$this->table_name} " .
                 '(url,' .
                  'weight,' .
                  'r_index,' .
                  'link_id,' .
                  'created_at) ' .
                  'VALUES ' .
                  '(%s,%d,%d,%d,NOW())';

    $query = $wpdb->prepare( $query_str,
                             $url,
                             $weight,
                             $r_index,
                             $link_id );

    $query_results = $wpdb->query($query);

    if($query_results)
      return $wpdb->insert_id;
    else
      return false;
  }

  public function update( $url, $weight, $r_index, $link_id ) {
    global $wpdb;

    $query_str = "UPDATE {$this->table_name} SET " .
                  'url=%s, ' .
                  'weight=%d ' .
                 'WHERE ' .
                  'link_id=%d AND ' .
                  'r_index=%d';

    $query = $wpdb->prepare( $query_str,
                             $url,
                             $weight,
                             $link_id,
                             $r_index );

    $query_results = $wpdb->query($query);

    return $query_results;
  }

  public function record_click( $click_id, $link_id, $url ) {
    global $wpdb;

    $query_str = "INSERT INTO {$this->cr_table_name} " .
                 '(click_id,' .
                  'link_id,' .
                  'url) ' .
                  'VALUES ' .
                  '(%d,%d,%s)';

    $query = $wpdb->prepare( $query_str,
                             $click_id,
                             $link_id,
                             $url );

    $query_results = $wpdb->query($query);

    if($query_results)
      return $wpdb->insert_id;
    else
      return false;
  }

  public function updateLinkRotations($link_id,$link_rotations,$link_weights) {
    $existing_rotations = $this->getAllByLinkId( $link_id );

    $max_count = ((count($existing_rotations) > count($link_rotations))?count($existing_rotations):count($link_rotations));
    for($i=0;$i<$max_count;$i++)
    {
      if(isset($existing_rotations[$i]) and isset($link_rotations[$i]))
      {
        if(empty($link_rotations[$i]) or preg_match("#^\s*$#",$link_rotations[$i]))
          $this->destroy($link_id,$i);
        else
          $this->update(trim($link_rotations[$i]), trim($link_weights[$i]), $i, $link_id);
      }
      else if(isset($link_rotations[$i]) and !preg_match("#^\s*$#",$link_rotations[$i]))
        $this->create(trim($link_rotations[$i]), trim($link_weights[$i]), $i, $link_id);
      else if(isset($existing_rotations[$i]))
        $this->destroy($link_id,$i);
    }
  }

  public function destroy( $link_id, $r_index ) {
    global $wpdb;
    $query_str = "DELETE FROM {$this->table_name} WHERE link_id=%d AND r_index=%d";
    $query = $wpdb->prepare($query_str,$link_id,$r_index);
    return $wpdb->query($query);
  }

  public function destroyByLinkId( $link_id ) {
    global $wpdb;
    $query_str = "DELETE FROM {$this->table_name} WHERE link_id=%d";
    $query = $wpdb->prepare($query_str,$link_id);
    return $wpdb->query($query);
  }

  public function getOne( $id, $return_type = OBJECT ) {
    global $wpdb;
    $query_str = "SELECT * FROM {$this->table_name} WHERE id=%d";
    $query = $wpdb->prepare($query_str,$id);
    return $wpdb->get_row($query, $return_type);
  }

  public function getAllByLinkId( $link_id, $return_type = OBJECT ) {
    global $wpdb;
    $query_str = "SELECT * FROM {$this->table_name} WHERE link_id=%d ORDER BY r_index";
    $query = $wpdb->prepare($query_str,$link_id);
    return $wpdb->get_results($query, $return_type);
  }

  public function getAll($where = '', $return_type = OBJECT) {
    global $wpdb, $prli_utils;
    $query_str = "SELECT * FROM {$this->table_name}" . $prli_utils->prepend_and_or_where(' WHERE', $where) . " ORDER BY link_id,r_index";
    return $wpdb->get_results($query_str, $return_type);
  }

  public function get_rotations($link_id) {
    global $wpdb;
    $query_str = "SELECT url FROM {$this->table_name} WHERE link_id=%d ORDER BY r_index";
    $query = $wpdb->prepare($query_str,$link_id);
    return $wpdb->get_col($query, 0);
  }

  public function get_weights($link_id) {
    global $wpdb;
    $query_str = "SELECT weight FROM {$this->table_name} WHERE link_id=%d ORDER BY r_index";
    $query = $wpdb->prepare($query_str,$link_id);
    return $wpdb->get_col($query, 0);
  }

  public function get_target_url($link_id) {
    global $prli_link, $prli_link_meta;

    $link = $prli_link->getOne($link_id);

    $rotation_urls = $this->get_rotations($link_id);
    $rotation_urls[] = $link->url;

    $weights = $this->get_weights($link_id);
    $weights[] = $prli_link_meta->get_link_meta($link_id,'prli-target-url-weight',true);

    $index = PlpUtils::w_rand($weights);

    // Just double check that we aren't returning an empty URL ...
    // At the very least we can return the target url.
    $target_url = (empty($rotation_urls[$index])?$link->url:$rotation_urls[$index]);

    return $target_url;
  }

  public function there_are_rotations_for_this_link($link_id) {
    global $wpdb;
    $query_str = "SELECT * FROM {$this->table_name} WHERE link_id=%d";
    $query = $wpdb->prepare($query_str,$link_id);
    $url_rotations = $wpdb->get_results($query);

    foreach($url_rotations as $rot) {
      if(!preg_match('#^/s*?#',$rot->url))
        return true; // short circuit when we find the first rotation
    }

    return false;
  }
}
