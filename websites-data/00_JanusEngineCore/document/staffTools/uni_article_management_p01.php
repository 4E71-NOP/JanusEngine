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
	'articleForm',
	array(
		'SQLlang'		=> 48,
		'SQLdeadline'	=> 4,
		'SQLnom'		=> "charg",
		'action'		=> "",
	)
);

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_article_management_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_article_management");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_article_management_p01_");

// --------------------------------------------------------------------------------------------
$pageSelectorData['query'] = "";
$pageSelectorData['clauseElements'] = array();

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();

$filterForm = array(
	'nbrPerPage'			=> 10,
	'query_like'			=> strtolower($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? ''),
	'selectionOffset'		=> 0,
	'deadline'				=> null
);

$formDeadline = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'deadline');
if (strlen($formDeadline ?? '') > 0 && $formDeadline != 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "dl.deadline_id", "operator" => "=", "right" => $formDeadline);
	$filterForm['deadline'] = $formDeadline;
}

$TemplateObj->checkFilterForm($filterForm);

// --------------------------------------------------------------------------------------------
$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite1') . "</p>";

// --------------------------------------------------------------------------------------------
$pageSelectorData['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? '') > 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "art.arti_name", "operator" => "LIKE", "right" => "'%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%'");
}
$pageSelectorData['clauseElements'][] = array("left" => "LOWER(art.arti_ref)",	"operator" => "LIKE",	"right" => "'%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%'");
$pageSelectorData['clauseElements'][] = array("left" => "mnu.fk_ws_id",			"operator" => "=",		"right" => "'" . $WebSiteObj->getWebSiteEntry('ws_id') . "'");
$pageSelectorData['clauseElements'][] = array("left" => "art.arti_ref",			"operator" => "=",		"right" => "mnu.fk_arti_ref");
$pageSelectorData['clauseElements'][] = array("left" => "art.fk_deadline_id",	"operator" => "=",		"right" => "dl.deadline_id");
$pageSelectorData['clauseElements'][] = array("left" => "art.fk_ws_id",			"operator" => "=",		"right" => "dl.fk_ws_id");
$pageSelectorData['clauseElements'][] = array("left" => "dl.fk_ws_id",			"operator" => "=",		"right" => "mnu.fk_ws_id");
$pageSelectorData['clauseElements'][] = array("left" => "mnu.menu_state",		"operator" => "=",		"right" => "'1'");
$pageSelectorData['clauseElements'][] = array("left" => "mnu.menu_type",		"operator" => "IN",		"right" => "('1','0')");


$pageSelectorData['query'] = "SELECT"
	. " COUNT(art.arti_id) AS ItemsCount "
	. " FROM "
	. $SqlTableListObj->getSQLTableName('article') . " art, "
	. $SqlTableListObj->getSQLTableName('menu') . " mnu, "
	. $SqlTableListObj->getSQLTableName('deadline') . " dl "
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. ";";

$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : \$q:" . $pageSelectorData['query']));

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
$langList = $bts->CMObj->getLanguageList();
$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "langList=" . $bts->StringFormatObj->arrayToString($langList)));

// --------------------------------------------------------------------------------------------
if (strlen($bts->RequestDataObj->getRequestDataEntry('SQLlang') ?? '') > 0) {
	$langList[$bts->RequestDataObj->getRequestDataEntry('SQLlang')]['s'] = "selected";
} else {
	$langList[$CurrentSetObj->getDataEntry('language_id')]['s'] = "selected";
}

$listDeadline = array(
	0 => array(
		'id' => 0,
		'deadline_title' => $bts->I18nTransObj->getI18nTransEntry('deadline0'),
	),
);
$q = "SELECT deadline_id,deadline_name,deadline_title,deadline_state FROM "
	. $SqlTableListObj->getSQLTableName('deadline')
	. " WHERE fk_ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "';";

$dbquery = $bts->SDDMObj->query($q, 1);
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$A = $dbp['deadline_id'];
	$listDeadline[$A]['id'] = $A;
	$listDeadline[$A]['deadline_name']		= $dbp['deadline_name'];
	$listDeadline[$A]['deadline_title']		= $dbp['deadline_title'];
	$listDeadline[$A]['deadline_state']		= $dbp['deadline_state'];
}
unset($A);
foreach ($listDeadline as $A) {
	if ($A['deadline_state'] == 0) {
		$A['deadline_title'] = "<span class='" . $Block . "_error'>" . $A['deadline_title'];
	} else {
		$A['deadline_title'] = "<span class='" . $Block . "_ok'>" . $A['deadline_title'];
	}
	$A['deadline_title'] .= $A['deadline_name'] . "</span>";
}
if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'deadline') ?? '') > 0) {
	$listDeadline[$bts->RequestDataObj->getRequestDataEntry('SQLdeadline')]['s'] = "selected";
}

$tdStyle = " style='margin:0.1cm;'";
$infos['insertLines'] = "<!-- deadline select -->"
	. "<tr>\r"
	. "<td " . $tdStyle . ">" . $bts->I18nTransObj->getI18nTransEntry('pageSelectorDeadline') . "</td>\r"
	. "<td " . $tdStyle . ">"
	. "<select name='articleForm[SQLdeadline]'>";

unset($A, $B);
foreach ($listDeadline as $A) {
	$infos['insertLines'] .= "<option value='" . $A['id'] . "' " . $A['selected'] . ">" . $A['deadline_title'] . " / " . $A['deadline_name'] . "</option>\r";
}

$infos['insertLines'] .= $bts->I18nTransObj->getI18nTransEntry('pageSelectorNbrPerPage')
	. "</select>\r"
	. "</td>\r"
	. "</tr>\r";
// --------------------------------------------------------------------------------------------
$q = "SELECT "
	. "art.arti_ref, art.arti_id, art.arti_name, art.arti_title, art.arti_page, "
	. "mnu.fk_lang_id, "
	. "dl.deadline_name, dl.deadline_title, dl.deadline_state "
	. "FROM "
	. $SqlTableListObj->getSQLTableName('article') . " art, "
	. $SqlTableListObj->getSQLTableName('menu') . " mnu, "
	. $SqlTableListObj->getSQLTableName('deadline') . " dl "
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. " ORDER BY art.arti_ref,art.arti_page"
	. " LIMIT " . $pageSelectorData['nbrPerPage'] . " OFFSET " . ($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset'))
	. ";";
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : \$q:" . $q));

$dbquery = $bts->SDDMObj->query($q);

$T = array();
$articleList = array();
if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$p = &$articleList[$dbp['arti_id']];
		$p['arti_ref']			= $dbp['arti_ref'];
		$p['arti_id']			= $dbp['arti_id'];
		$p['arti_name']			= $dbp['arti_name'];
		$p['arti_title']		= $dbp['arti_title'];
		$p['arti_page']			= $dbp['arti_page'];
		$p['fk_lang_id']		= $dbp['fk_lang_id'];
		$p['deadline_name']		= $dbp['deadline_name'];
		$p['deadline_title']	= $dbp['deadline_title'];
		$p['deadline_state']	= $dbp['deadline_state'];
	}

	$colorState = array(
		"0" => "<span class='" . $Block . "_warning'>",
		"1" => "<span class='" . $Block . "_ok'>",
		"2" => "<span class='" . $Block . "_error'>",
	);

	unset($A, $B);
	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	$T['Content']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');

	$linkId1 = "<a href='"
		. "index.php?" . _JNSENGLINKURLTAG_ . "=1"
		. "&arti_slug=" . $CurrentSetObj->getDataSubEntry('article', 'arti_slug')
		. "&arti_ref=" . $CurrentSetObj->getDataSubEntry('article', 'arti_ref')
		. "&arti_page=2"
		. "&formGenericData[mode]=edit"
		. "&articleForm[selectionId]=";

	foreach ($articleList as &$A) {
		$i++;
		$T['Content']['1'][$i]['1']['cont'] = $linkId1 . $A['arti_id'] . "'>" .  $A['arti_ref'] . "</a>";
		$T['Content']['1'][$i]['2']['cont'] = $A['arti_page'];
		$T['Content']['1'][$i]['3']['cont'] = $langList[$A['fk_lang_id']]['lang_original_name'];
		$T['Content']['1'][$i]['4']['cont'] = $colorState[$A['deadline_state']] . $A['deadline_title'] . "</span>";
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
	1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i, 4, 1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T)
	. "<br>\r"
	. $TemplateObj->renderFilterForm($infos)
	. $TemplateObj->renderAdminCreateButton($infos);

$bts->segmentEnding(__METHOD__);

// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-End*/
