<?php
global $wpdb;
$textdomain = 'custom-registration-form-pro-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$crf_fields =$wpdb->prefix."crf_fields";
$path =  plugin_dir_url(__FILE__); 
if(isset($_POST['list_order']))
{
	// get the list of items id separated by cama (,)
	$list_order = $_POST['list_order'];
	// convert the string list to an array
	$list = explode(',' , $list_order);
	$i = 1 ;
	foreach($list as $id) {
		$qry= "update $crf_fields set Ordering=$i where Id=$id";
		$row = $wpdb->query($qry);
		$i++;
	}
}
?>