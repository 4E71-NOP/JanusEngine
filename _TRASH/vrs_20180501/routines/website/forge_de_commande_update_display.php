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

$ptr = $_REQUEST['M_PRESNT'];

$pv['liste_colone1'] = array(
	"pres_ancre_dx10",
	"pres_ancre_dy10",
	"pres_ancre_dx20",
	"pres_ancre_dy20",
	"pres_ancre_dx30",
	"pres_ancre_dy30",
	"pres_module_ancre_e1a",	"pres_ancre_ex1a",	"pres_ancre_ey1a",
	"pres_module_ancre_e1b",	"pres_ancre_ex1b",	"pres_ancre_ey1b",
	"pres_module_ancre_e1c",	"pres_ancre_ex1c",	"pres_ancre_ey1c",
	"pres_module_ancre_e1d",	"pres_ancre_ex1d",	"pres_ancre_ey1d",
	"pres_module_ancre_e1e",	"pres_ancre_ex1e",	"pres_ancre_ey1e",

	"pres_module_ancre_e2a",	"pres_ancre_ex2a",	"pres_ancre_ey2a",
	"pres_module_ancre_e2b",	"pres_ancre_ex2b",	"pres_ancre_ey2b",
	"pres_module_ancre_e2c",	"pres_ancre_ex2c",	"pres_ancre_ey2c",
	"pres_module_ancre_e2d",	"pres_ancre_ex2d",	"pres_ancre_ey2d",
	"pres_module_ancre_e2e",	"pres_ancre_ex2e",	"pres_ancre_ey2e",

	"pres_module_ancre_e3a",	"pres_ancre_ex3a",	"pres_ancre_ey3a",
	"pres_module_ancre_e3b",	"pres_ancre_ex3b",	"pres_ancre_ey3b",
	"pres_module_ancre_e3c",	"pres_ancre_ex3c",	"pres_ancre_ey3c",
	"pres_module_ancre_e3d",	"pres_ancre_ex3d",	"pres_ancre_ey3d",
	"pres_module_ancre_e3e",	"pres_ancre_ex3e",	"pres_ancre_ey3e"
);

$pv['liste_colone2'] = array(
    "minimum_x",	"minimum_y",
    "pres_espacement_bord_haut",	"pres_espacement_bord_bas",
    "pres_espacement_bord_gauche",	"pres_espacement_bord_droite",
    "pres_dimenssion_x",			"pres_dimenssion_y"
);


foreach ( $ptr as $A1 ) {
	$tampon_commande_buffer[$ligne] = "update layout pres_cont_id \"".$A1['pres_cont_id']. "\"	\n";
	$tampon_commande_buffer[$ligne] .= "ligne = \"".$A1['nouvelordre']."\"	";

	reset ( $pv['liste_colone2'] );
	unset ( $A2 );
	foreach ( $pv['liste_colone2'] as $A2 ) { $tampon_commande_buffer[$ligne] .= $A2."	\"".$A1[$A2]."\"	"; }

	reset ( $pv['liste_colone1'] );
	unset ( $A2 );
	foreach ( $pv['liste_colone1'] as $A2 ) {
		if ( strlen( $A1[$A2] ) > 0 ) { $tampon_commande_buffer[$ligne] .= $A2."	\"".$A1[$A2]."\"	"; }
	}
	$ligne++;
}

/*
echo print_r_html ( $tampon_commande_buffer ) ;
echo print_r_html ( $_REQUEST[M_PRESNT][L61] ) ;
$tampon_commande_buffer[$ligne] = "update presentation name \"".$_REQUEST[MD][nom]. "\"	\n";
$tampon_commande_buffer[$ligne] .= "state		\"".$_REQUEST[MD][etat]. "\"	\n";
$tampon_commande_buffer[$ligne] .= "type		\"".$_REQUEST[MD][type]. "\"	\n";
$tampon_commande_buffer[$ligne] .= "directory	\"".$_REQUEST[MD][repertoire]. "\"	\n";
if ( strlen($_REQUEST[MM][titre]) > 0 )			{ $tampon_commande_buffer[$ligne] .= "title					\"".$_REQUEST[MM][titre]."\"	\n"; }
if ( strlen($_REQUEST[MM][fichier]) > 0 )		{ $tampon_commande_buffer[$ligne] .= "file					\"".$_REQUEST[MM][fichier]."\"	\n"; }
if ( strlen($_REQUEST[MM][desc]) > 0 )			{ $tampon_commande_buffer[$ligne] .= "desc 					\"".$_REQUEST[MM][desc]."\"	\n"; }

*/

?>
