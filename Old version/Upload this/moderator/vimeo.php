<?php $importer = array_merge($_GET, $_POST);
require_once( ADM.'/vimeo.class.php' );
$v_client = trim(get_option('vimeo_client'));
$v_secret = trim(get_option('vimeo_secret'));
$nb_display = 24;
echo "<h3>Vimeo Importer</h3>";
if((false ===$v_client) || (false === $v_secret) ) {
echo "Hold on! Seems the keys are missing.<a href='".admin_url("vimeosetts")."'>Add them here first</a>.";
} else {

$vimeo = new phpVimeo($v_client, $v_secret);
//Enable cache
$c_path = ADM.'/cache';
$vimeo->enableCache(phpVimeo::CACHE_FILE,$c_path, 300);
//$vcats = $vimeo->call('vimeo.categories.getAll');
$importer = array_merge($_GET, $_POST);
if (isset($importer['action'])) {
//var_dump($importer);
if($importer['action'] == "search") {
//Import by search
if(!isset($importer['key']) || empty($importer['key'])) { $importer['key'] = '' ; }
$importer['key'] = str_replace(" ", "+",$importer['key'] );
$call_params  = array(
            'page' => this_page(),
            'full_response' => '1',
            'per_page' => $nb_display,          
			'query' => $importer['key'],
            'sort' => 'relevant'
        );

$videos = $vimeo->call('vimeo.videos.search',$call_params);
$pagi_url = admin_url("vimeo").'&action=search&key='.$importer['key'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

} elseif($importer['action'] == "tags") {
//Import by tag
if(!isset($importer['tag']) || empty($importer['tag'])) { $importer['tag'] = '' ; }
$importer['tag'] = str_replace(" ", "+",$importer['tag'] );
/* Method to sort by: relevant, newest, oldest, most_played, most_commented, or most_liked. */
$call_params  = array(
            'page' => this_page(),
            'full_response' => '1',
            'per_page' => $nb_display,          
			'tag' => $importer['tag'],
            'sort' => 'newest'
        );

$videos = $vimeo->call('vimeo.videos.getByTag',$call_params);
$pagi_url = admin_url("vimeo").'&action=tags&tag='.$importer['tag'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

} elseif($importer['action'] == "category") {
//Import by category
if(!isset($importer['vchannel']) || empty($importer['vchannel'])) { $importer['vchannel'] = '' ; }
$importer['vchannel'] = str_replace(" ", "+",$importer['vchannel'] );
/* Method to sort by: relevant, newest, oldest, most_played, most_commented, or most_liked. */
$call_params  = array(
            'page' => this_page(),
            'full_response' => '1',
            'per_page' => $nb_display,          
			'category' => $importer['vchannel'],
            'sort' => 'newest'
        );

$videos = $vimeo->call('vimeo.categories.getRelatedVideos',$call_params);
$pagi_url = admin_url("vimeo").'&action=category&vchannel='.$importer['vchannel'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

}elseif($importer['action'] == "user") {
//Import by user's uploads
if(!isset($importer['user']) || empty($importer['user'])) { $importer['user'] = '' ; }
$importer['user'] = str_replace(" ", "+",$importer['user'] );
/* Method to sort by: relevant, newest, oldest, most_played, most_commented, or most_liked. */
$call_params  = array(
            'page' => this_page(),
            'full_response' => '1',
            'per_page' => $nb_display,          
			'user_id' => $importer['user'],
            'sort' => 'newest'
        );

$videos = $vimeo->call('vimeo.videos.getUploaded',$call_params);
$pagi_url = admin_url("vimeo").'&action=user&user='.$importer['user'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

}elseif($importer['action'] == "channel") {
//Import by user channel
if(!isset($importer['channel']) || empty($importer['channel'])) { $importer['channel'] = '' ; }
$importer['channel'] = str_replace(" ", "+",$importer['channel'] );
/* Method to sort by: relevant, newest, oldest, most_played, most_commented, or most_liked. */
$call_params  = array(
            'page' => this_page(),
            'full_response' => '1',
            'per_page' => $nb_display,          
			'channel_id' => $importer['channel'],
            'sort' => 'newest'
        );

$videos = $vimeo->call('vimeo.channels.getVideos',$call_params);
$pagi_url = admin_url("vimeo").'&action=channel&channel='.$importer['channel'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

}elseif($importer['action'] == "likes") {
//Import by user liked
if(!isset($importer['likes']) || empty($importer['likes'])) { $importer['likes'] = '' ; }
$importer['likes'] = str_replace(" ", "+",$importer['likes'] );
/* Method to sort by: relevant, newest, oldest, most_played, most_commented, or most_liked. */
$call_params  = array(
            'page' => this_page(),
            'full_response' => '1',
            'per_page' => $nb_display,          
			'user_id' => $importer['likes'],
            'sort' => 'newest'
        );

$videos = $vimeo->call('vimeo.videos.getLikes',$call_params);
$pagi_url = admin_url("vimeo").'&action=likes&likes='.$importer['likes'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

}elseif($importer['action'] == "album") {
//Import by album
if(!isset($importer['album']) || empty($importer['album'])) { $importer['album'] = '' ; }
$importer['album'] = str_replace(" ", "+",$importer['album'] );
/* Method to sort by: relevant, newest, oldest, most_played, most_commented, or most_liked. */
$call_params  = array(
            'page' => this_page(),
            'full_response' => '1',
            'per_page' => $nb_display,          
			'album_id' => $importer['album'],
            'sort' => 'newest'
        );

$videos = $vimeo->call('vimeo.albums.getVideos',$call_params);
$pagi_url = admin_url("vimeo").'&action=album&album='.$importer['album'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

} else {
echo 'Missing action/section. Click back and try again.';
}

// Do the import

if(isset($videos) &&  isset($videos['videos']['total']) && ($videos['videos']['total'] > 0)  ) {
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($nb_display);
$a->set_values($videos['videos']['total']);
$a->show_pages($pagi_url);
?>

<div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                                <tr>                                 
                                  <th width="130px"><?php echo _lang("Thumb"); ?></th>								 
                                  <th><?php echo _lang("Video"); ?></th>
								  <th>Duration</th>
                                  <th width="20%">Description</th>									   
							      <th>Status</th>							  
                                 
								</tr>
                          </thead>
                          <tbody>
						  <?php 
												
						  foreach ($videos['videos']['video'] as $video) {
						  
		                     if(!is_null($video)){ 
/* thumb selection */							 
$image = array();
		$j =1;
		foreach ($video['thumbnails']['thumbnail'] as $thumb) {
		$image[$j] = $thumb['_content'];
		$j++;
		}
$thumb = $image['2'];		
/* Video source */	
$source = 'http://www.vimeo.com/'.$video['id'];	
/* duration to sec converting */
$duration = intval($video['duration']);
/* format tags */
$xtags = '';
if(isset($video['tags'])&& !is_null($video['tags'])){

foreach ($video['tags']['tag'] as $tag) {
$xtags .= toDb($tag['_content']).", ";
}
}	
/* Video description */
$description = ucfirst($video['description']);
/* No remote capabilities */
$remote = '';
 ?>
                              <tr>
                                 
                                  <td><img src="<?php echo $thumb; ?>" style="width:130px; height:90px;"></td>
                                  <td><?php echo _html(ucfirst($video['title'])); ?></td>
								   <td><?php echo $video['duration']; ?></td>
                                  <td>
								    <?php echo _cut($description, 200)."..."; ?>
								  </td>
								  <td>
								<?php 
								
								if($importer['allowduplicates'] > 0) { 
								  echo '<span class="greenText">Imported</span>';
								  //Insert it
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`, `remote`) VALUES ('".intval(get_option('videos-initial'))."','".$source."', '".user_id()."', now() , '".$thumb."', '".toDb($video['title']) ."', '".intval($duration)."', '".$xtags."', '0', '0','".intval($importer['categ'])."','".toDb($description)."','0','".toDb($remote)."')");	
								} else {
								$check = $db->get_row("SELECT count(*) as dup from ".DB_PREFIX."videos where source ='".toDb($source)."'");
								
                                   if($check->dup > 0) {
								    echo '<span class="redText">Skipped as duplicate</span>';
								   } else {
								    echo '<span class="greenText">Imported</span>';
									//Insert it 
 $db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`, `remote`) VALUES  ('".intval(get_option('videos-initial'))."','".$source."', '".user_id()."', now() , '".$thumb."', '".toDb($video['title']) ."', '".intval($duration)."', '".$xtags."', '0', '0','".intval($importer['categ'])."','".toDb($description)."','0','".toDb($remote)."')");  
 }

                                  } ?>
								  </td>
								  
                              </tr>
							  <?php 
							if($importer['sleepvideos'] > 0) {   sleep($importer['sleepvideos']); }
							  } 
}


							  //end loop 
							  ?>
						</tbody>  
</table>
</div>						
<?php
$next = this_page() + 1;
if(($importer['auto'] > 0) && ($videos['videos']['total'] > 0) && ($next < $importer['endpage'])) {
echo 'Redirecting to '.$next;
echo '
<script type="text/javascript">
setTimeout(function() {
  window.location.href = "'.$pagi_url.$next.'";
}, '.$importer['sleeppush'].');

</script>
';
}

$a->show_pages($pagi_url);
} else { echo '<div class="msg-info">No (more) videos found</div>'; }


 } else { ?>
 
 <ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#search">Search results</a></li>
  <li><a href="#tags">Tagged with</a></li>
  <li><a href="#user">User uploads</a></li>
  <li><a href="#channel">User's channel </a></li>
  <li><a href="#likes">User's likes</a></li>
   <li><a href="#album">Album videos</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="search">
  <div class="row-fluid">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<i>Import videos from a specific Vimeo search </i>
<input type="hidden" name="action" class="hide" value="search"> 
<div class="control-group">
<label class="control-label"><i class="icon-search"></i>Keyword</label>
<div class="controls">
<input type="text" name="key" class="validate[required] span8" value="" placeholder="Ex: Rihanna, Nokia, IPhone, Ipad..etc"> 						
</div>	
</div>

<div class="control-group">
<label class="control-label">To category:</label>
<div class="controls">
<select data-placeholder="Choose a category" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
<?php	
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	 echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>'; 	}
}	else { echo'<option value="">'._lang("No categories").'</option>'; }
?>	
</select>
 </div>             
 </div>
 
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
		<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
	</div>
</div>
	</div>
	</div>	
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	 
</form>
</div>
  </div>

 <div class="tab-pane" id="tags">
  <div class="row-fluid">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<i>Import videos from a specific Vimeo tag </i>
<input type="hidden" name="action" class="hide" value="tags"> 
<div class="control-group">
<label class="control-label"><i class="icon-search"></i>Tag</label>
<div class="controls">
<input type="text" name="tag" class="validate[required] span8" value="" placeholder="Ex: Rihanna, Nokia, IPhone, Ipad..etc"> 						
</div>	
</div>

<div class="control-group">
<label class="control-label">To category:</label>
<div class="controls">
<select data-placeholder="Choose a category" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
<?php	
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	 echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>'; 	}
}	else { echo'<option value="">'._lang("No categories").'</option>'; }
?>	
</select>
 </div>             
 </div>
 
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
		<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
	</div>
</div>
	</div>
	</div>	
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	 
</form>
</div>
  </div>
<div class="tab-pane" id="user">
  <div class="row-fluid">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<i>Import videos from a specific Vimeo user </i>
<input type="hidden" name="action" class="hide" value="user"> 
<div class="control-group">
<label class="control-label"><i class="icon-search"></i>User</label>
<div class="controls">
<input type="text" name="user" class="validate[required] span8" value="" placeholder="Ex: for vimeo.com/user8452612 type only user8452612"> 						
</div>	
</div>

<div class="control-group">
<label class="control-label">To category:</label>
<div class="controls">
<select data-placeholder="Choose a category" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
<?php	
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	 echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>'; 	}
}	else { echo'<option value="">'._lang("No categories").'</option>'; }
?>	
</select>
 </div>             
 </div>
 
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
		<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
	</div>
</div>
	</div>
	</div>	
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	 
</form>
</div>
  </div>
 <div class="tab-pane" id="likes">
  <div class="row-fluid">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<i>Import videos from a specific Vimeo user's likes </i>
<input type="hidden" name="action" class="hide" value="likes"> 
<div class="control-group">
<label class="control-label"><i class="icon-search"></i>User's likes</label>
<div class="controls">
<input type="text" name="likes" class="validate[required] span8" value="" placeholder="Ex: for vimeo.com/user8452612 type only user8452612"> 						
</div>	
</div>

<div class="control-group">
<label class="control-label">To category:</label>
<div class="controls">
<select data-placeholder="Choose a category" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
<?php	
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	 echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>'; 	}
}	else { echo'<option value="">'._lang("No categories").'</option>'; }
?>	
</select>
 </div>             
 </div>
 
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
		<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
	</div>
</div>
	</div>
	</div>	
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	 
</form>
</div>
  </div>  
 <div class="tab-pane" id="album">
  <div class="row-fluid">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<i>Import videos from a specific Vimeo album </i>
<input type="hidden" name="action" class="hide" value="album"> 
<div class="control-group">
<label class="control-label"><i class="icon-search"></i>Album</label>
<div class="controls">
<input type="text" name="album" class="validate[required] span8" value="" placeholder="Ex: for vimeo.com/album/1930045 type only 1930045"> 						
</div>	
</div>

<div class="control-group">
<label class="control-label">To category:</label>
<div class="controls">
<select data-placeholder="Choose a category" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
<?php	
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	 echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>'; 	}
}	else { echo'<option value="">'._lang("No categories").'</option>'; }
?>	
</select>
 </div>             
 </div>
 
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
		<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
	</div>
</div>
	</div>
	</div>	
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	 
</form>
</div>
  </div>    

 <div class="tab-pane" id="channel">
  <div class="row-fluid">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<i>Import videos from a specific Vimeo channel </i>
<input type="hidden" name="action" class="hide" value="channel"> 
<div class="control-group">
<label class="control-label"><i class="icon-search"></i>Channel ID</label>
<div class="controls">
<input type="text" name="channel" class="validate[required] span8" value="" placeholder="Ex: for vimeo.com/channels/nokia type just nokia"> 						
</div>	
</div>

<div class="control-group">
<label class="control-label">To category:</label>
<div class="controls">
<select data-placeholder="Choose a category" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
<?php	
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	 echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>'; 	}
}	else { echo'<option value="">'._lang("No categories").'</option>'; }
?>	
</select>
 </div>             
 </div>
 
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
		<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
	</div>
</div>
	</div>
	</div>	
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	 
</form>
</div>
  </div>



</div>

 
 
 <?php

} 
}

?>