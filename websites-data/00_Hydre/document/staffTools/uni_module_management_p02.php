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
$bts->RequestDataObj->setRequestData('moduleForm',
		array(
				'selectionId'	=>	520779038210083227,
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
				'mode'			=> 'create',
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
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();
$tabDecoNbr			= $MenuSelectTableObj->getDecorationList();

// --------------------------------------------------------------------------------------------
// Table preparation
// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Module');
$currentModuleObj = new Module();
switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
	case "edit":
		$currentModuleObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('moduleForm', 'selectionId'));
		$commandType = "update";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		$T['Content']['1']['2']['2']['cont'] = $currentModuleObj->getModuleEntry('module_name');
		break;
	case "create":	
		$T['Content']['1']['1']['2']['cont'] = "*";
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('keywordForm[name]',	$currentModuleObj->getModuleEntry('module_name'));
		$commandType = "add";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= 
$bts->RenderFormObj->renderformHeader('ModuleForm')
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard".$processStep )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"AdminModuleManagementP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"module" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$currentModuleObj->getModuleEntry('module_name') )
."<p>\r"
;

// --------------------------------------------------------------------------------------------
$line = 1;
$T['Content']['1'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1'][$line]['2']['cont'] = $currentModuleObj->getModuleEntry('module_id');

$line++;
$T['Content']['1'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');

$line++;
$T['Content']['1'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1'][$line]['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',	$currentModuleObj->getModuleEntry('module_title'));

$line++;
$T['Content']['1'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1'][$line]['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[desc]',	$currentModuleObj->getModuleEntry('module_desc'));
// --------------------------------------------------------------------------------------------
$line = 1;

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "formGenericData",
		"formTargetId"		=> "formParams[module_file]",
		"formInputSize"		=> 40 ,
		"formInputVal"		=> $currentModuleObj->getModuleEntry('module_file'),
		"path"				=> "modules",
		"restrictTo"		=> "modules",
		"strRemove"			=> "",
		"strAdd"			=> "../",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "buttonModuleSelection",
		"case"				=> 1,
//		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );

$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l1c1');
$T['Content']['2'][$line]['2']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);

$line++;
$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l2c1');
$tab = $currentModuleObj->getMenuOptionArray();
$T['Content']['2'][$line]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[deco]',
	'defaultSelected' => $currentModuleObj->getModuleEntry('module_deco'),
	'options' => $tab['yesno'],
));

$line++;
$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l3c1');
$T['Content']['2'][$line]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[deco_nbr]',
	'defaultSelected' => $currentModuleObj->getModuleEntry('deco_nbr'),
	'options' => $tabDecoNbr,
));

$line++;
$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l4c1');
$T['Content']['2'][$line]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[adm_control]',
	'defaultSelected' => $currentModuleObj->getModuleEntry('module_adm_control'),
	'options' => $tab['yesno'],
));

$line++;
$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l5c1');
$T['Content']['2'][$line]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[execution]',
	'defaultSelected' => $currentModuleObj->getModuleEntry('module_execution'),
	'options' => $tab['execution'],
));

$line++;
$ClassLoaderObj->provisionClass('PermissionList');
$PermissionListObj = PermissionList::getInstance();
$PermissionListObj->makePermissionList();
$tabPerm = $PermissionListObj->getPermissionList();
$tabPermSelect = array();
foreach ( $tabPerm as $A ) {
	$tabPermSelect[$A['perm_id']]['t'] = $tabPermSelect[$A['perm_id']]['db'] = $A['perm_name'];
	$tabPermSelect[$A['perm_id']]['s'] = '';
}
$T['Content']['2'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l6c1');
$T['Content']['2'][$line]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[perm_name]',
	'defaultSelected' => $currentModuleObj->getModuleEntry('fk_perm_id'),
	'options' => $tabPermSelect,
));

$line++;


// --------------------------------------------------------------------------------------------
$line=1;

$ClassLoaderObj->provisionClass('ModuleWebsite');
$ModuleWebsiteObj = new ModuleWebsite();
$ModuleWebsiteObj->getModuleDataFromDB( $currentModuleObj->getModuleEntry('module_id') );
$T['Content']['3'][$line]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l1c1');
$T['Content']['3'][$line]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[state]',
	'defaultSelected' => $ModuleWebsiteObj->getModuleWebsiteEntry('module_state'),
	'options' => $tab['state'],
));

// $line++;

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
