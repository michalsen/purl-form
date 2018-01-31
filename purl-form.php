<?php
/*
Plugin Name: PurlForm
Plugin URI: http://localhost
Description: Creating Personalized URL's in Wordpress content since 1975.
Version:     1
Author: Eric L. Michalsen
Author URI:
Text Domain: wporg
Domain Path: /languages
License:     GPL2

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/


if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

// add_filter('template_redirect', 'purl_override' );

// function purl_override() {
//     global $wp_query;
//     print '<br><br><br><br>';
//     $check = check_purl(preg_replace('#/#', '', $_SERVER['REDIRECT_URL']));
//     print $check[0]->page . '<br>';
//     print $check[0]->post . '<br>';
//     print $check[0]->quote . '<br>';

//     if ('test') {
//         status_header( 200 );
//         $wp_query->is_404=TRUE;
//     }
// }

if(admin){
  include_once( 'includes/admin/class-purl-form_admin.php' );
}

register_activation_hook( __FILE__, 'purlform_create_db' );

add_action('wp_ajax_purlform_insert', 'purlform_insert');
add_action('wp_ajax_purlform_remove', 'purlform_remove');
add_action('wp_ajax_purlform_table', 'purlform_table');



function check_purl($purl) {
  global $wpdb;
  $table = $wpdb->prefix . 'purlform';

  $query = 'SELECT page, post, quote FROM ' . $table . ' WHERE link = "' . $purl . '"';
  $result = $wpdb->get_results($query, OBJECT);

  return $result;
}



function purlform_create_db() {
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $table_name = $wpdb->prefix . 'purlform';

  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    page smallint(5),
    post smallint(5),
    quote varchar(200),
    client varchar(200),
    link varchar(25),
    UNIQUE KEY id (id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
}


// REMOVE PURL
function purlform_remove(){
    if ($_REQUEST['action'] == 'purlform_remove') {
      global $wpdb;
      $table = $wpdb->prefix . "purlform";
      $wpdb->delete(
            $table,
            array(
                'id'   => $_REQUEST['data'][0]
            )
        );
    }
  print printTable();
  die();
  return true;
}


// INSERT FORM SUBMISSION
function purlform_insert(){
  global $wpdb;
    $table = $wpdb->prefix . "purlform";
    if ($_REQUEST['action'] == 'purlform_insert') {
      if ($_REQUEST['data'][1] <> NULL &&
          $_REQUEST['data'][0] <> NULL) {
        $hash = $_REQUEST['data'][1] . $_REQUEST['data'][2];
        $wpdb->insert(
            $table,
            array(
                'page'   => $_REQUEST['data'][1],
                'post'   => $_REQUEST['data'][0],
                'quote'  => $_REQUEST['data'][2],
                'client' => $_REQUEST['data'][3],
                'link'   => substr(md5($hash), 5, 8)
            )
        );
      }
    }
  print printTable();
  die();
  return true;
}


function printTable() {
  global $wpdb;
  $table = $wpdb->prefix . "purlform";
  $query = 'SELECT * FROM ' . $table;
  $result = $wpdb->get_results($query, OBJECT);
  $returnData = [];
  foreach ($result as $rows) {
    $returnData[] = [
                    $rows->id,
                   ($rows->page > 0 ? get_the_title($rows->page) : NULL),
                   ($rows->post > 0 ? get_the_title($rows->post) : NULL),
                   $rows->quote,
                   $rows->client,
                   site_url() . '/' . $rows->link];
       }
  return json_encode($returnData);
}


