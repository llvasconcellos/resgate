<?php
/**
 * @package   Juxta Template - RocketTheme
 * @version   1.5.3 July 19, 2010
 * @author    RocketTheme http://www.scriptz-team.info
 * @copyright Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureLogin extends GantryFeature {
    var $_feature_name = 'login';

	function render($position="") {
	    ob_start();
	    $user =& JFactory::getUser();
	    ?>
		<div class="clear"></div>
		<div class="rt-block">
		<div id="rt-login-button">
		<?php if ($user->guest) : ?>
			<a href="#" class="buttontext" rel="rokbox[215 265][module=rt-popup]">
				<span class="desc"><?php echo $this->get('text'); ?></span><span class="icon"></span>
			</a>
		<?php else : ?>
			<a href="#" class="buttontext" rel="rokbox[215 265][module=rt-popup]">
			<span><?php echo $this->get('logouttext'); ?> <?php echo JText::sprintf($user->get('username') ); ?></span>
			</a>
		<?php endif; ?>
		</div><div class="clear"></div>
		</div>
		<?php
	    return ob_get_clean();
	}
}