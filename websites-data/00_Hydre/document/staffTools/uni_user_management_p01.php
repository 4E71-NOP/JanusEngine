<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
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
/*Hydre-IDE-end*/

$bts->RequestDataObj->setRequestData(
	'filterForm',
	array(
		'user_status'			=> 1,
		'nbrPerPage'			=> 5,
		'group_id'				=> 0,
	),
);

/*Hydr-Content-Begin*/
$localisation = " / uni_user_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation);
$bts->LMObj->logCheckpoint("uni_user_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation);
$bts->MapperObj->setSqlApplicant("uni_user_management_p01.php");

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
			"pageSelectorDisplay"		=>	"Display",
			"pageSelectorNbrPerPage"	=>	"entries per page",
			"pageSelectorBtnFilter"		=>	"Filter",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$GDU_ = array();

$GDU_['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
// error_log( $data['selectionOffset'] ."!=". $data['pageCounter'] );
if ($GDU_['nbrPerPage'] < 1) {
	$GDU_['nbrPerPage'] = _ADMIN_PAGE_TABLE_DEFAULT_NBR_LINE_;
}
if ($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id') == 0) {
	$bts->RequestDataObj->setRequestDataSubEntry('filterForm', 'group_id', null);
}

$clause_sql_element = array();
$clause_sql_element['1'] = "WHERE";
$clause_sql_element['2'] = $clause_sql_element['3'] = $clause_sql_element['4'] = $clause_sql_element['5'] = $clause_sql_element['6'] = $clause_sql_element['7'] = $clause_sql_element['8'] = $clause_sql_element['9'] = $clause_sql_element['10'] = "AND";

$clause_sql_element_offset = 1;
$GDU_['clause_like'] = "";
if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like')) > 0) {
	$GDU_['clause_like'] .= " " .	$clause_sql_element[$clause_sql_element_offset] . " usr.user_login LIKE '%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%' ";
	$clause_sql_element_offset++;
}
if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id')) > 0 && $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id') != 0) {
	$GDU_['clause_like'] .= " " .	$clause_sql_element[$clause_sql_element_offset] . " gr.group_id = '" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id') . "' ";
	$clause_sql_element_offset++;
}
if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status')) > 0) {
	$GDU_['clause_like'] .= " " .	$clause_sql_element[$clause_sql_element_offset] . " usr.user_status = '" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status') . "' ";
	$clause_sql_element_offset++;
}
$GDU_['clause_like'] .= " " . $clause_sql_element[$clause_sql_element_offset] . " gr.group_tag != '0' ";
$clause_sql_element_offset++;
$GDU_['clause_like'] .= " " . $clause_sql_element[$clause_sql_element_offset] . " gu.group_user_initial_group = '1' ";
$clause_sql_element_offset++;
$GDU_['clause_like'] .= " " . $clause_sql_element[$clause_sql_element_offset] . " gw.fk_ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "' ";
$clause_sql_element_offset++;
$GDU_['clause_like'] .= " " . $clause_sql_element[$clause_sql_element_offset] . " gu.fk_user_id = usr.user_id";
$clause_sql_element_offset++;
$GDU_['clause_like'] .= " " . $clause_sql_element[$clause_sql_element_offset] . " gw.fk_group_id = gu.fk_group_id ";
$clause_sql_element_offset++;
$GDU_['clause_like'] .= " " . $clause_sql_element[$clause_sql_element_offset] . " gu.fk_group_id = gr.group_id ";
$clause_sql_element_offset++;
$GDU_['clause_like'] .= " " . $clause_sql_element[$clause_sql_element_offset] . " usr.user_name != 'HydreBDD'";
$clause_sql_element_offset++;


$dbquery = $bts->SDDMObj->query("
SELECT COUNT(usr.user_id) AS mucount 
FROM " . $SqlTableListObj->getSQLTableName('user') . " usr, "
	. $SqlTableListObj->getSQLTableName('group') . " gr, "
	. $SqlTableListObj->getSQLTableName('group_user') . " gu, "
	. $SqlTableListObj->getSQLTableName('group_website') . " gw 
" . $GDU_['clause_like'] . ";");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$GDU_['ItemsCount'] = $dbp['mucount'];
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
if ($GDU_['ItemsCount'] > $GDU_['nbrPerPage']) {

	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like')) > 0) {
		$strQueryLike	= "&filterForm[query_like]="	. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like');
	}
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage')) > 0) {
		$strNbrPerPage	= "&filterForm[nbrPerPage]="	. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
	}
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id')) > 0) {
		$strGroupId	= "&filterForm[group_id]="		. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id');
	}
	if (strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status')) > 0) {
		$strUserStatus	= "&filterForm[user_status]="	. $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status');
	}

	$GDU_['link'] = $strQueryLike . $strGroupId . $strUserStatus . $strNbrPerPage;
	$GDU_['elmIn'] = "<div class='" . $Block . "_page_selector'>";
	$GDU_['elmInHighlight'] = "<div class='" . $Block . "_page_selector_highlight'>";
	$GDU_['elmOut'] = "</div>";
	$GDU_['selectionOffset'] = "" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset');
	$Content .= $TemplateObj->renderPageSelector($GDU_);
}

$dbquery = $bts->SDDMObj->query("
SELECT usr.user_id,usr.user_login,user_name,usr.user_last_visit,gr.group_title,usr.user_status 
FROM " . $SqlTableListObj->getSQLTableName('user') . " usr, "
	. $SqlTableListObj->getSQLTableName('group') . " gr, "
	. $SqlTableListObj->getSQLTableName('group_user') . " gu, "
	. $SqlTableListObj->getSQLTableName('group_website') . " gw "
	. $GDU_['clause_like']
	. " ORDER BY user_name, user_login"
	. " LIMIT " . $GDU_['nbrPerPage'] . " OFFSET " . ($GDU_['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset'))
	. ";");

$GDU_['realNbrPerPage'] = $bts->SDDMObj->num_row_sql($dbquery);

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
		. "index.php?" . _HYDRLINKURLTAG_ . "=1"
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
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ContentCfg']['tabs'] = array(
	1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i, 6, 1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T)
	. "<br>\r"
	. $TemplateObj->renderFilterForm($infos)
	. $TemplateObj->renderAdminCreateButton($infos);
// --------------------------------------------------------------------------------------------
/*Hydr-Content-End*/
