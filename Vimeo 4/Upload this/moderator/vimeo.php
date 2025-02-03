<?php $importer = array_merge($_GET, $_POST);
require_once( ADM.'/vimeoapi/autoload.php' );
$importer = array_merge($_GET, $_POST);
use Vimeo\Vimeo;
$v_client = trim(get_option('vimeo_client'));
$v_secret = trim(get_option('vimeo_secret'));
$vimeo = new Vimeo($v_client, $v_secret);
$nb_display = 24;
echo "<h3>Vimeo Importer</h3>";
if((false ===$v_client) || (false === $v_secret) ) {
echo "Hold on! Seems the keys are missing.<a href='".admin_url("vimeosetts")."'>Add them here first</a>.";
} else {
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
'query' => urlencode($importer['key']),
'sort' => 'relevant'
);
$videos = $vimeo->request('/videos',$call_params);
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
'per_page' => $nb_display
);
$videos = $vimeo->request('/tags/'.$importer['tag'].'/videos',$call_params);
$pagi_url = admin_url("vimeo").'&action=tags&tag='.$importer['tag'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';
} elseif($importer['action'] == "user") {
//Import by user's uploads
if(!isset($importer['user']) || empty($importer['user'])) { $importer['user'] = '' ; }
$importer['user'] = str_replace(" ", "+",$importer['user'] );
/* Method to sort by: relevant, newest, oldest, most_played, most_commented, or most_liked. */
$call_params  = array(
'page' => this_page(),
'full_response' => '1',
'per_page' => $nb_display
);
$videos = $vimeo->request('/users/'.$importer['user'].'/videos',$call_params);
//var_dump($videos);
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
'per_page' => $nb_display
);
$videos = $vimeo->request('/channels/'.$importer['channel'].'/videos',$call_params);
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
'per_page' => $nb_display
);
//$videos = $vimeo->call('vimeo.videos.getLikes',$call_params);
$videos = $vimeo->request('/users/'.$importer['likes'].'/likes',$call_params);
//var_dump($videos);
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
'per_page' => $nb_display
);
$videos = $vimeo->request('/albums/'.$importer['album'].'/videos',$call_params);
$pagi_url = admin_url("vimeo").'&action=album&album='.$importer['album'].'&categ='.$importer['categ'];
$pagi_url .= '&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';
} else {
echo 'Missing action/section. Click back and try again.';
}
// Do the import
if(isset($videos) &&  isset($videos['body']['total']) && ($videos['body']['total'] > 0)  ) {
$a = new pagination;
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($nb_display);
$a->set_values($videos['body']['total']);
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
$ooi = 0;
foreach ($videos['body']['data'] as $video) {
$ooi++;
if(!is_null($video)){
/* thumb selection */
$image = array();
$j =1;
foreach ($video['pictures']['sizes'] as $thumb) {
$image[$j] = $thumb['link'];
$j++;
}
if(isset($image['2']) && not_empty($image['2'])) {
$thumb = $image['2'];
} elseif (isset($image['1']) && not_empty($image['1'])) {
$thumb = $image['1'];	
} else {
$thumb = $image['0'];	
}
/* Video source */
$source = $video['link'];
/* duration to sec converting */
$duration = intval($video['duration']);
/* format tags */
$xtags = '';
if(isset($video['tags'])&& !is_null($video['tags'])){
foreach ($video['tags'] as $tag) {
$xtags .= toDb($tag['tag']).", ";
}
}
/* Video description */
$description = ucfirst($video['description']);
/* No remote capabilities */
$remote = '';
?>
<tr>
<td><img src="<?php echo $thumb; ?>" style="width:130px; height:90px;"></td>
<td><?php echo _html(ucfirst($video['name'])); ?></td>
<td><?php echo $video['duration']; ?></td>
<td>
<?php echo _cut($description, 200)."..."; ?>
</td>
<td>
<?php
if($importer['allowduplicates'] > 0) {
echo '<span class="greenText">Imported</span>';
//Insert it
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`, `remote`) VALUES ('".intval(get_option('videos-initial'))."','".$source."', '".user_id()."', now() , '".$thumb."', '".toDb($video['name']) ."', '".intval($duration)."', '".$xtags."', '0', '0','".intval($importer['categ'])."','".toDb($description)."','0','".toDb($remote)."')");
//Done saving
} else {
$check = $db->get_row("SELECT count(*) as dup from ".DB_PREFIX."videos where source ='".toDb($source)."'");
if($check->dup > 0) {
echo '<span class="redText">Skipped as duplicate</span>';
} else {
echo '<span class="greenText">Imported</span>';
//Insert it
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`, `remote`) VALUES  ('".intval(get_option('videos-initial'))."','".$source."', '".user_id()."', now() , '".$thumb."', '".toDb($video['name']) ."', '".intval($duration)."', '".$xtags."', '0', '0','".intval($importer['categ'])."','".toDb($description)."','0','".toDb($remote)."')");
//Done saving
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
if(($importer['auto'] > 0) && ($videos['body']['total'] > 0) && ($next < $importer['endpage'])) {
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
<ul class="nav nav-tabs nav-tabs-line" id="myTab">
<li class="active"><a href="#search">Search results</a></li>
<li><a href="#tags">Tagged with</a></li>
<li><a href="#user">User uploads</a></li>
<li><a href="#channel">User's channel </a></li>
<li><a href="#likes">User's likes</a></li>
<li><a href="#album">Album videos</a></li>
</ul>
<div class="tab-content" style="margin-top:30px">
<div class="tab-pane active" id="search">
<div class="row">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" class="hide" value="search">
<div class="form-group form-material">
<label class="control-label"><i class="icon-search"></i>Keyword</label>
<div class="controls">
<input type="text" name="key" class="validate[required] span8" value="" placeholder="Ex: Rihanna, Nokia, IPhone, Ipad..etc">
</div>
</div>
<div class="form-group form-material">
<label class="control-label">To category:</label>
<div class="controls">
<?php
$cats = cats_select("categ","select","");
echo $cats;
?>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Autopush</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Allow duplicates</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Advanced settings</label>
<div class="controls">
<div class="row">
<div class="col-md-4">
<input class="col-md-12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
</div>
</div>
</div>
</div>
<div class="form-group form-material">
<button type="submit" class="pull-right btn btn-success">Start import</button>
</div>
</form>
</div>
</div>
<div class="tab-pane" id="tags">
<div class="row">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" class="hide" value="tags">
<div class="form-group form-material">
<label class="control-label"><i class="icon-search"></i>Tag</label>
<div class="controls">
<input type="text" name="tag" class="validate[required] span8" value="" placeholder="Ex: Rihanna, Nokia, IPhone, Ipad..etc">
</div>
</div>
<div class="form-group form-material">
<label class="control-label">To category:</label>
<div class="controls">
<?php
$cats = cats_select("categ","select","");
echo $cats;
?>
</select>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Autopush</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Allow duplicates</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Advanced settings</label>
<div class="controls">
<div class="row">
<div class="col-md-4">
<input class="col-md-12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
</div>
</div>
</div>
</div>
<div class="form-group form-material">
<button type="submit" class="pull-right btn btn-success">Start import</button>
</div>
</form>
</div>
</div>
<div class="tab-pane" id="user">
<div class="row">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" class="hide" value="user">
<div class="form-group form-material">
<label class="control-label"><i class="icon-search"></i>User</label>
<div class="controls">
<input type="text" name="user" class="validate[required] span8" value="" placeholder="Ex: for vimeo.com/user8452612 type only user8452612">
</div>
</div>
<div class="form-group form-material">
<label class="control-label">To category:</label>
<div class="controls">
<?php
$cats = cats_select("categ","select","");
echo $cats;
?>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Autopush</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Allow duplicates</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Advanced settings</label>
<div class="controls">
<div class="row">
<div class="col-md-4">
<input class="col-md-12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
</div>
</div>
</div>
</div>
<div class="form-group form-material">
<button type="submit" class="pull-right btn btn-success">Start import</button>
</div>
</form>
</div>
</div>
<div class="tab-pane" id="likes">
<div class="row">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" class="hide" value="likes">
<div class="form-group form-material">
<label class="control-label"><i class="icon-search"></i>User's likes</label>
<div class="controls">
<input type="text" name="likes" class="validate[required] span8" value="" placeholder="Ex: for vimeo.com/user8452612 type only user8452612">
</div>
</div>
<div class="form-group form-material">
<label class="control-label">To category:</label>
<div class="controls">
<?php
$cats = cats_select("categ","select","");
echo $cats;
?>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Autopush</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Allow duplicates</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Advanced settings</label>
<div class="controls">
<div class="row">
<div class="col-md-4">
<input class="col-md-12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
</div>
</div>
</div>
</div>
<div class="form-group form-material">
<button type="submit" class="pull-right btn btn-success">Start import</button>
</div>
</form>
</div>
</div>
<div class="tab-pane" id="album">
<div class="row">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" class="hide" value="album">
<div class="form-group form-material">
<label class="control-label"><i class="icon-search"></i>Album</label>
<div class="controls">
<input type="text" name="album" class="validate[required] span8" value="" placeholder="Ex: for vimeo.com/album/1930045 type only 1930045">
</div>
</div>
<div class="form-group form-material">
<label class="control-label">To category:</label>
<div class="controls">
<?php
$cats = cats_select("categ","select","");
echo $cats;
?>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Autopush</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Allow duplicates</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Advanced settings</label>
<div class="controls">
<div class="row">
<div class="col-md-4">
<input class="col-md-12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
</div>
</div>
</div>
</div>
<div class="form-group form-material">
<button type="submit" class="pull-right btn btn-success">Start import</button>
</div>
</form>
</div>
</div>
<div class="tab-pane" id="channel">
<div class="row">
<form class="form-horizontal styled" action="<?php echo admin_url('vimeo');?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" class="hide" value="channel">
<div class="form-group form-material">
<label class="control-label"><i class="icon-search"></i>Channel ID</label>
<div class="controls">
<input type="text" name="channel" class="validate[required] span8" value="" placeholder="Ex: for vimeo.com/channels/nokia type just nokia">
</div>
</div>
<div class="form-group form-material">
<label class="control-label">To category:</label>
<div class="controls">
<?php
$cats = cats_select("categ","select","");
echo $cats;
?>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Autopush</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Allow duplicates</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>
</div>
</div>
<div class="form-group form-material">
<label class="control-label">Advanced settings</label>
<div class="controls">
<div class="row">
<div class="col-md-4">
<input class="col-md-12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
</div>
<div class="col-md-4">
<input class="col-md-12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
</div>
</div>
</div>
</div>
<div class="form-group form-material">
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