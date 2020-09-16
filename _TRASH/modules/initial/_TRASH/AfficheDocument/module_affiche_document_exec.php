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
$pv['wm_start']	= 0;
$pv['wm_end']		= 0;
$pv['wm_cherche']	= "ON";
$pv['wm_mode']	= "NORMAL";

while ( $pv['wm_cherche'] == "ON" ) {																							/* C'est ON on boucle */
	$pv['wm_cherche'] = "OFF";																									/* Permet de sortir de la boucle si pas de ['WM'] trouvé */
	if ($pv['wm_mode'] == "NORMAL") {																							/* Le mode normal recherche le premier ['WM'] */
		$pv['wm_start'] = strpos ( ${$document_tableau}['docu_cont'] , "['WM']" , $pv['wm_start'] );							/* Donne la position du premier ['WM'] */
		if ( $pv['wm_start'] == false) {																						/* Verifie qu'on a trouvé ou pas la balise */
			if ( $pv['wm_end'] == 0 ) { 																						/* Deduit la presence de code dans tout le document */
				echo document_convertion ( ${$document_tableau}['docu_cont'] , ${$document_tableau}['arti_ref']."_p0".${$document_tableau}['docu_page'] );	/* S'il n'y a pas de code a executer on affiche directement le document */
				$pv['wm_fini'] = 1;
			}
			if ( $pv['wm_fini'] != 1 ) {
				$pv['docu_len'] = strlen (${$document_tableau}['docu_cont']);													/* C'est une fin de document ; Donne la longeur du document */
				$pv['docu_tmp_cont'] = substr( ${$document_tableau}['docu_cont'] , $pv['wm_end'] , $pv['docu_len'] - $pv['wm_end'] );	/* On a encore wm_end comme offset de depart ; on affiche */
				echo document_convertion ( $pv['docu_tmp_cont'] , ${$document_tableau}['arti_ref']."_p0".${$document_tableau}['docu_page'] );
				$pv['wm_cherche'] = "OFF";																						/* On sort de la */
			}
		}
		else {
			$pv['docu_tmp_cont'] = substr( ${$document_tableau}['docu_cont'] , $pv['wm_end'] , $pv['wm_start'] - $pv['wm_end'] );		/* Affiche ce qui est avant le code */
			echo document_convertion ( $pv['docu_tmp_cont'] , ${$document_tableau}['arti_ref']."_p0".${$document_tableau}['docu_page'] );
			$pv['wm_mode'] ="CODE";																								/* On switch pour executer le code */
			$pv['wm_cherche'] = "ON";																							/* On a trouvé une balise de ['WM'] On reste!!! */
		}
	}
	if ( $pv['wm_mode'] == "CODE" ) {
		$pv['wm_end'] = strpos ( ${$document_tableau}['docu_cont'] , "['/WM']" , $pv['wm_start'] );									/* Donne la position du premier ['/WM'] apres le ['WM'] */
		$pv['wm_cherche'] = "ON";																									/* Permet de continuer a parser le document */
		if ( $pv['wm_end'] == false ) {																								/* Affiche un message d'erreur si la balise de fin n'est pas trouvée */
			$pv['wm_cherche'] = "OFF";																								/* Permet de sortir de la boucle si pas de ['WM'] trouvé */
			echo ("<span class='skin_princ_".$_REQUEST['bloc']."_tb2 skin_princ_".$_REQUEST['bloc']."_avert' style='font-weight: bold'>ERREUR : ['/WM']/['WM']. STOP!</span>");
		}
		$pv['wm_code'] = substr( ${$document_tableau}['docu_cont'] , $pv['wm_start'] + 4 , $pv['wm_end'] - $pv['wm_start'] -4);	/* recopie le code */
		eval ($pv['wm_code']);																									/* Execute le segment de code */
		$pv['wm_end'] = $pv['wm_end'] +5;																						/* Positionne le end apres la balise de fin ['/WM'] */
		$pv['wm_start'] = $pv['wm_end'];																						/* Positionne le start apres la balise de fin ['/WM'] */
		$pv['wm_mode'] ="NORMAL";																								/* On bascule en mode NORMAL */
	}
}																																/* Sortie de boucle while */
?>
