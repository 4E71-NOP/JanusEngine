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
$tampon_commande_buffer[$ligne] = "update category name \"".$_REQUEST['M_CATEGO']['nom']. "\"	\n";
if ( strlen($_REQUEST['M_CATEGO']['titre']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "title		\"".$_REQUEST['M_CATEGO']['titre']."\"	\n"; }
if ( strlen($_REQUEST['M_CATEGO']['desc']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "desc		\"".$_REQUEST['M_CATEGO']['desc']."\"	\n"; }
if ( isset($_REQUEST['M_CATEGO']['type']) )				{ $tampon_commande_buffer[$ligne] .= "type		\"".$_REQUEST['M_CATEGO']['type']."\"	\n";}
if ( isset($_REQUEST['M_CATEGO']['site_id']) )			{ $tampon_commande_buffer[$ligne] .= "site		\"".$_REQUEST['M_CATEGO']['site_d']."\"	\n";}
if ( isset($_REQUEST['M_CATEGO']['lang']) )				{ $tampon_commande_buffer[$ligne] .= "lang		\"".$_REQUEST['M_CATEGO']['lang']."\"	\n";}
if ( isset($_REQUEST['M_CATEGO']['bouclage_id']) )		{ $tampon_commande_buffer[$ligne] .= "deadline	\"".$_REQUEST['M_CATEGO']['bouclage_id']."\"	\n";}
if ( isset($_REQUEST['M_CATEGO']['etat']) )				{ $tampon_commande_buffer[$ligne] .= "state		\"".$_REQUEST['M_CATEGO']['etat']."\"	\n";}
if ( isset($_REQUEST['M_CATEGO']['form_parent']) )		{ $tampon_commande_buffer[$ligne] .= "parent	\"".$_REQUEST['M_CATEGO']['form_parent']."\"	\n";}
if ( isset($_REQUEST['M_CATEGO']['position']) )			{ $tampon_commande_buffer[$ligne] .= "position	\"".$_REQUEST['M_CATEGO']['position']."\"	\n";}
if ( isset($_REQUEST['M_CATEGO']['groupe_id']) )		{ $tampon_commande_buffer[$ligne] .= "group		\"".$_REQUEST['M_CATEGO']['groupe_id']."\"	\n";}
if ( isset($_REQUEST['M_CATEGO']['doc_premier']) )		{ $tampon_commande_buffer[$ligne] .= "first_doc	\"".$_REQUEST['M_CATEGO']['doc_premier']."\"	\n";}
if ( strlen($_REQUEST['M_CATEGO']['arti_ref']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "article	\"".$_REQUEST['M_CATEGO']['arti_ref']."\"	\n"; }
?>
