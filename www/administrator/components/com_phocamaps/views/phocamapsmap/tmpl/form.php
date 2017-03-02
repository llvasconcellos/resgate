<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); 

echo PhocaMapsRender::renderSubmitButtonJs(array(
		0 => array('title', 'Map must have a title', 'true', 1))
	);
echo PhocaMapsRender::renderFormStyle();?>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
<div class="col50">
<fieldset class="adminform">
	<legend><?php echo JText::_('Basic Settings'); ?></legend>
	<table class="admintable">		
		<?php		
		echo PhocaMapsRender::renderFormInput('title', 'Title', $this->item->title);
		echo PhocaMapsRender::renderFormInput('alias', 'Alias', $this->item->alias);
		echo PhocaMapsRender::renderFormItemImageButton('latitude', 'Latitude', $this->item->latitude, 50, 50, $this->buttonmap);
		echo PhocaMapsRender::renderFormInput('longitude', 'Longitude', $this->item->longitude, 50, 50);		
		echo PhocaMapsRender::renderFormInput('zoom', 'Zoom', $this->item->zoom);
		echo PhocaMapsRender::renderFormInput('width', 'Map Width', $this->item->width);
		echo PhocaMapsRender::renderFormInput('height', 'Map Height', $this->item->height);
		echo PhocaMapsRender::renderFormInput('lang', 'Language', $this->item->lang, 5, 5);
		echo PhocaMapsRender::renderFormItemSpecial('published', 'Published', $this->lists['published'] );
		echo PhocaMapsRender::renderFormItemSpecial('ordering', 'Ordering', $this->lists['ordering'] );
		echo PhocaMapsRender::renderFormItemSpecial('description', 'Description', $this->editor->display( 'description',  $this->item->description, '550', '300', '60', '20', array('pagebreak', 'readmore') ) );
		
		
		?>
	</table>	
</fieldset>
</div>

<div class="col50">
<fieldset class="adminform">
	<legend><?php echo JText::_('Design Settings'); ?></legend>
	<table class="admintable">		
		<?php
		$option = array(0 => 'None', 1 => 'grey', 2 => 'greywb', 3 => 'greyrc', 4 => 'black');
		echo PhocaMapsRender::renderFormInputRadioButton('border', 'Border', $this->item->border, $option, 1);
		?>
	</table>	
</fieldset>
</div>

<div class="col50">
<fieldset class="adminform">
	<legend><?php echo JText::_('Advanced Settings'); ?></legend>
	<table class="admintable">		
		<?php
		

		$option = array(0 => 'Roadmap', 1 => 'Satellite', 2 => 'Hybrid', 3 => 'Terrain');
		echo PhocaMapsRender::renderFormSelectBox('typeid', 'Map Type', $this->item->typeid, $option);
		$option = array(0 => 'Disable', 1 => 'Default', 2 => 'Horizontal Bar', 3 => 'Dropdown Menu');
		echo PhocaMapsRender::renderFormSelectBox('typecontrol', 'Map Type Control', $this->item->typecontrol, $option);
		$option = array( 1 => 'Top', 2 => 'Top Left', 3 => 'Top Right', 4 => 'Bottom', 5 => 'Bottom Left', 6 => 'Bottom Right', 7 => 'Left', 8 => 'Right');
		echo PhocaMapsRender::renderFormSelectBox('typecontrolposition', 'Map Type Control Position', $this->item->typecontrolposition, $option);
		
		
		
		$option = array(0 => 'No', 1 => 'Yes');
		echo PhocaMapsRender::renderFormSelectBox('doubleclickzoom', 'Doubleclick Zoom', $this->item->doubleclickzoom, $option);
		echo PhocaMapsRender::renderFormSelectBox('scrollwheelzoom', 'Scroll Wheel Zoom', $this->item->scrollwheelzoom, $option);
		$option = array(0 => 'Disable', 1 => 'Default', 2 => 'Mini Zoom', 3 => 'Zoom Pan', 4 => 'Android');
		echo PhocaMapsRender::renderFormSelectBox('zoomcontrol', 'Navigation Control', $this->item->zoomcontrol, $option);
		$option = array(0 => 'Disable', 1 => 'Enable');
		echo PhocaMapsRender::renderFormSelectBox('scalecontrol', 'Scale Control', $this->item->scalecontrol, $option);
		
		
		$option = array(0 => 'No', 1 => 'Yes');
		//echo PhocaMapsRender::renderFormSelectBox('continuouszoom', 'Continuous Zoom', $this->item->continuouszoom, $option);
		//echo PhocaMapsRender::renderFormSelectBox('collapsibleoverview', 'Collapsible Overview Control', $this->item->collapsibleoverview, $option);
		//echo PhocaMapsRender::renderFormSelectBox('dynamiclabel', 'Dynamic Label Control', $this->item->dynamiclabel, $option);
		//echo PhocaMapsRender::renderFormSelectBox('googlebar', 'GoogleBar', $this->item->googlebar, $option);
		echo PhocaMapsRender::renderFormSelectBox('displayroute', 'Display Get Route Form', $this->item->displayroute, $option);
		
		echo PhocaMapsRender::renderFormInput('kmlfile', 'KML File', $this->item->kmlfile, 30, 255, '', '', '', JHTML::_('image.site',  'icon-16-warning.png', '/components/com_phocamaps/assets/images/' ) . ' ' . JText::_('Not supported in IE'));
		
		
		?>
	</table>	
</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="option" value="com_phocamaps" />
<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="phocamapsmap" />
</form>

	
