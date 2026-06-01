<?php
// // // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

// @JanusEngine:IDE-begin
// Some definitions in order to ease the IDE work and to provide details about what is available.
//
// @var $bts BaseToolSet
// @var $CurrentSetObj CurrentSet
// @var $ClassLoaderObj ClassLoader
//
// @var $RequestDataObj RequestData
// @var $SDDMObj DalFacade
// @var $SqlTableListObj SqlTableList
//
// @var $StringFormatObj StringFormat
// @var $MapperObj Mapper
// @var $DocumentDataObj DocumentData
// @var $ThemeDataObj ThemeData
// @var $UserObj User
// @var $WebSiteObj WebSite
//
// @var $CMObj ConfigurationManagement
// @var $LMObj LogManagement
//
// @var $InteractiveElementsObj InteractiveElements
// @var $RenderTablesObj RenderTables
//
// @var $Content String
// @var $Block String
// @var $infos array
// @var $l String
//
// @JanusEngine:IDE-end


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
