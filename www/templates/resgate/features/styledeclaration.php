<?php
/**
 * @package		Gantry Template Framework - RocketTheme
 * @version		1.5.3 July 19, 2010
 * @author		RocketTheme http://www.scriptz-team.info
 * @copyright 	Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureStyleDeclaration extends GantryFeature {
    var $_feature_name = 'styledeclaration';

    function isEnabled() {
        global $gantry;
        $menu_enabled = $this->get('enabled');

        if (1 == (int)$menu_enabled) return true;
        return false;
    }

	function init() {
        global $gantry;

		//inline css for dynamic stuff
		$css = '#rt-main-surround ul.menu li.active > a, #rt-main-surround ul.menu li.active > .separator, #rt-main-surround ul.menu li.active > .item, #rt-main-surround .square4 ul.menu li:hover > a, #rt-main-surround .square4 ul.menu li:hover > .item, #rt-main-surround .square4 ul.menu li:hover > .separator, .roktabs-links ul li.active span, .menutop li:hover > .item, .menutop li.f-menuparent-itemfocus .item, .menutop li.active > .item {color:'.$gantry->get('linkcolor').';}'."\n";
		
        $css .= 'a, .button, #rt-main-surround ul.menu a:hover, #rt-main-surround ul.menu .separator:hover, #rt-main-surround ul.menu .item:hover, .title1 .module-title .title, .item_add:link, .item_add:visited, .simpleCart_empty:link, .simpleCart_empty:visited, .simpleCart_checkout:link, .simpleCart_checkout:visited {color:'.$gantry->get('linkcolor').';}';



        $gantry->addInlineStyle($css);
		$this->_disableRokBoxForiPhone();

		//style stuff
        $gantry->addStyle($gantry->get('cssstyle').".css");
		if ($gantry->get('thirdparty')) $gantry->addStyle('extended.css');

	}
	
	function _disableRokBoxForiPhone() {
		global $gantry;
		
		if ($gantry->browser->platform == 'iphone') {
			$gantry->addInlineScript("window.addEvent('domready', function() {\$\$('a[rel^=rokbox]').removeEvents('click');});");
		}
	}

}