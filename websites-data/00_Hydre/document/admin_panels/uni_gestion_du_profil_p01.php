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

// --------------------------------------------------------------------------------------------
$RequestDataObj->setRequestData('UserProfileForm', 
	array(
		"SelectedThemeId"	=>	2,
		"SelectedTheme"		=>	"mwm_aqua_01",
// 		"SelectedThemeId"	=>	4,
// 		"SelectedTheme"		=>	"mwm_magma_01",
// 		"SelectedThemeId"	=>	5,
// 		"SelectedTheme"		=>	"mwm_nebula_01",
		
	)
);

$RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'UserProfileP01',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
				//				'mode'			=> 'create',
		//				'mode'			=> 'delete',
		)
		);

$RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_du_profil_p01.php";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_du_profil_p01.php");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_du_profil_p01.php");

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");


switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=>	"Cette partie va vous permettre de gérer les journaux d'évennement.",
		"col_1_txt"		=>	"Id",
		"col_2_txt"		=>	"Date",
		"col_3_txt"		=>	"Signal",
		"col_4_txt"		=>	"Id Msg",
		"col_5_txt"		=>	"Initiateur",
		"col_6_txt"		=>	"Action",
		"col_7_txt"		=>	"Message",
		"tabTxt1"		=>	"Compte",
		"tabTxt2"		=>	"Internet",
		"tabTxt3"		=>	"Perso",
		"tabTxt4"		=>	"Preferences",
		"btn1"			=>	"Rafraichir la vue",
		"btn2"			=>	"Supprimer",
		"AvatarUploadError" => array(
				0	=>	"Erreur inconnue.",
				1	=>	"Le fichier dépasse la limite autorisée par le serveur.",
				2	=>	"Le fichier d&eacute;passe la limite autoris&eacute;e dans le formulaire HTML.",
				3	=>	"L'envoi du fichier a &eacute;t&eacute; interrompu pendant le transfert.",
				4	=>	"Le fichier que vous avez envoy&eacute; a une taille nulle.",
				5	=>	"Extension interdite pour les images d'avatar.",
			),		
		"confirmation_modification_oubli"	=>	"Vous n'avez pas confirm&eacute; la modification du profil.",
		"t1_l1"	=>	"Identifiant",
		"t1_l2"	=>	"Avatar",
		"t1_l3"	=>	"Téléchargement",
		"t2_l1"	=>	"Email",
		"t2_l2"	=>	"MSN",
		"t2_l3"	=>	"AIM",
		"t2_l4"	=>	"ICQ",
		"t2_l5"	=>	"YIM",
		"t2_l6"	=>	"Site Web",
		"t3_l1" =>	"Nom",
		"t3_l2"	=>	"Pays",
		"t3_l3"	=>	"Ville",
		"t3_l4"	=>	"Occupation",
		"t3_l5"	=>	"Sujets d'intérèt",
		"t4_l1"	=>	"Recevoir la newsletter",
		"t4_l2"	=>	"Montrer l'E-mail au public",
		"t4_l3"	=>	"Montrer le status 'En ligne'",
		"t4_l4"	=>	"Recevoir une notification des forums",
		"t4_l5"	=>	"Recevoir une notification de la messagerie priv&eacute;e",
		"t4_l6"	=>	"Autorise le BBcode",
		"t4_l7"	=>	"Autorise le HTML",
		"t4_l8"	=>	"Autorise les smileys",
		"t4_l9"	=>	"Langue",
		"modif_profil"	=>	"Modifier le profil",
		"upload_avatar"	=>	"Télécharger une image",
		"uni"	=>	array(
			0	=>	"Non",
			1	=>	"Oui",
		),
		"text_confirm1"			=>	"Je confirme les modifications",
		"text_choix_theme"		=>	"Choix du theme.",
		"visualisation_theme"	=>	"Valider",
		));
		break;
		
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=>	"This part will allow you to manage Logs.",
		"col_1_txt"		=>	"Id",
		"col_2_txt"		=>	"Date",
		"col_3_txt"		=>	"Signal",
		"col_4_txt"		=>	"Id Msg",
		"col_5_txt"		=>	"Initiator",
		"col_6_txt"		=>	"Action",
		"col_7_txt"		=>	"Message",
		"tabTxt1"		=>	"Compte",
		"tabTxt2"		=>	"Internet",
		"tabTxt3"		=>	"Perso",
		"tabTxt4"		=>	"Préférences",
		"btn1"			=>	"Refresh display",
		"AvatarUploadError" => array(
				0	=>	"Unknown error.",
				1	=>	"The filesize is exeeding maximum filsesize.",
				2	=>	"The filesize is exeeding autorized HTML maximum filsesize.",
				3	=>	"The file transfert has been interrupted.",
				4	=>	"The submitted filesize is equals to zero.",
				5	=>	"Forbidden extenssion for avatar images.",
			),
		"confirmation_modification_oubli"	=>	"You forgot to confirm the profil modification.",
		"t1_l1"	=>	"Login",
		"t1_l2"	=>	"Avatar",
		"t1_l3"	=>	"Upload",
		"t2_l1"	=>	"Email",
		"t2_l2"	=>	"MSN",
		"t2_l3"	=>	"AIM",
		"t2_l4"	=>	"ICQ",
		"t2_l5"	=>	"YIM",
		"t2_l6"	=>	"Website",
		"t3_l1"	=>	"Name",
		"t3_l2"	=>	"Pays",
		"t3_l3"	=>	"Town",
		"t3_l4"	=>	"Occupation",
		"t3_l5"	=>	"Interest",
		"t4_l1"	=>	"Get the newletter",
		"t4_l2"	=>	"Show email to the public",
		"t4_l3"	=>	"Show Online status",
		"t4_l4"	=>	"Be notified by the forum",
		"t4_l5"	=>	"Be notified on private message",
		"t4_l6"	=>	"Allow BBcode",
		"t4_l7"	=>	"Allow HTML",
		"t4_l8"	=>	"Allow smileys",
		"t4_l9"	=>	"Language",
		"modif_profil"	=>	"Update profile",
		"upload_avatar"	=>	"Upload image",
		"uni"	=>	array(
				0	=>	"No",
				1	=>	"Yes",
			),
		"text_confirm1"			=>	"I confirm the modifications",
		"text_choix_theme"		=>	"Theme browser.",
		"visualisation_theme"	=>	"Confirm",
			));
		
		break;
}

if ( $UserObj->getUserEntry('login') == "anonymous" ) { $Content .= "Partie reserv&eacute;e aux membres enregistr&eacute;s"; }
else {
// --------------------------------------------------------------------------------------------
//	Debut du formulaire
// --------------------------------------------------------------------------------------------
	$Content .= "
	<p>
	Cette Partie permet de modifier les données de votre profil. Modifiez les champs accessibles puis validez.
	<br>\r
	";
	
	if ( $RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'uploadError') == 1 ) {
		$Content .= "<p class='" . $Block."_avert'>".$I18nObj->getI18nEntry('AvatarUploadError')[$RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'AvatarUploadError')]."</p>\r<br>\r";
	}
	
	if ( $RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'confirmation_modification_oubli') == 'on' ) { 
		$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$I18nObj->getI18nEntry('confirmation_modification_oubli')."</p>\r<br>\r"; 
	}
	
	$Content .= "<br>\r
	<form enctype='multipart/form-data' ACTION='index.php?' method='post' name='UserProfileForm'>\r
	";
	
	if ( $UserObj->getUserEntry('pref_theme') == 0 ) { $UserObj->setUserEntry('pref_theme', $WebSiteObj->getWebSiteEntry('theme_id')); }
	$dbquery = $SDDMObj->query("
	SELECT a.*,b.theme_name,b.theme_id
	FROM ".$SqlTableListObj->getSQLTableName('user')." a , ".$SqlTableListObj->getSQLTableName('theme_descriptor')." b 
	WHERE a.user_id = '".$UserObj->getUserEntry('id')."' 
	AND theme_id = '".$UserObj->getUserEntry('pref_theme')."' 
	;");
	$PmListTheme = array();
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { foreach ( $dbp as $A => $B ) { $PmListTheme[$A] = $B; } }
	
// --------------------------------------------------------------------------------------------
//	Informations internet
// --------------------------------------------------------------------------------------------

	$FileSelectorConfig = array(
			"width"				=> 80,	//in %
			"height"			=> 50,	//in %
			"formName"			=> "UserProfileForm",
			"formTargetId"		=> "UserProfileForm[user_image_avatar]",
			"formInputSize"		=> 40 ,
			"formInputVal"		=> $UserObj->getUserEntry('user_image_avatar'),
			"path"				=> "websites-data/".$WebSiteObj->getWebSiteEntry('ws_directory')."/data/images/avatars/",
			"restrictTo"		=> "websites-data/".$WebSiteObj->getWebSiteEntry('ws_directory')."/data/images/avatars/",
			"strRemove"			=> "",
			"strAdd"			=> "../",
			"selectionMode"		=> "file",
			"displayType"		=> "fileList",
			"buttonId"			=> "t1l2c2",
			"case"				=> 1,
			"update"			=> 1,
			"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
	);
	$infos['IconSelectFile'] = $FileSelectorConfig;
	$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
	$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );
	
	
	$T = array();
	$T['AD']['1']['1']['1']['cont'] = $I18nObj->getI18nEntry('t1_l1');
	$T['AD']['1']['2']['1']['cont'] = $I18nObj->getI18nEntry('t1_l2');
	$T['AD']['1']['3']['1']['cont'] = $I18nObj->getI18nEntry('t1_l3');
	
	$T['AD']['1']['1']['2']['cont'] = "<input type='text' name='UserProfileForm[login]' value='".$UserObj->getUserEntry('user_login')."' size='15' maxlength='255' class='" . $Block."_t3 " . $Block."_t3 " . $Block."_form_1'  disabled> (ne sera pas modifié)";
	
	if ( strlen($PmListTheme['user_image_avatar']) != 1024 ) { $T['AD']['1']['2']['2']['cont'] = "<img src='".$PmListTheme['user_image_avatar']."' width='48' height='48' alt='[Avatar]'>"; }
	else { $T['AD']['1']['2']['2']['cont'] = "N/A"; }
	$T['AD']['1']['2']['2']['cont'] .=	$InteractiveElementsObj->renderIconSelectFile($infos);
	$T['AD']['1']['3']['2']['cont'] = "<input type='hidden' name='MAX_FILE_SIZE' value='32768'> 
	<input type='file' name='UserProfileForm[AvatarSelectedFile]' size='40' class='" . $Block."_t3 " . $Block."_form_1'>";

// --------------------------------------------------------------------------------------------
	$T['AD']['2']['1']['1']['cont'] = $I18nObj->getI18nEntry('t2_l1');
	$T['AD']['2']['2']['1']['cont'] = $I18nObj->getI18nEntry('t2_l2');
	$T['AD']['2']['3']['1']['cont'] = $I18nObj->getI18nEntry('t2_l3');
	$T['AD']['2']['4']['1']['cont'] = $I18nObj->getI18nEntry('t2_l4');
	$T['AD']['2']['5']['1']['cont'] = $I18nObj->getI18nEntry('t2_l5');
	$T['AD']['2']['6']['1']['cont'] = $I18nObj->getI18nEntry('t2_l6');
	
	$T['AD']['2']['1']['2']['cont'] = "<input type='text' name='UserProfileForm[user_email]' value='".		$UserObj->getUserEntry('user_email')	."' size='30' maxlength='255' class='"	.$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['2']['2']['2']['cont'] = "<input type='text' name='UserProfileForm[user_msn]' value='".		$UserObj->getUserEntry('user_msn')		."' size='30' maxlength='25' class='"	.$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['2']['3']['2']['cont'] = "<input type='text' name='UserProfileForm[user_aim]' value='".		$UserObj->getUserEntry('user_aim')		."' size='30' maxlength='18' class='"	.$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['2']['4']['2']['cont'] = "<input type='text' name='UserProfileForm[user_icq]' value='".		$UserObj->getUserEntry('user_icq')		."' size='30' maxlength='15' class='"	.$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['2']['5']['2']['cont'] = "<input type='text' name='UserProfileForm[user_yim]' value='".		$UserObj->getUserEntry('user_yim')		."' size='30' maxlength='25' class='"	.$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['2']['6']['2']['cont'] = "<input type='text' name='UserProfileForm[user_website]' value='".	$UserObj->getUserEntry('user_website')	."' size='30' maxlength='255' class='"	.$Block."_t3 ".$Block."_form_1'>";
	
	
// --------------------------------------------------------------------------------------------
	$T['AD']['3']['1']['1']['cont'] = $I18nObj->getI18nEntry('t3_l1');
	$T['AD']['3']['2']['1']['cont'] = $I18nObj->getI18nEntry('t3_l2');
	$T['AD']['3']['3']['1']['cont'] = $I18nObj->getI18nEntry('t3_l3');
	$T['AD']['3']['4']['1']['cont'] = $I18nObj->getI18nEntry('t3_l4');
	$T['AD']['3']['5']['1']['cont'] = $I18nObj->getI18nEntry('t3_l5');
	
	$T['AD']['3']['1']['2']['cont'] = "<input type='text' name='UserProfileForm[perso_nom]' value='".			$UserObj->getUserEntry('user_perso_nom')		."' size='30' maxlength='255' class='".$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['3']['2']['2']['cont'] = "<input type='text' name='UserProfileForm[perso_pays]' value='".			$UserObj->getUserEntry('user_perso_pays')		."' size='30' maxlength='255' class='".$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['3']['3']['2']['cont'] = "<input type='text' name='UserProfileForm[perso_ville]' value='".			$UserObj->getUserEntry('user_perso_ville')		."' size='30' maxlength='255' class='".$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['3']['4']['2']['cont'] = "<input type='text' name='UserProfileForm[perso_occupation]' value='".	$UserObj->getUserEntry('user_perso_occupation')	."' size='30' maxlength='255' class='".$Block."_t3 ".$Block."_form_1'>";
	$T['AD']['3']['5']['2']['cont'] = "<input type='text' name='UserProfileForm[perso_interet]' value='".		$UserObj->getUserEntry('user_perso_interet')	."' size='30' maxlength='255' class='".$Block."_t3 ".$Block."_form_1'>";
// --------------------------------------------------------------------------------------------

	$T['AD']['4']['1']['1']['cont'] = $I18nObj->getI18nEntry('t4_l1');
	$T['AD']['4']['2']['1']['cont'] = $I18nObj->getI18nEntry('t4_l2');
	$T['AD']['4']['3']['1']['cont'] = $I18nObj->getI18nEntry('t4_l3');
	$T['AD']['4']['4']['1']['cont'] = $I18nObj->getI18nEntry('t4_l4');
	$T['AD']['4']['5']['1']['cont'] = $I18nObj->getI18nEntry('t4_l5');
	$T['AD']['4']['6']['1']['cont'] = $I18nObj->getI18nEntry('t4_l6');
	$T['AD']['4']['7']['1']['cont'] = $I18nObj->getI18nEntry('t4_l7');
	$T['AD']['4']['8']['1']['cont'] = $I18nObj->getI18nEntry('t4_l8');
	$T['AD']['4']['9']['1']['cont'] = $I18nObj->getI18nEntry('t4_l9');
	
	// TSO = $TableSelectOptions
	$TSO = array(
			0	=>	array (
				"A"	=>	"<option value='0' ",
				"B"	=>	">".$I18nObj->getI18nEntry('uni')[0]."</option>\r",
			),
			1	=>	array (
				"A"	=>	"<option value='0' ",
				"B"	=>	">".$I18nObj->getI18nEntry('uni')[1]."</option>\r",
			),
	);
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_newsletter')]['s'] = "selected";
	$T['AD']['4']['1']['2']['cont'] = "<select name='UserProfileForm[pref_newsletter]' class='" . $Block."_t3 " . $Block."_form_1'>\r
	".
	$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B'].
	$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B'].
	"</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_montre_email')]['s'] = "selected";
	$T['AD']['4']['2']['2']['cont'] = "<select name='UserProfileForm[pref_montre_email]' class='" . $Block."_t3 " . $Block."_form_1'>\r 
	".
	$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B'].
	$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B'].
	"</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_montre_status_online')]['s'] = "selected";
	$T['AD']['4']['3']['2']['cont'] = "<select name='UserProfileForm[pref_montre_status_online]' class='" . $Block."_t3 " . $Block."_form_1'>\r 
	".
	$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B'].
	$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B'].
	"</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_notification_reponse_forum')]['s'] = "selected";
	$T['AD']['4']['4']['2']['cont'] = "<select name='UserProfileForm[pref_notification_reponse_forum]' class='" . $Block."_t3 " . $Block."_form_1'>\r
	".
	$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B'].
	$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B'].
	"</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_notification_nouveau_pm')]['s'] = "selected";
	$T['AD']['4']['5']['2']['cont'] = "<select name='UserProfileForm[pref_notification_nouveau_pm]' class='" . $Block."_t3 " . $Block."_form_1'>\r
	".
	$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B'].
	$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B'].
	"</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_autorise_bbcode')]['s'] = "selected";
	$T['AD']['4']['6']['2']['cont'] = "<select name='UserProfileForm[pref_autorise_bbcode]' class='" . $Block."_t3 " . $Block."_form_1'>\r 
	".
	$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B'].
	$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B'].
	"</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_autorise_html')]['s'] = "selected";
	$T['AD']['4']['7']['2']['cont'] = "<select name='UserProfileForm[pref_autorise_html]' class='" . $Block."_t3 " . $Block."_form_1'>\r
	".
	$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B'].
	$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B'].
	"</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_autorise_smilies')]['s'] = "selected";
	$T['AD']['4']['8']['2']['cont'] = "<select name='UserProfileForm[pref_autorise_smilies]' class='" . $Block."_t3 " . $Block."_form_1'>\r
	".
	$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B'].
	$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B'].
	"</select>\r";
	
	
	$T['AD']['4']['9']['2']['cont'] = "<select name='UserProfileForm[lang]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
	$dbqueryL = $SDDMObj->query("
	SELECT sl.lang_id FROM ".$SqlTableListObj->getSQLTableName('language_website')." sl , ".$SqlTableListObj->getSQLTableName('website')." s 
	WHERE s.ws_id ='".$WebSiteObj->getWebSiteEntry('ws_id')."' 
	AND sl.ws_id = s.ws_id
	;");
	$langList= array();
	while ($dbpL = $SDDMObj->fetch_array_sql($dbqueryL)) { $langList[$dbpL['lang_id']]['support'] = 1; }
	if ( $PmListTheme['user_lang'] == 0 ) { $langList[$WebSiteObj->getWebSiteEntry('ws_lang')]['s'] = " selected "; }
	else { $langList[$PmListTheme['user_lang']]['s'] = " selected "; }
	foreach ( $langList as $A ) { 
		if ( $A['support'] == 1 ) {
			$T['AD']['4']['9']['2']['cont'] .= "<option value='".$A['lang_639_3']."' ".$A['s']."> ".$A['lang_original_name']." </option>\r"; 
		}
	}
	$T['AD']['4']['9']['2']['cont'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
	$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 10, 4);
	$T['ADC']['onglet'] = array(
			1	=>	$RenderTablesObj->getDefaultTableConfig(3,2,2),
			2	=>	$RenderTablesObj->getDefaultTableConfig(6,2,2),
			3	=>	$RenderTablesObj->getDefaultTableConfig(5,2,2),
			4	=>	$RenderTablesObj->getDefaultTableConfig(9,2,2),
	);
	$Content .= $RenderTablesObj->render($infos, $T);
	
	
	$Content .= "
	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto; padding:8px'>
	<tr>\r
	<td style='width: ".($RenderLayoutObj->getLayoutModuleEntry($infos['module_name'], 'dim_y_ex22' ) - 200)."px;'>\r
	<input type='checkbox' name='UserProfileForm[confirmation_modification]' checked> ".$I18nObj->getI18nEntry('text_confirm1')."\r
	</td>\r
	<td style='width: 200px;'>\r
	";
	
	$SB = array(
			"id"				=> "UpdateButton",
			"type"				=> "submit",
			"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
			"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
			"onclick"			=> "",
			"message"			=> $I18nObj->getI18nEntry('modif_profil'),
			"mode"				=> 0,
			"size" 				=> 0,
			"lastSize"			=> 0,
	);
	$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
	
	$Content .= "
	</td>\r
	</tr>\r
	</table>\r
	<hr>\r

	<input type='hidden' name='UserProfileForm[login]'		value='".$UserObj->getUserEntry('user_login')."'>\r
	<input type='hidden' name='UPDATE_action'				value='UPDATE_USER'>\r

	<input type='hidden' name='WM_GP_phase' value='1'>\r".
	$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
	$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
	$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
	$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page').
	"</form>\r
	";
	
// --------------------------------------------------------------------------------------------
//	Affichage du theme selectionné
// --------------------------------------------------------------------------------------------
	unset ($T);
	$T = array();
	if ( strlen($RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedTheme')) == 0 ) { 
		$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "No requested theme in the form, using the main theme."));
		$RequestDataObj->setRequestDataSubEntry('UserProfileForm', 'SelectedTheme', $ThemeDataObj->getThemeDataEntry('theme_name') );
	}
	$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "Requested theme =`".$RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedTheme')."`"));
	
	$dbquery = $SDDMObj->query("
	SELECT * 
	FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')." a , ".$SqlTableListObj->getSQLTableName('theme_website')." b 
	WHERE a.theme_name = '".$RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedTheme')."' 
	AND a.theme_id = b.theme_id 
	;");
// 	$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "
// 	SELECT *
// 	FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')." a , ".$SqlTableListObj->getSQLTableName('theme_website')." b
// 	WHERE a.theme_name = '".$RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedTheme')."'
// 	AND a.theme_id = b.theme_id
// 	;");
	
	$Content .= "<p>".$I18nObj->getI18nEntry('text_choix_theme')."<br>\r</p>\r";
	
	$PmThemeName = "PM_";
	$PmThemeDescriptorObj = new ThemeDescriptor();
	$PmThemeDataObj = new ThemeData();

	$PmThemeDescriptorObj->getThemeDescriptorDataFromDB($PmThemeName, $UserObj, $WebSiteObj);
	$PmThemeDataObj->setThemeData($PmThemeDescriptorObj->getThemeDescriptor()); //Better to give an array than the object itself.
	$PmThemeDataObj->setThemeName($PmThemeName);
	$PmThemeDataObj->setDecorationListFromDB();
	$PmThemeDataObj->renderBlockData();
	$PmThemeDataObj->setThemeDataEntry('theme_module_largeur_interne', $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne'));
	
	$CurrentSetObj->backupInstanceOfThemeDataObj();
	$CurrentSetObj->setInstanceOfThemeDataObj($PmThemeDataObj);
	
	
	$Content .= $RenderStylesheetObj->render($PmThemeName, $PmThemeDataObj );
	$iconList = array ('icone_repertoire','icone_efface','icone_gauche','icone_droite','icone_haut','icone_bas','icone_ok','icone_nok','icone_question','icone_notification');

	$ListThemeBlock= array();
	for ( $i = 1; $i < 31; $i++ ) {
		$TmpBlockEntry = "theme_bloc_".$StringFormatObj->getDecorationBlockName("", $i, "")."_nom";
		$TmpBlockName = $PmThemeDescriptorObj->getThemeDescriptorEntry($TmpBlockEntry);
// 		$TmpBlock = $PmThemeDataObj->getThemeData($TmpBlockName);
		if ( strlen($TmpBlockName) > 0 ) {
			$err = 0;
			foreach ( $ListThemeBlock as $A) {
				if ($A['nom'] == $TmpBlockName) { $err = 1; }
			}
			if ( $err == 0 ) {
				$ListThemeBlock[$TmpBlockEntry]['nom'] = $TmpBlockName;
				$ListThemeBlock[$TmpBlockEntry]['pos'] = $i;
			}
		}
	}

	for ( $i = 1; $i < (count($ListThemeBlock)+2); $i++ ) {
		$I18nObj->setI18nEntry('tabTxtThm'.$i, "#".$i);
		$T['ADC']['onglet'][$i] = $RenderTablesObj->getDefaultTableConfig(1,1,0);
	}
	$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 20, count($ListThemeBlock)+1,1,0,'tabTxtThm');
	$T['tab_infos']['GroupName']		= "theme";
	$T['tab_infos']['Height']			= 1024;
	
	$PmThemeDataObj->setThemeDataEntry('pathThemeBg', "../gfx/".$PmThemeDataObj->getThemeDataEntry('theme_directory')."/".$PmThemeDataObj->getThemeDataEntry('theme_bg'));
	$PmThemeDataObj->setThemeDataEntry('pathThemeDivInitialBg', "../gfx/".$PmThemeDataObj->getThemeDataEntry('theme_directory')."/".$PmThemeDataObj->getThemeDataEntry('theme_divinitial_bg'));
	$ModulePaddingX = 64;
	$ModulePaddingY = 64;
// 	$LMObj->logDebug($PmThemeDataObj->getThemeData(), "PmThemeDataObj");
	
	$infos['module_nameBackup']	= $infos['module_name'];
	$infos['blockBackup']		= $infos['block']; 
	$infos['blockGBackup']		= $infos['blockG']; 
	$infos['blockTBackup']		= $infos['blockT']; 
	
	$Tab = 1;
	unset ( $A );
	foreach ( $ListThemeBlock as $A ) {
		$infos['block']		= $StringFormatObj->getDecorationBlockName("B", $A['pos'] , "");
		$infos['blockG']	= $infos['block']."G";
		$infos['blockT']	= $infos['block']."T";
		$PmBlock = $PmThemeDataObj->getThemeName().$infos['block'];
		
		// As the class RenderLayout is a singleton (and it's better like that), we insert the necessary module data (X,Y) into the dataset for later use in RenderDecoXXXX classes.
		// We know the RenderDeco classes are provisionned.
		$mn = "MpBlock0".$Tab;
		$BlockDataTmp = array(
				'px'	=>	$ModulePaddingX / 2 ,
				'py'	=>	$ModulePaddingY / 2 ,
				'dx'	=>	($T['tab_infos']['Width'] - $ModulePaddingX -32),
				'dy'	=>	($T['tab_infos']['Height'] - $ModulePaddingY)
		);
		$RenderLayoutObj->setLayoutEntry($mn, $BlockDataTmp);
		$infos['module']['module_name'] = $mn;
		
		$T['AD'][$Tab]['1']['1']['cont'] .= "
		<div style='
		background-image: url(".$PmThemeDataObj->getThemeDataEntry('pathThemeBg')."); background-color: ".$PmThemeDataObj->getThemeDataEntry('theme_bg_color').";
		width: ".($T['tab_infos']['Width']-32)."px; height: ".($T['tab_infos']['Height']-32)."px;
		'>
		<div style='
		position: absolute; background-image: url(".$PmThemeDataObj->getThemeDataEntry('pathThemeDivInitialBg')."); 
		width: ".($T['tab_infos']['Width']-32)."px; height: ".($T['tab_infos']['Height']-32)."px;
		'>
		";
		
		// Brutal !! but efficient.
		$ClassLoaderObj->provisionClass('RenderDeco10Menu');
		$ClassLoaderObj->provisionClass('RenderDeco20Caligraph');
		$ClassLoaderObj->provisionClass('RenderDeco301Div');
		$ClassLoaderObj->provisionClass('RenderDeco40Elegance');
		$ClassLoaderObj->provisionClass('RenderDeco50Exquisite');
		$ClassLoaderObj->provisionClass('RenderDeco60Elysion');
		
		switch ($PmThemeDataObj->getThemeBlockEntry($infos['blockG'], 'deco_type')){
			case 30:	case "1_div":		$RenderDeco = RenderDeco301Div::getInstance();			$decoTmp = $RenderDeco->render($infos);		break;
			case 40:	case "elegance":	$RenderDeco = RenderDeco40Elegance::getInstance();		$decoTmp = $RenderDeco->render($infos);		break;
			case 50:	case "exquise":		$RenderDeco = RenderDeco50Exquisite::getInstance();		$decoTmp = $RenderDeco->render($infos);		break;
			case 60:	case "elysion":		$RenderDeco = RenderDeco60Elysion::getInstance();		$decoTmp = $RenderDeco->render($infos);		break;
			default:	$decoTmp = "<div id='".$mn."' class='" . $PmBlock."_div_std' style='position:absolute; left:".$RenderLayoutObj->getLayoutModuleEntry($mn, 'px')."px; top:".$RenderLayoutObj->getLayoutModuleEntry($mn, 'py')."px; width:".$RenderLayoutObj->getLayoutModuleEntry($mn, 'dx')."px; height:".$RenderLayoutObj->getLayoutModuleEntry($mn, 'dy')."px; '>\r";		break;
		}
		$T['AD'][$Tab]['1']['1']['cont'] .= $decoTmp;
		
		
		$PmThemeDataObj->setThemetBlockEntry($infos['blockT'], 'ttd', "
		<table style='height:".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'deco_ft_y')."px;' border='0' cellspacing='0' cellpadding='0'>\r
		<tr>\r
		<td style='width:".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'deco_ft1_x')."px;	background-image: url(../gfx/".$PmThemeDataObj->getThemeDataEntry('theme_directory')."/".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'deco_ft1').");'></td>\r
		<td style='background-image: url(../gfx/".$PmThemeDataObj->getThemeDataEntry('theme_directory')."/".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'deco_ft2').");'>\r
		<span class='".$PmBlock."_tb4' style='color:".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'deco_txt_titre_col').";'>\r
		");

		$PmThemeDataObj->setThemetBlockEntry($infos['blockT'], 'ttf', "
		</span>\r
		</td>\r
		<td style='width:".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'deco_ft3_x')."px;	background-image: url(../gfx/".$PmThemeDataObj->getThemeDataEntry('theme_directory')."/".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'deco_ft3').");'></td>\r
		</tr>\r
		</table>\r
		");

		$T['AD'][$Tab]['1']['1']['cont'] .= $PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'ttd')."Lorem Ipsum".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'ttf')."<br>\r";

		if ( $Tab == 1 ) {
			$T['AD'][$Tab]['1']['1']['cont'] .= "
			<form ACTION='index.php?' method='post'>\r
			<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto; '>
			<tr>\r
			<td class='".$PmBlock."_t3'>\r
			Je veux 
			<select name='UPDATE_action' class='".$PmBlock."_t3 ".$PmBlock."_form_1'>\r
			<option value='AUCUNE'>Voir</option>\r
			<option value='UPDATE_USER'>Activer</option>\r
			</select>\r
			le th&egrave;me 
			<select name='UserProfileForm[SelectedThemeId]' class='".$PmBlock."_t3 ".$PmBlock."_form_1'>\r
			";
			
			$dbquery = $SDDMObj->query("
			SELECT a.theme_id,a.theme_name,theme_title 
			FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')." a , ".$SqlTableListObj->getSQLTableName('theme_website')." b
			WHERE a.theme_id = b.theme_id  
			AND b.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
			;");
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
				if ( $dbp['theme_id'] == $RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedThemeId') ) { $T['AD'][$Tab]['1']['1']['cont'] .= "<option value='".$dbp['theme_id']."' selected>".$dbp['theme_title']."</option>\r"; }
				else { $T['AD'][$Tab]['1']['1']['cont'] .= "<option value='".$dbp['theme_id']."'>".$dbp['theme_title']."</option>\r"; }
			}
			
			$T['AD'][$Tab]['1']['1']['cont'] .= "
			</select>\r
			</td>\r
			<td>\r
			";
			
			$SB = array(
					"id"				=> "refreshButton",
					"type"				=> "submit",
					"initialStyle"		=> $PmBlock."_t3 ".$PmBlock."_submit_s2_n",
					"hoverStyle"		=> $PmBlock."_t3 ".$PmBlock."_submit_s2_h",
					"onclick"			=> "",
					"message"			=> $I18nObj->getI18nEntry('btn1'),
					"mode"				=> 0,
					"size" 				=> 0,
					"lastSize"			=> 0,
			);
			$T['AD'][$Tab]['1']['1']['cont'] .=  $InteractiveElementsObj->renderSubmitButton($SB);
			
			$T['AD'][$Tab]['1']['1']['cont'] .= "
			</td>\r
			</tr>\r
			</table>\r".
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page').
			"
			<input type='hidden' name='UserProfileForm[login]'						value='".$user['login_decode']."'>\r
			<input type='hidden' name='UserProfileForm[confirmation_modification]'	value='1'>\r
			</form>\r
			<hr>\r
			";
		}
		$T['AD'][$Tab]['1']['1']['cont'] .= "
		<p class='".$PmBlock."_t3'>\r
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". <br>\r
		<br>\r
		<a class='".$PmBlock."_lien ".$PmBlock."_t3'>Exemple de lien simple</a><br>\r
		<br>\r
		<input type='text' name='WM_GP_exemple01' value='Lorem ipsum dolor sit amet, consectetur adipiscing elit' size='25' maxlength='255' class='".$PmBlock."_form_1 ".$PmBlock."_t3'><br>\r
		<br>\r
		<input type='text' name='WM_GP_exemple02' value='Lorem ipsum dolor sit amet, consectetur adipiscing elit' size='25' maxlength='255' class='".$PmBlock."_form_2 ".$PmBlock."_t3'><br>\r
		<br>\r
		</p>

		<table style='margin-left:auto; margin-right:auto;'>\r
		<tr>\r
		<td>\r

		<p align='left' class='".$PmBlock."_code'>
		<code class='".$PmBlock."_code ".$PmBlock."_t3'>
		/* Lorem ipsum dolor sit amet, consectetur adipiscing elit */<br>\r
		#include &lt;stdio.h&gt;<br>\r
		#include &lt;mylib.h&gt;<br>\r
		#include &lt;hislib.h&gt;<br>\r
		#include &lt;theirlib.h&gt;<br>\r
		main ()<br>\r
		{<br>\r
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;printf ('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');<br>\r
		}<br>\r
		</code>\r
		</p>\r
		</td>\r

		<td>\r
		<table>\r
		<tr>\r
		<td class='".$PmBlock."_fcta ".$PmBlock."_t3' colspan='2'>\r Lorem ipsum dolor sit amet, consectetur adipiscing elit (A)  </td>\r
		<td class='".$PmBlock."_fctb ".$PmBlock."_t3' colspan='2'>\r Lorem ipsum dolor sit amet, consectetur adipiscing elit (B)</td>\r
		</tr>\r
		<tr>\r
		<td class='".$PmBlock."_fca ".$PmBlock."_t3'>\r Lorem ipsum.  a </td>\r
		<td class='".$PmBlock."_fcb ".$PmBlock."_t3'>\r Lorem ipsum.  b </td>\r
		<td class='".$PmBlock."_fcc ".$PmBlock."_t3'>\r Lorem ipsum.  c </td>\r
		<td class='".$PmBlock."_fcd ".$PmBlock."_t3'>\r Lorem ipsum.  d </td>\r
		</tr>\r
		<tr>\r
		<td class='".$PmBlock."_fca ".$PmBlock."_t3' colspan='4'>\r
		<a class='".$PmBlock."_lien ".$PmBlock."_t3'>Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br>\r
		<br>\r
		<input type='text' name='WM_GP_exemple01' value='Lorem ipsum dolor sit amet, consectetur adipiscing elit' size='25' maxlength='255' class='".$PmBlock."_form_1 ".$PmBlock."_t3'><br>\r
		<br>\r
		<input type='text' name='WM_GP_exemple02' value='Lorem ipsum dolor sit amet, consectetur adipiscing elit' size='25' maxlength='255' class='".$PmBlock."_form_2 ".$PmBlock."_t3'><br>\r

		</td>\r
		</tr>\r
		</table>\r
		</td>\r
		</tr>\r
		</table>\r
		";
		
		$PmIcon = array();
		$j = 0;
		reset ($iconList);
		foreach ( $iconList as $A ) {
			if ( strlen($PmThemeDataObj->getThemeBlockEntry($infos['blockT'],$A)) != 0 ) {
				$PmIcon[$j] = "background-image: url(../gfx/".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'repertoire')."/".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],$A).");";
			}
			$j++;
		}

		$maxCells = 3;
		$maxLines = 4;
		$lineCount = 1;
		$pv['icone_div_taille'] = floor($PmThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/4)-8 ;
		if ( $pv['icone_div_taille'] > 128 ) { $pv['icone_div_taille'] = 128; }
		$j = 0;
		$T['AD'][$Tab]['1']['1']['cont'] .= "<table style='margin-left:auto; margin-right:auto;' border='0' >\r";
		for ( $lineCount = 1 ; $lineCount <= $maxLines ; $lineCount++ ) {
			$T['AD'][$Tab]['1']['1']['cont'] .= "<tr>";
			for ( $cellCount = 1 ; $cellCount <= $maxCells ; $cellCount++ ) {
				$T['AD'][$Tab]['1']['1']['cont'] .= "<td style='
				width: 136px; height: 136px; 
				border-style: solid; border-width: 1px; border-color: #000000;'>\r
				<div style='
				width: ".$pv['icone_div_taille']."px; height: ".$pv['icone_div_taille']."px;
				margin:auto; 
				background-repeat: no-repeat; background-position:center; 
				".$PmIcon[$j]."'></div>\r
				</td>\r
				";
				$j++;
			}
			$T['AD'][$Tab]['1']['1']['cont'] .= "</tr>";
		}
		$T['AD'][$Tab]['1']['1']['cont'] .= "
		</table>\r
		</div>\r
		<!-- Fin de bloc -->\r
		";
		$Tab++;
	
	}
	
	
	$mn = "MpBlock0".$Tab;
	$BlockDataTmp = array(
			'px'	=>	$ModulePaddingX / 2 ,
			'py'	=>	$ModulePaddingY / 2 ,
			'dx'	=>	($T['tab_infos']['Width'] - $ModulePaddingX),
			'dy'	=>	($T['tab_infos']['Height'] - $ModulePaddingY)
	);
	$RenderLayoutObj->setLayoutEntry($mn, $BlockDataTmp);
	
	
	$T['AD'][$Tab]['1']['1']['cont'] .= "
	<div style='
	background-image: url(".$PmThemeDataObj->getThemeDataEntry('pathThemeBg')."); background-color: ".$PmThemeDataObj->getThemeDataEntry('theme_bg_color').";
	width: ".($T['tab_infos']['Width']-32)."px; height: ".($T['tab_infos']['Height']-64)."px;
	'>
	<div style='
	position: absolute; background-image: url(".$PmThemeDataObj->getThemeDataEntry('pathThemeDivInitialBg')."); 
	width: ".($T['tab_infos']['Width']-32)."px; height: ".($T['tab_infos']['Height']-64)."px;
	'>
	";

// --------------------------------------------------------------------------------------------
//
//	Last tabs showing the specific items.
//
//
	$T['AD'][$Tab]['1']['1']['cont'] .="<!-- Last tabs showing the specific items. -->\r";
	$j = 0;
	$themeDir = $PmThemeDataObj->getThemeBlockEntry('B01T', 'repertoire');
	$themeList = array ('theme_logo', 'theme_banner');
	$themeEntries = array();
	foreach ( $themeList as $A ) {
		if (strlen($PmThemeDataObj->getThemeDataEntry($A)) != 0) {
			$themeEntries[$j] = "background-image: url(../gfx/".$themeDir."/".$PmThemeDataObj->getThemeDataEntry($A).");";
			$j++;
		}
	}
	
	$NbrElmFound = $j;
	$maxCells = 1;
	$maxLines = 5;
	$j = 0;
	$T['AD'][$Tab]['1']['1']['cont'] .= "<table style='margin-left:auto; margin-right:auto;' border='0' >\r";
	for ( $lineCount = 1 ; $lineCount <= $maxLines ; $lineCount++ ) {
		$T['AD'][$Tab]['1']['1']['cont'] .= "<tr>";
		for ( $cellCount = 1 ; $cellCount <= $maxCells ; $cellCount++ ) {
			if ( $j < $NbrElmFound )  {
				$T['AD'][$Tab]['1']['1']['cont'] .= "
				<td>\r	
				<div style='background-repeat: no-repeat; background-position:center; ".$themeEntries[$j]." width: ".(floor(($T['tab_infos']['Width']-48)/$maxCells))."px; height: ".(floor($RenderLayoutObj->getLayoutModuleEntry($mn, 'dy')/$maxLines))."px;'></div>\r
				</td>\r";
				$j++;
			}
		}
		$T['AD'][$Tab]['1']['1']['cont'] .= "</tr>";
	}
	$infos['module_name']	= $infos['module_nameBackup']; 
	$infos['block']			= $infos['blockBackup'];
	$infos['blockG']		= $infos['blockGBackup'];
	$infos['blockT']		= $infos['blockTBackup'];
	
	$T['AD'][$Tab]['1']['1']['cont'] .= "
	</table>\r

	</div>\r
	</div>\r
	<br>\r
	</p>
	";
	$T['ADC']['onglet'][$Tab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$Tab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$Tab]['legende'] = 0;
	$CurrentSetObj->restoreInstanceOfThemeDataObj();
	$Content .= $RenderTablesObj->render($infos, $T);
	
	$LMObj->setInternalLogTarget($logTarget);
	
// --------------------------------------------------------------------------------------------
}

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
