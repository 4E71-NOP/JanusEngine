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
//	Manipulation des utilisateurs
// --------------------------------------------------------------------------------------------
function manipulation_utilisateur () {
	global $site_web, $SQL_tab, $SQL_tab_abrege, $db, $db_, $user, $langues;
	$R = &$_REQUEST['M_UTILIS'];

	$_REQUEST['conv_expr_section'] = "M_UTILIS";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];																	// recupere la langue courante
	$tl_['eng']['si'] = "User processing ";
	$tl_['fra']['si'] = "Manipulation utilisateur";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0 ) {
		$tl_['eng']['M_UTILIS_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_UTILIS_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_UTILIS_00001" , $tl_[$l]['M_UTILIS_00001'] );
		$R['ERR'] = 1;
	}
	else {
		//$_REQUEST['site_context']['site_id'] = $_REQUEST['site_context']['site_id'];
		//$_REQUEST['site_context']['site_nom'] = $_REQUEST['site_context']['site_nom'];
		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//	Pas d'action
		case 0:
		break;

// --------------------------------------------------------------------------------------------
//	Creation
		case 1: 
			string_DB_escape ( $_REQUEST['liste_colonne']['user'] , $_REQUEST['conv_expr_section'] );
			install_utilisateur_initial ( $R['user_login'] , $R['user_password'] );
			$R['password'] = hash ("sha1", $R['password'] );

			systeme_requete_unifiee ( 3 , "M_UTILIS_rdl" , $R['user_login'] , 0 , "M_UTILIS_1_0001" , $_REQUEST['fake'] );
			if ( $R['ERR'] == 0 ) {
				if ( strlen($R['user_pref_theme']) != 0 ) { 
					systeme_requete_unifiee ( 2 , "M_UTILIS_res" , $R['user_pref_theme'] , 0 , "M_UTILIS_1_0002" , $R['user_pref_theme'] );
				 }

				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['user_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				$R['user_id'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['user'] , "user_id" );

				reset ( $_REQUEST['liste_colonne']['user'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['user'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SQL_tab_abrege['user']." VALUES ".$requete_valeurs.";";

				if ( $R['login'] == "anonymous" ) {
					$dbquery = requete_sql( $_REQUEST['sql_initiateur'] ,"
					SELECT a.groupe_id AS groupe_id,a.groupe_nom AS groupe_nom 
					FROM ".$SQL_tab_abrege['groupe']." a, ".$SQL_tab_abrege['site_groupe']." b 
					WHERE a.groupe_tag = '0'
					AND a.groupe_id = b.groupe_id
					AND b.site_id = '".$_REQUEST['site_context']['site_id']."'
					;");
					while ($dbp = fetch_array_sql($dbquery)) { $MU_forge_groupe = $dbp['groupe_id']; }
				}
				else {
					$dbquery = requete_sql( $_REQUEST['sql_initiateur'] ,"
					SELECT a.groupe_id AS groupe_id,a.groupe_nom AS groupe_nom  
					FROM ".$SQL_tab_abrege['groupe']." a, ".$SQL_tab_abrege['site_groupe']." b 
					WHERE a.groupe_tag = '1'
					AND a.groupe_id = b.groupe_id
					AND b.site_id = '".$_REQUEST['site_context']['site_id']."'
					;");
					while ($dbp = fetch_array_sql($dbquery)) { $MU_forge_groupe = $dbp['groupe_id']; }
				}

				$R['id2'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['groupe_user'] , "groupe_user_id" );
				$requete2 = "
				INSERT INTO ".$SQL_tab_abrege['groupe_user']." VALUES ( 
				'".$R['id2']."',
				'".$MU_forge_groupe."',
				'".$R['user_id']."',
				'1'
				);";

				manipulation_traitement_requete ( $requete1 );
				manipulation_traitement_requete ( $requete2 );

				$tl_['eng']['M_UTILIS_1_03'] = "Done";
				$tl_['fra']['M_UTILIS_1_03'] = "Execution effectu&eacute;e.";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "M_UTILIS_1_0003" , $tl_[$l]['M_UTILIS_1_03'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['fiche'] = $R['id'];
				//$pv['utilisateur_selection'] = $R['id'];
				$R['creation_effectuee'] = 1;
				$R['utilisateur_selection'] = $pv['utilisateur_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//	Modification
		case 2:
			install_utilisateur_initial ( $R['user_login'] , $R['user_password'] );
			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
				$tl_['eng']['M_UTILIS_2_04'] = "The user '".$R['login']."' has not been updated. Confirmation forgotten";
				$tl_['fra']['M_UTILIS_2_04'] = "L'utilisateur '".$R['login']."' n'a pas &eacute;t&eacute; mis a jour. Oubli de la confirmation" ;
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $site_web['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_UTILIS_2_0004" , $tl_[$l]['M_UTILIS_2_04'] );
			}

			string_DB_escape ( $_REQUEST['liste_colonne']['user'] , $_REQUEST['conv_expr_section'] );

			systeme_requete_unifiee ( 2 , "M_UTILIS_rel" , $R['user_login'] , 0 , "M_UTILIS_2_0001" , $R['user_id'] );
			if ( $R['ERR'] != 1 ) {
				if ( strlen($R['pref_theme']) != 0 ) { 
					systeme_requete_unifiee ( 2 , "M_UTILIS_res" , $R['user_pref_theme'] , 0 , "M_UTILIS_2_0002" , $R['user_pref_theme'] );
				}

				foreach ( $_REQUEST['liste_colonne']['user_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				//$R['user_id'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['user'] , "user_id" );

				string_DB_escape ( $_REQUEST['liste_colonne']['user'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['user'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['user'] as $A ) {
					$requete_colonne .= $A . "='".$R[$A]."', ";
				}
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );

				$requete1 = "UPDATE ".$SQL_tab_abrege['user']." SET ".$requete_colonne." WHERE user_id = '".$R['user_id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_UTILIS_2_03'] = "The user '".$R['user_login']."' has been updated";
				$tl_['fra']['M_UTILIS_2_03'] = "L'utilisateur '".$R['user_login']."' a &eacute;t&eacute; mis a jour.";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $site_web['site_nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "M_UTILIS_2_0003" , $tl_[$l]['M_UTILIS_2_03'] );
				$_REQUEST['CC']['status'] = "OK";

				$_REQUEST['M_UTILIS']['fiche'] = $R['user_id'];
				//$pv['utilisateur_selection'] = $R['user_id'];
				$R['modification_effectuee'] = 1;
				$R['utilisateur_selection'] = $pv['utilisateur_selection'];
				$R['fiche'] = $R['user_id'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	Suppresion
		case 3:
			foreach ( $R as &$TMU ) { 
/*				switch ( $db_['dal'] ) {
				case "MYSQLI":		$TMU = $db->real_escape_string($TMU);					break;
				case "PDOMYSQL":	$TMU = $db->quote($TMU);								break;
				case "SQLITE":																break;
				case "ADODB":		$TMU = $db->qstr($TMU);									break;
				case "PEARDB":	
				case "PEARSQLITE":	$TMU = $db->escape($TMU , $escape_wildcards = false);	break;
				}
*/
				$TMU = string_DAL_escape ( $TMU );
			}
			unset($TMU);

			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}

			systeme_requete_unifiee ( 2 , "M_UTILIS_rel" , $R['user_login'] , 0 , "M_UTILIS_3_0001" , $R['user_id'] );
			if ( $R['ERR'] == 0 ) {
				if ( $R['confirmation_suppression'] == 1 ) {
					$requete1 = "
					UPDATE ".$SQL_tab_abrege['user']." 
					SET user_status = '2' 
					WHERE user_id = '".$R['user_id']."'
					;";
					manipulation_traitement_requete ( $requete1 );

					$tl_['eng']['M_UTILIS_3_01'] = "The user '".$R['user_login']."' has been deleted";
					$tl_['fra']['M_UTILIS_3_01'] = "L'utilisateur ".$R['user_login']." a ete supprim&eacute; (".$_REQUEST['site_context']['site_titre'].")." ;
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_UTILIS_3_0001" , $tl_[$l]['M_UTILIS_3_01'] );
					$_REQUEST['CC']['status'] = "OK";

					$pv['utilisateur_selection'] = $R['user_id'];
					$R['modification_effectuee'] = 1;
					$R['utilisateur_selection'] = $pv['utilisateur_selection'];
					$_REQUEST['M_UTILIS']['fiche'] = $R['id'];

				}
				else { $R['confirmation_suppression_oubli'] = 1; } 
			}
		break;
// --------------------------------------------------------------------------------------------
//	rejoint un groupe
		case 4:
			install_utilisateur_initial ( $R['user_login'] , $R['user_password'] );
			string_DB_escape ( $_REQUEST['liste_colonne']['user'] , $_REQUEST['conv_expr_section'] );

			systeme_requete_unifiee ( 2 , "M_UTILIS_rel" , $R['user_login'] , 0 , "M_UTILIS_4_0001" , $R['user_id'] );
			systeme_requete_unifiee ( 2 , "M_UTILIS_reg" , $R['join_group'] , 0 , "M_UTILIS_4_0002" , $_REQUEST['M_UTILIS_group_dest'] );
			systeme_requete_unifiee ( 3 , "M_UTILIS_rer" , $_REQUEST['M_UTILIS_group_dest'] , $R['user_id'] , "M_UTILIS_4_0003" , $_REQUEST['fake'] );
			if ( $R['ERR'] == 0 ) {
				$R['user_groupe_premier']	= conversion_expression ($R['user_groupe_premier']);
				if ( $R['user_groupe_premier'] == 1 ) {
					$requete1 = "UPDATE ".$SQL_tab_abrege['groupe_user']." SET
					groupe_premier = '0' 
					WHERE user_id = '".$R['user_id']."'
					;";
					manipulation_traitement_requete ( $requete1 );
				}
				$_REQUEST['M_UTILIS_groupe_user_id']	= manipulation_trouve_id_suivant ( $SQL_tab_abrege['groupe_user'] , "groupe_user_id" );
				$requete1 = "
				INSERT INTO ".$SQL_tab_abrege['groupe_user']." VALUES (
				'".$_REQUEST['M_UTILIS_groupe_user_id']."',
				'".$_REQUEST['M_UTILIS_group_dest']."',
				'".$R['user_id']."',
				'".$R['user_groupe_premier']."'
				);";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_UTILIS_4_01'] = "Done";
				$tl_['fra']['M_UTILIS_4_01'] = "Execution effectu&eacute;e.";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "M_UTILIS_1_0004" , $tl_[$l]['M_UTILIS_4_01'] );
				$_REQUEST['CC']['status'] = "OK";

				$_REQUEST['M_UTILIS']['fiche'] = $R['user_id'];
				$R['modification_effectuee'] = 1;
				$R['utilisateur_selection'] = $pv['utilisateur_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//	show
		case 5:
			$tl_['eng']['M_UTILIS_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_UTILIS_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_UTILIS_5_caption'];

			if ( $R['user_login'] == "NA" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND usr.user_login LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT usr.user_login, usr.user_perso_nom 
				FROM ".$SQL_tab_abrege['user']." as usr , ".$SQL_tab_abrege['groupe_user']." as gu , ".$SQL_tab_abrege['site_groupe']." as sg 
				WHERE usr.user_id = gu.user_id 
				AND gu.groupe_id = sg.groupe_id 
				AND gu.groupe_premier = '1' 
				AND sg.site_id = ".$_REQUEST['site_context']['site_id']."
				".$pv['clause']."
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['user_login'] . " (" . $dbp['user_perso_nom'] . "), "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT usr.*  
				FROM ".$SQL_tab_abrege['user']." as usr , ".$SQL_tab_abrege['groupe_user']." as gu , ".$SQL_tab_abrege['site_groupe']." as sg 
				WHERE usr.user_id = gu.user_id 
				AND gu.groupe_id = sg.groupe_id 
				AND gu.groupe_premier = '1' 
				AND sg.site_id = ".$_REQUEST['site_context']['site_id']." 
				AND usr.user_login = '".$R['login']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_UTILIS_5_001'] = "No user named ".$_REQUEST['M_GROUPE']['nom']." exists.";
					$tl_['fra']['M_UTILIS_5_001'] = "L'utilisateur nom&eacute; ".$_REQUEST['M_GROUPE']['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_UTILIS_5_0001" , $tl_[$l]['M_UTILIS_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}

					$tl_['eng']['yn']['0'] = "No";			$tl_['fra']['yn']['0'] = "Non";
					$tl_['eng']['yn']['1'] = "Yes";			$tl_['fra']['yn']['1'] = "Oui";
					$tl_['eng']['oo']['0'] = "Offline";		$tl_['fra']['oo']['0'] = "Hors ligne";
					$tl_['eng']['oo']['1'] = "Online";		$tl_['fra']['oo']['1'] = "En ligne";
					$tl_['eng']['oo']['3'] = "Deleted";		$tl_['fra']['oo']['3'] = "Supprim&eacute;";
					$tl_['eng']['s']['0'] = "Not active";		$tl_['fra']['s']['0'] = "Inactif";
					$tl_['eng']['s']['1'] = "Active";			$tl_['fra']['s']['1'] = "Actif";
					$tl_['eng']['s']['2'] = "Deleted";		$tl_['fra']['s']['2'] = "Supprim&eacute;";
					$tl_['eng']['rol']['1'] = "Private";		$tl_['fra']['rol']['1'] = "Priv&eacute;";
					$tl_['eng']['rol']['2'] = "Public";		$tl_['fra']['rol']['2'] = "Publique";

					$pv = $_REQUEST['ICC']['user_status'];			$_REQUEST['ICC']['user_status'] = $tl_[$l]['s'][$pv];
					$pv = $_REQUEST['ICC']['user_role_fonction'];	$_REQUEST['ICC']['user_role_fonction'] = $tl_[$l]['rol'][$pv];
					//$pv = $_REQUEST['ICC']['user_droit_tribune'];	$_REQUEST['ICC']['user_droit_tribune'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_droit_forum'];		$_REQUEST['ICC']['user_droit_forum'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_lang'];			$_REQUEST['ICC']['user_lang'] = $langues[$pv]['langue_639_3'];

					$pv = $_REQUEST['ICC']['user_pref_newsletter'];					$_REQUEST['ICC']['user_pref_newsletter'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_pref_montre_email'];				$_REQUEST['ICC']['user_pref_montre_email'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_pref_montre_status_online'];		$_REQUEST['ICC']['user_pref_montre_status_online'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_pref_notification_reponse_forum'];	$_REQUEST['ICC']['user_pref_notification_reponse_forum'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_pref_notification_nouveau_pm'];	$_REQUEST['ICC']['user_pref_notification_nouveau_pm'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_pref_autorise_bbcode'];			$_REQUEST['ICC']['user_pref_autorise_bbcode'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_pref_autorise_html'];				$_REQUEST['ICC']['user_pref_autorise_html'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_pref_autorise_smilies'];			$_REQUEST['ICC']['user_pref_autorise_smilies'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_image_avatar'];					$_REQUEST['ICC']['user_image_avatar'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['user_admin_commentaire'];				$_REQUEST['ICC']['user_admin_commentaire'] = $tl_[$l]['yn'][$pv];
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
unset ( $R );
}
?>
