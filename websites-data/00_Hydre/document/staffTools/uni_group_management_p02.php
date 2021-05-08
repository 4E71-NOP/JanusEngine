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

$bts->RequestDataObj->setRequestData('groupForm',
		array(
				'selectionId'	=>	30,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
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
		
/*Hydr-Content-Begin*/
$localisation = " / uni_group_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_group_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_group_management_p02.php");

switch ($l) {
	case "fra":
// 		$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Merging i18n data. Language selection=".$l);
		$bts->I18nTransObj->apply(array(
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
		$bts->I18nTransObj->apply(array(
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
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
// Table preparation
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Group');
$currentGroupObj = new Group();
switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
	case "delete":
	case "edit":
		$currentGroupObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('groupForm', 'selectionId'));
		$t1l2c2 = $currentGroupObj->getGroupEntry('group_name');
		$t1l3c2 = "<input type='text' name='groupForm[title]' size='45' maxlength='255' value=\"".$currentGroupObj->getGroupEntry('group_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$commandType = "update";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$currentGroupObj->setGroup(
			array(
			"group_id"		=> "*",
			"group_tag"	=> 0,
			"group_name"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
			"group_title"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
			"group_desc"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
			)
		);
		$t1l2c2 = "<input type='text' name='groupForm[name]' size='45' maxlength='255' value=\"".$bts->I18nTransObj->getI18nTransEntry('t1l2c2')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$t1l3c2 = "<input type='text' name='groupForm[title]' size='45' maxlength='255' value=\"".$bts->I18nTransObj->getI18nTransEntry('t1l2c2')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$commandType = "add";
		$processStep = "Create";
		$processTarget = "edit";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
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
."<input type='hidden' name='groupForm[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('groupForm', 'selectionId')."'>\r"
."<p>\r"
;

// --------------------------------------------------------------------------------------------
$T = array();

$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');
$T['Content']['1']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l6c1');

// $tabYN = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nTransEntry('no'],		"db"=>"NO" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nTransEntry('yes'],	"db"=>"YES" ),
// );
// $tabLine = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nTransEntry('offline'],	"db"=>"OFFLINE" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nTransEntry('online'],		"db"=>"ONLINE" ),
// 		2	=> array ( "t"=>$I18nObj->getI18nTransEntry('deleted'],	"db"=>"DELETED" ),
// );


$T['Content']['1']['1']['2']['cont'] = $currentGroupObj->getGroupEntry('group_id');
$T['Content']['1']['2']['2']['cont'] = $t1l2c2;
$T['Content']['1']['3']['2']['cont'] = $t1l3c2;

$tabStateDealine = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('anonymous'),		"db"=>"ANONYMOUS" ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('reader'),			"db"=>"READER" ),
		2	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('staff'),			"db"=>"STAFF" ),
		3	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('seniorStaff'),	"db"=>"SENIOR_STAFF" ),
);
$tab = $tabStateDealine;

switch ( $bts->RequestDataObj->getRequestDataSubEntry('groupForm', 'mode') ) {
	case "edit":	$tab[$currentGroupObj->getGroupEntry('group_tag')]['s'] = " selected";	break;
	case "create":	$tab[1]['s'] = " selected";	break;
}

$T['Content']['1']['4']['2']['cont'] = "<select name ='formParams[tag]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tab as $A ) { $T['Content']['1']['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['4']['2']['cont'] .= "</select>\r";

$T['Content']['1']['5']['2']['cont'] = "<input type='text' name='formParams[desc]' size='45' maxlength='255' value=\"".$currentGroupObj->getGroupEntry('group_desc')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

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
$T['Content']['1']['6']['2']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 8);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(5,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
// $T['ContentInfos']['EnableTabs']		= 1;
// $T['ContentInfos']['NbrOfTabs']		= 1;
// $T['ContentInfos']['TabBehavior']		= 0;
// $T['ContentInfos']['RenderMode']		= 1;
// $T['ContentInfos']['HighLightType']	= 0;
// $T['ContentInfos']['Height']			= floor( $infos['fontSizeMin'] + ($infos['fontCoef']*3) +10 ) * 6; //T3 is default; total padding = 10; nbr line +1
// $T['ContentInfos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
// $T['ContentInfos']['GroupName']		= "list";
// $T['ContentInfos']['CellName']			= "grp";
// $T['ContentInfos']['DocumentName']		= "doc";
// $T['ContentInfos']['cell_1_txt']		= $I18nObj->getI18nTransEntry('cell_1_txt');
// $T['ContentInfos']['cell_2_txt']		= $I18nObj->getI18nTransEntry('cell_2_txt');
// $T['ContentInfos']['cell_3_txt']		= $I18nObj->getI18nTransEntry('cell_3_txt');

// $T['ContentCfg']['tabs']['1']['NbrOfLines']	= 5;	$T['ContentCfg']['tabs']['1']['NbrOfCells']	= 2;	$T['ContentCfg']['tabs']['1']['TableCaptionPos']		= 2;

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


/*Hydr-Content-End*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
