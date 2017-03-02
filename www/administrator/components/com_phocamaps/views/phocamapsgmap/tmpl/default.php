<?php
defined('_JEXEC') or die('Restricted access');

echo '<div id="phocamaps">';
$id		= '';
$map	= new PhocaMapsMap($id);
if ($this->type == 'marker') {
	$map->loadCoordinatesJS();
}
$map->loadAPI();

echo '<div align="center" style="margin:0;padding:0">';
echo '<div id="phocaMap'.$id.'" style="margin:0;padding:0;width:620px;height:540px"></div></div>';

echo $map->startJScData();

	echo $map->addAjaxAPI('maps', '3.x', '{"other_params":"sensor=false"}');
	echo $map->addAjaxAPI('search', '1');

	echo $map->createMap('phocaMap', 'mapPhocaMap', 'phocaLatLng', 'phocaOptions','tstPhocaMap', 'tstIntPhocaMap', 'phocaGeoCoder', TRUE);
	echo $map->cancelEventFunction();
	echo $map->checkMapFunction();

	echo $map->startMapFunction();
	
		echo $map->setLatLng( $this->latitude, $this->longitude );
		echo $map->startMapOptions();
		echo $map->setMapOption('zoom', $this->zoom).','."\n";
		echo $map->setCenterOpt().','."\n";
		echo $map->setTypeControlOpt().','."\n";
		echo $map->setNavigationControlOpt().','."\n";
		echo $map->setMapOption('scaleControl', 1, TRUE ).','."\n";
		echo $map->setMapOption('scrollwheel', 1).','."\n";
		echo $map->setMapOption('disableDoubleClickZoom', 0).','."\n";
	//	echo $map->setMapOption('googleBar', $this->map->googlebar).','."\n";// Not ready yet
	//	echo $map->setMapOption('continuousZoom', $this->map->continuouszoom).','."\n";// Not ready yet
		echo $map->setMapTypeOpt()."\n";
		echo $map->endMapOptions();
		echo $map->setMap();
		
		echo $map->exportZoom($this->zoom, 'window.top.document.forms.adminForm.elements.zoom');
		echo $map->exportMarker('Global', $this->type, $this->latitude, $this->longitude, 'window.top.document.forms.adminForm.elements.latitude', 'window.top.document.forms.adminForm.elements.longitude');
		echo $map->setListener();
		echo $map->setGeoCoder();
		echo $map->endMapFunction();

	echo $map->addAddressToMapFunction('Global', 'phocaAddressEl', $this->type, 'window.top.document.forms.adminForm.elements.latitude', 'window.top.document.forms.adminForm.elements.longitude');// no '.id.' - it is set in class

	echo $map->setInitializeFunction();
	
echo $map->endJScData();


echo '<div class="p-add-address">'
. '<form action="#" onsubmit="addAddressToMap'.$id.'(); return false;">'
. JText::_('Set Coordinates by address').' : '
. '<input type="text" name="phocaAddressNameEl'.$id.'" id="phocaAddressEl'.$id.'" value="" class="address_input" size="30" />'
. '<input type="submit" name="find" value="'. JText::_('Set').'" />'
. '</form>'
. '</div>';
echo '</div>';
?>
