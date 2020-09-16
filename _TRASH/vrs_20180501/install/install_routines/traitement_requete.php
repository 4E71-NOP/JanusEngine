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

unset ( $C );
$pv['TAC'] = array();
$pv['TR'] = "";
foreach ( $requete_insert as $L => $C ) { $pv['TR'] .= $C; }

$pv['tab_rch'] = array ( "!table!",					"!IdxNom!",			"\n",	"	",	"*/",	chr(13) );	//
$pv['tab_rpl'] = array ( "`".$dbprefix_table."`",	$dbprefix_table,	"",		" ",	"*/\n",	" " );		// "`" est utilisé pour le fichier "tl_--.sql" Le nom de table doit être encadré.
$pv['TR'] = str_replace ($pv['tab_rch'],$pv['tab_rpl'],$pv['TR']);
unset ( $pv['tab_rch'], $pv['tab_rch'], $pv['requete_finale'] );

cartographie_expression ( "//" , 1 , 99999 , $pv['TR'] , $pv['TAC'] );
cartographie_expression ( "\n" , 2 , 99998 , $pv['TR'] , $pv['TAC'] );
cartographie_expression ( "/*" , 3 , 99997 , $pv['TR'] , $pv['TAC'] );
cartographie_expression ( "*/" , 4 , 99996 , $pv['TR'] , $pv['TAC'] );
cartographie_expression ( "'"  , 5 , 99995 , $pv['TR'] , $pv['TAC'] );
cartographie_expression ( "\"" , 6 , 99994 , $pv['TR'] , $pv['TAC'] );
cartographie_expression ( ";"  , 7 , 99993 , $pv['TR'] , $pv['TAC'] );

ksort ($pv['TAC']);
reset ($pv['TAC']);
$pv['$tampon_commande_rendu_idx'] = 0;
$pv['TRR'] = array();
formattage_commande ( $pv['TAC'] , $pv['TR'] , $pv['TRR']  );

unset ( $C );
foreach ( $pv['TRR'] as $C ) {
	if ( !isset($C['Ordre']) ) { 
		$_REQUEST['sql_initiateur'] = $tl_[$l]['p3_tr01'] . $repertoire_en_cours."/".$section."/".$val;
		journalisation_evenement ( 2 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$C['cont'] , "INFO" , "Requete" , "INFO" );
		manipulation_traitement_requete ( $C['cont'].";" );

		$_REQUEST['moniteur']['SQL_requete_nbr']++;

		$SQL_index = $SQL_requete['nbr'] - 1;
		switch ( $SQL_requete[$SQL_index]['signal'] ) {
			case "OK":		$T_SynResFicCom[$id_cmpt]['OK']++;		break;
			case "WARN":	$T_SynResFicCom[$id_cmpt]['WARN']++;	break;
			case "ERR":		$T_SynResFicCom[$id_cmpt]['ERR']++;		break;
		}
		//$requete_num++;			//??? apparement inutile.
	}
}

?>
