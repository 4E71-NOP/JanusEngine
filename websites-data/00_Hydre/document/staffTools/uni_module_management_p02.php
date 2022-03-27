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

$bts->RequestDataObj->setRequestData('formGenericData',
		array(
			'mode'			=> 'edit',
// 			'mode'			=> 'create',
			'selectionId'	=>	322588793493951519,
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

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
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
			"t2l4c1"		=>	"Admin",
			"t2l5c1"		=>	"Mode d'exécution",
			"t2l6c1"		=>	"Permission",

			"t3l1c1"		=>	"Etat",
			
			"t1l1c2"		=>	"?",
			"t1l2c2"		=>	"Nouveau_module",
			"t1l3c2"		=>	"Deadline_",
			),
		"eng" => array(
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
			"t2l4c1"		=>	"Admin",
			"t2l5c1"		=>	"Execution mode",
			"t2l6c1"		=>	"Permission",
			
			"t3l1c1"		=>	"State",
			
			"t1l1c2"		=>	"?",
			"t1l2c2"		=>	"New_module",
			"t1l3c2"		=>	"Module_",
		),
	)
);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
// Table preparation
// --------------------------------------------------------------------------------------------
$groupTab = array();
$dbquery = $bts->SDDMObj->query("
SELECT grp.group_id, grp.group_title, grp.group_name 
FROM ".$SqlTableListObj->getSQLTableName('group')." grp , ".$SqlTableListObj->getSQLTableName('group_website')." grw 
WHERE grp.group_id = grw.fk_group_id 
AND grw.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY grp.group_title
;");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$i = $dbp['group_id'];
	$groupTab[$i]['id']		= $dbp['group_id'];
	$groupTab[$i]['nom']	= $dbp['group_name'];
	$groupTab[$i]['titre']	= $dbp['group_title'];
}

$ClassLoaderObj->provisionClass('Module');
$currentModuleObj = new Module();
switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
	case "edit":
		$currentModuleObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'selectionId'));
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
				"module_state"					=>	0,
				"module_position"				=>	1,
				"module_adm_control"			=>	0,
				"module_execution"				=>	0,
				"fk_perm_di"					=>	0,
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
<form ACTION='index.php?' method='post' name='formGenericData'>\r"
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminModuleManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value='module'>"
."<input type='hidden' name='formTarget1[name]'			value='".$currentModuleObj->getModuleEntry('module_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='formGenericData[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'selectionId')."'>\r"
."<p>\r"
;



// --------------------------------------------------------------------------------------------
$T = array();

$line=1;
$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['1']['2']['cont'] = $currentModuleObj->getModuleEntry('module_id');

$line++;
$T['Content']['1'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
	case "edit":
		$T['Content']['1'][$line]['2']['cont'] = $currentModuleObj->getModuleEntry('module_name');
		break;
	case "create":
		$T['Content']['1'][$line-1]['2']['cont'] = "*";
		$T['Content']['1'][$line]['2']['cont'] = "<input type='text' name='formTarget[name]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_title')."\" class='".$Block."_form_1'>\r";
		break;
}
$line++;


$T['Content']['1'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1'][$line]['2']['cont'] = "<input type='text' name='formParams[title]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_title')."\" class='".$Block."_form_1'>\r";
$line++;


$T['Content']['1'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1'][$line]['2']['cont'] = "<input type='text' name='formParams[desc]' size='35' maxlength='255' value=\"".$currentModuleObj->getModuleEntry('module_desc')."\" class='".$Block."_form_1'>\r";


// --------------------------------------------------------------------------------------------
$line=1;


$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "formGenericData",
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


$tabYN = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('no'),		"db"=>"NO" ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('yes'),		"db"=>"YES" ),
);
$tabLine = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('offline'),	"db"=>"OFFLINE" ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('online'),	"db"=>"ONLINE" ),
		2	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('deleted'),	"db"=>"DELETED" ),
);


$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l1c1');
$T['Content']['2'][$line]['2']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$line++;


$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l2c1');
$tab = $tabYN;
$tab[$currentModuleObj->getModuleEntry('module_deco')]['s'] = " selected ";
$T['Content']['2'][$line]['2']['cont'] = "<select name='formParams[deco]' class='".$Block."_form_1'>\r";
foreach ( $tab as $A ) { $T['Content']['2'][$line]['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2'][$line]['2']['cont'] .= "</select>\r";
$line++;


$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l3c1');
$T['Content']['2'][$line]['2']['cont'] = "<select name='formParams[deco_nbr]' class='".$Block."_form_1'>\r";
$tab = array();
for ( $i =1; $i<=30; $i++ ) {
	$tab[$i] = array(
			"t"		=>	$i." - ".$ThemeDataObj->getThemeDataEntry($bts->StringFormatObj->getDecorationBlockName('theme_block_', $i, '_name')) ,
			"db"	=>	$i,
			"s"		=>	($i == $currentModuleObj->getModuleEntry('deco_nbr')) ? "selected" : "",
	);
}
foreach ($tab as $A) { $T['Content']['2'][$line]['2']['cont'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['Content']['2'][$line]['2']['cont'] .= "</select>\r";
$line++;


$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l4c1');
$T['Content']['2'][$line]['2']['cont'] = "<select name='formParams[adm_control]' class='".$Block."_form_1'>\r";
$tab = $tabYN;
$A = $currentModuleObj->getModuleEntry('module_adm_control');
$tab[$A]['s'] = " selected ";
foreach ( $tab as $A ) { $T['Content']['2'][$line]['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2'][$line]['2']['cont'] .= "</select>\r";
$line++;


$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l5c1');
$T['Content']['2'][$line]['2']['cont'] = "<select name='formParams[execution]' class='".$Block."_form_1'>\r";
$tab = array (
		0	=>	array("t" => $bts->I18nTransObj->getI18nTransEntry('during'),	"db" => "DURING",),
		1	=>	array("t" => $bts->I18nTransObj->getI18nTransEntry('before'),	"db" => "BEFORE",),
		2	=>	array("t" => $bts->I18nTransObj->getI18nTransEntry('after'),	"db" => "AFTER",),
);
$tab[$currentModuleObj->getModuleEntry('module_execution')]['s'] = " selected ";
foreach ( $tab as $A1 ) {
	$T['Content']['2'][$line]['2']['cont'] .= "<option value='".$A1['db']."' ".$A1['s']."> ".$A1['t']." </option>\r";
}
$T['Content']['2'][$line]['2']['cont'] .= "</select>\r";
$line++;



$ClassLoaderObj->provisionClass('PermissionList');
$PermissionListObj = PermissionList::getInstance();
$PermissionListObj->makePermissionList();
$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l6c1');
$T['Content']['2'][$line]['2']['cont'] = "<select name='formParams[perm_name]' class='".$Block."_form_1'>\r";
$tabPerm = $PermissionListObj->getPermissionList();
$tab[$currentModuleObj->getModuleEntry('fk_perm_id')]['s'] = " selected ";
foreach ( $tabPerm as $A1 ) {
	$T['Content']['2'][$line]['2']['cont'] .= "<option value='".$A1['perm_name']."' ".$A1['s']."> ".$A1['perm_name']." </option>\r";
}
$line++;


// --------------------------------------------------------------------------------------------
$line=1;

$ClassLoaderObj->provisionClass('ModuleWebsite');
$ModuleWebsiteObj = new ModuleWebsite();
$ModuleWebsiteObj->getModuleDataFromDB( $currentModuleObj->getModuleEntry('module_id') );
$T['Content']['3'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l1c1');
$tab = $tabLine;
$T['Content']['3'][$line]['2']['cont'] = "<select name='formParams[state]' class='".$Block."_form_1'>\r";
$tab[$ModuleWebsiteObj->getModuleWebsiteEntry('module_state')]['s'] = " selected ";
foreach ( $tab as $A ) { $T['Content']['3'][$line]['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['3'][$line]['2']['cont'] .= "</select>\r";
$line++;


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 8, 3);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(4,2,2),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(8,2,2),
		3	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "formGenericData";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydr-Content-End*/

?>
