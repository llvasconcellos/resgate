<?php
/**********************************************
* 	FlippingBook Gallery Component.
*	© Mediaparts Interactive. All rights reserved.
* 	Released under Commercial License.
*	www.page-flip-tools.com
**********************************************/

defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent( 'onPrepareContent', 'plgContentFlippingBook' );

function plgContentFlippingBook( &$db_row, &$params, $page=0 ) {
	$db =& JFactory::getDBO();

	if ( JString::strpos( $db_row->text, 'flippingbook_book' ) === false )
		return true;

	$plugin =& JPluginHelper::getPlugin( 'content', 'flippingbook_plugin' );

	$regex = "#{flippingbook_book (.*?)}#s";

 	$pluginParams = new JParameter( $plugin->params );

	if ( !$pluginParams->get( 'enabled', 1 ) ) {
		$db_row->text = preg_replace( $regex, '', $db_row->text );
		return true;
	}

	preg_match_all( $regex, $db_row->text, $matches );
 	$count = count( $matches[0] );
 	if ( $count ) {
		$output_type = 'plugin';
		if ( file_exists( JPATH_SITE . DS . 'components' . DS . 'com_flippingbook' . DS . 'views' . DS . 'book' . DS . 'tmpl' . DS . 'default.php' ) ) {
			$book_id_for_module = $matches[1][0];
			$call_from_plugin = true;
			require_once( JPATH_SITE . DS . 'components' . DS . 'com_flippingbook' . DS . 'models' . DS . 'book.php' );
			FlippingBookModelBook::loadGlobalVars();
			require_once( JPATH_SITE . DS . 'components' . DS . 'com_flippingbook' . DS . 'views' . DS . 'book' . DS . 'tmpl' . DS . 'default.php' );
			for ( $i = 0; $i < $count; $i++ ) {
				//only one book can be published on page
				if ( $i == 0 ) 
					$db_row->text = str_replace( $matches[0][$i], $output_html, $db_row->text );
				else 
					$db_row->text = str_replace( $matches[0][$i], '', $db_row->text );
			}
		} else {
			echo '<div style="color:#dd0000; background-color:#f5f5f5; padding:3px;">Make sure that FlippingBook Gallery Component installed in your Joomla!</div>';
			return;
		}
	}
}