<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Maps
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

class PhocaMapsCpViewPhocaMapsInfo extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$tmpl		= array();
		JHTML::stylesheet( 'phocamaps.css', 'administrator/components/com_phocamaps/assets/' );
		JToolBarHelper::title(   JText::_( 'Phoca Maps Info' ), 'info' );
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::help( 'screen.phocamaps', true );
		
		$params = JComponentHelper::getParams('com_phocamaps');
		
		
		$tmpl['version'] 	= PhocaMapsHelper::getPhocaVersion();

		$this->assignRef('tmpl',	$tmpl);
		
		parent::display($tpl);
	}
}
?>
