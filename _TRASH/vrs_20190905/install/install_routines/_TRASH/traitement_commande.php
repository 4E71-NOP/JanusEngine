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

// TAC	= Table Analyse Commande
// TC	= Tampon commande
// TCR	= Tampon commande rendu

$_REQUEST['sql_initiateur'] = "Installation : ".$repertoire_en_cours."/".$section."/".$val;

unset ( $C );
$pv['TAC'] = array();
$pv['TC'] = "";
foreach ( $requete_insert as $L => $C ) { $pv['TC'] .= $C; }

cartographie_expression ( "//" , 1 , 99999 , $pv['TC'] , $pv['TAC'] );
cartographie_expression ( "\n" , 2 , 99998 , $pv['TC'] , $pv['TAC'] );
cartographie_expression ( "/*" , 3 , 99997 , $pv['TC'] , $pv['TAC'] );
cartographie_expression ( "*/" , 4 , 99996 , $pv['TC'] , $pv['TAC'] );
cartographie_expression ( "'"  , 5 , 99995 , $pv['TC'] , $pv['TAC'] );
cartographie_expression ( "\"" , 6 , 99994 , $pv['TC'] , $pv['TAC'] );
cartographie_expression ( ";"  , 7 , 99993 , $pv['TC'] , $pv['TAC'] );

ksort ($pv['TAC']);
reset ($pv['TAC']);
$pv['$tampon_commande_rendu_idx'] = 0;
$pv['TCR'] = array();
formattage_commande ( $pv['TAC'] , $pv['TC'] , $pv['TCR']  );

unset ( $C );
foreach ( $pv['TCR'] as $C ) {
	if ( !isset($C['Ordre']) ) { 
		command_line ( $C['cont'] ); 

		if ( $_REQUEST['manip_site_special'] == 1 ) {
			$_REQUEST['tampon_commande_special'][] = "add group name \"".$_REQUEST['site_context']['group']."\" title ROOT tag SENIOR_STAFF file \"graph/universel/icone_developpeur_001.jpg\" desc Owner";
			$_REQUEST['tampon_commande_special'][] = "add group name Lecteur parent racine title Lecteur tag LECTEUR file \"graph/universel/icone_developpeur_001.jpg\" desc \"Insignifiante chose qui semble avoir envie de lire\"";
			$_REQUEST['tampon_commande_special'][] = "add group name Anonyme parent Lecteur title Anonyme tag ANONYME file \"graph/universel/icone_developpeur_001.jpg\" desc \"En fait, personne...\"";

			$_REQUEST['tampon_commande_special'][] = "add user login \"".$_REQUEST['site_context']['user']."\" perso_name \"".$_REQUEST['site_context']['user']."\" password \"".$_REQUEST['site_context']['password']."\" status ACTIVE role_function PRIVATE";

			$_REQUEST['tampon_commande_special'][] = "user \"".$_REQUEST['site_context']['user']."\" join_group \"".$_REQUEST['site_context']['group']."\" primary_group OUI";
			$_REQUEST['tampon_commande_special'][] = "user \"".$_REQUEST['site_context']['user']."\" join_group Lecteur primary_group NON";
			$_REQUEST['tampon_commande_special'][] = "user \"".$_REQUEST['site_context']['user']."\" join_group Anonyme primary_group NON";

			unset ( $B );
			foreach ( $_REQUEST['tampon_commande_special'] as $B ) {
				$_REQUEST['CC']['auth_bypass'] = 1;
				journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$B , "INFO" , "Commande" , "INFO" );
				command_line ( $B ); 
				$_REQUEST['CC']['Compteur']++;
			}
			$_REQUEST['tampon_commande_special'] = array();			// 20180701 PHP 7.2.7 : réinitialisation de la variable en tant que tableau plutot qu'un string ou un nombre.

			$_REQUEST['manip_site_special'] = 0;
		}
		$_REQUEST['CC']['Compteur']++;
	}

	switch ( $_REQUEST['CC']['status'] ) {
	case "OK":		$T_SynResFicCom[$id_cmpt]['OK']++;		break;
	case "WARN":	$T_SynResFicCom[$id_cmpt]['WARN']++;	break;
	case "ERR":		$T_SynResFicCom[$id_cmpt]['ERR']++;		break;
	}

	if ( $_REQUEST['authorisation_moniteur'] == 1 ) {
		requete_sql ( $_REQUEST['sql_initiateur'], "UPDATE ".$SQL_tab_abrege['installation']." SET install_etat_nombre = '".$_REQUEST['CC']['Compteur']."' WHERE install_etat_nom = 'commande_nbr';" );
		requete_sql ( $_REQUEST['sql_initiateur'], "UPDATE ".$SQL_tab_abrege['installation']." SET install_etat_nombre = '".time()."' WHERE install_etat_nom = 'derniere_activite';" );
	}

	$tampon_commande_accumulateur[$pv['CC_tampon']] = $C;
	$pv['CC_tampon']++;	
}

requete_sql( $_REQUEST['sql_initiateur'], "FLUSH TABLES;" );


if ( $_REQUEST['contexte_d_execution'] == "Installation" ) { unset ( $tampon_commande_accumulateur ); }


?>
