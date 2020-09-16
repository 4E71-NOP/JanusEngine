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
//	Manipulation bouclage
// --------------------------------------------------------------------------------------------
function manipulation_bouclage () {
	global $WebSiteObj;
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	$R = &$_REQUEST['M_BOUCLG'];

	$_REQUEST['conv_expr_section'] = "M_BOUCLG";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Deadline processing ";
	$tl_['fra']['si'] = "Manipulation bouclage";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;

	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_BOUCLG_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_BOUCLG_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_BOUCLG_00001" , $tl_[$l]['M_BOUCLG_00001'] );
		$R['ERR'] = 1;
	}
	else {

		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//	Pas d'action
		case 0:
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_BOUCLG_0_0001" , "Pas d'action specifiée." );
		break;
// --------------------------------------------------------------------------------------------
//	Creation de bouclage
		case 1:
			systeme_requete_unifiee ( 3 , "M_BOUCLG_rdb" , $R['nom'] , 0 , "M_BOUCLG_1_0001" , $_REQUEST['fake'] );

			if ( $R['ERR'] != 1 ) {
				if ( $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { $R['date_limite'] = mktime_from_canonical($R['date_limite']); }

				$R['bouclage_etat'] = conversion_expression ( $R['bouclage_etat']); 
				$R['id'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('bouclage') , "bouclage_id" );

				string_DB_escape ( $_REQUEST['liste_colonne']['bouclage'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['bouclage'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['bouclage'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SqlTableListObj->getSQLTableName('bouclage')." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_BOUCLG_1_0002'] = "Job done!";
				$tl_['fra']['M_BOUCLG_1_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_BOUCLG_1_0002" , $tl_[$l]['M_BOUCLG_1_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['id'] = $R['id'];
				$pv['nom'] = $R['nom'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R['creation_effectuee'] = 1; 
				$R['id'] = $pv['id'];
				$R['nom'] = $pv['nom'];
			}
		break;
	
// --------------------------------------------------------------------------------------------
//	Modification de bouclage
		case 2:
			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}
			else {
				systeme_requete_unifiee ( 2 , "M_BOUCLG_reb" , $R['nom'] , 0 , "M_BOUCLG_2_0001" , $R['id'] );
			}

			if ( $R['ERR'] != 1 && $R['confirmation_modification'] != 0 ) {
				$R['bouclage_etat'] = conversion_expression ( $R['bouclage_etat']); 
				$R['date_limite'] = mktime_from_canonical($R['date_limite']);
				$R['date_creation'] = mktime_from_canonical($R['date_creation']); 

				$pv['fieldlist'] = array ( "titre", "etat", "date_limite" );
				string_DB_escape ( $_REQUEST['liste_colonne']['bouclage'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['bouclage'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['bouclage'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SqlTableListObj->getSQLTableName('bouclage')." SET ".$requete_colonne." WHERE bouclage_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_BOUCLG_1_0002'] = "Job done!";
				$tl_['fra']['M_BOUCLG_1_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_BOUCLG_1_0002" , $tl_[$l]['M_BOUCLG_1_0002'] );
				$_REQUEST['CC']['status'] = "OK";

			}
			$pv['bouclage_selection'] = $R['id'];
			if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
			$R = &$_REQUEST['M_BOUCLG'];
			$R['modification_effectuee'] = 1; 
			$R['bouclage_selection'] = $pv['bouclage_selection'];
			$_REQUEST['uni_gestion_des_bouclages_p'] = 2;
		break;

// --------------------------------------------------------------------------------------------
//	Suppression de bouclage
		case 3:
			systeme_requete_unifiee ( 2 , "M_BOUCLG_reb" , $R['nom'] , 0 , "M_BOUCLG_3_0001" , $R['id'] );

			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				$requete1 = "UPDATE ".$SqlTableListObj->getSQLTableName('bouclage')." 
				SET bouclage_etat = 'SUPPRIME' 
				WHERE bouclage_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_BOUCLG_3_0002'] = "Job done!";
				$tl_['fra']['M_BOUCLG_3_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_BOUCLG_3_0002" , $tl_[$l]['M_BOUCLG_3_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['bouclage_selection'] = $R['id'];
				if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
				$R = &$_REQUEST['M_BOUCLG'];
				$R['modification_effectuee'] = 1; 
				$R['bouclage_selection'] = $pv['bouclage_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_BOUCLG_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_BOUCLG_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_BOUCLG_5_caption'];
			if ( $R['nom'] == "Nouveau bouclage" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND bouclage_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT bouclage_nom 
				FROM ".$SqlTableListObj->getSQLTableName('bouclage')." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
				".$pv['clause']." 
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['bouclage_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT * 
				FROM ".$SqlTableListObj->getSQLTableName('bouclage')." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
				AND bouclage_nom = '".$R['nom']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_BOUCLG_5_001'] = "No deadline named ".$R['nom']." exists.";
					$tl_['fra']['M_BOUCLG_5_001'] = "Le bouclage nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $MB['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_BOUCLG_5_0001" , $tl_[$l]['M_BOUCLG_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$tl_['eng']['oo']['0'] = "Offline";		$tl_['fra']['oo']['0'] = "Hors ligne";
					$tl_['eng']['oo']['1'] = "Online";		$tl_['fra']['oo']['1'] = "En ligne";
					$pv = $_REQUEST['ICC']['bouclage_etat'];	$_REQUEST['ICC']['bouclage_etat'] = $tl_[$l]['oo'][$pv];
					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
unset ( $R );
}	
?>
