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

//	memoire
// --------------------------------------------------------------------------------------------
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tl_['eng']['o1l11']	= "Variables";		$tl_['fra']['o1l11']	= "Variables";
$tl_['eng']['o1l12']	= "Size";			$tl_['fra']['o1l12']	= "Taille";

$pv['ligne'] = 1;
$AD[$pv['onglet']][$pv['ligne']]['1']['cont'] = $tl_[$l]['o1l11'];	$AD[$pv['onglet']]['1']['1']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";
$AD[$pv['onglet']][$pv['ligne']]['2']['cont'] = $tl_[$l]['o1l12'];	$AD[$pv['onglet']]['1']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";
$pv['ligne']++;

// --------------------------------------------------------------------------------------------
//
//	Fait le tour des variables pour les évaluer.
//	Suivant le mode choisi :
//		Cherche toutes les variables supérieures à une certaine taille.
//		Liste et affiche l'état des variables.
//
// --------------------------------------------------------------------------------------------
if ( $_REQUEST['ChasseurMemoire'] == 1 ) {
	function Check_all_variable ( &$data ) {
		global $AD, $pv, $CAV, $theme_tableau;

		unset ( $A , $B );
		foreach ( $data as $A => $B ) {
			$ERR = 0;
			foreach ( $pv['ListeExclusion'] as $C ) { if ( $A == $C ) { $ERR = 1; } }
			if ( $ERR == 0 ) {
				if ( is_array ( $B ) ) {
					if ( Taille_memoire_variable_brute ( $B ) > $_REQUEST['ChasseurMemoireLimite'] ) {
						$AD[$pv['onglet']][$pv['ligne']]['1']['cont'] = str_repeat ( $CAV['videgif']."|" , $CAV['profondeur'] ) . "-(" . $CAV['profondeur'] . ")-[" . $A . "]";
						$AD[$pv['onglet']][$pv['ligne']]['1']['style'] = "font-weight: bold;";
						$AD[$pv['onglet']][$pv['ligne']]['2']['cont'] = Taille_memoire_variable ( $B );
						$pv['ligne']++;
					}
					$CAV['profondeur']++;
					if ( $CAV['profondeur'] < $CAV['profondeur_max'] ) { Check_all_variable( $A ); }
					$CAV['profondeur']--;
				}
				else { 
					if ( Taille_memoire_variable_brute ( $B ) > $_REQUEST['ChasseurMemoireLimite'] ) {
						$AD[$pv['onglet']][$pv['ligne']]['1']['cont'] = str_repeat ( $CAV['videgif']."|" , $CAV['profondeur'] ) . "-(" . $CAV['profondeur'] . ")-" . $A;
						$AD[$pv['onglet']][$pv['ligne']]['2']['cont'] = Taille_memoire_variable ( $B );
						$pv['ligne']++;
					}
				}
			}
		}
	}
}

else {
	function Check_all_variable ( &$data ) {
		global $AD, $pv, $CAV, $theme_tableau;

		unset ( $A , $B );
		foreach ( $data as $A => $B ) {
			$ERR = 0;
			foreach ( $pv['ListeExclusion'] as $C ) { if ( $A == $C ) { $ERR = 1; } }
			if ( $ERR == 0 ) {
				if ( is_array ( $B ) ) {
					$AD[$pv['onglet']][$pv['ligne']]['1']['cont'] = str_repeat ( $CAV['videgif']."|" , $CAV['profondeur'] ) . "-(" . $CAV['profondeur'] . ")-[" . $A . "]";
					$AD[$pv['onglet']][$pv['ligne']]['1']['style'] = "font-weight: bold;";
					$AD[$pv['onglet']][$pv['ligne']]['2']['cont'] = Taille_memoire_variable ( $B );
					$pv['ligne']++;

					$CAV['profondeur']++;
					if ( $CAV['profondeur'] < $CAV['profondeur_max'] ) { Check_all_variable( $B ); }
					$CAV['profondeur']--;
				}
				else { 
					$AD[$pv['onglet']][$pv['ligne']]['1']['cont'] = str_repeat ( $CAV['videgif']."|" , $CAV['profondeur'] ) . "-(" . $CAV['profondeur'] . ")-" . $A;
					$AD[$pv['onglet']][$pv['ligne']]['2']['cont'] = Taille_memoire_variable ( $B );
					$pv['ligne']++;
				}
			}
		}
	}
}
// --------------------------------------------------------------------------------------------
// Le nombre de niveaux parcourus peut faire echouer PHP faute de mémoire suffisante. 
// 2 signifie 2+1 niveaux
// The number of parsed level can make PHP fail because of a lack of memory
// 2 means 2+1 levels.

//ini_set('memory_limit', '1024M' );

if ( $_REQUEST['contexte_d_execution'] == "Installation" ) { 
	$pv['ListeExclusion'] = array ( "GLOBALS",
	"langues", "site_web", "user", "theme_princ_", "pres_", "module_", 
	"JavaScriptFichier", "JavaScriptTabInfoModule", "JavaScriptInit", "JavaScriptInitDonnees", "JavaScriptInitCommandes", "JavaScriptOnload",
	"ListeExclusion" 
	);
}

//	"AD", "ADC", "Outil_debug", "SQL_requete", "langues", "site_web", "user", "theme_princ_", "pres_", "module_", "JavaScriptFichier", "JavaScriptTabInfoModule", "JavaScriptInit", "JavaScriptInitDonnees", "JavaScriptInitCommandes", "JavaScriptOnload",
else {
	$pv['ListeExclusion'] = array ( "GLOBALS",
	"ListeExclusion" 
	);
}

// Configuration du chasseur de mémoire.
/*
$_REQUEST['ChasseurMemoireLimite'] = 1024*16;
$CAV['profondeur_max'] = 5;
$pv['ListeExclusion'] = array ( "GLOBALS", "AD", "ADC", "Outil_debug", "SQL_requete" );
*/

// Configuration nominale
$CAV['profondeur_max'] = 1; //ATTENTION CELA DEVIENT VITE GOURMAND EN TEMPS MACHINE et mémoire!!!
if ( isset ( $CAV['profondeur_max_demande'] ) ) { $CAV['profondeur_max'] = $CAV['profondeur_max_demande']; }

$CAV['profondeur'] = 0;
$CAV['videgif'] = "<img src='../graph/".${$theme_tableau}['theme_repertoire']."/vide.gif' alt='' border='0'>\r";
$pv['ligne'] = 2;
reset ( $GLOBALS );
ksort ( $GLOBALS );
Check_all_variable ( $GLOBALS );
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['ligne'] ;
unset ( $A , $B );

// --------------------------------------------------------------------------------------------


?>
