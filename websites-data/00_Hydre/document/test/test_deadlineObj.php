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

$ClassLoaderObj->provisionClass ( 'DeadLine' );
$dl = new DeadLine();

$dl->getDataFromDB(4);

$Content .= "Type: DeadLine<br>\r<br>\r";
$Content .= "dl->checkDataConsistency()=";
switch ($dl->checkDataConsistency()) {
	case true:		$Content .= "TRUE";			break;
	case false:		$Content .= "FALSE";		break;
}


$Content .= "<br>\r";
// $dl->setDeadLineEntry('deadline_id', '1');
$Content .= "dl->existsInDB()=";
switch ($dl->existsInDB()) {
	case true:		$Content .= "TRUE";			break;
	case false:		$Content .= "FALSE";		break;
}

$Content .= "<br>\r";
$Content .= $bts->StringFormatObj->print_r_html($dl->getDeadLine());


$dl->setDeadLineEntry('deadline_title', $dl->getDeadLineEntry('deadline_title')."*");
$dl->sendToDB();
$dl->getDataFromDB(4);
$Content .= "<br>\r";
$Content .= $bts->StringFormatObj->print_r_html($dl->getDeadLine());

$Content .= "<br>\r<br>\r<br>\r";


/*Hydre-contenu_fin*/


?>/