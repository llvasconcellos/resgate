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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class PhocaMapsModelMap extends JModel
{
	var $_id			= null;
	var $_data			= null;

	function __construct() {
		parent::__construct();
		$id 	= JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	}
	
	function setId($id){
		$this->_id			= $id;
		$this->_data		= null;
	}
	
	
	function &getData() {
		if (!$this->_loadData()) {
			$this->_initData();
		}
		return $this->_data;
	}
	
	function _loadData() {
		if (empty($this->_data)) {
			$query = 'SELECT a.*'
					.' FROM #__phocamaps_map AS a'
					.' WHERE a.id = '.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data['map'] = $this->_db->loadObject();
			
			$query = 'SELECT a.*'
					.' FROM #__phocamaps_marker AS a'
					.' LEFT JOIN #__phocamaps_map AS c ON c.id = a.catid '
					.' WHERE c.id = '.(int) $this->_id
					.' AND a.published = 1';
			$this->_db->setQuery($query);
			$this->_data['marker'] = $this->_db->loadObjectList();
			
			return (boolean) $this->_data;
		}
		
		return true;
	}
	
	
	function _initData() {
		if (empty($this->_data)) {
			$this->_data	= '';
			return (boolean) $this->_data;
		}
		return true;
	}
}
?>
