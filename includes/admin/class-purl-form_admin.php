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
    add_action('admin_menu', array($this, 'admin_menu'));
    add_action('admin_init', array($this, 'admin_scripts_style'));
  }

  /**
   *
   */
  public function admin_scripts_style() {
   if (isset($_REQUEST['page'])) {
     if ($_REQUEST['page'] == "purl-form") {
        wp_enqueue_script('jquery');
        wp_enqueue_script('purlformJS',  plugins_url() . "/purl-form/assets/js/purl-form.js" );
        wp_enqueue_script('datatables, //cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js');
      }
    }
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
       add_action( 'wp_ajax_my_action', 'purlform_action' );
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
