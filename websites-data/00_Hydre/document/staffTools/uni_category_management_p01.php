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

$bts->RequestDataObj->setRequestData('cate_parent', 39);

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_category_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_category_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_category_management_p01.php");

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de modifier les deadlines.",
		"col_1_txt"		=> "Id",
		"col_2_txt"		=> "Nom",
		"col_3_txt"		=> "Titre",
		"col_4_txt"		=> "Parent",
		"col_5_txt"		=> "Pos",
		"col_6_txt"		=> "▲/▼",
		"col_7_txt"		=> "Etat",
		"cell_1_txt"	=> "Informations",
		"dlState0"		=> "Hors ligne",
		"dlState1"		=> "En ligne",
		"dlState2"		=> "Supprimé",
		));
		break;
	case "eng":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "This part will allow you to modify deadlines.",
		"col_1_txt"		=> "Id",
		"col_2_txt"		=> "Name",
		"col_3_txt"		=> "Title",
		"col_4_txt"		=> "Parent",
		"col_5_txt"		=> "Pos",
		"col_6_txt"		=> "▲/▼",
		"col_7_txt"		=> "Status",
		"cell_1_txt"	=> "Informations",
		"dlState0"		=> "Offline",
		"dlState1"		=> "Online",
		"dlState2"		=> "Deleted",
		));
		break;
}

$dbquery = $bts->SDDMObj->query("
SELECT c.lang_id, l.lang_original_name
FROM ".$SqlTableListObj->getSQLTableName('category')." c, ".$SqlTableListObj->getSQLTableName('language')." l, ".$SqlTableListObj->getSQLTableName('language_website')." sl
WHERE c.cate_type IN ('0','1')
AND c.cate_state = '1'
AND c.ws_id = '2'
AND c.lang_id = l.lang_id
AND l.lang_id = sl.lang_id
AND c.ws_id = sl.ws_id
AND c.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
GROUP BY c.lang_id
;");

$CateTabList = array();
$langClause = "";
$i = 1;
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$CateTabList[$dbp['lang_id']]['tab'] = $i; 
	$CateTabList[$dbp['lang_id']]['id'] = $dbp['lang_id']; 
	$CateTabList[$dbp['lang_id']]['nom'] = $dbp['lang_original_name']; 
	$CateTabList[$dbp['lang_id']]['count'] = 1;
	$CateTabList[$dbp['lang_id']]['linePtr'] = 2;
	$langClause .= $dbp['lang_id'].", ";
	$i++;
}

$bts->LMObj->logDebug($CateTabList, "CateTabList");

$langClause = substr($langClause, 0, -2);
$nbrTabs = $i-1;

// Prepare the chart first line.
$T = array();

reset ($CateTabList);
unset ($A);
foreach ( $CateTabList as $A ) {
	$Tab = $A['tab'];
	$T['AD'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['AD'][$Tab]['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['AD'][$Tab]['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	$T['AD'][$Tab]['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
	$T['AD'][$Tab]['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
	$T['AD'][$Tab]['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_6_txt');
	$T['AD'][$Tab]['1']['7']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_7_txt');
}

$dbquery = $bts->SDDMObj->query("SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('category')." c, ".$SqlTableListObj->getSQLTableName('language_website')." sl, ".$SqlTableListObj->getSQLTableName('website')." sw 
WHERE c.cate_type IN (0,1) 
AND c.cate_state = '1' 
AND c.lang_id IN (".$langClause.") 
AND c.lang_id = sl.lang_id 
AND sl.ws_id = sw.ws_id 
AND sw.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY c.lang_id, c.cate_parent, c.cate_position 
;");

$stateTab = array(
	0	=>	$bts->I18nTransObj->getI18nTransEntry('disabled'),
	1	=>	$bts->I18nTransObj->getI18nTransEntry('enabled'),
);

$buttonLink = "<a href='index.php?arti_ref=".$CurrentSetObj->getDataSubEntry('article', 'arti_ref')."&arti_page=".$CurrentSetObj->getDataSubEntry('article', 'arti_page'); 
$buttonUp = "'><img src='../media/theme/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'repertoire')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icone_haut')."' width='16' height='16'>"; 
$buttonDown = "'><img src='../media/theme/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'repertoire')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icone_bas')."' width='16' height='16'>";

while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery) ) {
	$Tab = $CateTabList[$dbp['lang_id']]['tab'];
	$l = $CateTabList[$dbp['lang_id']]['linePtr'];
	$T['AD'][$Tab][$l]['1']['cont'] = $dbp['cate_id'];
	$T['AD'][$Tab][$l]['1']['tc'] = 1;
	$T['AD'][$Tab][$l]['1']['style'] = "text-align:center;";
	$T['AD'][$Tab][$l]['2']['cont'] =
		"<a class='".$Block."_lien' href='index.php?"
		."sw=".$WebSiteObj->getWebSiteEntry('ws_id')
		."&l=".$CurrentSetObj->getDataEntry('language')
		."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
		."&arti_page=2"
		."&formGenericData[mode]=edit"
		."&categoryForm[selectionId]=".$dbp['cate_id']
		."'>".$dbp['cate_name']."</a>";
	$T['AD'][$Tab][$l]['3']['cont'] = $dbp['cate_title'];
	$T['AD'][$Tab][$l]['4']['cont'] = $dbp['cate_parent'];
	$T['AD'][$Tab][$l]['4']['tc'] = 1;
	$T['AD'][$Tab][$l]['4']['style'] = "text-align:center;";
	$T['AD'][$Tab][$l]['5']['cont'] = $dbp['cate_position'];
	$T['AD'][$Tab][$l]['5']['tc'] = 1;
	$T['AD'][$Tab][$l]['5']['style'] = "text-align:center;";
	$T['AD'][$Tab][$l]['6']['cont'] = $buttonLink."&categoryForm[cate_id]=".$dbp['cate_id']."&categoryForm[command]=moveUp".$buttonUp."</a>\r - \r".$buttonLink."&categoryForm[cate_id]=".$dbp['cate_id']."&categoryForm[command]=moveDown".$buttonDown."</a>\r";
	$T['AD'][$Tab][$l]['7']['cont'] = $stateTab[$dbp['cate_state']];
	$T['AD'][$Tab][$l]['7']['tc'] = 1;
	$l++;
	$CateTabList[$dbp['lang_id']]['count'] = $CateTabList[$dbp['lang_id']]['linePtr'] = $l;
}


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
reset ($CateTabList);
unset ($A);
foreach ( $CateTabList as $A ) {
	$Tab = $A['tab'];
	$T['ADC']['onglet'][$Tab] = $bts->RenderTablesObj->getDefaultTableConfig($A['count']-1,7,1);
	$bts->I18nTransObj->setI18nEntry('tabTxt'.$Tab, $A['nom']);
}
$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15,$nbrTabs );
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
// DEPRECATED : 
// Data sorting. Was useful at some point during migration. 
// Wil be removed some day.
function CateRchRacine ( $cate_type, &$src , &$dst ) {
	foreach ( $src as $A ) {
		if ( $A['cate_type'] == $cate_type ) { 
			foreach ( $A as $B => $C ) { $dst['0'][$B] = $C ; }
		}
	}
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
