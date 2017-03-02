<?php
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) July 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$group = $params->get( 'group','content' );
$tmp = $params->get( 'module_height', 'auto' );
$moduleHeight   =  ( $tmp=='auto' ) ? 'auto' : (int)$tmp.'px';
$tmp = $params->get( 'module_width', 'auto' );
$moduleWidth    =  ( $tmp=='auto') ? 'auto': (int)$tmp.'px';
$theme 			= $params->get( 'theme' , 'basic');
$openTarget 	= $params->get( 'open_target', 'parent' );
$class 			= $params->get( 'navigator_pos', 0 ) ? '':'lof-snleft';
$currentURL 	= JURI::base().'modules/mod_lofpiecemaker/';

modLofpiecemaker::loadMediaFiles( $params, $module, $theme );
$themeFileName = modLofpiecemaker::getThemeFileName( $params, $module, $theme );

require(JModuleHelper::getLayoutPath('mod_lofpiecemaker'));
?>
