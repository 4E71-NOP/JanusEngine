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

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

$bts->RequestDataObj->setRequestData('documentForm',
		array(
				'mode'			=> 'edit',
// 	 			'mode'			=> 'create',
				'selectionId'	=> 105,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
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

/*Hydr-Content-Begin*/
$localisation = " / uni_document_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_document_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_document_management_p02.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
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
		$bts->I18nTransObj->apply(array(
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
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Document');
$currentDocumentObj = new Document();
switch ($bts->RequestDataObj->getRequestDataSubEntry('documentForm', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentDocumentObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('documentForm', 'selectionId'));
		
		$T['AD']['1']['2']['2']['cont'] = $currentDocumentObj->getDocumentEntry('docu_name');
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		// 		$d = date();
		$currentDocumentObj->setDocument(
				array (
					"docu_id"				=>	"",
					"docu_name"				=>	"NewDocument",
					"docu_type"				=>	0,
					"docu_origin"			=>	$WebSiteObj->getWebSiteEntry('ws_id'),
					"docu_creator"			=>	$UserObj->getUserEntry('user_id'),
					"docu_creation_date"	=>	date(),
					"docu_examination"		=>	0,
					"docu_examiner"		=>	"",
					"docu_examination_date"	=>	0,
					"docu_cont"				=>	"",
				)
		);
		$T['AD']['1']['2']['2']['cont'] = "<input type='text' name='formParams[name]' size='35' maxlength='255' value=\"NewCategory".date()."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
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
."<input type='hidden' name='documentForm[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('documentForm', 'selectionId')."'>\r"
."<p>\r"
;


$T['AD']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['AD']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['AD']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['AD']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['AD']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');


$T['AD']['1']['1']['2']['cont'] = $currentDocumentObj->getDocumentEntry('docu_id');
$T['AD']['1']['2']['2']['cont'] = $currentDocumentObj->getDocumentEntry('docu_name');


$tabType = array(
		0 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('type0'),	"db" => "WMCODE"),
		1 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('type1'),	"db" => "NOCODE"),
		2 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('type2'),	"db" => "PHP"),
		3 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('type3'),	"db" => "MIXED"),
);
$tabType[$currentDocumentObj->getDocumentEntry('docu_type')]['s'] = " selected ";
$T['AD']['1']['3']['2']['cont'] = "<select name='formParams[type]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabType as $A ) { $T['AD']['1']['3']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['3']['2']['cont'] .= "</select>\r";


$tabYN = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('no'),		"db"=>"NO" ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('yes'),	"db"=>"YES" ),
);
$tab = $tabYN;
$tab[$currentDocumentObj->getDocumentEntry('part_modification')]['s'] = " selected ";
$T['AD']['1']['4']['2']['cont'] = "<select name='formParams[modification]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tab as $A ) { $T['AD']['1']['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['4']['2']['cont'] .= "</select>\r";

$T['AD']['1']['5']['2']['cont'] = $tabUser[$currentDocumentObj->getDocumentEntry('docu_examiner')]['t'];



// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 6, 1);
$T['ADC']['onglet'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(5,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "documentForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydr-Content-End*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
