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
function manipulation_variable () {
	global $site_web, $SQL_tab, $SQL_tab_abrege, $db, $langues, $l;
	$R = &$_REQUEST['VAR'];

	$_REQUEST['VAR']['ERR'] = 0;
	$_REQUEST['sru_ERR']  = &$_REQUEST['VAR']['ERR'];

	$l = $_REQUEST['site_context']['site_lang'];																	/* recupere la langue courante */
	$tl_['eng']['si'] = "Variable modification";
	$tl_['fra']['si'] = "Modification de variable";
	$_REQUEST['sql_initiateur'] =	$tl_[$l]['si'] ;
	if ( $_REQUEST['site_context']['site_id'] == 0) {
		$tl_['eng']['SC_001'] = "Error on website contexte. No website selected.";
		$tl_['fra']['SC_001'] = "Erreur sur le context de site. Aucun site selectionn&eacute;.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['tampon_commande'] , "ERR" , "SC_001" , $tl_[$l]['SC_001'] );
		$_REQUEST['VAR']['ERR'] = 1;
	}
	else {
		switch ($_REQUEST['VAR']['action']) {
// --------------------------------------------------------------------------------------------
/*	Pas d'action																				*/
		case 0:
		break;

// --------------------------------------------------------------------------------------------
/*	Variable																					*/
		case 1:
			switch ( $R['variable'] ) {
				case "CC_check_level":
				case "CC_niveau_de_verification":
				if ( strlen( $R['valeur'] ) > 0 ) { 
					$_REQUEST['CC_niveau_de_verification'] = $R['valeur']; 
					$tl_['eng']['MVAR_1_0001'] = "Job done!";
					$tl_['fra']['MVAR_1_0001'] = "Execution &eacute;ffectu&eacute;e!";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "MVAR_1_0001" , $tl_[$l]['MVAR_1_0001'] );
					$_REQUEST['CC']['status'] = "OK";
				}
				case "authorisation_moniteur":
				if ( strlen( $R['valeur'] ) > 0 ) { 
					$_REQUEST['authorisation_moniteur'] = $R['valeur']; 
					$tl_['eng']['MVAR_1_0001'] = "Job done!";
					$tl_['fra']['MVAR_1_0001'] = "Execution &eacute;ffectu&eacute;e!";
					journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom']." : ".$_REQUEST['tampon_commande'] , "OK" , "MVAR_1_0001" , $tl_[$l]['MVAR_1_0001'] );
					$_REQUEST['CC']['status'] = "OK";
				}
			}
		}
	unset ( $R );
	}
}
?>
