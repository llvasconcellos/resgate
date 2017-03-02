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
jimport('joomla.application.component.controller');

// Submenu view
$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );

if ($view == '' || $view == 'phocamapscp') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_('Maps'), 'index.php?option=com_phocamaps&view=phocamapsmaps');
	JSubMenuHelper::addEntry(JText::_('Markers'), 'index.php?option=com_phocamaps&view=phocamapsmarkers' );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocamaps&view=phocamapsinfo' );
}

if ($view == 'phocamapsmaps') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_('Maps'), 'index.php?option=com_phocamaps&view=phocamapsmaps', true);
	JSubMenuHelper::addEntry(JText::_('Markers'), 'index.php?option=com_phocamaps&view=phocamapsmarkers' );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocamaps&view=phocamapsinfo' );
}

if ($view == 'phocamapsmarkers') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_('Maps'), 'index.php?option=com_phocamaps&view=phocamapsmaps');
	JSubMenuHelper::addEntry(JText::_('Markers'), 'index.php?option=com_phocamaps&view=phocamapsmarkers', true );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocamaps&view=phocamapsinfo' );
}


if ($view == 'phocamapsinfo') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_('Maps'), 'index.php?option=com_phocamaps&view=phocamapsmaps');
	JSubMenuHelper::addEntry(JText::_('Markers'), 'index.php?option=com_phocamaps&view=phocamapsmarkers' );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocamaps&view=phocamapsinfo', true );
}


class phocaMapsCpController extends JController
{
	function display() {
		parent::display();
	}
}
?>
