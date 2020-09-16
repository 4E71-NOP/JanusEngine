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
function manipulation_groupe () {
	global $site_web, $SQL_tab, $SQL_tab_abrege, $db;
	$R = &$_REQUEST['M_GROUPE'];

	$_REQUEST['conv_expr_section'] = "M_GROUPE";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Group processing ";
	$tl_['fra']['si'] = "Manipulation groupe";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_GROUPE_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_GROUPE_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_GROUPE_00001" , $tl_[$l]['M_GROUPE_00001'] );
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
			systeme_requete_unifiee ( 3 , "M_GROUPE_rdg" , $R['nom'] , 0 , "M_GROUPE_1_0001" , $_REQUEST['fake'] );
			if ( $R['parent'] != "racine" ) { systeme_requete_unifiee ( 2 , "M_GROUPE_reg" , $R['parent'] , 0 , "M_GROUPE_1_0002" , $R['parent'] ); }
			else { $R['parent'] = 0; }

			if ( $R['ERR'] != 1 ) {
				$R['groupe_tag'] = conversion_expression ($R['groupe_tag']);
				$R['id'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['groupe'] , "groupe_id" );

				unset ( $A );
				string_DB_escape ( $_REQUEST['liste_colonne']['groupe'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['groupe'] ); 
				$requete_colonne = " (";
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['groupe'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SQL_tab_abrege['groupe']." VALUES ".$requete_valeurs.";";

				$R['id2'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['site_groupe'] , "site_groupe_id" );
				$requete2 = "
				INSERT INTO ".$SQL_tab_abrege['site_groupe']." VALUES ( 
				'".$R['id2']."',
				'".$_REQUEST['site_context']['site_id']."',
				'".$R['id']."',
				'1'
				);";
				manipulation_traitement_requete ( $requete1 );
				manipulation_traitement_requete ( $requete2 );

				$tl_['eng']['M_GROUPE_1_0002'] = "Job done!";
				$tl_['fra']['M_GROUPE_1_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_GROUPE_1_0002" , $tl_[$l]['M_GROUPE_1_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['groupe_selection'] = $R['id'];

				$pv['groupe_selection'] = $_REQUEST['M_GROUPE']['id'];
				$R['creation_effectuee'] = 1;
				$R['groupe_selection'] = $pv['groupe_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//	Modification
		case 2:
			systeme_requete_unifiee ( 2 , "M_GROUPE_reg" , $R['nom'] , 0 , "M_GROUPE_2_0001" , $R['id'] );
			if ( $R['parent'] != "racine" ) { systeme_requete_unifiee ( 2 , "M_GROUPE_reg" , $R['parent'] , 0 , "M_GROUPE_2_0002" , $R['parent'] ); }

			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				$R['groupe_tag'] = conversion_expression ( $R['groupe_tag']);

				string_DB_escape ( $_REQUEST['liste_colonne']['groupe'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['groupe'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['groupe'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SQL_tab_abrege['groupe']." SET ".$requete_colonne." WHERE groupe_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_GROUPE_2_0002'] = "Job done!";
				$tl_['fra']['M_GROUPE_2_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_GROUPE_2_0002" , $tl_[$l]['M_GROUPE_2_0002'] );
				$_REQUEST['CC']['status'] = "OK";
				$R['modification_effectuee'] = 1;
			}
			$R['groupe_selection'] = $R['id'];
		break;
// --------------------------------------------------------------------------------------------
//	Suppresion
		case 3:
			systeme_requete_unifiee ( 2 , "M_GROUPE_reg" , $R['nom'] , 0 , "M_GROUPE_3_0001" , $R['id'] );

			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				$requete1 = "UPDATE ".$SQL_tab_abrege['site_groupe']." 
				SET groupe_etat = '2' 
				WHERE groupe_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_GROUPE_3_0002'] = "Job done!";
				$tl_['fra']['M_GROUPE_3_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_GROUPE_3_0002" , $tl_[$l]['M_GROUPE_3_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['groupe_selection'] = $_REQUEST['M_GROUPE']['id'];
				$R['modification_effectuee'] = 1;
				$R['groupe_selection'] = $pv['groupe_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//	show
		case 5:
			$tl_['eng']['M_GROUPE_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_GROUPE_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_GROUPE_5_caption'];

			$_REQUEST['ICC_controle']['affichage_requis'] = 0;

			$tl_['eng']['grp_type']['0'] = "Anonymous";	$tl_['fra']['grp_type']['0'] = "Anonyme"; 
			$tl_['eng']['grp_type']['1'] = "Reader";	$tl_['fra']['grp_type']['1'] = "Lecteur"; 
			$tl_['eng']['grp_type']['2'] = "Staff";		$tl_['fra']['grp_type']['2'] = "Staff"; 

			if ( $R['nom'] == "Nouveau groupe" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND grp.groupe_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT grp.groupe_nom, grp.groupe_tag 
				FROM ".$SQL_tab_abrege['groupe']." as grp , ".$SQL_tab_abrege['site_groupe']." as sg 
				WHERE grp.groupe_id = sg.groupe_id 
				AND sg.groupe_etat != '2' 
				AND sg.site_id = ".$_REQUEST['site_context']['site_id']."
				".$pv['clause']."
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['groupe_nom'] . "(" . $tl_[$l]['grp_type'][$dbp['groupe_tag']] . "), "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT grp.* 
				FROM ".$SQL_tab_abrege['groupe']." as grp , ".$SQL_tab_abrege['site_groupe']." as sg 
				WHERE grp.groupe_id = sg.groupe_id 
				AND sg.groupe_etat != '2' 
				AND sg.site_id = ".$_REQUEST['site_context']['site_id']." 
				AND grp.groupe_nom = '".$R['nom']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_GROUPE_5_0001'] = "Job done!";
					$tl_['fra']['M_GROUPE_5_0001'] = "Execution &eacute;ffectu&eacute;e!";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_GROUPE_5_0001" , $tl_[$l]['M_GROUPE_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$tl_['eng']['tag']['0'] = "Anonymous";		$tl_['fra']['tag']['0'] = "Anonyme";
					$tl_['eng']['tag']['1'] = "Reader";			$tl_['fra']['tag']['1'] = "Lecteur";
					$tl_['eng']['tag']['2'] = "Staff";			$tl_['fra']['tag']['2'] = "Staff";
					$pv = $_REQUEST['ICC']['groupe_tag'];					$_REQUEST['ICC']['groupe_tag'] = $tl_[$l]['tag'][$pv];
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}	
	}
	unset ( $R );
}
?>
