<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/**
 *  PurlForm
 *  Admin Class
 *  Presents admin form for creating PURL's
 */
class PurlForm_Admin {

  /**
   *
   */
  public function __construct() {
    add_action('admin_menu', array( $this, 'admin_menu'));
  }

  /**
   *
   */
  public function admin_scripts_style() {

  }

  /**
   *
   */
  public function admin_menu() {
    $page = add_management_page('Purl Form', 'Purl Form ', 'manage_options', 'purl-form', array( $this,'wp_purlform_settings_page'));
  }

  /**
   *
   */
  function wp_purlform_admin_init() {
    if(is_admin()){

    }
  }

  /**
   *
   */
  public function wp_purlform_settings_page(){
    include('functions.php');
    include('purl-form_admin.tpl.php');
  }


}

return new PurlForm_Admin();
