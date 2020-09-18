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

$RequestDataObj->setRequestData('groupForm',
		array(
				'selectionId'	=>	30,
		)
);
$RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminGroupManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);
		
/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_groups_p02";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_groups_p02");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_groups_p02");

switch ($l) {
	case "fra":
// 		$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "Merging i18n data. Language selection=".$l);
		$I18nObj->apply(array(
		"anonymous"		=>	"Anonyme",
		"reader"		=>	"Lecteur",
		"staff"			=>	"Staff",
		"seniorStaff"	=>	"Staff Sénior",
		
		"invite1"		=> "Cette partie va vous permettre de gérer le group.",
		"invite2"		=> "Cette partie va vous permettre de créer un group.",
		"tabTxt1"		=> "Informations",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Nom",
		"t1l3c1"		=>	"Titre",
		"t1l4c1"		=>	"Tag",
		"t1l5c1"		=>	"Description",
		"t1l6c1"		=>	"Fichier",
		
		"t1l2c2"		=>	"New_group",
		));
		break;
		
	case "eng":
		$I18nObj->apply(array(
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
		"t1l6c1"		=>	"File",
		
		"t1l2c2"		=>	"New_group",
		));
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
// Table preparation
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Group');
$currentGroupObj = new Group();
switch ( $RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
	case "delete":
	case "edit":
		$currentGroupObj->getGroupDataFromDB($RequestDataObj->getRequestDataSubEntry('groupForm', 'selectionId'));
		$t1l2c2 = $currentGroupObj->getGroupEntry('group_name');
		$t1l3c2 = "<input type='text' name='groupForm[title]' size='45' maxlength='255' value=\"".$currentGroupObj->getGroupEntry('group_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$commandType = "update";
		$Content .= "<p>".$I18nObj->getI18nEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$currentGroupObj->setGroup(
			array(
			"group_id"		=> "*",
			"group_tag"	=> 0,
			"group_name"	=> $I18nObj->getI18nEntry('t1l2c2'),
			"group_title"	=> $I18nObj->getI18nEntry('t1l2c2'),
			"group_desc"	=> $I18nObj->getI18nEntry('t1l2c2'),
			)
		);
		$t1l2c2 = "<input type='text' name='groupForm[name]' size='45' maxlength='255' value=\"".$I18nObj->getI18nEntry('t1l2c2')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$t1l3c2 = "<input type='text' name='groupForm[title]' size='45' maxlength='255' value=\"".$I18nObj->getI18nEntry('t1l2c2')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$commandType = "add";
		$processStep = "Create";
		$processTarget = "edit";
		$Content .= "<p>".$I18nObj->getI18nEntry('invite2')."</p>\r";
		break;
}


$Content .= "
<form ACTION='index.php?' method='post' name='groupForm'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminGroupManagementP02'>\r"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>\r"
."<input type='hidden' name='formEntity1'				value='group'>\r"
."<input type='hidden' name='formTarget1[name]'			value='".$currentGroupObj->getGroupEntry('group_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='groupForm[selectionId]'	value='".$RequestDataObj->getRequestDataSubEntry('groupForm', 'selectionId')."'>\r"
."<p>\r"
;

// --------------------------------------------------------------------------------------------
$T = array();

$T['AD']['1']['1']['1']['cont'] = $I18nObj->getI18nEntry('t1l1c1');
$T['AD']['1']['2']['1']['cont'] = $I18nObj->getI18nEntry('t1l2c1');
$T['AD']['1']['3']['1']['cont'] = $I18nObj->getI18nEntry('t1l3c1');
$T['AD']['1']['4']['1']['cont'] = $I18nObj->getI18nEntry('t1l4c1');
$T['AD']['1']['5']['1']['cont'] = $I18nObj->getI18nEntry('t1l5c1');
$T['AD']['1']['6']['1']['cont'] = $I18nObj->getI18nEntry('t1l6c1');

// $tabYN = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nEntry('no'],		"db"=>"NO" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nEntry('yes'],	"db"=>"YES" ),
// );
// $tabLine = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nEntry('offline'],	"db"=>"OFFLINE" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nEntry('online'],		"db"=>"ONLINE" ),
// 		2	=> array ( "t"=>$I18nObj->getI18nEntry('deleted'],	"db"=>"DELETED" ),
// );


$T['AD']['1']['1']['2']['cont'] = $currentGroupObj->getGroupEntry('group_id');
$T['AD']['1']['2']['2']['cont'] = $t1l2c2;
$T['AD']['1']['3']['2']['cont'] = $t1l3c2;

$tabStateDealine = array(
		0	=> array ( "t"=>$I18nObj->getI18nEntry('anonymous'),		"db"=>"ANONYMOUS" ),
		1	=> array ( "t"=>$I18nObj->getI18nEntry('reader'),			"db"=>"READER" ),
		2	=> array ( "t"=>$I18nObj->getI18nEntry('staff'),			"db"=>"STAFF" ),
		3	=> array ( "t"=>$I18nObj->getI18nEntry('seniorStaff'),	"db"=>"SENIOR_STAFF" ),
);
$tab = $tabStateDealine;

switch ( $RequestDataObj->getRequestDataSubEntry('groupForm', 'mode') ) {
	case "edit":	$tab[$currentGroupObj->getGroupEntry('group_tag')]['s'] = " selected";	break;
	case "create":	$tab[1]['s'] = " selected";	break;
}

$T['AD']['1']['4']['2']['cont'] = "<select name ='formParams[tag]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tab as $A ) { $T['AD']['1']['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['4']['2']['cont'] .= "</select>\r";

$T['AD']['1']['5']['2']['cont'] = "<input type='text' name='formParams[desc]' size='45' maxlength='255' value=\"".$currentGroupObj->getGroupEntry('group_desc')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),
		array(
				"width"				=> 80,	//in %
				"height"			=> 50,	//in %
				"formName"			=> "groupForm",
				"formTargetId"		=> "inputFile",
				"path"				=> "websites-data/".$WebSiteObj->getWebSiteEntry('ws_name')."/data/images/avatars/",
				"selectionMode"		=> "file",
		)
);
$infos['IconSelectFile'] = array(
		"case"				=> 1 ,
		"formName"			=> "groupForm",
		"formInputId"		=> "inputFile",
		"formInputSize"		=> 40 ,
		"formInputVal"		=> $currentGroupObj->getGroupEntry('group_file'),
		"path"				=> "websites-data/".$WebSiteObj->getWebSiteEntry('ws_name')."/data/images/avatars/",
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD']['1']['6']['2']['cont'] = $InteractiveElementsObj->renderIconSelectFile($infos);


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 8);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig(5,2,2),
);
$Content .= $RenderTablesObj->render($infos, $T);


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
// $T['tab_infos']['EnableTabs']		= 1;
// $T['tab_infos']['NbrOfTabs']		= 1;
// $T['tab_infos']['TabBehavior']		= 0;
// $T['tab_infos']['RenderMode']		= 1;
// $T['tab_infos']['HighLightType']	= 0;
// $T['tab_infos']['Height']			= floor( $infos['fontSizeMin'] + ($infos['fontCoef']*3) +10 ) * 6; //T3 is default; total padding = 10; nbr line +1
// $T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
// $T['tab_infos']['GroupName']		= "list";
// $T['tab_infos']['CellName']			= "grp";
// $T['tab_infos']['DocumentName']		= "doc";
// $T['tab_infos']['cell_1_txt']		= $I18nObj->getI18nEntry('cell_1_txt');
// $T['tab_infos']['cell_2_txt']		= $I18nObj->getI18nEntry('cell_2_txt');
// $T['tab_infos']['cell_3_txt']		= $I18nObj->getI18nEntry('cell_3_txt');

// $T['ADC']['onglet']['1']['nbr_ligne']	= 5;	$T['ADC']['onglet']['1']['nbr_cellule']	= 2;	$T['ADC']['onglet']['1']['legende']		= 2;

// $config = array(
// 		"mode" => 1,
// 		"affiche_module_mode" => "normal",
// 		"module_z_index" => 2,
// 		"block"		=> $infos['block'],
// 		"blockG"	=> $infos['block']."G",
// 		"blockT"	=> $infos['block']."T",
// 		"deco_type"	=> 50,
// 		"module"	=> $infos['module'],
// );

// $Content .= $RenderTablesObj->render($config, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "groupForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
