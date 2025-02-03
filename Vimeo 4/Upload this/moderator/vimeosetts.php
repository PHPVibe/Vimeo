<?php if(isset($_POST['update_options_now'])){
foreach($_POST as $key=>$value)
{
if($key !== "site-logo") {
  update_option($key, toDb(trim($value)));
}
}
  echo '<div class="msg-info">Configuration options have been updated.</div>';
  $db->clean_cache();
}

$all_options = get_all_options();
?>

<div class="row row-setts">
<h3>Vimeo Importer Settings</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('vimeosetts');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="update_options_now" class="hide" value="1" /> 
<div class="form-group form-material">
<label class="control-label"><i class="icon-pencil"></i>Client ID</label>
<div class="controls">
<input type="text" name="vimeo_client" class="span12" value="<?php echo get_option('vimeo_client'); ?>" /> 						
<span class="help-block" id="limit-text">The Vimeo Client Id for your created application. <a href="https://developer.vimeo.com/apps">Create app</a></span>
</div>	
</div>	
<div class="form-group form-material">
<label class="control-label"><i class="icon-pencil"></i>Client secret</label>
<div class="controls">
<input type="text" name="vimeo_secret" class="span12" value="<?php echo get_option('vimeo_secret'); ?>" /> 						
<span class="help-block" id="limit-text">  Client secret from the Vimeo app. <a href="https://developer.vimeo.com/apps">Create app</a> </span>
</div>	
</div>
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>