<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin *
/*Hydr-Content-Begin*/

$ClassLoaderObj->provisionClass ( 'WebSite' );
$obj = new WebSite();
$id = 1;

$obj->getDataFromDB($id);

$Content .= "Type: WebSite<br>\r<br>\r";
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
$Content .= $bts->StringFormatObj->print_r_html($obj->getWebSite());


$obj->setWebSiteEntry('ws_name', $obj->getWebSiteEntry('ws_name')."*");
$obj->sendToDB();
$obj->getDataFromDB($id);
$Content .= "<br>\r";
$Content .= $bts->StringFormatObj->print_r_html($obj->getWebSite());

$Content .= "<br>\r<br>\r<br>\r";


/*Hydr-Content-End*/


?>