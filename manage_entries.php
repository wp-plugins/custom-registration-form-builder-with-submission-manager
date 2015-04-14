<?php
/*Controls custom field creation in the dashboard area*/
global $wpdb;
$textdomain = 'custom-registration-form-pro-with-submission-manager';
$crf_entries =$wpdb->prefix."crf_entries";
$crf_fields =$wpdb->prefix."crf_fields";
$crf_forms =$wpdb->prefix."crf_forms";
$path =  plugin_dir_url(__FILE__); 

if(isset($_REQUEST['form_id']))
{
	$form_id = $_REQUEST['form_id'];		
}
else
{
	$qry = "select id from $crf_forms order by id asc limit 1";
    $reg = $wpdb->get_var($qry);
	$form_id = $_REQUEST['form_id']=$reg;
}
if(!empty($_POST['selected']) && isset($_POST['remove']))
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'manage_crf_entries' ) ) die( 'Failed security check' );
	
	$ids = implode(',',$_POST['selected']);
	$query = "delete from $crf_entries where id in($ids)";
	$wpdb->get_results($query);
}
?>

<form name="field_list" id="field_list" method="post">
<?php wp_nonce_field('manage_crf_entries'); ?>
  <div class="crf-main-form">
    <div class="crf-form-name-heading-Submissions">
      <h1><?php _e('Submissions', $textdomain ); ?></h1>
    </div>
    <div  class="crf-add-remove-field-submissions crf-new-buttons">
      <div class="crf-remove-field" style="display:none;padding-top: 2px;">
        <input type="submit" name="remove" id="remove" value="Delete" onClick="return popup()"/>
      </div>
      
      <select name="form_id" id="form_id" onChange="redirectform(this.value)">
        <?php
    $qry = "select * from $crf_forms";
    $reg = $wpdb->get_results($qry);
    if(!empty($reg))
    {
        foreach($reg as $row)
        {
            ?>
        <option value="<?php echo $row->id;?>" <?php if($_REQUEST['form_id']==$row->id) echo 'selected';?>>
        <?php 
		$formnamelength = strlen($row->form_name);
if($formnamelength<=15){echo $row->form_name;}
else
{
$formnamehalf = substr($row->form_name, 0, 15);
echo $formnamehalf.'...';
}?>
        </option>
        <?php
        }
    }
    ?>
      </select>
    </div>
  </div>
  <div class="crf-main-sortable">
    <ul id="sortable" class="crf_entries">
      <?php
$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 10; // number of rows in page
$offset = ( $pagenum - 1 ) * $limit;
if($_REQUEST['form_id']!="")
{
  $total = $wpdb->get_var( "SELECT count(*) FROM $crf_entries where form_id ='".$form_id."'" );
  $num_of_pages = ceil( $total / $limit );
  $entries = $wpdb->get_results( "SELECT * FROM $crf_entries where form_id ='".$form_id."' order by id desc LIMIT $offset, $limit");
}

if(empty($entries))
{
?>
      <li class="rows">
        <div class="cols"><?php _e('No submissions for this form have been recorded.', $textdomain ); ?></div>
      </li>
      <?php
}
else
{
?>
      <li class="header rows">
        <div class="cols" style="width:30px;"></div>
        <div class="cols" style="width:30px;">#</div>
        <?php
	$qry = "select * from $crf_fields where form_id ='".$_REQUEST['form_id']."' and Type not in('heading','paragraph','file') order by ordering asc";
	$reg = $wpdb->get_results($qry);
	$count_field = count($reg);
	if($count_field >=4)
	{
		$show_field = 4;	
	}
	else
	{
		$show_field	=$count_field;
	}

	$field =1;
	
	foreach($reg as $row)
	{
	if($field<=$show_field):
	?>
        <div class="cols" style="width:19%">
          <?php 
		$fieldnamelength = strlen($row->Name);
if($fieldnamelength<=15){echo $row->Name;}
else
{
$fieldnamehalf = substr($row->Name, 0, 15);
echo $fieldnamehalf.'...';
}?>
        </div>
        <?php 
	$field++;
	endif;
	} ?>
      </li>
      <?php
  $i=1 + $offset;
  foreach($entries as $entry)
  {
	if($i%2==0)
	{
		$class="";
	}
	else
	{
		$class="alternate";
	}
  ?>
      <li class="<?php echo $class;?> rows">
        <div class="cols" style="width:30px;">
          <input type="checkbox" name="selected[]" value="<?php echo $entry->id; ?>" />
        </div>
        <div class="cols" style="width:30px;"><a href="admin.php?page=crf_view_entry&id=<?php echo $entry->id;?>"><?php echo $i; ?></a></div>
        <?php
	 $field =1;
	 $value = maybe_unserialize($entry->value); 
	foreach($reg as $row)
	{
	$Customfield = str_replace(" ","_",$row->Name);
	$Customfield1 = sanitize_key($row->Name).'_'.$row->Id;
	if($field<=$show_field):
	
	if(empty($value[$Customfield]) && empty($value[$Customfield1]) )
	{
		$result = "";
	}
	else
	{
		if(!empty($value[$Customfield]) )
		{
			$result = 	$value[$Customfield];
		}
		else
		{
			$result = 	$value[$Customfield1];
		}
	
	}
	
	if(is_array($result))
	{
		$result = implode(',',$result);
	}
	?>
        <div class="cols" style="width:19%">
          <?php 
	  $Valuehalf = substr($result, 0, 15);
	  if(strlen($result) < 15)
	  {
	  echo $result;
	  }
	  else
	  {
		echo $Valuehalf.'...'; 
	  }
	  ?>
        </div>
        <?php 
	$field++;
	endif;
	} 
	 ?>
     <div class="cols" style="width:50px"><a href="admin.php?page=crf_view_entry&id=<?php echo $entry->id;?>">View</a></div>
      </li>
      <?php 
$i++;
} 
}
?>
    </ul>
    <?php
	
	$args = array(
	'base'               => add_query_arg( 'pagenum', '%#%' ),
	'format'             => '',
	'total'              => $num_of_pages,
	'current'            => $pagenum,
	'show_all'           => False,
	'end_size'           => 1,
	'mid_size'           => 2,
	'prev_next'          => True,
	'prev_text'          => __('&laquo;', 'text-domain' ),
	'next_text'          => __('&raquo;', 'text-domain'),
	'type'               => 'plain',
	'add_args'           => False,
	'add_fragment'       => '',
	'before_page_number' => '',
	'after_page_number'  => ''
);

$page_links = paginate_links( $args );

if ( $page_links ) {
    echo '<div class="tablenav crfpagination"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
}
?>
  </div>
</form>
<script>
    function redirectform(id) {
        window.location = 'admin.php?page=crf_entries&form_id=' + id;
    }
    jQuery('input[name="selected[]"]').click(function () {
        var atLeastOneIsChecked = jQuery('input[name="selected[]"]:checked').length > 0;
        if (atLeastOneIsChecked == true) {
            jQuery('.crf-remove-field').show(500);
        } else {
            jQuery('.crf-remove-field').hide(500);
        }
    });
</script>
<script>
    function popup() {
        a = confirm("<?php _e('Are you sure you want to remove?', $textdomain ); ?>");
        if (a == true) {
            return true;
        } else {
            return false;
        }
    }
</script>