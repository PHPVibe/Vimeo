<?php /* file for custom hooks and filters */
function vimeo_menus($txt) {
$txt .= '<li><a href="'.admin_url("vimeo").'"><i class="icon-vimeo-square"></i>Vimeo</a></li>';
return $txt;
}
function vimeo_conf($txt) {
$txt .= '<li><a href="'.admin_url("vimeosetts").'"><i class="icon-vimeo-square"></i>Vimeo Settings</a></li>';
return $txt;
}
add_filter('importers_menu', 'vimeo_menus');
add_filter('configuration_menu', 'vimeo_conf');
?>