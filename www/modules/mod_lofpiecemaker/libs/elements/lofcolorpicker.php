<?php
/**
 * $ModDesc
 * 
 * @version	$Id: helper.php $Revision
 * @package	modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license	GNU General Public License version 2
 */
  // no direct access
defined('_JEXEC') or die('Restricted access');

class JElementLofcolorpicker extends JElement {

	var	$_name = 'Lofcolorpicker';
	
	function fetchElement($name, $value, &$node, $control_name){
		
        $uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
		$uri = str_replace("/administrator", "", $uri);
		$string = ' <input type="text" class="text_area" value="'.$value.'" '
				.'id="params'.$name.'" name="params['.$name.']"  />';

        $string .=  '<div id="preview-'.$name.'" style="padding-left:3px;float:left; display:block"><img id="img-'.$name.'" src="'.$uri.'/colorpicker/images/rainbow.png" alt="[r]" width="16" style="margin-right:4px;cursor:hand;cursor:pointer" height="16"/></div>';

		$string .= "
				<script type='text/javascript'>
				window.addEvent('domready', function() {
					var r = new MooRainbow('img-".$name."', {
						'startColor': [58, 142, 246],
						id:'img-".$name."',
						imgPath:'".$uri."/colorpicker/images/',
						'onChange': function(color) {
							$('params".$name."').value = color.hex.replace('#','');
					
							$('preview-".$name."').setStyle('background', '#' + $('params".$name."').value );
						}
					});
					
					if( $('params".$name."').value != '' ) {
						$('preview-".$name."').setStyle('background', '#' + $('params".$name."').value );
					}
				});
			</script>	
		";


		
		JHTML::stylesheet('colorpicker/mooRainbow.css', $uri."/");
		JHTML::script('colorpicker/mooRainbow.js', $uri."/");
		return $string;	
	}
}
?>
