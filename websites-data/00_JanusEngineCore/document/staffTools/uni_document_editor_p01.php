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

// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_document_editor_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_document_editor");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_document_editor_p01_");

// --------------------------------------------------------------------------------------------
// FilterForm control and correction
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$TemplateObj->checkFilterForm();

// --------------------------------------------------------------------------------------------
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";
// --------------------------------------------------------------------------------------------
$pageSelectorData = array();
$pageSelectorData['clauseElements'] = array();
$pageSelectorData['query'] = "";

$pageSelectorData['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');

if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? '') > 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "LOWER(doc.docu_name)", "operator" => "LIKE", "right" => "'%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%'");
}
$pageSelectorData['clauseElements'][] = array("left" => "shr.fk_ws_id",		"operator" => "=",	"right" => "'" . $WebSiteObj->getWebSiteEntry('ws_id') . "'");
$pageSelectorData['clauseElements'][] = array("left" => "shr.fk_docu_id",	"operator" => "=",	"right" => "doc.docu_id");
$pageSelectorData['clauseElements'][] = array("left" => "doc.docu_origin",	"operator" => "=",	"right" => "'" . $WebSiteObj->getWebSiteEntry('ws_id') . "'");

$pageSelectorData['query'] = "SELECT"
	. " COUNT(doc.docu_id) AS ItemsCount "
	. " FROM "
	. $SqlTableListObj->getSQLTableName('document') . " doc, "
	. $SqlTableListObj->getSQLTableName('document_share') . " shr "
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
	. "doc.docu_id,doc.docu_name,doc.docu_type,shr.share_modification "
	. "FROM "
	. $SqlTableListObj->getSQLTableName('document') . " doc, "
	. $SqlTableListObj->getSQLTableName('document_share') . " shr "
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. " ORDER BY doc.docu_name"
	. " LIMIT " . $pageSelectorData['nbrPerPage'] . " OFFSET " . ($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset'))
	. ";", 1);

$T = array();
if ($bts->SDDMObj->num_row_sql($dbquery) == 0) {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
} else {

	$type = array(
		0 => $bts->I18nTransObj->getI18nTransEntry('docTyp0'),
		1 => $bts->I18nTransObj->getI18nTransEntry('docTyp1'),
		2 => $bts->I18nTransObj->getI18nTransEntry('docTyp2'),
		3 => $bts->I18nTransObj->getI18nTransEntry('docTyp3'),
	);

	$modif = array(
		0 => $bts->I18nTransObj->getI18nTransEntry('docModif0'),
		1 => $bts->I18nTransObj->getI18nTransEntry('docModif1'),
	);

	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');

	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= "<a href='"
			. "index.php?" . _JNSENGLINKURLTAG_ . "=1"
			. "&arti_slug=" . $CurrentSetObj->getDataSubEntry('article', 'arti_slug')
			. "&arti_ref=" . $CurrentSetObj->getDataSubEntry('article', 'arti_ref')
			. "&arti_page=2"
			. "&formGenericData[mode]=edit"
			. "&documentForm[selectionId]=" . $dbp['docu_id']
			. "'>"
			. $dbp['docu_name']
			. "</a>\r";

		$T['Content']['1'][$i]['2']['cont']	= $type[$dbp['docu_type']];
		$T['Content']['1'][$i]['3']['cont']	= $modif[$dbp['share_modification']];
	}
}
// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, $i);
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
