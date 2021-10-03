<?php
add_action('wp_ajax_wqnew_entry', 'wqnew_entry_callback_function');
add_action('wp_ajax_nopriv_wqnew_entry', 'wqnew_entry_callback_function');

function wqnew_entry_callback_function() {
  global $wpdb;
  $wpdb->get_row( "SELECT * FROM `wp_reseller` WHERE `mail` = '".$_POST['mail']."' ORDER BY `id` DESC" );
  if($wpdb->num_rows < 1) {
    $wpdb->insert("wp_reseller", array(
      "resellerRS" => $_POST['resellerRS'],
      "name" => $_POST['name'],
      "surname" => $_POST['surname'],
      "mail" => $_POST['mail'],
      "tel" => $_POST['tel'],
      "passCatalogue" => MD5($_POST['passCatalogue']),
      "created_at" => time(),
      "updated_at" => time()
    ));

    $response = array('message'=>'Data Has Inserted Successfully', 'rescode'=>200);
  } else {
    $response = array('message'=>'Data Has Already Exist', 'rescode'=>404);
  }
  echo json_encode($response);
  exit();
  wp_die();
}



add_action('wp_ajax_wqedit_entry', 'wqedit_entry_callback_function');
add_action('wp_ajax_nopriv_wqedit_entry', 'wqedit_entry_callback_function');

function wqedit_entry_callback_function() {
  global $wpdb;
  $wpdb->get_row( "SELECT * FROM `wp_reseller` WHERE `title` = '".$_POST['wqtitle']."' AND `description` = '".$_POST['wqdescription']."' AND `id`!='".$_POST['wqentryid']."' ORDER BY `id` DESC" );
  if($wpdb->num_rows < 1) {
    if($_POST['passCatalogue']!=""){
      $wpdb->update( "wp_reseller", array(
        "resellerRS" => $_POST['resellerRS'],
        "name" => $_POST['name'],
        "surname" => $_POST['surname'],
        "mail" => $_POST['mail'],
        "tel" => $_POST['tel'],
        "passCatalogue" => MD5($_POST['passCatalogue']),
        "updated_at" => time()
      ), array('id' => $_POST['wqentryid']) );
    }
    else{
      $wpdb->update( "wp_reseller", array(
        "resellerRS" => $_POST['resellerRS'],
        "name" => $_POST['name'],
        "surname" => $_POST['surname'],
        "mail" => $_POST['mail'],
        "tel" => $_POST['tel'],
        "updated_at" => time()
      ), array('id' => $_POST['wqentryid']) );
    }
    

    $response = array('message'=>'Data Has Updated Successfully', 'rescode'=>200);
  } else {
    $response = array('message'=>'Data Has Already Exist', 'rescode'=>404);
  }
  echo json_encode($response);
  exit();
  wp_die();
}
