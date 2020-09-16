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
//	Manipulation document
// --------------------------------------------------------------------------------------------
function document_rch_existence_correcteur ($code_erreur) {
	global $SQL_tab_abrege;
	$R = &$_REQUEST['M_DOCUME'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT sw_id FROM ".$SQL_tab_abrege['site_web']." 
	WHERE sw_nom = '".$R['docu_du_site']."' 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { $R['docu_du_site'] = $dbp['sw_id'];} 

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT usr.user_login,usr.user_id 
	FROM ".$SQL_tab_abrege['user']." usr , ".$SQL_tab_abrege['groupe_user']." gu , ".$SQL_tab_abrege['site_groupe']." sg 
	WHERE usr.user_login = '".$R['docu_correcteur']."' 
	AND usr.user_id = gu.user_id 
	AND gu.groupe_id = sg.groupe_id 
	AND sg.site_id = '".$R['docu_du_site']."' 
	;");
	if ( num_row_sql($dbquery) == 0 ) {
		$l = $_REQUEST['site_context']['site_lang'];
		$tl_['eng']['err'] = "The user named '".$R['docu_correcteur']."' doesn't exists.";
		$tl_['fra']['err'] = "L'utilisateur '".$R['docu_correcteur']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "ERR" , $code_erreur , $tl_[$l]['err'] );
	}
	else { while ($dbp = fetch_array_sql($dbquery)) { $R['docu_correcteur'] = $dbp['user_id'];} }
}

function document_rch_existence_createur ($code_erreur) {
	global $SQL_tab_abrege;
	$R = &$_REQUEST['M_DOCUME'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT sw_id FROM ".$SQL_tab_abrege['site_web']." 
	WHERE sw_nom = '".$R['docu_du_site']."' 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { $R['docu_du_site'] = $dbp['sw_id'];} 

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT usr.user_login,usr.user_id 
	FROM ".$SQL_tab_abrege['user']." usr , ".$SQL_tab_abrege['groupe_user']." gu , ".$SQL_tab_abrege['site_groupe']." sg 
	WHERE usr.user_login = '".$R['docu_createur']."' 
	AND usr.user_id = gu.user_id 
	AND gu.groupe_id = sg.groupe_id 
	AND sg.site_id = '".$R['docu_du_site']."' 
	;");
	if ( num_row_sql($dbquery) == 0 ) {
		$l = $_REQUEST['site_context']['site_lang'];
		$tl_['eng']['err'] = "The user named '".$R['docu_createur']."' doesn't exists.";
		$tl_['fra']['err'] = "L'utilisateur '".$R['docu_createur']."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "ERR" , $code_erreur , $tl_[$l]['err'] );
	}
	else { while ($dbp = fetch_array_sql($dbquery)) { $R['docu_createur'] = $dbp['user_id'];} }
}

function document_rch_existence_fichier ($code_erreur) {
	$R = &$_REQUEST['M_DOCUME'];
	$MD_filename = $R['fichier_cible'];

	if ( is_file($MD_filename) != TRUE ) {
		$l = $_REQUEST['site_context']['site_lang'];
		$tl_['eng']['err'] = "The file named '".$MD_filename."' doesn't exists.";
		$tl_['fra']['err'] = "Le fichier '".$MD_filename."' n'existe pas.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "ERR" , $code_erreur , $tl_[$l]['err'] );
		$R['ERR'] = 1;
	}
	if ( is_readable($MD_filename) != TRUE ) {
		$l = $_REQUEST['site_context']['site_lang'];
		$tl_['eng']['err'] = "The file named '".$MD_filename."' isn't readable.";
		$tl_['fra']['err'] = "Le fichier '".$MD_filename."' n'est pas lisible.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "WARN" , $code_erreur , $tl_[$l]['err'] );
		$R['ERR'] = 1;
	}
}

// --------------------------------------------------------------------------------------------
function manipulation_document () {
	global $SQL_tab_abrege, $db, $db_, $user;
	$R = &$_REQUEST['M_DOCUME'];

	$_REQUEST['conv_expr_section'] = "M_DOCUME";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Document processing ";
	$tl_['fra']['si'] = "Manipulation document";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_DOCUME_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_DOCUME_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_DOCUME_00001" , $tl_[$l]['M_DOCUME_00001'] );
		$R['ERR'] = 1;
	}
	else {
		$timestamp_MD = time ();
		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//		Pas d'action
		case 0:
//		echo ("Pas de modification de cat&eacute;gorie");
		break;

// --------------------------------------------------------------------------------------------
//		Creation de document
		case 1:
			install_utilisateur_initial ( $R['docu_createur'] , $R['neant'] );
			if ( strlen($R['docu_du_site']) == 0 ) { $R['docu_du_site'] = $_REQUEST['site_context']['site_nom']; }
			if ( $_REQUEST['CC_niveau_de_verification'] == 1 ) {
				systeme_requete_unifiee ( 3 , "M_DOCUME_rdd" , $R['docu_nom'] , 0 , "M_DOCUME_1_0001" , $_REQUEST['fake'] );
				document_rch_existence_createur ("M_DOCUME_1_0003");
			}

			if ( $R['ERR'] != 1 ) {
 				$R['docu_type']	= conversion_expression ( $R['docu_type'] );			// docu_type					WMCODE 0	NOCODE 1	PHP 2	MIXED 3
 				$R['docu_id'] 	= manipulation_trouve_id_suivant ( $SQL_tab_abrege['document'] , "docu_id" );
				$R['docu_creation_date'] = time();

				$pv['rch'] = array ( "<MWM_textarea",	"<MWM_/textarea" );
				$pv['rpl'] = array ( "<texarea",		"</textarea" );
				$R['cont'] = str_replace( $pv['rch'], $pv['rpl'], $R['cont'] );

				string_DB_escape ( $_REQUEST['liste_colonne']['document'] , $_REQUEST['conv_expr_section'] );
				reset ( $_REQUEST['liste_colonne']['document'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['document'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SQL_tab_abrege['document']." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_DOCUME_1_0001'] = "Job done!";
				$tl_['fra']['M_DOCUME_1_0001'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_DOCUME_1_0001" , $tl_[$l]['M_DOCUME_1_0001'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['creation_effectuee'] = 1;
				$R['document_selection'] = $R['id'];
			}
		break;

// --------------------------------------------------------------------------------------------
//		modification de document
// --------------------------------------------------------------------------------------------
		case 2:
			install_utilisateur_initial ( $R['docu_correcteur'] , $R['neant'] );
			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}
			$R['docu_correction']		= conversion_expression ( $R['docu_correction']);
			$R['docu_correction_comp']	= conversion_expression ( $R['docu_correction_comp']);

			if ( $R['docu_correction'] == 1 ) {
				if ( strlen($R['docu_correcteur']) == 0 ) { $R['docu_correcteur'] = $R['docu_correcteur_id']; }
				else { 
					if ( strlen($R['du_site']) == 0 ) { $R['du_site'] = $_REQUEST['site_context']['site_nom']; }
					document_rch_existence_correcteur ("M_DOCUME_2_0003"); 
				}
			}
			if ( $R['docu_correction_comp'] != $R['docu_correction'] && $R['docu_correction'] == 1 ) { $requete1_date  = "docu_correction_date	= '". time() ."', "; }
			if ( $R['ERR'] != 1 ) {

				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['document_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A] ); }

//				string_DB_conversion_expression ( $_REQUEST['liste_colonne']['document_conversion'] , $_REQUEST['conv_expr_section'] );

				if ( $_REQUEST['contexte_d_execution'] == "Admin_menu" ) {
					$tab_rch = array ("<*G1*>",	"<*G2*>",	"<MWM_textarea",	"<MWM_/textarea" );
					$tab_rpl = array ("'",		'"',		"<texarea",			"</textarea" );
					$R['cont'] = str_replace ($tab_rch,$tab_rpl,$R['cont']);											

					switch ( $db_['dal'] ) {
					case "MYSQLI":		$R['cont'] = $db->real_escape_string( $R['cont'] );	break;
					case "PDOMYSQL":	$R['cont'] = $db->quote( $R['cont'] );				break;
					case "SQLITE":															break;
					case "ADODB":		$R['cont'] = $db->qstr( $R['cont'] );				break;
					case "PEARDB":
					case "PEARSQLITE":	$R['cont'] = $db->escape( $R['cont'] );				break;
					}

					$requete1_cont = " docu_cont	= '".$R['cont']."', "; 
				}
				string_DB_escape ( $_REQUEST['liste_colonne']['document'] , $_REQUEST['conv_expr_section'] );

				$requete1 = "
				UPDATE ".$SQL_tab_abrege['document']." SET 
				docu_correction	= '".$R['docu_correction']."', 
				docu_correcteur	= '".$R['docu_correcteur']."', 
				".$requete1_date." 
				".$requete1_cont." 
				docu_type 		= '".$R['docu_type']."'
				WHERE docu_id = '".$R['docu_id']."'
				;";
				manipulation_traitement_requete ( $requete1 );

				$requete1 = "
				UPDATE ".$SQL_tab_abrege['document_partage']." SET 
				part_modification 	= '".$R['docu_modification']."' 
				WHERE docu_id = '".$R['docu_id']."' 
				;";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_DOCUME_2_0002'] = "Job done!";
				$tl_['fra']['M_DOCUME_2_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_DOCUME_2_0002" , $tl_[$l]['M_DOCUME_2_0002'] );
				$_REQUEST['CC']['status'] = "OK";
				$R['modification_effectuee'] = 1; 
			}

			$R['modification_effectuee'] = 1;
			$R['document_selection'] = $R['id'];
		break;

// --------------------------------------------------------------------------------------------
//		Suppression de document
// --------------------------------------------------------------------------------------------
		case 3:
			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}
			if ( $_REQUEST['CC_niveau_de_verification'] == 1 ) {
				systeme_requete_unifiee ( 2 , "M_DOCUME_red" , $R['nom'] , 0 , "M_DOCUME_1_0001" , $R['docu_id'] );
			}

			if ( $R['ERR'] != 1 ) {
				$requete = "
				DELETE FROM ".$SQL_tab_abrege['document']." 
				WHERE docu_id = '".$R['docu_id']."'
				;";
				manipulation_traitement_requete ( $requete );

				$requete = "
				UPDATE ".$SQL_tab_abrege['article']." SET
				arti_validation_etat	= '0' 
				WHERE docu_id = '".$R['docu_id']."'
				;";
				manipulation_traitement_requete ( $requete );

				$requete = "
				DELETE FROM ".$SQL_tab_abrege['document_partage']." 
				WHERE docu_id = '".$R['docu_id']."'
				AND site_id = ".$_REQUEST['site_context']['site_id'].";";
				manipulation_traitement_requete ( $requete );

				$tl_['eng']['M_DOCUME_2_0002'] = "Job done!";
				$tl_['fra']['M_DOCUME_2_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_DOCUME_2_0002" , $tl_[$l]['M_DOCUME_2_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['modification_effectuee'] = 1;
				$R['document_selection'] = $R['id'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	Remplacement du contenu d'un document par celui d'un fichier
// --------------------------------------------------------------------------------------------
/*
log des differences a inclure comme option.
			if ( $MA_log_utilisation_diff == 1 ) {
				include ("diff.php");
				$MA_changements = addslashes( PHPDiff( $_REQUEST['M_ARTICL']['docu_ancien_contenu'] , $_REQUEST['M_ARTICL']['article_submit_contenu'] ) );
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , "$_REQUEST['tampon_commande']" , "WARN" , "M_ARTICL_2_0001" , "Modification de l'article ".$_REQUEST['M_ARTICL']['nom']." : $MA_changements" );
			}
*/
		case 29:
			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}

			switch ( $_REQUEST['contexte_d_execution'] ) {
				case "Admin_menu" :				$R['fichier_cible'] = $R['fichier'];																				break;
				case "Installation" :			$R['fichier_cible'] = "../websites-datas/".$_REQUEST['site_context']['site_repertoire']."/document/".$R['fichier'];	break;
				case "Extension_installation":	$R['fichier_cible'] = "../extensions/".$_REQUEST['M_EXTENS']['extension_repertoire']."/_installation/document/".$R['fichier'];	break;
			}
			systeme_requete_unifiee ( 2 , "M_DOCUME_red" , $R['nom'] , 0 , "M_DOCUME_29_0001" , $R['id']);
			if ( $_REQUEST['CC_niveau_de_verification'] == 1 ) { document_rch_existence_fichier ("M_DOCUME_29_0002"); }

			if ( file_exists($R['fichier_cible']) ) { 

				$MD_file_content = file( $R['fichier_cible'] );
				foreach ( $MD_file_content as $line ) { $MD_content .= $line; }

				$MD_ptr_d = stripos( $MD_content , "/*Hydre-contenu_debut*/" , 0) + 23 ;
				$MD_ptr_f = stripos( $MD_content , "/*Hydre-contenu_fin*/" , 0);
					if ( $MD_ptr_d > $MD_ptr_f ) {
						$tl_['eng']['err'] = "The end tag was found before the start tag in file '".$R['fichier_cible']."'.";
						$tl_['fra']['err'] = "La balise de fin se trouve avant celle du d&eacute;but dans le fichier '".$R['fichier_cible']."'.";
						journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "ERR" , "M_DOCUME_29_0004" , $tl_[$l]['err'] );
						$R['ERR'] = 1;
					}

				$MD_ptr_d_count = substr_count( $MD_content , "/*Hydre-contenu_debut*/");
				$MD_ptr_f_count = substr_count( $MD_content , "/*Hydre-contenu_fin*/");
				if ( $MD_ptr_d_count != 1 || $MD_ptr_f_count != 1 ) {
					$tl_['eng']['err'] = "Incorrect tag count in file '".$R['fichier_cible']."' ( D: ".$MD_ptr_d_count." ; F: ".$MD_ptr_d_count." ).";
					$tl_['fra']['err'] = "Nombre incorecte de balises dans le fichier '".$R['fichier_cible']."' ( D:".$MD_ptr_d_count." ; F: ".$MD_ptr_d_count." ).";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "ERR" , "M_DOCUME_29_0005" , $tl_[$l]['err'] );
					$R['ERR'] = 1;
				}

				if ( strlen($MD_content) > 65536 ) {
					$tl_['taille_docu'] = (strlen($MD_content) / 1024 ) ;
					$tl_['eng']['err'] = "The content is larger than 64Kb (".$tl_['taille_docu']." Kb). Some Databases are limited to 64Kb by default on BLOB.";
					$tl_['fra']['err'] = "Le contenu d&eacute;passe la taille de 64Ko (".$tl_['taille_docu']." Ko). Certaines bases de donn&eacute;es sont limit&eacute;es par d&eacute;faut a 64Ko sur les BLOB.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "WARN" , "M_DOCUME_29_0006" , $tl_[$l]['err'] );
				}
			}
			else {
				$tl_['eng']['err'] = "File not found '".$R['fichier_cible']."'.";
				$tl_['fra']['err'] = "Fichier inexistant '".$R['fichier_cible']."'.";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "ERR" , "M_DOCUME_29_0003" , $tl_[$l]['err'] );
				$R['ERR'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				switch ($_REQUEST['mode_operatoire'] ) {
				case "installation_differee":
					$tab_rch = array ("'",	"\"");
					$tab_rpl = array ("''",	"\"\"");
					$MD_content_2 = str_replace ($tab_rch,$tab_rpl,$MD_content);
					$MD_content = substr ( $MD_content ,$MD_ptr_d , ($MD_ptr_f - $MD_ptr_d) );
					$MD_content = addslashes($MD_content);
				break;
				case "connexion_directe":
					$MD_content = substr ( $MD_content ,$MD_ptr_d , ($MD_ptr_f - $MD_ptr_d) );
					$MD_content = addslashes($MD_content);
				break;
				}

				$requete1 = "
				UPDATE ".$SQL_tab_abrege['document']." SET
				docu_correction = '".$user['id']."',
				docu_correcteur = '".$user['id']."',
				docu_cont = '".$MD_content."'
				WHERE docu_id = '".$R['id']."'
				;";
				$requete2 = "
				UPDATE ".$SQL_tab_abrege['document']." SET
				docu_correction = '".$user['id']."',
				docu_correcteur = '".$user['id']."',
				docu_cont = '".$MD_content_2."'
				WHERE docu_id = '".$R['id']."'
				;";

				switch ( $_REQUEST['mode_operatoire'] ) {
					case "installation_differee":
						$tab_rch = array (chr(13),	"\n",	"\r",	"\n\r",	"\r\n",	"	",	"*/");
						$tab_rpl = array (" ",		" ",	" ",	" ",	" ",	" ",	"*/\n");
						$requete1 = str_replace ($tab_rch,$tab_rpl,$requete1);
						$requete2 = str_replace ($tab_rch,$tab_rpl,$requete2);
						manipulation_traitement_requete ( $requete2 );
						$master_install_script .= $requete1 . "\n";
					break;
					case "connexion_directe":
						manipulation_traitement_requete ( $requete1 );
					break;
				}

				$tl_['eng']['M_DOCUME_29_0001'] = "Job done!";
				$tl_['fra']['M_DOCUME_29_0001'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_DOCUME_29_0001" , $tl_[$l]['M_DOCUME_29_0001'] );
				$_REQUEST['CC']['status'] = "OK";
				$R['modification_effectuee'] = 1; 
			}			

//			outil_debug ( $user , "user" );
			$R['modification_effectuee'] = 1;
			$R['document_selection'] = $R['id'];
		break;
// --------------------------------------------------------------------------------------------
//		Suppression de document
// --------------------------------------------------------------------------------------------
		case 3:
		break;
// --------------------------------------------------------------------------------------------
//		Autre
// --------------------------------------------------------------------------------------------
//		Partage d'un document pour un site
		case 4:
			if ( $R['avec_site'] == "*website*" ) { $R['avec_site'] = $_REQUEST['site_context']['site_nom']; }
			systeme_requete_unifiee ( 2 , "M_DOCUME_red" , $R['docu_nom'] , 0 , "M_DOCUME_4_0001" , $R['docu_id']);
			systeme_requete_unifiee ( 2 , "M_DOCUME_res" , $R['avec_site'] , 0 , "M_DOCUME_4_0002" , $R['site_id']);
			systeme_requete_unifiee ( 3 , "M_DOCUME_rep" , $R['docu_id'] , 0 , "M_DOCUME_4_0003" , $_REQUEST['fake'] );

			if ( $R['ERR'] != 1 ) {
				$R['docu_modification']	= conversion_expression ( $R['docu_modification']);			//	part_modification	NON 0	OUI 1
				$R['part_id'] 		= manipulation_trouve_id_suivant ( $SQL_tab_abrege['document_partage'] , "part_id" );

				$requete1 = "
				INSERT INTO ".$SQL_tab_abrege['document_partage']." VALUES (
				'".$R['part_id']."',
				'".$R['docu_id']."',
				'".$R['site_id']."',
				'".$R['docu_modification']."'
				);";

				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_DOCUME_4_0004'] = "Job done!";
				$tl_['fra']['M_DOCUME_4_0004'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_DOCUME_4_0004" , $tl_[$l]['M_DOCUME_4_0004'] );
				$_REQUEST['CC']['status'] = "OK";
			}
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_DOCUME_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_DOCUME_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_DOCUME_5_caption'];
			if ( $R['nom'] == "" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND doc.docu_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT doc.docu_nom 
				FROM ".$SQL_tab_abrege['document']." AS doc, ".$SQL_tab_abrege['document_partage']." AS dp 
				WHERE dp.docu_id = doc.docu_id  
				AND dp.site_id = '".$_REQUEST['site_context']['site_id']."' 
				".$pv['clause']." 
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['docu_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT doc.* 
				FROM ".$SQL_tab_abrege['document']." AS doc, ".$SQL_tab_abrege['document_partage']." AS dp 
				WHERE dp.docu_id = doc.docu_id  
				AND dp.site_id = '".$_REQUEST['site_context']['site_id']."' 
				AND doc.docu_nom = '".$R['nom']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_DOCUME_5_001'] = "No document named ".$R['nom']." exists.";
					$tl_['fra']['M_DOCUME_5_001'] = "Le document nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_DOCUME_5_0001" , $tl_[$l]['M_DOCUME_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$tl_['eng']['typ']['0'] = "MWMcode";			$tl_['fra']['typ']['0'] = "MWMcode";
					$tl_['eng']['typ']['1'] = "No code";			$tl_['fra']['typ']['1'] = "Sans code";
					$tl_['eng']['typ']['2'] = "PHP";				$tl_['fra']['typ']['2'] = "PHP";
					$tl_['eng']['typ']['3'] = "Mixed";			$tl_['fra']['typ']['3'] = "Mixte";
					$pv = $_REQUEST['ICC']['docu_type'];			$_REQUEST['ICC']['docu_type'] = $tl_[$l]['typ'][$pv];
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
unset ( $R );
}

?>
