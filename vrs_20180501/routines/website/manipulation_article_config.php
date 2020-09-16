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
//	Manipulation article config
// --------------------------------------------------------------------------------------------
function manipulation_article_config () {
	global $site_web, $SQL_tab, $SQL_tab_abrege, $db;
	$R = &$_REQUEST['M_ARTCFG'];

	$_REQUEST['conv_expr_section'] = "M_ARTCFG";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Article config processing ";
	$tl_['fra']['si'] = "Manipulation article config";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;

	if ( $_REQUEST['site_context']['site_id'] == 0 ) {
		$tl_['eng']['M_ARTCFG_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_ARTCFG_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_ARTCFG_00001" , $tl_[$l]['M_ARTCFG_00001'] );
		$R['ERR'] = 1;
	}
	else {
		$MAC['site_context'] = $_REQUEST['site_context']['site_id'];
		$MAC['site_nom'] = $_REQUEST['site_context']['site_nom'];
		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//		Pas d'action
		case 0:
		break;

// --------------------------------------------------------------------------------------------
//		Creation de article_config
		case 1:
			systeme_requete_unifiee ( 3 , "M_ARTCFG_rdac" , $R['nom'] , 0 , "M_ARTCFG_1_0001" , $_REQUEST['fake'] );

			if ( $R['ERR'] != 1 ) {
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['config_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				string_DB_escape ( $_REQUEST['liste_colonne']['config'] , $_REQUEST['conv_expr_section'] );

				$R['id'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['article_config'] , "config_id" );
 
				reset ( $_REQUEST['liste_colonne']['config'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['config'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SQL_tab_abrege['article_config']." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_ARTCFG_1_0002'] = "Job done!";
				$tl_['fra']['M_ARTCFG_1_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_ARTCFG_1_0002" , $tl_[$l]['M_ARTCFG_1_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['id'] = $R['id'];
				$pv['nom'] = $R['nom'];
				if ( $site_web['sw_info_debug'] < 10 ) { unset ($R); }
				$R['creation_effectuee'] = 1; 
				$R['id'] = $pv['id'];
				$R['nom'] = $pv['nom'];
				$MAC_creation_faite = 1; 
			}
		break;
// --------------------------------------------------------------------------------------------
//		Modification
		case 2:
			//systeme_requete_unifiee ( 2 , "M_ARTCFG_rdac" , $R['nom'] , 0 , "M_ARTCFG_2_0001" , $R['id'] );

			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['config_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				string_DB_escape ( $_REQUEST['liste_colonne']['config'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['config'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['config'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SQL_tab_abrege['article_config']." SET ".$requete_colonne." WHERE config_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_ARTCFG_2_0002'] = "Job done!";
				$tl_['fra']['M_ARTCFG_2_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_ARTCFG_2_0002" , $tl_[$l]['M_ARTCFG_2_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['id'] = $R['id'];
				$pv['nom'] = $R['nom'];
				if ( $site_web['sw_info_debug'] < 10 ) { unset ($R); }
				$R['modification_effectuee'] = 1; 
				$R['id'] = $pv['id'];
				$R['nom'] = $pv['nom'];
				$MAC_modification_faite = 1; 
			}
		break;
// --------------------------------------------------------------------------------------------
//		Suppression
		case 3:
			systeme_requete_unifiee ( 2 , "M_ARTCFG_rdac" , $R['nom'] , 0 , "M_ARTCFG_3_0001" , $R['id'] );

			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}

			if ( $R['ERR'] != 1 ) {
				$requete1 = "
				DELETE FROM ".$SQL_tab_abrege['article_config']." 
				WHERE config_id = '".$R['id']."',
				);";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_ARTCFG_3_0002'] = "Job done!";
				$tl_['fra']['M_ARTCFG_3_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_ARTCFG_3_0002" , $tl_[$l]['M_ARTCFG_3_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['id'] = $R['id'];
				$pv['nom'] = $R['nom'];
				if ( $site_web['sw_info_debug'] < 10 ) { unset ($R); }
				$R['modification_effectuee'] = 1; 
				$R['id'] = $pv['id'];
				$R['nom'] = $pv['nom'];
				$MAC_modification_faite = 1; 
			}
		break;
		}
	}
unset ( $R );
}
?>
