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



if(admin){
  include_once( 'includes/admin/class-purl-form_admin.php' );
}

register_activation_hook( __FILE__, 'purlform_create_db' );

add_action('wp_ajax_purlform_insert', 'purlform_insert');
add_action('wp_ajax_purlform_table', 'purlform_table');



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


// INSERT FORM SUBMISSION
function purlform_insert(){
  global $wpdb;

    $table = $wpdb->prefix . "purlform";

    if (isset($_REQUEST['data'][2])) {
      $wpdb->insert(
            $table,
            array(
                'page'   => $_REQUEST['data'][1],
                'post'   => $_REQUEST['data'][0],
                'quote'  => $_REQUEST['data'][2],
                'client' => $_REQUEST['data'][3],
                'link'   => substr(md5($_REQUEST['data'][2]), 5, 8)
            )
        );
    }

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

  print json_encode($returnData);
  die();
  return true;
}



// PAINT SUBMISSION TABLE
// function purlform_table(){

//   global $wpdb;

//   $table = $wpdb->prefix . "purlform";
//   $query = 'SELECT * FROM ' . $table;
//   $result = $wpdb->get_results($query, OBJECT);

//   $dataTable = '<table id="static_table">';
//   $dataTable .= '<tr>';
//   $dataTable .= '<th>Remove</th>';
//   $dataTable .= '<th>Post</th>';
//   $dataTable .= '<th>Page</th>';
//   $dataTable .= '<th>Quote</th>';
//   $dataTable .= '<th>Client</th>';
//   $dataTable .= '<th>Link</th>';
//   $dataTable .= '</tr>';

//   foreach ($result as $rows) {
//     $data = [];
//     $data['page'] = get_the_title($rows->page);
//     $data['post'] = get_the_title($rows->post);

//     $dataTable .= '<tr>';
//     $dataTable .= '<td>';
//     $dataTable .= $rows->id;
//     $dataTable .= '</td><td>';
//     $dataTable .= ($rows->post > 0 ? $data['post'] : NULL);
//     $dataTable .= '</td><td>';
//     $dataTable .= ($rows->page > 0 ? $data['page'] : NULL);
//     $dataTable .= '</td><td>';
//     $dataTable .= $rows->quote;
//     $dataTable .= '</td><td>';
//     $dataTable .= $rows->client;
//     $dataTable .= '</td>';
//     $dataTable .= '</td><td>';
//     $dataTable .= site_url() . '/' . $rows->link;
//     $dataTable .= '</td>';
//     $dataTable .= '</tr>';
//   }
//   $dataTable .= '</table>';

//   print $dataTable;
//   die();
//   return true;
// }

