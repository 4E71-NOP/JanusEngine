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



$bts->LMObj->saveVectorSystemLogLevel();
$bts->LMObj->setVectorSystemLogLevel(LOGLEVEL_BREAKPOINT);

$bts->RequestDataObj->setRequestData('layoutForm',
		array(
				'selectionId'	=> 4097719268898732606,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminLayoutManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'create',
				'mode'			=> 'edit',
				// 'mode'			=> 'delete',
		)
);


/*Hydr-Content-Begin*/
$localisation = " / uni_layout_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_layout_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_layout_management_p02.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les présentations.",
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Titre",
			"t1l4c1"		=>	"Nom générique",
			"t1l5c1"		=>	"Description",
			"t1l6c1"		=>	"Fichier présentation",

			"tabTxt1"		=> "Informations",
			"raf1"			=> "Rien a afficher",
			"btn1"			=> "Filtrer",
			"pageSelectorQueryLike"		=>	"Filtrer avec",
			"pageSelectorDisplay"		=>	"Affichage",
			"pageSelectorNbrPerPage"	=>	"entrées par page",
			"pageSelectorBtnFilter"		=>	"Filtrer",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage layouts.",
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Name",
			"t1l3c1"		=>	"Title",
			"t1l4c1"		=>	"Generic name",
			"t1l5c1"		=>	"Description",
			"t1l6c1"		=>	"Layout file",

			"tabTxt1"		=> "Informations",
			"raf1"			=> "Nothing to display",
			"btn1"			=> "Filter",
			"pageSelectorQueryLike"		=>	"Filter with",
			"pageSelectorDisplay"		=>	"Display",
			"pageSelectorNbrPerPage"	=>	"entries per page",
			"pageSelectorBtnFilter"		=>	"Filter",
		)
	)
);


// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();
$tabLayoutFile	= $MenuSelectTableObj->getLayoutFileList();

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Layout');
$currentLayoutObj = new Layout();
switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentLayoutObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('layoutForm', 'selectionId'));
		
		$T['Content']['1']['1']['2']['cont'] = $currentLayoutObj->getLayoutEntry('layout_id');
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[name]',	$currentLayoutObj->getLayoutEntry('layout_name') );
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		
		$d = $bts->TimeObj->getMicrotime();
		$e = $bts->TimeObj->timestampToDate($d);

		$T['Content']['1']['1']['2']['cont'] = "***";
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[name]',	"NewArticle".time() );
		$processStep = "Create";
		$processTarget = "edit";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		break;
}

// --------------------------------------------------------------------------------------------


$Content .= 
$bts->RenderFormObj->renderformHeader('layoutForm')
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard".$processStep )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"AdminArticleManagementP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"layyout" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$currentLayoutObj->getLayoutEntry('layout_name') )
."<p>\r"
;


$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');
$T['Content']['1']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l6c1');

$T['Content']['1']['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',			$currentLayoutObj->getLayoutEntry('layout_title'));
$T['Content']['1']['4']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[generic_name]',	$currentLayoutObj->getLayoutEntry('layout_generic_name') );
$T['Content']['1']['5']['2']['cont'] = "<textarea name='formParams1[generic_name]' style='min-width:384px; min-height:32px;width=100%; height:100%;'>".$currentLayoutObj->getLayoutEntry('layout_desc')."</textarea>\r";


$ClassLoaderObj = ClassLoader::getInstance ();

// LayoutFile
$ClassLoaderObj->provisionClass ( 'LayoutFile' );	// Make sure we got it loaded
$layoutFileTmpObj = new LayoutFile();
$layoutFileTmpObj->getDataFromDB($currentLayoutObj->getLayoutEntry('fk_layout_file_id'));
$T['Content']['1']['6']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[layout_file_name]',
	'defaultSelected' => $layoutFileTmpObj->getLayoutFileEntry('layout_file_name'),
	'options' => $tabLayoutFile,
));

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 1);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(6,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "articleForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);

/*Hydr-Content-End*/
$bts->LMObj->restoreVectorSystemLogLevel();

?>
