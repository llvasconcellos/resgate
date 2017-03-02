<?php
/*********** XML PARAMETERS AND VALUES ************/
$xml_item = "component";// component | template
$xml_file = "phocamaps.xml";		
$xml_name = "PhocaMaps";
$xml_creation_date = "10/03/2010";
$xml_author = "Jan Pavelka (www.phoca.cz)";
$xml_author_email = "";
$xml_author_url = "www.phoca.cz";
$xml_copyright = "Jan Pavelka";
$xml_license = "GNU/GPL";
$xml_version = "1.1.0";
$xml_description = "Phoca Maps";
$xml_copy_file = 1;//Copy other files in to administration area (only for development), ./front, ./language, ./other

$xml_menu = array (0 => "Phoca Maps", 1 => "option=com_phocamaps", 2 => "components/com_phocamaps/assets/images/icon-16-pmap-menu.png");
$xml_submenu[0] = array (0 => "Control Panel", 1 => "option=com_phocamaps", 2 => "components/com_phocamaps/assets/images/icon-16-pmap-menu-cp.png");
$xml_submenu[1] = array (0 => "Maps", 1 => "option=com_phocamaps&view=phocamapsmaps", 2 => "components/com_phocamaps/assets/images/icon-16-pmap-menu-map.png");
$xml_submenu[2] = array (0 => "Markers", 1 => "option=com_phocamaps&view=phocamapsmarkers", 2 => "components/com_phocamaps/assets/images/icon-16-pmap-menu-marker.png");
$xml_submenu[3] = array (0 => "Info", 1 => "option=com_phocamaps&view=phocamapsinfo", 2 => "components/com_phocamaps/assets/images/icon-16-pmap-menu-info.png");

$xml_install_file = 'install.phocamaps.php'; 
$xml_uninstall_file = 'uninstall.phocamaps.php';
/*********** XML PARAMETERS AND VALUES ************/
?>