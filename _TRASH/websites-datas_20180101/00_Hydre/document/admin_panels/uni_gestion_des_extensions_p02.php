<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

//$_REQUEST['M_EXTENS']['extension_nom']		= "MWM_Galerie";
$_REQUEST['M_EXTENS']['extension_repertoire'] = "mwm_galerie_v0.01";
$_REQUEST['M_EXTENS']['extension_requete']	= "Installer";
//$_REQUEST['M_EXTENS']['extension_requete']	= "Retirer";
$_REQUEST['uni_gestion_des_modules_p'] = 2;

/*Hydre-contenu_debut*/
statistique_checkpoint ( "Demarrage gestion des extensions" );
$_REQUEST['sql_initiateur'] = "uni_gestion_des_groupes_p0".$_REQUEST['uni_gestion_des_modules_p'].".php";

if ( $user['groupe_tag'] == 3 ) {
	//outil_debug ( $user['groupe_tag'] , "user['groupe_tag']" );

	function extension_score_element ( &$cible , &$liste , $sru_requete ) {
		unset ( $A );
		foreach ( $liste as $A ) {
			$cible[$A]['etat'] = "ERR"; 
			systeme_requete_unifiee ( 2 , $sru_requete , $A , 0 , "M_EXTENS_V_".$sru_requete , $cible[$A]['etat'] );
			if ( $cible[$A]['etat'] != "ERR" ) { $cible[$A]['etat'] = "ok"; }
		}
		$pv['compte_ok'] = 0; $pv['compte_err'] = 0;
		unset ( $A );
		foreach ( $dp['documents'] as $A ) {
			if ( $A['etat'] == "ok" ) { $pv['compte_ok']++; }
			else { $pv['compte_err']++; }
		}
		$score = 0;
		if ( $pv['compte_ok'] != 0 ) { $score++; }
		if ( $pv['compte_err'] != 0 ) { $score += 2; }
		switch ( $score ) {
			case 0:
			case 1: $cible = "ok";		break;
			case 2: $cible = "FAIL";	break;
			case 3: $cible = "ERR";		break;
		}
	}

	$extensions_['donnees'] = array();
	$pv['i'] = 0;
	$A = "../extensions/".$_REQUEST['M_EXTENS']['extension_repertoire']."/extension_config.php";
	if ( file_exists ( $A ) ) { include ( $A ); }

	$P = &$extensions_['donnees']['0'];

	switch ( $_REQUEST['M_EXTENS']['extension_requete'] ) {
	case "Installer":
		$pv['requete'] = "SELECT ext.* 
		FROM ".$SQL_tab_abrege['extension']." ext 
		WHERE ext.site_id = '".$site_web['sw_id']."' 
		AND ext.extension_nom = '".$P['extension_nom']."'
		;";
		$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
		if ( num_row_sql( $dbquery ) != 0 ) { $_REQUEST['M_EXTENS']['ERR'] = 1; }
		$pv['debug_nqueries'] = num_row_sql( $dbquery );

		if ( $_REQUEST['M_EXTENS']['ERR'] == 0 ) {
			$P['extension_id'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['extension'] , "extension_id" );
			$pv['requete'] = "INSERT INTO ".$SQL_tab_abrege['extension']." VALUES ('" . 
			$P['extension_id']			. "','" . 
			$P['site_id']				. "','" .
			$P['extension_nom']			. "','" . 
			$P['extension_version']		. "','" . 
			$P['extension_auteur']		. "','" . 
			$P['extension_site_auteur']	. "','rien', '" .
			$_REQUEST['M_EXTENS']['extension_repertoire'] . "');";
			manipulation_traitement_requete ( $pv['requete'] );

			unset ( $_REQUEST['liste_repertoire_a_scanner'] );
			$_REQUEST['liste_repertoire_a_scanner']['0']['nom_repertoire'] = "/_installation";
			$_REQUEST['liste_repertoire_a_scanner']['0']['etat'] = on;

		}
		else { echo ( "err=". $_REQUEST['M_EXTENS']['ERR'] ); }
	break;
	case "Retirer":
		unset ( $_REQUEST['liste_repertoire_a_scanner'] );
		$_REQUEST['liste_repertoire_a_scanner']['0']['nom_repertoire'] = "/_desinstallation";
		$_REQUEST['liste_repertoire_a_scanner']['0']['etat'] = on;

		$P['extension_id'] = Extension_Recherche_Id ( $P['extension_nom'] );

		$pv['requete'] = "
		DELETE FROM ".$SQL_tab_abrege['extension']."  
		WHERE site_id = '".$P['site_id']."' 
		AND extension_nom = '".$P['extension_nom']."'
		;";
		manipulation_traitement_requete ( $pv['requete'] );
	break;
	}
// --------------------------------------------------------------------------------------------
//	Action
	include_once ("routines/website/manipulation_article.php");
	include_once ("routines/website/manipulation_article_config.php");
	include_once ("routines/website/manipulation_bouclage.php");
	include_once ("routines/website/manipulation_categorie.php");
	include_once ("routines/website/manipulation_contexte.php");
	include_once ("routines/website/manipulation_decoration.php");
	include_once ("routines/website/manipulation_document.php");
	include_once ("routines/website/manipulation_groupe.php");
	include_once ("routines/website/manipulation_module.php");
	include_once ("routines/website/manipulation_mot_cle.php");
	include_once ("routines/website/manipulation_presentation.php");
	include_once ("routines/website/manipulation_site.php");
	include_once ("routines/website/manipulation_theme.php");
	include_once ("routines/website/manipulation_tag.php");
	include_once ("routines/website/manipulation_utilisateur.php");
	include_once ("routines/website/console_de_commande.php");

	$_REQUEST['sql_initiateur']			= "Installation extension";
	$_REQUEST['contexte_d_execution']	= "Extension_installation";
	$_REQUEST['mode_operatoire'] 		= "connexion_directe";
//	include_once ("install/install_routines/fonction_install.php");
	include_once ("routines/website/formattage_commande.php");

	$chemin = "../extensions/".$_REQUEST['M_EXTENS']['extension_repertoire'];  $methode = "filename";	$section = "tables_creation";
	include ("install/install_routines/admin_creation_database.php");
	statistique_checkpoint ( "Apres creation BDD" );

	$chemin = "../extensions/".$_REQUEST['M_EXTENS']['extension_repertoire'];  $methode = "filename";	$section = "tables_data";
	include ("install/install_routines/admin_creation_database.php");
	statistique_checkpoint ( "Apres remplissage table" );

	$_REQUEST['site_context']['site_nom']	= $site_web['sw_nom'];
	$_REQUEST['site_context']['site_lang']	= $site_web['sw_lang'];
	$_REQUEST['site_context']['user']		= $_REQUEST['form']['database_user_login'] = $db_['user_login'];
	$_REQUEST['site_context']['password']	= $_REQUEST['form']['database_user_password'] = $db_['user_password'];
	$chemin = "../extensions/".$_REQUEST['M_EXTENS']['extension_repertoire'];  $methode = "console de commandes";	$section = "script";
	include ("install/install_routines/admin_creation_database.php");
	statistique_checkpoint ( "Apres execution des scripts de commandes" );

// --------------------------------------------------------------------------------------------
// Post-install/desinstall
  	switch ( $_REQUEST['M_EXTENS']['extension_requete'] ) {
	case "Installer":	$CI = $P['F_Configuration'];			break;
	case "Retirer":		$CI = $P['F_EffaceConfiguration'];		break;
	}
	$pv['i'] = 0;
	if ( function_exists ( $CI ) ) { $CI(); }
	else { echo ("Fail!!"); }
// --------------------------------------------------------------------------------------------
// Affichage information

	switch ( $_REQUEST['M_EXTENS']['extension_requete'] ) {
	case "Installer":
		// Check
		$pv['diagnostic_extension'] = array();
		$dp['extension_enregistrement'] = "ERR";
		$dp['extension_table1'] = "ERR";

		$CI = $P['F_CheckInstall'];
		if ( function_exists ( $CI ) ) { $CI(); }
		else { echo ("Fail!!"); }

		// Affichage du résultat
		$dp = &$pv['diagnostic_extension'];
		$tl_['eng']['score']['ok'] = "Ok";						$tl_['fra']['score']['ok'] = "Succ&egrave;s";
		$tl_['eng']['score']['FAIL'] = "Errors appeared";		$tl_['fra']['score']['FAIL'] = "Erreurs tourv&eacute;es";
		$tl_['eng']['score']['ERR'] = "Total failure";			$tl_['fra']['score']['ERR'] = "Echec total";

		$tl_['txt']['eng']['invite1'] = $P['extension_nom'] . " installation...";		
		$tl_['txt']['fra']['invite1'] = "Installation de " . $P['extension_nom'] . "...";
		$tl_['txt']['eng']['col_1_txt'] = "Opération";		$tl_['txt']['fra']['col_1_txt'] = "Op&eacute;ration";
		$tl_['txt']['eng']['col_2_txt'] = "Status";			$tl_['txt']['fra']['col_2_txt'] = "Status";

		$pv['i'] = 1;
		$tl_['eng']['dp_text'] = "Registering";	$tl_['fra']['dp_text'] = "Enregistrement";
		$AD['1'][$pv['i']]['1']['cont'] = $tl_[$l]['dp_text'];
		$AD['1'][$pv['i']]['2']['cont'] = $tl_[$l]['score'][$dp['extension_enregistrement']];

		unset ( $A );
		foreach ( $dp['tables'] as $A ) {
			$pv['i']++;
			$tl_['eng']['dp_table1'] = "Creating table ". $A['nom'];	$tl_['fra']['dp_table1'] = "Cr&eacute;ation de la table ". $A['nom'];
			$AD['1'][$pv['i']]['1']['cont'] = $tl_[$l]['dp_table1'];
			$AD['1'][$pv['i']]['2']['cont'] = $tl_[$l][$A['etat']];
		}

		$pv['i']++;
		$tl_['eng']['dp_text'] = "Creating documents";	$tl_['fra']['dp_text'] = "Cr&eacute;ation des documents";
		$AD['1'][$pv['i']]['1']['cont'] = $tl_[$l]['dp_text'];
		$AD['1'][$pv['i']]['2']['cont'] = $tl_[$l]['score'][$dp['documents']];

		$pv['i']++;
		$tl_['eng']['dp_text'] = "Creating articles";	$tl_['fra']['dp_text'] = "Cr&eacute;ation des articles";
		$AD['1'][$pv['i']]['1']['cont'] = $tl_[$l]['dp_text'];
		$AD['1'][$pv['i']]['2']['cont'] = $tl_[$l]['score'][$dp['articles']];

		$pv['i']++;
		$tl_['eng']['dp_text'] = "Creating categories";	$tl_['fra']['dp_text'] = "Cr&eacute;ation des cat&eacute;rogies";
		$AD['1'][$pv['i']]['1']['cont'] = $tl_[$l]['dp_text'];
		$AD['1'][$pv['i']]['2']['cont'] = $tl_[$l]['score'][$dp['categories']];

		$ADC['onglet']['1']['nbr_ligne'] = $pv['i'];	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 1;
		$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

		$tab_infos['AffOnglet']			= 1;
		$tab_infos['NbrOnglet']			= 1;
		$tab_infos['tab_comportement']	= 0;
		$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
		$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
		$tab_infos['doc_height']		= 512;
		$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
		$tab_infos['groupe']			= "edc_grp1";
		$tab_infos['cell_id']			= "tab";
		$tab_infos['document']			= "doc";
		$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
		include ("routines/website/affichage_donnees.php");
	break;
	case "Retirer":
	break;
	}

	$tl_['eng']['boutonmsg1'] = "Return to list";		$tl_['fra']['boutonmsg1'] = "Retour &agrave; la liste";

	$_REQUEST['BS']['id']				= "formulaire_Retourp1";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['boutonmsg1'];
	$_REQUEST['BS']['mode']				= 0;
	$_REQUEST['BS']['taille'] 			= 0;
	$_REQUEST['BS']['derniere_taille']	= 0;
	echo ("<br>\r
	<form ACTION='index.php?' method='post' name='formulaire_Retourp1'>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref'].
	"<input type='hidden' name='arti_page'					value='1'>\r
	". generation_bouton () . "</form>\r");
}
else { echo ("!!!!!!!!!!!!!!!!"); }

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$A,
		$B , 
		$CI,
		$ĈCI,
		$dbquery , 
		$dbp , 
		$extensions_,
		$P,
		$pv,
		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
