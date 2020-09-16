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
$tampon_commande_buffer[$ligne] = "update module name \"".$_REQUEST['M_MODULE']['nom']. "\"	\n";
if ( strlen($_REQUEST['M_MODULE']['titre']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "title					\"".$_REQUEST['M_MODULE']['titre']."\"	\n"; }
if ( strlen($_REQUEST['M_MODULE']['fichier']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "file					\"".$_REQUEST['M_MODULE']['fichier']."\"	\n"; }
if ( strlen($_REQUEST['M_MODULE']['desc']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "desc 					\"".$_REQUEST['M_MODULE']['desc']."\"	\n"; }

if ( isset($_REQUEST['M_MODULE']['groupe_pour_voir']) )		{ $tampon_commande_buffer[$ligne] .= "group_who_can_see		\"".$_REQUEST['M_MODULE']['groupe_pour_voir']."\"	\n";}
if ( isset($_REQUEST['M_MODULE']['groupe_pour_utiliser']) )	{ $tampon_commande_buffer[$ligne] .= "group_who_can_use		\"".$_REQUEST['M_MODULE']['groupe_pour_utiliser']."\"	\n";}
if ( isset($_REQUEST['M_MODULE']['deco']) )					{ $tampon_commande_buffer[$ligne] .= "deco					\"".$_REQUEST['M_MODULE']['deco']."\"	\n";}
if ( isset($_REQUEST['M_MODULE']['deco_nbr']) )				{ $tampon_commande_buffer[$ligne] .= "deco_nbr				\"".$_REQUEST['M_MODULE']['deco_nbr']."\"	\n";}
if ( isset($_REQUEST['M_MODULE']['deco_txt_defaut']) )		{ $tampon_commande_buffer[$ligne] .= "deco_txt_defaut		\"".$_REQUEST['M_MODULE']['deco_txt_defaut']."\"	\n";}
if ( isset($_REQUEST['M_MODULE']['position']) )				{ $tampon_commande_buffer[$ligne] .= "position				\"".$_REQUEST['M_MODULE']['position']."\"	\n";}
if ( isset($_REQUEST['M_MODULE']['module_adm_control']) )	{ $tampon_commande_buffer[$ligne] .= "module_adm_control	\"".$_REQUEST['M_MODULE']['module_adm_control']."\"	\n";}
if ( isset($_REQUEST['M_MODULE']['etat']) )					{ $tampon_commande_buffer[$ligne] .= "state					\"".$_REQUEST['M_MODULE']['etat']."\"	\n";}
if ( isset($_REQUEST['M_MODULE']['module_execution']) )		{ $tampon_commande_buffer[$ligne] .= "execution				\"".$_REQUEST['M_MODULE']['module_execution']."\"	\n";}
?>
