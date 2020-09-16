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
$tampon_commande_buffer[$ligne] = "add theme name \"".$_REQUEST['M_THEME']['nom']. "\"	\n";

if ( isset($_REQUEST['M_THEME']['admctrl_position']) )			{ $tampon_commande_buffer[$ligne] .= "admctrl_position		\"".$_REQUEST['M_THEME']['admctrl_position']."\"	\n";}
if ( strlen($_REQUEST['M_THEME']['repertoire']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "directory				\"".$_REQUEST['M_THEME']['repertoire']."\"	\n"; }
//if ( strlen($_REQUEST['M_THEME']['nom']) > 0 )				{ $tampon_commande_buffer[$ligne] .= "name					\"".$_REQUEST['M_THEME']['nom']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['titre']) > 0 )				{ $tampon_commande_buffer[$ligne] .= "title					\"".$_REQUEST['M_THEME']['titre']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['desc']) > 0 )					{ $tampon_commande_buffer[$ligne] .= "description			\"".$_REQUEST['M_THEME']['desc']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['bg']) > 0 )					{ $tampon_commande_buffer[$ligne] .= "bg					\"".$_REQUEST['M_THEME']['bg']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['bg_repeat']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "bg_repeat				\"".$_REQUEST['M_THEME']['bg_repeat']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['bg_color']) > 0 )				{ $tampon_commande_buffer[$ligne] .= "bg_color				\"".$_REQUEST['M_THEME']['bg_color']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['blason']) > 0 )				{ $tampon_commande_buffer[$ligne] .= "blason				\"".$_REQUEST['M_THEME']['blason']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['admctrl_panel_bg']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "banniere				\"".$_REQUEST['M_THEME']['admctrl_panel_bg']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['admctrl_switch_bg']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "admctrl_switch_bg		\"".$_REQUEST['M_THEME']['admctrl_switch_bg']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['admctrl_size_x']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "admctrl_size_x		\"".$_REQUEST['M_THEME']['admctrl_size_x']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['admctrl_size_y']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "admctrl_size_y		\"".$_REQUEST['M_THEME']['admctrl_size_y']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['couleur_jauge_depart']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "couleur_jauge_depart	\"".$_REQUEST['M_THEME']['couleur_jauge_depart']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['couleur_jauge_milieu']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "couleur_jauge_milieu	\"".$_REQUEST['M_THEME']['couleur_jauge_milieu']."\"	\n"; }
if ( strlen($_REQUEST['M_THEME']['couleur_jauge_fin']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "couleur_jauge_fin		\"".$_REQUEST['M_THEME']['couleur_jauge_fin']."\"	\n"; }

for ( $pv['i'] = 1 ; $pv['i'] <= 30 ; $pv['i']++ ) {
	$pv['j'] = sprintf("%02u", $pv['i'] );
	if ( strlen( $_REQUEST['M_THEME']['theme_bloc_'.$pv['j'].'_nom'] ) > 0 )		{ $tampon_commande_buffer[$ligne] .= "theme_block_" . $pv['j'] . "_name		\"" . $_REQUEST['M_THEME']['theme_bloc_'.$pv['j'].'_nom']."\"	\n"; }
	if ( strlen( $_REQUEST['M_THEME']['theme_bloc_'.$pv['j'].'_texte'] ) > 0 )	{ $tampon_commande_buffer[$ligne] .= "theme_block_" . $pv['j'] . "_text		\"" . $_REQUEST['M_THEME']['theme_bloc_'.$pv['j'].'_texte']."\"	\n"; }
} 
for ( $pv['i'] = 0 ; $pv['i'] <= 9 ; $pv['i']++ ) {
	$pv['j'] = sprintf("%02u", $pv['i'] );
	if ( strlen ( $_REQUEST['M_THEME']['theme_bloc_'.$pv['i'].'_menu'] ) > 0 ) {
		$tampon_commande_buffer[$ligne] .= "theme_bloc_".$pv['j']."_menu		\"".$_REQUEST['M_THEME']['theme_bloc_'.$pv['j'].'_menu']."\"	\n";
	}
} 

?>
