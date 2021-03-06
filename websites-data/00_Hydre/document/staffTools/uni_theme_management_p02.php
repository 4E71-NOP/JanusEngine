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
/* @var $cs CommonSystem                            */
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


$cs->RequestDataObj->setRequestData('themeForm',
		array(
				'mode'			=> 'edit',
// 				'mode'			=> 'create',
				'selectionId'	=>	30,
		)
);
$cs->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminThemeManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);
$cs->CMObj->setConfigurationEntry('colorSelector', 'system');		//"or Hydr"


/*Hydre-contenu_debut*/
$localisation = " / uni_theme_management_p02";
$cs->MapperObj->AddAnotherLevel($localisation );
$cs->LMObj->logCheckpoint("uni_theme_management_p02.php");
$cs->MapperObj->RemoveThisLevel($localisation );
$cs->MapperObj->setSqlApplicant("uni_theme_management_p02.php");

switch ($l) {
	case "fra":
		$cs->I18nObj->apply(array(
		"acpUp"			=>	"Haut",
		"acpDown"		=>	"Bas",
		"acpLeft"		=>	"Gauche",
		"acpRight"		=>	"Droite",
		"acpMiddle"		=>	"Milieu",
		
		"invite1"		=> "Cette partie va vous permettre de gérer le thème.",
		"invite2"		=> "Cette partie va vous permettre de créer un thème.",
		"tabTxt1"		=> "Général",
		"tabTxt2"		=> "Block 1-15",
		"tabTxt3"		=> "Block 16-30",
		"tabTxt4"		=> "Menu 0-9",
		"tabTxt5"		=> "Config",
		"tabTxt6"		=> "Admin",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Nom",
		"t1l3c1"		=>	"Titre",
		"t1l4c1"		=>	"Description",
		"t1l5c1"		=>	"Répertoire",
		
		"t2lxc1"		=>	"Bloc",
		
		"t5l1c1"		=>	"Répertoire",
		"t5l2c1"		=>	"Feuille de style",
		"t5l7c1"		=>	"Fond",
		"t5l8c1"		=>	"Image de fond",
		"t5l9c1"		=>	"Répetition image",
		"t5l10c1"		=>	"Couleur de fond",
		"t5l11c1"		=>	"Div initial",
		"t5l12c1"		=>	"Image de fond",
		"t5l13c1"		=>	"Répetition image",
		"t5l14c1"		=>	"Dimenssion X",
		"t5l15c1"		=>	"Dimenssion Y",
		"t5l16c1"		=>	"Divers",
		"t5l17c1"		=>	"Logo",
		"t5l18c1"		=>	"Banniere",
		
		"t6l1c1"		=>	"Fond du panneau d'administration<span class='".$Block."_avert'>(1)</span>",
		"t6l2c1"		=>	"Bouton<span class='".$Block."_avert'>(1)</span>",
		"t6l3c1"		=>	"Dimenssion X/Y",
		"t6l4c1"		=>	"Position",
		"t6l5c1"		=>	"Fondu de la jauge D&eacute;but / Fin",
		"t6l6c1"		=>	"<span class='".$Block."_avert'>(1)</span>Ne laissez que le nom de fichier dans la case.",
		
		
		"t1l2c2"		=>	"New_theme",
		
		));
		break;
		
	case "eng":
		$cs->I18nObj->apply(array(
		"acpUp"			=>	"Up",
		"acpDown"		=>	"Down",
		"acpLeft"		=>	"Left",
		"acpRight"		=>	"Right",
		"acpMiddle"		=>	"Middle",
		
		"invite1"		=> "This part will allow you to manage this theme.",
		"invite2"		=> "This part will allow you to create a theme.",
		"tabTxt1"		=> "General",
		"tabTxt2"		=> "Block 1-15",
		"tabTxt3"		=> "Block 16-30",
		"tabTxt4"		=> "Menu 0-9",
		"tabTxt5"		=> "Config",
		"tabTxt6"		=> "Admin",
		"raf1"			=> "Nothing to display",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Name",
		"t1l3c1"		=>	"Title",
		"t1l4c1"		=>	"Description",
		"t1l5c1"		=>	"Directory",
		
		"t2lxc1"		=>	"Block",
		
		"t5l1c1"		=>	"Directory",
		"t5l2c1"		=>	"StyleSheet",
		"t5l7c1"		=>	"Background",
		"t5l8c1"		=>	"Background image",
		"t5l9c1"		=>	"Image repetition",
		"t5l10c1"		=>	"Background color",
		"t5l11c1"		=>	"Div initial",
		"t5l12c1"		=>	"Background image",
		"t5l13c1"		=>	"Image repetition",
		"t5l14c1"		=>	"Dimenssion X",
		"t5l15c1"		=>	"Dimenssion Y",
		"t5l16c1"		=>	"Miscellaneous",
		"t5l17c1"		=>	"Logo",
		"t5l18c1"		=>	"Banner",
		
		"t6l1c1"		=>	"Admin panel background<span class='".$Block."_avert'>(1)</span>",
		"t6l2c1"		=>	"Switch<span class='".$Block."_avert'>(1)</span>",
		"t6l3c1"		=>	"Size X/Y",
		"t6l4c1"		=>	"Position",
		"t6l5c1"		=>	"Gauge blend Begin / End",
		"t6l6c1"		=>	"<span class='".$Block."_avert'>(1)</span>Leave only the filename.",
		
		"t1l2c2"		=>	"New_theme",
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

$ClassLoaderObj->provisionClass('ThemeDescriptor');
$currentThemeObj = new ThemeDescriptor();
switch ( $cs->RequestDataObj->getRequestDataSubEntry('themeForm', 'mode') ) {
	case "edit":
		$commandType = "update";
		$currentThemeObj->getThemeDescriptorDataFromDB($cs->RequestDataObj->getRequestDataSubEntry('themeForm', 'selectionId'));
		$t1l2c2 = $currentThemeObj->getThemeDescriptorEntry('theme_name');
		$t1l3c2 = "<input type='text' name='formParams[title]' size='45' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$Content .= "<p>".$cs->I18nObj->getI18nEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentThemeObj->setThemeDescriptor(
		array(
		"theme_id"		=> "*",
		"theme_name"	=> $cs->I18nObj->getI18nEntry('t1l2c2'),
		"theme_title"	=> $cs->I18nObj->getI18nEntry('t1l2c2'),
		"theme_desc"	=> $cs->I18nObj->getI18nEntry('t1l2c2'),
		)
		);
		$t1l2c2 = "<input type='text' name='formTarget[name]' size='45' maxlength='255' value=\"".$cs->I18nObj->getI18nEntry('t1l2c2')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$t1l3c2 = "<input type='text' name='formParams[title]' size='45' maxlength='255' value=\"".$cs->I18nObj->getI18nEntry('t1l2c2')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$Content .= "<p>".$cs->I18nObj->getI18nEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}


// --------------------------------------------------------------------------------------------
// if ( $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard' && $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'modification') != 'on' ) {
// 	$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => 'AdminDashboard modification checkbox forgotten');
// 	$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$cs->I18nObj->getI18nEntry('userForgotConfirmation')."</p>\r";
// }
// if ( $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard' && $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'deletion') != 'on' ) {
// 	$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => 'AdminDashboard deletion checkbox forgotten');
// 	$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$cs->I18nObj->getI18nEntry('userForgotDeletion')."</p>\r";
// }

$Content .= "
<form ACTION='index.php?' method='post' name='themeForm'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminThemeManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value=''>"
."<input type='hidden' name='formTarget1[name]'			value='".$currentThemeObj->getThemeDescriptorEntry('theme_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='themeForm[selectionId]'	value='".$cs->RequestDataObj->getRequestDataSubEntry('themeForm', 'selectionId')."'>\r"
."<p>\r"
;

// --------------------------------------------------------------------------------------------
$T = array();
$curTab = 1;

$T['AD'][$curTab]['1']['1']['cont'] = $cs->I18nObj->getI18nEntry('t1l1c1');
$T['AD'][$curTab]['2']['1']['cont'] = $cs->I18nObj->getI18nEntry('t1l2c1');
$T['AD'][$curTab]['3']['1']['cont'] = $cs->I18nObj->getI18nEntry('t1l3c1');
$T['AD'][$curTab]['4']['1']['cont'] = $cs->I18nObj->getI18nEntry('t1l4c1');
$T['AD'][$curTab]['5']['1']['cont'] = $cs->I18nObj->getI18nEntry('t1l5c1');


$T['AD'][$curTab]['1']['2']['cont'] = $currentThemeObj->getThemeDescriptorEntry('theme_id');
$T['AD'][$curTab]['2']['2']['cont'] = $t1l2c2;
$T['AD'][$curTab]['3']['2']['cont'] = $t1l3c2;
$T['AD'][$curTab]['4']['2']['cont'] = $currentThemeObj->getThemeDescriptorEntry('theme_desc');


// --------------------------------------------------------------------------------------------
$decoCount1 = 1;
for ( $i = 2 ; $i <= 3 ; $i++ ) {
	for ( $j = 1 ; $j <= 15 ; $j++ ) {
		$decoCount2 = sprintf("%02u", $decoCount1 );
		$T['AD'][$i][$j]['1']['cont'] = $cs->I18nObj->getI18nEntry('t2lxc1') . "_" . $decoCount2;
		$T['AD'][$i][$j]['2']['cont'] = "
		<input type='text' name='formParams[theme_bloc_".$decoCount2."_nom]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_bloc_'.$decoCount2.'_nom')."\" class='".$Block."_t3 ".$Block."_form_1'>\r
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='text' name='formParams[theme_bloc_".$decoCount2."_texte]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_bloc_'.$decoCount2.'_texte')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$decoCount1++;
	}
}

// --------------------------------------------------------------------------------------------
$decoCount1 = 0;
for ( $j = 1 ; $j <= 30 ; $j++ ) {
	$decoCount2 = sprintf("%02u", $decoCount1 );
	$T['AD']['4'][$j]['1']['cont'] = $cs->I18nObj->getI18nEntry('t2lxc1') . "_" . $decoCount2;
	$T['AD']['4'][$j]['2']['cont'] = "<input type='text' name='formParams[theme_bloc_".$decoCount2."_menu]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_bloc_'.$decoCount2.'_menu')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
	$decoCount1++;
}


// --------------------------------------------------------------------------------------------
$curTab = 5;
$T['AD'][$curTab]['1']['1']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l1c1');
$T['AD'][$curTab]['2']['1']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l2c1')." #1";
$T['AD'][$curTab]['3']['1']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l2c1')." #2";
$T['AD'][$curTab]['4']['1']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l2c1')." #3";
$T['AD'][$curTab]['5']['1']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l2c1')." #4";
$T['AD'][$curTab]['6']['1']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l2c1')." #5";
$T['AD'][$curTab]['7']['2']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l7c1');
$T['AD'][$curTab]['7']['1']['colspan']		= 2;
$T['AD'][$curTab]['8']['1']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l8c1');
$T['AD'][$curTab]['9']['1']['cont']			= $cs->I18nObj->getI18nEntry('t'.$curTab.'l9c1');
$T['AD'][$curTab]['10']['1']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l10c1');
$T['AD'][$curTab]['11']['2']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l11c1');
$T['AD'][$curTab]['11']['1']['colspan']		= 2;
$T['AD'][$curTab]['12']['1']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l12c1');
$T['AD'][$curTab]['13']['1']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l13c1');
$T['AD'][$curTab]['14']['1']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l14c1');
$T['AD'][$curTab]['15']['1']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l15c1');
$T['AD'][$curTab]['16']['2']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l16c1');
$T['AD'][$curTab]['16']['1']['colspan']		= 2;
$T['AD'][$curTab]['17']['1']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l17c1');
$T['AD'][$curTab]['18']['1']['cont']		= $cs->I18nObj->getI18nEntry('t'.$curTab.'l18c1');



$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_directory]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_directory'),
		"path"				=> "/media/theme/",
		"restrictTo"		=> "/media/theme/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "directory",
		"displayType"		=> "fileList",
		"buttonId"			=> "t5l1c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['1']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_stylesheet_1]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_1'),
		"path"				=> "/stylesheets/",
		"restrictTo"		=> "/stylesheets/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "t5l2c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['2']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_stylesheet_2]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_2'),
		"path"				=> "/stylesheets/",
		"restrictTo"		=> "/stylesheets/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "t5l3c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['3']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_stylesheet_3]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_3'),
		"path"				=> "/stylesheets/",
		"restrictTo"		=> "/stylesheets/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "t5l4c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['4']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_stylesheet_4]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_4'),
		"path"				=> "/stylesheets/",
		"restrictTo"		=> "/stylesheets/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "t5l5c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['5']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_stylesheet_5]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_5'),
		"path"				=> "/stylesheets/",
		"restrictTo"		=> "/stylesheets/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "t5l6c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['6']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);



// --------------------------------------------------------------------------------------------

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_bg]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_bg'),
		"path"				=> "/media/theme/",
		"restrictTo"		=> "/media/theme/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "imageMosaic",
		"buttonId"			=> "t5l8c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['8']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);

$T['AD'][$curTab]['9']['2']['cont']		= "<input type='text' name='formParams[theme_bg_repeat]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_bg_repeat')."\" class='".$Block."_t3 ".$Block."_form_1'>\r"; 
$T['AD'][$curTab]['10']['2']['cont']	= "<input type='text' name='formParams[theme_bg_color]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_bg_color')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_divinitial_bg]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_divinitial_bg'),
		"path"				=> "/media/theme/",
		"restrictTo"		=> "/media/theme/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "imageMosaic",
		"buttonId"			=> "t5l12c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['12']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);


$T['AD'][$curTab]['13']['2']['cont']	= "<input type='text' name='formParams[theme_divinitial_repeat]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_divinitial_repeat')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['14']['2']['cont']	= "<input type='text' name='formParams[theme_divinitial_dx]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_divinitial_dx')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['15']['2']['cont']	= "<input type='text' name='formParams[theme_divinitial_dy]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_divinitial_dy')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_divinitial_bg]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_divinitial_bg'),
		"path"				=> "/media/theme/",
		"restrictTo"		=> "/media/theme/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "imageMosaic",
		"buttonId"			=> "t5l12c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['12']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);



$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_logo]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_logo'),
		"path"				=> "/media/theme/",
		"restrictTo"		=> "/media/theme/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "imageMosaic",
		"buttonId"			=> "t5l17c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['17']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_banner]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_banner'),
		"path"				=> "/media/theme/",
		"restrictTo"		=> "/media/theme/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "imageMosaic",
		"buttonId"			=> "t5l18c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['18']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);



// --------------------------------------------------------------------------------------------
$curTab++;
$T['AD'][$curTab]['1']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l1c1');
$T['AD'][$curTab]['2']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l2c1');
$T['AD'][$curTab]['3']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l3c1');
$T['AD'][$curTab]['4']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l4c1');
$T['AD'][$curTab]['5']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l5c1');
$T['AD'][$curTab]['6']['2']['cont'] = $cs->I18nObj->getI18nEntry('t6l6c1');

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_admctrl_panel_bg]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_admctrl_panel_bg'),
		"path"				=> "/media/theme/",
		"restrictTo"		=> "/media/theme/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "",
		"selectionMode"		=> "file",
		"displayType"		=> "imageMosaic",
		"buttonId"			=> "t6l1c2",
		"case"				=> 3,
		"update"			=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
$T['AD'][$curTab]['1']['2']['cont'] = $cs->InteractiveElementsObj->renderIconSelectFile($infos);

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "themeForm",
		"formTargetId"		=> "formParams[theme_admctrl_switch_bg]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentThemeObj->getThemeDescriptorEntry('theme_admctrl_switch_bg'),
		"path"				=> "/media/theme/",
		"restrictTo"		=> "/media/theme/",
		"strRemove"			=> "/\.*\w*\//",
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
$T['AD'][$curTab]['2']['2']['cont'] = $cs->InteractiveElementsObj->renderIconSelectFile($infos);

$T['AD'][$curTab]['3']['2']['cont'] = "
	<input type='text' name='formParams[admctrl_size_x]' size='8' maxlength='255' value='".$currentThemeObj->getThemeDescriptorEntry('theme_admctrl_size_x')."' class='".$Block."_t3 ".$Block."_form_1'>px\r /
	<input type='text' name='formParams[admctrl_size_y]' size='8' maxlength='255' value='".$currentThemeObj->getThemeDescriptorEntry('theme_admctrl_size_y')."' class='".$Block."_t3 ".$Block."_form_1'>px\r"
;

$T['AD'][$curTab]['4']['2']['cont'] = "<select name ='formParams['admctrl_position']' class='".$Block."_t3 ".$Block."_form_1'>\r";
$admctrl_position = array();
$admctrl_position[$currentThemeObj->getThemeDescriptorEntry('theme_admctrl_position')] = " selected ";
$T['AD'][$curTab]['4']['2']['cont'] .= "
<option value='1' ".$admctrl_position['1']."> ".$cs->I18nObj->getI18nEntry('acpUp')." - ".		$cs->I18nObj->getI18nEntry('acpLeft')		." </option>\r
<option value='2' ".$admctrl_position['2']."> ".$cs->I18nObj->getI18nEntry('acpUp')." - ".		$cs->I18nObj->getI18nEntry('acpMiddle')	." </option>\r
<option value='3' ".$admctrl_position['3']."> ".$cs->I18nObj->getI18nEntry('acpUp')." - ".		$cs->I18nObj->getI18nEntry('acpRight')	." </option>\r
<option value='4' ".$admctrl_position['4']."> ".$cs->I18nObj->getI18nEntry('acpMiddle')." - ".	$cs->I18nObj->getI18nEntry('acpRight')	." </option>\r
<option value='5' ".$admctrl_position['5']."> ".$cs->I18nObj->getI18nEntry('acpDown')." - ".		$cs->I18nObj->getI18nEntry('acpRight')	." </option>\r
<option value='6' ".$admctrl_position['6']."> ".$cs->I18nObj->getI18nEntry('acpDown')." - ".		$cs->I18nObj->getI18nEntry('acpMiddle')	." </option>\r
<option value='7' ".$admctrl_position['7']."> ".$cs->I18nObj->getI18nEntry('acpDown')." - ".		$cs->I18nObj->getI18nEntry('acpLeft')		." </option>\r
<option value='8' ".$admctrl_position['8']."> ".$cs->I18nObj->getI18nEntry('acpMiddle')." - ".	$cs->I18nObj->getI18nEntry('acpLeft')		." </option>\r
</select>\r";


switch ( $cs->CMObj->getConfigurationEntry('colorSelector') ){
	case "Hydr":
		$T['AD'][$curTab]['5']['2']['cont'] = "
		#<input type='text' id='MS_couleur_jauge_depart'	name='formParams[couleur_jauge_depart]'	size='8' maxlength='6' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_start_color')."\"	class='".$Block."_t3 ".$Block."_form_1'>\r /
		#<input type='text' id='MS_couleur_jauge_milieu'	name='formParams[couleur_jauge_milieu]'	size='8' maxlength='6' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_middle_color')."\"	class='".$Block."_t3 ".$Block."_form_1'>\r /
		#<input type='text' id='MS_couleur_jauge_fin'		name='formParams[couleur_jauge_fin]'		size='8' maxlength='6' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_end_color')."\"		class='".$Block."_t3 ".$Block."_form_1'>\r
		<br>\r
		<br>\r
		<table style='border: 1px solid black; border-collapse: collapse'>\r
		<tr>\r";
		break;
	case "system":
		$T['AD'][$curTab]['5']['2']['cont'] = "
		<input type='color' id='MS_couleur_jauge_depart'	name='formParams[couleur_jauge_depart]'	value='#".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_start_color')."'	oninput='GestionThemeMAJJauge()' class='" . $Block."_t3 ".$Block."_form_1'>\r /
		<input type='color' id='MS_couleur_jauge_milieu'	name='formParams[couleur_jauge_milieu]'	value='#".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_middle_color')."'	oninput='GestionThemeMAJJauge()' class='" . $Block."_t3 ".$Block."_form_1'>\r /
		<input type='color' id='MS_couleur_jauge_fin'		name='formParams[couleur_jauge_fin]'		value='#".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_end_color')."'		oninput='GestionThemeMAJJauge()' class='" . $Block."_t3 ".$Block."_form_1'>\r
		<br>\r
		<br>\r
		<table style='border: 1px solid black; border-collapse: collapse'>\r
		<tr>\r";
		break;
}

$gradientNbr = 30;
$gradientWidth = 320;
for ( $i = 1 ; $i <= $gradientNbr; $i++ ) { $T['AD'][$curTab]['5']['2']['cont'] .= "<td id='jauge_theme_".$i."' style='width: ".floor( $gradientWidth / $gradientNbr)."px; height: 32px; background-color: #000000; border: 0px'></td>\r"; }
$T['AD'][$curTab]['5']['2']['cont'] .= "</tr>\r</table>\r";



// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $cs->RenderTablesObj->getDefaultDocumentConfig($infos, 16, 6);
$T['ADC']['onglet'] = array(
		1	=>	$cs->RenderTablesObj->getDefaultTableConfig(4,2,2),
		2	=>	$cs->RenderTablesObj->getDefaultTableConfig(15,2,2),
		3	=>	$cs->RenderTablesObj->getDefaultTableConfig(15,2,2),
		4	=>	$cs->RenderTablesObj->getDefaultTableConfig(10,2,2),
		5	=>	$cs->RenderTablesObj->getDefaultTableConfig(18,2,2),
		6	=>	$cs->RenderTablesObj->getDefaultTableConfig(6,2,2),
);
$Content .= $cs->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------

$cs->GeneratedJavaScriptObj->insertJavaScript('File', "engine/javascript/lib_themeManagement.js");
$cs->GeneratedJavaScriptObj->insertJavaScript('Onload', 'GestionThemeMAJJauge();');
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "themeForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
