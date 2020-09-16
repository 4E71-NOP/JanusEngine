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

//	Tags are for sticking on an article in order to be able to use the internal search engine.
//	Keywords are for highlighting expression inside the article. 
// --------------------------------------------------------------------------------------------
//	Manipulation mots cles
// --------------------------------------------------------------------------------------------

function manipulation_mot_cle () {
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	
	$R = &$_REQUEST['M_MOTCLE'];

	$_REQUEST['conv_expr_section'] = "M_MOTCLE";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Keyword processing";
	$tl_['fra']['si'] = "Manipulation mot cl&eacute;";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_MOTCLE_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_MOTCLE_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_MOTCLE_00001" , $tl_[$l]['M_MOTCLE_00001'] );
		$R['ERR'] = 1;
	}
	else {
		//$_REQUEST['site_context']['site_nom'] = $_REQUEST['site_context']['site_nom'];
		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//	Pas d'action
		case 0: 
//		echo ("Pas de modification de mot cle");
		break;

// --------------------------------------------------------------------------------------------
//	Creation de mot cle
		case 1:
			systeme_requete_unifiee ( 3 , "M_MOTCLE_rdmc" , $R['mc_nom'] , 0 , "M_MOTCLE_1_0001" , $_REQUEST['fake'] );
			systeme_requete_unifiee ( 2 , "MA_rea" , $R['arti_id'] , 0 , "M_MOTCLE_1_0002" , $R['arti_id'] );

			if ( $R['ERR'] != 1 ) {
				foreach ( $_REQUEST['liste_colonne']['motcle_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				unset ( $A );
				string_DB_escape ( $_REQUEST['liste_colonne']['motcle'] , $_REQUEST['conv_expr_section'] );
				$R['mc_id'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('mot_cle') , "mc_id" );

				reset ( $_REQUEST['liste_colonne']['motcle'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['motcle'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SqlTableListObj->getSQLTableName('mot_cle')." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_MOTCLE_1_0003'] = "Job done!";
				$tl_['fra']['M_MOTCLE_1_0003'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "M_MOTCLE_1_0003" , $tl_[$l]['M_MOTCLE_1_0003'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['mot_cle_selection'] = $R['mc_id'];
				$R['creation_effectuee'] = 1;
				$R['mot_cle_selection'] = $pv['mot_cle_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//	modification de mot cle
		case 2:
			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}
			else {
				systeme_requete_unifiee ( 2 , "M_MOTCLE_remc" , $R['mc_nom'] , 0 , "M_MOTCLE_2_0001" , $R['mc_id'] );
				systeme_requete_unifiee ( 2 , "MA_rea" , $R['arti_id'] , 0 , "M_MOTCLE_2_0002" , $R['arti_id'] );
			}

			if ( $R['ERR'] != 1 ) {
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['motcle_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				string_DB_escape ( $_REQUEST['liste_colonne']['motcle'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['motcle'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['motcle'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SqlTableListObj->getSQLTableName('mot_cle')." SET ".$requete_colonne." WHERE mc_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_MOTCLE_2_0005'] = "Job done!";
				$tl_['fra']['M_MOTCLE_2_0005'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "M_MOTCLE_2_0005" , $tl_[$l]['M_MOTCLE_2_0005'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['mot_cle_selection'] = $pv['mot_cle_selection'] = $R['mc_id'];
				$R['modification_effectuee'] = 1;
			}
		break;

// --------------------------------------------------------------------------------------------
//	Suppression de categorie
		case 3:
			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}
			if ( $R['ERR'] != 1 ) {
				systeme_requete_unifiee ( 2 , "M_MOTCLE_remc" , $R['mc_nom'] , 0 , "M_MOTCLE_3_0001" , $R['mc_id'] );

				$requete1 = "UPDATE  ".$SqlTableListObj->getSQLTableName('mot_cle')." SET 
				mc_etat 		= '2' 
				WHERE mc_id	= '".$R['mc_id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_MOTCLE_3_0005'] = "Job done!";
				$tl_['fra']['M_MOTCLE_3_0005'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "M_MOTCLE_3_0005" , $tl_[$l]['M_MOTCLE_3_0005'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['mot_cle_selection'] = $R['mc_id'];
				$R['modification_effectuee'] = 1;
				$R['mot_cle_selection'] = $pv['mot_cle_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_MOTCLE_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_MOTCLE_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_MOTCLE_5_caption'];
			if ( $R['nom'] == "nouveau_mot_cle" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND mc_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT mc_nom 
				FROM ".$SqlTableListObj->getSQLTableName('mot_cle')." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."'
				".$pv['clause']." 
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['mc_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT * 
				FROM ".$SqlTableListObj->getSQLTableName('mot_cle')." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
				AND mc_nom = '".$R['mc_nom']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_MOTCLE_5_001'] = "No keyword named ".$R['mc_nom']." exists.";
					$tl_['fra']['M_MOTCLE_5_001'] = "Le mot cl&eacute; nom&eacute; ".$R['mc_nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $MMC['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_MOTCLE_5_0001" , $tl_[$l]['M_MOTCLE_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$tl_['eng']['oo']['0'] = "Offline";			$tl_['fra']['oo']['0'] = "Hors ligne";
					$tl_['eng']['oo']['1'] = "Online";			$tl_['fra']['oo']['1'] = "En ligne";
					$tl_['eng']['oo']['3'] = "Deleted";			$tl_['fra']['oo']['3'] = "Supprim&eacute;";
					$tl_['eng']['typ']['0'] = "To category";	$tl_['fra']['typ']['0'] = "Vers une cat&eacute;gorie";
					$tl_['eng']['typ']['1'] = "To URL";			$tl_['fra']['typ']['1'] = "Vers une URL";
					$tl_['eng']['typ']['2'] = "To tooltip";		$tl_['fra']['typ']['2'] = "Vers l'aide dynamique";
					$pv = $_REQUEST['ICC']['mc_etat'];				$_REQUEST['ICC']['mc_etat'] = $tl_[$l]['oo'][$pv];
					$pv = $_REQUEST['ICC']['mc_type'];				$_REQUEST['ICC']['mc_type'] = $tl_[$l]['typ'][$pv];
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
//unset ( $R );
}
?>
