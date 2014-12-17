<?php
/*Controls custom field creation in the dashboard area*/
global $wpdb;
$textdomain = 'custom-registration-form-with-submission-manager';
$crf_option=$wpdb->prefix."crf_option";
$path =  plugin_dir_url(__FILE__); 
if(isset($_REQUEST['saveoption']))
{
	if(!isset($_REQUEST['enable_captcha'])) $_REQUEST['enable_captcha']='no';
	if(!isset($_REQUEST['autogenerate_pass'])) $_REQUEST['autogenerate_pass']='no';
	if(!isset($_REQUEST['user_auto_approval'])) $_REQUEST['user_auto_approval']='no';
	crf_add_option( 'enable_captcha', $_REQUEST['enable_captcha']);
	crf_add_option( 'public_key', $_REQUEST['publickey']);
	crf_add_option( 'private_key', $_REQUEST['privatekey']);
	crf_add_option( 'autogeneratedepass', $_REQUEST['autogenerate_pass']);
	crf_add_option( 'userautoapproval', $_REQUEST['user_auto_approval']);	
}

$qry="SELECT `value` FROM $crf_option WHERE fieldname='public_key'";
$public_key = $wpdb->get_var($qry);
$qry="SELECT `value` FROM $crf_option WHERE fieldname='private_key'";
$private_key = $wpdb->get_var($qry);
?>

<div class="crf-main-form">
  <div class="crf-form-heading">
    <h1><?php _e( 'Form Settings', $textdomain ); ?></h1>
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
          <?php _e( 'User Registration Auto approval:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input name="user_auto_approval" id="user_auto_approval" type="checkbox" class="upb_toggle" value="yes" <?php if (checkfieldname("userautoapproval","yes")==true){ echo "checked";}?> style="display:none;"/>
        <label for="user_auto_approval"></label>
      </div>
    </div>
    <br>
    <br>
    <div class="crf-form-footer">
      <div class="crf-form-button">
        <input type="submit"  class="button-primary" value="Save" name="saveoption" id="saveoption" />
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