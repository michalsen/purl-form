<?php



global $wpdb;

print 'test2';
if (isset($_REQUEST['data'])) {
  $data = json_decode($_REQUEST['data']);

    print $data[0] . "<br>";
    print $data[1] . "<br>";
    print $data[2] . "<br>";
    print $data[3] . "<br>";

       $table = $wpdb->prefix . "purlform";

       print 'table2: ' . $table . "<br>";
       // $wpdb->insert(
       //        $table,
       //        array(
       //            'page'   => $data[0],
       //            'post'   => $data[1],
       //            'quote'  => $data[2],
       //            'client' => $data[3]
       //        )
       //    );
}
