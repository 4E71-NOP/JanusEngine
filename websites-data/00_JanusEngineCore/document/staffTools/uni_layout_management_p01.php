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

$bts->RequestDataObj->setRequestData(
	'test',
	array(
		'test'		=> 1,
	)
);

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_layout_management_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les présentations.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Nom générique",
			"col_3_txt"		=> "Theme",
			"tabTxt1"		=> "Informations",
			"raf1"			=> "Rien a afficher",
			"btn1"			=> "Filtrer",
			"pageSelectorQueryLike"		=>	"Filtrer avec",
			"pageSelectorDisplay"		=>	"Affichage",
			"pageSelectorNbrPerPage"	=>	"entrées par page",
			"pageSelectorBtnFilter"		=>	"Filtrer",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage layouts.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Generic name",
			"col_3_txt"		=> "Theme",
			"tabTxt1"		=> "Informations",
			"raf1"			=> "Nothing to display",
			"btn1"			=> "Filter",
			"pageSelectorQueryLike"		=>	"Filter with",
			"pageSelectorDisplay"		=>	"Display",
			"pageSelectorNbrPerPage"	=>	"entries per page",
			"pageSelectorBtnFilter"		=>	"Filter",
		)
	)
);

$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite1') . "</p>";
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$pageSelectorData['query'] = "";
$pageSelectorData['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
if ($pageSelectorData['nbrPerPage'] < 1) {
	$pageSelectorData['nbrPerPage'] = _ADMIN_PAGE_TABLE_DEFAULT_NBR_LINE_;
}

$pageSelectorData['clauseElements'] = array();
$pageSelectorData['clauseElements'][] = array("left" => "tw.fk_ws_id",		"operator" => "=",	"right" => "'" . $WebSiteObj->getWebSiteEntry('ws_id') . "'");
$pageSelectorData['clauseElements'][] = array("left" => "lt.fk_theme_id",	"operator" => "=",	"right" => "tw.fk_theme_id");
$pageSelectorData['clauseElements'][] = array("left" => "tw.fk_theme_id",	"operator" => "=",	"right" => "td.theme_id");
$pageSelectorData['clauseElements'][] = array("left" => "lt.fk_layout_id",	"operator" => "=",	"right" => "l.layout_id");

if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? '') > 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "m.deco_name", "operator" => "LIKE", "right" => "'%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%'");
}

$pageSelectorData['query'] = "SELECT"
	. " COUNT(l.layout_id) AS ItemsCount "
	. " FROM "
	. $SqlTableListObj->getSQLTableName('layout') . " l, "
	. $SqlTableListObj->getSQLTableName('layout_theme') . " lt, "
	. $SqlTableListObj->getSQLTableName('theme_website') . " tw, "
	. $SqlTableListObj->getSQLTableName('theme_descriptor') . " td "
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
	. "l.*, td.theme_title"
	. " FROM "
	. $SqlTableListObj->getSQLTableName('layout') . " l, "
	. $SqlTableListObj->getSQLTableName('layout_theme') . " lt, "
	. $SqlTableListObj->getSQLTableName('theme_website') . " tw, "
	. $SqlTableListObj->getSQLTableName('theme_descriptor') . " td "
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. " ORDER BY l.layout_name "
	. " LIMIT " . $pageSelectorData['nbrPerPage'] . " OFFSET " . ($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset'))
	. ";");

if ($bts->SDDMObj->num_row_sql($dbquery) == 0) {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('raf1');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
} else {
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
			. "&layoutForm[selectionId]=" . $dbp['layout_id']
			. "'>" . $dbp['layout_name'] . "</a>";
		$T['Content']['1'][$i]['2']['cont']	= $dbp['layout_title'];
		$T['Content']['1'][$i]['3']['cont']	= $dbp['theme_title'];
	}
}


$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 1);
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
