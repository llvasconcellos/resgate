<?php
/**
 * $ModDesc
 * 
 * @version	$Id: helper.php $Revision
 * @package	modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) July 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license	GNU General Public License version 2
 */
?>
<?php header("Content-type: text/xml");?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; echo "\r\n"?>
<?php if(isset($_GET['f']) && !empty($_GET['f']) ) :?>
<?php 
	define( 'DS', DIRECTORY_SEPARATOR );
	$cacheRootPath = str_replace( 'modules' . DS . 'mod_lofpiecemaker', 'cache', dirname(__FILE__) );
	$cacheGroup = 'mod_lofpiecemaker';
	$path = $cacheRootPath.DS.$cacheGroup.DS.$_GET['f'].'.php';

	if (file_exists($path) ) {
		$content = @file_get_contents($path);
		$content = unserialize(preg_replace('/^.*\n/', '', $content));
		$content = $content['result'];
		echo $content;
	}
?>
<?php endif; ?>
