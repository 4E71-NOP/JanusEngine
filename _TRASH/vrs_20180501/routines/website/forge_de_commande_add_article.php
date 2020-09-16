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
$tampon_commande_buffer[$ligne] = "add article name \"".$_REQUEST['M_ARTICL']['nom']. "\"	\n";
if ( isset($_REQUEST['M_ARTICL']['reference']) )			{ $tampon_commande_buffer[$ligne] .= "reference		\"".$_REQUEST['M_ARTICL']['reference']."\"	\n";}
if ( isset($_REQUEST['M_ARTICL']['bouclage']) )				{ $tampon_commande_buffer[$ligne] .= "deadline		\"".$_REQUEST['M_ARTICL']['bouclage']."\"	\n";}
if ( strlen($_REQUEST['M_ARTICL']['desc']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "desc			\"".$_REQUEST['M_ARTICL']['desc']."\"	\n"; }
if ( strlen($_REQUEST['M_ARTICL']['titre']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "title			\"".$_REQUEST['M_ARTICL']['titre']."\"	\n"; }
if ( strlen($_REQUEST['M_ARTICL']['sous_titre']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "sub_title		\"".$_REQUEST['M_ARTICL']['sous_titre']."\"	\n"; }
if ( isset($_REQUEST['M_ARTICL']['page']) )					{ $tampon_commande_buffer[$ligne] .= "page			\"".$_REQUEST['M_ARTICL']['page']."\"	\n";}
if ( isset($_REQUEST['M_ARTICL']['config_id']) )			{ $tampon_commande_buffer[$ligne] .= "config		\"".$_REQUEST['M_ARTICL']['config_id']."\"	\n";}
if ( isset($_REQUEST['M_ARTICL']['presentation']) )			{ $tampon_commande_buffer[$ligne] .= "display		\"".$_REQUEST['M_ARTICL']['presentation']."\"	\n";}

if ( isset($_REQUEST['M_ARTICL']['document']) )	{ 
	$ligne++;
	$tampon_commande_buffer[$ligne] .= "link article \"".$_REQUEST['M_ARTICL']['nom']. "\"	document	\"".$_REQUEST['M_ARTICL']['document']."\"	\n";
}
?>
