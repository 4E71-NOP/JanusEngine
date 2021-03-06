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

$cs->RequestDataObj->setRequestData('userForm',
		array(
				'mode'			=> 'edit',
// 				'mode'			=> 'create',
				'selectionId'	=>	30,
				'selectionName'	=>	"dieu",
		)
);
$cs->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminUserManagementP02',
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
$localisation = " / uni_user_management_p02";
$cs->MapperObj->AddAnotherLevel($localisation );
$cs->LMObj->logCheckpoint("uni_user_management_p02.php");
$cs->MapperObj->RemoveThisLevel($localisation );
$cs->MapperObj->setSqlApplicant("uni_user_management_p02.php");

switch ($l) {
	case "fra":
		$cs->I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer le thème.",
		"invite2"		=> "Cette partie va vous permettre de créer un thème.",
		"tabTxt1"		=> "Général",
		"tabTxt2"		=> "Etat",
		"tabTxt3"		=> "Adresses",
		"tabTxt4"		=> "Perso",
		"tabTxt5"		=> "Localisation",
		"tabTxt6"		=> "Config",
		"raf1"			=> "Rien a afficher",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Nom",
		"t1l3c1"		=>	"Identifiant",
		"t1l4c1"		=>	"Avatar",
		"t1l5c1"		=>	"Date d'inscription",
		"t1l6c1"		=>	"Commentaire admin",
		
		"t2l1c1"		=>	"Groupe initial",
		"t2l2c1"		=>	"Statut",
		"t2l3c1"		=>	"Fonction",
		"t2l4c1"		=>	"Droits forums",
		
		"t3l1c1"		=>	"Courriel",
		"t3l2c1"		=>	"MSN",
		"t3l3c1"		=>	"AIM",
		"t3l4c1"		=>	"ICQ",
		"t3l5c1"		=>	"YIM",
		"t3l6c1"		=>	"Site web",
		
		"t4l1c1"		=>	"Nom",
		"t4l2c1"		=>	"Pays",
		"t4l3c1"		=>	"Ville",
		"t4l4c1"		=>	"Occupation",
		"t4l5c1"		=>	"Interet",
		
		"t5l1c1"		=>	"Langue",
		"t5l2c1"		=>	"Dernière visite",
		"t5l3c1"		=>	"Dernière IP",
		"t5l4c1"		=>	"TimeZone",
		
		"t6l1c1"		=>	"Theme",
		"t6l2c1"		=>	"Newsletter",
		"t6l3c1"		=>	"Montre email",
		"t6l4c1"		=>	"Montre status online",
		"t6l5c1"		=>	"Notification reponse forum",
		"t6l6c1"		=>	"Notification nouveau",
		"t6l7c1"		=>	"Autorise bbcode",
		"t6l8c1"		=>	"Autorise html",
		"t6l9c1"		=>	"Autorise smilies",
		
		"public"		=>	"Public",
		"private"		=>	"Privé",
		"forumAccesGranted"		=>	"Forum accessilbe",
		"forumAccesDenied"		=>	"Forum inaccessilbe",
		));
		break;
		
	case "eng":
		$cs->I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage this theme.",
		"invite2"		=> "This part will allow you to create a theme.",
		"tabTxt1"		=> "General",
		"tabTxt2"		=> "State",
		"tabTxt3"		=> "Addresses",
		"tabTxt4"		=> "Perso",
		"tabTxt5"		=> "Localisation",
		"tabTxt6"		=> "Config",
		"raf1"			=> "Nothing to display",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Name",
		"t1l3c1"		=>	"Login",
		"t1l4c1"		=>	"Avatar",
		"t1l5c1"		=>	"Sign up date",
		"t1l6c1"		=>	"Admin coment",
		
		"t2l1c1"		=>	"Initial group",
		"t2l2c1"		=>	"Status",
		"t2l3c1"		=>	"Fonction",
		"t2l4c1"		=>	"Forums access",
		
		"t3l1c1"		=>	"Email",
		"t3l2c1"		=>	"MSN",
		"t3l3c1"		=>	"AIM",
		"t3l4c1"		=>	"ICQ",
		"t3l5c1"		=>	"YIM",
		"t3l6c1"		=>	"Website",
		
		"t4l1c1"		=>	"Nom",
		"t4l2c1"		=>	"Country",
		"t4l3c1"		=>	"Town",
		"t4l4c1"		=>	"Occupation",
		"t4l5c1"		=>	"Interest",
		
		"t5l1c1"		=>	"Language",
		"t5l2c1"		=>	"Last visit",
		"t5l3c1"		=>	"Last IP",
		"t5l4c1"		=>	"TimeZone",
		
		"t6l1c1"		=>	"theme",
		"t6l2c1"		=>	"newsletter",
		"t6l3c1"		=>	"show email",
		"t6l4c1"		=>	"show status online",
		"t6l5c1"		=>	"forum notification",
		"t6l6c1"		=>	"new topic notification",
		"t6l7c1"		=>	"Allow bbcode",
		"t6l8c1"		=>	"Allow html",
		"t6l9c1"		=>	"Allow smilies",
		
		"public"		=>	"Public",
		"private"		=>	"Private",
		"forumAccesGranted"		=>	"Forum access granted",
		"forumAccesDenied"		=>	"Forum denied",
		));
		break;
}
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------

$currentUserObj = new User();
switch ( $cs->RequestDataObj->getRequestDataSubEntry('userForm', 'mode') ) {
	case "edit":
		$commandType = "update";
		$currentUserObj->getUserDataFromDB($cs->RequestDataObj->getRequestDataSubEntry('userForm', 'selectionName'), $WebSiteObj);
		$t1l2c2 = $currentUserObj->getUserEntry('user_name');
		$Content .= "<p>".$cs->I18nObj->getI18nEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentUserObj->setUser(
				array(
					"user_id"							=>	"33",
					"user_name"							=>	"dieu",
					"user_login"						=>	"dieu",
					"user_password"						=>	"",
					"user_subscription_date"			=>	"1581612801",
					"user_status"						=>	1,
					"user_role_function"				=>	1,
					"user_forum_access"					=>	1,
					"user_email"						=>	"NA",
					"user_msn"							=>	"NA",
					"user_aim"							=>	"NA",
					"user_icq"							=>	"NA",
					"user_yim"							=>	"NA",
					"user_website"						=>	"NA",
					"user_perso_name"					=>	"dieu",
					"user_perso_country"				=>	"NA",
					"user_perso_town"					=>	"NA",
					"user_perso_occupation"				=>	"NA",
					"user_perso_interest"				=>	"NA",
					"user_last_visit"					=>	0,
					"user_last_ip"						=>	"0.0.0.0",
					"user_timezone"						=>	1,
					"user_lang"							=>	0,
					"user_pref_theme"					=>	"NULL",
					"user_pref_newsletter"				=>	1,
					"user_pref_show_email"				=>	0,
					"user_pref_show_online_status"		=>	0,
					"user_pref_forum_notification"		=>	1,
					"user_pref_forum_pm"				=>	1,
					"user_pref_allow_bbcode"			=>	1,
					"user_pref_allow_html"				=>	1,
					"user_pref_autorise_smilies"		=>	1,
					"user_avatar_image"					=>	"../websites-datas/00_Hydre/data/images/avatars/public/dieu.gif",
					"user_admin_comment"				=>	"Null",
				)
		);
		$t1l2c2 = "<input type='text' name='formTarget[name]' size='45' maxlength='255' value=\"".$cs->I18nObj->getI18nEntry('t1l2c2')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$Content .= "<p>".$cs->I18nObj->getI18nEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();

// $tabUser		= $MenuSelectTableObj->getUserList();
$tabGroup		= $MenuSelectTableObj->getGroupList();
$tabLanguage	= $MenuSelectTableObj->getLanguageList();
$tabTheme		= $MenuSelectTableObj->getThemeList();

$tabYN = array(
		0	=> array ( "t"=>$cs->I18nObj->getI18nEntry('no'),		"db"=>"NO" ),
		1	=> array ( "t"=>$cs->I18nObj->getI18nEntry('yes'),	"db"=>"YES" ),
);

// --------------------------------------------------------------------------------------------
$timezone = array(
		0		=> "0 - England, Ireland, Portugal",
		1		=> "+1 - Europe: France, Spain, Germany, Poland, etc.",
		2		=> "+2 - Central Europe: Turkey, Greece, Finland, etc.",
		3		=> "+3 - Moscow, Saudi Arabia",
		4		=> "+4 - Oman",
		5		=> "+5 - Pakistan",
		6		=> "+6 - India",
		7		=> "+7 - Indonesia",
		8		=> "+8 - China, Phillipines, Malaysia, West Australia",
		9		=> "+9 - Japan",
		10		=> "+10 - East Australia",
		11		=> "+11 - Solomon islands, Micronesia",
		12		=> "+12 - Marshall Islands, Fiji",
		13		=> "-11 - Samoa, Midway",
		14		=> "-10 - Hawaii, French Polynesia, Cook island",
		15		=> "-9 - Alaska",
		16		=> "-8 - US Pacific",
		17		=> "-7 - US Mountain",
		18		=> "-6 - US Central",
		19		=> "-5 - US Eastern",
		20		=> "-4 - New Foundland, Venezuela, Chile",
		21		=> "-3 - Brazil, Argentina, Greenland",
		22		=> "-2 - Mid-Atlantic",
		23		=> "-1 - Azores, Cape Verda Is.",
);


// --------------------------------------------------------------------------------------------
$Content .= "
<form ACTION='index.php?' method='post' name='userForm'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminUserManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value=''>"
."<input type='hidden' name='formTarget1[name]'			value='".$currentUserObj->getUserEntry('user_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='userForm[selectionId]'		value='".$cs->RequestDataObj->getRequestDataSubEntry('userForm', 'selectionId')."'>\r"
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
$T['AD'][$curTab]['6']['1']['cont'] = $cs->I18nObj->getI18nEntry('t1l6c1');


$T['AD'][$curTab]['1']['2']['cont'] = $currentUserObj->getUserEntry('user_id');
$T['AD'][$curTab]['2']['2']['cont'] = $currentUserObj->getUserEntry('user_name');
$T['AD'][$curTab]['3']['2']['cont'] = $currentUserObj->getUserEntry('user_login');

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "userForm",
		"formTargetId"		=> "formParams[user_avatar_image]",
		"formInputSize"		=> 25 ,
		"formInputVal"		=> $currentUserObj->getUserEntry('user_avatar_image'),
		"path"				=> "/websites-data/".$WebSiteObj->getWebSiteEntry ('ws_directory')."/data/images/avatars/",
		"restrictTo"		=> "/websites-data/".$WebSiteObj->getWebSiteEntry ('ws_directory')."/data/images/avatars/",
		"strRemove"			=> "/\.*\w*\//",
		"strAdd"			=> "../",
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
$T['AD'][$curTab]['4']['2']['cont']		= $cs->InteractiveElementsObj->renderIconSelectFile($infos);

$T['AD'][$curTab]['5']['2']['cont'] = $cs->TimeObj->timestampToDate($currentUserObj->getUserEntry('user_subscription_date'));
$T['AD'][$curTab]['6']['2']['cont'] = "<textarea name='formParams[user_admin_comment]' cols='50' rows='10'>".$currentUserObj->getUserEntry('user_admin_comment')."</textarea>";

// --------------------------------------------------------------------------------------------
$curTab++;

$T['AD'][$curTab]['1']['1']['cont'] = $cs->I18nObj->getI18nEntry('t2l1c1');
$T['AD'][$curTab]['2']['1']['cont'] = $cs->I18nObj->getI18nEntry('t2l2c1');
$T['AD'][$curTab]['3']['1']['cont'] = $cs->I18nObj->getI18nEntry('t2l3c1');
$T['AD'][$curTab]['4']['1']['cont'] = $cs->I18nObj->getI18nEntry('t2l4c1');

$cs->LMObj->logDebug($currentUserObj, 'currentUserObj');


$tabGroup[$currentUserObj->getUserEntry('group_id')]['s'] = " selected ";
$T['AD'][$curTab]['1']['2']['cont'] = "<select name='formParams[group]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabGroup as $A ) { $T['AD'][$curTab]['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['1']['2']['cont'] .= "</select>\r";


$tabStatus = array(
	0	=> array ( "t"=>$cs->I18nObj->getI18nEntry('offline'),	"db"=>"OFFLINE" ),
	1	=> array ( "t"=>$cs->I18nObj->getI18nEntry('online'),		"db"=>"ONLINE" ),
	2	=> array ( "t"=>$cs->I18nObj->getI18nEntry('deleted'),	"db"=>"DELETED" ),
);
$tabStatus[$currentUserObj->getUserEntry('user_status')]['s'] = " selected ";
$T['AD'][$curTab]['2']['2']['cont'] = "<select name='formParams[status]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabStatus as $A ) { $T['AD'][$curTab]['2']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['2']['2']['cont'] .= "</select>\r";


$tabRole = array(
		1	=> array ( "t"=>$cs->I18nObj->getI18nEntry('public'),	"db"=>"PUBLIC" ),
		2	=> array ( "t"=>$cs->I18nObj->getI18nEntry('private'),	"db"=>"PRIVATE" ),
);
$tabRole[$currentUserObj->getUserEntry('user_role_function')]['s'] = " selected ";
$T['AD'][$curTab]['3']['2']['cont'] = "<select name='formParams[role]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabRole as $A ) { $T['AD'][$curTab]['3']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['3']['2']['cont'] .= "</select>\r";


$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_forum_access')]['s'] = " selected ";
$T['AD'][$curTab]['4']['2']['cont'] = "<select name='formParams[forums]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['4']['2']['cont'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
$curTab++;
$T['AD'][$curTab]['1']['1']['cont'] = $cs->I18nObj->getI18nEntry('t3l1c1');
$T['AD'][$curTab]['2']['1']['cont'] = $cs->I18nObj->getI18nEntry('t3l2c1');
$T['AD'][$curTab]['3']['1']['cont'] = $cs->I18nObj->getI18nEntry('t3l3c1');
$T['AD'][$curTab]['4']['1']['cont'] = $cs->I18nObj->getI18nEntry('t3l4c1');
$T['AD'][$curTab]['5']['1']['cont'] = $cs->I18nObj->getI18nEntry('t3l5c1');
$T['AD'][$curTab]['6']['1']['cont'] = $cs->I18nObj->getI18nEntry('t3l6c1');

$T['AD'][$curTab]['1']['2']['cont'] = "<input type='text' name='formParams[user_email]'		size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('user_email')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['2']['2']['cont'] = "<input type='text' name='formParams[user_msn]'		size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('user_msn')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['3']['2']['cont'] = "<input type='text' name='formParams[user_aim]'		size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('user_aim')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['4']['2']['cont'] = "<input type='text' name='formParams[user_icq]'		size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('user_icq')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['5']['2']['cont'] = "<input type='text' name='formParams[user_yim]'		size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('user_yim')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['6']['2']['cont'] = "<input type='text' name='formParams[user_website]'	size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('user_website')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

// --------------------------------------------------------------------------------------------
$curTab++;

$T['AD'][$curTab]['1']['1']['cont'] = $cs->I18nObj->getI18nEntry('t4l1c1');
$T['AD'][$curTab]['2']['1']['cont'] = $cs->I18nObj->getI18nEntry('t4l2c1');
$T['AD'][$curTab]['3']['1']['cont'] = $cs->I18nObj->getI18nEntry('t4l3c1');
$T['AD'][$curTab]['4']['1']['cont'] = $cs->I18nObj->getI18nEntry('t4l4c1');
$T['AD'][$curTab]['5']['1']['cont'] = $cs->I18nObj->getI18nEntry('t4l5c1');

$T['AD'][$curTab]['1']['2']['cont'] = "<input type='text' name='formParams[perso_nom]'			size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('perso_nom')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['2']['2']['cont'] = "<input type='text' name='formParams[perso_pays]'			size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('perso_pays')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['3']['2']['cont'] = "<input type='text' name='formParams[perso_ville]'		size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('perso_ville')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['4']['2']['cont'] = "<input type='text' name='formParams[perso_occupation]'	size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('perso_occupation')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD'][$curTab]['5']['2']['cont'] = "<input type='text' name='formParams[perso_interet]'		size='35' maxlength='255' value=\"".$currentUserObj->getUserEntry('perso_interet')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";



// --------------------------------------------------------------------------------------------
$curTab++;

$T['AD'][$curTab]['1']['1']['cont'] = $cs->I18nObj->getI18nEntry('t5l1c1');
$T['AD'][$curTab]['2']['1']['cont'] = $cs->I18nObj->getI18nEntry('t5l2c1');
$T['AD'][$curTab]['3']['1']['cont'] = $cs->I18nObj->getI18nEntry('t5l3c1');
$T['AD'][$curTab]['4']['1']['cont'] = $cs->I18nObj->getI18nEntry('t5l4c1');

$tabLanguage[$currentUserObj->getUserEntry('user_lang')]['s'] = " selected ";
$T['AD'][$curTab]['1']['2']['cont'] = "<select name='formParams[user_lang]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabLanguage as $A ) { $T['AD'][$curTab]['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['1']['2']['cont'] .= "</select>\r";

$T['AD'][$curTab]['2']['2']['cont'] = $cs->TimeObj->timestampToDate($currentUserObj->getUserEntry('user_last_visit'));
$T['AD'][$curTab]['3']['2']['cont'] = $currentUserObj->getUserEntry('user_last_ip');
$T['AD'][$curTab]['4']['2']['cont'] = $timezone[$currentUserObj->getUserEntry('user_timezone')];

// --------------------------------------------------------------------------------------------
$curTab++;

$T['AD'][$curTab]['1']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l1c1');
$T['AD'][$curTab]['2']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l2c1');
$T['AD'][$curTab]['3']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l3c1');
$T['AD'][$curTab]['4']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l4c1');
$T['AD'][$curTab]['5']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l5c1');
$T['AD'][$curTab]['6']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l6c1');
$T['AD'][$curTab]['7']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l7c1');
$T['AD'][$curTab]['8']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l8c1');
$T['AD'][$curTab]['9']['1']['cont'] = $cs->I18nObj->getI18nEntry('t6l9c1');




$tabTheme[$currentUserObj->getUserEntry('user_pref_theme')]['s'] = " selected ";
$T['AD'][$curTab]['1']['2']['cont'] = "<select name='formParams[user_pref_theme]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTheme as $A ) { $T['AD'][$curTab]['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['1']['2']['cont'] .= "</select>\r";


$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_pref_newsletter')]['s'] = " selected ";
$T['AD'][$curTab]['2']['2']['cont'] = "<select name='formParams[user_pref_newsletter]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['2']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['2']['2']['cont'] .= "</select>\r";

$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_pref_show_email')]['s'] = " selected ";
$T['AD'][$curTab]['3']['2']['cont'] = "<select name='formParams[user_pref_show_email]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['3']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['3']['2']['cont'] .= "</select>\r";

$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_pref_show_online_status')]['s'] = " selected ";
$T['AD'][$curTab]['4']['2']['cont'] = "<select name='formParams[user_pref_show_online_status]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['4']['2']['cont'] .= "</select>\r";

$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_pref_forum_notification')]['s'] = " selected ";
$T['AD'][$curTab]['5']['2']['cont'] = "<select name='formParams[user_pref_forum_notification]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['5']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['5']['2']['cont'] .= "</select>\r";

$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_pref_forum_pm')]['s'] = " selected ";
$T['AD'][$curTab]['6']['2']['cont'] = "<select name='formParams[user_pref_forum_pm]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['6']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['6']['2']['cont'] .= "</select>\r";

$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_pref_allow_bbcode')]['s'] = " selected ";
$T['AD'][$curTab]['7']['2']['cont'] = "<select name='formParams[user_pref_allow_bbcode]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['7']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['7']['2']['cont'] .= "</select>\r";

$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_pref_allow_html')]['s'] = " selected ";
$T['AD'][$curTab]['8']['2']['cont'] = "<select name='formParams[user_pref_allow_html]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['8']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['8']['2']['cont'] .= "</select>\r";

$tabTmp = $tabYN;
$tabTmp[$currentUserObj->getUserEntry('user_pref_autorise_smilies')]['s'] = " selected ";
$T['AD'][$curTab]['9']['2']['cont'] = "<select name='formParams[user_pref_autorise_smilies]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabTmp as $A ) { $T['AD'][$curTab]['9']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD'][$curTab]['9']['2']['cont'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $cs->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 6);
$T['ADC']['onglet'] = array(
		1	=>	$cs->RenderTablesObj->getDefaultTableConfig(5,2,2),
		2	=>	$cs->RenderTablesObj->getDefaultTableConfig(4,2,2),
		3	=>	$cs->RenderTablesObj->getDefaultTableConfig(6,2,2),
		4	=>	$cs->RenderTablesObj->getDefaultTableConfig(5,2,2),
		5	=>	$cs->RenderTablesObj->getDefaultTableConfig(4,2,2),
		6	=>	$cs->RenderTablesObj->getDefaultTableConfig(9,2,2),
);
$Content .= $cs->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "userForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
