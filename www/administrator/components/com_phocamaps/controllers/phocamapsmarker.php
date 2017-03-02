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

class PhocaMapsCpControllerPhocaMapsMarker extends PhocaMapsCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply'  , 'save' );
	}
	
	function edit() {
		JRequest::setVar( 'view', 'phocamapsmarker' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );

		parent::display();

		// Checkin
		$model = $this->getModel( 'phocamapsmarker' );
		$model->checkout();
	}

	function save() {
		$post					= JRequest::get('post');
		$cid					= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['description']	= JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['id'] 			= (int) $cid[0];
		
		$model = $this->getModel( 'phocamapsmarker' );
		
		switch ( JRequest::getCmd('task') ) {
			case 'apply':
				$id	= $model->store($post);//you get id and you store the table data
				if ($id && $id > 0) {
					$msg = JText::_( 'Changes to Phoca Maps Markers Saved' );
					//$id		= $model->store($post);
				} else {
					$msg = JText::_( 'Error Saving Phoca Maps Markers' );
					$id		= $post['id'];
				}
				$this->setRedirect( 'index.php?option=com_phocamaps&controller=phocamapsmarker&task=edit&cid[]='. $id, $msg );
				break;

			case 'save':
			default:
				if ($model->store($post)) {
					$msg = JText::_( 'Phoca Maps Markers Saved' );
				} else {
					$msg = JText::_( 'Error Saving Phoca Maps Markers' );
				}
				$this->setRedirect( 'index.php?option=com_phocamaps&view=phocamapsmarkers', $msg );
				break;
		}
		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
	}

	function remove() {
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		
		
		$model = $this->getModel( 'phocamapsmarker' );
		
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Deleting Phoca Maps Markers' );
		} else {
			$msg = JText::_( 'Phoca Maps Markers Deleted' );
		}

		$link = 'index.php?option=com_phocamaps&view=phocamapsmarkers';
		$this->setRedirect( $link, $msg );
	}

	function publish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('phocamapsmarker');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$link = 'index.php?option=com_phocamaps&view=phocamapsmarkers';
		$this->setRedirect($link);
	}

	function unpublish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('phocamapsmarker');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$link = 'index.php?option=com_phocamaps&view=phocamapsmarkers';
		$this->setRedirect($link);
	}

	function cancel() {
		$model = $this->getModel( 'phocamapsmarker' );
		$model->checkin();

		$link = 'index.php?option=com_phocamaps&view=phocamapsmarkers';
		$this->setRedirect( $link );
	}

	function orderup() {
		$model = $this->getModel( 'phocamapsmarker' );
		$model->move(-1);

		$link = 'index.php?option=com_phocamaps&view=phocamapsmarkers';
		$this->setRedirect( $link );
	}

	function orderdown() {
		$model = $this->getModel( 'phocamapsmarker' );
		$model->move(1);

		$link = 'index.php?option=com_phocamaps&view=phocamapsmarkers';
		$this->setRedirect( $link );
	}

	function saveorder() {
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel( 'phocamapsmarker' );
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$link = 'index.php?option=com_phocamaps&view=phocamapsmarkers';
		$this->setRedirect( $link, $msg  );
	}
}
?>
