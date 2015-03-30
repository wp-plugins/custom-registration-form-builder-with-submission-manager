<?php
/*Controls custom field creation in the dashboard area*/
global $wpdb;
$textdomain = 'custom-registration-form-pro-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$path =  plugin_dir_url(__FILE__); 
?>
<style>
#support-feature{
	float: left;
    font-family: "Roboto",sans-serif;
    margin-left: 30px;
    margin-top: 35px;
    max-width: 883px;
    width: 100%;
}
#support-feature .support-top{
	background-color: #fff;
    box-shadow: 0 1px 2px -1px #c7c7c7;
	min-height:120px;
}
#support-feature .support-top h1{
	margin:0;
}
#support-feature .support-top .support-hedding-icon{
	background:url(<?php echo $path;?>images/support-hedding-icon.png) no-repeat left center;
	font-family: "Roboto",sans-serif;
    font-weight: 300;
	color: #78b0be;
	padding-top:20px;
	padding-left: 60px;
	padding-bottom:20px;
}
.hedding-boder{
	border-bottom:1px solid #efefef;
	padding-left:20px;
}
.support-available{
	margin-top:15px;
	box-shadow: 0 1px 2px -1px #c7c7c7;
	background-color: #fff;
	padding:20px;
}
.analytics-addon{
	border-top:1px solid #efefef;
	padding-top:20px;
}
.support-available ul li{
	float:none;
	list-style:none;
	margin-bottom:15px;
	display:block;
}
.support-available h3{
	color:#656565;
	font-weight:normal;
	margin-bottom:35px;
	margin-top:0;
}
a:active{
	outline:none;
}
a:focus{
	outline:none;
	box-shadow:none !important;
}
a:visited{
	outline:none;
}
.support-available ul li a{
	color:#ff6160;
	font-size:14px;
	font-weight:normal;
	text-decoration:none;
}
.analytics-addon a{
	color:#ff6160;
	font-size:14px;
	font-weight:normal;
	text-decoration:none;
	text-transform:uppercase;
}
</style>
<div id="support-feature">
<div class="support-top">
    <div class="hedding-boder">
    <h1 class="support-hedding-icon">Support, Feature Requests and Feedback</h1>
    </div>
</div>
<div class="support-available">
  <h3>Support is available through our forums. Here are the relevant links:</h3>
  <div class="link">
  <ul>
  <li><a href="http://cmshelplive.com/accounts/index.php?m=forum&action=viewboard&id=3" target="_blank">GENERAL QUESTIONS</a></li>
<li><a href="http://cmshelplive.com/accounts/index.php?m=forum&action=viewboard&id=6" target="_blank">INSTALLATION ISSUES</a></li>
<li><a href="http://cmshelplive.com/accounts/index.php?m=forum&action=viewboard&id=4" target="_blank">FEATURE REQUESTS</a></li>
<li><a href="http://cmshelplive.com/accounts/index.php?m=forum&action=viewboard&id=5" target="_blank">BUG REPORTS</a></li>
  </ul>
  </div>
  

</div>

</div>