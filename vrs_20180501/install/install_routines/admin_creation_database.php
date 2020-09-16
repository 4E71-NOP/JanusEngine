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
$_REQUEST['manipulation_result']['nbr'] = 1 ;

unset ( $A );
foreach ( $_REQUEST['liste_repertoire_a_scanner'] as $A ) {
	$repertoire_en_cours = $A['nom_repertoire'];
	$repertoire_liste_fichier = array();
	$handle = opendir( $chemin.$repertoire_en_cours."/".$section."/" );
	if ( $A['etat'] == on ) {
		while (false !== ($file = readdir($handle))) {
			$pv['acd_ERR'] = 0;
			if ( $file == "." || $file == ".." ) { $pv['acd_ERR'] = 1; }
			if ( strpos($file, ".save" ) != FALSE ) { $pv['acd_ERR'] = 1; }
			if ( strpos($file, "*.*~" ) != FALSE ) { $pv['acd_ERR'] = 1; }
			if ( $pv['acd_ERR'] == 0 ) { $repertoire_liste_fichier[] = $file; }
		}
		closedir($handle);
		sort ($repertoire_liste_fichier);
		reset ($repertoire_liste_fichier);
	}
	unset ($handle);

// --------------------------------------------------------------------------------------------
//	Evaluation du fichier
	foreach ( $repertoire_liste_fichier as $key => $val ) {
		$id_cmpt = "a" . $c_SRF;
		$file_stat = stat( $chemin.$repertoire_en_cours."/".$section."/".$val );

// --------------------------------------------------------------------------------------------
//		Parcoure le fichier et execute la requete trouvée
		unset ( $requete_insert );
		$requete_insert = file( $chemin.$repertoire_en_cours."/".$section."/".$val );

		$CC_result['nbr'] = 1;
//		$requete_num = 1;

		$T_SynResFicCom[$id_cmpt]['repertoire_en_cours'] = $repertoire_en_cours;
		$T_SynResFicCom[$id_cmpt]['fichier'] = $val;
		$T_SynResFicCom[$id_cmpt]['OK'] = 0;
		$T_SynResFicCom[$id_cmpt]['WARN'] = 0;
		$T_SynResFicCom[$id_cmpt]['ERR'] = 0;
		$T_SynResFicCom[$id_cmpt]['debut'] = microtime_chrono();

		switch ( $methode ) {
		case "filename":
			$T_SynResFicCom[$id_cmpt]['mode'] = "filename";
			$T_SynResFicCom[$id_cmpt]['date'] = strftime ("%a %d %b %y - %H:%M", $file_stat['mtime']);
			$dbprefix_table = $db_['tabprefix'] . $val;
			$dbprefix_table = str_replace(".sql" , "" , $dbprefix_table );
			include ("install/install_routines/traitement_requete.php");
			requete_sql( $_REQUEST['sql_initiateur'], "FLUSH TABLES;" );
		break;
		case "table_nomee":
			$T_SynResFicCom[$id_cmpt]['mode'] = "table_nomee";
			$dbprefix_table = $db_['tabprefix'] . $table_destination_nom;
			include ("install/install_routines/traitement_requete.php");
			requete_sql( $_REQUEST['sql_initiateur'], "FLUSH TABLES;" );
		break;
		case "console de commandes":
			$T_SynResFicCom[$id_cmpt]['mode'] = "console de commandes";
			include ("install/install_routines/traitement_commande.php");
		break;
		}

// --------------------------------------------------------------------------------------------
//	Affiche la description de la table
		switch ($methode) {
		case "filename":
		case "table_nomee":				$result_message_type = "db";		break;
		case "console de commandes":	$result_message_type = "cc";		break;
		}

		$admin_msg['p3_resultat_catchy'] = "<span class='skin_princ_s0".$module_['module_deco_nbr']."_t1'>".$tl_[$l]['p3_resultat_catchy_ok'][$result_message_type];
		if ( $execution_resume['WARN'] != 0 ) { $admin_msg['p3_resultat_catchy'] = "<span class='skin_princ_s0".$module_['module_deco_nbr']."_avert2'>".$tl_[$l]['p3_resultat_catchy_warn'][$result_message_type]; }
		if ( $execution_resume['ERR'] != 0 ) { $admin_msg['p3_resultat_catchy'] = "<span class='skin_princ_s0".$module_['module_deco_nbr']."_erreur3'>".$tl_[$l]['p3_resultat_catchy_err'][$result_message_type]; }
		$c_SRF++;
		$T_SynResFicCom[$id_cmpt]['fin'] = microtime_chrono();

	}
}
?>
