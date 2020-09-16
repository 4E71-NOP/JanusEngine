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
$tampon_commande_buffer[$ligne] = "add tag name \"".$_REQUEST['M_TAG']['nom']. "\"	\n";
if ( strlen($_REQUEST['M_TAG']['html']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "html					\"".$_REQUEST['M_TAG']['html']."\"	\n"; }

?>
