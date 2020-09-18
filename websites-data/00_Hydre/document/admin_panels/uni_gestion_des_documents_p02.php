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

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

$RequestDataObj->setRequestData('documentForm',
		array(
				'mode'			=> 'edit',
// 	 			'mode'			=> 'create',
				'selectionId'	=> 105,
		)
);
$RequestDataObj->setRequestData('formGenericData',
	array(
		'origin'			=> 'AdminDashboard',
		'section'			=> 'AdminDocumentManagementP02',
		'creation'		=> 'on',
		'modification'	=> 'on',
		'deletion'		=> 'on',
		'mode'			=> 'edit',
//		'mode'			=> 'create',
//		'mode'			=> 'delete',
	)
);

/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_documents_p02";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_documents_p02");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_documents_p02");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les documents.",
		"invite2"		=> "Cette partie va vous permettre de créer un document.",
		"tabTxt1"		=> "Informations",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Nom",
		"t1l3c1"		=>	"Type",
		"t1l4c1"		=>	"Modifiable par un autre site",
		"t1l5c1"		=>	"Vérifié par",
		
		"type0"			=>	"Hydr Code",
		"type1"			=>	"No code",
		"type2"			=>	"PHP",
		"type3"			=>	"Mixed",
		"goModif"		=>	"Modifier le contenu de ce document.",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
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
		
		"type0"			=>	"Hydr Code",
		"type1"			=>	"No code",
		"type2"			=>	"PHP",
		"type3"			=>	"Mixed",
		
		"goModif"		=>	"Modify the document content.",
		));
		break;
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();

$tabUser = $MenuSelectTableObj->getUserList();

// --------------------------------------------------------------------------------------------
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Document');
$currentDocumentObj = new Document();
switch ($RequestDataObj->getRequestDataSubEntry('documentForm', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentDocumentObj->getDocumentDataFromDB($RequestDataObj->getRequestDataSubEntry('documentForm', 'selectionId'));
		
		$T['AD']['1']['2']['2']['cont'] = $currentDocumentObj->getDocumentEntry('docu_nom');
		$Content .= "<p>".$I18nObj->getI18nEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		// 		$d = date();
		$currentDocumentObj->setDocument(
				array (
					"docu_id"				=>	"",
					"docu_nom"				=>	"NewDocument",
					"docu_type"				=>	0,
					"docu_origine"			=>	$WebSiteObj->getWebSiteEntry('ws_id'),
					"docu_createur"			=>	$UserObj->getUserEntry('user_id'),
					"docu_creation_date"	=>	date(),
					"docu_correction"		=>	0,
					"docu_correcteur"		=>	"",
					"docu_correction_date"	=>	0,
					"docu_cont"				=>	"",
				)
		);
		$T['AD']['1']['2']['2']['cont'] = "<input type='text' name='formParams[name]' size='35' maxlength='255' value=\"NewCategory".date()."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$Content .= "<p>".$I18nObj->getI18nEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}


// --------------------------------------------------------------------------------------------
$Content .= "
<form ACTION='index.php?' method='post' name='documentForm'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminDocumentManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value='document'>"
."<input type='hidden' name='formTarget1[name]'			value='".$currentDocumentObj->getDocumentEntry('cate_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='documentForm[selectionId]'	value='".$RequestDataObj->getRequestDataSubEntry('documentForm', 'selectionId')."'>\r"
."<p>\r"
;


$T['AD']['1']['1']['1']['cont'] = $I18nObj->getI18nEntry('t1l1c1');
$T['AD']['1']['2']['1']['cont'] = $I18nObj->getI18nEntry('t1l2c1');
$T['AD']['1']['3']['1']['cont'] = $I18nObj->getI18nEntry('t1l3c1');
$T['AD']['1']['4']['1']['cont'] = $I18nObj->getI18nEntry('t1l4c1');
$T['AD']['1']['5']['1']['cont'] = $I18nObj->getI18nEntry('t1l5c1');


$T['AD']['1']['1']['2']['cont'] = $currentDocumentObj->getDocumentEntry('docu_id');
$T['AD']['1']['2']['2']['cont'] = $currentDocumentObj->getDocumentEntry('docu_nom');


$tabType = array(
		0 =>	array ( "t" => $I18nObj->getI18nEntry('type0'),	"db" => "WMCODE"),
		1 =>	array ( "t" => $I18nObj->getI18nEntry('type1'),	"db" => "NOCODE"),
		2 =>	array ( "t" => $I18nObj->getI18nEntry('type2'),	"db" => "PHP"),
		3 =>	array ( "t" => $I18nObj->getI18nEntry('type3'),	"db" => "MIXED"),
);
$tabType[$currentDocumentObj->getDocumentEntry('docu_type')]['s'] = " selected ";
$T['AD']['1']['3']['2']['cont'] = "<select name='formParams[type]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabType as $A ) { $T['AD']['1']['3']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['3']['2']['cont'] .= "</select>\r";


$tabYN = array(
		0	=> array ( "t"=>$I18nObj->getI18nEntry('no'),		"db"=>"NO" ),
		1	=> array ( "t"=>$I18nObj->getI18nEntry('yes'),	"db"=>"YES" ),
);
$tab = $tabYN;
$tab[$currentDocumentObj->getDocumentEntry('part_modification')]['s'] = " selected ";
$T['AD']['1']['4']['2']['cont'] = "<select name='formParams[modification]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tab as $A ) { $T['AD']['1']['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['4']['2']['cont'] .= "</select>\r";

$T['AD']['1']['5']['2']['cont'] = $tabUser[$currentDocumentObj->getDocumentEntry('docu_correcteur')]['t'];



// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 6, 1);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig(5,2,2),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "documentForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
