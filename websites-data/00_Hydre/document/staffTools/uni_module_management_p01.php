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

// --------------------------------------------------------------------------------------------
/*Hydr-Content-Begin*/
$localisation = " / uni_module_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_module_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_module_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de créer un module.",
			"invite2"		=> "Cette partie va vous permettre de gérer les modules.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Description",
			"col_3_txt"		=> "State",
			"col_4_txt"		=> "Decoration",
			"col_5_txt"		=> "Permission",
			"col_6_txt"		=> "Panneau d'administration",
			"tabTxt1"		=> "Informations",
			"pageSelectorQueryLike"		=>	"Filtrer avec",
			"pageSelectorDisplay"		=>	"Affichage",
			"pageSelectorNbrPerPage"	=>	"entrées par page",
			"pageSelectorBtnFilter"		=>	"Filtrer",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to create a module.",
			"invite2"		=> "This part will allow you to manage modules.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Description",
			"col_3_txt"		=> "State",
			"col_4_txt"		=> "Decoration",
			"col_5_txt"		=> "Permission",
			"col_6_txt"		=> "Administration panel",
			"tabTxt1"		=> "Informations",
			"pageSelectorQueryLike"		=>	"Filter with",
			"pageSelectorDisplay"		=>	"Display",
			"pageSelectorNbrPerPage"	=>	"entries per page",
			"pageSelectorBtnFilter"		=>	"Filter",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$pageSelectorData['query'] = "";
$pageSelectorData['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
if ($pageSelectorData['nbrPerPage'] < 1 ) { $pageSelectorData['nbrPerPage'] = _ADMIN_PAGE_TABLE_DEFAULT_NBR_LINE_; }

$pageSelectorData['clauseElements'] = array();
$pageSelectorData['clauseElements'][] = array("left" => "mw.fk_ws_id",		"operator" => "=",	"right" => "'".$WebSiteObj->getWebSiteEntry('ws_id')."'" );
$pageSelectorData['clauseElements'][] = array("left" => "m.module_id",		"operator" => "=",	"right" => "mw.fk_module_id" );
$pageSelectorData['clauseElements'][] = array("left" => "m.fk_perm_id",		"operator" => "=",	"right" => "p.perm_id" );

if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like'))>0 ) {
	$pageSelectorData['clauseElements'][] = array( "left" => "m.module_name", "operator" => "LIKE", "right" => "'%".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like')."%'" );
}

$pageSelectorData['query'] = "SELECT"
." COUNT(m.module_id) AS ItemsCount "
." FROM "
.$SqlTableListObj->getSQLTableName('module')." m , "
.$SqlTableListObj->getSQLTableName('module_website')." mw, "
.$SqlTableListObj->getSQLTableName('permission')." p"
.$bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
.";"
;

$dbquery = $bts->SDDMObj->query($pageSelectorData['query']);
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $pageSelectorData['ItemsCount'] = $dbp['ItemsCount']; }

if ( $pageSelectorData['ItemsCount'] > $pageSelectorData['nbrPerPage'] ) {
	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like'))>0 )	{$strQueryLike	= "&filterForm[query_like]="	.$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like');}
	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage'))>0 )	{$strNbrPerPage	= "&filterForm[nbrPerPage]="	.$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');}

	$pageSelectorData['link'] = $strQueryLike . $strGroupId . $strUserStatus . $strNbrPerPage;
	$pageSelectorData['elmIn'] = "<div class='".$Block."_page_selector'>";
	$pageSelectorData['elmInHighlight'] = "<div class='".$Block."_page_selector_highlight'>";
	$pageSelectorData['elmOut'] = "</div>";
	$pageSelectorData['selectionOffset'] = "".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset');
	$Content .= $TemplateObj->renderPageSelector($pageSelectorData);
}

// --------------------------------------------------------------------------------------------


$dbquery = $bts->SDDMObj->query(
"SELECT m.*,p.perm_name"
." FROM "
.$SqlTableListObj->getSQLTableName('module')." m , "
.$SqlTableListObj->getSQLTableName('module_website')." mw, "
.$SqlTableListObj->getSQLTableName('permission')." p "
.$bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
." ORDER BY m.module_name, mw.module_position "
." LIMIT ".($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset')).",".$pageSelectorData['nbrPerPage']
.";");

$groupTab = array();
$table_infos_modules = array();
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$module_id_index = $dbp['module_id'];
	foreach ( $dbp as $A => $B ) { $table_infos_modules[$module_id_index][$A] = $B; }
}

$dbquery = $bts->SDDMObj->query("
SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('group')."
;");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$i = $dbp['group_id'];
	$groupTab[$i] = $dbp['group_title'];
}

$tab_module_state = array(
	0 => "<span class='".$Block."_avert ".$Block."_t1'>".$bts->I18nTransObj->getI18nTransEntry('disabled')."</span>",
	1 => $bts->I18nTransObj->getI18nTransEntry('enabled'),
	2 => "<span class='".$Block."_avert ".$Block."_t1'>".$bts->I18nTransObj->getI18nTransEntry('deleted')."</span>",
);
		
$tab_module_deco = array(
	0 => $bts->I18nTransObj->getI18nTransEntry('no'),
	1 => $bts->I18nTransObj->getI18nTransEntry('yes'),
);

$i = 1;
$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
$T['Content']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
$T['Content']['1'][$i]['5']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
$T['Content']['1'][$i]['6']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_6_txt');

foreach ( $table_infos_modules AS $A1 ) {
	$i++;
	$A2 = $A1['module_state'];
	$A3 = $A1['module_deco'];
	$A4 = $A1['module_adm_control'];
	$T['Content']['1'][$i]['1']['cont'] = "<a href='"
	."index.php?"._HYDRLINKURLTAG_."=1"
	."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
	."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
	."&arti_page=2"
	."&formGenericData[mode]=edit"
	."&moduleForm[selectionId]=".$A1['module_id']
	."'>"
	.$A1['module_name']
	."</a>\r";

	$T['Content']['1'][$i]['2']['cont'] = $A1['module_desc'];
	$T['Content']['1'][$i]['3']['cont'] = $tab_module_state[$A2];
	$T['Content']['1'][$i]['4']['cont'] = $tab_module_deco[$A3];
	$T['Content']['1'][$i]['5']['cont'] = $A1['perm_name'];
	$T['Content']['1'][$i]['6']['cont'] = $tab_module_deco[$A4];
}
// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,6,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T)
."<br>\r"
.$TemplateObj->renderFilterForm($infos)
.$TemplateObj->renderAdminCreateButton($infos)
;
// --------------------------------------------------------------------------------------------
/*Hydr-Content-End*/
?>
