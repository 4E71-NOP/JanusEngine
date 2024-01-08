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

$ClassLoaderObj->provisionClass ( 'Article' );
$obj = new Article();
$id = 105;

$obj->getDataFromDB($id);

$Content .= "Type: Article<br>\r<br>\r";
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
$Content .= $bts->StringFormatObj->print_r_html($obj->getArticle());


$obj->setArticleEntry('arti_title', $obj->getArticleEntry('arti_title')."*");
$obj->sendToDB();
$obj->getDataFromDB($id);
$Content .= "<br>\r";
$Content .= $bts->StringFormatObj->print_r_html($obj->getArticle());

$Content .= "<br>\r<br>\r<br>\r";


/*Hydr-Content-End*/


?>/