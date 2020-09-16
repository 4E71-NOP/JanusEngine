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

//	Manipulation decoration
// --------------------------------------------------------------------------------------------
function document_rch_compare_type_decoration ($code_erreur) {
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	$R = &$_REQUEST['M_DECORA'];

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT deco_type
	FROM ".$SqlTableListObj->getSQLTableName('decoration')." 
	WHERE deco_nom = '".$R['deco_nom']."' 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { $R['type_comp'] = $dbp['deco_type']; }
	if ( $R['type_comp'] != $R['deco_type'] ) {
		$l = $_REQUEST['site_context']['site_lang'];
		$tl_['eng']['err'] = "The decoration type of '".$R['nom']."' cannot change. If you want to have another decoration type; create a new decoration.";
		$tl_['fra']['err'] = "La le type de la decoration '".$R['nom']."' ne peut changer. Si vous d&eacute;sirez avoir un autre type; cr&eacute;ez une nouvelle d&eacute;coration.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "ERR" , $code_erreur , $tl_[$l]['err'] );
		$R['ERR'] = 1;
	}
}

// --------------------------------------------------------------------------------------------
function manipulation_decoration () {
	global $SQL_tab_abrege;
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	$R = &$_REQUEST['M_DECORA'];

	$_REQUEST['conv_expr_section'] = "M_DECORA";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Decoration processing ";
	$tl_['fra']['si'] = "Manipulation d&eacute;coration";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_DECORA_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_DECORA_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_DECORA_00001" , $tl_[$l]['M_DECORA_00001'] );
		$R['ERR'] = 1;
	}
	else {
		//$_REQUEST['site_context']['site_nom'] = $_REQUEST['site_context']['site_nom'];
		$timestamp_MD = time ();
		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//		Pas d'action
		case 0:
//		echo ("Pas de modification de cat&eacute;gorie");
		break;

// --------------------------------------------------------------------------------------------
//		Creation de decoration
		case 1:
			systeme_requete_unifiee ( 3 , "M_DECORA_rddec" , $R['deco_nom'] , 0 , "M_DECORA_1_0001" , $_REQUEST['fake'] );
			if ( $R['ERR'] != 1 ) {
				$R['deco_ref_id'] 	= manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('decoration') , "deco_ref_id" );

				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['all_405060'] as $A ) { $R[$A] = conversion_expression ( $R[$A] ); }

				switch ( $R['deco_type'] ) {
				case 10:
				case "menu":
					systeme_requete_unifiee ( 2 , "M_DECORA_redec" , $R['deco_graphique'] , 0 , "M_DECORA_1_0002" , $R['deco_graphique'] );
					systeme_requete_unifiee ( 2 , "M_DECORA_redec" , $R['deco_texte'] , 0 , "M_DECORA_1_0003" , $R['deco_texte'] );

					if ( $R['ERR'] != 1 ) {
						$pv['SQL_table'] = "deco_10_menu";
						$pv['deco_liste_valeurs'] = "menu_10";
					}
				break;

				case 20:
				case "caligraphe":
				case "caligraph":
					$pv['SQL_table'] = "deco_20_caligraphe";
					$pv['deco_liste_valeurs'] = "caligraph_20";
					// Créer un bloc dédié à la confection des requetes pour le sytème de table BDD reduite.
					// Solution batarde pour le temps de faire l'étude du système et le mettre à l'épreuve. 
				break;

				case 30:
				case "1_div":
					$pv['SQL_table'] = "deco_30_1_div";
					$pv['deco_liste_valeurs'] = "1div_30";
				break;

				case 40:
				case "elegance":
					$pv['SQL_table'] = "deco_40_elegance";
					$pv['deco_liste_valeurs'] = "elegance_40";
				break;

				case 50:
				case "exquise":
				case "exquisite":
					$pv['SQL_table'] = "deco_50_exquise";
					$pv['deco_liste_valeurs'] = "exquise_50";
				break;

				case 60:
				case "elysion":
					$pv['SQL_table'] = "deco_60_elysion";
					$pv['deco_liste_valeurs'] = "elysion_60";
					break;
				}

			// isoler ce bloc pour ne l'avoir actif uniquement dans les deco 30 40 50 60
				$R['deco_id'] 		= manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName($pv['SQL_table']) , "deco_id" );
				$R['deco_nligne'] 	= manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName($pv['SQL_table']) , "deco_nligne" );
				string_DB_escape ( $_REQUEST['liste_variables'][$pv['deco_liste_valeurs']] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_variables'][$pv['deco_liste_valeurs']] ); 
				unset ( $A );
				$requete1 = $requete_valeurs = "";
				foreach ( $_REQUEST['liste_variables'][$pv['deco_liste_valeurs']] as $A ) { 
					$requete_valeurs .= "('".$R['deco_nligne']."','".$R['deco_id']."','".$A."','".$R[$A]."'),";
					$R['deco_nligne']++;
				}
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 );
				$requete1 = "INSERT INTO ".$SqlTableListObj->getSQLTableName($pv['SQL_table'])." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$requete2 = "
				INSERT INTO ".$SqlTableListObj->getSQLTableName('decoration')." VALUES (
				'".$R['deco_ref_id']."',
				'".$R['deco_nom']."',
				'1',
				'".$R['deco_type']."',
				'".$R['deco_id']."'
				);";
				manipulation_traitement_requete ( $requete2 );
				$tl_['eng']['M_DECORA_1_0002'] = "Job done!";
				$tl_['fra']['M_DECORA_1_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_DECORA_1_0002" , $tl_[$l]['M_DECORA_1_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['decoration_selection'] = $R['id'];
				$R['creation_effectuee'] = 1;
				$R['decoration_selection'] = $pv['decoration_selection'];
			}
		break;

// --------------------------------------------------------------------------------------------
//		Modification de decoration
// --------------------------------------------------------------------------------------------
//		Modification de decoration depuis l'interface
		case 2:
			$R['deco_type_sauvegarde'] = $R['deco_type'];
			$R['deco_type']		= conversion_expression ( $R['deco_type'] );
			document_rch_compare_type_decoration ("M_DECORA_2_0001");

			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				$R['deco_type'] = $R['deco_type_sauvegarde'];
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['all_405060'] as $A ) { $R[$A] = conversion_expression ( $R[$A] ); }

				switch ( $R['deco_type'] ) {
				case 10:
				case "menu":
					$pv['SQL_table'] = "deco_10_menu";
					$pv['deco_liste_valeurs'] = "menu_10";
				break;

				case 20:
				case "caligraphe":
				case "caligraph":
					$pv['SQL_table'] = "deco_20_caligraphe";
					$pv['deco_liste_valeurs'] = "caligraph_20";
				break;

				case 30:
				case "1_div":
					$pv['SQL_table'] = "deco_30_1_div";
					$pv['deco_liste_valeurs'] = "1div_30";
				break;

				case 40:
				case "elegance":
					$pv['SQL_table'] = "deco_40_elegance";
					$pv['deco_liste_valeurs'] = "elegance_40";
				break;

				case 50:
				case "exquise":
				case "exquisite":
					$pv['SQL_table'] = "deco_50_exquise";
					$pv['deco_liste_valeurs'] = "exquise_50";
				break;

				case 60:
				case "elysion":
					$pv['SQL_table'] = "deco_60_elysion";
					$pv['deco_liste_valeurs'] = "elysion_60";
					break;
				}

				string_DB_escape ( $_REQUEST['liste_colonne'][$pv['deco_liste_valeurs']] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne'][$pv['deco_liste_valeurs']] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne'][$pv['deco_liste_valeurs']] as $A ) {
					$requete_colonne .= $A . "='".$R[$A]."', ";
				}
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SQL_tab_abrege[$pv['SQL_table']]." SET ".$requete_colonne." WHERE deco_id = '".$R['deco_id']."';";

				manipulation_traitement_requete ( $requete1 );
				$requete2 = "
				UPDATE ".$SqlTableListObj->getSQLTableName('decoration')." SET 
				deco_etat	=	'".$R['deco_etat']."', 
				deco_type	=	'".$R['deco_type']."' 
				WHERE deco_id = '".$R['deco_id']."' 
				;";
				manipulation_traitement_requete ( $requete2 );

				$tl_['eng']['M_DECORA_1_0002'] = "Job done!";
				$tl_['fra']['M_DECORA_1_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_DECORA_1_0002" , $tl_[$l]['M_DECORA_1_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['decoration_selection'] = $R['id'];
				$R['modification_effectuee'] = 1;
				$R['decoration_selection'] = $pv['decoration_selection'];

			}
		break;

// --------------------------------------------------------------------------------------------
//		Suppression de document
		case 3:
			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}

			systeme_requete_unifiee ( 2 , "M_DECORA_rddec" , $R['nom'] , 0 , "M_DECORA_1_0001" , $_REQUEST['deco_id'] );
			if ( $R['ERR'] != 1 ) {

				$requete1 = "
				UPDATE ".$SqlTableListObj->getSQLTableName('decoration')." SET 
				deco_etat	= '3' 
				WHERE deco_id = '".$R['deco_id']."' 
				;";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_DECORA_1_0002'] = "Job done!";
				$tl_['fra']['M_DECORA_1_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_DECORA_1_0002" , $tl_[$l]['M_DECORA_1_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['decoration_selection'] = $R['id'];
				$R['modification_effectuee'] = 1;
				$R['decoration_selection'] = $pv['decoration_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_DECORA_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_DECORA_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_DECORA_5_caption'];
			if ( $R['nom'] == "" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "WHERE deco_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT deco_nom 
				FROM ".$SqlTableListObj->getSQLTableName('decoration')." 
				".$pv['clause']." 
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['deco_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT * 
				FROM ".$SqlTableListObj->getSQLTableName('decoration')." 
				WHERE deco_nom = '".$R['nom']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_DECORA_5_001'] = "No decoration named ".$R['nom']." exists.";
					$tl_['fra']['M_DECORA_5_001'] = "La d&eacute;coration nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_DECORA_5_0001" , $tl_[$l]['M_DECORA_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$tl_['eng']['oo']['0'] = "Offline";		$tl_['fra']['oo']['0'] = "Hors ligne";
					$tl_['eng']['oo']['1'] = "Online";		$tl_['fra']['oo']['1'] = "En ligne";
					$tl_['eng']['oo']['3'] = "Deleted";		$tl_['fra']['oo']['3'] = "Supprim&eacute;";
					$tl_['eng']['typ']['10'] = "menu";		$tl_['fra']['typ']['10'] = "menu";
					$tl_['eng']['typ']['20'] = "Caligraph";	$tl_['fra']['typ']['20'] = "Caligraphe";
					$tl_['eng']['typ']['30'] = "1_div";		$tl_['fra']['typ']['30'] = "1_div";
					$tl_['eng']['typ']['40'] = "Elegance";	$tl_['fra']['typ']['40'] = "Elegance";
					$tl_['eng']['typ']['50'] = "Exquisite";	$tl_['fra']['typ']['50'] = "Exquise";
					$tl_['eng']['typ']['60'] = "Elysion";		$tl_['fra']['typ']['60'] = "Elysion";
					$pv = $_REQUEST['ICC']['deco_etat'];		$_REQUEST['ICC']['deco_etat'] = $tl_[$l]['oo'][$pv];
					$pv = $_REQUEST['ICC']['deco_type'];		$_REQUEST['ICC']['deco_type'] = $tl_[$l]['typ'][$pv];
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
unset ( $R );
}
?>
