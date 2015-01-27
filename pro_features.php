<?php
/*Controls custom field creation in the dashboard area*/
global $wpdb;
$textdomain = 'custom-registration-form-pro-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$path =  plugin_dir_url(__FILE__); 
?>
<div class="crf-main-form" style="background:none; box-shadow:none;">

  <div id="Pro-features">
  
      <div class="Pro-banner">
         <a target="_blank" href="http://cmshelplive.com/custom-user-registration-form-builder-pro.html"><img src="<?php echo $path; ?>images/Pro-Banner.png" alt="Banner" /></a>
      </div>
      
      <div class="Or-choose">
       <h2 class="Or-choose-hedding">Or choose separate addons...</h2>
      </div>
      
      <div class="coming-soon-box">
        <div class="File-Upload-box">
           <div class="File-Upload-box-left">
            <img src="<?php echo $path; ?>images/fill-upload-icon.png">
           </div>
           <div class="File-Upload-box-right">
            <h3>File Upload Field</h3>
            <p>Adds a new field type “File” to available fields allowing file attachment with forms. This field can be recurring, allowing multiple attachments. Settings include restricting file types. Attachments will be available for download with each entry in Submission tracker.</p>
            <div class="cler"></div>
            <?php
			/*file addon start */
			if ( is_plugin_active('file-upload-addon/file-upload.php') ) {
				?>
                <a style="cursor:default" class="purchased">Purchased</a>
                <?php }
                else
				{
					?>
                    <a target="_blank" href="http://cmshelplive.com/accounts/cart.php?a=add&pid=63">Buy Now</a>
             <span>Only 4.95 US$</span>
                    <?php
				}
                ?>
            
             <div class="cler"></div>
           </div>
           <div class="cler"></div>
        </div>
        <div class="File-Upload-box boder">
          <h1 class="File-Upload-box-heddig">More addons<br> 
             coming soon...</h1>
           <p>watch out for this space</p>
         
        </div>
        
      </div>
    
  
  </div>
  
</div>
