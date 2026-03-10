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
/* @var $bts BaseToolSet                            */
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
$bts->mapSegmentLocation(__METHOD__, "uni_critical_information_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_critical_information");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_critical_information_p01_");

$Content .= $bts->I18nTransObj->getI18nTransEntry('url_bypass') . "
<p style='text-align:center;'>
<br>\r
<a href='".$CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url').
"index.php?"._JNSENGLINKURLTAG_."=1&arti_slug=admin-authentification&arti_page=1' 
style='background-color:#FF800080; border-radius:0.5cm; padding:0.5cm'
>\r".$bts->I18nTransObj->getI18nTransEntry('url_bypass_name')."
</a>\r
</p>\r
<br>\r
<br>\r
<hr>\r
";

$bts->segmentEnding(__METHOD__);

/*JanusEngine-Content-End*/
?>
