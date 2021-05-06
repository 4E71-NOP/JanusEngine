<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin *
/*Hydr-Content-Begin*/

$ClassLoaderObj->provisionClass ( 'Group' );
$obj = new Group();
$id = 54;

$obj->getDataFromDB($id);

$Content .= "Type: Group<br>\r<br>\r";
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
$Content .= $bts->StringFormatObj->print_r_html($obj->getGroup());


$obj->setGroupEntry('group_name', $obj->getGroupEntry('group_name')."*");
$obj->sendToDB();
$obj->getDataFromDB($id);
$Content .= "<br>\r";
$Content .= $bts->StringFormatObj->print_r_html($obj->getGroup());

$Content .= "<br>\r<br>\r<br>\r";


/*Hydr-Content-End*/


?>