<?php
/* JanusEngine-license-start */
// --------------------------------------------------------------------------------------------
//
// Janus Engine - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* JanusEngine-license-end *
/*JanusEngine-Content-Begin*/

$ClassLoaderObj->provisionClass ( 'ExtensionDependency' );
$obj = new ExtensionDependency();
$id = 1;

$obj->getDataFromDB($id);

$Content .= "Type: ExtensionDependency<br>\r<br>\r";
$Content .= "dl->checkDataConsistency()=";
switch ($obj->checkDataConsistency()) {
	case true:		$Content .= "TRUE";			break;
	case false:		$Content .= "FALSE";		break;
}


$Content .= "<br>\r";
$Content .= "dl->existsInDB()=";
switch ($obj->existsInDB()) {
	case true:		$Content .= "TRUE";			break;
	case false:		$Content .= "FALSE";		break;
}

$Content .= "<br>\r";
$Content .= $bts->StringFormatObj->print_r_html($obj->getExtensionDependency());


$obj->setExtensionDependencyEntry('extension_dep', $obj->getExtensionDependencyEntry('extension_dep')."*");
$obj->sendToDB();
$obj->getDataFromDB($id);
$Content .= "<br>\r";
$Content .= $bts->StringFormatObj->print_r_html($obj->getExtensionDependency());

$Content .= "<br>\r<br>\r<br>\r";


/*JanusEngine-Content-End*/


?>/