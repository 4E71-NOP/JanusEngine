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
$ligne++;
$tampon_commande_buffer[$ligne] = "add document name \"".$_REQUEST['M_DOCUME']['nom']. "\"	\n";
if ( isset($_REQUEST['M_DOCUME']['type']) )				{ $tampon_commande_buffer[$ligne] .= "type					\"".$_REQUEST['M_DOCUME']['type']."\"	\n";}

if ( strlen($_REQUEST['M_DOCUME_fichier']) > 0 ) { $_REQUEST['M_DOCUME']['fichier'] = $_REQUEST['M_DOCUME_fichier']; }
if ( isset($_REQUEST['M_DOCUME']['fichier']) ) {
	$ligne++;
	$tampon_commande_buffer[$ligne] = "insert_content		file \"".$_REQUEST['M_DOCUME']['fichier']."\"	to	\"".$_REQUEST['M_DOCUME']['nom']. "\"	\n";
}
$ligne++;
$tampon_commande_buffer[$ligne] = "share_document	name \"".$_REQUEST['M_DOCUME']['nom']."\"	with_site	\"".$site_web['sw_nom']. "\"	modification \"YES\" \n";

?>
