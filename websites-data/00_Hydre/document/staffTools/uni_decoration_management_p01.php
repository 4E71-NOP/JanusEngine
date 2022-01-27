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

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

$localisation = " / uni_decoration_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_decoration_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_decoration_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gerer les décorations.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Etat",
			"col_3_txt"		=> "Type",
			"tabTxt1"		=> "Informations",
			"type"			=> array(
				10	=>	"Menu",
				20	=>	"Caligraph",
				30	=>	"1_DIV",
				40	=>	"Elegance",
				50	=>	"Exquisite",
				60	=>	"Elysion",
			),
			"state"			=> array(
				0	=> "HOrs ligne",
				1	=> "En ligne",
				2	=> "Supprimé",
			),
			"pageSelectorQueryLike"		=>	"Filtrer avec",
			"pageSelectorDisplay"		=>	"Affichage",
			"pageSelectorNbrPerPage"	=>	"entrées par page",
			"pageSelectorBtnFilter"		=>	"Filtrer",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage decoration.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "State",
			"col_3_txt"		=> "Type",
			"tabTxt1"		=> "Informations",
			"type"			=> array(
				10	=>	"Menu",
				20	=>	"Caligraphr",
				30	=>	"1_DIV",
				40	=>	"Elegance",
				50	=>	"Exquisite",
				60	=>	"Elysion",
				),
			"state"			=> array(
				0	=> "Offline",
				1	=> "Online",
				2	=> "Deleted",
			),
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
// $pageSelectorData['clauseElements'][] = array("left" => "tw.fk_ws_id",		"operator" => "=",	"right" => "'".$WebSiteObj->getWebSiteEntry('ws_id')."'" );
// $pageSelectorData['clauseElements'][] = array("left" => "td.theme_id",		"operator" => "=",	"right" => "tw.fk_theme_id" );

if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like'))>0 ) {
	$pageSelectorData['clauseElements'][] = array( "left" => "m.deco_name", "operator" => "LIKE", "right" => "'%".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like')."%'" );
}

$pageSelectorData['query'] = "SELECT"
." COUNT(d.deco_id) AS ItemsCount "
." FROM "
.$SqlTableListObj->getSQLTableName('decoration')." d "
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
$dbquery = $bts->SDDMObj->query("
SELECT * FROM "
.$SqlTableListObj->getSQLTableName('decoration'). " d"
." ORDER BY  d.deco_name"
." LIMIT ".($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset')).",".$pageSelectorData['nbrPerPage']
.";");

$T = array();
if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
}
else {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');

	$i = 1;
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= "
		<a class='".$Block."_lien' href='"
		."index.php?"._HYDRLINKURLTAG_."=1"
		."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
		."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
		."&arti_page=2"
		."&formGenericData[mode]=edit"
		."&formGenericData[selectionId]=".$dbp['deco_id']
		."'>".$dbp['deco_name']."</a>";
		$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('state')[$dbp['deco_state']];
		$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('type')[$dbp['deco_type']];
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
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T)
."<br>\r"
.$TemplateObj->renderFilterForm($infos)
.$TemplateObj->renderAdminCreateButton($infos)
;
// --------------------------------------------------------------------------------------------
/*Hydr-Content-End*/
?>
