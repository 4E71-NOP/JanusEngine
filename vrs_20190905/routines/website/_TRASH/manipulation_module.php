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
//	Manipulation module
// --------------------------------------------------------------------------------------------
function manipulation_module () {
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	$R = &$_REQUEST['M_MODULE'];

	$_REQUEST['conv_expr_section'] = "M_MODULE";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Module processing";
	$tl_['fra']['si'] = "Manipulation module";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0 ) {
		$tl_['eng']['M_MODULE_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_MODULE_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_MODULE_00001" , $tl_[$l]['M_MODULE_00001'] );
		$R['ERR'] = 1;
	}
	else {
		//$_REQUEST['site_context']['site_id'] = $_REQUEST['site_context']['site_id'];
		//$_REQUEST['site_context']['site_nom'] = $_REQUEST['site_context']['site_nom'];
		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//		Pas d'action
		case 0:
//		echo ("Pas de modification de cat&eacute;gorie"); */
		break;

// --------------------------------------------------------------------------------------------
//		Creation de module
		case 1:
			systeme_requete_unifiee ( 3 , "M_MODULE_rdm" , $R['module_nom'] , 0 , "M_MODULE_1_0001" , $_REQUEST['fake'] );
			systeme_requete_unifiee ( 2 , "M_MODULE_regpv" , $R['module_groupe_pour_voir'] , 0 , "MG_1_0002" , $R['module_groupe_pour_voir']);
			systeme_requete_unifiee ( 2 , "M_MODULE_regpu" , $R['module_groupe_pour_utiliser'] , 0 , "MG_1_0003" , $R['module_groupe_pour_utiliser']);

			if ( $R['ERR'] != 1 ) {
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['module_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				$R['id'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('module') , "module_id" );
				unset ( $A );
				string_DB_escape ( $_REQUEST['liste_colonne']['module'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['module'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['module'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SqlTableListObj->getSQLTableName('module')." VALUES ".$requete_valeurs.";";

				$R['id2'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('site_module') , "site_module_id" );
				$requete2 = "
				INSERT INTO ".$SqlTableListObj->getSQLTableName('site_module')." VALUES ( 
				'".$R['id2']."',
				'".$_REQUEST['site_context']['site_id']."',
				'".$R['module_id']."',
				'".$R['module_etat']."',
				'".$R['module_position']."'
				);";

				manipulation_traitement_requete ( $requete1 );
				manipulation_traitement_requete ( $requete2 );
				$tl_['eng']['M_MODULE_1_0004'] = "Job done!";
				$tl_['fra']['M_MODULE_1_0004'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_MODULE_1_0004" , $tl_[$l]['M_MODULE_1_0004'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['module_selection'] = $_REQUEST['M_MODULE']['id2'];
				$R['creation_effectuee'] = 1;
				$R['module_selection'] = $pv['module_selection'];
				$R['creation_faite'] = 1; 
			}
		break;

// --------------------------------------------------------------------------------------------
//		Modification de module
		case 2:
			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}

			$_REQUEST['module_selection'] = $R['id'];				/*	Valeur de retour pour uni_gestion_des_modules_p02	*/
			systeme_requete_unifiee ( 2 , "M_MODULE_regpv" , $R['groupe_pour_voir'] , 0 , "MG_2_0002" , $R['groupe_pour_voir']);
			systeme_requete_unifiee ( 2 , "M_MODULE_regpu" , $R['groupe_pour_utiliser'] , 0 , "MG_2_0003" , $R['groupe_pour_utiliser']);

			if ( $R['ERR'] != 1 ) {
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['module_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				string_DB_escape ( $_REQUEST['liste_colonne']['module'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['module'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['module'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SqlTableListObj->getSQLTableName('module')." SET ".$requete_colonne." WHERE module_id = '".$R['id']."';";

				$requete2 = "
				UPDATE ".$SqlTableListObj->getSQLTableName('site_module')." SET 
				module_etat			= '".$R['etat']."', 
				module_position		= '".$R['position']."'  
				WHERE site_id		= '".$_REQUEST['site_context']['site_id']."'  
				AND module_id		= '".$R['id']."' 
				;";

				manipulation_traitement_requete ( $requete1 );
				manipulation_traitement_requete ( $requete2 );
				$tl_['eng']['M_MODULE_2_0005'] = "Job done!";
				$tl_['fra']['M_MODULE_2_0005'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_MODULE_2_0005" , $tl_[$l]['M_MODULE_2_0005'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['module_selection'] = $_REQUEST['M_MODULE']['id'];
				$R['modification_effectuee'] = 1;
				$R['module_selection'] = $pv['module_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//		Suppression de module
		case 3:
			if ( !isset($R['confirmation_suppression']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_suppression_oubli'] = 1;
			}

			systeme_requete_unifiee ( 2 , "M_MODULE_rem" , $R['nom'] , 0 , "MG_3_0001" , $R['id'] );
			$_REQUEST['module_selection'] = $R['id'];

			if ( $R['ERR'] != 1 ) {
				$requete1 = "
				UPDATE ".$SqlTableListObj->getSQLTableName('site_module')." 
				SET module_etat = '2', 
				module_position = '1' 
				WHERE module_id = '".$R['id']."'
				;";
				manipulation_traitement_requete ( $requete1 );
				$tl_['eng']['M_MODULE_3_0002'] = "Job done!";
				$tl_['fra']['M_MODULE_3_0002'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_MODULE_3_0002" , $tl_[$l]['M_MODULE_3_0002'] );
				$_REQUEST['CC']['status'] = "OK";

				$pv['module_selection'] = $_REQUEST['M_MODULE']['id'];
				$R['modification_effectuee'] = 1;
				$R['module_selection'] = $pv['module_selection'];
			}
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_MODULE_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_MODULE_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_MODULE_5_caption'];
			if ( $R['nom'] == "Nouveau module" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND module_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT mdl.module_nom 
				FROM ".$SqlTableListObj->getSQLTableName('module')." as mdl , ".$SqlTableListObj->getSQLTableName('site_module')." as sm 
				WHERE mdl.module_id = sm.module_id 
				AND sm.site_id = ".$_REQUEST['site_context']['site_id']."
				".$pv['clause']."
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['module_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT mdl.*, sm.module_etat 
				FROM ".$SqlTableListObj->getSQLTableName('module')." as mdl , ".$SqlTableListObj->getSQLTableName('site_module')." as sm 
				WHERE mdl.module_id = sm.module_id 
				AND sm.site_id = ".$_REQUEST['site_context']['site_id']."
				AND mdl.module_nom = '".$R['nom']."'
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_MODULE_5_001'] = "No module named ".$R['nom']." exists.";
					$tl_['fra']['M_MODULE_5_001'] = "Le module nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_MODULE_5_0001" , $tl_[$l]['M_MODULE_5_001'] ); 
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
					$tl_['eng']['bad']['0'] = "During";		$tl_['fra']['bad']['0'] = "Pendant";
					$tl_['eng']['bad']['1'] = "Before";		$tl_['fra']['bad']['1'] = "Avant";
					$tl_['eng']['bad']['2'] = "After";		$tl_['fra']['bad']['2'] = "Apr&eagrave;s";

					$pv = $_REQUEST['ICC']['module_deco'];			$_REQUEST['ICC']['module_deco'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['module_etat'];			$_REQUEST['ICC']['module_etat'] = $tl_[$l]['oo'][$pv];
					$pv = $_REQUEST['ICC']['module_adm_control'];	$_REQUEST['ICC']['module_adm_control'] = $tl_[$l]['yn'][$pv];
					$pv = $_REQUEST['ICC']['module_execution'];		$_REQUEST['ICC']['module_execution'] = $tl_[$l]['bad'][$pv];

					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
unset ( $R );
}
?>
