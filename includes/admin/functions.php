<?php

/**
 *  Functions
 *  Create dropdown list of webforms
 *
 */

// Test
$posts      = get_posts();
$pages      = get_pages();


$postOptions = '<option value=0> -- Choose Post -- </option>';
$pageOptions = '<option value=0> -- Choose Page -- </option>';


// $postArray = array();
foreach ($posts as $key => $value) {
  $postOptions .= '<option value="' . $value->ID . '">' .$value->post_title . '</option>';
  // $pageArray[$value->ID] = $value->post_title;
}
foreach ($pages as $key => $value) {
  $pageOptions .= '<option value="' . $value->ID . '">' .$value->post_title . '</option>';
}


