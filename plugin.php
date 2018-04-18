<?php
/*
Plugin Name: Image Renamer
Plugin URI: http://lorispinna.com/wp/image_renamer/
Description: A plugin to rename all uploads file without accents
Version: 1.1
Author: Loris Pinna
Author URI: http://lorispinna.com
License: A "Slug" license name e.g. GPL2
*/

include "AccentList.php";
include "UploadScanner.php";
$UploadScanner = new UploadScanner();

include "pages/Renamer.php";
$Renamer = new Renamer();


add_action('admin_head', 'image_renamer_design');

function image_renamer_design() {
    echo '<link rel="stylesheet" href="'.plugins_url( './design/style.css', __FILE__ ).'" type="text/css" media="all" />';
}