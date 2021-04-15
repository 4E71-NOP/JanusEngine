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
/*Hydre-contenu_debut*/

$ClassLoaderObj->provisionClass ( 'ExtensionConfig' );
$obj = new ExtensionConfig();
$id = 1;

$obj->getDataFromDB($id);

$Content .= "Type: ExtensionConfig<br>\r<br>\r";
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
$Content .= $bts->StringFormatObj->print_r_html($obj->getExtensionConfig());


$obj->setExtensionConfigEntry('extension_variable', $obj->getExtensionConfigEntry('extension_variable')."*");
$obj->sendToDB();
$obj->getDataFromDB($id);
$Content .= "<br>\r";
$Content .= $bts->StringFormatObj->print_r_html($obj->getExtensionConfig());

$Content .= "<br>\r<br>\r<br>\r";


/*Hydre-contenu_fin*/


?>/