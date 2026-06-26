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


// $bts->RequestDataObj->setRequestData('articleForm',
// 	array(
// 		'SQLlang'		=> 48,
// 		'SQLdeadline'	=> 4,
// 		'SQLnom'		=> "charg",
// 		'action'		=> "",
// 	)
// );

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_decoration_management_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_decoration_management");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_decoration_management_p01_");

// --------------------------------------------------------------------------------------------
// FilterForm control and correction
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$TemplateObj->checkFilterForm();

// --------------------------------------------------------------------------------------------
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$pageSelectorData['query'] = "";
$pageSelectorData['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');

$pageSelectorData['clauseElements'] = array();

if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? '') > 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "LOWER(d.deco_name)", "operator" => "LIKE", "right" => "'%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%'");
}

$pageSelectorData['query'] = "SELECT"
	. " COUNT(d.deco_id) AS ItemsCount "
	. " FROM "
	. $SqlTableListObj->getSQLTableName('decoration') . " d "
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. ";";

$dbquery = $bts->SDDMObj->query($pageSelectorData['query']);
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$pageSelectorData['ItemsCount'] = $dbp['ItemsCount'];
}

if ($pageSelectorData['ItemsCount'] > $pageSelectorData['nbrPerPage']) {
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? '') > 0) {
		$strQueryLike	= "&filterForm[query_like]="	. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like');
	}
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage') ?? '') > 0) {
		$strNbrPerPage	= "&filterForm[nbrPerPage]="	. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
	}

	$pageSelectorData['link'] = $strQueryLike . $strGroupId . $strUserStatus . $strNbrPerPage;
	$pageSelectorData['elmIn'] = "<div class='" . $Block . "_page_selector'>";
	$pageSelectorData['elmInHighlight'] = "<div class='" . $Block . "_page_selector_highlight'>";
	$pageSelectorData['elmOut'] = "</div>";
	$pageSelectorData['selectionOffset'] = "" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset');
	$Content .= $TemplateObj->renderPageSelector($pageSelectorData);
}

// --------------------------------------------------------------------------------------------
$dbquery = $bts->SDDMObj->query("SELECT "
	. "CONCAT('0x', HEX(d.deco_id)) AS deco_id, "
	. "d.deco_name, "
	. "d.deco_state, "
	. "d.deco_type "
	. "FROM "
	. $SqlTableListObj->getSQLTableName('decoration') . " d "
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. "ORDER BY  d.deco_name "
	. "LIMIT " . $pageSelectorData['nbrPerPage'] . " "
	. "OFFSET " . ($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset'))
	. ";");

$T = array();
if ($bts->SDDMObj->num_row_sql($dbquery) == 0) {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
} else {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');

	$i = 1;
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= "
		<a class='" . $Block . "_lien' href='"
			. "index.php?" . _JNSENGLINKURLTAG_ . "=1"
			. "&arti_slug=" . $CurrentSetObj->getDataSubEntry('article', 'arti_slug')
			. "&arti_ref=" . $CurrentSetObj->getDataSubEntry('article', 'arti_ref')
			. "&arti_page=2"
			. "&formGenericData[mode]=edit"
			. "&formGenericData[selectionId]=" . $dbp['deco_id']
			. "'>" . $dbp['deco_name'] . "</a>";
		$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('state')[($dbp['deco_state'] ?? 0)];
		$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('type')[($dbp['deco_type']?? 40)];
	}
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos); //$i
$T['ContentCfg']['tabs'] = array(
	1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i, 3, 1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T)
	. "<br>\r"
	. $TemplateObj->renderFilterForm($infos)
	. $TemplateObj->renderAdminCreateButton($infos);

$bts->segmentEnding(__METHOD__);
// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-End*/
