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
/* @var $cs CommonSystem                            */
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
/*Hydre-contenu_debut*/
$localisation = " / uni_group_management_p01";
$cs->MapperObj->AddAnotherLevel($localisation );
$cs->LMObj->logCheckpoint("uni_group_management_p01.php");
$cs->MapperObj->RemoveThisLevel($localisation );
$cs->MapperObj->setSqlApplicant("uni_group_management_p01.php");

switch ($l) {
	case "fra":
		$cs->I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les groupes.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Titre",
		"col_3_txt"		=> "Tag",
		"tabTxt1"		=> "Informations",
		"tag0"			=> "Anonyme",
		"tag1"			=> "Lecteur",
		"tag2"			=> "Staff",
		"tag3"			=> "Senior staff",
		));
		break;
	case "eng":
		$cs->I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage groups.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Title",
		"col_3_txt"		=> "Tag",
		"tabTxt1"		=> "Informations",
		"tag0"			=> "Anonymous",
		"tag1"			=> "Reader",
		"tag2"			=> "Staff",
		"tag3"			=> "Senior staff",
		));
		break;
}

$tagTab = array(
	0 => $cs->I18nObj->getI18nEntry('tag0'),
	1 => $cs->I18nObj->getI18nEntry('tag1'),
	2 => $cs->I18nObj->getI18nEntry('tag2'),
	3 => $cs->I18nObj->getI18nEntry('tag3'),
);

$T = array();
$dbquery = $cs->SDDMObj->query("
SELECT grp.*, sg.group_state 
FROM ".$SqlTableListObj->getSQLTableName('group')." grp, ".$SqlTableListObj->getSQLTableName('group_website')." sg 
WHERE sg.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND grp.group_id = sg.group_id 
and grp.group_name != 'Server_owner' 
;");
$i = 1;
$T['AD']['1'][$i]['1']['cont']	= $cs->I18nObj->getI18nEntry('col_1_txt');
$T['AD']['1'][$i]['2']['cont']	= $cs->I18nObj->getI18nEntry('col_2_txt');
$T['AD']['1'][$i]['3']['cont']	= $cs->I18nObj->getI18nEntry('col_3_txt');
while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) { 
	$i++;
	$T['AD']['1'][$i]['link'] = "index.php?arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')."&arti_page=2&formGenericData[mode]=edit&groupForm[selectionId]=".$dbp['group_id'];
// 	$T['AD']['1'][$i]['1']['cont'] = "<a class='".$Block."_lien' href='index.php?"
// 	.$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')
// 	."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
// 	."&arti_page=2"
// 	."&formGenericData[mode]=edit"
// 	."&groupForm[selectionId]=".$dbp['group_id']
// 	."'>".$dbp['group_name']
// 	."</a>";
	$T['AD']['1'][$i]['1']['cont'] =$dbp['group_name'];
	$T['AD']['1'][$i]['2']['cont'] = $dbp['group_title'];
	$T['AD']['1'][$i]['2']['tc'] = 2;
	$T['AD']['1'][$i]['3']['cont'] = $tagTab[$dbp['group_tag']];
	$T['AD']['1'][$i]['3']['tc'] = 2;
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $cs->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ADC']['onglet'] = array(
		1	=>	$cs->RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $cs->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
