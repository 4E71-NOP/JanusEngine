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
/*Hydre-contenu_debut*/
$localisation = " / uni_module_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_module_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_module_management_p01.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
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
		$bts->I18nTransObj->apply(array(
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
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

$dbquery = $bts->SDDMObj->query("
SELECT a.module_id,a.module_deco,a.module_deco_nbr,a.module_name,a.module_title,a.module_file,a.module_desc,a.module_group_allowed_to_see,a.module_group_allowed_to_use,a.module_adm_control,b.module_state 
FROM ".$SqlTableListObj->getSQLTableName('module')." a , ".$SqlTableListObj->getSQLTableName('module_website')." b 
WHERE a.module_id = b.module_id 
AND b.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY b.module_position
;");

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
$T['AD']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
$T['AD']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
$T['AD']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
$T['AD']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
$T['AD']['1'][$i]['5']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
$T['AD']['1'][$i]['6']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_6_txt');
$T['AD']['1'][$i]['7']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_7_txt');

foreach ( $table_infos_modules AS $A1 ) {
	$i++;
	$A2 = $A1['module_state'];
	$A3 = $A1['module_deco'];
	$A4 = $A1['module_adm_control'];
	$gpv = $A1['module_group_allowed_to_see'];
	$gpu = $A1['module_group_allowed_to_use'];
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
	.$A1['module_name']
	."</a>\r";

	$T['AD']['1'][$i]['2']['cont'] = $A1['module_desc'];
	$T['AD']['1'][$i]['3']['cont'] = $tab_module_state[$A2];
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
$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ADC']['onglet'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,7,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
