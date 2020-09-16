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
//	Manipulation des utilisateurs
// --------------------------------------------------------------------------------------------
function manipulation_contexte () {
	global $langues, $l;
	$SqlTableListObj = SqlTableList::getInstance(null, null);
	$R = &$_REQUEST['SC'];

	$_REQUEST['SC']['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$_REQUEST['SC']['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];																	/* recupere la langue courante */
	$tl_['eng']['si'] = "Changing website context";
	$tl_['fra']['si'] = "Changement du contexte de site";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['SC_001'] = "Error on website contexte. No website selected.";
		$tl_['fra']['SC_001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "SC_001" , $tl_[$l]['SC_001'] );
		$_REQUEST['SC']['ERR'] = 1;
	}
	else {
		switch ($_REQUEST['SC']['action']) {
// --------------------------------------------------------------------------------------------
/*	Pas d'action																				*/
		case 0:
		break;

// --------------------------------------------------------------------------------------------
/*	Site_context																				*/
		case 1:
			install_utilisateur_initial ( $_REQUEST['SC']['utilisateur'] , $_REQUEST['SC']['mot_de_passe'] );
			if ( $R['website'] == "*website*" ) { $R['website'] = $_REQUEST['site_context']['site_nom']; } // Extension install

			$dbquery = requete_sql ($_REQUEST['sql_initiateur'] , "
			SELECT * 
			FROM ".$SqlTableListObj->getSQLTableName('site_web')." 
			WHERE sw_nom = '".$_REQUEST['SC']['site']."' 
			;");
			if ( num_row_sql($dbquery) == 0 ) {
				$tl_['eng']['SC_002'] = "Error : Unknow website!";
				$tl_['fra']['SC_002'] = "Erreur : Site inconnu!";
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "SC_002" , $tl_[$l]['SC_002'] );
				$_REQUEST['SC']['ERR'] = 1;
			}
			else {
				while ($dbp = fetch_array_sql($dbquery)) { 
					$pv['site_id']			= $dbp['sw_id'];
					$pv['site_nom']			= $dbp['sw_nom'];
					$pv['site_titre']		= $dbp['sw_titre'];
					$pv['site_repertoire']	= $dbp['sw_repertoire'];
					$pv['theme_id']			= $dbp['theme_id'];
					$pv['site_lang']		= $dbp['sw_lang'];
				}
			}

			if ($_REQUEST['SC']['ERR'] == 0 ) {
				$dbquery = requete_sql ($_REQUEST['sql_initiateur'] , "
				SELECT usr.user_id AS user_id, usr.user_login AS user_login, usr.user_password AS user_password 
				FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('groupe_user')." gu, ".$SqlTableListObj->getSQLTableName('site_groupe')." grp 
				WHERE user_login = '".$_REQUEST['SC']['utilisateur']."' 
				AND usr.user_id = gu.user_id 
				AND gu.groupe_id = grp.groupe_id 
				AND gu.groupe_premier = '1' 
				AND grp.site_id = '".$pv['site_id']."'
				;");

				if ( num_row_sql($dbquery) == 0 ) {
					$tl_['eng']['SC_003'] = "User unknow";
					$tl_['fra']['SC_003'] = "Utilisateur inconnu";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "SC_003" , $tl_[$l]['SC_003'] );
					$_REQUEST['SC']['ERR'] = 1;
				}
				else {
					while ($dbp = fetch_array_sql($dbquery)) { 
						$_REQUEST['SC']['db_user_id'] = $dbp['user_id'];
						$_REQUEST['SC']['db_user_login'] = $dbp['user_login'];
						$_REQUEST['SC']['db_user_password'] = $dbp['user_password'];
					}
				}
			}

			if ($_REQUEST['SC']['ERR'] == 0 ) {
				if ( $_REQUEST['SC_comportement'] == "interface_CC" ) { $_REQUEST['SC']['pass_comp'] = $_REQUEST['SC']['mot_de_passe']; }
				else { $_REQUEST['SC']['pass_comp'] = hash("sha1",stripslashes($_REQUEST['SC']['mot_de_passe'])); }

				if ( $_REQUEST['SC']['pass_comp'] != $_REQUEST['SC']['db_user_password'] ) {
					$tl_['eng']['SC_004'] = "Authentification failed";
					$tl_['fra']['SC_004'] = "L'authentification a &eacute;chou&eacute; ";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "SC_004" , $tl_[$l]['SC_004'] );
				}
				else {
					$_REQUEST['site_context']['site_id']			= $pv['site_id'];
					$_REQUEST['site_context']['site_nom']			= $pv['site_nom'];
					$_REQUEST['site_context']['site_titre']			= $pv['site_titre'];
					$_REQUEST['site_context']['site_repertoire']	= $pv['site_repertoire'];
					$_REQUEST['site_context']['theme_id']			= $pv['theme_id'];
					$_REQUEST['site_context']['site_lang_id']		= $_REQUEST['site_context']['site_lang']			=  $pv['site_lang'];
					$_REQUEST['site_context']['user']				= $_REQUEST['SC']['db_user_login'];
					$_REQUEST['site_context']['password']			= $_REQUEST['SC']['db_user_password'];

					$pv['l'] = $_REQUEST['site_context']['site_lang'];
					$_REQUEST['site_context']['site_lang'] = $l = $langues[$pv['l']]['langue_639_3'];

					genere_tableau_requete ( $_REQUEST['site_context']['site_id'] );

					$tl_['eng']['SC_005'] = "Done. The website context is now : " . $_REQUEST['site_context']['site_nom'] . " (".$_REQUEST['site_context']['site_lang'].").";
					$tl_['fra']['SC_005'] = "Commande execut&eacute;e. Le contexte de site est : " . $_REQUEST['site_context']['site_nom'] . " (".$_REQUEST['site_context']['site_lang'].").";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "OK" , "SC_005" , $tl_[$l]['SC_005'] );
					$_REQUEST['CC']['status'] = "OK";
				} 
			}
		break;
		}
	}
unset ( $R );
}
?>
