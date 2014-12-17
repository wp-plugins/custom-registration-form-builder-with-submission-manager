<?php
/*Controls registration form behavior on the front end*/
global $wpdb;
$textdomain = 'custom-registration-form-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$crf_fields =$wpdb->prefix."crf_fields";
$path =  plugin_dir_url(__FILE__);
$crf_option=$wpdb->prefix."crf_option";
$crf_entries =$wpdb->prefix."crf_entries";
$entry = $wpdb->get_row( "SELECT * FROM $crf_entries where id=".$_REQUEST['id'] );

if(isset($_REQUEST['delete_entry']) && isset($_REQUEST['id']))
{
	$qry = "delete from $crf_entries where id =".$_REQUEST['id'];
	$wpdb->query($qry);
	wp_redirect('admin.php?page=crf_entries&form_id='.$entry->form_id);exit;
}

$qry = "select form_name from $crf_forms where id=".$entry->form_id;
$form_name = $wpdb->get_var($qry);
$value = @unserialize($entry->value);

if(isset($_REQUEST['user_enable']) && isset($_REQUEST['id']))
{
	  $user_name = $value['user_name']; // receiving username
	  $user_email = $value['user_email']; // receiving email address
	  $inputPassword = $value['user_pass']; // receiving password
	  $user_id = username_exists( $user_name ); // Checks if username is already exists.
	  
	  if ( !$user_id and email_exists($user_email) == false )//Creates password if password auto-generation is turned on in the settings
	  {
		  if($pwd_show != "no")
		  {
			  $random_password = $inputPassword;
		  }
		  else
		  {
			  $random_password = $inputPassword;
		  }
	  $qry="SELECT crf_welcome_email_subject FROM $crf_forms WHERE id=".$entry->form_id;//Fetches registration email Subject from dashboard settings
	  $subject = $wpdb->get_var($qry);
	  $user_id = wp_create_user( $user_name, $random_password, $user_email );//Creates new WP user after successful registration

		if($subject == "")
		{
		  $subject = get_bloginfo('name');//Auto inserts email Subject if it is not defined in dashboard settings
		  $subject .= __(" - Registration",$textdomain);
		}
	  $qry1="SELECT crf_welcome_email_message FROM $crf_forms WHERE id=".$entry->form_id;//Fetches registration email body from dashboard settings
	  $message = $wpdb->get_var($qry1);
	  if($message == "")
	  {
		  $message = __("Thank you for registration.",$textdomain);//Auto inserts this text as email body if it is not defined in dashboard settings
	  }

	  if($pwd_show != "no")//Inserts password into registration email body if auto-generation of password is enabled
	  {
		  $message .= __('You can use following details for login.',$textdomain);
		$message .= __('Username : ',$textdomain).$user_name;
		$message .= __('password : ',$textdomain).$random_password;
	  }
	  if($value['role']!="")
	  {
		  $role = $value['role'];//Assigns the new user a role based on registration form shortcode
	  }
	  else
	  {
		  $role = 'subscriber';//Defines default role if there is not shortcode in registration form
	  }
	  /*Insert custom field values if displayed in registration form*/
	  $qry1 = "select * from $crf_fields where Form_Id= '".$entry->form_id."' and Type not in('heading','paragraph') order by ordering asc";
	  $reg1 = $wpdb->get_results($qry1);
	  if(!empty($reg1))
	  {
	   foreach($reg1 as $row1)
	   {
		  if(!empty($row1))
		  {
			  $Customfield = str_replace(" ","_",$row1->Name);
			  if(!isset($prev_value)) $prev_value='';
			  add_user_meta( $user_id, $Customfield, $value[$Customfield], true );
			  update_user_meta( $user_id, $Customfield, $value[$Customfield], $prev_value );
		  }
	   }
	  }
	  /*Assigns user role to newly registered user*/
	  if($value['role']!="")
	  {		 
		  if($value['role']=='Subscriber' || $value['role']=='Administrator' || $value['role']=='Editor' || $value['role']=='Author' || $value['role']=='Contributor')
		  {
			  $role = strtolower($value['role']);
		  }
		  else
		  {
			  $role =  $value['role'];	
		  }
		  $user_id = wp_update_user( array( 'ID' => $user_id, 'role' => $role ) );
	  }

	  $qry = "update $crf_entries set user_approval = 'yes' where id=".$entry->id;
	  $wpdb->query($qry);
	  wp_mail( $user_email, $subject, $message );//Sends email to user on successful registration
	  wp_redirect('admin.php?page=crf_entries&form_id='.$entry->form_id);exit;
	  }
}
?>

<div class="crf-main-form">
  <div class="crf-main-form-top-area">
    <div class="crf-form-name-heading">
      <h1><?php echo $form_name; ?></h1>
    </div>
    <div class="crf-form-name-buttons">
      <div class="crf-setting"><a href="#"></a></div>
    </div>
  </div>
  <div class="crf-new-buttons"><span class="crf-back-button">
    <input name="Back" type="submit" autofocus id="Back" title="Back" value="Back" onClick="backfun(<?php echo $entry->form_id;?>)">
    </span> <span class="crf-duplicate-button">
    <form action="admin.php?page=crf_view_entry">
      <input type="submit" value="Delete" name="delete_entry">
      <input type="hidden" value="<?php echo $entry->id;?>" name="id" />
      <input type="hidden" value="crf_view_entry" name="page" >
    </form>
    </span> <span class="crf-Approve-Registration-button">
    <?php

if($entry->form_type=='reg_form' && $entry->user_approval=='no')
{
?>
    <form action="admin.php?page=crf_view_entry">
      <input type="submit" value="Approve Registration" name="user_enable">
      <input type="hidden" value="<?php echo $entry->id;?>" name="id" />
      <input type="hidden" value="crf_view_entry" name="page" >
    </form>
    <?php
}
?>
    </span></div>
</div>
<div class="crf-signle-entry-form">
  <div class="crf-single-entry-content">
    <div>
      <p><span class="entry_heading"><?php _e('Entry Id :',$textdomain);?> </span><span class="entry_Value"><?php echo $entry->id;?></span></p>
      <p><span class="entry_heading"><?php _e('Entry Type :',$textdomain);?> </span><span class="entry_Value">
        <?php if($entry->form_type=='reg_form'){echo 'Registration Form';}else{echo 'Contact Form';}?>
        </span></p>
      <?php
if(!empty($value))
{
	foreach($value as $key => $val) 
	{
		if(is_array($val))
		{
			$val = implode(',',$val);	
		}
		$Customfield = str_replace("_"," ",$key);
		if($key!="user_pass"):
  		?>
      <p><span class="entry_heading"><?php echo $Customfield; ?> : </span><span class="entry_Value"><?php echo $val; ?></span></p>
      <?php
		endif;
	}
}
?>
    </div>
  </div>
</div>
<script>
function backfun(id)
{
 window.location = 'admin.php?page=crf_entries&form_id='+id;
}
</script> 