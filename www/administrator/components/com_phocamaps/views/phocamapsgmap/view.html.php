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
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view');

class PhocaMapsCpViewPhocaMapsGMap extends JView
{
	function display($tpl = null) {
		global $mainframe;

		$uri 		=& JFactory::getURI();
		$params 	= &JComponentHelper::getParams( 'com_phocamaps' );
		$apiKey 	= $params->get( 'google_maps_api_key', '' );
		$document	= & JFactory::getDocument();
		$document->addStyleSheet(JURI::base(true).'/components/com_phocamaps/assets/phocamaps.css');
		
		$latitude	= JRequest::getVar( 'lat', '50', 'get', 'string' );
		$longitude	= JRequest::getVar( 'lng', '-30', 'get', 'string' );
		$zoom		= JRequest::getVar( 'zoom', '2', 'get', 'string' );
		$type		= JRequest::getVar( 'type', 'map', 'get', 'string' );

		$this->assignRef('zoom', $zoom);
		$this->assignRef('longitude', $longitude);
		$this->assignRef('latitude', $latitude);
		$this->assignRef('type', $type);
		$this->assignRef('apikey', $apiKey);
		$this->assignRef('request_url',	$uri->toString());
		parent::display($tpl);
	}
}
?>