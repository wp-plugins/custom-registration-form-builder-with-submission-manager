<?php
/*
	Plugin Name: Custom User Registration Form Builder
	Plugin URI: https://wordpress.org/plugins/custom-registration-form-builder-with-submission-manager/
	Description: An easy to use, simple but powerful registration form system that also tracks your registrations through a nifty interface. You can create unlimited forms with custom fields and use them through shortcode system.
	Version: 1.4.0
	Author: CMSHelpLive
	Author URI: https://profiles.wordpress.org/cmshelplive
	License: gpl2
*/
ob_start();
/*Plugin activation hook*/
global $crf_db_version;
$crf_db_version = 1.7;

register_activation_hook ( __FILE__, 'activate_custom_registration_form_with_sm_plugin' );
function activate_custom_registration_form_with_sm_plugin()
{
	add_option('crf_db_version','1.7');
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	$crf_option=$wpdb->prefix."crf_option";
	$crf_fields =$wpdb->prefix."crf_fields";
	$crf_forms =$wpdb->prefix."crf_forms";
	$crf_entries =$wpdb->prefix."crf_entries";
	$crf_stats = $wpdb->prefix."crf_stats";
	$sqlcreate = "CREATE TABLE IF NOT EXISTS $crf_stats
	(
		`id` int NOT NULL AUTO_INCREMENT,
			`form_id` int(11),
			`stats_key` varchar(255),
			`details` longtext,
			PRIMARY KEY(id)
	)";
	dbDelta( $sqlcreate );
	
	$sqlcreate = "CREATE TABLE IF NOT EXISTS $crf_option
	(
		`id` int NOT NULL AUTO_INCREMENT,
		`fieldname` varchar(255),
		`value` longtext,
		PRIMARY KEY(id)
	)";
	dbDelta( $sqlcreate );

	$insert="INSERT INTO $crf_option VALUES
		(1, 'enable_captcha', 'no'),
		(2, 'public_key', ''),
		(3, 'private_key', ''),
		(4, 'autogeneratedepass', 'no'),
		(5, 'userautoapproval', 'yes'),
		(6, 'adminemail', ''),
		(7, 'adminnotification', 'no'),
		(8, 'from_email', ''),
		(9, 'userip', 'yes'),
		(10, 'crf_theme','default')";
		$wpdb->query($insert);

	$sqlcreate = "CREATE TABLE IF NOT EXISTS $crf_entries
	(
		`id` int NOT NULL AUTO_INCREMENT,
		`form_id` int NOT NULL,
		`form_type` varchar(255),
		`user_approval` varchar(255),
		`value` longtext,
		 PRIMARY KEY (`id`)
	)";
	dbDelta( $sqlcreate );

	$sqlcreate = "CREATE TABLE IF NOT EXISTS $crf_forms (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) DEFAULT NULL,
  `form_desc` longtext,
  `form_type` varchar(255) NOT NULL,
  `custom_text` longtext,
  `crf_welcome_email_subject` varchar(255) NOT NULL,
  `success_message` varchar(255) NOT NULL,
  `crf_welcome_email_message` longtext,
  `redirect_option` varchar(255) NOT NULL,
  `redirect_page_id` int(11) NOT NULL,
  `redirect_url_url` longtext NOT NULL,
  `send_email` int(11) NOT NULL,
  `form_option` longtext,
  PRIMARY KEY (`id`)
)";
	dbDelta( $sqlcreate );
	
	$sqlcreate = "CREATE TABLE IF NOT EXISTS $crf_fields (
	  `Id` int(11) NOT NULL AUTO_INCREMENT,
	  `Form_Id` int(11) NOT NULL,
	  `Type` varchar(50) DEFAULT NULL,
	  `Name` varchar(256) NOT NULL,
	  `Value` longtext DEFAULT NULL,
	  `Class` varchar(256) DEFAULT NULL,
	  `Max_Length` varchar(256) DEFAULT NULL,
	  `Cols` varchar(256) DEFAULT NULL,
	  `Rows` varchar(256) DEFAULT NULL,
	  `Option_Value` varchar(256) DEFAULT NULL,
	  `Description` longtext DEFAULT NULL,
	  `Require` varchar(256) DEFAULT NULL,
	  `Readonly` varchar(256) DEFAULT NULL,
	  `Visibility` varchar(256) DEFAULT NULL,
	  `Ordering` int(11) DEFAULT NULL,
	  PRIMARY KEY (`Id`))";
	dbDelta( $sqlcreate );
}

add_action( 'plugins_loaded', 'crf_update_db_check' );
function crf_update_db_check()
{
	 global $crf_db_version;
	 global $wpdb;
	 $crf_option=$wpdb->prefix."crf_option";
	 $save_db_version =  floatval(get_site_option( 'crf_db_version','1.0' ));
    if ( $save_db_version < $crf_db_version ) 
	{	
		$insert="INSERT IGNORE INTO $crf_option VALUES
		(6, 'adminemail', ''),
		(7, 'adminnotification', 'no')";
		$wpdb->query($insert);
		
		$insert="INSERT IGNORE INTO $crf_option VALUES
		(8, 'from_email', '')";
		$wpdb->query($insert);
		
		$insert="INSERT IGNORE INTO $crf_option VALUES
		(9, 'userip', 'no')";
		$wpdb->query($insert);
		
		$qry="select `value` from $crf_option where fieldname='crf_theme'";
		$crf_theme = $wpdb->get_var($qry);
		
		if(isset($crf_theme) && $crf_theme!="")
		{
			if($crf_theme=='default')
			{
				$wpdb->query("update $crf_option set value='classic' where fieldname='crf_theme'");
			}
			else
			{
				$wpdb->query("update $crf_option set value='default' where fieldname='crf_theme'");	
			}
		}
		
		$insert="INSERT IGNORE INTO $crf_option VALUES
		(10, 'crf_theme', 'default')";
		$wpdb->query($insert);
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$crf_stats = $wpdb->prefix."crf_stats";
		$sqlcreate = "CREATE TABLE IF NOT EXISTS $crf_stats
		(
			`id` int NOT NULL AUTO_INCREMENT,
			`form_id` int(11),
			`stats_key` varchar(255),
			`details` longtext,
			PRIMARY KEY(id)
		)";
		dbDelta( $sqlcreate );
		
		$crf_forms =$wpdb->prefix."crf_forms";
		$crfform = $wpdb->get_row("SELECT * FROM $crf_forms");
		//Add column if not present.
		if(!isset($crfform->form_option)){
			$wpdb->query("ALTER TABLE $crf_forms ADD form_option longtext");
		}
		
		update_option( "crf_db_version", $crf_db_version );
		
	}
}

add_action( 'wp_enqueue_scripts', 'crf_frontend_script' );
add_action( 'admin_init', 'crf_admin_script' );
/*Defines enqueue style/ script for front end*/
function crf_frontend_script() {
	global $wpdb;
	$crf_option=$wpdb->prefix."crf_option";
	$qry="select `value` from $crf_option where fieldname='crf_theme'";
	$crf_theme = $wpdb->get_var($qry);
	wp_enqueue_style( 'crf-style-'.$crf_theme, plugin_dir_url(__FILE__) . 'css/crf-style-'.$crf_theme.'.css');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', 'http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css');
}
/*Defines enqueue style/ script for dashboard*/
function crf_admin_script() {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style( 'crf-admin.css', plugin_dir_url(__FILE__) . 'css/crf-admin.css');
	wp_enqueue_style( 'jquery-ui.css', 'http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_Script('jquery-ui-dialog');
	wp_enqueue_Script('jquery-ui-sortable');
	wp_register_style('crf_googleFonts', 'http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700');
    wp_enqueue_style( 'crf_googleFonts');
	wp_enqueue_script( 'ZeroClipboard.js',  plugin_dir_url(__FILE__) . 'js/ZeroClipboard.js');	
	wp_enqueue_script( 'jquery-ui-tooltip');
	wp_enqueue_style( 'crf_analytics', plugin_dir_url(__FILE__) . 'css/crf_analytics.css');
	wp_enqueue_script( 'crf_jsapi', 'https://www.google.com/jsapi');	
}

/*Defines menu and sub-menu items in dashboard*/
add_action('admin_menu', 'custom_registration_form_with_sm_menu');
function custom_registration_form_with_sm_menu()
{
	add_menu_page("Custom Registration Form","Custom Registration Form","manage_options","crf_manage_forms","crf_manage_forms",plugins_url('/images/profile-icon2.png', __FILE__),"28.01");
	add_submenu_page("","Add Form","Add Form","manage_options","crf_add_form","crf_add_form");
	add_submenu_page("crf_manage_forms","Settings","Settings","manage_options","crf_settings","crf_settings");
	add_submenu_page("crf_manage_forms","Submissions","Submissions","manage_options","crf_entries","crf_entries");
	add_submenu_page("","Manage Form Fields","Manage Form Fields","manage_options","crf_manage_form_fields","crf_manage_form_fields");
	add_submenu_page("","View Entry","View Entry","manage_options","crf_view_entry","crf_view_entry");
	add_submenu_page("","Add Field","Add Field","manage_options","crf_add_field","crf_add_field");
	add_submenu_page("crf_manage_forms","Upgrade","Upgrade","manage_options","crf_Pro","crf_Pro");
	add_submenu_page("crf_manage_forms","Analytics (Demo)","Analytics (Demo)","manage_options","analytics_demo","analytics_demo");
	add_submenu_page("crf_manage_forms","Support","Support","manage_options","crf_support","crf_support");
}

function add_crf_menu_adminbar() {
	global $wp_admin_bar;

	$wp_admin_bar->add_menu( array(
		'id'    => 'crf_add_form',
		'title' => 'Form',
		'href'  => admin_url().'admin.php?page=crf_add_form',
		'parent'=>'new-content'
	));
}
add_action( 'wp_before_admin_bar_render', 'add_crf_menu_adminbar' ); 

function crf_Pro()
{
	include 'pro_features.php';	
}

function analytics_demo()
{
	include 'crf_analytics.php';	
}

function crf_support()
{
	include 'crf_support.php';	
}

function crf_settings()
{
	include 'crfoption.php';
}

function crf_add_form()
{
	include 'add-form.php';	
}

function crf_add_field()
{
	include 'add_field.php';
}

function crf_view_entry()
{
	include 'view_entry.php';	
}

function crf_manage_forms()
{
	include 'manage-form.php';
}

function crf_entries()
{
	include 'manage_entries.php';
}

function crf_manage_form_fields()
{
	include 'manage-form-fields.php';
}

add_shortcode( 'CRF_Form', 'CRF_view_form_fun' );
function CRF_view_form_fun($content)
{
	global $wpdb;
	$crf_option=$wpdb->prefix."crf_option";
	$qry="select `value` from $crf_option where fieldname='crf_theme'";
	$crf_theme = $wpdb->get_var($qry);
	include 'view-form-'.$crf_theme.'.php';
}

add_action('wp_ajax_set_field_order', 'CRF_set_field_order');
add_action('wp_ajax_nopriv_set_field_order', 'CRF_set_field_order');
function CRF_set_field_order()
{
	global $wpdb;
	include('set_field_order.php');die;
}

add_action('wp_ajax_crf_ajaxcalls', 'CRF_ajaxcalls');
add_action('wp_ajax_nopriv_crf_ajaxcalls', 'CRF_ajaxcalls');
function CRF_ajaxcalls()
{
	global $wpdb;
	include('crf_ajaxCalls.php');
	die;
}

add_action('wp_ajax_check_crf_field_name', 'CRF_check_field_name');
add_action('wp_ajax_nopriv_check_crf_field_name', 'CRF_check_field_name');
function CRF_check_field_name()
{
	global $wpdb;
	include('check_crf_field_name.php');
	die;
}

add_action('wp_ajax_check_crf_form_name', 'CRF_check_form_name');
add_action('wp_ajax_nopriv_check_crf_form_name', 'CRF_check_form_name');
function CRF_check_form_name()
{
	global $wpdb;
	include('check_crf_form_name.php');
	die;
}

add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');
?>