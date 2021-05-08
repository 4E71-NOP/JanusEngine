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

// --------------------------------------------------------------------------------------------
/*Hydr-Content-Begin*/
$localisation = " / uni_group_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_group_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_group_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les groupes.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Titre",
			"col_3_txt"		=> "Tag",
			"tabTxt1"		=> "Informations",
			"tag0"			=> "Anonyme",
			"tag1"			=> "Lecteur",
			"tag2"			=> "Staff",
			"tag3"			=> "Senior staff",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage groups.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Title",
			"col_3_txt"		=> "Tag",
			"tabTxt1"		=> "Informations",
			"tag0"			=> "Anonymous",
			"tag1"			=> "Reader",
			"tag2"			=> "Staff",
			"tag3"			=> "Senior staff",
		)
	)
);

$tagTab = array(
	0 => $bts->I18nTransObj->getI18nTransEntry('tag0'),
	1 => $bts->I18nTransObj->getI18nTransEntry('tag1'),
	2 => $bts->I18nTransObj->getI18nTransEntry('tag2'),
	3 => $bts->I18nTransObj->getI18nTransEntry('tag3'),
);

$T = array();
$dbquery = $bts->SDDMObj->query("
SELECT grp.*, wg.group_state 
FROM "
.$SqlTableListObj->getSQLTableName('group')." grp, "
.$SqlTableListObj->getSQLTableName('group_website')." wg 
WHERE wg.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND grp.group_id = wg.fk_group_id 
and grp.group_name != 'Server_owner' 
;");
$i = 1;
$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$i++;
	$T['Content']['1'][$i]['link'] = "index.php?arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')."&arti_page=2&formGenericData[mode]=edit&groupForm[selectionId]=".$dbp['group_id'];
// 	$T['Content']['1'][$i]['1']['cont'] = "<a class='".$Block."_lien' href='index.php?"
// 	.$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')
// 	."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
// 	."&arti_page=2"
// 	."&formGenericData[mode]=edit"
// 	."&groupForm[selectionId]=".$dbp['group_id']
// 	."'>".$dbp['group_name']
// 	."</a>";
	$T['Content']['1'][$i]['1']['cont'] =$dbp['group_name'];
	$T['Content']['1'][$i]['2']['cont'] = $dbp['group_title'];
	$T['Content']['1'][$i]['2']['tc'] = 2;
	$T['Content']['1'][$i]['3']['cont'] = $tagTab[$dbp['group_tag']];
	$T['Content']['1'][$i]['3']['tc'] = 2;
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
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydr-Content-End*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
