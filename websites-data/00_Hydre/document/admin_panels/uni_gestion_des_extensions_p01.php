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
/*Hydre-contenu_debut*/

$localisation = " / uni_gestion_des_extensions_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_extensions_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_extensions_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les extensions.",
		"col_1_txt"		=> "Extensions disponibles",
		"col_2_txt"		=> "Version",
		"col_3_txt"		=> "Installée",
		"col_4_txt"		=> "Action #1",
		"col_5_txt"		=> "Action #2",
		"tabTxt1"		=> "Informations",
		"tab10"			=> "Non",
		"tab11"			=> "Oui",
		"tab20"			=> "Activer",
		"tab21"			=> "Réinstaller",
		"tab30"			=> "Supprimer",
		"tab31"			=> "Désactiver",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage extensions.",
		"col_1_txt"		=> "Available extensions",
		"col_2_txt"		=> "Version",
		"col_3_txt"		=> "Installed",
		"col_4_txt"		=> "Action #1",
		"col_5_txt"		=> "Action #2",
		"tabTxt1"		=> "Informations",
		"tab10"			=> "No",
		"tab11"			=> "Yes",
		"tab20"			=> "Activate",
		"tab21"			=> "Reinstall",
		"tab30"			=> "Delete",
		"tab31"			=> "Deactivate",
		));
		break;
}

$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------

if ( $UserObj->getUserEntry('groupe_tag') == 3 ) {
	$extensionList = array();
	$extensions_ = array();
	$handle = opendir("../extensions/");
	while (false !== ($file = readdir($handle))) {
		if ( $file != "." && $file != ".." && !is_file("../extensions/".$file)  ) { $extensionList[] = $file; }
	}

	unset ( $A );
	$i = 0;
	foreach ( $extensionList as $A ) {
		$B = "../extensions/".$A."/extension_config.php";
		if ( file_exists ($B) ) { include ($B); }
		else {
			$extensions_['donnees'][$i]['introuvable'] = 1;
			$extensions_['donnees'][$i]['repertoire_vide'] = $A;
		}
		$i++;
	}

	unset ( $A );
	foreach ( $extensions_['donnees'] as &$A ) {
		if ( $A['introuvable'] != 1 ) {
			$dbquery = $SDDMObj->query("
			SELECT ext.* 
			FROM ".$SqlTableListObj->getSQLTableName('extension')." ext 
			WHERE ext.site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
			AND ext.extension_nom = '".$A['extension_nom']."'
			;");
			if ( $SDDMObj->num_row_sql($dbquery) != 0 ) { $A['extension_etat'] = 1; }
		}
	}


	unset ( $A );
	$i = 1;
	$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
	$T['AD']['1'][$i]['4']['cont']	= $I18nObj->getI18nEntry('col_4_txt');
	$T['AD']['1'][$i]['5']['cont']	= $I18nObj->getI18nEntry('col_5_txt');
	foreach ( $extensions_['donnees'] as $A ) {
		if ( $A['introuvable'] != 1 ) {
			$i++;
			$T['AD']['1'][$i]['1']['cont'] = $A['extension_nom'];
			$T['AD']['1'][$i]['2']['cont'] = $A['extension_version'];
			$T['AD']['1'][$i]['3']['cont'] = $I18nObj->getI18nEntry('tab1'.$A['extension_etat']);
			
			$SB = array(
					"id"				=> "installButton",
					"type"				=> "submit",
					"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
					"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
					"onclick"			=> "",
					"message"			=> $I18nObj->getI18nEntry('tab2'.$A['extension_etat']),
					"mode"				=> 1,
					"size" 				=> 96,
					"lastSize"			=> 0,
			);
			
			$T['AD']['1'][$i]['4']['style']		= "padding:16px";
			$T['AD']['1'][$i]['4']['cont']		= "
			<form ACTION='index.php?' method='post' name='formulaire_install1'>\r".
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')."
			<input type='hidden' name='arti_page'						value='2'>\r
			<input type='hidden' name='M_EXTENS[extension_nom]'			value='".$A['extension_nom']."'>\r
			<input type='hidden' name='M_EXTENS[extension_repertoire]'	value='".$A['extension_repertoire']."'>\r
			<input type='hidden' name='M_EXTENS[extension_requete]'		value='Installer'>\r
			<input type='hidden' name='uni_gestion_des_extensions_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
			". $InteractiveElementsObj->renderSubmitButton($SB).
			"</form>\r";

			$SB = array(
					"id"				=> "deleteButton",
					"type"				=> "submit",
					"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
					"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
					"onclick"			=> "",
					"message"			=> $I18nObj->getI18nEntry('tab3'.$A['extension_etat']),
					"mode"				=> 1,
					"size" 				=> 96,
					"lastSize"			=> 0,
			);
			
			$T['AD']['1'][$i]['5']['style']		= "padding:16px";
			$T['AD']['1'][$i]['5']['cont']		= "
			<form ACTION='index.php?' method='post' name='formulaire_install1'>\r".
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')."
			<input type='hidden' name='arti_page'						value='2'>\r
			<input type='hidden' name='M_EXTENS[extension_nom]'			value='".$A['extension_nom']."'>\r
			<input type='hidden' name='M_EXTENS[extension_repertoire]'	value='".$A['extension_repertoire']."'>\r
			<input type='hidden' name='M_EXTENS[extension_requete]'		value='Supprimer'>\r
			<input type='hidden' name='uni_gestion_des_extensions_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
			". $InteractiveElementsObj->renderSubmitButton($SB).
			"</form>\r";
		}
		if ( $A['extension_etat'] == 1 ) {
			$SB = array(
					"id"				=> "deleteButton",
					"type"				=> "submit",
					"initialStyle"		=> $Block."_t3 ".$Block."_submit_s3_n",
					"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s3_h",
					"onclick"			=> "",
					"message"			=> $I18nObj->getI18nEntry('tab3'.$A['extension_etat']),
					"mode"				=> 1,
					"size" 				=> 96,
					"lastSize"			=> 0,
			);
			
			
			$T['AD']['1'][$i]['5']['cont']		= "<br>\r&nbsp;
			<form ACTION='index.php?' method='post' name='formulaire_Retire1'>\r".
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
			$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
			"<input type='hidden' name='arti_page'						value='2'>\r
			<input type='hidden' name='M_EXTENS[extension_repertoire]'	value='".$A['extension_repertoire']."'>\r
			<input type='hidden' name='M_EXTENS[extension_requete]'		value='Retirer'>\r
			<input type='hidden' name='uni_gestion_des_extensions_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
			". $InteractiveElementsObj->renderSubmitButton($SB).
			"</form>\r";
		}
	}
	
	// --------------------------------------------------------------------------------------------
	//
	//	Display
	//
	//
	// --------------------------------------------------------------------------------------------
	$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 15);
	$T['ADC']['onglet'] = array(
			1	=>	$RenderTablesObj->getDefaultTableConfig($i,5,1),
	);
	$Content .= $RenderTablesObj->render($infos, $T);
}
else { $Content .= "!!!!!!!!!!!!!!!!"; }


/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
