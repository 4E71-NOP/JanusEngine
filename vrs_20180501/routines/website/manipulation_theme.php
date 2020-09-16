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
//	Manipulation theme
// --------------------------------------------------------------------------------------------
function manipulation_theme () {
	global $site_web, $SQL_tab, $SQL_tab_abrege, $db;
	$R = &$_REQUEST['M_THEME'];

	$_REQUEST['conv_expr_section'] = "M_THEME";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];																	// recupere la langue courante
	$tl_['eng']['si'] = "Theme processing ";
	$tl_['fra']['si'] = "Manipulation theme";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;

	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_THEME_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_THEME_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_THEME_00001" , $tl_[$l]['M_THEME_00001'] );
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
//	Creation de theme
		case 1:
			systeme_requete_unifiee ( 3 , "M_THEME_rdt" , $R['nom'] , 0 , "M_THEME_1_0001" , $_REQUEST['fake'] );

			if ( $R['ERR'] != 1 ) {
				$R['theme_id'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['theme_descripteur'] , "theme_id" );

				string_DB_escape ( $_REQUEST['liste_colonne']['theme'] , $_REQUEST['conv_expr_section'] );
				foreach ( $_REQUEST['liste_colonne']['theme_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }

				reset ( $_REQUEST['liste_colonne']['theme'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['theme'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SQL_tab_abrege['theme_descripteur']." VALUES ".$requete_valeurs.";";

				$R['id2'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['site_theme'] , "site_theme_id" );
				$requete2 = "
				INSERT INTO ".$SQL_tab_abrege['site_theme']." VALUES ( 
				'".$R['id2']."',
				'".$_REQUEST['site_context']['site_id']."',
				'".$R['theme_id']."',
				'".$R['theme_etat']."'
				);";

				manipulation_traitement_requete ( $requete1 );
				manipulation_traitement_requete ( $requete2 );
				$tl_['eng']['ok'] = "Job done!";
				$tl_['fra']['ok'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_THEME_1_0002" , $tl_[$l]['ok'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['creation_effectuee'] = 1;
				$R['theme_selection'] = $R['id'];
				$R['theme_id_selection'] = $R['id'];
				//$pv['theme_selection'] = $_REQUEST['MS']['id'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	Modification de theme
		case 2:
			systeme_requete_unifiee ( 2 , "M_THEME_ret" , $R['nom'] , 0 , "M_THEME_2_0001" , $R['id'] );

			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {

				foreach ( $_REQUEST['liste_colonne']['theme_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				string_DB_escape ( $_REQUEST['liste_colonne']['theme'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['theme'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['theme'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SQL_tab_abrege['theme_descripteur']." SET ".$requete_colonne." WHERE theme_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['ok'] = "Job done!";
				$tl_['fra']['ok'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_THEME_2_0002" , $tl_[$l]['ok'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['modification_effectuee'] = 1;
				$pv['theme_selection'] = $R['id'];
				$R['theme_id_selection'] = $R['id'];
				$_REQUEST['uni_gestion_des_theme_p'] = 2;
			}
		break;
// --------------------------------------------------------------------------------------------
//	Suppression de theme
		case 3:
			systeme_requete_unifiee ( 2 , "M_THEME_rdt" , $R['theme_nom'] , 0 , "M_THEME_3_0001" , $R['theme_id'] );
			//$R['theme_id_selection'] = $R['id'];

			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				$requete1 = "
				DELETE ".$SQL_tab_abrege['theme_descripteur']." 
				WHERE theme_id = '".$R['theme_id']."'
				;";

				manipulation_traitement_requete ( $requete1 );
				$tl_['eng']['ok'] = "Job done!";
				$tl_['fra']['ok'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_THEME_3_0002" , $tl_[$l]['ok'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['theme_selection'] = $_REQUEST['MS']['id'];
				$R['modification_effectuee'] = 1;
				$R['theme_selection'] = $pv['theme_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	Repechage de theme
		case 4:
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['MS_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['MS_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['MS_5_caption'];
			if ( $R['nom'] == "Nouvelle theme" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND theme_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT tm.theme_nom 
				FROM ".$SQL_tab_abrege['theme_descripteur']." AS tm, ".$SQL_tab_abrege['site_theme']." AS ss 
				WHERE ss.theme_id = tm.theme_id 
				AND ss.site_id = '".$_REQUEST['site_context']['site_id']."' 
				".$pv['clause']." 
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['theme_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT rm.*, ss.theme_etat 
				FROM ".$SQL_tab_abrege['theme_descripteur']." AS tm, ".$SQL_tab_abrege['site_theme']." AS ss 
				WHERE ss.theme_id = tm.theme_id 
				AND ss.site_id = '".$_REQUEST['site_context']['site_id']."' 
				AND theme_nom = '".$R['nom']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_THEME_5_001'] = "No theme named ".$R['nom']." exists.";
					$tl_['fra']['M_THEME_5_001'] = "Le theme nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_THEME_5_0001" , $tl_[$l]['M_THEME_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$tl_['eng']['oo']['0'] = "Offline";		$tl_['fra']['oo']['0'] = "Hors ligne";
					$tl_['eng']['oo']['1'] = "Online";		$tl_['fra']['oo']['1'] = "En ligne";
					$tl_['eng']['oo']['3'] = "Deleted";		$tl_['fra']['oo']['3'] = "Supprim&eacute;";
					$pv = $_REQUEST['ICC']['theme_etat'];		$_REQUEST['ICC']['theme_etat'] = $tl_[$l]['oo'][$pv];
					$_REQUEST['ICC']['theme_admctrl_size_x'] .= "px";
					$_REQUEST['ICC']['theme_admctrl_size_y'] .= "px";
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
//unset ( $R );
//outil_debug ( $_REQUEST['M_THEME'] , "_REQUEST['M_THEME']" );
}
?>
