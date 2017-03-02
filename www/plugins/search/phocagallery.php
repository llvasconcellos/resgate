<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
$mainframe->registerEvent( 'onSearch', 'plgSearchPhocagallery' );
$mainframe->registerEvent( 'onSearchAreas', 'plgSearchPhocagalleryAreas' );
JPlugin::loadLanguage( 'plg_search_phocagallery' );

if (!JComponentHelper::isEnabled('com_phocagallery', true)) {
	return JError::raiseError(JText::_('Phoca Gallery Error'), JText::_('Phoca Gallery is not installed on your system'));
}
if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries'.DS.'loader.php');
}
phocagalleryimport('phocagallery.path.route');

function &plgSearchPhocagalleryAreas() {
	static $areas = array(
		'phocagallery' => 'Phoca Gallery'
	);
	return $areas;
}

function plgSearchPhocagallery( $text, $phrase = '', $ordering = '', $areas = null ) {
	
	$db		= &JFactory::getDBO();
	$user	= &JFactory::getUser();
	$menu 	= &JSite::getMenu();

	if (is_array( $areas )) {
		if (!array_intersect( $areas, array_keys( plgSearchPhocagalleryAreas() ) )) {
			return array();
		}
	}

	// load plugin params info
 	$plugin 		= &JPluginHelper::getPlugin('search', 'phocagallery');
 	$pluginParams 	= new JParameter( $plugin->params );
	$limit 			= $pluginParams->def( 'search_limit', 50 );

	$text = trim( $text );
	if ($text == '') {
		return array();
	}

	$section = JText::_( 'Phoca Gallery');

	switch ( $ordering ) {
		case 'alpha':
			$orderingCode = 'a.title ASC';
			break;

		case 'category':
			$orderingCode = 'a.id ASC';
			break;

		case 'popular':
		case 'newest':
		case 'oldest':
		default:
			$orderingCode = 'a.title ASC';
	}

	$text	= $db->Quote( '%'.$db->getEscaped( $text, true ).'%', false );


	$rows = array();
	
	// Categories
	$query = 'SELECT a.id, a.title AS title, a.alias, "" AS created,'
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug,'
		. ' a.description AS text,'
		. ' CONCAT_WS( " / ", '.$db->Quote($section).', a.title ) AS section,'
		. ' "2" AS browsernav'
		. ' FROM #__phocagallery_categories AS a'
		. ' WHERE ( a.title LIKE '.$text
		. ' OR a.name LIKE '.$text
		. ' OR a.metakey LIKE '.$text
		. ' OR a.metadesc LIKE '.$text
		. ' OR a.description LIKE '.$text.' )'
		. ' AND a.published = 1'
		. ' AND a.approved = 1'
		. ' AND a.access <= '.(int) $user->get( 'aid' )
		. ' GROUP BY a.id'
		. ' ORDER BY '. $orderingCode;
	
	$db->setQuery( $query, 0, $limit );
	$listCategories = $db->loadObjectList();
	$limit -= count($listCategories);

	if(isset($listCategories)) {
		foreach($listCategories as $key => $value) {
			
			$listCategories[$key]->href = $link = JRoute::_(PhocaGalleryRoute::getCategoryRoute($value->id, $value->alias));
		}
	}
	$rows[] = $listCategories;

	// Images
	if ( $limit > 0 ) {
		switch ( $ordering ) {
		case 'alpha':
			$orderingCode = 'a.title ASC';
			break;
		case 'category':
			$orderingCode = 'b.title ASC, a.title ASC';
			break;
		case 'popular':
		case 'newest':
			$orderingCode = 'a.date ASC';
			break;
		case 'oldest':
			$orderingCode = 'a.date DESC';
			break;
		default:
			$orderingCode = 'a.title ASC';
		}
	
		$query	= 'SELECT '
		. ' CASE WHEN CHAR_LENGTH(a.title) THEN CONCAT_WS(\': \', b.title, a.title)
	ELSE b.title END AS title, '
		. ' CASE WHEN CHAR_LENGTH(a.description) THEN CONCAT_WS(\': \', a.title,
	a.description) ELSE a.title END AS text, '
		. ' a.id, a.date AS created, '
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '
		. ' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(\':\', b.id, b.alias) ELSE b.id END AS catslug, '
		. ' CONCAT_WS( " / ", '.$db->Quote($section).', a.title ) AS section,'
		. ' "2" AS browsernav, b.id as catid, b.alias as catalias'
		. ' FROM #__phocagallery AS a'
		. ' LEFT JOIN #__phocagallery_categories AS b ON b.id = a.catid'
		. ' WHERE ( a.title LIKE '.$text
		. ' OR a.filename LIKE '.$text
		. ' OR a.metakey LIKE '.$text
		. ' OR a.metadesc LIKE '.$text
		. ' OR a.description LIKE '.$text.' )'
		. ' AND a.published = 1'
		. ' AND b.published = 1'
		. ' AND a.approved = 1'
		. ' AND b.approved = 1'
		. ' AND b.access <= '.(int) $user->get( 'aid' )
		. ' ORDER BY '. $orderingCode;

		$db->setQuery( $query, 0, $limit );
		$listImages = $db->loadObjectList();

		if(isset($listImages)) {
			foreach($listImages as $key => $value) {
				
				$listImages[$key]->href = JRoute::_(PhocaGalleryRoute::getCategoryRoute($value->catid, $value->catalias));
			}
		}
		$rows[] = $listImages;
	}
	
	$results = array();
	if(count($rows)) {
		foreach($rows as $row) {
			$results = array_merge($results, (array) $row);
		}
	}
	
	return $results;
}
