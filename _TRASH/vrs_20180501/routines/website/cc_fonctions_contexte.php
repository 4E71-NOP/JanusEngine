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
function initialisation_valeurs_contexte () {
	$R = &$_REQUEST['SC'];

	$R['site']			= "";
	$R['utilisateur']	= "";
	$R['mot_de_passe']	= "";

	$R['website']		= &$R['site'];
	$R['user']			= &$R['utilisateur'];
	$R['password']		= &$R['mot_de_passe'];

}
?>
