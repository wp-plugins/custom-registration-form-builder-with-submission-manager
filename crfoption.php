<?php
/*Controls custom field creation in the dashboard area*/
global $wpdb;
$textdomain = 'custom-registration-form-pro-with-submission-manager';
$crf_option=$wpdb->prefix."crf_option";
$path =  plugin_dir_url(__FILE__); 
if(isset($_REQUEST['saveoption']))
{
	if(!isset($_REQUEST['enable_captcha'])) $_REQUEST['enable_captcha']='no';
	if(!isset($_REQUEST['autogenerate_pass'])) $_REQUEST['autogenerate_pass']='no';
	if(!isset($_REQUEST['user_auto_approval'])) $_REQUEST['user_auto_approval']='yes';
	if(!isset($_REQUEST['admin_notification'])) $_REQUEST['admin_notification']='no';
	if(!isset($_REQUEST['userip'])) $_REQUEST['userip']='no';
	crf_add_option( 'enable_captcha', $_REQUEST['enable_captcha']);
	crf_add_option( 'public_key', $_REQUEST['publickey']);
	crf_add_option( 'private_key', $_REQUEST['privatekey']);
	crf_add_option( 'autogeneratedepass', $_REQUEST['autogenerate_pass']);
	crf_add_option( 'userautoapproval', $_REQUEST['user_auto_approval']);
	crf_add_option( 'adminnotification', $_REQUEST['admin_notification']);
	crf_add_option( 'adminemail', $_REQUEST['admin_email']);
	crf_add_option( 'from_email', $_REQUEST['from_email']);	
	crf_add_option( 'userip', $_REQUEST['userip']);	
}

$qry="SELECT `value` FROM $crf_option WHERE fieldname='public_key'";
$public_key = $wpdb->get_var($qry);
$qry="SELECT `value` FROM $crf_option WHERE fieldname='private_key'";
$private_key = $wpdb->get_var($qry);
$qry="SELECT `value` FROM $crf_option WHERE fieldname='adminemail'";
$admin_email = $wpdb->get_var($qry);
$qry="SELECT `value` FROM $crf_option WHERE fieldname='from_email'";
$from_email = $wpdb->get_var($qry);
?>

<div class="crf-main-form">
  <div class="crf-form-heading">
    <h1><?php _e( 'Global Settings', $textdomain ); ?></h1>
  </div>
  <form method="post">
    <div class="option-main crf-form-setting">
      <div class="user-group crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Enable Recaptcha:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input name="enable_captcha" id="enable_captcha" type="checkbox" class="upb_toggle" value="yes" <?php if (checkfieldname("enable_captcha","yes")==true){ echo "checked";}?> style="display:none;"/>
        <label for="enable_captcha"></label>
      </div>
    </div>
    <div class="option-main ">
      <div id="captcha_fun" <?php if (checkfieldname("enable_captcha","yes")==true){ echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
        <div class="option-main crf-form-setting">
          <div class="user-group crf-form-left-area">
            <div class="crf-label">
              <?php _e( 'Public Key:', $textdomain ); ?>
            </div>
          </div>
          <div class="user-group-option crf-form-right-area">
            <input type="text" name="publickey" id="publickey" value="<?php if(isset($public_key)) echo $public_key; ?>" />
          </div>
        </div>
        <div class="option-main crf-form-setting">
          <div class="user-group crf-form-left-area">
            <div class="crf-label">
              <?php _e( 'Private Key:', $textdomain ); ?>
            </div>
          </div>
          <div class="user-group-option crf-form-right-area">
            <input type="text" name="privatekey" id="privatekey" value="<?php if(isset($private_key)) echo $private_key; ?>" />
          </div>
        </div>
      </div>
    </div>
    <div class="option-main crf-form-setting">
      <div class="user-group crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Auto Generated Password:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input name="autogenerate_pass" id="autogenerate_pass" type="checkbox" class="upb_toggle" value="yes" <?php if (checkfieldname("autogeneratedepass","yes")==true){ echo "checked";}?> style="display:none;" />
        <label for="autogenerate_pass"></label>
      </div>
    </div>
    
    <div class="option-main crf-form-setting">
      <div class="user-group crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Capture IP and Browser Info:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input name="userip" id="userip" type="checkbox" class="upb_toggle" value="yes" <?php if (checkfieldname("userip","yes")==true){ echo "checked";}?> style="display:none;" />
        <label for="userip"></label>
      </div>
    </div>
    
    <div class="option-main crf-form-setting">
      <div class="user-group crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Admin Email Notification:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input name="admin_notification" id="admin_notification" type="checkbox" class="upb_toggle" value="yes" <?php if (checkfieldname("adminnotification","yes")==true){ echo "checked";}?> style="display:none;"/>
        <label for="admin_notification"></label>
      </div>
    </div>
         <div id="notification_fun" <?php if (checkfieldname("adminnotification","yes")==true){ echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
    <div class="option-main crf-form-setting">
      <div class="user-group crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Admin Email:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input type="text" name="admin_email" id="admin_email" value="<?php if(isset($admin_email)) echo $admin_email; ?>" />
      </div>
    </div>
    </div>
    
    <div class="option-main crf-form-setting">
      <div class="user-group crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'From Email:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input type="text" name="from_email" id="from_email" value="<?php if(isset($from_email)) echo $from_email; ?>" />
      </div>
    </div>
    
    <br>
    <br>
    <div class="crf-form-footer">
      <div class="crf-form-button">
        <input type="submit"  class="button-primary" value="Save" name="saveoption" id="saveoption" />
        <a href="admin.php?page=crf_manage_forms" class="cancel_button">Cancel</a>
      </div>
    </div>
  </form>
</div>
<script>
jQuery( "#enable_captcha" ).click(function() {
 a = jQuery(this).is(':checked'); 
 if(a==true)
 {
	jQuery("#captcha_fun").show(500); 
 }
 else
 {
	jQuery("#captcha_fun").hide(500); 
 }
});
</script>

<script>
jQuery( "#admin_notification" ).click(function() {
 a = jQuery(this).is(':checked'); 
 if(a==true)
 {
	jQuery("#notification_fun").show(500); 
 }
 else
 {
	jQuery("#notification_fun").hide(500); 
 }
});
</script>

<?php
function crf_add_option($fieldname,$value)
{
  global $wpdb;
  $crf_option=$wpdb->prefix."crf_option";
  $update="update $crf_option set `value`='".$value."' where fieldname='".$fieldname."'";
  $wpdb->query($update);
}

function checkfieldname($fieldname,$value)
{
	global $wpdb;
	$crf_option=$wpdb->prefix."crf_option";
	$select="select `value` from $crf_option where fieldname='".$fieldname."' and `value`='".$value."'";
	$data = $wpdb->get_var($select);
	
	if($data==$value)
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>