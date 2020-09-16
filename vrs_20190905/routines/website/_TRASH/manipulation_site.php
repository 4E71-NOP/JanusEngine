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
//	Manipulation site
// --------------------------------------------------------------------------------------------
function manipulation_site () {
	global $WebSiteObj, $db, $db_, $langues;
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	$R = &$_REQUEST['M_SITWEB'];

	$tl_['eng']['log_init'] = "Website modification";
	$tl_['fra']['log_init'] = "Manipulation site web";

	$_REQUEST['conv_expr_section'] = "M_SITWEB";
	$R['ERR'] = 0;
	$l = $_REQUEST['site_context']['site_lang'];																	// recupere la langue courante
	$tl_['eng']['si'] = "Website processing ";
	$tl_['fra']['si'] = "Manipulation site web";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;

	//$_REQUEST['site_context']['site_id']	= $_REQUEST['site_context']['site_id'];
	//$_REQUEST['site_context']['site_nom']		= $_REQUEST['site_context']['site_nom'];

	switch ($R['action']) {
// --------------------------------------------------------------------------------------------
//	Pas d'action
// --------------------------------------------------------------------------------------------
	case 0: 
	break;

// --------------------------------------------------------------------------------------------
//	Creation de site
// --------------------------------------------------------------------------------------------
	case 1:
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT * 
		FROM ".$SqlTableListObj->getSQLTableName('site_web')." 
		WHERE sw_nom = '".$R['nom']."';
		");
		if ( num_row_sql($dbquery) > 0 ) {
			$tl_['eng']['M_SITWEB_1_0001'] = "The website named ".$R['sw_nom']." already exists.";
			$tl_['fra']['M_SITWEB_1_0001'] = "Le site '".$R['sw_nom']."' existe deja.";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_SITWEB_1_0001" , $tl_[$l]['M_SITWEB_1_0001'] );
			$R['ERR'] = 1;
		}
		if ( strlen($R['groupe']) == 0 ) { 
			$tl_['eng']['M_SITWEB_1_0002'] = "The group name was not found.";
			$tl_['fra']['M_SITWEB_1_0002'] = "Le groupe n'est pas sp&eacute;cifi&eacute;.";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_SITWEB_1_0002" , $tl_[$l]['M_SITWEB_1_0002'] );
			$R['ERR'] = 1;
		}
		if ( strlen($R['utilisateur']) == 0 ) { 
			$tl_['eng']['M_SITWEB_1_0003'] = "The user name was not found.";
			$tl_['fra']['M_SITWEB_1_0003'] = "L'utilisateur n'est pas sp&eacute;cifi&eacute;.";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_SITWEB_1_0003" , $tl_[$l]['M_SITWEB_1_0003'] );
			$R['ERR'] = 1;
		}
		if ( strlen($R['mot_de_passe']) == 0 ) { 
			$tl_['eng']['M_SITWEB_1_0004'] = "The password was not found.";
			$tl_['fra']['M_SITWEB_1_0004'] = "Le mot de passe n'est pas sp&eacute;cifi&eacute;.";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_SITWEB_1_0004" , $tl_[$l]['M_SITWEB_1_0004'] );
			$R['ERR'] = 1;
		}

		if ( $R['ERR'] != 1 ) {
			install_utilisateur_initial ( $R['utilisateur'] , $R['mot_de_passe'] );
			$R['sw_id'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('site_web') , "sw_id" );

			$R['lang_save']		= $R['sw_lang'];

			string_DB_escape ( $_REQUEST['liste_colonne']['site'] , $_REQUEST['conv_expr_section'] );
			foreach ( $_REQUEST['liste_colonne']['site_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A]); }

			reset ( $_REQUEST['liste_colonne']['site'] ); 
			$requete_valeurs = " (";
			unset ( $A );
			foreach ( $_REQUEST['liste_colonne']['site'] as $A ) { $requete_valeurs .= "'" . $R[$A] . "',"; }
			$requete_valeurs = substr ( $requete_valeurs , 0 , -1 ) . ") ";
			$requete1 = "INSERT INTO ".$SqlTableListObj->getSQLTableName('site_web')." VALUES ".$requete_valeurs.";";

			manipulation_traitement_requete ( $requete1 );

			// Site context fake. 
			$_REQUEST['site_context']['site_id']			=  $R['id'];
			$_REQUEST['site_context']['site_nom']			=  $R['nom'];
			$_REQUEST['site_context']['site_titre']			=  $R['titre'];
			$_REQUEST['site_context']['site_repertoire']	=  $R['repertoire'];
			$_REQUEST['site_context']['theme_id']			=  $R['theme_id'];
			$_REQUEST['site_context']['site_lang']			=  $R['lang'];

			switch ( $db_['dal'] ) {
			case "MYSQLI":
				$_REQUEST['site_context']['group']				= $db->real_escape_string( $R['group'] );
				$_REQUEST['site_context']['user']				= $db->real_escape_string( $R['user'] );
				$_REQUEST['site_context']['password']			= $db->real_escape_string( $R['password'] );
			break;
			case "PDOMYSQL":
				$_REQUEST['site_context']['group']				= $db->quote( $R['group']);
				$_REQUEST['site_context']['user']				= $db->quote( $R['user']);
				$_REQUEST['site_context']['password']			= $db->quote( $R['password']);
			break;
			case "SQLITE":
			break;
			case "ADODB":
				$_REQUEST['site_context']['group']				= $db->qstr( $R['group']);
				$_REQUEST['site_context']['user']				= $db->qstr( $R['user']);
				$_REQUEST['site_context']['password']			= $db->qstr( $R['password']);
			break;
			case "PEARDB":
			case "PEARSQLITE":
				$_REQUEST['site_context']['group']				= $db->escape( $R['group'] , $escape_wildcards = false);
				$_REQUEST['site_context']['user']				= $db->escape( $R['user'] , $escape_wildcards = false);
				$_REQUEST['site_context']['password']			= $db->escape( $R['password'] , $escape_wildcards = false);
			break;
			}

			$_REQUEST['manip_site_special'] = 1;
			$pv['l'] = $_REQUEST['site_context']['site_lang'];
			$_REQUEST['site_context']['site_lang'] = $l = $langues[$pv['l']]['langue_639_3'];
			genere_tableau_requete ( $_REQUEST['site_context']['site_id'] );

			$tl_['eng']['ok'] = "Job done!";
			$tl_['fra']['ok'] = "Execution &eacute;ffectu&eacute;e!";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $R['nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "M_SITWEB_1_0005" , $tl_[$l]['ok'] );	
			$_REQUEST['CC']['status'] = "OK";

			$pv['website_selection'] = $_REQUEST['M_SITWEB']['id'];
			if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
			$R['creation_effectuee'] = 1;
			$R['website_selection'] = $pv['website_selection'];
		}
	break;

// --------------------------------------------------------------------------------------------
//	modification de site
	case 2:
		if ( $_REQUEST['site_context']['site_id'] == 0 ) {
			$tl_['eng']['M_SITWEB_2_0001'] = "Site context error. No website selected";
			$tl_['fra']['M_SITWEB_2_0001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "M_SITWEB_2_0001" , $tl_[$l]['M_SITWEB_2_0001'] );
			$R['ERR'] = 1;
		}
		else {
			if ( !isset($R['confirmation']) && $_REQUEST['contexte_d_execution'] == "Admin_menu" ) { 
				$R['ERR'] = 1;
				$R['confirmation_oubli'] = 1;
			}
			if ( strlen($R['sw_theme_nom']) != 0 ) {
				$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
				SELECT a.theme_id AS theme_id,a.theme_nom AS theme_nom 
				FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." a , ".$SqlTableListObj->getSQLTableName('site_theme')." b 
				WHERE a.theme_nom = '".$R['sw_theme_nom']."' 
				AND a.theme_id = b.theme_id 
				AND b.site_id = '".$_REQUEST['site_context']['site_id']."' 
				;");
				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['M_SITWEB_2_0002'] = "The theme ".$R['theme']." doesn't exists for this site (".$_REQUEST['site_context']['site_titre'].").";
					$tl_['fra']['M_SITWEB_2_0002'] = "Le theme ".$R['theme']." n'existe pas pour le site (".$_REQUEST['site_context']['site_titre'].").";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] ." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_SITWEB_2_0002" , $tl_[$l]['M_SITWEB_2_0002'] );
					$R['ERR'] = 1;
				}
				else { while ($dbp = fetch_array_sql($dbquery)) { $R['sw_theme_id'] = $dbp['theme_id']; } } 
			}

			if ( $R['ERR'] != 1 ) {
				foreach ( $_REQUEST['liste_colonne']['site_conversion'] as $A ) { $R[$A] = conversion_expression ( $R[$A] ); }
				string_DB_escape ( $_REQUEST['liste_colonne']['site'] , $_REQUEST['conv_expr_section'] );

				reset ( $_REQUEST['liste_colonne']['site'] ); 
				$requete_colonne = "";
				unset ( $A );
				foreach ( $_REQUEST['liste_colonne']['site'] as $A ) { $requete_colonne .= $A . "='".$R[$A]."', "; }
				$requete_colonne = substr ( $requete_colonne , 0 , -2 );
				$requete1 = "UPDATE ".$SqlTableListObj->getSQLTableName('site_web')." SET ".$requete_colonne." WHERE sw_id = '".$_REQUEST['site_context']['site_id']."';";
				manipulation_traitement_requete ( $requete1 );

				$tl_['eng']['M_SITWEB_2_0003'] = "Job done!";
				$tl_['fra']['M_SITWEB_2_0003'] = "Execution &eacute;ffectu&eacute;e!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $R['nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "M_SITWEB_2_0003" , $tl_[$l]['M_SITWEB_2_0003'] );
				$_REQUEST['CC']['status'] = "OK";

				if ( strlen($R['ajout_lang']) != 0 ) {
					$R['ajout_lang_nom'] = $R['ajout_lang'];
					$R['ajout_lang'] = conversion_expression ( $R['ajout_lang']);
					$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT * FROM ".$SqlTableListObj->getSQLTableName('site_langue')." WHERE site_id = '".$R['id']."';");

					if ( num_row_sql($dbquery) != 0 ) {
						while ($dbp = fetch_array_sql($dbquery)) {
							if ( $dbp['lang_id'] == $R['ajout_lang'] ) {
								$tl_['eng']['M_SITWEB_2_0004'] = "langage ".$R['ajout_lang_nom']." (id=".$R['ajout_lang'].") is already assigned to this title. No operation.";
								$tl_['fra']['M_SITWEB_2_0004'] = "La langue ".$R['ajout_lang_nom']." (id=".$R['ajout_lang'].") est deja attribu&eacute; a ce site. Pas d'op&eacute;ration";
								journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "INFO" , "M_SITWEB_2_0004" , $tl_[$l]['M_SITWEB_2_0004'] );
								$R['ERR'] = 1;
							} 
						}
					}
					//else { $R['ERR'] = 1; } 

					if ( $R['ERR'] != 1 ) {
						$R['site_lang_id'] = manipulation_trouve_id_suivant ( $SqlTableListObj->getSQLTableName('site_langue') , "site_lang_id" );
						requete_sql($_REQUEST['sql_initiateur'],"
						INSERT INTO ".$SqlTableListObj->getSQLTableName('site_langue')." VALUES ( 
						'".$R['site_lang_id']."',
						'".$_REQUEST['site_context']['site_id']."',
						'".$R['sw_ajout_lang']."'
						);");
					}
				}

				if ( strlen($R['suppression_lang']) != 0 ) {
					$R['suppression_lang'] = conversion_expression ( $R['suppression_lang']);
					$requete1 = "
					DELETE FROM ".$SqlTableListObj->getSQLTableName('site_langue')."
					WHERE site_id = '".$_REQUEST['site_context']['site_id']."' 
					AND lang_id = '".$R['suppression_lang']."';";
					manipulation_traitement_requete ( $requete1 );
				}
			}
			$pv['website_selection'] = $_REQUEST['M_SITWEB']['id'];
			$R['modification_effectuee'] = 1;
			$R['website_selection'] = $pv['website_selection'];
		}
	break;
// --------------------------------------------------------------------------------------------
//	Suppression de site
	case 3:
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT * FROM ".$SqlTableListObj->getSQLTableName('site_web')." 
		WHERE sw_nom = '".$R['nom']."'
		;");
		if ( num_row_sql($dbquery) == 0 ) {
			$tl_['eng']['M_SITWEB_3_0001'] = "the site  '".$R['nom']."' doesn't exists.";
			$tl_['fra']['M_SITWEB_3_0001'] = "Le site '".$R['nom']."' n'existe pas.";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_SITWEB_3_0001" , $tl_[$l]['M_SITWEB_3_0001'] ); 
			$R['ERR'] = 1;
		}
		else { while ($dbp = fetch_array_sql($dbquery)) { $R['id'] = $dbp['sw_id']; } }
		if ( $R['ERR'] != 1 ) {
			$requete1 = "UPDATE ".$SqlTableListObj->getSQLTableName('site_web')." 
			SET sw_etat = 'SUPPRIME'
			WHERE sw_id = '".$R['id']."';";
			manipulation_traitement_requete ( $requete1 );

			$pv['website_selection'] = $_REQUEST['M_SITWEB']['id'];
			if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { unset ($R); }
			$R['modification_effectuee'] = 1;
			$R['website_selection'] = $pv['website_selection'];
		}
	break;

// --------------------------------------------------------------------------------------------
//	show
	case 5:
		$tl_['eng']['M_SITWEB_5_caption'] = "Result of :" . $_REQUEST['tampon_commande'];
		$tl_['fra']['M_SITWEB_5_caption'] = "R&eacute;sultat de : " . $_REQUEST['tampon_commande'];
		$_REQUEST['ICC_caption'] = $tl_[$l]['M_SITWEB_5_caption'];

		$_REQUEST['ICC_controle']['affichage_requis'] = 0;
		if ( $R['nom'] == "Nouveau site" ) {
			$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
			SELECT sw_nom FROM ".$SqlTableListObj->getSQLTableName('site_web')." 
			;");
			while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['ICC']['name'] .= $dbp['sw_nom'] . ", "; }
			$_REQUEST['ICC']['name'] = substr ( $_REQUEST['ICC']['name'] , 0 , -2 ) . ".";
			$_REQUEST['ICC_controle']['affichage_requis'] = 1;
		}
		else {
			$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
			SELECT * FROM ".$SqlTableListObj->getSQLTableName('site_web')." 
			WHERE sw_nom = '".$R['nom']."'
			;");

			if ( num_row_sql($dbquery) == 0 ) {
				$tl_['eng']['M_SITWEB_5_001'] = "No website named ".$R['nom']." exists.";
				$tl_['fra']['M_SITWEB_5_001'] = "Le site nom&eacute; ".$R['nom']." n'existe pas.";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "ERR" , "M_SITWEB_5_0001" , $tl_[$l]['M_SITWEB_5_001'] ); 
				$R['ERR'] = 1;
			}
			else {
				while ($dbp = fetch_array_sql($dbquery)) { 
					foreach ( $dbp as $A => $B ) { $_REQUEST['ICC'][$A] = $B; }
				}

				$tl_['eng']['swls']['0'] = "No";			$tl_['fra']['swls']['0'] = "Non";
				$tl_['eng']['swls']['1'] = "Yes";			$tl_['fra']['swls']['1'] = "Oui";
				$tl_['eng']['etat']['0'] = "Offline";		$tl_['fra']['etat']['0'] = "Hors ligne";
				$tl_['eng']['etat']['1'] = "Online";		$tl_['fra']['etat']['1'] = "En ligne";
				$tl_['eng']['css']['0'] = "Dynamic";		$tl_['fra']['css']['0'] = "Dynamique";
				$tl_['eng']['css']['1'] = "Static";			$tl_['fra']['css']['1'] = "Statique";
				$tl_['eng']['galm']['0'] = "Off";			$tl_['fra']['galm']['0'] = "D&eacute;sactiv&eacute;";
				$tl_['eng']['galm']['1'] = "Database";		$tl_['fra']['galm']['1'] = "Base de donn&eacute;e";
				$tl_['eng']['galm']['2'] = "File";			$tl_['fra']['galm']['2'] = "Fichier";

				$pv = $_REQUEST['ICC']['sw_lang'];						$_REQUEST['ICC']['sw_lang'] = $langues[$pv]['langue_639_3'];
				$pv = $_REQUEST['ICC']['sw_lang_select'];				$_REQUEST['ICC']['sw_lang_select'] = $tl_[$l]['swls'][$pv];
//				$_REQUEST['ICC']['theme_id'] = "";
				$pv = $_REQUEST['ICC']['sw_etat'];						$_REQUEST['ICC']['sw_etat'] = $tl_[$l]['etat'][$pv];
				$pv = $_REQUEST['ICC']['sw_stylesheet'];				$_REQUEST['ICC']['sw_stylesheet'] = $tl_[$l]['galm'][$pv];
				$pv = $_REQUEST['ICC']['sw_gal_mode'];					$_REQUEST['ICC']['sw_gal_mode'] = $tl_[$l]['galm'][$pv];
				$_REQUEST['ICC']['sw_gal_qualite'] .= " % ";
				$_REQUEST['ICC']['sw_gal_x'] .= " px";
				$_REQUEST['ICC']['sw_gal_y'] .= " px";
				$_REQUEST['ICC']['sw_gal_liserai'] .= " px";			$pv = $_REQUEST['ICC']['sw_ma_diff'];
				$_REQUEST['ICC']['sw_ma_diff'] = $tl_[$l]['swls'][$pv];

				$_REQUEST['ICC_controle']['affichage_requis'] = 1;
			}
		}
	break;
	}
unset ( $R );
}
?>
