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

$RequestDataObj->setRequestData('moduleForm',
	array(
			'mode'			=> 'edit',
// 			'mode'			=> 'create',
			'selectionId'	=>	14,
	)
);
$RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminModuleManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);

/*Hydre-contenu_debut*/
$localisation = " / fra_gestion_des_modules_p02";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("fra_gestion_des_modules_p02");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("fra_gestion_des_modules_p02");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"before"		=>	"Avant",
		"during"		=>	"Pendant",
		"after"			=>	"Après",
		
		"invite1"		=> "Cette partie va vous permettre de gérer le module.",
		"invite2"		=> "Cette partie va vous permettre de créer un module.",
		"tabTxt1"		=>	"Général",
		"tabTxt2"		=>	"Configuration",
		"tabTxt3"		=>	"Etat",
		"dlState0"		=> "Hors ligne",
		"dlState1"		=> "En ligne",
		"dlState2"		=> "Supprimé",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Nom",
		"t1l3c1"		=>	"Titre",
		"t1l4c1"		=>	"Description",

		"t2l1c1"		=>	"Fichier",
		"t2l2c1"		=>	"Décoration",
		"t2l3c1"		=>	"Décoration N°",
		"t2l4c1"		=>	"Groupe pour voir",
		"t2l5c1"		=>	"Groupe pour utiliser",
		"t2l6c1"		=>	"Admin",
		"t2l7c1"		=>	"Mode d'exécution",

		"t3l1c1"		=>	"Etat",
		
		"t1l1c2"		=>	"?",
		"t1l2c2"		=>	"Nouveau_module",
		"t1l3c2"		=>	"Deadline_",
		
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"before"		=>	"Before",
		"during"		=>	"During",
		"after"			=>	"After",
		
		"invite1"		=> "This part will allow you to manage this module.",
		"invite2"		=> "This part will allow you to create a module.",
		"tabTxt1"		=> "General",
		"tabTxt2"		=> "Configuration",
		"tabTxt3"		=> "State",
		"dlState0"		=> "Offline",
		"dlState1"		=> "Online",
		"dlState2"		=> "Deleted",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Name",
		"t1l3c1"		=>	"Title",
		"t1l4c1"		=>	"Description",
		
		"t2l1c1"		=>	"File",
		"t2l2c1"		=>	"Décoration",
		"t2l3c1"		=>	"Décoration N°",
		"t2l4c1"		=>	"Group who can see",
		"t2l5c1"		=>	"Group who can use",
		"t2l6c1"		=>	"Admin",
		"t2l7c1"		=>	"Execution mode",
		
		"t3l1c1"		=>	"State",
		
		"t1l1c2"		=>	"?",
		"t1l2c2"		=>	"New_module",
		"t1l3c2"		=>	"Module_",
		));
		break;
}
// --------------------------------------------------------------------------------------------
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
// Table preparation
// --------------------------------------------------------------------------------------------
$groupTab = array();
$dbquery = $SDDMObj->query("
SELECT a.group_id,a.groupe_titre,a.groupe_nom
FROM ".$SqlTableListObj->getSQLTableName('groupe')." a , ".$SqlTableListObj->getSQLTableName('group_website')." b
WHERE a.group_id = b.group_id
AND ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY a.groupe_titre
;");
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
	$i = $dbp['group_id'];
	$groupTab[$i]['id']		= $dbp['group_id'];
	$groupTab[$i]['nom']	= $dbp['groupe_nom'];
	$groupTab[$i]['titre']	= $dbp['groupe_titre'];
}

$ClassLoaderObj->provisionClass('Module');
$currentModuleObj = new Module();
switch ( $RequestDataObj->getRequestDataSubEntry('moduleForm', 'mode') ) {
	case "edit":
		$currentModuleObj->getModuleDataFromDB($RequestDataObj->getRequestDataSubEntry('moduleForm', 'selectionId'));
		$commandType = "update";
		$Content .= "<p>".$I18nObj->getI18nEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":	
		$currentModuleObj->setModule(
			array(
				"module_id"	=> "",
				"module_deco"					=>	1,
				"module_deco_nbr"				=>	1,
				"module_name"					=>	$I18nObj->getI18nEntry('t1l2c2'),
				"module_title"					=>	$I18nObj->getI18nEntry('t1l2c2'),
				"module_file"				=>	"",
				"module_desc"					=>	$I18nObj->getI18nEntry('t1l2c2'),
				"module_group_allowed_to_see"		=>	2,
				"module_group_allowed_to_use"	=>	2,
				"module_state"					=>	0,
				"module_position"				=>	1,
				"module_adm_control"			=>	0,
				"module_execution"				=>	0,
			)
		);
		$commandType = "add";
		$Content .= "<p>".$I18nObj->getI18nEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= "
<form ACTION='index.php?' method='post' name='moduleForm'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminModuleManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value='module'>"
."<input type='hidden' name='formTarget1[name]'			value='".$currentModuleObj->getModuleEntry('module_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='moduleForm[selectionId]'	value='".$RequestDataObj->getRequestDataSubEntry('moduleForm', 'selectionId')."'>\r"
."<p>\r"
;



// --------------------------------------------------------------------------------------------
$T = array();

$T['AD']['1']['1']['1']['cont'] = $I18nObj->getI18nEntry('t1l1c1');
$T['AD']['1']['2']['1']['cont'] = $I18nObj->getI18nEntry('t1l2c1');
$T['AD']['1']['3']['1']['cont'] = $I18nObj->getI18nEntry('t1l3c1');
$T['AD']['1']['4']['1']['cont'] = $I18nObj->getI18nEntry('t1l4c1');



$T['AD']['1']['1']['2']['cont'] = $currentModuleObj->getModuleEntry('module_id');
switch ( $RequestDataObj->getRequestDataSubEntry('moduleForm', 'mode') ) {
	case "edit":
		$T['AD']['1']['2']['2']['cont'] = $currentModuleObj->getModuleEntry('module_name');
		break;
	case "create":
		$T['AD']['1']['1']['2']['cont'] = "*";
		$T['AD']['1']['2']['2']['cont'] = "<input type='text' name='formTarget[name]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		break;
}
$T['AD']['1']['3']['2']['cont'] = "<input type='text' name='formParams[title]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD']['1']['4']['2']['cont'] = "<input type='text' name='formParams[desc]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_desc')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";


// --------------------------------------------------------------------------------------------

$T['AD']['2']['1']['1']['cont'] = $I18nObj->getI18nEntry('t2l1c1');
$T['AD']['2']['2']['1']['cont'] = $I18nObj->getI18nEntry('t2l2c1');
$T['AD']['2']['3']['1']['cont'] = $I18nObj->getI18nEntry('t2l3c1');
$T['AD']['2']['4']['1']['cont'] = $I18nObj->getI18nEntry('t2l4c1');
$T['AD']['2']['5']['1']['cont'] = $I18nObj->getI18nEntry('t2l5c1');
$T['AD']['2']['6']['1']['cont'] = $I18nObj->getI18nEntry('t2l6c1');
$T['AD']['2']['7']['1']['cont'] = $I18nObj->getI18nEntry('t2l7c1');


$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "moduleForm",
		"formTargetId"		=> "formParams[module_file]",
		"formInputSize"		=> 40 ,
		"formInputVal"		=> $currentModuleObj->getModuleEntry('module_file'),
		"path"				=> "/modules/",
		"restrictTo"		=> "/modules/",
		"strRemove"			=> "",
		"strAdd"			=> "../",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "t2l1c2",
		"case"				=> 1,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD']['2']['1']['2']['cont']		= $InteractiveElementsObj->renderIconSelectFile($infos);

$tabYN = array(
		0	=> array ( "t"=>$I18nObj->getI18nEntry('no'),		"db"=>"NO" ),
		1	=> array ( "t"=>$I18nObj->getI18nEntry('yes'),	"db"=>"YES" ),
);
$tabLine = array(
		0	=> array ( "t"=>$I18nObj->getI18nEntry('offline'),	"db"=>"OFFLINE" ),
		1	=> array ( "t"=>$I18nObj->getI18nEntry('online'),		"db"=>"ONLINE" ),
		2	=> array ( "t"=>$I18nObj->getI18nEntry('deleted'),	"db"=>"DELETED" ),
);
// $tabStatus = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nEntry('disabled'],	"db"=>"DISABLED" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nEntry('enabled'],	"db"=>"ENABLED" ),
// );


$tab = $tabYN;
$tab[$currentModuleObj->getModuleEntry('module_deco')]['s'] = " selected ";
$T['AD']['2']['2']['2']['cont'] = "<select name='formParams[deco]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tab as $A ) { $T['AD']['2']['2']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['2']['2']['2']['cont'] .= "</select>\r";




$T['AD']['2']['3']['2']['cont'] = "<select name='formParams[deco_nbr]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$tab = array();
for ( $i =1; $i<=30; $i++ ) {
	$tab[$i] = array(
			"t"		=>	$i." - ".$ThemeDataObj->getThemeDataEntry($StringFormatObj->getDecorationBlockName('theme_bloc_', $i, '_nom')) ,
			"db"	=>	$i,
			"s"		=>	($i == $currentModuleObj->getModuleEntry('deco_nbr')) ? "selected" : "",
	);
}


foreach ($tab as $A) { $T['AD']['2']['3']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['AD']['2']['3']['2']['cont'] .= "</select>\r";



$index_selection = array( $currentModuleObj->getModuleEntry('module_group_allowed_to_see') => " selected" );
$T['AD']['2']['4']['2']['cont'] = "<select name='formParams[group_who_can_see]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $groupTab as $A1 ) {
	$T['AD']['2']['4']['2']['cont'] .= "<option value='".$A1['nom']."' ".$index_selection[$A1['id']]."> ".$A1['titre']." </option>\r";
}
$T['AD']['2']['4']['2']['cont'] .= "</select>\r";



$T['AD']['2']['5']['2']['cont'] = "<select name='formParams[group_who_can_use]' class='".$Block."_t3 ".$Block."_form_1'>\r";
unset ($index_selection);
$index_selection = array( $currentModuleObj->getModuleEntry('module_group_allowed_to_use') => " selected" );
foreach ( $groupTab as $A1 ) {
	$T['AD']['2']['5']['2']['cont'] .= "<option value='".$A1['nom']."' ".$index_selection[$A1['id']]."> ".$A1['titre']." </option>\r";
}
$T['AD']['2']['5']['2']['cont'] .= "</select>\r";


$tab = $tabYN;
$T['AD']['2']['6']['2']['cont'] = "<select name='formParams[adm_control]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$A = $currentModuleObj->getModuleEntry('module_adm_control');
$tab[$A]['s'] = " selected ";
foreach ( $tab as $A ) { $T['AD']['2']['6']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['2']['6']['2']['cont'] .= "</select>\r";


$tab = array (
		0	=>	array("t" => $I18nObj->getI18nEntry('during'),	"db" => "DURING",),
		1	=>	array("t" => $I18nObj->getI18nEntry('before'),	"db" => "BEFORE",),
		2	=>	array("t" => $I18nObj->getI18nEntry('after'),		"db" => "AFTER",),
);

$T['AD']['2']['7']['2']['cont'] = "<select name='formParams[execution]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$tab[$currentModuleObj->getModuleEntry('module_execution')]['s'] = " selected ";
foreach ( $tab as $A1 ) {
	$T['AD']['2']['7']['2']['cont'] .= "<option value='".$A1['db']."' ".$A1['s']."> ".$A1['t']." </option>\r";
}
$T['AD']['2']['7']['2']['cont'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
$T['AD']['3']['1']['1']['cont'] = $I18nObj->getI18nEntry('t3l1c1');
$tab = $tabLine;
$T['AD']['3']['1']['2']['cont'] = "<select name='formParams[state]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$tab[$currentModuleObj->getModuleEntry('module_state')]['s'] = " selected ";
foreach ( $tab as $A ) { $T['AD']['3']['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['3']['1']['2']['cont'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 8, 3);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig(4,2,2),
		2	=>	$RenderTablesObj->getDefaultTableConfig(7,2,2),
		3	=>	$RenderTablesObj->getDefaultTableConfig(1,2,2),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "moduleForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
