<?php defined('_JEXEC') or die('Restricted access');?>

<form action="index.php" method="post" name="adminForm">
<table class="adminform">
	<tr>
		<td width="55%" valign="top">
			<div id="phocamaps-cpanel">
			<div id="cpanel">
	<?php
	$component = 'com_phocamaps';
	
	$link = 'index.php?option='.$component.'&view=phocamapsmaps';
	echo PhocaMapsRender::quickIconButton( $component, $link, 'icon-48-map.png', JText::_( 'Maps' ) );
	
	$link = 'index.php?option='.$component.'&view=phocamapsmarkers';
	echo PhocaMapsRender::quickIconButton( $component, $link, 'icon-48-marker.png', JText::_( 'Markers' ) );
	
	$link = 'index.php?option='.$component.'&view=phocamapsinfo';
	echo PhocaMapsRender::quickIconButton( $component, $link, 'icon-48-info.png', JText::_( 'Info' ) );
	?>
			
			<div style="clear:both">&nbsp;</div>
			<p>&nbsp;</p>
			<div style="text-align:center;padding:0;margin:0;border:0">
				<iframe style="padding:0;margin:0;border:0" src="http://www.phoca.cz/adv/phocamaps" noresize="noresize" frameborder="0" border="0" cellspacing="0" scrolling="no" width="500" marginwidth="0" marginheight="0" height="125">
				<a href="http://www.phoca.cz/adv/phocamaps" target="_blank">Phoca Maps</a>
				</iframe>
			</div>
			
			
			</div>
			</div>
		</td>
		
		<td width="45%" valign="top">
			<div style="300px;border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
			<div style="float:right;margin:10px;">
				<?php
					echo JHTML::_('image.site',  'logo-phoca.png', '/components/com_phocamenu/assets/images/', NULL, NULL, 'Phoca.cz' )
				?>
			</div>
			<div id="phocamenu-info">
			<h3><?php echo JText::_('Version');?></h3>
			<p><?php echo $this->version ;?></p>

			<h3><?php echo JText::_('Copyright');?></h3>
			<p>© 2007 - <?php echo date("Y"); ?> Jan Pavelka</p>
			<p><a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>

			<h3><?php echo JText::_('License');?></h3>
			<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>
			<p>&nbsp;</p>
			</div>
			
			<p>Maps are created by Google Maps™<br />
			<p>Google™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a><br />Google Maps™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a></p>
			
			
			<div id="pg-update"><a href="http://www.phoca.cz/version/index.php?phocamaps=<?php echo $this->version ;?>" target="_blank"><?php echo JText::_('Check for update'); ?></a></div>
			
			
			</div>
		</td>
	</tr>
</table>

<input type="hidden" name="option" value="com_phocamaps" />
<input type="hidden" name="view" value="phocamapscp" />
<?php echo JHTML::_( 'form.token' ); ?>	
</form>