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
$localisation = " / uni_gestion_des_modules_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_modules_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_modules_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de créer un module.",
		"invite2"		=> "Cette partie va vous permettre de gérer les modules.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Description",
		"col_3_txt"		=> "State",
		"col_4_txt"		=> "Decoration",
		"col_5_txt"		=> "Habilité à voir",
		"col_6_txt"		=> "Habilité à utiliser",
		"col_7_txt"		=> "Panneau d'administration",
		"tabTxt1"		=> "Informations",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to create a module.",
		"invite2"		=> "This part will allow you to manage modules.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Description",
		"col_3_txt"		=> "State",
		"col_4_txt"		=> "Decoration",
		"col_5_txt"		=> "Alowed to see",
		"col_6_txt"		=> "Alowed to use",
		"col_7_txt"		=> "Administration panel",
		"tabTxt1"		=> "Informations",
		));
		break;
}
$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

$dbquery = $SDDMObj->query("
SELECT a.module_id,a.module_deco,a.module_deco_nbr,a.module_nom,a.module_titre,a.module_fichier,a.module_desc,a.module_groupe_pour_voir,a.module_groupe_pour_utiliser,a.module_adm_control,b.module_etat 
FROM ".$SqlTableListObj->getSQLTableName('module')." a , ".$SqlTableListObj->getSQLTableName('site_module')." b 
WHERE a.module_id = b.module_id 
AND b.site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY b.module_position
;");

$groupTab = array();
$table_infos_modules = array();
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
	$module_id_index = $dbp['module_id'];
	foreach ( $dbp as $A => $B ) { $table_infos_modules[$module_id_index][$A] = $B; }
}

$dbquery = $SDDMObj->query("
SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('groupe')."
;");
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
	$i = $dbp['groupe_id'];
	$groupTab[$i] = $dbp['groupe_titre'];
}

$tab_module_etat = array(
	0 => "<span class='".$Block."_avert ".$Block."_t1'>".$I18nObj->getI18nEntry('disabled')."</span>",
	1 => $I18nObj->getI18nEntry('enabled'),
	2 => "<span class='".$Block."_avert ".$Block."_t1'>".$I18nObj->getI18nEntry('deleted')."</span>",
);
		
$tab_module_deco = array(
	0 => $I18nObj->getI18nEntry('no'),
	1 => $I18nObj->getI18nEntry('yes'),
);

$i = 1;
$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
$T['AD']['1'][$i]['4']['cont']	= $I18nObj->getI18nEntry('col_4_txt');
$T['AD']['1'][$i]['5']['cont']	= $I18nObj->getI18nEntry('col_5_txt');
$T['AD']['1'][$i]['6']['cont']	= $I18nObj->getI18nEntry('col_6_txt');
$T['AD']['1'][$i]['7']['cont']	= $I18nObj->getI18nEntry('col_7_txt');

foreach ( $table_infos_modules AS $A1 ) {
	$i++;
	$A2 = $A1['module_etat'];
	$A3 = $A1['module_deco'];
	$A4 = $A1['module_adm_control'];
	$gpv = $A1['module_groupe_pour_voir'];
	$gpu = $A1['module_groupe_pour_utiliser'];
	$gpv = $groupTab[$gpv];
	$gpu = $groupTab[$gpu];
	$T['AD']['1'][$i]['1']['cont'] = "
	<a class='".$Block."_lien' href='index.php?"
	."sw=".$WebSiteObj->getWebSiteEntry('ws_id')
	."&l=".$CurrentSetObj->getDataEntry('language')
	."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
	."&arti_page=2"
	."&formGenericData[mode]=edit"
	."&moduleForm[selectionId]=".$A1['module_id']
	."'>"
	.$A1['module_nom']
	."</a>\r";

	$T['AD']['1'][$i]['2']['cont'] = $A1['module_desc'];
	$T['AD']['1'][$i]['3']['cont'] = $tab_module_etat[$A2];
	$T['AD']['1'][$i]['4']['cont'] = $tab_module_deco[$A3];
	$T['AD']['1'][$i]['5']['cont'] = $gpv;
	$T['AD']['1'][$i]['6']['cont'] = $gpu;
	$T['AD']['1'][$i]['7']['cont'] = $tab_module_deco[$A4];
}
// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig($i,7,1),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
