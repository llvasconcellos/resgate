<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */ 
defined('_JEXEC') or die();
class PhocaMapsHelper
{	
	function strTrimAll($input) {
		$output	= '';;
	    $input	= trim($input);
	    for($i=0;$i<strlen($input);$i++) {
	        if(substr($input, $i, 1) != " ") {
	            $output .= trim(substr($input, $i, 1));
	        } else {
	            $output .= " ";
	        }
	    }
	    return $output;
	}

	function getPhocaVersion() {
		$component = 'com_phocamaps';
		$folder = JPATH_ADMINISTRATOR .DS. 'components'.DS.$component;
		
		if (JFolder::exists($folder)) {
			$xmlFilesInDir = JFolder::files($folder, '.xml$');
		} else {
			$folder = JPATH_SITE .DS. 'components'.DS.$component;
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$xmlFilesInDir = null;
			}
		}

		$xml_items = '';
		if (count($xmlFilesInDir))
		{
			foreach ($xmlFilesInDir as $xmlfile)
			{
				if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
					foreach($data as $key => $value) {
						$xml_items[$key] = $value;
					}
				}
			}
		}
		
		if (isset($xml_items['version']) && $xml_items['version'] != '' ) {
			return $xml_items['version'];
		} else {
			return '';
		}
	}
	
	function getInfo() {
		return ""; //base64_decode('PGRpdiBzdHlsZT0idGV4dC1hbGlnbjogcmlnaHQ7IGNvbG9yOiByZ2IoMjExLCAyMTEsIDIxMSk7IGNsZWFyOiBib3RoOyBtYXJnaW4tdG9wOiAxMHB4O21hcmdpbi1ib3R0b206MTBweDsiPlBvd2VyZWQgYnkgPGEgaHJlZj0iaHR0cDovL3d3dy5waG9jYS5jeiIgc3R5bGU9InRleHQtZGVjb3JhdGlvbjogbm9uZTsiIHRhcmdldD0iX2JsYW5rIiB0aXRsZT0iUGhvY2EuY3oiPlBob2NhPC9hPiA8YSBocmVmPSJodHRwOi8vd3d3LnBob2NhLmN6L3Bob2NhbWFwcyIgc3R5bGU9InRleHQtZGVjb3JhdGlvbjogbm9uZTsiIHRhcmdldD0iX2JsYW5rIiB0aXRsZT0iUGhvY2EgTWFwcyI+TWFwczwvYT48L2Rpdj4=');	
	}
	
}
?>