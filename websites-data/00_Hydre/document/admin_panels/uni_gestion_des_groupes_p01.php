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
// Some definitions in order to ease the IDE work.
/* @var $AdminFormToolObj AdminFormTool             */
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $I18nObj I18n                               */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */
/* @var $TimeObj Time                               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $RenderLayoutObj RenderLayout               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_groupes_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_groupes_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_groupes_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
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
		$I18nObj->apply(array(
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
	0 => $I18nObj->getI18nEntry('tag0'),
	1 => $I18nObj->getI18nEntry('tag1'),
	2 => $I18nObj->getI18nEntry('tag2'),
	3 => $I18nObj->getI18nEntry('tag3'),
);

$T = array();
$dbquery = $SDDMObj->query("
SELECT grp.*, sg.group_state 
FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp, ".$SqlTableListObj->getSQLTableName('group_website')." sg 
WHERE sg.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND grp.group_id = sg.group_id 
and grp.groupe_nom != 'Server_owner' 
;");
$i = 1;
$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
	$i++;
	$T['AD']['1'][$i]['1']['cont'] = "<a class='".$Block."_lien' href='index.php?"
	.$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')
	."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
	."&arti_page=2"
	."&formGenericData[mode]=edit"
	."&groupForm[selectionId]=".$dbp['group_id']
	."'>".$dbp['groupe_nom']
	."</a>";
	$T['AD']['1'][$i]['2']['cont'] = $dbp['groupe_titre'];
	$T['AD']['1'][$i]['2']['tc'] = 2;
	$T['AD']['1'][$i]['3']['cont'] = $tagTab[$dbp['groupe_tag']];
	$T['AD']['1'][$i]['3']['tc'] = 2;
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
