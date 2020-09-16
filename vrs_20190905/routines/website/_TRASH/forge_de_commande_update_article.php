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
$tampon_commande_buffer[$ligne] = "update article name \"".$_REQUEST['M_ARTICL']['nom']. "\"	\n";
if ( strlen($_REQUEST['M_ARTICL']['desc']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "desc			\"".$_REQUEST['M_ARTICL']['desc']."\"	\n"; }
if ( strlen($_REQUEST['M_ARTICL']['titre']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "title			\"".$_REQUEST['M_ARTICL']['titre']."\"	\n"; }
if ( strlen($_REQUEST['M_ARTICL']['sous_titre']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "sub_title		\"".$_REQUEST['M_ARTICL']['sous_titre']."\"	\n"; }
if ( isset($_REQUEST['M_ARTICL']['pres_nom_generique']) )	{ $tampon_commande_buffer[$ligne] .= "layout		\"".$_REQUEST['M_ARTICL']['pres_nom_generique']."\"	\n";}
if ( isset($_REQUEST['M_ARTICL']['config_id']) )			{ $tampon_commande_buffer[$ligne] .= "config		\"".$_REQUEST['M_ARTICL']['config_id']."\"	\n";}
if ( isset($_REQUEST['M_ARTICL']['bouclage']) )				{ $tampon_commande_buffer[$ligne] .= "deadline		\"".$_REQUEST['M_ARTICL']['bouclage']."\"	\n";}

if ( $_REQUEST['M_ARTICL']['validation_etat'] == 1 ) {
	$tampon_commande_buffer[$ligne] .= "validation_state	\"".$_REQUEST['M_ARTICL']['validation_etat']."\"	\n";
	$tampon_commande_buffer[$ligne] .= "validation_examiner	\"".$_REQUEST['M_ARTICL']['validation_validateur']."\"	\n";
	$tampon_commande_buffer[$ligne] .= "validation_date		\"".time()."\"	\n";
}

if ( $_REQUEST['M_ARTICL']['document'] == 1 )	{ 
	$ligne++;
	$tampon_commande_buffer[$ligne] .= "link article \"".$_REQUEST['M_ARTICL']['nom']. "\"	document	\"".$_REQUEST['M_ARTICL']['document']."\"	\n";
}
?>
