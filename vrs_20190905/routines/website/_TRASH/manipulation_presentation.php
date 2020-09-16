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
//	Manipulation des groupes
// --------------------------------------------------------------------------------------------
function manipulation_presentation () {
	global $WebSiteObj;
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	$R = &$_REQUEST['M_PRESNT'];

	$_REQUEST['conv_expr_section'] = "M_PRESNT";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];																	// recupere la langue courante
	$tl_['eng']['si'] = "Display processing ";
	$tl_['fra']['si'] = "Manipulation pr&eacute;sentation";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_PRESNT_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_PRESNT_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_PRESNT_00001" , $tl_[$l]['M_PRESNT_00001'] );
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
			systeme_requete_unifiee ( 3 , "M_PRESNT_rdp" , $R['nom'] , 0 , "M_PRESNT_1_0001" , $_REQUEST['fake'] );
			if ( $R['ERR'] != 1 ) {
				$R['id'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('presentation') , "pres_id" );

				string_DB_escape ( $_REQUEST['liste_colonne']['presentation'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['presentation'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['presentation'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SqlTableListObj->getSQLTableName('presentation')." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_PRESNT_1_0002'] = "Job done!";
				$tl_['fra']['M_PRESNT_1_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_PRESNT_1_0002" , $tl_[$l]['M_PRESNT_1_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['presentation_selection'] = $_REQUEST['M_PRESNT']['id'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R['creation_effectuee'] = 1;
				$R['presentation_selection'] = $pv['presentation_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	modification
		case 1: 
			systeme_requete_unifiee ( 2 , "M_PRESNT_rep" , $R['nom'] , 0 , "M_PRESNT_2_0001" , $R['id'] );

			if ( !isset($_REQUEST['MS']['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				string_DB_escape ( $_REQUEST['liste_colonne']['presentation'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['presentation'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['presentation'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SqlTableListObj->getSQLTableName('presentation')." SET ".$requete_colonne." WHERE pres_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_PRESNT_2_0002'] = "Job done!";
				$tl_['fra']['M_PRESNT_2_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_PRESNT_2_0002" , $tl_[$l]['M_PRESNT_2_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['presentation_selection'] = $_REQUEST['M_PRESNT']['id'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R['modification_effectuee'] = 1;
				$R['presentation_selection'] = $pv['presentation_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	Suppression
		case 3:
			systeme_requete_unifiee ( 2 , "M_PRESNT_rep" , $R['nom'] , 0 , "M_PRESNT_3_0001" , $R['id'] );

			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {

				$requete1= "
				DELETE FROM ".$SqlTableListObj->getSQLTableName('presentation')." 
				WHERE pres_id ='".$R['id']."'
				);";
				manipulation_traitement_requete ( $requete1 );

				$requete1= "
				DELETE FROM ".$SqlTableListObj->getSQLTableName('theme_presentation')." 
				WHERE pres_id ='".$R['id']."'
				);";
				manipulation_traitement_requete ( $requete1 );
				$tl_['eng']['M_PRESNT_3_0001'] = "Job done!";
				$tl_['fra']['M_PRESNT_3_0001'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_PRESNT_3_0001" , $tl_[$l]['M_PRESNT_3_0001'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['presentation_selection'] = $_REQUEST['M_PRESNT']['id'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R['modification_effectuee'] = 1;
				$R['presentation_selection'] = $pv['presentation_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	Assignation a un theme
		case 4:
			systeme_requete_unifiee ( 2 , "M_PRESNT_rep" , $R['nom'] , 0 , "M_PRESNT_4_0001" , $R['id'] );
			systeme_requete_unifiee ( 2 , "M_PRESNT_res" , $R['assignee_a'] , 0 , "M_PRESNT_4_0002" , $R['assignee_a'] );

			if ( $R['ERR'] != 1 ) {
				$R['defaut'] = conversion_expression ( $R['defaut']);
				$R['theme_pres_id'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('theme_presentation') , "theme_pres_id" );
				if ( $R['defaut'] == 1 ) {
					requete_sql($_REQUEST['sql_initiateur'],"
					UPDATE ".$SqlTableListObj->getSQLTableName('theme_presentation')." SET 
					pres_defaut = '0' 
					WHERE theme_id = '".$R['assignee_a']."'
					;");
				}
				$requete1= "
				INSERT INTO ".$SqlTableListObj->getSQLTableName('theme_presentation')." VALUES (
				'".$R['theme_pres_id']."',
				'".$R['assignee_a']."',
				'".$R['id']."',
				'".$R['defaut']."'
				);";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_PRESNT_4_0003'] = "Job done!";
				$tl_['fra']['M_PRESNT_4_0003'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_PRESNT_4_0003" , $tl_[$l]['M_PRESNT_4_0003'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['presentation_selection'] = $_REQUEST['M_PRESNT']['id'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R['modification_effectuee'] = 1;
				$R['presentation_selection'] = $pv['presentation_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	Modification du contenu de la presentation
		case 11:
			systeme_requete_unifiee ( 2 , "M_PRESNT_rep" , $R['nom'] , 0 , "M_PRESNT_4_0001" , $R['id'] );

			if ( $R['ERR'] != 1 ) {
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['presentation_contenu_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }

//				$pv['fieldlist'] = array ( "ligne", "minimum_x", "minimum_y", "module_nom", "type_calcul",  "position_x", "position_y", "dimenssion_x", "dimenssion_y" );
				string_DB_escape ( $_REQUEST['liste_colonne']['presentation_contenu'] , $_REQUEST['conv_expr_section'] );

				$R['pres_cont_id'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('presentation_contenu') , "pres_cont_id" );

				reset ( $_REQUEST['liste_colonne']['presentation_contenu'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['presentation_contenu'] as $A ) { $requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SqlTableListObj->getSQLTableName('presentation_contenu')." VALUES ".$requete_valeurs.";";

				manipulation_traitement_requete ( $requete1 );
				$tl_['eng']['M_PRESNT_11_0003'] = "Job done!";
				$tl_['fra']['M_PRESNT_11_0003'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_PRESNT_11_0003" , $tl_[$l]['M_PRESNT_11_0003'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['presentation_contenu_selection'] = $_REQUEST['M_PRESNT']['cont_id'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R['modification_effectuee'] = 1;
				$R['presentation_contenu_selection'] = $pv['presentation_contenu_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_PRESNT_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_PRESNT_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_PRESNT_5_caption'];
			if ( $R['nom'] == "Nouvelle_presentation" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "WHERE pres_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT pres_nom 
				FROM ".$SqlTableListObj->getSQLTableName('presentation')." 
				".$pv['clause']." 
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['pres_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT * 
				FROM ".$SqlTableListObj->getSQLTableName('presentation')." 
				WHERE pres_nom = '".$R['nom']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_PRESNT_5_001'] = "No layout named ".$R['nom']." exists.";
					$tl_['fra']['M_PRESNT_5_001'] = "La pr&eacute;sentation nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_PRESNT_5_0001" , $tl_[$l]['M_PRESNT_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
unset ( $R );
}
?>
