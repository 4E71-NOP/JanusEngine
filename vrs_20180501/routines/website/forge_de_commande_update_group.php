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
$tampon_commande_buffer[$ligne] = "update group name \"".$_REQUEST['M_GROUPE']['nom']. "\"	\n";
if ( strlen($_REQUEST['M_GROUPE']['parent']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "parent	\"".$_REQUEST['M_GROUPE']['parent']."\"	\n";}
if ( isset($_REQUEST['M_GROUPE']['titre']) )			{ $tampon_commande_buffer[$ligne] .= "title		\"".$_REQUEST['M_GROUPE']['titre']."\"	\n";}
if ( isset($_REQUEST['M_GROUPE']['tag']) )				{ $tampon_commande_buffer[$ligne] .= "tag		\"".$_REQUEST['M_GROUPE']['tag']."\"	\n";}
if ( strlen($_REQUEST['M_GROUPE']['fichier']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "file		\"".$_REQUEST['M_GROUPE']['fichier']."\"	\n"; }
if ( strlen($_REQUEST['M_GROUPE']['desc']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "desc		\"".$_REQUEST['M_GROUPE']['desc']."\"	\n"; }
?>
