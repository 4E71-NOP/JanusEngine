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
//	Test DB cnx
// --------------------------------------------------------------------------------------------
$debug = 0;

switch ( $debug ) {
	case 1:
		error_reporting(E_ERROR);
		ini_set('display_errors','On'); 
	break;
	default :
		error_reporting(0);
	break;
}

function statistique_checkpoint () { }

echo ("test : " . $_REQUEST['form']['choix'] );

switch ( $debug ) {
	case 1:		
	include_once ("../../routines/website/fonctions_universelles.php");
	echo ( "<br>" . print_r_html ( $db_ ) );
	echo ("<br>connect(".$db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $b4dbprefix . $db_['dbprefix'] .");" );
	break;
}

?>
