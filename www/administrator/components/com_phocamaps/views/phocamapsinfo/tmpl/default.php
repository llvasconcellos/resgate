<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>

<form action="index.php" method="post" name="adminForm">
<div style="float:right;margin:10px;">
	<?php
	echo JHTML::_('image.site',  'logo-phoca.png', '/components/com_phocamaps/assets/images/', NULL, NULL, 'Phoca.cz' )
	?>
</div>

<?php echo  JHTML::_('image.site', 'logo-product.png', 'components/com_phocamaps/assets/images/', NULL, NULL, 'Phoca.cz');?>

<h3><?php echo JText::_('Help');?></h3>

<div id="phocamaps-info">
<p>
<a href="http://www.phoca.cz/phocamaps/" target="_blank">Phoca Maps Main Site</a><br />
<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca Maps User Manual</a><br />
<a href="http://www.phoca.cz/forum/" target="_blank">Phoca Maps Forum</a><br />
</p>

<h3><?php echo JText::_('Version');?></h3>
<p><?php echo $this->tmpl['version'] ;?></p>

<h3><?php echo JText::_('Copyright');?></h3>
<p>© 2007 - <?php echo date("Y"); ?> Jan Pavelka</p>

<h3><?php echo JText::_('License');?></h3>
<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>


<p>Maps are created by Google Maps™<br />
<p>Google™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a><br />Google Maps™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a></p>

<input type="hidden" name="option" value="com_phocamaps" />
<input type="hidden" name="controller" value="phocamapsinfo" />
<input type="hidden" name="task" value="" />
</form>
<p>&nbsp;</p>
</div>

<div style="border-top:1px solid #c2c2c2"></div>
<div id="pg-update" ><a href="http://www.phoca.cz/version/index.php?phocamaps=<?php echo $this->tmpl['version'] ;?>" target="_blank"><?php echo JText::_('Check for update'); ?></a></div>