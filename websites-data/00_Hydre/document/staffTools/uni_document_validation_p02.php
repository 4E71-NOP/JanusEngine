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

$bts->RequestDataObj->setRequestData('documentForm',
		array(
				'selectionId'	=> 1868244585737455932,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
	array(
		'origin'		=> 'AdminDashboard',
		'section'		=> 'AdminDocumentValidationP02',
		'creation'		=> 'on',
		'modification'	=> 'on',
		'deletion'		=> 'on',
		'mode'			=> 'edit',
		// 'mode'			=> 'create',
//		'mode'			=> 'delete',
	)
);

/*Hydr-Content-Begin*/
$localisation = " / uni_document_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_document_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_document_management_p02.php");


$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les documents.",
			"invite2"		=> "Cette partie va vous permettre de créer un document.",
			"tabTxt1"		=> "Informations",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Type",
			"t1l4c1"		=>	"Modifiable par un autre site",
			"t1l5c1"		=>	"Vérifié par",
			
			"type0"			=>	"HTML",
			"type1"			=>	"PHP",
			"type2"			=>	"Mixé",
			"goModif"		=>	"Modifier le contenu de ce document.",
		),
		"eng" => array(
			"no"			=>	"No",
			"yes"			=>	"Yes",
			"offline"		=> "Offline",
			"online"		=> "Online",
			
			"invite1"		=> "This part will allow you to manage documents.",
			"invite2"		=> "This part will allow you to create a document.",
			"tabTxt1"		=> "Informations",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Type",
			"t1l4c1"		=>	"Update-able by another site",
			"t1l5c1"		=>	"Checked by",
			
			"type0"			=>	"HTML",
			"type1"			=>	"PHP",
			"type2"			=>	"Mixed",
			
			"goModif"		=>	"Modify the document content.",
		)
	)
);


// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();

$tabUser = $MenuSelectTableObj->getUserList();

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Document');
$currentDocumentObj = new Document();
switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentDocumentObj->getDataFromDBNoOriginCheck($bts->RequestDataObj->getRequestDataSubEntry('documentForm', 'selectionId'));
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentDocumentObj->setDocument(
				array (
					"docu_id"				=>	"",
					"docu_name"				=>	"NewDocument",
					"docu_type"				=>	0,
					"docu_origin"			=>	$WebSiteObj->getWebSiteEntry('ws_id'),
					"docu_creator"			=>	$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_id'),
					"docu_creation_date"	=>	time(),
					"docu_validation"		=>	0,
					"docu_validator"		=>	"",
					"docu_validation_date"	=>	0,
					"docu_cont"				=>	"",
				)
		);
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= 
$bts->RenderFormObj->renderformHeader('documentForm')
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard".$processStep )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"AdminDeadlineDocumentP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"document" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$currentDocumentObj->getDocumentEntry('docu_name') )
."<p>\r"
;

$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');

switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
	case "edit":
		$T['Content']['1']['1']['2']['cont'] = $currentDocumentObj->getDocumentEntry('docu_id');
		$T['Content']['1']['2']['2']['cont'] = $currentDocumentObj->getDocumentEntry('docu_name');
		break;
	case "create":
		$T['Content']['1']['1']['2']['cont'] = "***";
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[name]',	"NewDocument".time());;
		break;
}

$documentMenuOption = $currentDocumentObj->getMenuOptionArray();

$T['Content']['1']['3']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams[type]',
	'defaultSelected' => $currentDocumentObj->getDocumentEntry('docu_type'),
	'options' => $documentMenuOption['type'],
));

$T['Content']['1']['4']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams[modification]',
	'defaultSelected' => $currentDocumentObj->getDocumentEntry('part_modification'),
	'options' => $documentMenuOption['yesno'],
));

$T['Content']['1']['5']['2']['cont'] = $tabUser[$currentDocumentObj->getDocumentEntry('docu_validator')]['t'];


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 6, 1);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(5,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "documentForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydr-Content-End*/

?>
