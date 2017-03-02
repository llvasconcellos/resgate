<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class TablePhocaMapsMap extends JTable
{
	var $id					= null;
	var $title				= null;
	var $alias				= null;
	var $width				= null;
	var $height				= null;
	var $latitude			= null;
	var $longitude			= null;
	var $zoom				= null;
	var $lang				= '';
	var $border				= null;
	var $continuouszoom 	= 1;
	var $doubleclickzoom 	= 1;
	var $scrollwheelzoom 	= 1;
	var $zoomcontrol		= 1;
	var $scalecontrol 		= 0;
	var $typeid				= 0;
	var $typecontrol		= 1;
	var $typecontrolposition= 1;
	var $collapsibleoverview= 1;
	var $dynamiclabel 		= 0;
	var $googlebar 			= 1;
	var $displayroute		= 0;
	var $kmlfile			= null;
	var $description		= null;
	var $published			= null;
	var $checked_out		= null;
	var $checked_out_time	= null;
	var $ordering			= null;
	var $acces				= null;
	var $hits				= null;
	var $params				= null;
	

	function __construct( &$db ) {
		parent::__construct( '#__phocamaps_map', 'id', $db );
	}
	
	function check() {
		if (trim( $this->title ) == '') {
			$this->setError( JText::_( 'Map must have a title') );
			return false;
		}

		if(empty($this->alias)) {
			$this->alias = $this->title;
		}
		
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		if(trim(str_replace('-','',$this->alias)) == '') {
			$datenow =& JFactory::getDate();
			$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}
		return true;
	}
}
?>