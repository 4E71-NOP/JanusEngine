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
/*JanusEngine-IDE-end*/

/*JanusEngine-Content-Begin*/
switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
		"invit"		=>	"<p>Article non disponible. Ou peut-être avez vous oublié de vous connecter.</p>\r")
	);
		break;
	case "eng":
		$bts->I18nTransObj->apply(array(
		"invit"		=>	"<p>This article isn't available. Or maybe you forgot to sign-in.</p>")
		);
		break;
}

$Content .= $bts->I18nTransObj->getI18nTransEntry('invit');

/*JanusEngine-Content-End*/
?>
