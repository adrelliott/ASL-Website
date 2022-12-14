<?php
if(!defined('ABSPATH')) { die('You are not allowed to call this page directly.'); }

class PlpReport
{
  public $table_name;
  public $links_table_name;

  public function __construct() {
    global $wpdb;
    $this->table_name = "{$wpdb->prefix}prli_reports";
    $this->links_table_name = "{$wpdb->prefix}prli_report_links";
  }

  public function create( $values ) {
    global $wpdb;

    $goal_link_id = isset($values['goal_link_id']) ? $values['goal_link_id'] : 0;
    $query_str = "INSERT INTO {$this->table_name} ".
                 '(name,goal_link_id,created_at) ' .
                 'VALUES (%s,%d,NOW())';
    $query = $wpdb->prepare( $query_str, $values['name'], $goal_link_id );
    $query_results = $wpdb->query($query);
    return $wpdb->insert_id;
  }

  public function update( $id, $values ) {
    global $wpdb;

    $goal_link_id = isset($values['goal_link_id']) ? $values['goal_link_id'] : 0;
    $query_str = "UPDATE {$this->table_name} " .
                 'SET name=%s, goal_link_id=%d ' .
                 'WHERE id=%d';
    $query = $wpdb->prepare($query_str,$values['name'],$goal_link_id,$id);
    $query_results = $wpdb->query($query);
    return $query_results;
  }

  public function get_report_links($report_id, $return_type = OBJECT) {
    global $wpdb;
    $query_str = "SELECT * FROM {$this->links_table_name} WHERE report_id=%d";
    $query = $wpdb->prepare($query_str, $report_id);
    return $wpdb->get_results($query, $return_type);
  }

  public function get_report_links_array($report_id) {
    global $wpdb;
    $links_table = $wpdb->prefix . 'prli_links';
    $query_str = "SELECT link_id FROM {$this->links_table_name} LEFT JOIN {$links_table} links ON link_id = links.id WHERE report_id=%d AND link_status='enabled'";
    $query = $wpdb->prepare($query_str, $report_id);
    return $wpdb->get_col($query,0);
  }

  public function update_report_links($report_id, $link_ids) {
    global $wpdb;

    // Delete all records associated with this report
    $query_str = "DELETE FROM {$this->links_table_name} WHERE report_id=%d";
    $query = $wpdb->prepare($query_str, $report_id);
    $wpdb->query($query);

    // Rebuild link IDs from the array of link_ids
    foreach($link_ids as $link_id) {
      $query_str = "INSERT INTO {$this->links_table_name} ".
                                 '(report_id,'.
                                  'link_id,'.
                                  'created_at) ' .
                                'VALUES (%d,%d,NOW())';
      $query = $wpdb->prepare( $query_str, $report_id, $link_id );
      $query_results = $wpdb->query($query);
    }
  }

  public function destroy( $id ) {
    global $wpdb;
    $query_str = "DELETE FROM {$this->table_name} WHERE id=%d";
    $query = $wpdb->prepare($query_str, $id);
    return $wpdb->query($query);
  }

  public function getOne( $id ) {
    global $wpdb;
    $query_str = "SELECT * FROM {$this->table_name} WHERE id=%d";
    $query = $wpdb->prepare($query_str, $id);
    return $wpdb->get_row($query);
  }

  public function getAll( $where = '', $order_by = '', $return_type = OBJECT ) {
    global $wpdb, $prli_utils;
    $query = "SELECT rp.*, " .
                    "li.name as goal_link_name, " .
                    "(SELECT COUNT(*) " .
                      "FROM {$this->links_table_name} rpl " .
                      "WHERE rpl.report_id = rp.id) as link_count " .
               "FROM {$this->table_name} rp " .
               "LEFT OUTER JOIN {$prli_link->table_name} li ON li.id = rp.goal_link_id AND li.link_status='enabled'" .
               $prli_utils->prepend_and_or_where(' WHERE', $where) . $order_by;
    return $wpdb->get_results($query, $return_type);
  }

  // Pagination Methods
  public function getRecordCount($where='') {
    global $wpdb, $prli_utils;
    $query = "SELECT COUNT(*) FROM {$this->table_name} rp" . $prli_utils->prepend_and_or_where(' WHERE', $where);
    return $wpdb->get_var($query);
  }

  public function getPageCount($p_size, $where="") {
    return ceil((int)$this->getRecordCount($where) / (int)$p_size);
  }

  public function getPage($current_p,$p_size, $where = "", $order_by = '') {
    global $wpdb, $prli_link, $prli_utils, $prli_link;
    $end_index = $current_p * $p_size;
    $start_index = $end_index - $p_size;
    $query = "SELECT rp.*, " .
                    "li.name as goal_link_name, " .
                    "(SELECT COUNT(*) " .
                      "FROM {$this->links_table_name} rpl " .
                      "WHERE rpl.report_id = rp.id) as link_count " .
               "FROM {$this->table_name} rp " .
               "LEFT OUTER JOIN {$prli_link->table_name} li ON li.id = rp.goal_link_id AND li.link_status='enabled'" .
               $prli_utils->prepend_and_or_where(' WHERE', $where) . "{$order_by} " .
               "LIMIT {$start_index},{$p_size}";
    $results = $wpdb->get_results($query);
    return $results;
  }

  // Set defaults and grab get or post of each possible param
  public function get_params_array() {
    $values = array(
       'action' => sanitize_key(stripslashes(isset($_GET['action'])?$_GET['action']:(isset($_POST['action'])?$_POST['action']:''))),
       'id'     => (isset($_GET['id'])?(int)$_GET['id']:(isset($_POST['id'])?(int)$_POST['id']:'')),
       'sdate'  => sanitize_text_field(stripslashes(isset($_GET['sdate'])?$_GET['sdate']:(isset($_POST['sdate'])?$_POST['sdate']:''))),
       'edate'  => sanitize_text_field(stripslashes(isset($_GET['edate'])?$_GET['edate']:(isset($_POST['edate'])?$_POST['edate']:''))),
       'paged'  => (isset($_GET['paged'])?(int)$_GET['paged']:(isset($_POST['paged'])?(int)$_POST['paged']:1)),
       'search' => sanitize_text_field(stripslashes(isset($_GET['search'])?$_GET['search']:(isset($_POST['search'])?$_POST['search']:''))),
       'sort'   => sanitize_key(stripslashes(isset($_GET['sort'])?$_GET['sort']:(isset($_POST['sort'])?$_POST['sort']:''))),
       'sdir'   => sanitize_key(stripslashes(isset($_GET['sdir'])?$_GET['sdir']:(isset($_POST['sdir'])?$_POST['sdir']:'')))
    );

    return $values;
  }

  public function validate( $values ) {
    global $wpdb, $prli_utils;

    $errors = array();
    if( empty($values['name']) ) {
      $errors[] = __("Report must have a name.", 'pretty-link');
    }

    if( empty($values['link']) ) {
      $errors[] = __("At least one link must be selected for analysis.", 'pretty-link');
    }

    return $errors;
  }

  public function get_labels_by_links($start_timestamp,$end_timestamp,$links,$uniques = false) {
    global $wpdb, $prli_click, $prli_blogurl, $prli_link, $prli_utils;

    if (!count($links)) {
      return array();
    }

    $query_str = "
      SELECT li.name as label
        FROM {$prli_link->table_name} AS li
       WHERE li.id IN (".implode(',',$links).")
         AND li.link_status='enabled'
       ORDER BY li.name
    ";
    $records = $wpdb->get_results($query_str);

    $link_labels = array();
    foreach($records as $record) {
      $link_labels[] = $record->label;
    }

    return $link_labels;
  }

  public function get_clicks_by_links($start_timestamp,$end_timestamp,$links,$uniques = false) {
    global $wpdb, $prli_click, $prli_blogurl, $prli_link, $prli_utils;

    if (!count($links)) {
      return array();
    }

    $query_str = "SELECT li.id as id, " .
                    "(SELECT COUNT(*) FROM {$prli_click->table_name} cl " .
                        "WHERE cl.link_id = li.id" . $prli_click->get_exclude_where_clause( ' AND' ) . " " .
                        (($uniques)?'AND cl.first_click=1 ':'') .
                        "AND cl.created_at BETWEEN %s AND %s) as clicks " .
                 "FROM {$prli_link->table_name} li " .
                 "WHERE li.id IN (".implode(',',$links).") " .
                   "AND li.link_status='enabled' " .
                 "ORDER BY li.name";
    $query = $wpdb->prepare( $query_str, date("Y-n-j 00:00:00",$start_timestamp), date("Y-n-j 23:59:59",$end_timestamp) );
    $records = $wpdb->get_results($query);

    $link_clicks = array();
    foreach($records as $record) {
      $link_clicks[] = $record->clicks;
    }

    return $link_clicks;
  }

  public function get_conversions_by_links($start_timestamp,$end_timestamp,$links,$goal_link_id) {
    global $wpdb, $prli_click, $prli_blogurl, $prli_link, $prli_utils;

    $sdate = date("Y-n-j 00:00:00",$start_timestamp);
    $edate = date("Y-n-j 23:59:59",$end_timestamp);

    $query_str = "SELECT li.id as id, " .
                    "(SELECT COUNT(DISTINCT cl.vuid) FROM {$prli_click->table_name} cl " .
                        "WHERE cl.link_id = li.id" . $prli_click->get_exclude_where_clause( ' AND' ) . " " .
                        "AND cl.vuid IN (SELECT DISTINCT cl2.vuid " .
                                          "FROM {$prli_click->table_name} cl2 " .
                                          "WHERE cl2.link_id=%d " .
                                          "AND cl.created_at < cl2.created_at " .
                                          "AND cl2.created_at BETWEEN %s AND %s" .
                                          $prli_click->get_exclude_where_clause( ' AND' ) . ") " .
                        "AND cl.created_at BETWEEN %s AND %s" .
                    ") as conversions " .
                 "FROM {$prli_link->table_name} li " .
                 "WHERE li.id IN (".implode(',',$links).") " .
                   "AND li.link_status='enabled' " .
                 "ORDER BY li.name";

    $query = $wpdb->prepare( $query_str, $goal_link_id, $sdate, $edate, $sdate, $edate  );
    $records = $wpdb->get_results($query);

    $link_conversions = array();
    foreach($records as $record) {
      $link_conversions[] = $record->conversions;
    }

    return $link_conversions;
  }

  public function get_chart_height($report_id,$line_height = 30) {
    $links = $this->get_report_links_array($report_id);
    return $line_height * count($links);
  }

  public function setupClicksByLinkBarGraph($start_timestamp, $end_timestamp, $report_id, $title_only = false) {
    global $wpdb, $prli_utils, $prli_link, $prli_click;

    $report = $this->getOne($report_id);
    $links = $this->get_report_links_array($report_id);
    $labels_array = $this->get_labels_by_links($start_timestamp, $end_timestamp, $links);
    $clicks_array = $this->get_clicks_by_links($start_timestamp, $end_timestamp, $links);
    $uniques_array = $this->get_clicks_by_links($start_timestamp, $end_timestamp, $links, true);

    if($title_only) {
      return __("Pretty Links Pro: Clicks for", 'pretty-link').' '.stripslashes($report->name).' '.__('report between', 'pretty-link').' '.date("Y-n-j",$start_timestamp).' '.__('and', 'pretty-link').' '.date("Y-n-j", $end_timestamp);
    }

    //Setup conversions
    if(!empty($report->goal_link_id)) {
      $conversions_array = $this->get_conversions_by_links($start_timestamp, $end_timestamp, $links, $report->goal_link_id);

      $chart_data = array('cols' => array(array("label" => __('Link', 'pretty-link'), 'type' => 'string'), array("label" => __('All Clicks', 'pretty-link'), 'type' => 'number'), array("label" => __('Unique Clicks', 'pretty-link'), 'type' => 'number'), array("label" => __('Conversions', 'pretty-link'), 'type' => 'number')));

      foreach($labels_array as $key => $value) {
        $label = substr(addslashes($value),0,40);

        $chart_data['rows'][] = array('c' => array(array('v' => $label, 'f' => null), array('v' => (int)$clicks_array[$key], 'f' => null), array('v' => (int)$uniques_array[$key], 'f' => null), array('v' => (int)$conversions_array[$key], 'f' => null)));
      }
    }
    else { //Setup the clicks w/out conversions
      $chart_data = array('cols' => array(array("label" => __('Link', 'pretty-link'), 'type' => 'string'), array("label" => __('All Clicks', 'pretty-link'), 'type' => 'number'), array("label" => __('Unique Clicks', 'pretty-link'), 'type' => 'number')));

      foreach($labels_array as $key => $value) {
        $label = substr(addslashes($value),0,40);

        $chart_data['rows'][] = array('c' => array(array('v' => $label, 'f' => null), array('v' => (int)$clicks_array[$key], 'f' => null), array('v' => (int)$uniques_array[$key], 'f' => null)));
      }
    }

    return $chart_data;
  }

  // SPLIT TEST REPORT FUNCTIONS
  public function get_split_report_links_array($link_id) {
    global $prli_link,$plp_link_rotation;

    $link = $prli_link->getOne($link_id);

    $rotation_urls   = $plp_link_rotation->get_rotations($link_id);

    if($rotation_urls and is_array($rotation_urls)) {
      array_unshift($rotation_urls,$link->url);
    }
    else {
      $rotation_urls = array($link->url);
    }

    $new_rotation_urls = array();
    foreach($rotation_urls as $rotation_url) {
      if(!empty($rotation_url)) {
        $new_rotation_urls[] = $rotation_url;
      }
    }

    return $new_rotation_urls;
  }

  public function get_split_labels($link_id) {
    $urls = $this->get_split_report_links_array($link_id);

    $new_urls = array();
    foreach($urls as $url) {
      $new_urls[] = substr($url,0,40);
    }

    return $new_urls;
  }

  public function get_split_clicks($start_timestamp,$end_timestamp,$link_id,$uniques=false) {
    global $wpdb, $prli_click, $plp_link_rotation;
    $query_str = "SELECT cr.url as url, COUNT(".(($uniques)?'DISTINCT cl.vuid':'cl.id').") as clicks FROM {$prli_click->table_name} cl " .
                   "JOIN {$plp_link_rotation->cr_table_name} cr ON cl.id=cr.click_id " .
                  "WHERE cl.link_id=%d" .
                  $prli_click->get_exclude_where_clause( ' AND' ) . " " .
                    "AND cl.created_at BETWEEN %s AND %s " .
                  "GROUP BY cr.url";
    $query = $wpdb->prepare( $query_str, $link_id, date("Y-n-j 00:00:00",$start_timestamp), date("Y-n-j 23:59:59",$end_timestamp) );
    $records = $wpdb->get_results($query, ARRAY_A);

    if($records and is_array($records)) {
      $link_records = array();
      foreach($records as $record) {
        $link_records[$record['url']] = $record['clicks'];
      }

      return $link_records;
    }
    else {
      return false;
    }
  }

  public function get_split_conversions($start_timestamp,$end_timestamp,$link_id,$goal_link_id) {
    global $wpdb, $prli_click, $plp_link_rotation;

    $sdate = date("Y-n-j 00:00:00",$start_timestamp);
    $edate = date("Y-n-j 23:59:59",$end_timestamp);

    $query_str = "SELECT cr.url as url, COUNT(DISTINCT cl.vuid) as conversions " .
                   "FROM {$prli_click->table_name} cl " .
                   "JOIN {$plp_link_rotation->cr_table_name} cr ON cl.id=cr.click_id " .
                  "WHERE cl.link_id=%d" . $prli_click->get_exclude_where_clause( ' AND' ) . " " .
                    "AND cl.vuid IN (SELECT DISTINCT cl2.vuid " .
                                       "FROM {$prli_click->table_name} cl2 " .
                                       "WHERE cl2.link_id=%d " .
                                       "AND cl.created_at < cl2.created_at " .
                                       $prli_click->get_exclude_where_clause( ' AND','cl2' ) . ") " .
                    "AND cl.created_at BETWEEN %s AND %s " .
                  "GROUP BY cr.url";

    $query = $wpdb->prepare( $query_str, $link_id, $goal_link_id, $sdate, $edate );
    $records = $wpdb->get_results($query, ARRAY_A);

    if($records and is_array($records)) {
      $link_records = array();
      foreach($records as $record) {
        $link_records[$record['url']] = $record['conversions'];
      }

      return $link_records;
    }
    else {
      return false;
    }
  }

  public function split_test_chart_data($start_timestamp, $end_timestamp, $link_id, $title_only = false) {
    global $wpdb, $prli_utils, $prli_link, $prli_link_meta, $prli_click;

    $link  = $prli_link->getOne($link_id);
    $links = $this->get_split_report_links_array($link_id);
    $goal_link_id = $prli_link_meta->get_link_meta($link_id, 'prli-split-test-goal-link', true);

    $labels_array  = $links;
    $hits_array    = $this->get_split_clicks($start_timestamp, $end_timestamp, $link_id);
    $uniques_array = $this->get_split_clicks($start_timestamp, $end_timestamp, $link_id, true);

    $hits = array();
    $uniques = array();
    for($i=0;$i<count($links);$i++) {
      $hits[$i]    = ((is_array($hits_array) and isset($hits_array[$links[$i]]) and !empty($hits_array[$links[$i]]))?$hits_array[$links[$i]]:0);
      $uniques[$i] = ((is_array($uniques_array) and isset($uniques_array[$links[$i]]) and !empty($uniques_array[$links[$i]]))?$uniques_array[$links[$i]]:0);
    }

    if($title_only) {
      return __("Pretty Links Pro: Split Report for", 'pretty-link')." ".stripslashes($link->name)." ".__("between", 'pretty-link')." ".date("Y-n-j",$start_timestamp).' '.__('and', 'pretty-link').' '.date("Y-n-j", $end_timestamp);
    }

    //Setup conversions
    if(!empty($goal_link_id) and $goal_link_id) {
      $conversions_array = $this->get_split_conversions($start_timestamp, $end_timestamp, $link_id, $goal_link_id);
      $conversions = array();

      for($i = 0; $i < count($links); $i++) {
        $conversions[$i] = ((is_array($conversions_array) and isset($conversions_array[$links[$i]]) and !empty($conversions_array[$links[$i]]))?$conversions_array[$links[$i]]:0);
      }

      $chart_data = array('cols' => array(array("label" => __('Rotation', 'pretty-link'), 'type' => 'string'), array("label" => __('All Clicks', 'pretty-link'), 'type' => 'number'), array("label" => __('Unique Clicks', 'pretty-link'), 'type' => 'number'), array("label" => __('Conversions', 'pretty-link'), 'type' => 'number')));

      foreach($labels_array as $key => $value) {
        $chart_data['rows'][] = array('c' => array(array('v' => $value, 'f' => null), array('v' => (int)$hits[$key], 'f' => null), array('v' => (int)$uniques[$key], 'f' => null), array('v' => (int)$conversions[$key], 'f' => null)));
      }
    }
    else { //Setup the clicks w/out conversions
      $chart_data = array('cols' => array(array("label" => __('Rotation', 'pretty-link'), 'type' => 'string'), array("label" => __('All Clicks', 'pretty-link'), 'type' => 'number'), array("label" => __('Unique Clicks', 'pretty-link'), 'type' => 'number')));

      foreach($labels_array as $key => $value) {
        $chart_data['rows'][] = array('c' => array(array('v' => $value, 'f' => null), array('v' => (int)$hits[$key], 'f' => null), array('v' => (int)$uniques[$key], 'f' => null)));
      }
    }

    return $chart_data;
  }

  private function common_report_vars() {
    global $prli_siteurl, $prli_utils;

    $params = $this->get_params_array();
    $first_click = $prli_utils->getFirstClickDate();

    // Adjust for the first click
    if(isset($first_click)) {
      $min_date = (int)((time()-$first_click)/60/60/24);

      if($min_date < 30) {
        $start_timestamp = $prli_utils->get_start_date($params,$min_date);
      }
      else {
        $start_timestamp = $prli_utils->get_start_date($params,30);
      }

      $end_timestamp = $prli_utils->get_end_date($params);
    }
    else {
      $min_date = 0;
      $start_timestamp = time();
      $end_timestamp = time();
    }

    return array(
      'id' => $params['id'],
      'first_click' => $first_click,
      'min_date' => ($min_date * -1),
      'start_timestamp' => $start_timestamp,
      'end_timestamp' => $end_timestamp
    );
  }

  /* Add header to prli-custom-report page */
  public function custom_report_vars() {
    $vars = $this->common_report_vars();

    extract($vars);

    $report = $this->getOne($id);
    $data   = $this->setupClicksByLinkBarGraph($start_timestamp, $end_timestamp, $id);
    $title  = $this->setupClicksByLinkBarGraph($start_timestamp, $end_timestamp, $id, true);

    return array_merge(
      compact( 'title', 'data', 'report' ),
      $vars
    );
  }

  /* Add header to prli-split-test-report page */
  public function split_test_report_vars() {
    global $prli_link;

    $vars = $this->common_report_vars();

    extract($vars);

    $link  = $prli_link->getOne($id);
    $data  = $this->split_test_chart_data($start_timestamp, $end_timestamp, $id);
    $title = $this->split_test_chart_data($start_timestamp, $end_timestamp, $id, true);

    return array_merge(
      compact( 'title', 'data', 'link' ),
      $vars
    );
  }
}

