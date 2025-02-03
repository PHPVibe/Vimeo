<?php
/**
 * Plugin Name: Vimeo Importer
 * Plugin URI: http://get.phpvibe.com/
 * Description: Mass-video importer for Vimeo
 * Version: 4
 * Author: PHPVibe Crew
 * Author URI: http://www.phpvibe.com
 * License: Commercial
 */

/* file for custom hooks and filters */
function vimeo_menus($txt) {
$txt .= '<li><a href="'.admin_url("vimeo").'"><i class="icon-vimeo-square"></i> Vimeo</a></li>';
return $txt;
}
function vimeo_conf($txt) {
$txt .= '<li><a href="'.admin_url("vimeosetts").'"><i class="icon-vimeo-square"></i> Vimeo Settings</a></li>';
return $txt;
}
add_filter('importers_menu', 'vimeo_menus');
add_filter('configuration_menu', 'vimeo_conf');
?>