<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @plugin Phoca Plugin
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
defined('_JEXEC') or die('Restricted access');// no direct access
if (!JComponentHelper::isEnabled('com_phocagallery', true)) {
	return JError::raiseError(JText::_('Phoca Gallery Error'), JText::_('Phoca Gallery is not installed on your system'));
}
if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries'.DS.'loader.php');
}
phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.path.route');
phocagalleryimport('phocagallery.file.file');
phocagalleryimport('phocagallery.file.filethumbnail');
phocagalleryimport('phocagallery.ordering.ordering');

class plgContentPhocaGalleryslideshow extends JPlugin
{	
	function plgContentPhocaGalleryslideshow( &$subject, $params ){
		parent::__construct( $subject, $params  );
    }

	function onPrepareContent( &$article, &$params, $limitstart = 0 ) {
		$db 		= &JFactory::getDBO();
		$document	= &JFactory::getDocument();
		$path 		= PhocaGalleryPath::getPath();
		$menu 		= &JSite::getMenu();
		
		$document->addScript( JURI::base(true) . '/plugins/content/phocagalleryslideshow.js');
		
		// PARAMS - direct from Phoca Gallery Global configuration
		$component 		= 'com_phocagallery';
		$table 			=& JTable::getInstance('component');
		$table->loadByOption( $component );
		$paramsC	 	= new JParameter( $table->params );

		// Start Plugin
		$regex_one		= '/({pgslideshow\s*)(.*?)(})/si';
		$regex_all		= '/{pgslideshow\s*.*?}/si';
		$matches 		= array();
		$count_matches	= preg_match_all($regex_all,$article->text,$matches,PREG_OFFSET_CAPTURE | PREG_PATTERN_ORDER);
		$customCSS		= '';
		$customCSS2		= '';
		
		for($j = 0; $j < $count_matches; $j++) {
			// Plugin variables
			$id						= 0;
			$width 					= 640;
			$height					= 480;
			$delay					= 3000;
			$image					= 'L';
			$tmpl['pgslink']		= 0;
			$tmpl['imageordering']	= $paramsC->get( 'image_ordering', 9);
			
			// Get plugin parameters
			$phocagallery	= $matches[0][$j][0];
			preg_match($regex_one,$phocagallery,$phocagallery_parts);
			$parts			= explode("|", $phocagallery_parts[2]);
			$values_replace = array ("/^'/", "/'$/", "/^&#39;/", "/&#39;$/", "/<br \/>/");

			foreach($parts as $key => $value) {
				
				$values = explode("=", $value, 2);
				foreach ($values_replace as $key2 => $values2) {
					$values = preg_replace($values2, '', $values);
				}
				
				// Get plugin parameters from article
				if($values[0]=='id')					{$id					= $values[1];}
				else if($values[0]=='height')			{$height				= $values[1];}
				else if($values[0]=='width')			{$width					= $values[1];}
				else if($values[0]=='delay')			{$delay					= $values[1];}
				else if($values[0]=='image')			{$image					= $values[1];}
				else if($values[0]=='pgslink')			{$tmpl['pgslink']		= $values[1];}
				else if($values[0]=='imageordering')	{$tmpl['imageordering']	= $values[1];}
			}
			
			if ($id > 0) {
			
				if ($tmpl['imageordering'] == 9) {
					$imageOrdering = ' ORDER BY RAND()'; 
				} else {
					$imageOrdering = ' ORDER BY a.'.PhocaGalleryOrdering::getOrderingString($tmpl['imageordering']);
				}
			
				$c = time() * rand(0,10);							
				$query     = ' SELECT a.filename, cc.id as catid, cc.alias as catalias, a.extid, a.exts, a.extm, a.extl, a.exto,'
						   . ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END as catslug'
						   . ' FROM #__phocagallery_categories AS cc'
						   . ' LEFT JOIN #__phocagallery AS a ON a.catid = cc.id'
						   . ' WHERE cc.published = 1'
						   . ' AND a.published = 1'
						   . ' AND cc.approved = 1'
						   . ' AND a.approved = 1'
						   . ' AND a.catid = ' . (int)$id
						   . $imageOrdering;
				$db->setQuery($query);
				$images = $db->loadObjectList();
				
				$script  = '<script type="text/javascript">' . "\n";
				$script .= 'fadeimages'.$c.' = new Array();' . "\n";
				
				$output = '';
				$n = count( $images );
				if ($n > 0) {
					for ($i = 0; $i < $n; $i++) {
						
						switch ($image) {
							case 'S':
								$imageName = PhocaGalleryFileThumbnail::getThumbnailName($images[$i]->filename, 'small');
								$imageName->ext = $images[$i]->exts;
							break;
							
							case 'M':
								$imageName = PhocaGalleryFileThumbnail::getThumbnailName($images[$i]->filename, 'medium');
								$imageName->ext = $images[$i]->extm;
							break;
							
							case 'O':
								$imageName->rel = PhocaGalleryFile::getFileOriginal($images[$i]->filename , 1);
								$imageName->ext = $images[$i]->exto;
							break;
							
							case 'L':
							default:
							$imageName = PhocaGalleryFileThumbnail::getThumbnailName($images[$i]->filename, 'large');
								$imageName->ext = $images[$i]->extl;
							
							
							break;
						}
						if (isset($images[$i]->extid) && $images[$i]->extid != '') {
							$script .= 'fadeimages'.$c.'['.$i.'] = [\'' .$imageName->ext	. '\', \'\', \'\'];'. "\n";
						} else {
							$script .= 'fadeimages'.$c.'['.$i.'] = [\'' . JURI::base(true).'/'.$imageName->rel . '\', \'\', \'\'];'. "\n";
						}
					}
					
					$siteLink = '';
					if (isset($images[0]->catid)) {
						if ((int)$tmpl['pgslink'] == 2) {
							// Different Link - to all categories
							$siteLink = JRoute::_(PhocaGalleryRoute::getCategoriesRoute());
						} else if ((int)$tmpl['pgslink'] == 1) {
							// Different Link - to all category
							$siteLink = JRoute::_(PhocaGalleryRoute::getCategoryRoute($images[0]->catid, $images[0]->catalias));
						}
					}
					
					//$script .= 'new fadeshow(fadeimages'.$c.', '.$width.', '.$height.', 0, '.$delay.', 1, \'R\')' . "\n";
					// Added by Ingo
					$script .= "function fadeshowladen".$c."() {\n";
					$script .= 'new fadeshow(fadeimages'.$c.', '.$width.', '.$height.', 0, '.$delay.', 1, \'\', \'phocagallerycontent'.$c.'\');' . "\n";
					$script .= "}\n";

					$script .= "if(window.onload) {\n";
					$script .= "var temp = window.onload;\n";
					$script .= "window.onload=function(e) {\n";
					$script .= "temp(e);\n";
					$script .= "fadeshowladen".$c."();\n";
					$script .= "};\n}\n else{\n window.onload=function(e) {\n";
					$script .= "fadeshowladen".$c."();\n";
					$script .= "};\n}";

	/*            $script .= 'new fadeshow(fadeimages'.$c.', '.$width.', '.$height.', 0, '.$delay.', 1, \'R\')' . "\n";*/
					$script .= '</script>'. "\n";
					
					$output .= '<div class="phocagalleryslideshow" style="text-align:center;">' . "\n";
					if ($siteLink != '') {
						$output .= '<a href="'.$siteLink.'" ><span id="phocagallerycontent'.$c.'"></span></a>'. "\n";
					} else {
						$output .= '<div id="phocagallerycontent'.$c.'"></div>';
					}
					$output .=$script;
					$output .='</div>';
					$c++;
					
				} else {
					$output .= JText::_('There is no image or category is unpublished or not authorized');
				}
				$article->text = preg_replace($regex_all, $output, $article->text, 1);
			}
		}
		return true;
	}
}
?>
