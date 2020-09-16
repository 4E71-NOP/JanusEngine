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
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */
/* @var $TimeObj Time                               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $RenderLayoutObj RenderLayout               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

/*Hydre-contenu_debut*/

switch ($l) {
	case "fra":
		$i18nDoc = array(
		"invit"		=>	"Le but du site est de pouvoir permettre de faire des sites web. Rien de nouveau hein? L'accent est mis sur les possibilit&eacute;s graphique et les pr&eacute;sentations.<br>\r
		<br>\r
		Nous d&eacute;veloppons les modules du site afin d'am&eacute;liorer les fonctionnalit&eacute;s et aussi d'en cr&eacute;er de nouvelles.<br>\r
		<br>\r
		Nous sommes sensibles &agrave; vos suggestions qui pourront apporter, tant &agrave; vous m&ecirc;me qu'aux autres, des &eacute;volutions int&eacute;ressantes.<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		");
		break;
	case "eng":
		$i18nDoc = array(
		"invit"		=>	"The engine goal is to provide an interface to create website. Nothing new huh? A particular touch was put on graphic possibilities and layouts.<br>\r
		<br>\r
		We are developping 'module' to enhace functionalities and to create new ones.<br>\r
		<br>\r
		We are listening to suggestions that will probably bring, for us and others, interresting and useful futur evolutions. <br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		");
		break;
}

$Content .= $i18nDoc['invit'];

/*Hydre-contenu_fin*/
?>
