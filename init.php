<?php
/*
Plugin Name: Catalogue PDF Casapro 
Plugin URI: https://github.com/Chaabaniatef/catalogueList
Description: A Plugin For WordPress catalogue ( Create, Read, Update & Delete ) Application Using Ajax & WP List Table
Author: Atef Chaabani
Author URI: https://github.com/Chaabaniatef
Version: 1.0.0
*/

global $wpdb;
define('CATALOGUE_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('CATALOGUE_PLUGIN_PATH', plugin_dir_path( __FILE__ ));

register_activation_hook( __FILE__, 'activate_catalogue_plugin_function' );
register_deactivation_hook( __FILE__, 'deactivate_catalogue_plugin_function' );

function activate_catalogue_plugin_function() {
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $table_name = 'wp_catalogue';

  $sql = "CREATE TABLE $table_name (
    `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
    `titleCatalogue` varchar(255),
    `urlPdf` varchar(255),
    `desc` varchar(255),
    `urlImage` varchar(255),
    
    `created_at` varchar(255),
    `updated_at` varchar(255),
    PRIMARY KEY  (id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
}

function deactivate_catalogue_plugin_function() {
  global $wpdb;
  $table_name = 'wp_catalogue';
  $sql = "DROP TABLE IF EXISTS $table_name";
  $wpdb->query($sql);
}

function CatalogueLoad_custom_css_js() {
  wp_register_style( 'Cataloguemy_custom_css', CATALOGUE_PLUGIN_URL.'/css/style.css', false, '1.0.0' );
  wp_enqueue_style( 'Cataloguemy_custom_css' );
  wp_enqueue_script( 'Cataloguemy_custom_script2', CATALOGUE_PLUGIN_URL. '/js/jQuery.min.js' );
  wp_enqueue_script( 'Cataloguemy_custom_script1', CATALOGUE_PLUGIN_URL. '/js/custom.js' );

  wp_localize_script( 'Cataloguemy_custom_script1', 'ajax_var', array( 'ajaxurl' => admin_url('admin-ajax.php') ));
}
add_action( 'admin_enqueue_scripts', 'CatalogueLoad_custom_css_js' );

require_once(CATALOGUE_PLUGIN_PATH.'/ajax/ajax_action.php');

add_action('admin_menu', 'CatalogueMy_menu_pages');
function CatalogueMy_menu_pages(){
 

    add_menu_page('CATALOGUE', 'Catalogue CasaPro', 'manage_options', 'new-entry-catalogue', 'catalogueMy_menu_output' ,'dashicons-category',5);
    add_submenu_page('new-entry-catalogue', 'CATALOGUE Application', 'Nouveau', 'manage_options', 'new-entry-catalogue', 'catalogueMy_menu_output' );
    add_submenu_page('new-entry-catalogue', 'CATALOGUE Application', 'Liste catalogue', 'manage_options', 'view-entries-catalogue', 'catalogue_my_submenu_output' );


}

function catalogueMy_menu_output() {
  require_once(CATALOGUE_PLUGIN_PATH.'/admin-templates/new_entryCatalogue.php');
}

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class CatalogueEntryListTable extends WP_List_Table {

    function __construct() {
      global $status, $page;
      parent::__construct(array(
        'singular' => 'Entry Data',
        'plural' => 'Entry Datas',
      ));
    }

    function column_default($item, $column_name) {
        switch($column_name){
          case 'action': echo '<a href="'.admin_url('admin.php?page=new-entry&entryid='.$item['id']).'">Edit</a>';
        }
        return $item[$column_name];
    }

    function column_feedback_name($item) {
      $actions = array( 'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id']) );
      return sprintf('%s %s', $item['id'], $this->row_actions($actions) );
    }

    function column_cb($item) {
      return sprintf( '<input type="checkbox" name="id[]" value="%s" />', $item['id'] );
    }

    function get_columns() {
      $columns = array(
        'cb' => '<input type="checkbox" />',
			  'resellerRS'=> 'Raison Social',
        'name'=> 'Prénom responsable',
        'surname'=> 'Nom responsable',
        'mail'=> 'E-mail',
        'tel'=> 'Téléphone',
        'action' => 'Action'
      );
      return $columns;
    }

    function get_sortable_columns() {
      $sortable_columns = array(
        'resellerRS' => array('resellerRS', true)
      );
      return $sortable_columns;
    }

    function get_bulk_actions() {
      $actions = array( 'delete' => 'Delete' );
      return $actions;
    }

    function process_bulk_action() {
      global $wpdb;
      $table_name = "wp_catalogue";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);
            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    function prepare_items() {
      global $wpdb,$current_user;

      $table_name = "wp_catalogue";
		  $per_page = 10;
      $columns = $this->get_columns();
      $hidden = array();
      $sortable = $this->get_sortable_columns();
      $this->_column_headers = array($columns, $hidden, $sortable);
      $this->process_bulk_action();
      $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

      $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
      $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
      $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

		  if(isset($_REQUEST['s']) && $_REQUEST['s']!='') {
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE `resellerRS` LIKE '%".$_REQUEST['s']."%' OR `tel` LIKE '%".$_REQUEST['s']."%' OR `mail` LIKE '%".$_REQUEST['s']."%' OR `name` LIKE '%".$_REQUEST['s']."%' OR `surname` LIKE '%".$_REQUEST['s']."%' ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged * $per_page), ARRAY_A);
		  } else {
			  $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged * $per_page), ARRAY_A);
		  }

      $this->set_pagination_args(array(
        'total_items' => $total_items,
        'per_page' => $per_page,
        'total_pages' => ceil($total_items / $per_page)
      ));
    }
}

function catalogue_my_submenu_output() {
  global $wpdb;
  $table = new CatalogueEntryListTable();
  $table->prepare_items();
  $message = '';
  if ('delete' === $table->current_action()) {
    $message = '<div class="div_message" id="message"><p>' . sprintf('Items deleted: %d', count($_REQUEST['id'])) . '</p></div>';
  }
  ob_start();
?>
  <div class="wrap wqmain_body">
    <h3>Liste Catalogue</h3>
    <?php echo $message; ?>
    <form id="entry-table" method="GET">
      <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
      <?php $table->search_box( 'search', 'search_id' ); $table->display() ?>
    </form>
  </div>
<?php
  $wq_msg = ob_get_clean();
  echo $wq_msg;
}

add_shortcode( 'casaproCatalogue', 'wpcasaproCatalogue_shortcode' );
function wpcasaproCatalogue_shortcode() {
  global $wpdb;
  $loged=false;
  // $wpdb->get_row( "SELECT * FROM `wp_reseller`" );

  ob_start();

  ?>
  <script>
    function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
  </script>
  <?php 
 if (isset($_POST["email"]) && isset($_POST["pwd"]) ){
  $wpdb->get_row( "SELECT * FROM `wp_reseller` where mail='".$_POST["email"]."' and passCatalogue='".MD5($_POST["pwd"])."';" );
  
  if($wpdb->num_rows == 1) {
    // setcookie("isLoged", "true", time() + (86400 * 30 * 30), "/"); 
    // setcookie('isLoged', "true", time()+31556926);
    echo "<script> setCookie('isLoged', true, 365) </script>" ;
    $loged=true;
  } 
}
 if(!isset($_COOKIE["isLoged"]) || $loged==false )
  {
  
  ?>
  
  <form class=""  method="post">
    <input type="text" name="email"/>
    <input type="password" name="pwd"/>
    <input type="submit" name="submit" value="Connexion"/>

</form>
<?php 
  } else {
?>
 show list Catalogue 

 
  <?php
  echo do_shortcode( '[pdfviewer width="600px" height="849px" beta="false"]http://localhost/wordpress/wp-content/uploads/2019/06/sample.pdf[/pdfviewer]' );
}
  return ob_get_clean();
}

