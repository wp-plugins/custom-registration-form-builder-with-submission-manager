 <?php
/*Controls custom field creation in the dashboard area*/
global $wpdb;
$textdomain = 'custom-registration-form-pro-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$path =  plugin_dir_url(__FILE__); 
if(isset($_POST['submit_form']) && trim($_POST['form_name'])!="")
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'save_crf_add_form' ) ) die( 'Failed security check' );
	
	$formoptions = array();
	
	$formoptions['submit_button_label'] = $_POST['submit_button_label'];
	$formoptions['auto_expires'] = $_POST['auto_expires'];
	$formoptions['expiry_type'] = $_POST['expiry_type'];
	$formoptions['submission_limit'] = $_POST['submission_limit'];
	$formoptions['expiry_date'] = $_POST['expiry_date'];
	$formoptions['expiry_message'] = $_POST['expiry_message'];
	
	$options = maybe_serialize($formoptions);
	
	if(isset($_POST['form_id']) && $_POST['form_id']==0)
	{
	$qry = "insert into $crf_forms values('','".$_POST['form_name']."','".$_POST['form_des']."','".$_POST['form_type']."','".$_POST['form_custom_text']."','".$_POST['welcome_email_subject']."','".$_POST['success_message']."','".$_POST['welcome_email_message']."','".$_POST['redirect_option']."','".$_POST['page_id']."','".$_POST['redirect_url']."','".$_POST['send_email']."','".$options."')";	
	}
	else
	{
	$qry = "update $crf_forms set form_name = '".$_POST['form_name']."',form_desc='".$_POST['form_des']."',form_type='".$_POST['form_type']."',custom_text='".$_POST['form_custom_text']."',crf_welcome_email_subject='".$_POST['welcome_email_subject']."',success_message='".$_POST['success_message']."',crf_welcome_email_message='".$_POST['welcome_email_message']."',redirect_option='".$_POST['redirect_option']."',redirect_page_id='".$_POST['page_id']."',redirect_url_url='".$_POST['redirect_url']."',send_email='".$_POST['send_email']."',form_option='".$options."' where id='".$_POST['form_id']."'";	
	}
	$wpdb->query($qry);
	wp_redirect('admin.php?page=crf_manage_forms');exit;
}
if(isset($_REQUEST['id']))
{
	$qry = "select * from $crf_forms where id =".$_REQUEST['id'];
	$row = $wpdb->get_row($qry);
	$form_options = maybe_unserialize($row->form_option);
	$submit_button_label = $form_options['submit_button_label'];
	$auto_expires = $form_options['auto_expires'];
	$expiry_type = $form_options['expiry_type'];
	$submission_limit = $form_options['submission_limit'];
	$expiry_date = $form_options['expiry_date'];
	$expiry_message = $form_options['expiry_message'];
	
}
else
{
	$_REQUEST['id']=0;
}
?>
<div class="crf-main-form">
  <div class="crf-form-heading">
    <?php if(isset($_REQUEST['id']) && $_REQUEST['id']==0): ?>
    <h1><?php _e( 'New Form', $textdomain ); ?></h1>
    <?php else: ?>
    <h1><?php _e( 'Edit Form', $textdomain ); ?></h1>
    <?php endif; ?>
  </div>
  <form name="crf_form" id="crf_form" method="post">
    <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Type:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <label>
          <input type="radio" name="form_type" value="contact_form" id="RadioGroup1_0" <?php if(!empty($row) && $row->form_type=='contact_form') echo 'checked'; ?> required tabindex="1">
          <span><?php _e( 'Contact Form', $textdomain ); ?></span> </label>
        <label>
          <input name="form_type" type="radio" id="RadioGroup1_1" value="reg_form" <?php if(!empty($row) && $row->form_type=='reg_form') echo 'checked'; ?> tabindex="2">
          <span><?php _e( 'Registration Form', $textdomain ); ?></span></label>
      </div>
    </div>
    <div class="crf-form-setting" >
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Unique Name :', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <input type="text" name="form_name" id="form_name" value="<?php if(!empty($row)) echo $row->form_name; ?>" tabindex="3" required onKeyUp="check('<?php if(!empty($row)){echo $row->form_name;}else { echo 'new';} ?>')"/>
        <div id="user-result"></div>
      </div>
    </div>
    <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Form Description:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <textarea name="form_des" id="form_des" tabindex="4"><?php if(!empty($row))echo $row->form_desc; ?></textarea>
      </div>
    </div>
    <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Redirection:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <label>
          <input type="radio" name="redirect_option" id="redirect_option_page" value="none" onClick="showhideredirect(this.value)" <?php if(!empty($row) && $row->redirect_option=='none') echo 'checked'; ?> tabindex="5" required>
          <span><?php _e( 'None', $textdomain ); ?></span></label>
        <label>
          <input type="radio" name="redirect_option" id="redirect_option_page" value="page" tabindex="6" onClick="showhideredirect(this.value)" <?php if(!empty($row) && $row->redirect_option=='page') echo 'checked'; ?>>
          <span><?php _e( 'Page', $textdomain ); ?></span></label>
        <label>
          <input type="radio" name="redirect_option" id="redirect_option_url" value="url" tabindex="7" onClick="showhideredirect(this.value)" <?php if(!empty($row) && $row->redirect_option=='url') echo 'checked'; ?>>
          <span><?php _e( 'URL', $textdomain ); ?></span></label>
      </div>
    </div>
    <div class="crf-form-setting" id="page_html" style=" <?php if(!empty($row) && $row->redirect_option=='page'){echo 'display:block;';} else { echo 'display:none;';} ?>">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Page:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <?php 
if(!empty($row->redirect_page_id))
{
	$selected = $row->redirect_page_id;
}
else
{
	$selected = 0;
}
$args = array(
    'depth'            => 0,
    'child_of'         => 0,
    'selected'         => $selected,
    'echo'             => 1,
    'name'             => 'page_id'); ?>
        <?php wp_dropdown_pages($args); ?>
      </div>
    </div>
    <div class="crf-form-setting" id="url_html" style=" <?php if(!empty($row) && $row->redirect_option=='url'){ echo 'display:block;';} else{ echo 'display:none;';} ?>">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'URL:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <input type="text" id="redirect_url" name="redirect_url" tabindex="8" value="<?php if(!empty($row)) echo $row->redirect_url_url; ?>" />
      </div>
    </div>
    <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Header Text', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <textarea tabindex="9" name="form_custom_text" id="form_custom_text"><?php if(!empty($row))echo $row->custom_text; ?></textarea>
      </div>
    </div>
    <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Auto Responder:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <input name="send_email" id="send_email" type="checkbox" tabindex="10" class="upb_toggle" value="1" <?php if (!empty($row) && $row->send_email==1){ echo "checked";}?> style="display:none;" />
        <label for="send_email"></label>
      </div>
    </div>
    <div class="crf-form-setting autoresponder"  style="display:<?php if (!empty($row) && $row->send_email==1){ echo "block";}else {echo 'none';}?>">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Auto Responder Subject:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <input type="text" name="welcome_email_subject" id="welcome_email_subject" tabindex="11" value="<?php if(!empty($row)) echo $row->crf_welcome_email_subject; ?>" />
      </div>
    </div>
    <div class="crf-form-setting autoresponder" style="display:<?php if (!empty($row) && $row->send_email==1){ echo "block";}else {echo 'none';}?>">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Auto Responder Message:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <textarea name="welcome_email_message" id="welcome_email_message" tabindex="12" ><?php if(!empty($row)) echo $row->crf_welcome_email_message; ?></textarea>
      </div>
    </div>
    <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Success Message:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <textarea name="success_message" id="success_message" tabindex="13" required><?php if(!empty($row)) echo $row->success_message; ?></textarea>
      </div>
    </div>
    
        <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Submit Button Label:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
       <input type="text" name="submit_button_label" id="submit_button_label" tabindex="14" value="<?php if(isset($submit_button_label)) echo $submit_button_label;?>" />
      </div>
    </div>

<div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( ' Auto Expires?:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <input name="auto_expires" id="auto_expires" type="checkbox" tabindex="15" class="upb_toggle" value="1" <?php if(isset($auto_expires) && $auto_expires==1){ echo "checked";}?> style="display:none;" />
        <label for="auto_expires"></label>
      </div>
    </div>
	
    <div class="auto_expires_html"  style="display:<?php if(isset($auto_expires) && $auto_expires==1){ echo "block";}else {echo 'none';}?>">
    <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Expiry Type:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <label>
          <input type="radio" name="expiry_type" id="expiry_type_submission" value="submission" onClick="showhidelimitation(this.value)" <?php if(isset($expiry_type) && $expiry_type=='submission') echo 'checked'; ?> tabindex="16">
          <span><?php _e( 'By Submissions', $textdomain ); ?></span></label>
        <label>
          <input type="radio" name="expiry_type" id="expiry_type_date" value="date" tabindex="17" onClick="showhidelimitation(this.value)" <?php if(isset($expiry_type) && $expiry_type=='date') echo 'checked'; ?>>
          <span><?php _e( 'By Date', $textdomain ); ?></span></label>
        <label>
          <input type="radio" name="expiry_type" id="expiry_type_both" value="both" tabindex="18" onClick="showhidelimitation(this.value)" <?php if(isset($expiry_type) && $expiry_type=='both') echo 'checked'; ?>>
          <span><?php _e( 'Set Both <small>(Whichever is earlier)</small>', $textdomain ); ?></span></label>
      </div>
    </div>
    
    <div class="crf-form-setting" id="limitation_submission_html" style="display:<?php if(isset($expiry_type) && ($expiry_type=='submission' || $expiry_type=='both')) echo 'block'; else echo 'none';?>;">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Submissions Limit:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
         <input type="text" name="submission_limit" id="submission_limit" tabindex="19" value="<?php if(isset($submission_limit)) echo $submission_limit; ?>" class="crf_number" onBlur="check_number()" />
         <div class="crf_number_message" style="color:red;"></div>
      </div>
    </div>
    
    <div class="crf-form-setting" id="limitation_date_html" style="display:<?php if(isset($expiry_type) && ($expiry_type=='date' || $expiry_type=='both')) echo 'block'; else echo 'none';?>;">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Expiry Date:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
         <input type="text" name="expiry_date" id="expiry_date" tabindex="20" value="<?php if(isset($expiry_date)) echo $expiry_date; ?>" class="crf_date" onBlur="check_date()" />
         <div class="crf_date_message" style="color:red;"></div>
      </div>
    </div>
    
    <div class="crf-form-setting">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Message for visitor after Expiry', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
         <textarea name="expiry_message" id="expiry_message" tabindex="21"><?php if(isset($expiry_message)) echo $expiry_message; ?></textarea>
      </div>
    </div>
    
    </div>

    <div class="crf-form-footer">
      <div class="crf-form-button">
        <input type="hidden" name="form_id" id="form_id" value="<?php if(isset($_REQUEST['id'])) echo $_REQUEST['id']?>" />
        <?php wp_nonce_field('save_crf_add_form'); ?>
        <input type="submit" value="Save" name="submit_form" id="submit_form" tabindex="14" onClick="return validationform()"  />
        <input type="reset" />
        <a href="admin.php?page=crf_manage_forms" class="cancel_button">Cancel</a>
      </div>
    </div>
  </form>
</div>
<script>
function validationform()
{
	a = jQuery('.crf_number_message').html();
	b = jQuery('.crf_date_message').html();
	c = jQuery('#user-result').html();
	if(a=="" && b=="" && c=="")
	{
		return true;	
	}
	else
	{
		return false;	
	}
}
function check_number() {
	var number = jQuery('.crf_number').val();
	var isnumber = jQuery.isNumeric(number);
	if (isnumber == false && number != "") {
		jQuery('.crf_number_message').html('<?php _e('Please enter a valid number',$textdomain);?>');
		jQuery('.crf_number_message').show();
	}
	else
	{
		jQuery('.crf_number_message').html('');
		jQuery('.crf_number_message').hide();
	}
}

function check_date() {
            var date = jQuery('.crf_date').val();
			var datepattern = /^\d{4}-\d{2}-\d{2}$/;
 			 is_date = date.match(datepattern);
            if (is_date == null && date !="") {
                jQuery('.crf_date_message').html('<?php _e('Please enter a valid date(yyyy-mm-dd).',$textdomain);?>');
                jQuery('.crf_date_message').show();
            }
			else
			{
				jQuery('.crf_date_message').html('');
				jQuery('.crf_date_message').hide();
			}

}

jQuery(document).ready(function () {
        //for date picker
        jQuery('.crf_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
    function showhideredirect(a) {
        if (a == 'page') {
            jQuery('#page_html').show(500);
            jQuery('#url_html').hide(500);
        } else if (a == 'url') {
            jQuery('#page_html').hide(500);
            jQuery('#url_html').show(500);
        } else {
            jQuery('#page_html').hide(500);
            jQuery('#url_html').hide(500);
        }
    }
</script>

<script>
    function showhidelimitation(a) {
        if (a == 'submission') {
            jQuery('#limitation_submission_html').show(500);
            jQuery('#limitation_date_html').hide(500);
        } else if (a == 'date') {
            jQuery('#limitation_submission_html').hide(500);
            jQuery('#limitation_date_html').show(500);
        } else {
            jQuery('#limitation_submission_html').show(500);
            jQuery('#limitation_date_html').show(500);
        }
    }
	
	jQuery("#auto_expires").click(function () {
        a = jQuery(this).is(':checked');
        if (a == true) {
            jQuery(".auto_expires_html").show(500);
        } else {
            jQuery(".auto_expires_html").hide(500);
        }
    });
</script>

<script>
    jQuery("#send_email").click(function () {
        a = jQuery(this).is(':checked');
        if (a == true) {
            jQuery(".autoresponder").show(500);
        } else {
            jQuery(".autoresponder").hide(500);
        }
    });
</script>

<script type="text/javascript">
    function check(prev) {
        name = jQuery("#form_name").val();
        jQuery.post('<?php echo get_option('siteurl').'/wp-admin/admin-ajax.php';?>?action=check_crf_form_name&cookie=encodeURIComponent(document.cookie)', {
                'name': name,
                'prev': prev
            },
            function (data) {
                //make ajax call to check_username.php
                if (data == "") {
                    jQuery("#user-result").html('');
                    jQuery("#submit_form").show();
                } else {
                    jQuery("#user-result").html(data);
                    jQuery("#submit_form").hide();
                }
                //dump the data received from PHP page
            });
    }
</script>