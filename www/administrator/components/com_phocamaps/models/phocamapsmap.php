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
jimport('joomla.application.component.model');
class PhocaMapsCpModelPhocaMapsMap extends JModel
{
	var $_id			= null;
	var $_data			= null;
	
	function __construct() {
		parent::__construct();
		$array 	= JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id) {
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData() {
		if ($this->_loadData()) {
		/*	$user = &JFactory::getUser();
			// Check whether category access level allows access
			if ($this->_data->cat_access > $user->get('aid', 0)) {
				JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
				return;
			}*/
		} else {
			$this->_initData();
		}
		return $this->_data;
	}
	
	function isCheckedOut( $uid=0 ) {
		if ($this->_loadData()) {
			if ($uid) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		}
	}

	function checkin() {
		if ($this->_id) {
			$table = & $this->getTable();
			if(! $table->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}

	function checkout($uid = null) {
		if ($this->_id) {
			// Make sure we have a user id to checkout the article with
			if (is_null($uid)) {
				$user	=& JFactory::getUser();
				$uid	= $user->get('id');
			}
			// Lets get to it and checkout it
			$table = & $this->getTable();
			if(!$table->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}

	function store($data) {	
		
		$row =& $this->getTable();

		// Bind the form fields to the table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// if new item, order last in appropriate group
		if (!$row->id) {
			$row->ordering = $row->getNextOrder( );
		}

		// Make sure table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $row->id;
	}

	function delete($cid = array()) {
		
		$db =& JFactory::getDBO();
		
		$result = false;
	
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'DELETE FROM #__phocamaps_map'
					. ' WHERE id IN ( '.$cids.' )';
				
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	function publish($cid = array(), $publish = 1) {
		$user 	=& JFactory::getUser();

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__phocamaps_map'
				. ' SET published = '.(int) $publish
				. ' WHERE id IN ( '.$cids.' )'
				. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )';
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	function move($direction, $type) {
		$row =& $this->getTable();
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->move( $direction, ' published >= 0 ' )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}


	function saveorder($cid = array(), $order) {
		$row 	=& $this->getTable();
		$total	= count( $cid );

		// update ordering values
		for( $i=0; $i < $total; $i++ )
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg() );
				}
			}
		}
		$row->reorder( );
	}

	function _loadData() {
		if (empty($this->_data)) {
			$query = 'SELECT a.*'
					.' FROM #__phocamaps_map AS a'
					.' WHERE a.id = '.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();		
			return (boolean) $this->_data;
		}
		
		return true;
	}
	
	function _initData() {
		if (empty($this->_data)) {
			$table = new stdClass();
			$table->id					= null;
			$table->title				= null;
			$table->alias				= null;
			$table->width				= 400;
			$table->height				= 360;
			$table->latitude			= 50;
			$table->longitude			= -30;
			$table->zoom				= 2;	
			$table->lang				= '';
			$table->border				= null;
			$table->continuouszoom 		= 1;
			$table->doubleclickzoom 	= 1;
			$table->scrollwheelzoom 	= 1;
			$table->zoomcontrol			= 1;
			$table->scalecontrol 		= 0;
			$table->typeid				= 0;
			$table->typecontrol			= 1;
			$table->typecontrolposition	= 1;
			$table->collapsibleoverview = 1;
			$table->dynamiclabel 		= 0;
			$table->googlebar 			= 1;
			$table->displayroute		= 0;
			$table->kmlfile				= null;
			$table->description			= null;
			$table->published			= null;
			$table->checked_out			= null;
			$table->checked_out_time	= null;
			$table->ordering			= null;
			$table->acces				= null;
			$table->hits				= null;
			$table->params				= null;
			$this->_data				= $table;
			return (boolean) $this->_data;
		}
		return true;
	}
}
?>