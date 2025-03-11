<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
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
/*JanusEngine-IDE-end*/

// --------------------------------------------------------------------------------------------
$bts->RequestDataObj->setRequestData(
	'formGenericData',
	array(
		'origin'		=> 'profileManagement',
		'section'		=> 'browseTheme',
		'modification'	=> 'on',
		'mode'			=> 'edit',
	)
);

$bts->RequestDataObj->setRequestData(
	'browseTheme',
	array(
		"theme_id"			=>	1952994312284275436,
		"theme_name"		=>	"JnsEng_tronic_01",
	)
);


$bts->RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_profile_management_p01");

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
			"tabTxt3"		=>	"Adresses",
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
			"t1_login"			=>	"Identifiant",
			"t1_mail"			=>	"Email",
			"t1_avatar"			=>	"Avatar",
			"t1_upload"			=>	"Téléchargement",
			"t1_passwordTopic"	=>	"Mot de passe",
			"t1_passwordLink"	=>	"Suivre ce lien pour changer le mot de passe",
			"t4_l1"	=>	"Recevoir la newsletter",
			"t4_l2"	=>	"Montrer l'E-mail au public",
			"t4_l3"	=>	"Montrer le status 'En ligne'",
			"t4_l4"	=>	"Langue",
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
			"tabTxt3"		=>	"Addresses",
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
			"t1_login"			=>	"Login",
			"t1_mail"			=>	"Email",
			"t1_avatar"			=>	"Avatar",
			"t1_upload"			=>	"Upload",
			"t1_passwordTopic"	=>	"Password",
			"t1_passwordLink"	=>	"Follow this link to change your password",
			"t4_l1"	=>	"Get the newletter",
			"t4_l2"	=>	"Show email to the public",
			"t4_l3"	=>	"Show Online status",
			"t4_l4"	=>	"Language",
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

$UserObj = $CurrentSetObj->UserObj;
if ($UserObj->getUserEntry('user_login') == "anonymous") {
	$Content .= $bts->I18nTransObj->getI18nTransEntry("anonDeny");
} else {
	// --------------------------------------------------------------------------------------------
	//	Debut du formulaire
	// --------------------------------------------------------------------------------------------
	$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite1') . "</p>\r<br>\r";

	if ($bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'uploadError') == 1) {
		$Content .= "<p class='" . $Block . _CLASS_TXT_WARNING_ . "'>" . $bts->I18nTransObj->getI18nTransEntry('AvatarUploadError')[$bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'AvatarUploadError')] . "</p>\r<br>\r";
	}

	if ($bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'confirmation_modification_oubli') == 'on') {
		$Content .= "<p class='" . $Block . _CLASS_TXT_ERROR_ . "'>" . $bts->I18nTransObj->getI18nTransEntry('confirmation_modification_oubli') . "</p>\r<br>\r";
	}

	$Content .= "<br>\r
	<form enctype='multipart/form-data' ACTION='index.php?' method='post' name='UserProfileForm'>\r"
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]", "profileManagement")
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[section]", "UserProfileForm")
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[modification]", "on")
		. $bts->RenderFormObj->renderHiddenInput("formEntity", "User")
		. $bts->RenderFormObj->renderHiddenInput("formTarget[name]", $UserObj->getUserEntry('user_login'));

	$userPrefthemeId = $WebSiteObj->getWebSiteEntry('fk_theme_id');
	if ($UserObj->getUserEntry('pref_theme') != 0) {
		$userPrefthemeId = $UserObj->getUserEntry('pref_theme');
	}
	$dbquery = $bts->SDDMObj->query("
	SELECT u.*,td.theme_name,td.theme_id
	FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('user') . " u , "
		. $CurrentSetObj->SqlTableListObj->getSQLTableName('theme_descriptor') . " td 
	WHERE u.user_id = '" . $UserObj->getUserEntry('user_id') . "' 
	AND td.theme_id = '" . $userPrefthemeId . "' 
	;");
	$PmListTheme = array();
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		foreach ($dbp as $A => $B) {
			$PmListTheme[$A] = $B;
		}
	}

	// --------------------------------------------------------------------------------------------
	//	Informations internet
	// --------------------------------------------------------------------------------------------
	$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "UserProfileForm",
		"formTargetId"		=> "UserProfileForm[user_avatar_image]",
		"formInputSize"		=> 40,
		"formInputVal"		=> $UserObj->getUserEntry('user_avatar_image'),
		"path"				=> "websites-data/" . $WebSiteObj->getWebSiteEntry('ws_directory') . "/data/images/avatars/",
		"restrictTo"		=> "websites-data/" . $WebSiteObj->getWebSiteEntry('ws_directory') . "/data/images/avatars/",
		"strRemove"			=> "",
		"strAdd"			=> "../",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "t1l2c2",
		"case"				=> 1,
		"update"			=> 1,
		"array"				=> "tableFileSelector[" . $CurrentSetObj->getDataEntry('fsIdx') . "]",
	);
	$infos['IconSelectFile'] = $FileSelectorConfig;
	$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
	$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);


	$T = array();
	$curTab = 0;
	$maxLines = 0;

	// --------------------------------------------------------------------------------------------
	$curTab++;
	$l = 1;
	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_login');
	$T['Content'][$curTab][$l]['2']['cont'] = "<input type='text' name='formParams[login]' value='" . $UserObj->getUserEntry('user_login') . "' size='15' maxlength='255' disabled>";
	$l++;
	
	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_mail');
	$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderInputText("formParams[user_email]", $UserObj->getUserEntry('user_email'), "", 30);
	$l++;
	
	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_avatar');
	if (strlen($PmListTheme['user_avatar_image'] ?? '') != 1024) {
		$T['Content'][$curTab][$l]['2']['cont'] = "<img src='" . $PmListTheme['user_avatar_image'] . "' width='48' height='48' alt='[Avatar]'>";
	} else {
		$T['Content'][$curTab][$l]['2']['cont'] = "N/A";
	}
	$T['Content'][$curTab][$l]['2']['cont'] .=	$bts->InteractiveElementsObj->renderIconSelectFile($infos);
	$l++;
	
	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_upload');
	$T['Content'][$curTab][$l]['2']['cont'] = "<input type='hidden' name='MAX_FILE_SIZE' value='32768'> 
	<input type='file' name='formParams[AvatarSelectedFile]' size='40'>";
	$l++;
	
	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_passwordTopic');
	$T['Content'][$curTab][$l]['2']['cont'] = "<a href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') 
			. "reset-password'>" . $bts->I18nTransObj->getI18nTransEntry('t1_passwordLink') . "</a>";
	$l++;

	$T['ContentCfg']['tabs'][$curTab] = $bts->RenderTablesObj->getDefaultTableConfig($l -1, 2, 2);
	if ($l > $maxLines) { $maxLines = $l;}

	// --------------------------------------------------------------------------------------------
	$curTab++;
	$l = 1;

	$TSO = array(
		0	=>	array(
			"A"	=>	"<option value='0' ",
			"B"	=>	">" . $bts->I18nTransObj->getI18nTransEntry('uni')[0] . "</option>\r",
		),
		1	=>	array(
			"A"	=>	"<option value='0' ",
			"B"	=>	">" . $bts->I18nTransObj->getI18nTransEntry('uni')[1] . "</option>\r",
		),
	);

	$preferenceList = array( 
		"show_email",
		"show_online_status",
		"",
		"",
		"",
		"",
		"",
	);

	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l1');
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_newsletter')]['s'] = "selected";
	$T['Content'][$curTab][$l]['2']['cont'] = "<select name='formParams[user_pref_newsletter]'>\r"
		. $TSO['0']['A'] . $TSO['0']['s'] . $TSO['0']['B']
		. $TSO['1']['A'] . $TSO['1']['s'] . $TSO['1']['B']
		. "</select>\r";
	$l++;

	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l2');
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_show_email')]['s'] = "selected";
	$T['Content'][$curTab][$l]['2']['cont'] = "<select name='formParams[user_pref_show_email]'>\r "
		. $TSO['0']['A'] . $TSO['0']['s'] . $TSO['0']['B']
		. $TSO['1']['A'] . $TSO['1']['s'] . $TSO['1']['B']
		. "</select>\r";
	$l++;

	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l3');
	$TSO['S0'] = $TSO['S1'] = "";
	$TSO[$UserObj->getUserEntry('user_pref_show_online_status')]['s'] = "selected";
	$T['Content'][$curTab][$l]['2']['cont'] = "<select name='formParams[user_pref_show_online_status]'>\r "
		. $TSO['0']['A'] . $TSO['0']['s'] . $TSO['0']['B']
		. $TSO['1']['A'] . $TSO['1']['s'] . $TSO['1']['B']
		. "</select>\r";
	$l++;

	$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l4');
	$T['Content'][$curTab][$l]['2']['cont'] = "<select name='formParams[lang]'>\r";

	$langList = array();
	$q = "SELECT * FROM ". $CurrentSetObj->SqlTableListObj->getSQLTableName('language') . " l;";
	$dbqueryL1 = $bts->SDDMObj->query($q);
	while ($dbpL1 = $bts->SDDMObj->fetch_array_sql($dbqueryL1)) {
		$langList[$dbpL1['lang_id']] =  array(
			"lang_id"				=>	$dbpL1['lang_id'],           
			"lang_639_3"			=>	$dbpL1['lang_639_3'],        
			"lang_original_name"	=>	$dbpL1['lang_original_name'],
			"lang_639_2"			=>	$dbpL1['lang_639_2'],        
			"lang_639_1"			=>	$dbpL1['lang_639_1'],        
			"lang_image"			=>	$dbpL1['lang_image'],        
		);
	}

	$q = "SELECT lw.fk_lang_id FROM "
		. $CurrentSetObj->SqlTableListObj->getSQLTableName('language_website') . " lw , "
		. $CurrentSetObj->SqlTableListObj->getSQLTableName('website') . " w 
		WHERE w.ws_id ='" . $WebSiteObj->getWebSiteEntry('ws_id') . "' 
		AND lw.fk_ws_id = w.ws_id
		;";
	$dbqueryL2 = $bts->SDDMObj->query($q);
	while ($dbpL2 = $bts->SDDMObj->fetch_array_sql($dbqueryL2)) {
		$langList[$dbpL2['fk_lang_id']]['support'] = 1;
	}
	if ($PmListTheme['user_lang'] == 0) {
		$langList[$WebSiteObj->getWebSiteEntry('fk_lang_id')]['s'] = " selected ";
	} else {
		$langList[$PmListTheme['user_lang']]['s'] = " selected ";
	}

	reset($langList);
	unset($A);
	
	foreach ($langList as $A) {
		if ($A['support'] == 1) {
			$T['Content'][$curTab][$l]['2']['cont'] .= "<option value='" . $A['lang_639_3'] . "' " . $A['s'] . "> " . $A['lang_original_name'] . " </option>\r";
		}
	}
	
	$T['Content'][$curTab][$l]['2']['cont'] .= "</select>\r";
	$l++;

	$T['ContentCfg']['tabs'][$curTab] = $bts->RenderTablesObj->getDefaultTableConfig($l -1, 2, 2);
	if ($l > $maxLines) { $maxLines = $l; }

	// --------------------------------------------------------------------------------------------
	$curTab++;
	$l = 1;

	$bts->InitClass('MiscTools');
	$tab = $bts->MiscTools->makeInfosConfigList('user', 'adr_', '');
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : tab=" . $bts->StringFormatObj->print_r_debug($tab) ));

	foreach ($tab as $IC) {
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : l=" . $l . ", field=" . $IC['infcfg_field']));

		$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry($IC['infcfg_label_ref']);
		$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderInputText(
			"formParams1['" . $IC['infcfg_field'] . "']", 
			$UserObj->getInfosEntry($IC['infcfg_field']), 
			"", 
			64);
		$l++;
	}

	$T['ContentCfg']['tabs'][$curTab] = $bts->RenderTablesObj->getDefaultTableConfig($l - 1, 2, 2);
	if ($l > $maxLines) { $maxLines = $l; }

	// --------------------------------------------------------------------------------------------
	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, $curTab);

	$Content .= $bts->RenderTablesObj->render($infos, $T);


	$Content .= "
	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto; padding:8px'>
	<tr>\r
	<td style='width:70%;'>\r
	<input type='checkbox' name='formParams1[confirmation_modification]' checked> " . $bts->I18nTransObj->getI18nTransEntry('text_confirm1') . "\r
	</td>\r
	<td style='width: 200px;'>\r
	";

	$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
		$infos,
		'submit',
		$bts->I18nTransObj->getI18nTransEntry('modif_profil'),
		0,
		'UpdateButton',
		2,
		2,
		"",
		0
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
		. $SqlTableListObj->getSQLTableName('theme_descriptor') . " td, "
		. $SqlTableListObj->getSQLTableName('theme_website') . " tw 
		WHERE td.theme_id = tw.fk_theme_id  
		AND tw.fk_ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "'
		ORDER BY td.theme_name
		;");
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$themeList[$dbp['theme_name']] = array(
			"theme_id"		=> $dbp['theme_id'],
			"theme_name"	=> $dbp['theme_name'],
			"theme_title"	=> $dbp['theme_title'],
		);
	}

	unset($T);
	$T = array();
	$tmpStr = $bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name');
	if (strlen($tmpStr ?? '') == 0) {
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " No requested theme in the form, using the main theme."));
		$bts->RequestDataObj->setRequestDataSubEntry('browseTheme', 'theme_name', $ThemeDataObj->getThemeDataEntry('theme_name'));
		$bts->RequestDataObj->setRequestData(
			'browseTheme',
			array(
				"theme_id"		=>	$ThemeDataObj->getThemeDataEntry('theme_id'),
				"theme_name"	=>	$ThemeDataObj->getThemeDataEntry('theme_name'),
			)
		);
	}
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Requested theme N=`" . $bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name') . "`"));

	$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('text_choix_theme') . "</p>\r";

	$PmThemeDescriptorObj = new ThemeDescriptor();
	$PmThemeDescriptorObj->setCssPrefix('PM_');
	$PmThemeDataObj = new ThemeData();

	$PmThemeDataObj->setThemeName($PmThemeDescriptorObj->getCssPrefix());
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "User preference theme name: " . $themeList[$bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedTheme')]['theme_name'] . " and id: " . $themeList[$bts->RequestDataObj->getRequestDataSubEntry('UserProfileForm', 'SelectedTheme')]['theme_id'] . "."));
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "Form browseTheme name: " . $bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name') . "."));
	$PmThemeDescriptorObj->getDataFromDB($themeList[$bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name')]['theme_id']);

	// $bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "  PmThemeDescriptorObj :" . $bts->StringFormatObj->print_r_debug($PmThemeDescriptorObj) ));

	$PmThemeDataObj->setThemeData($PmThemeDescriptorObj->getThemeDescriptor()); //Better to give an array than the object itself.
	$PmThemeDataObj->setThemeDefinition($PmThemeDescriptorObj->getThemeDefinition());
	$PmThemeDataObj->setDecorationListFromDB();
	$PmThemeDataObj->renderBlockData();

	$CurrentSetObj->backupInstanceOfThemeDataObj();
	$CurrentSetObj->setThemeDataObj($PmThemeDataObj);

	$ClassLoaderObj->provisionClass('RenderStylesheet');
	$RenderStylesheetObj = RenderStylesheet::getInstance();
	$Content .= $RenderStylesheetObj->render($PmThemeDescriptorObj->getCssPrefix(), $PmThemeDataObj);

	$iconList = array('icon_directory', 'icon_erase', 'icon_left', 'icon_right', 'icon_top', 'icon_bottom', 'icon_ok', 'icon_ko', 'icon_question', 'icon_notification');

	$ListThemeBlock = array();
	for ($i = 1; $i < 30; $i++) {
		$TmpBlockName = $bts->StringFormatObj->getDecorationBlockName("block_", $i, "_name");
		$TmpBlockEntry = $PmThemeDescriptorObj->getThemeDefinitionEntry($TmpBlockName);

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " processing : " . $TmpBlockName));
		if (count($TmpBlockEntry) > 0) { // Also "!$TmpBlockEntry" works
			$err = 0;
			foreach ($ListThemeBlock as $A) {
				if ($A['def_string'] == $TmpBlockName) {
					$err = 1;
				}
			}
			if ($err == 0) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "Inserting :" . $TmpBlockEntry['def_string']));
				$ListThemeBlock[$TmpBlockEntry['def_string']]['name'] = $TmpBlockName;
				$ListThemeBlock[$TmpBlockEntry['def_string']]['pos'] = $i;
			}
		}
	}

	// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Result : " . $bts->StringFormatObj->print_r_debug($ListThemeBlock)));

	for ($i = 1; $i < (count($ListThemeBlock) + 2); $i++) {
		$bts->I18nTransObj->setI18nTransEntry('tabTxtThm' . $i, "#" . $i);
		$T['ContentCfg']['tabs'][$i] = $bts->RenderTablesObj->getDefaultTableConfig(1, 1, 0);
	}
	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 20, count($ListThemeBlock) + 1, 1, 0, 'tabTxtThm');
	$T['ContentInfos']['GroupName']		= "pm";
	$T['ContentInfos']['Width']			= 768;
	$T['ContentInfos']['Height']		= 1200;
	$T['ContentInfos']['padding-h']		= "128px";
	$T['ContentInfos']['padding-v']		= "16px";

	$PmThemeDataObj->setThemeDataEntry('pathThemeBg', $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $PmThemeDataObj->getDefinitionValue('directory') . "/" . $PmThemeDataObj->getDefinitionValue('bg'));
	$ModulePaddingX = $ModulePaddingY = 64;

	$infos['module_nameBackup']	= $infos['module_name'];
	$infos['blockBackup']		= $infos['block'];
	$infos['blockGBackup']		= $infos['blockG'];
	$infos['blockTBackup']		= $infos['blockT'];

	$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "Display theme ______________________________"));
	$Tab = 1;
	unset($A);
	reset($ListThemeBlock);
	foreach ($ListThemeBlock as $A) {

		$currentBlock = $bts->StringFormatObj->getDecorationBlockName("B", $A['pos'], "");
		$PmBlock = $PmThemeDataObj->getThemeName() . $currentBlock;

		$mn = "MpBlock0" . $Tab;
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Processing decoration : " . $mn));

		$infosTmp = array(
			'module_name' => $mn,
			'block' => $currentBlock,
			'blockG' => $currentBlock . "G",
			'blockT' => $currentBlock . "T",
			'mode' => 1,
			'module' => array(
				'module_name' => $mn,
				'module_container_name' => "container_" . $mn,
			),
		);
		$infosTmp['deco_type'] = $ThemeDataObj->getThemeBlockEntry($infosTmp['blockG'], 'deco_type');

		$T['Content'][$Tab]['1']['1']['cont'] .= "
		<div style='
		background-image: url(" . $PmThemeDataObj->getThemeDataEntry('pathThemeBg') . "); background-color: " . $PmThemeDataObj->getDefinitionValue('bg_color') . ";
		width: 100%; height: " . $T['ContentInfos']['Height'] . "px;
		max-width: 768px; max_height:120px;
		padding:" . $T['ContentInfos']['padding-v'] . " " . $T['ContentInfos']['padding-h'] . " " . $T['ContentInfos']['padding-v'] . " " . $T['ContentInfos']['padding-h'] . ";
		'>	
		";

		// Brutal... But efficient!!!
		// $ClassLoaderObj->provisionClass('RenderDeco10Menu');
		// $ClassLoaderObj->provisionClass('RenderDeco20Caligraph');
		$ClassLoaderObj->provisionClass('RenderDeco301Div');
		$ClassLoaderObj->provisionClass('RenderDeco40Elegance');
		$ClassLoaderObj->provisionClass('RenderDeco50Exquisite');
		$ClassLoaderObj->provisionClass('RenderDeco60Elysion');

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " DécoType : " . $infosTmp['blockG']));

		switch ($PmThemeDataObj->getThemeBlockEntry($infosTmp['blockG'], 'deco_type')) {
			case 30:
			case "1_div":
				$PmRenderDeco = RenderDeco301Div::getInstance();
				$decoTmp = $PmRenderDeco->render($infosTmp);
				break;
			case 40:
			case "elegance":
				$PmRenderDeco = RenderDeco40Elegance::getInstance();
				$decoTmp = $PmRenderDeco->render($infosTmp);
				break;
			case 50:
			case "exquise":
				$PmRenderDeco = RenderDeco50Exquisite::getInstance();
				$decoTmp = $PmRenderDeco->render($infosTmp);
				break;
			case 60:
			case "elysion":
				$PmRenderDeco = RenderDeco60Elysion::getInstance();
				$decoTmp = $PmRenderDeco->render($infosTmp);
				break;
			default:
				$decoTmp = "<div id='" . $mn . "' style='position:absolute; left:0px; top:0px; width:100%; height:1200px; '>\r";
				break;
		}
		$T['Content'][$Tab]['1']['1']['cont'] .= $decoTmp;

		$T['Content'][$Tab]['1']['1']['style'] = "backgound-color:transparent;background-image:url();";
		$T['Content'][$Tab]['1']['1']['cont'] .= "
			<table class='" . $PmBlock . "_ft'>\r
			<tr style='background-color:transparent;'>\r
			<td class='" . $PmBlock . "_ft1' style='padding:0px; background-color:transparent;'></td>\r
			<td class='" . $PmBlock . "_ft2' style='padding:0px; background-color:transparent;'>" . $DocumentDataObj->getDocumentDataEntry('arti_title') . "</td>\r
			<td class='" . $PmBlock . "_ft3' style='padding:0px; background-color:transparent;'></td>\r
			</tr>\r
			</table>\r
			<h2>" . $DocumentDataObj->getDocumentDataEntry('arti_subtitle') . "</h2>
			";
			
			/*
			

style='background-color:transparent;'
style='background-color:transparent;'
style='background-color:transparent;'


			<table class='" . $Block . "_ft'>\r
			<tr>\r
			<td class='" . $Block . "_ft1'></td>\r
			<td class='" . $Block . "_ft2'>" . $DocumentDataObj->getDocumentDataEntry('arti_title') . "</td>\r
			<td class='" . $Block . "_ft3'></td>\r
			</tr>\r
			</table>\r
*/

		if ($Tab == 1) {
			$T['Content'][$Tab]['1']['1']['cont'] .=
				$bts->RenderFormObj->renderformHeader('ThemeSelectionForm')
				. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]",			"profileManagement")
				. $bts->RenderFormObj->renderHiddenInput("formGenericData[section]",		"browseTheme")
				. $bts->RenderFormObj->renderHiddenInput("formGenericData[modification]",	"on")
				. $bts->RenderFormObj->renderHiddenInput("formEntity",						"User")
				. $bts->RenderFormObj->renderHiddenInput("formTarget[name]",				$UserObj->getUserEntry('user_login'))
				. $bts->RenderFormObj->renderHiddenInput("formSubmitted",					"1")
				. "\r
			<table class='" . $PmBlock . _CLASS_TABLE_STD_ . "'>
			<tr style='background-color:transparent;'>\r
			<td>\r
			" . $bts->I18nTransObj->getI18nTransEntry('formIwantTo') . ": 
			<select name='formCommand1'>\r
			<option value=''>" . $bts->I18nTransObj->getI18nTransEntry('formIwantToSee') . "</option>\r
			<option value='update'>" . $bts->I18nTransObj->getI18nTransEntry('formIwantToActivate') . "</option>\r
			</select>\r
			" . $bts->I18nTransObj->getI18nTransEntry('formTheTheme') . " 
			<select name='browseTheme[theme_name]'>\r
			";
			reset($themeList);
			foreach ($themeList as $A) {
				if ($A['theme_name'] == $bts->RequestDataObj->getRequestDataSubEntry('browseTheme', 'theme_name')) {
					$T['Content'][$Tab]['1']['1']['cont'] .= "<option value='" . $A['theme_name'] . "' selected>" . $A['theme_title'] . "</option>\r";
				} else {
					$T['Content'][$Tab]['1']['1']['cont'] .= "<option value='" . $A['theme_name'] . "'>" . $A['theme_title'] . "</option>\r";
				}
			}

			$T['Content'][$Tab]['1']['1']['cont'] .= "
			</select>\r
			</td>\r
			<td>\r
			";

			$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
				$infos,
				'submit',
				$bts->I18nTransObj->getI18nTransEntry('formIwantToSee'),
				0,
				'refreshButton',
				2,
				2,
				"",
				0
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
		<p class='" . $PmBlock . "'>\r
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #" . $Tab . ". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #" . $Tab . ". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #" . $Tab . ". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #" . $Tab . ". 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit #" . $Tab . ". <br>\r
		<br>\r
		<a>Exemple de lien simple</a><br>\r
		<br>\r"
			. $bts->RenderFormObj->renderInputText("PmExample01", "Lorem ipsum dolor sit amet, consectetur adipiscing elit", "", 25)
			. "<br>\r<br>\r"
			. $bts->RenderFormObj->renderInputText("PmExample02", "Lorem ipsum dolor sit amet, consectetur adipiscing elit", "", 25)
			. "<br>\r
		</p>

		<table class='" . $PmBlock . _CLASS_TABLE_STD_ . "'>\r
		<tr style='background-color:transparent;'>\r
		<td>\r
		<table class='" . $PmBlock . _CLASS_TABLE01_ . "'>\r
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
		<br>\r"
			. $bts->RenderFormObj->renderInputText("PmExample03", "Lorem ipsum dolor sit amet", "", 25)
			. "<br>\r
		<br>\r"
			. $bts->RenderFormObj->renderInputText("PmExample04", "Lorem ipsum dolor sit amet", "", 25)
			. "<br>\r
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
		reset($iconList);
		foreach ($iconList as $A) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " icon " . $A . ": " . $PmThemeDataObj->getThemeBlockEntry($infos['blockT'], $A)));
			if (strlen($PmThemeDataObj->getThemeBlockEntry($infos['blockT'], $A) ?? '') != 0) {
				$PmIcon[$j] = "background-image: url(" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $PmThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $PmThemeDataObj->getThemeBlockEntry($infos['blockT'], $A) . ");";
			}
			$j++;
		}

		$maxCells = 3;
		$maxLines = 4;
		$lineCount = 1;
		$j = 0;
		$T['Content'][$Tab]['1']['1']['cont'] .= "<table style='margin-left:auto; margin-right:auto;' border='0' >\r";
		for ($lineCount = 1; $lineCount <= $maxLines; $lineCount++) {
			$T['Content'][$Tab]['1']['1']['cont'] .= "<tr style='background-color:transparent;'>";
			for ($cellCount = 1; $cellCount <= $maxCells; $cellCount++) {
				$T['Content'][$Tab]['1']['1']['cont'] .= "<td style='
				width: 136px; height: 136px; 
				border-style: solid; border-width: 1px; border-color: #000000;'>\r
				<div style='
				width:50%; height:50%;
				margin:auto; 
				background-repeat: no-repeat; background-position:center; background-size:contain;
				" . $PmIcon[$j] . "'></div>\r
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

	$mn = "MpBlock0" . $Tab;
	$infosTmp = array(
		'px'	=>	$ModulePaddingX / 2,
		'py'	=>	$ModulePaddingY / 2,
		'dx'	=> ($T['ContentInfos']['Width'] - $ModulePaddingX),
		'dy'	=> ($T['ContentInfos']['Height'] - $ModulePaddingY)
	);

	$T['Content'][$Tab]['1']['1']['cont'] .= "
	<div style='
	background-image: url(" . $PmThemeDataObj->getThemeDataEntry('pathThemeBg') . "); background-color: " . $PmThemeDataObj->getDefinitionValue('bg_color') . ";
	width: " . ($T['ContentInfos']['Width'] - 32) . "px; height: " . ($T['ContentInfos']['Height'] - 64) . "px;
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
	$themeList = array('logo');
	$themeEntries = array();
	foreach ($themeList as $A) {
		$tmpArrayDefEntry = $PmThemeDataObj->getThemeDefinitionEntry($A);
		if (strlen( $tmpArrayDefEntry['def_string'] ?? '') != 0) {
			$themeEntries[$j] = "background-image: url(" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $themeDir . "/" . $tmpArrayDefEntry['def_string'] . ");";
			$j++;
		}
	}

	$NbrElmFound = $j;
	$maxCells = 1;
	$maxLines = 5;
	$j = 0;
	$T['Content'][$Tab]['1']['1']['cont'] .= "<table style='margin-left:auto; margin-right:auto;' border='0' >\r";
	for ($lineCount = 1; $lineCount <= $maxLines; $lineCount++) {
		$T['Content'][$Tab]['1']['1']['cont'] .= "<tr>";
		for ($cellCount = 1; $cellCount <= $maxCells; $cellCount++) {
			if ($j < $NbrElmFound) {
				$T['Content'][$Tab]['1']['1']['cont'] .= "
				<td>\r	
				<div style='background-repeat: no-repeat; background-position:center; " . $themeEntries[$j] . " background-size: contain; width:128px; height:128px;'></div>\r
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
	$T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 0;

	$CurrentSetObj->restoreInstanceOfThemeDataObj();
	$Content .= $bts->RenderTablesObj->render($infos, $T);

	// --------------------------------------------------------------------------------------------
}

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
