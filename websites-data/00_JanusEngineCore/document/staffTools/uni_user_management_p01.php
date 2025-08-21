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
	'filterForm',
	array(
		'user_status'			=> 1,
		'nbrPerPage'			=> 10,
		'group_id'				=> 0,
	),
);

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_user_management_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les utilisateurs.",
			"col_1_txt"		=> "Login",
			"col_2_txt"		=> "Nom",
			"col_3_txt"		=> "Groupe",
			"col_4_txt"		=> "Statut",
			"col_5_txt"		=> "Dernière visite",
			"tabTxt1"		=> "Informations",
			"select1_0"		=> "No groupe",
			"select1_1"		=> "Aucun groupe",

			"status0"		=> "Désactivé",
			"status1"		=> "Actif",
			"status2"		=> "Suppprimé",

			"table1_1"		=> "Chercher le login contenant",
			"table1_2"		=> "Du groupe",
			"table1_3"		=> "Statut",
			"table1_41"		=> "Affichage",
			"table1_42"		=> "entrées par pages.",
			"select1_0"		=> "Aucun groupe",
			"select2_0"		=> "Inactif",
			"select2_1"		=> "Actif",
			"select2_2"		=> "Supprimé",
			"pageSelectorQueryLike"		=>	"Filtrer avec",
			"pageSelectorQuerygroup"	=>	"Groupe",
			"pageSelectorQueryStatus"	=>	"Statut",
			"pageSelectorDisplay"		=>	"Affichage",
			"pageSelectorNbrPerPage"	=>	"entrées par page",
			"pageSelectorBtnFilter"		=>	"Filtrer",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage users.",
			"col_1_txt"		=> "Login",
			"col_2_txt"		=> "Name",
			"col_3_txt"		=> "In group",
			"col_4_txt"		=> "Status",
			"col_5_txt"		=> "Last visit",
			"tabTxt1"		=> "Informations",
			"select1_0"		=> "No group",
			"select1_1"		=> "Aucun group",

			"status0"		=> "Disabled",
			"status1"		=> "Active",
			"status2"		=> "Deleted",

			"table1_1"		=> "Find login containing",
			"table1_2"		=> "From group",
			"table1_3"		=> "User status",
			"table1_41"		=> "Display",
			"table1_42"		=> "entry per pages.",
			"select1_0"		=> "No group",
			"select2_0"		=> "Disabled",
			"select2_1"		=> "Active",
			"select2_2"		=> "Deleted",
			"pageSelectorQueryLike"		=>	"Filter with",
			"pageSelectorQuerygroup"	=>	"Group",
			"pageSelectorQueryStatus"	=>	"Status",
			"pageSelectorDisplay"		=>	"Display",
			"pageSelectorNbrPerPage"	=>	"entries per page",
			"pageSelectorBtnFilter"		=>	"Filter",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
// FilterForm control and correction
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();

$filterForm = array(
	'nbrPerPage'			=> 10,
	'query_like'			=> strtolower($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? ''),
	'selectionOffset'		=> 0,
	'user_status'			=> $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status'),
	'group_id'				=> $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id'),
);
$TemplateObj->checkFilterForm($filterForm);

// --------------------------------------------------------------------------------------------
$pageSelectorData['query'] = "";
$pageSelectorData['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
$pageSelectorData['clauseElements'] = array();

if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? '') > 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "LOWER(usr.user_login)", "operator" => "LIKE", "right" => "'%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%'");
}
if ($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id') != 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "gr.group_id", "operator" => "=", "right" => $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id'));
}
if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status') ?? '') > 0) {
	$pageSelectorData['clauseElements'][] = array("left" => "usr.user_status", "operator" => "=", "right" => $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status'));
}

$pageSelectorData['clauseElements'][] = array("left" => "gr.group_tag", 				"operator" => "<>",	"right" => "0");
$pageSelectorData['clauseElements'][] = array("left" => "gu.group_user_initial_group",	"operator" => "=",	"right" => "1");
$pageSelectorData['clauseElements'][] = array("left" => "gw.fk_ws_id",					"operator" => "=",	"right" => $WebSiteObj->getWebSiteEntry('ws_id'));
$pageSelectorData['clauseElements'][] = array("left" => "gu.fk_user_id",				"operator" => "=",	"right" => "usr.user_id");
$pageSelectorData['clauseElements'][] = array("left" => "gw.fk_group_id",				"operator" => "=",	"right" => "gu.fk_group_id");
$pageSelectorData['clauseElements'][] = array("left" => "gu.fk_group_id",				"operator" => "=",	"right" => "gr.group_id");
$pageSelectorData['clauseElements'][] = array("left" => "usr.user_name",				"operator" => "<>",	"right" => "'JnsEngAdmDB'");

$dbquery = $bts->SDDMObj->query("
SELECT COUNT(usr.user_id) AS mucount 
FROM " . $SqlTableListObj->getSQLTableName('user') . " usr, "
	. $SqlTableListObj->getSQLTableName('group') . " gr, "
	. $SqlTableListObj->getSQLTableName('group_user') . " gu, "
	. $SqlTableListObj->getSQLTableName('group_website') . " gw " 
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. ";", 1);
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$pageSelectorData['ItemsCount'] = $dbp['mucount'];
}

$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
if ($pageSelectorData['ItemsCount'] > $pageSelectorData['nbrPerPage']) {
		if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') ?? '') > 0) {
		$strQueryLike	= "&filterForm[query_like]="	. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like');
	}
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage') ?? '') > 0) {
		$strNbrPerPage	= "&filterForm[nbrPerPage]="	. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
	}
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id') ?? '') > 0) {
		$strGroupId	= "&filterForm[group_id]="		. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id');
	}
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status') ?? '') > 0) {
		$strUserStatus	= "&filterForm[user_status]="	. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status');
	}
	$pageSelectorData['link'] = $strQueryLike . $strGroupId . $strUserStatus . $strNbrPerPage;
	$pageSelectorData['elmIn'] = "<div class='" . $Block . "_page_selector'>";
	$pageSelectorData['elmInHighlight'] = "<div class='" . $Block . "_page_selector_highlight'>";
	$pageSelectorData['elmOut'] = "</div>";
	$pageSelectorData['selectionOffset'] = "" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset');
	$Content .= $TemplateObj->renderPageSelector($pageSelectorData);
}


$dbquery = $bts->SDDMObj->query("
SELECT usr.user_id,usr.user_login,user_name,usr.user_last_visit,gr.group_title,usr.user_status 
FROM " . $SqlTableListObj->getSQLTableName('user') . " usr, "
	. $SqlTableListObj->getSQLTableName('group') . " gr, "
	. $SqlTableListObj->getSQLTableName('group_user') . " gu, "
	. $SqlTableListObj->getSQLTableName('group_website') . " gw "
	. $bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
	. " ORDER BY user_name, user_login"
	. " LIMIT " . $pageSelectorData['nbrPerPage'] . " OFFSET " . ($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset'))
	. ";");

$pageSelectorData['realNbrPerPage'] = $bts->SDDMObj->num_row_sql($dbquery);

$T = array();
$i = 1;
$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
$T['Content']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
$T['Content']['1'][$i]['5']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
$T['Content']['1'][$i]['6']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_6_txt');
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$i++;
	$T['Content']['1'][$i]['1']['cont'] = "<a href='"
		. "index.php?" . _JNSENGLINKURLTAG_ . "=1"
		. "&arti_slug=" . $CurrentSetObj->getDataSubEntry('article', 'arti_slug')
		. "&arti_ref=" . $CurrentSetObj->getDataSubEntry('article', 'arti_ref')
		. "&arti_page=2"
		. "&formGenericData[mode]=edit"
		. "&userForm[selectionId]=" . $dbp['user_id']
		. "'>"
		. $dbp['user_login']
		. "</a>\r";
	$T['Content']['1'][$i]['2']['cont'] = $dbp['user_name'];
	$T['Content']['1'][$i]['3']['cont'] = $dbp['group_title'];
	$T['Content']['1'][$i]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('status' . $dbp['user_status']);
	$lastVisit = ($dbp['user_last_visit'] != 0) ? date("Y M d - H:i:s", $dbp['user_last_visit']) : "";
	$T['Content']['1'][$i]['5']['cont'] = $lastVisit;
}

// --------------------------------------------------------------------------------------------
// Menu select for group
$tdStyle = " style='margin:0.1cm;'";
$infos['insertLines'] = "<!-- group select -->"
	. "<tr>\r"
	. "<td " . $tdStyle . ">" . $bts->I18nTransObj->getI18nTransEntry('pageSelectorQuerygroup') . "</td>\r"
	. "<td " . $tdStyle . ">"
	. "<select name='filterForm[group_id]'>";

unset($A, $B);

$q = "SELECT grp.group_id, grp.group_name, grp.group_title "
	. "FROM "
	. $SqlTableListObj->getSQLTableName('group') . " grp, "
	. $SqlTableListObj->getSQLTableName('group_website') . " wg "
	. "WHERE wg.fk_ws_id = " . $WebSiteObj->getWebSiteEntry('ws_id') . " "
	. "AND wg.fk_group_id = grp.group_id "
	. "ORDER BY grp.group_title "
	. ";";

	$infos['insertLines'] .= "<option value='0'></option>\r";

$dbquery = $bts->SDDMObj->query($q, 1);
$group_id = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id');
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	if ($group_id == $dbp['group_id']) {
		$dbp['selected'] = " selected ";
	} else {
		$dbp['selected'] = "";
	}
	$infos['insertLines'] .= "<option value='" . $dbp['group_id'] . "' " . $dbp['selected'] . ">" . $dbp['group_title'] . "</option>\r";
}

$infos['insertLines'] .= "</select>\r"
	. "</td>\r"
	. "</tr>\r";

// --------------------------------------------------------------------------------------------
// Menu select for status
$infos['insertLines'] .= "<!-- status select -->"
	. "<tr>\r"
	. "<td " . $tdStyle . ">" . $bts->I18nTransObj->getI18nTransEntry('pageSelectorQueryStatus') . "</td>\r"
	. "<td " . $tdStyle . ">"
	. "<select name='filterForm[user_status]'>"
	. "<option value='0'>" . $bts->I18nTransObj->getI18nTransEntry('select2_0') . "</option>\r"
	. "<option value='1' selected>" . $bts->I18nTransObj->getI18nTransEntry('select2_1') . "</option>\r"
	. "<option value='2'>" . $bts->I18nTransObj->getI18nTransEntry('select2_2') . "</option>\r"
	. "</select>\r"
	. "</td>\r"
	. "</tr>\r";

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, $i);
$T['ContentCfg']['tabs'] = array(
	1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i, 6, 1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T)
	. "<br>\r"
	. $TemplateObj->renderFilterForm($infos)
	. $TemplateObj->renderAdminCreateButton($infos);


$bts->segmentEnding(__METHOD__);
// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-End*/
