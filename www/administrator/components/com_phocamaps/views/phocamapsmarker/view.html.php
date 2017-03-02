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
jimport( 'joomla.application.component.view' );

class phocaMapsCpViewPhocaMapsMarker extends JView
{
	function display($tpl = null) {
		global $mainframe;
		
		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		
		parent::display($tpl);
	}

	function _displayForm($tpl) {
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();
		$editor =& JFactory::getEditor();
		$document= &JFactory::getDocument();		
		$tmpl	= array();
		$tmpl['catid'] 		= JRequest::getVar( 'catid', 0, 'post', 'int' );// Only for New (New can be added only by POST)
		
		//Data from model
		$item	=& $this->get('Data');
		JHTML::stylesheet( 'phocamaps.css', 'administrator/components/com_phocamaps/assets/' );
		$document->addScript(JURI::base(true).'/components/com_phocamaps/assets/js/coordinates.js');
		
		$lists 	= array();		
		$isNew	= ((int)$item->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'Phoca Maps Markers' ), $item->title );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}

		// Set toolbar items for the page
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Phoca Maps Markers' ).': <small><small>[ ' . $text.' ]</small></small>' , 'map');
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		JToolBarHelper::help( 'screen.phocamaps', true );

		// Edit or Create?
		if (!$isNew) {
			$model->checkout( $user->get('id') );
		} else {
			// initialise new record
			$item->published 		= 1;
			$item->order 			= 0;
			$item->access			= 0;
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, title AS text'
			. ' FROM #__phocamaps_marker'
			. ' ORDER BY ordering';
		$lists['ordering'] 			= JHTML::_('list.specificordering',  $item, $item->id, $query, false );
		// build the html select list
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published );
		
		//build the list of guestbooks
		$query = 'SELECT a.title AS text, a.id AS value'
		. ' FROM #__phocamaps_map AS a'
		. ' WHERE a.published = 1'
		. ' ORDER BY a.ordering';
		$db->setQuery( $query );
		$maps = $db->loadObjectList();
		array_unshift($maps, JHTML::_('select.option', '0', '- '.JText::_('Select Map').' -', 'value', 'text'));
		
		// list maps - if there is a category, display it, if not display the category from markers view
		if (isset($item->catid) && $item->catid > 0) {
			$tmpl['catid'] =  $item->catid;
		}
		$lists['catid'] = JHTML::_( 'select.genericlist', $maps, 'catid',  '', 'value', 'text', $tmpl['catid']);
		
		jimport('joomla.filter.output');
		JFilterOutput::objectHTMLSafe( $item, ENT_QUOTES, 'description' );

		// Map Button
		$latitude	= '50';
		$longitude 	= '-30';
		$zoom		= 2;
		if (isset($item->longitude) && $item->longitude != '') {
			$longitude = $item->longitude;
		}
		if (isset($item->latitude) && $item->latitude != '') {
			$latitude = $item->latitude;
		}
		
		if (isset($item->zoom) && (int)$item->zoom > 0) {
			$zoom = $item->zoom;
		}
		
		
		$linkMap = 'index.php?option=com_phocamaps&amp;view=phocamapsgmap&amp;tmpl=component&amp;lat='.$latitude.'&amp;lng='.$longitude.'&amp;zoom='.$zoom.'&amp;type=marker';
		JHTML::_('behavior.modal', 'a.modal-button');
		$buttonMap = new JObject();
		$buttonMap->set('modal', true);
		$buttonMap->set('link', $linkMap);
		$buttonMap->set('text', JText::_( 'Coordinates' ));
		$buttonMap->set('name', 'image');
		$buttonMap->set('modalname', 'modal-button');
		$buttonMap->set('options', "{handler: 'iframe', size: {x: 640, y: 600}}");
		
			
		$this->assignRef('editor', $editor);
		$this->assignRef('lists', $lists);
		$this->assignRef('item', $item);
		$this->assignRef('buttonmap', $buttonMap);	
		$this->assignRef('tmpl', $tmpl);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
	}
}
?>
