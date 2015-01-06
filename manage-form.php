<?php
/*Controls custom field creation in the dashboard area*/
global $wpdb;
$textdomain = 'custom-registration-form-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$crf_entries =$wpdb->prefix."crf_entries";
$path =  plugin_dir_url(__FILE__); 
if(!empty($_POST['selected']) && isset($_POST['copy']))
{
	$ids = implode(',',$_POST['selected']);
	$query = "select * from $crf_forms where id in($ids)";
	$results = $wpdb->get_results($query);
	if(!empty($results))
	{
	foreach($results as $entry)
	{
		$qry = "insert into $crf_forms values('','".$entry->form_name."','".$entry->form_desc."','".$entry->form_type."','".$entry->custom_text."','".$entry->crf_welcome_email_subject."','".$entry->success_message."','".$entry->crf_welcome_email_message."','".$entry->redirect_option."','".$entry->redirect_page_id."','".$entry->redirect_url_url."','".$entry->send_email."')";	
		$wpdb->query($qry);	
	}
	}
}

if(!empty($_POST['selected']) && isset($_POST['delete']))
{
	$ids = implode(',',$_POST['selected']);
	$query = "delete from $crf_forms where id in($ids)";
	$wpdb->get_results($query);
}

$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 10; // number of rows in page
$offset = ( $pagenum - 1 ) * $limit;
$qry = "SELECT * FROM $crf_forms";
$total = $wpdb->get_var( "SELECT count(*) FROM $crf_forms" );
$num_of_pages = ceil( $total / $limit );
$entries = $wpdb->get_results( "SELECT * FROM $crf_forms order by id asc LIMIT $offset, $limit" );
?>

<form name="forms" id="forms" method="post" action="admin.php?page=crf_manage_forms" >
<div class="ucf_pro_banner">
<a target="_blank" href="http://cmshelplive.com/custom-user-registration-form-builder-pro.html"><img src="<?php echo $path;?>images/UCF_Banner.png" /></a>
</div>
  <div class="crf-main-form">
    <div class="crf-main-form-top-area">
      <div class="crf-form-name-heading">
        <h1><?php _e( 'All Forms', $textdomain ); ?></h1>
      </div>
      <div class="crf-form-name-buttons">
        <div class="crf-setting"><a href="admin.php?page=crf_settings"><img src="<?php echo $path; ?>images/crf-setting-button.png"></a></div>
      </div>
    </div>
    <div class="crf-new-buttons"><span class="crf-add-new-button"><a href="admin.php?page=crf_add_form"><?php _e( 'Add New', $textdomain ); ?></a></span> <span class="crf-duplicate-button" style="display:none;">
      <input type="submit" name="copy" id="copy" value="Duplicate" >
      </span> <span class="crf-remove-button" style="display:none;">
      <input type="submit" name="delete" id="delete" value="Remove" onClick="return popup()">
      </span></div>
  </div>
  <div class="crf-row-result-main">
    <?php
if(empty($entries))
{
?>
    <!--HTML when there is not create any form-->  
    <ul id="sortable" class="crf_entries">
      <li class="rows">
        <div class="cols"><?php _e( 'You have not created any forms yet. Once you have created a new form, it will appear here.', $textdomain ); ?></div>
      </li>
    </ul>
    <?php 
}
else
{
$i = 1;	
foreach($entries as $row)
{
	$qry = "select count(*) from $crf_entries where form_id=".$row->id;
	$submission = $wpdb->get_var($qry);
	if($submission>100)
	{
		$submission='99+';
	}
?>
    <!--HTML when there are already custom fields associated with selected user role-->  
    <div class="crf-row-result">
      <div class="crf-form-name">
        <?php 
$length = strlen($row->form_name);
if($length<=12){echo $row->form_name;}
else
{
$Valuehalf = substr($row->form_name, 0, 12);
echo $Valuehalf.'...';
}
?>
      </div>
      <div class="crf-form-check">
        <input type="checkbox" name="selected[]" value="<?php echo $row->id;?>">
      </div>
      <div class="crf-form-submissions"><?php _e( 'Submissions', $textdomain ); ?></div>
      <div class="crf-form-rest"><a href="admin.php?page=crf_entries&form_id=<?php echo $row->id;?>"><?php echo $submission;?></a></div>
      <div class="crf-form-shortcode"><?php _e( 'Shortcode', $textdomain ); ?></div>
      <div class="crf-form-shortcode-name">[CRF_Form id='<?php echo $row->id;?>']</div>
      <div class="crf-form-shortcode-type"><?php _e( 'Type', $textdomain ); ?></div>
      <div class="crf-form-shortcode-type-name">
        <?php if($row->form_type=='reg_form')echo 'Registration'; else echo 'Contact Form';?>
      </div>
      <div  class="crf-row-result-button-area">
        <div class="crf-row-result-edit-button"><a href="admin.php?page=crf_add_form&id=<?php echo $row->id;?>"><?php _e( 'Edit', $textdomain ); ?></a></div>
        <div class="crf-row-result-preview-button"><a href="admin.php?page=crf_manage_form_fields&form_id=<?php echo $row->id;?>"><?php _e( 'Fields', $textdomain ); ?></a></div>
      </div>
    </div>
    <?php
		$i++;
}
}

$page_links = paginate_links( array(
    'base' => add_query_arg( 'pagenum', '%#%' ),
    'format' => '',
	'type'=>'array',
    'prev_text' => __( 'Prev', $textdomain ),
    'next_text' => __( 'Next', $textdomain ),
    'total' => $num_of_pages,
    'current' => $pagenum
) );

$count	= count($page_links);
$prev = strpos($page_links[0],'Prev');
$next = strpos($page_links[$count-1],'Next');

if($prev!=false)
{
?>
    <div class="crf-row-result pagination prev"> <?php echo $page_links['0']; ?> </div>
    <?php
}
if($next!=false)
{
?>
    <div class="crf-row-result pagination next"> <?php echo $page_links[$count-1]; ?> </div>
    <?php
}
?>
  </div>
</form>
<script>
    jQuery(document).ready(function () {
        var a = jQuery('.crf-row-result-main .crf-row-result');
        for (var i = 0; i < a.length; i += 4) {
            a.slice(i, i + 4).wrapAll('<div class="crf-form-cutom-row"></div>');
        }
    });
    jQuery('input[name="selected[]"]').click(function () {
        var atLeastOneIsChecked = jQuery('input[name="selected[]"]:checked').length > 0;
        if (atLeastOneIsChecked == true) {
            jQuery('.crf-duplicate-button').show(500);
            jQuery('.crf-remove-button').show(500);
        } else {
            jQuery('.crf-duplicate-button').hide(500);
            jQuery('.crf-remove-button').hide(500);
        }
    });
</script>
<script>
    function popup() {
        a = confirm("<?php _e('This will delete the form(s) permanently. Please confirm.', $textdomain ); ?>");
        if (a == true) {
            return true;
        } else {
            return false;
        }
    }
</script>