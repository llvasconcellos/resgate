<?php 
/**
 * $ModDesc
 * 
 * @version	$Id: helper.php $Revision
 * @package	modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) June 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license	GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';
if( !defined('PhpThumbFactoryLoaded') ) {
	require_once dirname(__FILE__).DS.'libs'.DS.'phpthumb'.DS.'ThumbLib.inc.php';
	define('PhpThumbFactoryLoaded',1);
}
if( !class_exists('LofSliderGroupBase') ){
    require_once( dirname(__FILE__).DS.'libs'.DS.'group_base.php' );
}

abstract class modLofpiecemaker {
	
	/**
	 * get list articles
	 */
	public static function getList( $params, $module, $theme  ){
		global $mainframe;	
		
		$layout = '';
		$content= '';
		if( $theme ) {
			$layout = trim($theme).'_default';	
		}
		$list = self::getGroupObject( $params );
		// Build the template and base path for the layout
		$tPath = JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.$module->module.DS.$layout.'.php';
		$bPath = JPATH_BASE.DS.'modules'.DS.$module->module.DS.'themes'.DS.$theme.DS.'default.php';
	
		// If the template has a layout override use it
		if (file_exists($tPath)) {
			ob_start();	
				require( $tPath );
				$content = ob_get_contents();
			ob_end_clean(); 	
		} elseif( file_exists($bPath) ) {
			ob_start();	
				require( $bPath );
				$content = ob_get_contents();
			ob_end_clean(); 
		}
	
		return $content;
	}
	
	/**
	 * get list articles
	 */
	public static function getGroupObject( $params ){
		$group = $params->get( 'group', 'content' );
		$file = dirname(__FILE__).DS.'libs'.DS.'groups'.DS.strtolower($group).DS.strtolower($group).'.php';	
		if( file_exists($file) ){
			require_once( $file );
			$className = 'LofSliderGroup'.ucfirst($group);
			if( class_exists($className) ){
				$object = new $className( $group );	
				$object->setReturnImagePath( true );
				$object->setCurrentPath(  dirname(__FILE__).DS.'libs'.DS.'groups'.DS.strtolower($group).DS );							
			}
		}
		if( $object ){
			return $object->getListByParameters( $params );	
		} else {
			return array();
		}
	}
        
	/**
	 * render Item Layout.
	 */
	public function renderItem( &$row, $params, $layout='_item' ){
		$target = $params->get('open_target','_parent') != 'modalbox'
							? 'target="'.$params->get('open_target','_parent').'"'
							: 'rel="'.$params->get('modal_rel','width:800,height:350').'" class="mb"'; 
	
		$path = dirname(__FILE__).DS.'themes'.DS.$params->get('theme').DS;
		if( file_exists($path.$params->get('group').$layout.'.php') ){
			require( $path.$params->get('group').$layout.'.php' );
			return ;
		}
		require( $path.$layout.'.php' );
	}

	/**
	 * load css - javascript file.
	 * 
	 * @param JParameter $params;
	 * @param JModule $module
	 * @return void.
	 */
	public static function loadMediaFiles( $params, $module, $theme='' ){				
		JHTML::script( 'swfobject.js','modules/'.$module->module.'/assets/swfobject/' );
	}
	
	/**
	 * load theme
	 */
	public static function getThemeFileName( $params, $module, $theme  ){
		// echo modLofpiecemaker::getList( $params, $module, $theme  );die;
		global $mainframe;		 
		$id    = md5( $module->module.'|'.$theme.'|'.$params->get('lof_added_time', '') );	
		$cache = JFactory::getCache( $module->module, 'callback', 'file' );
		$cache->setCaching( true );
		$cache->setLifeTime( $params->get( 'cache_time', 15 ) * 60 );	
		$content  = $cache->get( array( 'modLofpiecemaker' , 'getList' ), array( $params, $module, $theme  ),  $id  ); 
		$engine   = $cache->_getStorage();
		$file     = $engine->_getFilePath( $id, $module->module );
		$file     =  str_replace( array(JPATH_CACHE . DS . $module->module . DS,'.php'),'',$file ); 
		return $file;
	}
}
?>
