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

$bts->RequestDataObj->setRequestData('moduleForm',
	array(
			'mode'			=> 'edit',
// 			'mode'			=> 'create',
			'selectionId'	=>	14,
	)
);
$bts->RequestDataObj->setRequestData('formGenericData',
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

/*Hydr-Content-Begin*/
$localisation = " / uni_module_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_module_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_module_management_p02.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
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
		$bts->I18nTransObj->apply(array(
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
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
// Table preparation
// --------------------------------------------------------------------------------------------
$groupTab = array();
$dbquery = $bts->SDDMObj->query("
SELECT a.group_id,a.group_title,a.group_name
FROM ".$SqlTableListObj->getSQLTableName('group')." a , ".$SqlTableListObj->getSQLTableName('group_website')." b
WHERE a.group_id = b.group_id
AND ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY a.group_title
;");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$i = $dbp['group_id'];
	$groupTab[$i]['id']		= $dbp['group_id'];
	$groupTab[$i]['nom']	= $dbp['group_name'];
	$groupTab[$i]['titre']	= $dbp['group_title'];
}

$ClassLoaderObj->provisionClass('Module');
$currentModuleObj = new Module();
switch ( $bts->RequestDataObj->getRequestDataSubEntry('moduleForm', 'mode') ) {
	case "edit":
		$currentModuleObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('moduleForm', 'selectionId'));
		$commandType = "update";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":	
		$currentModuleObj->setModule(
			array(
				"module_id"	=> "",
				"module_deco"					=>	1,
				"module_deco_nbr"				=>	1,
				"module_name"					=>	$bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
				"module_title"					=>	$bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
				"module_file"					=>	"",
				"module_desc"					=>	$bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
				// "module_group_allowed_to_see"	=>	2,
				// "module_group_allowed_to_use"	=>	2,
				"module_state"					=>	0,
				"module_position"				=>	1,
				"module_adm_control"			=>	0,
				"module_execution"				=>	0,
			)
		);
		$commandType = "add";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
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
."<input type='hidden' name='moduleForm[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('moduleForm', 'selectionId')."'>\r"
."<p>\r"
;



// --------------------------------------------------------------------------------------------
$T = array();

$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');



$T['Content']['1']['1']['2']['cont'] = $currentModuleObj->getModuleEntry('module_id');
switch ( $bts->RequestDataObj->getRequestDataSubEntry('moduleForm', 'mode') ) {
	case "edit":
		$T['Content']['1']['2']['2']['cont'] = $currentModuleObj->getModuleEntry('module_name');
		break;
	case "create":
		$T['Content']['1']['1']['2']['cont'] = "*";
		$T['Content']['1']['2']['2']['cont'] = "<input type='text' name='formTarget[name]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		break;
}
$T['Content']['1']['3']['2']['cont'] = "<input type='text' name='formParams[title]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['Content']['1']['4']['2']['cont'] = "<input type='text' name='formParams[desc]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_desc')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";


// --------------------------------------------------------------------------------------------

$T['Content']['2']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l1c1');
$T['Content']['2']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l2c1');
$T['Content']['2']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l3c1');
$T['Content']['2']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l4c1');
$T['Content']['2']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l5c1');
$T['Content']['2']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l6c1');
$T['Content']['2']['7']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l7c1');


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
$T['Content']['2']['1']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);

$tabYN = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('no'),		"db"=>"NO" ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('yes'),	"db"=>"YES" ),
);
$tabLine = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('offline'),	"db"=>"OFFLINE" ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('online'),		"db"=>"ONLINE" ),
		2	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('deleted'),	"db"=>"DELETED" ),
);
// $tabStatus = array(
// 		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('disabled'],	"db"=>"DISABLED" ),
// 		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('enabled'],	"db"=>"ENABLED" ),
// );


$tab = $tabYN;
$tab[$currentModuleObj->getModuleEntry('module_deco')]['s'] = " selected ";
$T['Content']['2']['2']['2']['cont'] = "<select name='formParams[deco]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tab as $A ) { $T['Content']['2']['2']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2']['2']['2']['cont'] .= "</select>\r";




$T['Content']['2']['3']['2']['cont'] = "<select name='formParams[deco_nbr]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$tab = array();
for ( $i =1; $i<=30; $i++ ) {
	$tab[$i] = array(
			"t"		=>	$i." - ".$ThemeDataObj->getThemeDataEntry($bts->StringFormatObj->getDecorationBlockName('theme_bloc_', $i, '_nom')) ,
			"db"	=>	$i,
			"s"		=>	($i == $currentModuleObj->getModuleEntry('deco_nbr')) ? "selected" : "",
	);
}


foreach ($tab as $A) { $T['Content']['2']['3']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['Content']['2']['3']['2']['cont'] .= "</select>\r";



$index_selection = array( $currentModuleObj->getModuleEntry('module_group_allowed_to_see') => " selected" );
$T['Content']['2']['4']['2']['cont'] = "<select name='formParams[group_who_can_see]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $groupTab as $A1 ) {
	$T['Content']['2']['4']['2']['cont'] .= "<option value='".$A1['nom']."' ".$index_selection[$A1['id']]."> ".$A1['titre']." </option>\r";
}
$T['Content']['2']['4']['2']['cont'] .= "</select>\r";



$T['Content']['2']['5']['2']['cont'] = "<select name='formParams[group_who_can_use]' class='".$Block."_t3 ".$Block."_form_1'>\r";
unset ($index_selection);
$index_selection = array( $currentModuleObj->getModuleEntry('module_group_allowed_to_use') => " selected" );
foreach ( $groupTab as $A1 ) {
	$T['Content']['2']['5']['2']['cont'] .= "<option value='".$A1['nom']."' ".$index_selection[$A1['id']]."> ".$A1['titre']." </option>\r";
}
$T['Content']['2']['5']['2']['cont'] .= "</select>\r";


$tab = $tabYN;
$T['Content']['2']['6']['2']['cont'] = "<select name='formParams[adm_control]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$A = $currentModuleObj->getModuleEntry('module_adm_control');
$tab[$A]['s'] = " selected ";
foreach ( $tab as $A ) { $T['Content']['2']['6']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2']['6']['2']['cont'] .= "</select>\r";


$tab = array (
		0	=>	array("t" => $bts->I18nTransObj->getI18nTransEntry('during'),	"db" => "DURING",),
		1	=>	array("t" => $bts->I18nTransObj->getI18nTransEntry('before'),	"db" => "BEFORE",),
		2	=>	array("t" => $bts->I18nTransObj->getI18nTransEntry('after'),		"db" => "AFTER",),
);

$T['Content']['2']['7']['2']['cont'] = "<select name='formParams[execution]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$tab[$currentModuleObj->getModuleEntry('module_execution')]['s'] = " selected ";
foreach ( $tab as $A1 ) {
	$T['Content']['2']['7']['2']['cont'] .= "<option value='".$A1['db']."' ".$A1['s']."> ".$A1['t']." </option>\r";
}
$T['Content']['2']['7']['2']['cont'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
$T['Content']['3']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l1c1');
$tab = $tabLine;
$T['Content']['3']['1']['2']['cont'] = "<select name='formParams[state]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$tab[$currentModuleObj->getModuleEntry('module_state')]['s'] = " selected ";
foreach ( $tab as $A ) { $T['Content']['3']['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['3']['1']['2']['cont'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 8, 3);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(4,2,2),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(7,2,2),
		3	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "moduleForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydr-Content-End*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
