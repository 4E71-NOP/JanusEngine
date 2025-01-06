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
$bts->mapSegmentLocation(__METHOD__, "uni_deadline_management_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les deadlines.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Etat",
			"col_3_txt"		=> "Date",
			"tabTxt1"		=> "Informations",
			"dlState0"		=> "Hors ligne",
			"dlState1"		=> "En ligne",
			"dlState2"		=> "Supprimé",
			"pageSelectorQueryLike"		=>	"Filtrer avec",
			"pageSelectorDisplay"		=>	"Affichage",
			"pageSelectorNbrPerPage"	=>	"entrées par page",
			"pageSelectorBtnFilter"		=>	"Filtrer",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage deadlines.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Status",
			"col_3_txt"		=> "Date",
			"tabTxt1"		=> "Informations",
			"dlState0"		=> "Offline",
			"dlState1"		=> "Online",
			"dlState2"		=> "Deleted",
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
$pageSelectorData['clauseElements'][] = array("left" => "dl.fk_ws_id",		"operator" => "=",	"right" => "'" . $WebSiteObj->getWebSiteEntry('ws_id') . "'");
// $pageSelectorData['clauseElements'][] = array("left" => "",	"operator" => "=",	"right" => "" );

if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? '') > 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "dl.deadline_name", "operator" => "LIKE", "right" => "'%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%'");
}

$pageSelectorData['query'] = "SELECT"
	. " COUNT(dl.deadline_id) AS ItemsCount "
	. " FROM "
	. $SqlTableListObj->getSQLTableName('deadline') . " dl "
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
$dbquery = $bts->SDDMObj->query("SELECT dl.*"
	. " FROM "
	. $SqlTableListObj->getSQLTableName('deadline') . " dl "
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. " ORDER BY dl.deadline_name"
	. " LIMIT " . $pageSelectorData['nbrPerPage'] . " OFFSET " . ($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset'))
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

	$linkId1 = "<a href='"
		. "index.php?" . _JNSENGLINKURLTAG_ . "=1"
		. "&arti_slug=" . $CurrentSetObj->getDataSubEntry('article', 'arti_slug')
		. "&arti_ref=" . $CurrentSetObj->getDataSubEntry('article', 'arti_ref')
		. "&arti_page=2"
		. "&formGenericData[mode]=edit"
		. "&deadlineForm[selectionId]=";

	$tabState = array(
		0	=> $bts->I18nTransObj->getI18nTransEntry('dlState0'),
		1	=> $bts->I18nTransObj->getI18nTransEntry('dlState1'),
		2	=> $bts->I18nTransObj->getI18nTransEntry('dlState2'),
	);
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= $linkId1 . $dbp['deadline_id'] . "'>" . $dbp['deadline_title'] . "</a>";
		$T['Content']['1'][$i]['2']['cont']	= $tabState[$dbp['deadline_state']];
		$T['Content']['1'][$i]['3']['cont']	= date("Y m d H:i:s", $dbp['deadline_end_date']);
		$T['Content']['1'][$i]['2']['tc']	= 1;
		$T['Content']['1'][$i]['3']['tc']	= 1;
	}
}
// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
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
