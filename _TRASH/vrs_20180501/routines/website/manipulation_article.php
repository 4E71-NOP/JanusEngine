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
//	Manipulation article
// --------------------------------------------------------------------------------------------

function manipulation_article () {
	global $site_web, $SQL_tab, $SQL_tab_abrege, $db;
	$R = &$_REQUEST['M_ARTICL'];

//	echo ( "<br><br>" . $_REQUEST['tampon_commande'] . "<br>");

	$_REQUEST['conv_expr_section'] = "M_ARTICL";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Article processing ";
	$tl_['fra']['si'] = "Manipulation article";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_ARTICL_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_ARTICL_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_ARTICL_00001" , $tl_[$l]['M_ARTICL_00001'] );
		$R['ERR'] = 1;
	}
	else {
		$MA['timestamp'] = time ();
		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//		Pas d'action
		case 0:
//		echo ("Pas de modification de cat&eacute;gorie"); */
		break;

// --------------------------------------------------------------------------------------------
//		Creation de article
		case 1:
			systeme_requete_unifiee ( 3 , "M_ARTICL_rda" , $R['arti_nom'] , 0 , "M_ARTICL_1_0001" , $_REQUEST['fake'] );
			systeme_requete_unifiee ( 2 , "M_ARTICL_reb" , $R['arti_bouclage'] , 0 , "M_ARTICL_1_0002" , $R['arti_bouclage'] );
			systeme_requete_unifiee ( 2 , "M_ARTICL_reac" , $R['config_id'] , 0 , "M_ARTICL_1_0003" , $R['config_id'] );
			systeme_requete_unifiee ( 2 , "M_ARTICL_rec" , $R['arti_creation_createur'] , 0 , "M_ARTICL_1_0004" , $R['arti_creation_createur'] );
			systeme_requete_unifiee ( 2 , "M_ARTICL_rev" , $R['arti_validation_validateur'] , 0 , "M_ARTICL_1_0005" , $R['arti_validation_validateur'] );
			systeme_requete_unifiee ( 2 , "M_ARTICL_rep" , $R['pres_nom_generique'] , $_REQUEST['site_context']['theme_id'] , "M_ARTICL_1_0006" , $R['pres_nom_generique'] );
			if ( $R['ERR'] != 1 ) {
				$R['arti_validation_etat']			= conversion_expression ( $R['arti_validation_etat']);			// arti_validation_etat		NON_VALIDE 0	VALIDE 1

				if ( !isset($R['arti_creation_date']) || $R['arti_creation_date'] == 0 )			{ $R['arti_creation_date']		= $MA['timestamp'];}
				if ( !isset($R['arti_validation_date']) || $R['arti_validation_date'] == 0 )		{ $R['arti_validation_date']	= $MA['timestamp'];}
				if ( !isset($R['arti_parution_date']) || $R['arti_parution_date'] == 0 )			{ $R['arti_parution_date']		= $MA['timestamp'];}

				$R['arti_id'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['article'] , "arti_id" );
				string_DB_escape ( $_REQUEST['liste_colonne']['article'] , $_REQUEST['conv_expr_section'] );
				reset ( $_REQUEST['liste_colonne']['article'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['article'] as $A ) { $requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SQL_tab_abrege['article']." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_ARTICL_1_0009'] = "Job done!";
				$tl_['fra']['M_ARTICL_1_0009'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_ARTICL_1_0009" , $tl_[$l]['M_ARTICL_1_0009'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['creation_effectuee'] = 1; 
				$_REQUEST['arti_ref_selection'] = $R['ref'];
				$_REQUEST['arti_page_selection'] = $R['page'];
			}
		break;
// --------------------------------------------------------------------------------------------
//	Modification (toute modification de contenu)
// --------------------------------------------------------------------------------------------
//	Modification de l'article et mise a jour des infos
		case 2:
		systeme_requete_unifiee ( 2 , "M_ARTICL_rea" , $R['nom'] , 0 , "M_ARTICL_2_0001" , $R['id'] );
		systeme_requete_unifiee ( 2 , "M_ARTICL_reb" , $R['bouclage'] , 0 , "M_ARTICL_2_0002" , $R['bouclage'] );
		systeme_requete_unifiee ( 2 , "M_ARTICL_reac" , $R['config'] , 0 , "M_ARTICL_2_0003" , $R['config_id'] );
		systeme_requete_unifiee ( 2 , "M_ARTICL_rep" , $R['pres_nom_generique'] , $_REQUEST['site_context']['theme_id'] , "M_ARTICL_2_0004" , $R['pres_nom_generique'] );

		$R['validation_etat']			= conversion_expression ( $R['validation_etat']);			/* arti_validation_etat		NON_VALIDE 0	VALIDE 1 */
		if ( $R['validation_etat'] == 1 ) { 
				$pv['fieldlist'] = array ( "validation_etat", "validation_validateur", "validation_date" );
				string_DB_escape ( $pv['fieldlist'] , $_REQUEST['conv_expr_section'] );

				systeme_requete_unifiee ( 2 , "M_ARTICL_rev" , $R['validation_validateur'] , 0 , "M_ARTICL_2_0005" , $R['validation_validateur'] );
				if ($_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
					if	( !isset($R['confirmation_modification']) ) {
						$R['arti_id_selection'] = $R['id'];
						$R['confirmation_modification_oubli'] = 1;
						$R['ERR'] = 1;
					}
				}
			}

			if ( $R['ERR'] != 1 ) {
				string_DB_escape ( $_REQUEST['liste_colonne']['article'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['article'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['article'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SQL_tab_abrege['article']." SET ".$requete_colonne." WHERE arti_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_ARTICL_2_0009'] = "Job done!";
				$tl_['fra']['M_ARTICL_2_0009'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_ARTICL_2_0009" , $tl_[$l]['M_ARTICL_2_0009'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['modification_effectuee'] = 1; 
				$_REQUEST['arti_ref_selection'] = $R['ref'];
				$_REQUEST['arti_page_selection'] = $R['page'];
//				outil_debug ( $_REQUEST['M_ARTICL'] , $_REQUEST['M_ARTICL'] );
			}
		break;

// --------------------------------------------------------------------------------------------
//	Suppression de l'article
		case 3:
			systeme_requete_unifiee ( 2 , "M_ARTICL_rea" , $R['nom'] , 0 , "M_ARTICL_4_0001" , $R['id'] );

			if ( $R['ERR'] != 1 ) {
				$requete1 = "DELETE FROM ".$SQL_tab_abrege['article']." 
				WHERE arti_id = '".$R['id']."'
				AND site_id ='".$_REQUEST['site_context']['site_id']."'
				;";
				manipulation_traitement_requete ( $requete1 );
				$requete1 = "DELETE FROM ".$SQL_tab_abrege['article_tag']." 
				WHERE arti_id = '".$R['id']."'
				;";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_ARTICL_3_0001'] = "Job done!";
				$tl_['fra']['M_ARTICL_3_0001'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_ARTICL_3_0001" , $tl_[$l]['M_ARTICL_3_0001'] );
				$_REQUEST['CC']['status'] = "OK";
			}
		break;

// --------------------------------------------------------------------------------------------
//		Autre
// --------------------------------------------------------------------------------------------
//		Ligature avec un article
		case 4:
			systeme_requete_unifiee ( 2 , "M_ARTICL_rea" , $R['nom'] , 0 , "M_ARTICL_4_0001" , $R['id'] );
			systeme_requete_unifiee ( 2 , "M_ARTICL_red" , $R['docu_nom'] , 0 , "M_ARTICL_4_0002" , $R['docu_id'] );

			if ( $R['ERR'] != 1 ) {
				$requete1 = "UPDATE ".$SQL_tab_abrege['article']." SET 
				docu_id = '".$R['docu_id']."' 
				WHERE arti_id = '".$R['id']."'
				;";
				manipulation_traitement_requete ( $requete1 );
				$tl_['eng']['M_ARTICL_4_0003'] = "Job done!";
				$tl_['fra']['M_ARTICL_4_0003'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_ARTICL_4_0003" , $tl_[$l]['M_ARTICL_4_0003'] );
				$_REQUEST['CC']['status'] = "OK";
			}
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_ARTICL_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_ARTICL_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_ARTICL_5_caption'];
			if ( $R['nom'] == "Nouvel article" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND arti_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT arti_ref, arti_nom 
				FROM ".$SQL_tab_abrege['article']." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
				".$pv['clause']." 
				ORDER BY arti_nom, arti_ref
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['arti_nom'] . " (" . $dbp['arti_ref'] . "), "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT *  
				FROM ".$SQL_tab_abrege['article']." 
				WHERE site_id = ".$_REQUEST['site_context']['site_id']."
				AND arti_nom = '".$R['nom']."'
				ORDER BY arti_nom, arti_ref
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_ARTICL_5_001'] = "No article named ".$R['nom']." exists.";
					$tl_['fra']['M_ARTICL_5_001'] = "L'article nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $MA['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_ARTICL_5_0001" , $tl_[$l]['M_ARTICL_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$tl_['eng']['v']['0'] = "Not valid";		$tl_['fra']['v']['0'] = "Non valide";
					$tl_['eng']['v']['1'] = "Valid";			$tl_['fra']['v']['1'] = "Valide";
					$pv = $_REQUEST['ICC']['arti_validation_etat'];					$_REQUEST['ICC']['arti_validation_etat'] = $tl_[$l]['v'][$pv];
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
// --------------------------------------------------------------------------------------------
	}
unset ( $R );
}
?>
