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
class PhocaMapsCpModelPhocaMapsMarkers extends JModel
{
	var $_data 			= null;
	var $_total 		= null;
	var $_pagination 	= null;

	function __construct() {
		parent::__construct();

		global $mainframe;		
		
		$context	= 'com_phocamaps.markers.list.';
		$limit		= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $context.'limitstart',	'limitstart',	0, 'int' );
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	function getData() {
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	}

	function getTotal() {
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}

	function getPagination() {
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function _buildQuery() {
		$context	= 'com_phocamaps.markers.list.';
		$where		= $this->_buildContentWhere($context);
		$orderby	= $this->_buildContentOrderBy($context);
			
		$query = 'SELECT a.*, u.name AS editor, cc.title AS catidname '
				.' FROM #__phocamaps_marker AS a '
				.' LEFT JOIN #__phocamaps_map AS cc ON cc.id = a.catid '
				.' LEFT JOIN #__users AS u ON u.id = a.checked_out '
				. $where
				. $orderby;
		return $query;
	}

	function _buildContentOrderBy($context) {
		global $mainframe;
		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'',	'word' );

		if ($filter_order == 'a.ordering'){
			$orderby 	= ' ORDER BY a.catid, a.ordering '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' a.catid, a.ordering ';
		}
		return $orderby;
	}

	function _buildContentWhere($context) {
		global $mainframe;
		$filter_state		= $mainframe->getUserStateFromRequest( $context.'filter_state',	'filter_state', '',	'word' );
		$filter_catid		= $mainframe->getUserStateFromRequest( $context.'filter_catid', 'filter_catid', 0, 'int' );
		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		$search				= $mainframe->getUserStateFromRequest( $context.'search', 'search', '', 'string' );
		$search				= JString::strtolower( $search );

		$where = array();
		
		if ($filter_catid > 0) {
			$where[] = 'a.catid = '.(int) $filter_catid;
		}

		if ($search) {
			$where[] = 'LOWER(a.title) LIKE '.$this->_db->Quote('%'.$search.'%');
		}
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = 'a.published = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 'a.published = 0';
			}
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
	}
}
?>