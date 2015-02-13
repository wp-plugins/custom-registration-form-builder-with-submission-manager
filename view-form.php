<?php
/*Controls registration form behavior on the front end*/
global $wpdb;
$crf_option=$wpdb->prefix."crf_option";
$qry="select `value` from $crf_option where fieldname='crf_theme'";
$crf_theme = $wpdb->get_var($qry);
include 'view-form-'.$crf_theme.'.php';

