<?php

/**
 * @package WP Theme Customizer
 */
/*
Thumb Generator
*/

ob_start();

if ( isset( $_GET['thumb'] ) ){

	$thumb = $_GET['thumb'];
	
	$thumb = strip_tags( stripslashes( $thumb ) );
	
}

	$thumb_inf = getimagesize($thumb);
	
	$old_width = $thumb_inf[0];
	
	$old_height = $thumb_inf[1];
	
	$mime = $thumb_inf['mime'];
	
	switch($mime){
	
		case "image/jpeg" : header('Content-type: image/jpeg'); break;
		case "image/png"  : header('Content-type: image/png'); break;
		case "image/gif"  : header('Content-type: image/gif'); break;
		default  		  : header('Content-type: image/jpeg'); break;
		
	}
	
	$new_width = 25;
	
	$new_height = 25;
	
	$new_thumb = imagecreatetruecolor($new_width, $new_height);
	
	switch($mime){
	
		case "image/jpeg" : $old_thumb = imagecreatefromjpeg($thumb); break;
		case "image/png"  : $old_thumb = imagecreatefrompng($thumb); break;
		case "image/gif"  : $old_thumb = imagecreatefromgif($thumb); break;
		default			  : $old_thumb = imagecreatefromjpeg($thumb); break;
		
	}
	
	imagecopyresized($new_thumb, $old_thumb, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
	
	switch($mime){
	
		case "image/jpeg" : imagejpeg($new_thumb); break;
		case "image/png"  : imagepng($new_thumb); break;
		case "image/gif"  : imagegif($new_thumb); break;
		default			  : imagejpeg($new_thumb); break;
		
	}

?>