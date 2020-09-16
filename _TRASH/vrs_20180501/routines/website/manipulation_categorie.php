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

//	Manipulation categorie
// --------------------------------------------------------------------------------------------

function MC_trouve_dernier_fils ( $function_parametres ) {
	$dbquery_MC = requete_sql($function_parametres['sql_initiateur'],"
	SELECT cate_position 
	FROM ".$function_parametres['SQL_tab_categorie']." 
	WHERE cate_parent = '".$function_parametres['parent']."' 
	AND site_id = '".$function_parametres['site_id']."' 
	ORDER BY cate_position DESC 
	LIMIT 1
	;");
	while ($dbp_MC = fetch_array_sql($dbquery_MC)) { $result = $dbp_MC['cate_position']; }
	return  $result;
}

function MC_reconstruit_branche () {
	global $SQL_tab_abrege;
	$R = &$_REQUEST['M_CATEGO'];
	$dbquery = requete_sql( $_REQUEST['sql_initiateur'], "
	SELECT cate_id,cate_parent,cate_nom,cate_position,derniere_modif 
	FROM ".$SQL_tab_abrege['categorie']." 
	WHERE cate_parent = '".$R['parent']."' 
	AND site_id ='".$_REQUEST['site_context']['site_id']."' 
	AND cate_lang = '".$R['lang']."' 
	ORDER BY cate_position ASC,derniere_modif ".$R['sql_derniere_modif']." 
	;");

	$i = 1;
	$liste_categorie_ = array();
	while ($dbp = fetch_array_sql($dbquery)) { 
		$liste_categorie_[$i]['controle']			= $i;
		$liste_categorie_[$i]['cate_id']			= $dbp['cate_id'];
		$liste_categorie_[$i]['cate_nom']			= $dbp['cate_nom'];
		$liste_categorie_[$i]['cate_parent']		= $dbp['cate_parent'];
		$liste_categorie_[$i]['cate_position']	= $dbp['cate_position'];
		$i++;
	}
	foreach ( $liste_categorie_ as &$A ) { 
		if ( $A['cate_position'] != $A['controle'] ) { $MC_position_err['signal'] = 1 ; }
		$A['cate_position'] = $A['controle'];
	}
	if ( $MC_position_err['signal'] == 1 ) {
		foreach ( $liste_categorie_ as $B ) { 
			requete_sql($_REQUEST['sql_initiateur'], "
			UPDATE ".$SQL_tab_abrege['categorie']." 
			SET cate_position = '".$B['cate_position']."' 
			WHERE cate_id = '".$B['cate_id']."' 
			;");
		}
	}
	foreach ( $liste_categorie_ as $C ) { 
		if ( $C['cate_id'] ==  $R['id'] ) { $R['position'] = $C['cate_position']; }
	}
}

function MC_cate_devient_dernier() {
	global $SQL_tab_abrege;
	$R = &$_REQUEST['M_CATEGO'];
	requete_sql( $_REQUEST['sql_initiateur'], "
	UPDATE ".$SQL_tab_abrege['categorie']." SET 
	cate_position 	= '100', 
	derniere_modif	= '".time()."' 
	WHERE cate_id	= '".$R['id']."' 
	;");
}

// --------------------------------------------------------------------------------------------
function manipulation_categorie () {
	global $site_web, $SQL_tab, $SQL_tab_abrege, $db, $langues;
	$R = &$_REQUEST['M_CATEGO'];

	$_REQUEST['conv_expr_section'] = "M_CATEGO";
	$R['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$R['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];
	$tl_['eng']['si'] = "Category processing ";
	$tl_['fra']['si'] = "Manipulation cat&eacute;gorie";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['M_CATEGO_00001'] = "Site context error. No website selected";
		$tl_['fra']['M_CATEGO_00001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_CATEGO_00001" , $tl_[$l]['M_CATEGO_00001'] );
		$R['ERR'] = 1;
	}
	else {
		$MC['site_nom'] = $_REQUEST['site_context']['site_nom'];
		switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//	Pas d'action
		case 0: 
//		echo ("Pas de modification de catégorie");
		break;

// --------------------------------------------------------------------------------------------
//	Creation de categorie
		case 1:
			systeme_requete_unifiee ( 3 , "M_CATEGO_rdc" , $_REQUEST['M_ARTICL']['nom'] , 0 , "M_CATEGO_1_0001" , $_REQUEST['fake'] );
			if ( $R['type'] == "ADMIN_CONF_EXTENSION" ) {
				systeme_requete_unifiee ( 1 , "M_CATEGO_rrp" , $R['type'] , 0 , "M_CATEGO_1_0005" , $R['parent']);
				$R['type'] = "menu_admin";
				$R['bouclage'] = "initial_online";
			}
			else {
				systeme_requete_unifiee ( 1 , "M_CATEGO_rep" , $R['parent'] , 0 , "M_CATEGO_1_0002" , $R['parent']);
				systeme_requete_unifiee ( 2 , "M_CATEGO_reb" , $R['bouclage'] , 0 , "M_CATEGO_1_0003" , $R['bouclage']);
			}
			systeme_requete_unifiee ( 2 , "M_CATEGO_reg" , $R['groupe'] , 0 , "M_CATEGO_1_0004" , $R['groupe']);

			if ( $R['ERR'] != 1 ) {
				if ( !isset($R['position']) ) {
					$function_parametres = array (
						"sql_initiateur" 	=> $_REQUEST['sql_initiateur'],
						"SQL_tab_categorie" => $SQL_tab_abrege['categorie'],
						"parent" 			=> $R['parent'],
						"site_id" 			=> $site_web['sw_id']
					);
					$MC_position = MC_trouve_dernier_fils( $function_parametres ) + 1;
				}

				$pv['l'] = $R['lang'];
				$R['lang'] 		= $langues[$pv['l']]['id'];

				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['categorie_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				string_DB_escape ( $_REQUEST['liste_colonne']['categorie'] , $_REQUEST['conv_expr_section'] );

				$R['id'] = manipulation_trouve_id_suivant ( $SQL_tab_abrege['categorie'] , "cate_id" );

				reset ( $_REQUEST['liste_colonne']['categorie'] ); 
				$requete_valeurs = " (";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['categorie'] as $A ) {$requete_valeurs .= "'" . $R[$A] . "',"; }
				$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
				$requete1 = "INSERT INTO ".$SQL_tab_abrege['categorie']." ".$requete_colonne." VALUES ".$requete_valeurs.";";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_CATEGO_1_0005'] = "Job done!";
				$tl_['fra']['M_CATEGO_1_0005'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_CATEGO_1_0005" , $tl_[$l]['M_CATEGO_1_0005'] );
				$_REQUEST['CC']['status'] = "OK";

				$R['creation_effectuee'] = 1;
			}
		break;

// --------------------------------------------------------------------------------------------
//	modification de categorie
		case 2:
			if ( !isset($R['confirmation_modification']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_modification_oubli'] = 1;
			}
			else {
				$_REQUEST['M_CATEGO_Nouv_texte']['etat']		= $R['etat'];		// nouveau avant convertion
				$_REQUEST['M_CATEGO_Nouv_texte']['parent']	= $R['parent'];		// nouveau avant convertion
				$_REQUEST['M_CATEGO_Nouv_texte']['position']	= $R['position'];

				systeme_requete_unifiee ( 2 , "M_CATEGO_rep" , $_REQUEST['M_CATEGO_Initial_texte']['parent']		, 0 , "M_CATEGO_2_0001" , $R['parent']);
				systeme_requete_unifiee ( 2 , "M_CATEGO_reb" , $R['bouclage']	, 0 , "M_CATEGO_2_0002" , $R['bouclage']);
				systeme_requete_unifiee ( 2 , "M_CATEGO_reg" , $R['groupe']		, 0 , "M_CATEGO_2_0003" , $R['groupe']);
			}

			if ( $R['ERR'] != 1 && $R['confirmation_modification'] != 0 ) {
				$pv['l'] = $R['lang'];
				$R['lang'] 		= $langues[$pv['l']]['id'];

				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['categorie_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }
				string_DB_escape ( $_REQUEST['liste_colonne']['categorie'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['categorie'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['categorie'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SQL_tab_abrege['categorie']." SET ".$requete_colonne." WHERE cate_id = '".$R['id']."';";
				manipulation_traitement_requete ( $requete1 );

				$R['sql_derniere_modif'] = "ASC";
				$i = ( $R['position'] - $_REQUEST['M_CATEGO_Initial_texte']['position'] );  
				if ( $i < 0 ) { $R['sql_derniere_modif'] = "DESC"; MC_reconstruit_branche (); }
				if ( $i > 0 ) { $R['sql_derniere_modif'] = "ASC"; MC_reconstruit_branche (); }

				if ( $_REQUEST['M_CATEGO_Nouv_texte']['etat'] != $_REQUEST['M_CATEGO_Initial_texte']['etat'] || $_REQUEST['M_CATEGO_Nouv_texte']['parent'] != $_REQUEST['M_CATEGO_Initial_texte']['parent'] ) {
					MC_cate_devient_dernier();

					$pv['i'] = $R['parent'];
					$R['parent'] = $_REQUEST['M_CATEGO_Initial_numerique']['parent'];
					$R['sql_derniere_modif'] = "ASC";
					MC_reconstruit_branche ();
					$R['parent'] = $pv['i'];
				}

				$R['sql_derniere_modif'] = "ASC";
				MC_reconstruit_branche ();

				$tl_['eng']['M_CATEGO_2_0005'] = "Job done!";
				$tl_['fra']['M_CATEGO_2_0005'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_CATEGO_2_0005" , $tl_[$l]['M_CATEGO_2_0005'] );
				$_REQUEST['CC']['status'] = "OK";
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
				systeme_requete_unifiee ( 2 , "M_CATEGO_rep" , $R['cate_nom'] , 0 , "M_CATEGO_3_0001" , $R['cate_id']);
				$requete = "
				UPDATE ".$SQL_tab_abrege['categorie']." SET 
				cate_etat 		= '2', 
				derniere_modif	= '".time()."' 
				WHERE cate_id	= '".$R['cate_id']."';";
				manipulation_traitement_requete ( $requete );

				$R['sql_derniere_modif'] = "ASC";
				MC_cate_devient_dernier();
				MC_reconstruit_branche ();

				$tl_['eng']['M_CATEGO_3_0005'] = "Job done!";
				$tl_['fra']['M_CATEGO_3_0005'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_CATEGO_3_0005" , $tl_[$l]['M_CATEGO_3_0005'] );
				$_REQUEST['CC']['status'] = "OK";
				$R['modification_effectuee'] = 1;
			}
		break;
// --------------------------------------------------------------------------------------------
//		show
		case 5:
			$tl_['eng']['M_CATEGO_5_caption'] = "Result of : " . $_REQUEST['tampon_commande'];
			$tl_['fra']['M_CATEGO_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
			$_REQUEST['ICC_caption'] = $tl_[$l]['M_CATEGO_5_caption'];
			if ( $R['nom'] == "Nouvelle categorie" ) {
				if ( strlen( $R['filtre'] ) > 0 ) { $pv['clause'] = "AND cate_nom LIKE '%".$R['filtre']."%' "; }
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT cate_nom, cate_lang  
				FROM ".$SQL_tab_abrege['categorie']." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
				".$pv['clause']." 
				ORDER BY cate_nom, cate_position, cate_lang 
				;");
				while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['cate_nom'] . ", "; }
				$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
			else {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT * 
				FROM ".$SQL_tab_abrege['categorie']." 
				WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
				AND cate_nom = '".$R['nom']."'
				ORDER BY cate_nom, cate_position, cate_lang 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_CATEGO_5_001'] = "No category named ".$R['nom']." exists.";
					$tl_['fra']['M_CATEGO_5_001'] = "La cat&eacute;gorie nom&eacute; ".$R['nom']." n'existe pas.";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $MC['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_CATEGO_5_0001" , $tl_[$l]['M_CATEGO_5_001'] ); 
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
					}
					$tl_['eng']['yn']['0'] = "No";						$tl_['fra']['yn']['0'] = "Non";
					$tl_['eng']['yn']['1'] = "Yes";						$tl_['fra']['yn']['1'] = "Oui";
					$tl_['eng']['oo']['0'] = "Offline";					$tl_['fra']['oo']['0'] = "Hors ligne";
					$tl_['eng']['oo']['1'] = "Online";					$tl_['fra']['oo']['1'] = "En ligne";
					$tl_['eng']['typ']['0'] = "Root article";			$tl_['fra']['typ']['0'] = "Article racine";
					$tl_['eng']['typ']['1'] = "Article";				$tl_['fra']['typ']['1'] = "Article";
					$tl_['eng']['typ']['2'] = "Root admin menu";		$tl_['fra']['typ']['2'] = "Menu admin racine";
					$tl_['eng']['typ']['3'] = "Admin menu";				$tl_['fra']['typ']['3'] = "Menu admin";
					$tl_['eng']['rol']['0'] = "None";					$tl_['fra']['rol']['0'] = "Aucun";
					$tl_['eng']['rol']['1'] = "Article examination";	$tl_['fra']['rol']['1'] = "Correction d'article";
					$pv = $_REQUEST['ICC']['cate_type'];			$_REQUEST['ICC']['cate_type'] = $tl_[$l]['typ'][$pv];
					$pv = $_REQUEST['ICC']['cate_lang'];			$_REQUEST['ICC']['cate_lang'] = $langues[$pv]['langue_639_3'];
					$pv = $_REQUEST['ICC']['cate_etat'];			$_REQUEST['ICC']['cate_etat'] = $tl_[$l]['oo'][$pv];
					$pv = $_REQUEST['ICC']['cate_role'];			$_REQUEST['ICC']['cate_role'] = $tl_[$l]['rol'][$pv];
					$pv = $_REQUEST['ICC']['cate_doc_premier'];		$_REQUEST['ICC']['cate_doc_premier'] = $tl_[$l]['yn'][$pv];

					$_REQUEST['ICC_controle']['affichage_requis'] = 1;
				}
			}
		break;
		}
	}
unset ( $R );
}
?>
