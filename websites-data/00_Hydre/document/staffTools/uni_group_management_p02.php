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

$bts->RequestDataObj->setRequestData('groupForm',
		array(
				'selectionId'	=>	2430833223629620803,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminGroupManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				// 'mode'			=> 'edit',
				'mode'			=> 'create',
				'mode'			=> 'delete',
		)
);
		
/*Hydr-Content-Begin*/
$localisation = " / uni_group_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_group_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_group_management_p02.php");


$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"anonymous"		=>	"Anonyme",
			"reader"		=>	"Lecteur",
			"staff"			=>	"Staff",
			"seniorStaff"	=>	"Staff Sénior",
			
			"invite1"		=> "Cette partie va vous permettre de gérer le groupe.",
			"invite2"		=> "Cette partie va vous permettre de créer un groupe.",
			"tabTxt1"		=> "Informations",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Titre",
			"t1l4c1"		=>	"Tag",
			"t1l5c1"		=>	"Description",
			"t1l6c1"		=>	"Icone",
			
			"t1l2c2"		=>	"Nouveau_groupe ",
		),
		"eng" => array(
			"anonymous"		=>	"Anonymous",
			"reader"		=>	"Reader",
			"staff"			=>	"Staff",
			"seniorStaff"	=>	"Senior Staff",
			
			"invite1"		=> "This part will allow you to manage this group.",
			"invite2"		=> "This part will allow you to create a group.",
			"tabTxt1"		=> "Informations",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Title",
			"t1l4c1"		=>	"Tag",
			"t1l5c1"		=>	"Description",
			"t1l6c1"		=>	"Icon file",
			
			"t1l2c2"		=>	"New group ",
		)
	)
);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Group');
$currentGroupObj = new Group();

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('FormBuilder');
// $formBuilderObj = FormBuilder::getInstance();

// --------------------------------------------------------------------------------------------
$T = array();
switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
	case "delete":
	case "edit":
		$T['Content']['1']['2']['2']['cont'] = $currentGroupObj->getGroupEntry('group_name');
		$currentGroupObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('groupForm', 'selectionId'));
		$commandType = "update";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$arrTmp = array_merge (
			$currentGroupObj->getGroup(),
			array(
			"group_id"		=> "*",
			"group_name"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2') . "name " . time(),
			"group_title"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2') . "title " . time(),
			"group_desc"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2') . "desc " . time(),
			)
		);
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[name]',	$currentGroupObj->getGroupEntry('group_name'));
		$currentGroupObj->setGroup($arrTmp);
		$commandType = "add";
		$processStep = "Create";
		$processTarget = "edit";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= 
$bts->RenderFormObj->renderformHeader('groupForm')
.$bts->RenderFormObj->renderHiddenInput(	"formSubmitted"	,				"1")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"AdminGroupManagementP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"group" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$currentGroupObj->getGroupEntry('group_name') )
.$bts->RenderFormObj->renderHiddenInput(	"groupForm[selectionId]"	,	$currentGroupObj->getGroupEntry('group_id') )
."<p>\r"
;

// --------------------------------------------------------------------------------------------
$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');
$T['Content']['1']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l6c1');

$T['Content']['1']['1']['2']['cont'] = $currentGroupObj->getGroupEntry('group_id');
$T['Content']['1']['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',	$currentGroupObj->getGroupEntry('group_title'));

$Tab = $currentGroupObj->getMenuOptionArray();

$T['Content']['1']['4']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[tag]',
	'defaultSelected' => $currentGroupObj->getGroupEntry('group_tag'),
	'options' => $Tab['tag'],
));

$T['Content']['1']['5']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[desc]',	$currentGroupObj->getGroupEntry('group_desc'));


$FileSelectorConfig = array(
	"width"				=> 80,	//in %
	"height"			=> 50,	//in %
	"formName"			=> "groupForm",
	"formTargetId"		=> "formParams[file]",
	"formInputSize"		=> 25 ,
	"formInputVal"		=> $currentGroupObj->getGroupEntry('group_file'),
	"path"				=> "/websites-data/".$WebSiteObj->getWebSiteEntry('ws_name')."/data/images/avatars/",
	"restrictTo"		=> "/websites-data/".$WebSiteObj->getWebSiteEntry('ws_name')."/data/images/avatars/",
	"strRemove"			=> "",
	// "strRemove"			=> "/\.*\w*\//",
	"strAdd"			=> "",
	"selectionMode"		=> "file",
	"displayType"		=> "imageMosaic",
	"buttonId"			=> "t6l2c2",
	"case"				=> 3,
	"update"			=> 1,
	"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['Content']['1']['6']['2']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 8);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(6,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "groupForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydr-Content-End*/

?>
