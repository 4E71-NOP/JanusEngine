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
function installation_log_rapport_fichier () {
	global $l, $T_SynResFicCom, $pv , $ADC , $AD, $theme_tableau;

	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 2;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 6;	$ADC['onglet'][$pv['onglet']]['legende'] = 6;
	$tl_['eng']['ils_01']	= "Directory";		$tl_['fra']['ils_01']	= "Repertoire";
	$tl_['eng']['ils_02']	= "File";			$tl_['fra']['ils_02']	= "Fichier";
	$tl_['eng']['ils_03']	= "OK(s)";			$tl_['fra']['ils_03']	= "OK(s)";
	$tl_['eng']['ils_04']	= "Warnings(s)";	$tl_['fra']['ils_04']	= "Avertissement(s)";
	$tl_['eng']['ils_05']	= "Errors(s)";		$tl_['fra']['ils_05']	= "Erreur(s)";
	$tl_['eng']['ils_06']	= "Time";			$tl_['fra']['ils_06']	= "Temps";

	$ligne = 1;
	$AD[$pv['onglet']][$ligne]['1']['cont'] = $tl_[$l]['ils_01'];	$AD[$pv['onglet']][$ligne]['1']['tc'] = 4;
	$AD[$pv['onglet']][$ligne]['2']['cont'] = $tl_[$l]['ils_02'];	$AD[$pv['onglet']][$ligne]['2']['tc'] = 4;
	$AD[$pv['onglet']][$ligne]['3']['cont'] = $tl_[$l]['ils_03'];	$AD[$pv['onglet']][$ligne]['3']['tc'] = 4;
	$AD[$pv['onglet']][$ligne]['4']['cont'] = $tl_[$l]['ils_04'];	$AD[$pv['onglet']][$ligne]['4']['tc'] = 4;
	$AD[$pv['onglet']][$ligne]['5']['cont'] = $tl_[$l]['ils_05'];	$AD[$pv['onglet']][$ligne]['5']['tc'] = 4;
	$AD[$pv['onglet']][$ligne]['6']['cont'] = $tl_[$l]['ils_06'];	$AD[$pv['onglet']][$ligne]['6']['tc'] = 4;
	$ligne++;

	$TOK	= 0;
	$TWARN	= 0;
	$TERR	= 0;

	foreach ( $T_SynResFicCom as $A ) {
		$AD[$pv['onglet']][$ligne]['1']['cont'] = $A['repertoire_en_cours'];		$AD[$pv['onglet']][$ligne]['1']['tc'] = 2;
		$AD[$pv['onglet']][$ligne]['2']['cont'] = $A['fichier'];					$AD[$pv['onglet']][$ligne]['2']['tc'] = 2;
		$AD[$pv['onglet']][$ligne]['3']['cont'] = $A['OK'];							$AD[$pv['onglet']][$ligne]['3']['tc'] = 2;		$AD[$pv['onglet']][$ligne]['3']['class'] = $theme_tableau.$_REQUEST['bloc']."_fade";
		$AD[$pv['onglet']][$ligne]['4']['cont'] = $A['WARN'];						$AD[$pv['onglet']][$ligne]['4']['tc'] = 2;		$AD[$pv['onglet']][$ligne]['4']['class'] = $theme_tableau.$_REQUEST['bloc']."_fade";
		if ( $A['WARN'] > 0 ) {	
			$AD[$pv['onglet']][$ligne]['4']['class'] = $theme_tableau.$_REQUEST['bloc']."_avert";
			$AD[$pv['onglet']][$ligne]['4']['style'] = "font-weight:bold;";
			$AD[$pv['onglet']][$ligne]['4']['tc'] = 4;
		}
		$AD[$pv['onglet']][$ligne]['5']['cont'] = $A['ERR'];						$AD[$pv['onglet']][$ligne]['5']['tc'] = 2;		$AD[$pv['onglet']][$ligne]['5']['class'] = $theme_tableau.$_REQUEST['bloc']."_fade";
		if ( $A['ERR'] > 0 ) { 
			$AD[$pv['onglet']][$ligne]['5']['class'] = $theme_tableau.$_REQUEST['bloc']."_erreur";
			$AD[$pv['onglet']][$ligne]['5']['style'] = "font-weight:bold;";
			$AD[$pv['onglet']][$ligne]['5']['tc'] = 4;
		}
		$AD[$pv['onglet']][$ligne]['6']['cont'] = round ( ($A['fin']-$A['debut']),3);	$AD[$pv['onglet']][$ligne]['6']['tc'] = 2;	$AD[$pv['onglet']][$ligne]['6']['class'] = $theme_tableau.$_REQUEST['bloc']."_fade";

		$TOK	+= $A['OK'];
		$TWARN	+= $A['WARN'];
		$TERR	+= $A['ERR'];
		$ADC['onglet'][$pv['onglet']]['nbr_ligne']++;
		$ligne++;
	}

	$AD[$pv['onglet']][$ligne]['3']['cont'] = $TOK;		$AD[$pv['onglet']][$ligne]['3']['tc'] = 5;	$AD[$pv['onglet']][$ligne]['3']['style'] = "font-weight:bold;";
	$AD[$pv['onglet']][$ligne]['4']['cont'] = $TWARN;	$AD[$pv['onglet']][$ligne]['4']['tc'] = 4;	$AD[$pv['onglet']][$ligne]['4']['style'] = "font-weight:bold;";
	$AD[$pv['onglet']][$ligne]['5']['cont'] = $TERR;	$AD[$pv['onglet']][$ligne]['5']['tc'] = 4;	$AD[$pv['onglet']][$ligne]['5']['style'] = "font-weight:bold;";

	if ( $TWARN != 0 )	{ $AD[$pv['onglet']][$ligne]['4']['class'] = $theme_tableau.$_REQUEST['bloc']."_avert";		$AD[$pv['onglet']][$ligne]['4']['tc'] = 6; }
	if ( $TERR != 0 )	{ $AD[$pv['onglet']][$ligne]['5']['class'] = $theme_tableau.$_REQUEST['bloc']."_erreur";	$AD[$pv['onglet']][$ligne]['5']['tc'] = 6; }
}

// --------------------------------------------------------------------------------------------
function installation_log_sql () {
	global $SQL_requete, $l, $pv , $ADC , $AD;
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 2;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 5;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

	$tl_['eng']['ils_01']	= "N";			$tl_['fra']['ils_01']	= "N";
	$tl_['eng']['ils_02']	= "Query";		$tl_['fra']['ils_02']	= "Requ&ecirc;te";
	$tl_['eng']['ils_03']	= "Signal";		$tl_['fra']['ils_03']	= "Signal";
	$tl_['eng']['ils_04']	= "Code";		$tl_['fra']['ils_04']	= "Code";
	$tl_['eng']['ils_05']	= "Message";	$tl_['fra']['ils_05']	= "Message";

	$ligne = 1;
	$AD[$pv['onglet']][$ligne]['1']['cont'] = $tl_[$l]['ils_01'];
	$AD[$pv['onglet']][$ligne]['2']['cont'] = $tl_[$l]['ils_02'];
	$AD[$pv['onglet']][$ligne]['3']['cont'] = $tl_[$l]['ils_03'];
	$AD[$pv['onglet']][$ligne]['4']['cont'] = $tl_[$l]['ils_04'];
	$AD[$pv['onglet']][$ligne]['5']['cont'] = $tl_[$l]['ils_05'];
	$ligne++;

	foreach ( $SQL_requete as $a ) {
		if ( isset ($a['signal']) ) {
			$B =  str_replace ( $db_['database_user_password'], "&lt; PASSWORD &gt;", $a['requete'] );
			$B =  htmlentities ( tronquage_expression ( $B , 128 ) , ENT_NOQUOTES );

			switch ($a['signal']) {
			case "OK":
				if ( $_REQUEST['debug_option']['SQL_debug_level'] > 2 ) {
					$AD[$pv['onglet']][$ligne]['1']['cont'] = $a['nbr'];
					$AD[$pv['onglet']][$ligne]['2']['cont'] = $a['nom'];
					$AD[$pv['onglet']][$ligne]['3']['cont'] = $B;
					$AD[$pv['onglet']][$ligne]['4']['cont'] = "-";
					$AD[$pv['onglet']][$ligne]['5']['cont'] = $a['err_msg'];
					$ligne++;
				}
			break;
			case "WARN":
				if ( $_REQUEST['debug_option']['SQL_debug_level'] > 1 ) {
					$AD[$pv['onglet']][$ligne]['1']['cont'] = $a['nbr'];
					$AD[$pv['onglet']][$ligne]['2']['cont'] = $a['nom'];
					$AD[$pv['onglet']][$ligne]['3']['cont'] = $B;
					$AD[$pv['onglet']][$ligne]['4']['cont'] = $a['err_no'];
					$AD[$pv['onglet']][$ligne]['5']['cont'] = $a['err_msg'];
					$ligne++;
				}
			break;
			case "ERR":
				if ( $_REQUEST['debug_option']['SQL_debug_level'] > 0 ) {
 					$AD[$pv['onglet']][$ligne]['1']['cont'] = $a['nbr'];
					$AD[$pv['onglet']][$ligne]['2']['cont'] = $a['nom'];
					$AD[$pv['onglet']][$ligne]['3']['cont'] = $B;
					$AD[$pv['onglet']][$ligne]['4']['cont'] = $a['err_no'];
					$AD[$pv['onglet']][$ligne]['5']['cont'] = $a['err_msg'];
					$ligne++;
				}
			break;
			}
			$AD[$pv['onglet']][$ligne]['1']['tc'] = 2;
			$AD[$pv['onglet']][$ligne]['2']['tc'] = 1;
			$AD[$pv['onglet']][$ligne]['3']['tc'] = 2;
			$AD[$pv['onglet']][$ligne]['4']['tc'] = 2;
			$AD[$pv['onglet']][$ligne]['5']['tc'] = 1;
		}
	}
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = ( $ligne -1 );
}

// --------------------------------------------------------------------------------------------
function installation_log_manipulation () {
	global $l, $pv , $ADC , $AD;
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 2;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 6;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

	$tl_['eng']['ils_01']	= "ID";			$tl_['fra']['ils_01']	= "ID";
	$tl_['eng']['ils_02']	= "Section";	$tl_['fra']['ils_02']	= "Section";
	$tl_['eng']['ils_03']	= "Command";	$tl_['fra']['ils_03']	= "Commande";
	$tl_['eng']['ils_04']	= "Signal";		$tl_['fra']['ils_04']	= "Signal";
	$tl_['eng']['ils_05']	= "Code";		$tl_['fra']['ils_05']	= "Code";
	$tl_['eng']['ils_06']	= "Message";	$tl_['fra']['ils_06']	= "Message";

	$ligne = 1;
	$AD[$pv['onglet']][$ligne]['1']['cont'] = $tl_[$l]['ils_01'];
	$AD[$pv['onglet']][$ligne]['2']['cont'] = $tl_[$l]['ils_02'];
	$AD[$pv['onglet']][$ligne]['3']['cont'] = $tl_[$l]['ils_03'];
	$AD[$pv['onglet']][$ligne]['4']['cont'] = $tl_[$l]['ils_04'];
	$AD[$pv['onglet']][$ligne]['5']['cont'] = $tl_[$l]['ils_05'];
	$AD[$pv['onglet']][$ligne]['6']['cont'] = $tl_[$l]['ils_06'];
	$ligne++;

	foreach ( $_REQUEST['manipulation_result'] as $a ) {
		if ( isset ($a['signal']) ) {
			$B = tronquage_expression ( $a['action'] , 128 );
			switch ( $a['signal'] ) {
			case "OK":
				if ( $_REQUEST['form']['console_detail_log_ok'] == "on" ) {
					$AD[$pv['onglet']][$ligne]['1']['cont'] = $a['nbr'];
					$AD[$pv['onglet']][$ligne]['2']['cont'] = $a['nom'];
					$AD[$pv['onglet']][$ligne]['3']['cont'] = $B;
					$AD[$pv['onglet']][$ligne]['4']['cont'] = $a['signal'];
					$AD[$pv['onglet']][$ligne]['5']['cont'] = $a['msgid'];
					$AD[$pv['onglet']][$ligne]['6']['cont'] = $a['msg'];
				}
			break;
			case "WARN":
				if ( $_REQUEST['form']['console_detail_log_warn'] == "on" ) {
					$AD[$pv['onglet']][$ligne]['1']['cont'] = $a['nbr'];
					$AD[$pv['onglet']][$ligne]['2']['cont'] = $a['nom'];
					$AD[$pv['onglet']][$ligne]['3']['cont'] = $B;
					$AD[$pv['onglet']][$ligne]['4']['cont'] = $a['signal'];
					$AD[$pv['onglet']][$ligne]['5']['cont'] = $a['msgid'];
					$AD[$pv['onglet']][$ligne]['6']['cont'] = $a['msg'];
				}
			break;
			case "ERR":
				if ( $_REQUEST['form']['console_detail_log_err'] == "on" ) {
					$AD[$pv['onglet']][$ligne]['1']['cont'] = $a['nbr'];
					$AD[$pv['onglet']][$ligne]['2']['cont'] = $a['nom'];
					$AD[$pv['onglet']][$ligne]['3']['cont'] = $B;
					$AD[$pv['onglet']][$ligne]['4']['cont'] = $a['signal'];
					$AD[$pv['onglet']][$ligne]['5']['cont'] = $a['msgid'];
					$AD[$pv['onglet']][$ligne]['6']['cont'] = $a['msg'];
				}
			break;
			}
			$AD[$pv['onglet']][$ligne]['1']['tc'] = 2;
			$AD[$pv['onglet']][$ligne]['2']['tc'] = 2;
			$AD[$pv['onglet']][$ligne]['3']['tc'] = 1;
			$AD[$pv['onglet']][$ligne]['4']['tc'] = 2;
			$AD[$pv['onglet']][$ligne]['5']['tc'] = 2;
			$AD[$pv['onglet']][$ligne]['6']['tc'] = 1;
			$ligne++;
		}
	}
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = ( $ligne -1 );
}

// --------------------------------------------------------------------------------------------
function affiche_etat_table ($tableau_aet, $sql_aet) {
	global $module_, $skin_AI_;
	echo ("
	<table ".${$theme_tableau}['tab_std_rules']." width='".($skin_AI_['tab_interieur']-16)."'>\r
	<tr>\r
	");
	foreach ( $tableau_aet['titre'] as $A => $B ) {
		echo ("<td  class='" . $theme_tableau .$_REQUEST['bloc']."_fcc ".$theme_tableau.$_REQUEST['bloc']."_t1'>".$B."</td>\r");
	}
	echo ("</tr>\r");
	unset ( $A , $B );

	$dbquery = requete_sql($sql_aet['initiateur'] , $sql_aet['requete'] );
	while ($dbp = fetch_array_sql($dbquery)) {
		echo ("<tr>\r");
		reset ($tableau_aet['titre']);
		foreach ( $tableau_aet['titre'] as $A => $B ) {
			echo ("<td  class='" . $theme_tableau .$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t1'>".$dbp[$B]."</td>\r");
		}
		unset ( $A , $B );
		echo ("</tr>\r");
	}
	echo ("
	</table>\r
	<br>\r
	<br>\r
	");
}

?>
