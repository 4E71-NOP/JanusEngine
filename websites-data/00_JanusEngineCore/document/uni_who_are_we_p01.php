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

//http://www.local-janus-engine.com/enroll/1/

/*JanusEngine-Content-Begin*/

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"C'est un petit développeur dans sa campagne qui lance ce projet.<br>\r
			<br>\r
			Si vous souhaitez aider, allez sur <a href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "enroll'>cette page</a>.<br>\r
			<br>\r
			<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			"
		),
		"eng" => array(
			"invite1"		=>	"This is a single developer lost in the jungle who launch this project.<br>\r
			<br>\r
			If you want to help, go to <a href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "enroll'>this page</a>.<br>\r
			<br>\r
			<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		"
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";

/*JanusEngine-Content-End*/
