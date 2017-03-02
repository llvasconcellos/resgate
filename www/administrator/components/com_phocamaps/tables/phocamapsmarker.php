<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class TablePhocaMapsMarker extends JTable
{
	var $id					= null;
	var $catid				= null;
	var $title				= null;
	var $alias				= null;
	var $latitude			= null;
	var $longitude			= null;
	var $gpslatitude		= null;
	var $gpslongitude		= null;
	var $displaygps			= null;
	var $icon				= null;
	var $description		= null;
	var $contentwidth		= '';
	var $contentheight		= '';
	var $markerwindow		= null;
	var $published			= null;
	var $checked_out		= null;
	var $checked_out_time	= null;
	var $ordering			= null;
	var $acces				= null;
	var $hits				= null;
	var $params				= null;

	function __construct( &$db ) {
		parent::__construct( '#__phocamaps_marker', 'id', $db );
	}
	
	function check() {
		if (trim( $this->title ) == '') {
			$this->setError( JText::_( 'Marker must have a title') );
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