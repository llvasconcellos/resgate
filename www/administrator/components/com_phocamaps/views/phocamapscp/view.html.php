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

class PhocaMapsCpViewPhocaMapsCp extends JView
{
	function display($tpl = null) {
		
		$component 		= 'phocamaps';
		$componentName	= 'Phoca Maps';
		
		JHTML::stylesheet( $component.'.css', 'administrator/components/com_'.$component.'/assets/' );
		
		global $mainframe;
		$uri		=& JFactory::getURI();
		$document	=& JFactory::getDocument();
		$db		    =& JFactory::getDBO();
		
		JToolBarHelper::title(  JText::_( $componentName .' Control Panel' ), 'phocamaps' );
		JToolBarHelper::preferences('com_'.$component, '460');
		JToolBarHelper::help( 'screen.'.$component, true );

		JHTML::_('behavior.tooltip');
		$version = PhocaMapsHelper::getPhocaVersion('com_'.$component);
		$this->assignRef('version',	$version);
		
		parent::display($tpl);
		
	}
}
?>