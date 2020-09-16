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
$tampon_commande_buffer[$ligne] = "add keyword name \"".$_REQUEST['M_MOTCLE']['nom']. "\"	\n";
if ( isset($_REQUEST['M_MOTCLE']['article']) )			{ $tampon_commande_buffer[$ligne] .= "article	\"".$_REQUEST['M_MOTCLE']['article']."\"		\n";}
if ( isset($_REQUEST['M_MOTCLE']['chaine']) )			{ $tampon_commande_buffer[$ligne] .= "string	\"".$_REQUEST['M_MOTCLE']['chaine']."\"		\n";}
if ( isset($_REQUEST['M_MOTCLE']['compteur']) )			{ $tampon_commande_buffer[$ligne] .= "compteur	\"".$_REQUEST['M_MOTCLE']['compteur']."\"	\n";}
if ( isset($_REQUEST['M_MOTCLE']['type']) )				{ $tampon_commande_buffer[$ligne] .= "type		\"".$_REQUEST['M_MOTCLE']['type']."\"		\n";}
if ( isset($_REQUEST['M_MOTCLE']['donnee']) )			{ $tampon_commande_buffer[$ligne] .= "data		\"".$_REQUEST['M_MOTCLE']['donnee']."\"		\n";}

?>
