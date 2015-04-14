<?php
global $wpdb;
$textdomain = 'custom-registration-form-pro-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$crf_fields =$wpdb->prefix."crf_fields";
$path =  plugin_dir_url(__FILE__); 
$qrylastrow = "select count(*) from $crf_fields where Form_Id = '".$_REQUEST['formid']."'"; 
$lastrow = $wpdb->get_var($qrylastrow);
$ordering = $lastrow+1;
if(isset($_REQUEST['type'])) $str = $_REQUEST['type'];
if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete')
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'delete_crf_field' ) ) die( 'Failed security check' );
	
	$qry = "delete from $crf_fields where Id=".$_REQUEST['id'];	
	$reg = $wpdb->query($qry);	
	wp_redirect('admin.php?page=crf_manage_form_fields&form_id='.$_REQUEST['formid']);exit;
}

if(isset($_REQUEST['id']))
{
	$qry="select * from $crf_fields where Id=".$_REQUEST['id'];	
	$reg = $wpdb->get_row($qry);
	$str = $reg->Type;
}

if(isset($_POST['field_submit']) && empty($_POST['field_id']))/*Saves the field after clicking save button*/
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'save_crf_add_field' ) ) die( 'Failed security check' );
	
$qry = "insert into $crf_fields values('','".$_POST['form_id']."','".$_POST['select_type']."','".$_POST['field_name']."','".$_POST['field_value']."','".$_POST['field_class']."','".$_POST['field_maxLenght']."','".$_POST['field_cols']."','".$_POST['field_rows']."','".$_POST['field_Options']."','".$_POST['field_Des']."','".$_POST['field_require']."','".$_POST['field_readonly']."','".$_POST['field_visibility']."','".$ordering."')";
$row = $wpdb->query($qry);	
wp_redirect('admin.php?page=crf_manage_form_fields&form_id='.$_POST['form_id']);exit;
}

if(isset($_POST['field_submit']) && !empty($_POST['field_id']))
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'save_crf_add_field' ) ) die( 'Failed security check' );
	
	$qry = "update $crf_fields set Form_Id='".$_POST['form_id']."',Type ='".$_POST['select_type']."',Name ='".$_POST['field_name']."',`Value` ='".$_POST['field_value']."',Class='".$_POST['field_class']."',Max_Length='".$_POST['field_maxLenght']."',Cols='".$_POST['field_cols']."',Rows='".$_POST['field_rows']."',Option_Value='".$_POST['field_Options']."',Description='".$_POST['field_Des']."',`Require`='".$_POST['field_require']."',Readonly='".$_POST['field_readonly']."',Visibility='".$_POST['field_visibility']."' where Id='".$_POST['field_id']."'";
$row = $wpdb->query($qry);	
wp_redirect('admin.php?page=crf_manage_form_fields&form_id='.$_POST['form_id']);exit;

}

?>
<script>
    jQuery(document).ready(function () {
        // Handler for .ready() called.
        getfields('<?php echo $str;?>');
    });
    /*Defines field parameters when selecting field type in drop down*/
    function getfields(a) {
            jQuery('#user_groupsfield').show();
            if (a == '') {
                jQuery('#namefield').hide();
                jQuery('#classfield').hide();
                jQuery('#desfield').hide();
                jQuery('#maxlenghtfield').hide();
                jQuery('#requirefield').hide();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').hide();
                jQuery('#readonlyfield').hide();
                jQuery('#registrationformfield').hide();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
                jQuery('#optionsfield').hide();
                jQuery('#valuefield').hide();
                jQuery('#submit_field').hide();
                jQuery('#orderingfield').hide();
                jQuery('#user_groupsfield').hide();
            }
            if (a == 'text' || a == 'password') {
                jQuery('#namefield').show();
                jQuery('#classfield').show();
                jQuery('#desfield').hide();
                jQuery('#maxlenghtfield').show();
                jQuery('#requirefield').show();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').show();
                jQuery('#readonlyfield').hide();
                jQuery('#registrationformfield').show();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
                jQuery('#optionsfield').hide();
                jQuery('#valuefield').hide();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
            }
            if (a == 'submit' || a == 'reset' || a == 'hidden') {
                jQuery('#namefield').show();
                jQuery('#classfield').show();
                jQuery('#valuefield').show();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
                jQuery('#desfield').hide();
                jQuery('#maxlenghtfield').hide();
                jQuery('#requirefield').hide();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').hide();
                jQuery('#readonlyfield').hide();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
                jQuery('#optionsfield').hide();
                jQuery('#registrationformfield').hide();
            }
            if (a == 'select' || a == 'radio' || a == 'checkbox') {
                jQuery('#namefield').show();
                jQuery('#classfield').show();
                jQuery('#optionsfield').show();
                jQuery('#desfield').hide();
                jQuery('#valuefield').show();
                jQuery('#requirefield').show();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').show();
                jQuery('#readonlyfield').show();
                jQuery('#registrationformfield').show();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
                jQuery('#maxlenghtfield').hide();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
            }
            if (a == 'select') {
                jQuery('#requirefield').show();
            }
            if (a == 'textarea') {
                jQuery('#namefield').show();
                jQuery('#classfield').show();
                jQuery('#desfield').hide();
                jQuery('#requirefield').show();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').show();
                jQuery('#readonlyfield').show();
                jQuery('#registrationformfield').show();
                jQuery('#colsfield').show();
                jQuery('#rowsfield').show();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
                jQuery('#maxlenghtfield').show();
                jQuery('#optionsfield').hide();
                jQuery('#valuefield').hide();
            }
            if (a == 'file') {
                jQuery('#namefield').show();
                jQuery('#classfield').show();
                jQuery('#desfield').hide();
                jQuery('#requirefield').hide();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').hide();
                jQuery('#readonlyfield').hide();
                jQuery('#registrationformfield').show();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
                jQuery('#maxlenghtfield').hide();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
                jQuery('#optionsfield').hide();
                jQuery('#valuefield').hide();
            }
            if (a == 'heading' || a == 'paragraph') {
                jQuery('#namefield').show();
                jQuery('#classfield').show();
                jQuery('#desfield').hide();
                jQuery('#requirefield').hide();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').hide();
                jQuery('#readonlyfield').hide();
                jQuery('#registrationformfield').show();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
                jQuery('#maxlenghtfield').hide();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
                jQuery('#optionsfield').hide();
                jQuery('#valuefield').show();
            }
            if (a == 'DatePicker' || a == 'term_checkbox') {
                jQuery('#namefield').show();
                jQuery('#classfield').hide();
                jQuery('#desfield').hide();
                jQuery('#requirefield').show();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').show();
                jQuery('#readonlyfield').hide();
                jQuery('#registrationformfield').show();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
                jQuery('#maxlenghtfield').hide();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
                jQuery('#optionsfield').hide();
                jQuery('#valuefield').hide();
            }
			/*file addon start */
			if(a=='file')
			{
				jQuery('#optionsfield .crf-label').html('Define allowed file types (file extensions). <small style="float:left;">(Separate multiple values by “|”. For example PDF|JPEG|XLS)</small>');
				jQuery('#optionsfield').show();
				
			}
			
			if(a != 'file')
			{
				jQuery('#optionsfield .crf-label').html('Options: <small style="float:left;">(value seprated by comma ",")</small>');	
			}
			/*file addon end */
            if (a != 'term_checkbox') {
                jQuery('#desfield label').html('Description');
                jQuery('#namefield label').html('Label');
                jQuery('.info').hide();
            }
			
            if (a == 'term_checkbox') {
                jQuery('#desfield .crf-label').html('<?php _e( 'Terms & Conditions', $textdomain ); ?>');
                jQuery('#namefield .crf-label').html('<?php _e( 'Name', $textdomain ); ?>');
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').hide();
                jQuery('#readonlyfield').hide();
                jQuery('#registrationformfield').hide();
                jQuery('.info').html('Use this checkbox field for adding Terms & Conditions to the registration form.');
                jQuery('.info').show();
				jQuery('#desfield').show();
            }
            if (a == 'heading') {
                jQuery('.info').html('This Heading field is working only for "Registration" and "Edit Profile" page.');
                jQuery('.info').show();
            }
            if (a == 'paragraph') {
                jQuery('.info').html('This Paragraph field is working only for "Registration" and "Edit Profile" page.');
				jQuery('#optionsfield .crf-label').html('Paragraph Text');
				jQuery('#valuefield').hide();
				jQuery('#optionsfield').show();
                jQuery('.info').show();
            }
            if (a == 'email' || a == 'number') {
                jQuery('#namefield').show();
                jQuery('#classfield').show();
                jQuery('#desfield').hide();
                jQuery('#requirefield').show();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').show();
                jQuery('#readonlyfield').hide();
                jQuery('#registrationformfield').show();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
                jQuery('#maxlenghtfield').hide();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
                jQuery('#optionsfield').hide();
                jQuery('#valuefield').hide();
            }
			if (a == 'country' || a=='timezone') {
                jQuery('#namefield').show();
                jQuery('#classfield').show();
                jQuery('#desfield').hide();
                jQuery('#requirefield').show();
                jQuery('#visibilityfield').hide();
                jQuery('#rulesfield').show();
                jQuery('#readonlyfield').hide();
                jQuery('#registrationformfield').show();
                jQuery('#submit_field').show();
                jQuery('#orderingfield').show();
                jQuery('#maxlenghtfield').hide();
                jQuery('#colsfield').hide();
                jQuery('#rowsfield').hide();
                jQuery('#optionsfield').hide();
                jQuery('#valuefield').hide();
            }
			if (a == 'text') {
                jQuery('#valuefield').show();
            }
        }
        /*Field selection ends*/
</script>
<style>
.form_field p {
	display: none;
}
#selectfieldtype {
	display: block;
}
</style>

<div class="crf-main-form">
  <div class="crf-form-heading">
  <?php if(isset($_REQUEST['id'])):?>
    <h1><?php _e( 'Edit Field:', $textdomain ); ?></h1>
    <?php else: ?>
    <h1><?php _e( 'New Field:', $textdomain ); ?></h1>
    <?php endif; ?>
  </div>
  
  <!--HTML for custom field creation-->
  
  <form method="post" action="" id="add_field_form">
    <div class="crf-form-setting" id="selectfieldtype">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Select Type:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <select name="select_type" id="select_type" onChange="getfields(this.value)">
          <option value=""><?php _e( 'Select A Field', $textdomain ); ?></option>
          <option value="heading" <?php if(isset($str) && $str=='heading') echo 'selected'; ?>><?php _e( 'Heading', $textdomain ); ?></option>
          <option value="paragraph" <?php if(isset($str) && $str=='paragraph') echo 'selected'; ?>><?php _e( 'Paragraph', $textdomain ); ?></option>
          <option value="text" <?php if(isset($str) && $str=='text') echo 'selected'; ?>><?php _e( 'Text Field', $textdomain ); ?></option>
          <option value="select" <?php if(isset($str) && $str=='select') echo 'selected'; ?>><?php _e( 'Drop Down', $textdomain ); ?></option>
          <option value="radio" <?php if(isset($str) && $str=='radio') echo 'selected'; ?>><?php _e( 'Radio Button', $textdomain ); ?></option>
          <option value="textarea" <?php if(isset($str) && $str=='textarea') echo 'selected'; ?>><?php _e( 'Text Area', $textdomain ); ?></option>
          <option value="checkbox" <?php if(isset($str) && $str=='checkbox') echo 'selected'; ?>><?php _e( 'Check Box', $textdomain ); ?></option>
          <option value="DatePicker" <?php if(isset($str) && $str=='DatePicker') echo 'selected'; ?>><?php _e( 'Date Picker', $textdomain ); ?></option>
          <option value="email" <?php if(isset($str) && $str=='email') echo 'selected'; ?>><?php _e( 'Email', $textdomain ); ?></option>
          <option value="number" <?php if(isset($str) && $str=='number') echo 'selected'; ?>><?php _e( 'Number', $textdomain ); ?></option>
          <option value="country" <?php if(isset($str) && $str=='country') echo 'selected'; ?>><?php _e( 'Country', $textdomain ); ?></option>
          <option value="timezone" <?php if(isset($str) && $str=='timezone') echo 'selected'; ?>><?php _e( 'Timezone', $textdomain ); ?></option>
          <option value="term_checkbox" <?php if(isset($str) && $str=='term_checkbox') echo 'selected'; ?>><?php _e( 'Terms & Conditions Checkbox', $textdomain ); ?></option>
          	<?php
			/*file addon start */
			if ( is_plugin_active('file-upload-addon/file-upload.php') ) {
			?>
			<option value="file" <?php if(isset($str) && $str=='file') echo 'selected'; ?>><?php _e( 'File', $textdomain ); ?></option>                <?php
			}
			/*file addon end */
			?>
          
        </select>
      </div>
    </div>
    <div class="crf-form-setting" id="namefield">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Label:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <input type="text" name="field_name" id="field_name" value="<?php if(!empty($reg)) echo $reg->Name; ?>" required onKeyUp="check('<?php if(!empty($reg)){echo $reg->Name;}else { echo 'new';} ?>','<?php if(isset($_REQUEST['formid'])) echo $_REQUEST['formid']?>')" onBlur="check('<?php if(!empty($reg)){echo $reg->Name;}else { echo 'new';} ?>','<?php if(isset($_REQUEST['formid'])) echo $_REQUEST['formid']?>')">
        <div id="user-result"></div>
      </div>
    </div>
    <div class="crf-form-setting" id="optionsfield">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Options:', $textdomain ); ?>
          <small style="float:left;"><?php _e( '(value seprated by comma ",")', $textdomain ); ?></small> </div>
      </div>
      <div class="crf-form-right-area">
        <textarea type="text" name="field_Options" id="field_Options" cols="25" rows="5"><?php if(!empty($reg)) echo $reg->Option_Value; ?></textarea>
      </div>
    </div>
    <div class="crf-form-setting" id="desfield">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Description:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <textarea type="text" name="field_Des" id="field_Des" cols="25" rows="5"><?php if(!empty($reg)) echo $reg->Description; ?></textarea>
      </div>
    </div>
    <div class="crf-form-setting">
      <div class="toggle_button crf-form-left-area">
        <div class="crf-label"><?php _e( 'Advance Options', $textdomain ); ?></div>
        <span class="show_hide" id="plus"><?php _e( '+', $textdomain ); ?></span></div>
    </div>
    <div class="slidingDiv">
      <div class="crf-form-setting" id="valuefield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Default Value:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <input type="text" name="field_value" id="field_value" value="<?php if(!empty($reg)) echo $reg->Value; ?>">
        </div>
      </div>
      <div class="crf-form-setting" id="classfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'CSS Class Attribute:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <input type="text" name="field_class" id="field_class" value="<?php if(!empty($reg)) echo $reg->Class; ?>">
        </div>
      </div>
      <div class="crf-form-setting" id="maxlenghtfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Maximum Length:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area upb_number">
          <input type="text" name="field_maxLenght" id="field_maxLenght" value="<?php if(!empty($reg)) echo $reg->Max_Length; ?>">
          <div class="custom_error"></div>
        </div>
      </div>
      <div class="crf-form-setting" id="colsfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Columns:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area upb_number">
          <input type="text" name="field_cols" id="field_cols" value="<?php if(!empty($reg)) echo $reg->Cols; ?>">
          <div class="custom_error"></div>
        </div>
      </div>
      <div class="crf-form-setting" id="rowsfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Rows:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area upb_number">
          <input type="text" name="field_rows" id="field_rows" value="<?php if(!empty($reg)) echo $reg->Rows; ?>">
          <div class="custom_error"></div>
        </div>
      </div>
      <div class="crf-form-setting">
        <p class="rules" id="rulesfield" style="width:100%;"><?php _e( 'Rules', $textdomain ); ?></p>
      </div>
      <div class="crf-form-setting" id="requirefield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Is Required:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <input type="checkbox" name="field_require" id="field_require" value="1" style="width:auto;" <?php if(!empty($reg) && $reg->Require==1) echo 'checked'; ?>/>
        </div>
      </div>
      <div class="crf-form-setting" id="readonlyfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Is Read Only:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <input type="checkbox" name="field_readonly" id="field_readonly" value="1" style="width:auto;" <?php if(!empty($reg) && $reg->Readonly==1) echo 'checked'; ?> />
        </div>
      </div>
      <div class="crf-form-setting" id="visibilityfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Visibility:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <select type="checkbox" name="field_visibility" id="field_visibility">
            <option value="1" <?php if(!empty($reg) && $reg->Visibility==1) echo 'selected'; ?>>Public</option>
            <option value="2" <?php if(!empty($reg) && $reg->Visibility==2) echo 'selected'; ?>>Registered</option>
            <option value="3" <?php if(!empty($reg) && $reg->Visibility==3) echo 'selected'; ?>>Private</option>
          </select>
        </div>
      </div>
    </div>
    <div class="crf-form-footer">
      <div class="crf-form-button">
      	 <?php wp_nonce_field('save_crf_add_field'); ?>
        <input type="hidden" name="form_id" id="form_id" value="<?php if(isset($_REQUEST['formid'])) echo $_REQUEST['formid']?>" />
        <input type="hidden" name="field_id" id="field_id" value="<?php if(isset($_REQUEST['id'])) echo $_REQUEST['id']?>" />
        <input type="submit" value="Save" name="field_submit" id="field_submit" />
        <input type="button" value="Cancel" class="crf-back-button" name="field_back" id="field_back" onClick="backtoform(<?php if(isset($_REQUEST['formid'])) echo $_REQUEST['formid']?>)"  />
      </div>
      <div class="customupberror" style="display:none;"></div>
    </div>
  </form>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery(".slidingDiv").hide();
        jQuery(".show_hide").show();
        jQuery('.show_hide').toggle(function () {
            jQuery("#plus").text("-");
            jQuery(".slidingDiv").slideDown();
        }, function () {
            jQuery("#plus").text("+");
            jQuery(".slidingDiv").slideUp();
        });
    });
    jQuery('#add_field_form').submit(function () {
        jQuery('.upb_number').each(function (index, element) { //Validation for number type custom field
            var number = jQuery(this).children('input').val();
            var isnumber = jQuery.isNumeric(number);
            if (isnumber == false && number != "") {
                jQuery(this).children('.custom_error').html('Please enter a valid number');
                jQuery(this).children('.custom_error').show();
            } else {
                jQuery(this).children('.custom_error').html('');
                jQuery(this).children('.custom_error').hide();
            }
        });
        var b = '';
        b = jQuery('.custom_error').each(function () {
            var a = jQuery(this).html();
            b = a + b;
            jQuery('.customupberror').html(b);
        });
        var error = jQuery('.customupberror').html();
        if (error == '') {
            return true;
        } else {
            return false;
        }
    });
</script>
<script type="text/javascript">
    function check(prev, formid) {
        name = jQuery("#field_name").val();
        jQuery.post('<?php echo get_option('siteurl').'/wp-admin/admin-ajax.php';?>?action=check_crf_field_name&cookie=encodeURIComponent(document.cookie)', {
                'name': name,
                'prev': prev,
                'formid': formid
            },
            function (data) {
                //make ajax call to check_username.php
                if (data == "") {
                    jQuery("#user-result").html('');
                    jQuery("#field_submit").show();
                } else {
                    jQuery("#user-result").html(data);
                    jQuery("#field_submit").hide();
                }
                //dump the data received from PHP page
            });
    }

    function backtoform(a) {
        window.location = '<?php  echo admin_url().'admin.php?page=crf_manage_form_fields&form_id='?>' + a;
    }
</script>