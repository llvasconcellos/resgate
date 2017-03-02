<?php
/**
 * $ModDesc
 * 
 * @version	$Id: helper.php $Revision
 * @package	modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license	GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
?>
<div class="lof-piecemaker" style="width:<?php echo $params->get('module_width','960');?>px; height:<?php echo $params->get('module_height','400');?>px;">
	<div  id="flashcontent<?php echo $module->id?>" class="lof-inner" ><?php echo JText::_('Loading...');?></div>
</div
><script type="text/javascript">
		var flashvars = {};
		flashvars.xmlSource   = "<?php echo $currentURL ; ?>piecemakerXML.php?f=<?php echo $themeFileName;?>";
		flashvars.cssSource   = "<?php echo $currentURL ; ?>assets/piecemakerCSS.css";
		flashvars.imageSource = "<?php echo JURI::base() ; ?>";
		var attributes = {};
		attributes.wmode = "transparent";
        <?php if( file_exists(dirname(dirname(__FILE__)).DS.'themes'.DS.$theme.DS.'player.php') ): ?>
			<?php require(dirname(dirname(__FILE__)).DS.'themes'.DS.$theme.DS.'player.php'); ?>
		<?php else :?>
		swfobject.embedSWF("<?php echo $currentURL ; ?>assets/piecemakerShadow.swf", "flashcontent<?php echo $module->id?>", "<?php echo $params->get('module_width','960');?>", "<?php echo $params->get('module_height','500');?>", "10", "<?php echo $currentURL ; ?>assets/swfobject/expressInstall.swf", flashvars, attributes);
		<?php endif; ?>	
</script>

