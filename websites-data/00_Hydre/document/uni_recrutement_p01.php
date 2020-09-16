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
		"invit"		=>	"Webmachine, de mani&egrave;re a devenir international a besoin de traducteurs pour ses articles, code, commentaires.<br>\r
		<br>\r
		Si vous avez des sujets int&eacute;ressants pour Multi-Web Manager n'h&eacute;sitez pas a en proposer.<br>\r
		<br>\r
		Si vous avez des suggestions (constructives) concernant Multi-Web Manager vous pourrez nous contacter a l'adresse suivante.<br>\r
		<br>\r
		<p style='text-align: center;' >\r
		<a class='".$Block."_lien ".$Block."_t4' href='mailto:someone@somedomain.net'>mailto:someone@somedomain.net</a>
		</p>
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		");
		break;
	case "eng":
		$i18nDoc = array(
		"invit"		=>	"In order to become international MultiWebManager needs traducers for article, code, comments.<br>\r
		<br>\r
		If you have interesting topics for  MultiWebManager don't hesitate to submit some.<br>\r
		<br>\r
		If you have suggestions for MultiWebManager you can write to this address.<br>\r
		<br>\r
		<p style='text-align: center;' >\r
		<a class='".$Block."_lien ".$Block."_t4' href='mailto:someone@somedomain.net'>mailto:someone@somedomain.net</a>
		</p>
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		");
		break;
}

$Content .= $i18nDoc['invit'];

/*Hydre-contenu_fin*/
?>
