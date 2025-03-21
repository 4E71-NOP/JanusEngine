<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
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
/*JanusEngine-IDE-end*/

/*JanusEngine-Content-Begin*/

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Le but du site est de pouvoir permettre de faire des sites web. Rien de nouveau hein? L'accent est mis sur les possibilit&eacute;s graphique et les pr&eacute;sentations.<br>\r
			<br>\r
			Nous d&eacute;veloppons les modules du site afin d'am&eacute;liorer les fonctionnalit&eacute;s et aussi d'en cr&eacute;er de nouvelles.<br>\r
			<br>\r
			Nous sommes sensibles &agrave; vos suggestions qui pourront apporter, tant &agrave; vous m&ecirc;me qu'aux autres, des &eacute;volutions int&eacute;ressantes.<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			"),
		"eng" => array(
			"invite1"		=>	"The engine goal is to provide an interface to create website. Nothing new huh? A particular touch was put on graphic possibilities and layouts.<br>\r
			<br>\r
			We are developping 'module' to enhace functionalities and to create new ones.<br>\r
			<br>\r
			We are listening to suggestions that will probably bring, for us and others, interresting and useful futur evolutions. <br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		")
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

/*JanusEngine-Content-End*/
?>
