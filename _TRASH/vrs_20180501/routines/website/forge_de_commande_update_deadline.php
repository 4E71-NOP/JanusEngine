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
$tampon_commande_buffer[$ligne] = "update deadline name \"".$_REQUEST['M_BOUCLG']['nom']. "\"	\n";
if ( strlen($_REQUEST['M_BOUCLG']['titre']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "title		\"".$_REQUEST['M_BOUCLG']['titre']."\"	\n"; }
if ( isset($_REQUEST['M_BOUCLG']['etat']) )					{ $tampon_commande_buffer[$ligne] .= "state		\"".$_REQUEST['M_BOUCLG']['etat']."\"	\n";}
if ( strlen($_REQUEST['M_BOUCLG']['date_limite']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "limit		\"".$_REQUEST['M_BOUCLG']['date_limite']."\"	\n"; }
?>
