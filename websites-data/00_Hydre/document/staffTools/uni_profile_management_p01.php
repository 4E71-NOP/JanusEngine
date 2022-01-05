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
/* @var $ClassLoaderObj ClassLoader                 *x/

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

// --------------------------------------------------------------------------------------------
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'profileManagement',
				'section'		=> 'BrowseThemeForm',
				// 'creation'		=> 'on',
				'modification'	=> 'on',
				// 'deletion'		=> 'on',
				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
	);

	$bts->RequestDataObj->setRequestData('browseTheme', 
	array(
		"theme_id"			=>	3748884111131853825,
		"theme_name"		=>	"hydr_magma_01",
	)
);


$bts->RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*Hydr-Content-Begin*/
$localisation = " / uni_profile_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_profile_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_profile_management_p01.php");

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
		"anonDeny"		=>	"Partie reservée aux membres enregistrés",
		"invite1"		=>	"Cette partie va vous permettre de gérer les journaux d'évennement.",
		"col_1_txt"		=>	"Id",
		"col_2_txt"		=>	"Date",
		"col_3_txt"		=>	"Signal",
		"col_4_txt"		=>	"Id Msg",
		"col_5_txt"		=>	"Initiateur",
		"col_6_txt"		=>	"Action",
		"col_7_txt"		=>	"Message",
		"tabTxt1"		=>	"Compte",
		"tabTxt2"		=>	"Preferences",
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
		"t1_login"	=>	"Identifiant",
		"t1_mail"	=>	"Email",
		"t1_avatar"	=>	"Avatar",
		"t1_upload"	=>	"Téléchargement",
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
		"formIwantTo"			=>	"Je veux ",
		"formIwantToSee"		=>	"voir",
		"formIwantToActivate"	=>	"activer",
		"formTheTheme"			=>	"le thème",
		),
		"eng" => array(
		"anonDeny"		=>	"Partie reservée aux membres enregistrés",
		"invite1"		=>	"This part will allow you to manage Logs.",
		"col_1_txt"		=>	"Id",
		"col_2_txt"		=>	"Date",
		"col_3_txt"		=>	"Signal",
		"col_4_txt"		=>	"Id Msg",
		"col_5_txt"		=>	"Initiator",
		"col_6_txt"		=>	"Action",
		"col_7_txt"		=>	"Message",
		"tabTxt1"		=>	"Compte",
		"tabTxt2"		=>	"Préférences",
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
		"t1_login"	=>	"Login",
		"t1_mail"	=>	"Email",
		"t1_avatar"	=>	"Avatar",
		"t1_upload"	=>	"Upload",
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
		"formIwantTo"			=>	"I want to ",
		"formIwantToSee"		=>	"see",
		"formIwantToActivate"	=>	"activate",
		"formTheTheme"			=>	"the theme",
		)
	)
);

$UserObj = $CurrentSetObj->getInstanceOfUserObj();
if ( $UserObj->getUserEntry('user_login') == "anonymous" ) { $Content .= $bts->I18nTransObj->getI18nTransEntry("anonDeny"); }
else {
// --------------------------------------------------------------------------------------------
//	Debut du formulaire
// --------------------------------------------------------------------------------------------
	$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r<br>\r";
	
	if ( $bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'uploadError') == 1 ) {
		$Content .= "<p class='" . $Block._CLASS_TXT_WARNING_."'>".$bts->I18nTransObj->getI18nTransEntry('AvatarUploadError')[$bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'AvatarUploadError')]."</p>\r<br>\r";
	}
	
	if ( $bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'confirmation_modification_oubli') == 'on' ) { 
		$Content .= "<p class='".$Block._CLASS_TXT_ERROR_."'>".$bts->I18nTransObj->getI18nTransEntry('confirmation_modification_oubli')."</p>\r<br>\r"; 
	}
	
	$Content .= "<br>\r
	<form enctype='multipart/form-data' ACTION='index.php?' method='post' name='UserProfileForm'>\r

	<input type='hidden' name='formSubmitted'					value='1'>
	<input type='hidden' name='formGenericData[origin]'			value='profileManagement'>
	<input type='hidden' name='formGenericData[section]'		value='UserProfileForm'>
	<input type='hidden' name='formGenericData[modification]'	value='on'>
	<input type='hidden' name='formEntity'						value='User'>
	<input type='hidden' name='formTarget[name]'				value='".$UserObj->getUserEntry('user_login')."'>\r
	";

	$userPrefthemeId = $WebSiteObj->getWebSiteEntry('fk_theme_id');
	if ( $UserObj->getUserEntry('pref_theme') != 0 ) { $userPrefthemeId = $UserObj->getUserEntry('pref_theme'); }
	$dbquery = $bts->SDDMObj->query("
	SELECT u.*,td.theme_name,td.theme_id
	FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')." u , "
	.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor')." td 
	WHERE u.user_id = '".$UserObj->getUserEntry('user_id')."' 
	AND td.theme_id = '".$userPrefthemeId."' 
	;");
	$PmListTheme = array();
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { foreach ( $dbp as $A => $B ) { $PmListTheme[$A] = $B; } }
	
// --------------------------------------------------------------------------------------------
//	Informations internet
// --------------------------------------------------------------------------------------------
	$FileSelectorConfig = array(
			"width"				=> 80,	//in %
			"height"			=> 50,	//in %
			"formName"			=> "UserProfileForm",
			"formTargetId"		=> "UserProfileForm[user_avatar_image]",
			"formInputSize"		=> 40 ,
			"formInputVal"		=> $UserObj->getUserEntry('user_avatar_image'),
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
	$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_login');
	$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_mail');
	$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_avatar');
	$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_upload');
	
	$T['Content']['1']['1']['2']['cont'] = "<input type='text' name='formParams[login]' value='".$UserObj->getUserEntry('user_login')."' size='15' maxlength='255' disabled>";
	$T['Content']['1']['2']['2']['cont'] = "<input type='text' name='formParams[user_email]'	value='".	$UserObj->getUserEntry('user_email')	."' size='30' maxlength='255'>";
	
	if ( strlen($PmListTheme['user_avatar_image']) != 1024 ) { $T['Content']['1']['3']['2']['cont'] = "<img src='".$PmListTheme['user_avatar_image']."' width='48' height='48' alt='[Avatar]'>"; }
	else { $T['Content']['1']['3']['2']['cont'] = "N/A"; }
	$T['Content']['1']['3']['2']['cont'] .=	$bts->InteractiveElementsObj->renderIconSelectFile($infos);
	$T['Content']['1']['4']['2']['cont'] = "<input type='hidden' name='MAX_FILE_SIZE' value='32768'> 
	<input type='file' name='formParams[AvatarSelectedFile]' size='40'>";

	// --------------------------------------------------------------------------------------------
	$T['Content']['2']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l1');
	$T['Content']['2']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l2');
	$T['Content']['2']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l3');
	$T['Content']['2']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l4');
	$T['Content']['2']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l5');
	$T['Content']['2']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l6');
	$T['Content']['2']['7']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l7');
	$T['Content']['2']['8']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l8');
	$T['Content']['2']['9']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l9');
	
	// TSO = $TableSelectOptions
	$TSO = array(
			0	=>	array (
				"A"	=>	"<option value='0' ",
				"B"	=>	">".$bts->I18nTransObj->getI18nTransEntry('uni')[0]."</option>\r",
			),
			1	=>	array (
				"A"	=>	"<option value='0' ",
				"B"	=>	">".$bts->I18nTransObj->getI18nTransEntry('uni')[1]."</option>\r",
			),
	);
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_newsletter')]['s'] = "selected";
	$T['Content']['2']['1']['2']['cont'] = "<select name='formParams[pref_newsletter]'>\r"
	.$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B']
	.$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B']
	."</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_show_email')]['s'] = "selected";
	$T['Content']['2']['2']['2']['cont'] = "<select name='formParams[pref_montre_email]'>\r "
	.$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B']
	.$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B']
	."</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_show_online_status')]['s'] = "selected";
	$T['Content']['2']['3']['2']['cont'] = "<select name='formParams[pref_montre_status_online]'>\r "
	.$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B']
	.$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B']
	."</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_forum_notification')]['s'] = "selected";
	$T['Content']['2']['4']['2']['cont'] = "<select name='formParams[pref_notification_reponse_forum]'>\r"
	.$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B']
	.$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B']
	."</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_forum_pm')]['s'] = "selected";
	$T['Content']['2']['5']['2']['cont'] = "<select name='formParams[pref_notification_nouveau_pm]'>\r"
	.$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B']
	.$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B']
	."</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_allow_bbcode')]['s'] = "selected";
	$T['Content']['2']['6']['2']['cont'] = "<select name='formParams[pref_autorise_bbcode]'>\r "
	.$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B']
	.$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B']
	."</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_allow_html')]['s'] = "selected";
	$T['Content']['2']['7']['2']['cont'] = "<select name='formParams[pref_autorise_html]'>\r"
	.$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B']
	.$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B']
	."</select>\r";
	
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_autorise_smilies')]['s'] = "selected";
	$T['Content']['2']['8']['2']['cont'] = "<select name='formParams[pref_autorise_smilies]'>\r"
	.$TSO['0']['A'].$TSO['0']['s'].$TSO['0']['B']
	.$TSO['1']['A'].$TSO['1']['s'].$TSO['1']['B']
	."</select>\r";
	
	$T['Content']['2']['9']['2']['cont'] = "<select name='formParams[lang]'>\r";
	$dbqueryL = $bts->SDDMObj->query("
		SELECT lw.fk_lang_id FROM "
		.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language_website')." lw , "
		.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')." w 
		WHERE w.ws_id ='".$WebSiteObj->getWebSiteEntry('ws_id')."' 
		AND lw.fk_ws_id = w.ws_id
		;");
	$langList= array();
	while ($dbpL = $bts->SDDMObj->fetch_array_sql($dbqueryL)) { $langList[$dbpL['lang_id']]['support'] = 1; }
	if ( $PmListTheme['user_lang'] == 0 ) { $langList[$WebSiteObj->getWebSiteEntry('ws_lang')]['s'] = " selected "; }
	else { $langList[$PmListTheme['user_lang']]['s'] = " selected "; }
	foreach ( $langList as $A ) { 
		if ( $A['support'] == 1 ) {
			$T['Content']['2']['9']['2']['cont'] .= "<option value='".$A['lang_639_3']."' ".$A['s']."> ".$A['lang_original_name']." </option>\r"; 
		}
	}
	$T['Content']['2']['9']['2']['cont'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 2);
	$T['ContentCfg']['tabs'] = array(
			1	=>	$bts->RenderTablesObj->getDefaultTableConfig(4,2,2),
			2	=>	$bts->RenderTablesObj->getDefaultTableConfig(9,2,2),
	);
	$Content .= $bts->RenderTablesObj->render($infos, $T);
	
	$Content .= "
	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto; padding:8px'>
	<tr>\r
	<td style='width:70%;'>\r
	<input type='checkbox' name='formParams1[confirmation_modification]' checked> ".$bts->I18nTransObj->getI18nTransEntry('text_confirm1')."\r
	</td>\r
	<td style='width: 200px;'>\r
	";

	$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
		$infos , 'submit', 
		$bts->I18nTransObj->getI18nTransEntry('modif_profil'), 0, 
		'UpdateButton', 
		2, 2, 
		"",0 
	);
	$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
	
	$Content .= "
	</td>\r
	</tr>\r
	</table>\r
	<hr>\r
	
	</form>\r
	";
// 	<input type='hidden' name='WM_GP_phase' value='1'>\r".

// --------------------------------------------------------------------------------------------
//	Affichage du theme selectionné
// --------------------------------------------------------------------------------------------
	$themeList = array();
	$dbquery = $bts->SDDMObj->query("
		SELECT td.theme_id, td.theme_name, td.theme_title 
		FROM "
		.$SqlTableListObj->getSQLTableName('theme_descriptor')." td, "
		.$SqlTableListObj->getSQLTableName('theme_website')." tw 
		WHERE td.theme_id = tw.fk_theme_id  
		AND tw.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		ORDER BY td.theme_name
		;");
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$themeList[$dbp['theme_name']] = array(
			"theme_id"		=> $dbp['theme_id'],
			"theme_name"	=> $dbp['theme_name'],
			"theme_title"	=> $dbp['theme_title'],
		);
	}

	unset ($T);
	$T = array();
	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name')) == 0 ) { 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "No requested theme in the form, using the main theme."));
		$bts->RequestDataObj->setRequestDataSubEntry('browseTheme', 'theme_name', $ThemeDataObj->getThemeDataEntry('theme_name') );
		$bts->RequestDataObj->setRequestData('browseTheme', 
			array(
				"SelectedThemeId"	=>	$ThemeDataObj->getThemeDataEntry('theme_id'),
				"SelectedTheme"		=>	$ThemeDataObj->getThemeDataEntry('theme_name'),
			)
		);
	}
	$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Requested theme N=`".$bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name')."`"));
	
	$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('text_choix_theme')."</p>\r";
	
	$PmThemeDescriptorObj = new ThemeDescriptor();
	$PmThemeDescriptorObj->setCssPrefix('PM_');
	$PmThemeDataObj = new ThemeData();
	
	$PmThemeDataObj->setThemeName($PmThemeDescriptorObj->getCssPrefix());
	$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "get theme data with name :".$themeList[$bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedTheme')]['theme_name']." and id ".$themeList[$bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedTheme')]['theme_id']."."));
	$PmThemeDescriptorObj->getDataFromDB($themeList[$bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name')]['theme_id']);
	$PmThemeDataObj->setThemeData($PmThemeDescriptorObj->getThemeDescriptor()); //Better to give an array than the object itself.
	$PmThemeDataObj->setDecorationListFromDB();
	$PmThemeDataObj->renderBlockData();
	// $PmThemeDataObj->setThemeDataEntry('theme_module_internal_width', $ThemeDataObj->getThemeDataEntry('theme_module_internal_width'));
	
	$CurrentSetObj->backupInstanceOfThemeDataObj();
	$CurrentSetObj->setInstanceOfThemeDataObj($PmThemeDataObj);
	
	$ClassLoaderObj->provisionClass ( 'RenderStylesheet' );
	$RenderStylesheetObj = RenderStylesheet::getInstance ();
	$Content .= $RenderStylesheetObj->render($PmThemeDescriptorObj->getCssPrefix(), $PmThemeDataObj );
	
	$iconList = array ('icon_directory','icon_erase','icon_left','icon_right','icon_top','icon_bottom','icon_ok','icon_ko','icon_question','icon_notification');
	
	$ListThemeBlock= array();
	for ( $i = 1; $i < 31; $i++ ) {
		$TmpBlockEntry = "theme_block_".$bts->StringFormatObj->getDecorationBlockName("", $i, "")."_name";
		$TmpBlockName = $PmThemeDescriptorObj->getThemeDescriptorEntry($TmpBlockEntry);
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " processing : " . $TmpBlockName));
		if ( strlen($TmpBlockName) > 0 ) {
			$err = 0;
			foreach ( $ListThemeBlock as $A) {
				if ($A['name'] == $TmpBlockName) { $err = 1; }
			}
			if ( $err == 0 ) {
				$ListThemeBlock[$TmpBlockEntry]['name'] = $TmpBlockName;
				$ListThemeBlock[$TmpBlockEntry]['pos'] = $i;
			}
		}
	}

	for ( $i = 1; $i < (count($ListThemeBlock)+2); $i++ ) {
		$bts->I18nTransObj->setI18nTransEntry('tabTxtThm'.$i, "#".$i);
		$T['ContentCfg']['tabs'][$i] = $bts->RenderTablesObj->getDefaultTableConfig(1,1,0);
	}
	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 20, count($ListThemeBlock)+1,1,0,'tabTxtThm');
	$T['ContentInfos']['GroupName']		= "pm";
	$T['ContentInfos']['Height']		= 1024;
	$T['ContentInfos']['Height']		= 512;
	
	$PmThemeDataObj->setThemeDataEntry('pathThemeBg', $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$PmThemeDataObj->getThemeDataEntry('theme_directory')."/".$PmThemeDataObj->getThemeDataEntry('theme_bg'));
	//$PmThemeDataObj->setThemeDataEntry('pathThemeDivInitialBg', $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$PmThemeDataObj->getThemeDataEntry('theme_directory')."/".$PmThemeDataObj->getThemeDataEntry('theme_divinitial_bg'));
	$ModulePaddingX = $ModulePaddingY = 64;
	
	$infos['module_nameBackup']	= $infos['module_name'];
	$infos['blockBackup']		= $infos['block']; 
	$infos['blockGBackup']		= $infos['blockG']; 
	$infos['blockTBackup']		= $infos['blockT']; 

	$Tab = 1;
	unset ( $A );
	foreach ( $ListThemeBlock as $A ) {
		
		$currentBlock = $bts->StringFormatObj->getDecorationBlockName("B", $A['pos'] , "");
		$PmBlock = $PmThemeDataObj->getThemeName().$currentBlock;
		
		$mn = "MpBlock0".$Tab;
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " processing : " . $mn));

		$infosTmp = array(
			'module_name' => $mn,
			'block' => $currentBlock,
			'blockG' => $currentBlock . "G",
			'blockT' => $currentBlock . "T",
			'mode' => 1,
			'module' => array(
				'module_name' => $mn,
				'module_container_name' => "container_".$mn,
			),
		);
		$infosTmp['deco_type'] = $ThemeDataObj->getThemeBlockEntry($infosTmp['blockG'], 'deco_type');

		$T['Content'][$Tab]['1']['1']['cont'] .= "
		<div style='
		background-image: url(".$PmThemeDataObj->getThemeDataEntry('pathThemeBg')."); background-color: ".$PmThemeDataObj->getThemeDataEntry('theme_bg_color').";
		width: ".($T['ContentInfos']['Width']-32)."px; height: ".($T['ContentInfos']['Height']-32)."px;
		'>
		";
		
		// Brutal... But efficient!!!
		// $ClassLoaderObj->provisionClass('RenderDeco10Menu');
		// $ClassLoaderObj->provisionClass('RenderDeco20Caligraph');
		$ClassLoaderObj->provisionClass('RenderDeco301Div');
		$ClassLoaderObj->provisionClass('RenderDeco40Elegance');
		$ClassLoaderObj->provisionClass('RenderDeco50Exquisite');
		$ClassLoaderObj->provisionClass('RenderDeco60Elysion');
		
		switch ($PmThemeDataObj->getThemeBlockEntry($infosTmp['blockG'], 'deco_type')){
			case 30:	case "1_div":		$PmRenderDeco = RenderDeco301Div::getInstance();		$decoTmp = $PmRenderDeco->render($infosTmp);		break;
			case 40:	case "elegance":	$PmRenderDeco = RenderDeco40Elegance::getInstance();	$decoTmp = $PmRenderDeco->render($infosTmp);		break;
			case 50:	case "exquise":		$PmRenderDeco = RenderDeco50Exquisite::getInstance();	$decoTmp = $PmRenderDeco->render($infosTmp);		break;
			case 60:	case "elysion":		$PmRenderDeco = RenderDeco60Elysion::getInstance();		$decoTmp = $PmRenderDeco->render($infosTmp);		break;
			default:	$decoTmp = "<div id='".$mn."' style='position:absolute; left:0px; top:0px; width:640px; height:640px; '>\r";		break;
		}
		$T['Content'][$Tab]['1']['1']['cont'] .= $decoTmp;

		$T['Content'][$Tab]['1']['1']['style'] = "backgound-color:transparent;background-image:url();";
		$T['Content'][$Tab]['1']['1']['cont'] .= "
			<table class='".$PmBlock."_ft'>\r
			<tr style='background-color:transparent;'>\r
			<td class='".$PmBlock."_ft1' style='background-color:transparent;'></td>\r
			<td class='".$PmBlock."_ft2' style='background-color:transparent;'>".$DocumentDataObj->getDocumentDataEntry('arti_title')."</td>\r
			<td class='".$PmBlock."_ft3' style='background-color:transparent;'></td>\r
			</tr>\r
			</table>\r
			<h2>". $DocumentDataObj->getDocumentDataEntry('arti_subtitle') ."</h2>
			";

/*

			<input type='hidden' name='formEntity'						value='User'>
			<input type='hidden' name='formTarget[name]'				value='".$UserObj->getUserEntry('user_login')."'>\r

*/		
		if ( $Tab == 1 ) {
			$T['Content'][$Tab]['1']['1']['cont'] .= "
			<form ACTION='index.php?' method='post' name'ThemeSelection'>\r

			<input type='hidden' name='formSubmitted'					value='1'>
			<input type='hidden' name='formGenericData[origin]'			value='profileManagement'>
			<input type='hidden' name='formGenericData[section]'		value='BrowseThemeForm'>
			<input type='hidden' name='formGenericData[modification]'	value='off'>
		
			<table class='".$PmBlock._CLASS_TABLE_STD_."'>
			<tr style='background-color:transparent;'>\r
			<td>\r
			".$bts->I18nTransObj->getI18nTransEntry('formIwantTo').": 
			<select name='formCommand1'>\r
			<option value=''>".$bts->I18nTransObj->getI18nTransEntry('formIwantToSee')."</option>\r
			<option value='update'>".$bts->I18nTransObj->getI18nTransEntry('formIwantToActivate')."</option>\r
			</select>\r
			".$bts->I18nTransObj->getI18nTransEntry('formTheTheme')." 
			<select name='browseTheme[theme_name]'>\r
			";
			reset ($themeList);
			foreach ( $themeList as $A ) {
				if ( $A['theme_name'] == $bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name') ) { $T['Content'][$Tab]['1']['1']['cont'] .= "<option value='".$A['theme_name']."' selected>".$A['theme_title']."</option>\r"; }
				else { $T['Content'][$Tab]['1']['1']['cont'] .= "<option value='".$A['theme_name']."'>".$A['theme_title']."</option>\r"; }
			}
			
			$T['Content'][$Tab]['1']['1']['cont'] .= "
			</select>\r
			</td>\r
			<td>\r
			";

			$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
				$infos , 'submit', 
				$bts->I18nTransObj->getI18nTransEntry('modif_profil'), 0, 
				'refreshButton', 
				2, 2, 
				"",0 
			);
			$T['Content'][$Tab]['1']['1']['cont'] .=  $bts->InteractiveElementsObj->renderSubmitButton($SB);
			
			$T['Content'][$Tab]['1']['1']['cont'] .= "
			</td>\r
			</tr>\r
			</table>\r
			</form>\r
			<hr>\r
			";
		}
		$T['Content'][$Tab]['1']['1']['cont'] .= "
		<p class='".$PmBlock."'>\r
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #".$Tab.". <br>\r
		<br>\r
		<a>Exemple de lien simple</a><br>\r
		<br>\r
		<input type='text' name='PmExample01' value='Lorem ipsum dolor sit amet, consectetur adipiscing elit' size='25' maxlength='255' ><br>\r
		<br>\r
		<input type='text' name='PmExample02' value='Lorem ipsum dolor sit amet, consectetur adipiscing elit' size='25' maxlength='255'><br>\r
		<br>\r
		</p>

		<table class='".$PmBlock._CLASS_TABLE_STD_."'>\r
		<tr style='background-color:transparent;'>\r
		<td>\r
		<table class='".$PmBlock._CLASS_TABLE01_."'>\r
		<caption>Lorem ipsum dolor sit amet</caption>
		<tr>\r
		<td colspan='2'>\r Lorem ipsum dolor sit amet, consectetur adipiscing elit (A)</td>\r
		<td colspan='2'>\r Lorem ipsum dolor sit amet, consectetur adipiscing elit (B)</td>\r
		</tr>\r
		<tr>\r
		<td>\r Lorem ipsum.  a </td>\r
		<td>\r Lorem ipsum.  b </td>\r
		<td>\r Lorem ipsum.  c </td>\r
		<td>\r Lorem ipsum.  d </td>\r
		</tr>\r
		<tr>\r
		<td colspan='4'>\r
		<a>Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br>\r
		<br>\r
		<input type='text' name='PmExample03' value='Lorem ipsum dolor sit amet, consectetur adipiscing elit' size='25' maxlength='255'><br>\r
		<br>\r
		<input type='text' name='PmExample04' value='Lorem ipsum dolor sit amet, consectetur adipiscing elit' size='25' maxlength='255'><br>\r
		</td>\r
		</tr>\r

		<tr style='background-color:transparent;'>\r

		<td>\r
		<code>\r
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
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " icon ".$A.": " . $PmThemeDataObj->getThemeBlockEntry($infos['blockT'],$A)));
			if ( strlen($PmThemeDataObj->getThemeBlockEntry($infos['blockT'],$A)) != 0 ) {
				$PmIcon[$j] = "background-image: url(".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],'directory')."/".$PmThemeDataObj->getThemeBlockEntry($infos['blockT'],$A).");";
			}
			$j++;
		}

		$maxCells = 3;
		$maxLines = 4;
		$lineCount = 1;
		$j = 0;
		$T['Content'][$Tab]['1']['1']['cont'] .= "<table style='margin-left:auto; margin-right:auto;' border='0' >\r";
		for ( $lineCount = 1 ; $lineCount <= $maxLines ; $lineCount++ ) {
			$T['Content'][$Tab]['1']['1']['cont'] .= "<tr style='background-color:transparent;'>";
			for ( $cellCount = 1 ; $cellCount <= $maxCells ; $cellCount++ ) {
				$T['Content'][$Tab]['1']['1']['cont'] .= "<td style='
				width: 136px; height: 136px; 
				border-style: solid; border-width: 1px; border-color: #000000;'>\r
				<div style='
				width:50%; height:50%;
				margin:auto; 
				background-repeat: no-repeat; background-position:center; background-size:contain;
				".$PmIcon[$j]."'></div>\r
				</td>\r
				";
				$j++;
			}
			$T['Content'][$Tab]['1']['1']['cont'] .= "</tr>";
		}
		$T['Content'][$Tab]['1']['1']['cont'] .= "
		</table>\r
		</div>\r
		<!-- Fin de bloc -->\r
		";
		$Tab++;
	
	}
	
	$mn = "MpBlock0".$Tab;
	$infosTmp = array(
			'px'	=>	$ModulePaddingX / 2 ,
			'py'	=>	$ModulePaddingY / 2 ,
			'dx'	=>	($T['ContentInfos']['Width'] - $ModulePaddingX),
			'dy'	=>	($T['ContentInfos']['Height'] - $ModulePaddingY)
	);

	$T['Content'][$Tab]['1']['1']['cont'] .= "
	<div style='
	background-image: url(".$PmThemeDataObj->getThemeDataEntry('pathThemeBg')."); background-color: ".$PmThemeDataObj->getThemeDataEntry('theme_bg_color').";
	width: ".($T['ContentInfos']['Width']-32)."px; height: ".($T['ContentInfos']['Height']-64)."px;
	'>
	";

// --------------------------------------------------------------------------------------------
//
//	Last tabs showing the specific items.
//
//
	// $T['Content'][$Tab]['1']['1']['style'] .= "background-color:transparent; background-image:url('');";
	$T['Content'][$Tab]['1']['1']['cont'] .= "<!-- Last tabs showing the specific items. -->\r";
	$j = 0;
	$themeDir = $PmThemeDataObj->getThemeBlockEntry('B01T', 'directory');
	$themeList = array ('theme_logo');
	$themeEntries = array();
	foreach ( $themeList as $A ) {
		if (strlen($PmThemeDataObj->getThemeDataEntry($A)) != 0) {
			$themeEntries[$j] = "background-image: url(".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$themeDir."/".$PmThemeDataObj->getThemeDataEntry($A).");";
			$j++;
		}
	}

	$NbrElmFound = $j;
	$maxCells = 1;
	$maxLines = 5;
	$j = 0;
	$T['Content'][$Tab]['1']['1']['cont'] .= "<table style='margin-left:auto; margin-right:auto;' border='0' >\r";
	for ( $lineCount = 1 ; $lineCount <= $maxLines ; $lineCount++ ) {
		$T['Content'][$Tab]['1']['1']['cont'] .= "<tr>";
		for ( $cellCount = 1 ; $cellCount <= $maxCells ; $cellCount++ ) {
			if ( $j < $NbrElmFound )  {
				$T['Content'][$Tab]['1']['1']['cont'] .= "
				<td>\r	
				<div style='background-repeat: no-repeat; background-position:center; ".$themeEntries[$j]." background-size: contain; width:128px; height:128px;'></div>\r
				</td>\r";
				$T['Content'][$Tab]['1']['1']['class'] = "mt_bareTable";
				$j++;
			}
		}
		$T['Content'][$Tab]['1']['1']['cont'] .= "</tr>";
	}
	$infos['module_name']	= $infos['module_nameBackup']; 
	$infos['block']			= $infos['blockBackup'];
	$infos['blockG']		= $infos['blockGBackup'];
	$infos['blockT']		= $infos['blockTBackup'];
	
	$T['Content'][$Tab]['1']['1']['cont'] .= "
	</table>\r

	</div>\r
	<br>\r
	</p>
	";
	$T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = 1;	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 1;	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 0;
	
	$CurrentSetObj->restoreInstanceOfThemeDataObj();
	$Content .= $bts->RenderTablesObj->render($infos, $T);
	
// 	$LMObj->setInternalLogTarget($LOG_TARGET);
	
// --------------------------------------------------------------------------------------------
}

/*Hydr-Content-End*/

?>
