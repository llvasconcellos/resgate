<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); 

echo PhocaMapsRender::renderSubmitButtonJs(array(
		0 => array('title', 'Marker must have a title', 'true', 1),
		1 =>array('catid', 'You must select a map', 'true', 0))
	);
echo PhocaMapsRender::renderFormStyle();?>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
<div class="col50">
<fieldset class="adminform">
	<legend><?php echo JText::_('Basic Settings'); ?></legend>
	<table class="admintable">		
		<?php		
		echo PhocaMapsRender::renderFormInput('title', 'Title', $this->item->title);
		echo PhocaMapsRender::renderFormItemImageButton('latitude', 'Latitude', $this->item->latitude, 50, 50, $this->buttonmap, 'onChange="setPMGPSLatitude(this.value);"');
		echo PhocaMapsRender::renderFormInput('longitude', 'Longitude', $this->item->longitude, 50, 50, 'onChange="setPMGPSLongitude(this.value);"');
		echo PhocaMapsRender::renderFormInput('gpslatitude', 'GPS Latitude', $this->item->gpslatitude, '', '', 'readonly', 'background:#f0f0f0');
		echo PhocaMapsRender::renderFormInput('gpslongitude', 'GPS Longitude', $this->item->gpslongitude, '', '', 'readonly', 'background:#f0f0f0');
		echo PhocaMapsRender::renderFormItemSpecial('catid', 'Map', $this->lists['catid'] );
		echo PhocaMapsRender::renderFormItemSpecial('published', 'Published', $this->lists['published'] );
		echo PhocaMapsRender::renderFormItemSpecial('ordering', 'Ordering', $this->lists['ordering'] );
		echo PhocaMapsRender::renderFormItemSpecial('description', 'Description', $this->editor->display( 'description',  $this->item->description, '550', '300', '60', '20', array('pagebreak', 'readmore') ) );
		
		$option = array(0 => 'No', 1 => 'Yes');
		echo PhocaMapsRender::renderFormSelectBox('markerwindow', 'Open Marker Window', $this->item->markerwindow, $option, '', 'Open Marker Window DESC');
		
		echo PhocaMapsRender::renderFormInput('contentwidth', 'Marker Content Width', $this->item->contentwidth, '', '', '', '', 'Marker Content Width DESC');
		echo PhocaMapsRender::renderFormInput('contentheight', 'Marker Content Height', $this->item->contentheight, '', '', '', '', 'Marker Content Height DESC');
		
		
		
		$option = array(0 => 'No', 1 => 'Yes');
		echo PhocaMapsRender::renderFormSelectBox('displaygps', 'Display GPS', $this->item->displaygps, $option);
		?>
	</table>	
</fieldset>
</div>

<div class="col50">
<fieldset class="adminform">
	<legend><?php echo JText::_('Design Settings'); ?></legend>
	<table class="admintable">		
		<?php
		$option = array(0 => 'default', 1 => 'igrey', 2 => 'iyellow', 3 => 'ihome', 4 => 'igreen', 5 => 'istar', 6 => 'iinfoh', 7 => 'iinfoi', 8 => 'iinfop', 9 => 'iinfoph', 10 => 'iinfoz');
		echo PhocaMapsRender::renderFormInputRadioButton('icon', 'Marker Icon', $this->item->icon, $option, 2);
		?>
	</table>
</fieldset>
</div>



<div class="clr"></div>

<input type="hidden" name="zoom" value="" />
<input type="hidden" name="option" value="com_phocamaps" />
<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="phocamapsmarker" />
</form>

	
