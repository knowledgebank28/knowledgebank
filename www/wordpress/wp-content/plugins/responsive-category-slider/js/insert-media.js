/**
 * @package   Responsive Category Slider
 * @author     ThemeLead Team <support@themelead.com>
 * @copyright  Copyright 2014 themelead.com. All Rights Reserved.
 * @license    GPLv2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.themelead.com
 * Technical Support:  Free Forum Support - http://support.themelead.com
 */
jQuery(document).ready(function() {
 
	jQuery('#b_upload_background_image_button').click(function() {
	 formfield = jQuery('#b_upload_image').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 return false;
	});
	 
	window.send_to_editor = function(html) {
	 imgurl = jQuery('img',html).attr('src');
	 jQuery('#b_upload_image').val(imgurl);
	 tb_remove();
	}

});