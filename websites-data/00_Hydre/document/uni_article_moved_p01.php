<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE's work.
/* @var $cs CommonSystem                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

/*Hydre-contenu_debut*/
switch ($l) {
	case "fra":
		$i18nDoc = array(
		"invit"		=>	"Article déplacé. L'article que vous recherchez ne se trouve plus à cette URL.");
		break;
	case "eng":
		$i18nDoc = array(
		"invit"		=>	"This article has been moved. The article you seek isn't on this URL any more.");
		break;
}

$Content .= $i18nDoc['invit'];

/*Hydre-contenu_fin*/
?>
