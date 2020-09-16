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
/*
$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];

$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 3;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 1		// Comportement des onglets
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1;	// 1:ligne, 2:cellule
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "gdb_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");
*/

// --------------------------------------------------------------------------------------------
$_REQUEST['sql_initiateur'] = "affichage_donnees.php";
$NumL = $NumLangues_[$WebSiteObj->getWebSiteEntry('sw_lang')];

$pv['rendu'] = "";

if ( $tab_infos['NbrOnglet'] == 0 ) { $tab_infos['NbrOnglet'] = 1; }
if ( $tab_infos['AffOnglet'] != 0 ) {
	if ( !function_exists("genere_onglet_html") ) {
		$JavaScriptFichier[] = "routines/website/javascript_onglet.js";
		$GeneratedJavaScriptObj->insertJavaScript('File', "routines/website/javascript_onglet.js");
		include ("routines/website/decoration_onglet.php");
	}
	$pv['rendu'] = genere_onglet_html ();
}

// --------------------------------------------------------------------------------------------
//
//	Preparation des styles
//
// --------------------------------------------------------------------------------------------
// $NumO = Num Onglet
// $NumL = Num Ligne
// $NumC = Num Cellule

for ( $NumO = 1 ; $NumO <= $tab_infos['NbrOnglet'] ; $NumO++ ) {
	switch ( $ADC['onglet'][$NumO]['legende'] ) {
	case 1: // top
		for ( $NumC = 1 ; $NumC <= $ADC['onglet'][$NumO]['nbr_cellule'] ; $NumC++ ) { $AD[$NumO]['1'][$NumC]['cc'] = 1; }
	break;
	case 2: // left
		for ( $NumL = 1 ; $NumL <= $ADC['onglet'][$NumO]['nbr_ligne'] ; $NumL++ ) { $AD[$NumO][$NumL]['1']['cc'] = 1; }
	break;
	case 3: // right
		$pv['PF_cellule_titre'] = $ADC['onglet'][$NumO]['nbr_cellule'];
		for ( $NumL = 1 ; $NumL <= $ADC['onglet'][$NumO]['nbr_ligne'] ; $NumL++ ) { $AD[$NumO][$NumL][$pv['PF_cellule_titre']]['cc'] = 1; }
	break;
	case 4: // bottom
		$pv['PF_ligne_titre'] = $ADC['onglet'][$NumO]['nbr_ligne'];
		for ( $NumC = 1 ; $NumC <= $ADC['onglet'][$NumO]['nbr_cellule'] ; $NumC++ ) { $AD[$NumO][$pv['PF_ligne_titre']][$NumC]['cc'] = 1; }
	break;
	case 5: // left&right
		for ( $NumL = 1 ; $NumL <= $ADC['onglet'][$NumO]['nbr_ligne'] ; $NumL++ ) { $AD[$NumO][$NumL]['1']['cc'] = 1; }
		$pv['PF_cellule_titre'] = $ADC['onglet'][$NumO]['nbr_cellule'];
		for ( $NumL = 1 ; $NumL <= $ADC['onglet'][$NumO]['nbr_ligne'] ; $NumL++ ) { $AD[$NumO][$NumL][$pv['PF_cellule_titre']]['cc'] = 1; }
	break;
	case 6: // top&bottom
		for ( $NumC = 1 ; $NumC <= $ADC['onglet'][$NumO]['nbr_cellule'] ; $NumC++ ) { $AD[$NumO]['1'][$NumC]['cc'] = 1; }
		$pv['PF_ligne_titre'] = $ADC['onglet'][$NumO]['nbr_ligne'];
		for ( $NumC = 1 ; $NumC <= $ADC['onglet'][$NumO]['nbr_cellule'] ; $NumC++ ) { $AD[$NumO][$pv['PF_ligne_titre']][$NumC]['cc'] = 1; }
	break;
	}
}
//outil_debug ( $AD , "affichage_donnees.php<br>\$AD" );
// --------------------------------------------------------------------------------------------
//	Affichage
if ( $tab_infos['AffOnglet'] != 0 ) {
	$pv['doc_height'] = ($tab_infos['doc_height'] > 0) ? "height:".$tab_infos['doc_height']."px; " : "height:auto; ";
	$pv['rendu'] .= "<div id='AD_".$tab_infos['groupe']."_".$tab_infos['document']."' class='".$theme_tableau.$_REQUEST['bloc']."_fco' style='position:relative; overflow:hidden; width:".($tab_infos['doc_width']-10) ."px; ".$pv['doc_height']."' >\r"; // overflow:hidden;
}

$pv['Blc'] = $theme_tableau.$_REQUEST['bloc'];

$pv['Tab_class']['0'] = $pv['Blc']."_fca";
$pv['Tab_class']['1'] = $pv['Blc']."_fcb";
$pv['Tab_class']['2'] = $pv['Blc']."_fcc";
$pv['Tab_class']['3'] = $pv['Blc']."_fcd";

$pv['Tab_class']['4'] = $pv['Blc']."_fcsa";
$pv['Tab_class']['5'] = $pv['Blc']."_fcsb";
$pv['Tab_class']['6'] = $pv['Blc']."_fcsa";
$pv['Tab_class']['7'] = $pv['Blc']."_fcsb";

$pv['Tab_class']['8'] = $pv['Blc']."_fcta";
$pv['Tab_class']['9'] = $pv['Blc']."_fctb";
$pv['Tab_class']['10'] = $pv['Blc']."_fcta";
$pv['Tab_class']['11'] = $pv['Blc']."_fctb";


$pv['WidthTable'] = ($tab_infos['doc_width']-32);
$pv['visibility'] = "visible";
for ( $NumO = 1 ; $NumO <= $tab_infos['NbrOnglet'] ; $NumO++ ) {
	if ( $NumO > 1 ) { $pv['visibility'] = "hidden"; }
	if ( $tab_infos['AffOnglet'] != 0 ) {
		$pv['rendu'] .= "<div id='".$tab_infos['groupe']."_".$tab_infos['document'].$NumO."' style='position:absolute; visibility:".$pv['visibility']."; width:".( $tab_infos['doc_width']-16)."px; ".$pv['doc_height']." overflow:auto;'>\r"; // position:absolute; 
	}

	unset ($A);
	$pv['i'] = 0;
	if ( isset($ADC['onglet'][$NumO]['colswidth']) ) {
		$pv['ListeColWidth'] = "<colgroup>\r";
		foreach ( $ADC['onglet'][$NumO]['colswidth'] as $A ) { 
			$pv['ListeColWidth'] .= "<col span='".$pv['i']."' style='width:".floor( $pv['WidthTable'] * $A )."px;'>\r"; 
			$pv['i']++;
		}
		$pv['ListeColWidth'] .= "</colgroup>\r";
		if ( $pv['i'] == 0 ) { $pv['ListeColWidth'] =""; }
	}

	if ( $ADC['onglet'][$NumO]['nbr_ligne'] != 0 ) {
		$pv['rendu'] .= "<table class='".$pv['Blc']."_t3' style='width:".$pv['WidthTable']."px; empty-cells: show; vertical-align: top; border-spacing: 1px;'>\r" . $pv['ListeColWidth']; //table-layout: fixed; overflow:hidden; 

		if ( isset($AD[$NumO]['caption']['cont']) ) { 
			$pv['ForgeCaptionClass'] = $pv['Blc']."_tb4 ".$pv['Blc']."_fcta";
			if ( isset($AD[$NumO]['caption']['class']) ) { $pv['ForgeCaptionClass'] .= $AD[$NumO]['caption']['class']; }
			if ( isset($AD[$NumO]['caption']['syle']) ) { $pv['ForgeCaptionStyle'] = $AD[$NumO]['caption']['style']; }
			$pv['rendu'] .= "<caption class='".$pv['ForgeCaptionClass']."' style='".$pv['ForgeCaptionStyle']."'>".$AD[$NumO]['caption']['cont']."</caption>\r";
		}

		$pv['TRidx'] = 0;
		for ( $NumL = 1 ; $NumL <= $ADC['onglet'][$NumO]['nbr_ligne'] ; $NumL++ ) {
			if ( $NumL == $ADC['onglet'][$NumO]['theadD'] ) { $pv['rendu'] .= "<thead>\r"; }
			if ( $NumL == $ADC['onglet'][$NumO]['tbodyD'] ) { $pv['rendu'] .= "<tbody style='display:block; width:".$pv['WidthTable']."px; height:".($tab_infos['doc_height']-64)."px; overflow-y:scroll;'>\r"; }		//display:block; 
			if ( $NumL == $ADC['onglet'][$NumO]['tfootD'] ) { $pv['rendu'] .= "<tfoot>\r"; }

			if ( $tab_infos['TypSurbrillance'] == 1 ) { 
				$pv['TR'] = "<tr class='".$pv['Tab_class'][$pv['TRidx']]."' onMouseOver=\"this.className='".$pv['Tab_class'][($pv['TRidx']+4)]."'\" onMouseOut=\"this.className='".$pv['Tab_class'][$pv['TRidx']]."'\">\r";
			}
			else { $pv['TR'] = "<tr class='".$pv['Tab_class'][$pv['TRidx']]."'>\r"; }
			$pv['rendu'] .= $pv['TR'];

			$pv['TDidx'] = $pv['TRidx'];
			for ( $NumC = 1 ; $NumC <= $ADC['onglet'][$NumO]['nbr_cellule'] ; $NumC++ ) {
				if ( $AD[$NumO][$NumL][$NumC]['desactive'] == 0 ) {

					$pv['ForgeDeco'] = " class='";
					if ( isset ($AD[$NumO][$NumL][$NumC]['tc']) )	{ $pv['ForgeDeco'] .= $pv['Blc']."_t".$AD[$NumO][$NumL][$NumC]['tc']." "; }
					if ( isset ($AD[$NumO][$NumL][$NumC]['cc']) )	{ $pv['ForgeDeco'] .= $pv['Tab_class'][( ($AD[$NumO][$NumL][$NumC]['cc']*8) + $pv['TRidx'] + $pv['TDidx'] )]." "; }
					if ( isset($AD[$NumO][$NumL][$NumC]['sc']) )	{ $pv['ForgeDeco'] .= $pv['Tab_class'][$AD[$NumO][$NumL][$NumC]['sc']]." "; }
					if ( isset($AD[$NumO][$NumL][$NumC]['class']) )	{ $pv['ForgeDeco'] .= $AD[$NumO][$NumL][$NumC]['class']." "; }
					if ( $pv['ForgeDeco'] == " class='" ) { $pv['ForgeDeco'] = ""; }
					else  { $pv['ForgeDeco'] = substr( $pv['ForgeDeco'], 0, -1 ) . "'"; }

					if ( isset($AD[$NumO][$NumL][$NumC]['style']) ) { $pv['ForgeDeco'] .= " style='".$AD[$NumO][$NumL][$NumC]['style']."'"; }

					$pv['tdtmp'] = "<td" . $pv['ForgeDeco'];
					$pv['spanscore'] = 0;
					if ( $AD[$NumO][$NumL][$NumC]['colspan'] != 0 ) { $pv['spanscore'] += 1; }
					if ( $AD[$NumO][$NumL][$NumC]['rowspan'] != 0 ) { $pv['spanscore'] += 2; }
					switch ($pv['spanscore']) {
					case 1:
						$pv['tdtmp'] .= " colspan='".$AD[$NumO][$NumL][$NumC]['colspan']."'";
						$NumC += $AD[$NumO][$NumL][$NumC]['colspan']-1;
					break;
					case 2:
						$pv['tdtmp'] .= " rowspan='".$AD[$NumO][$NumL][$NumC]['rowspan']."'";
					break;
					case 3:
						$pv['tdtmp'] .= " colspan='".$AD[$NumO][$NumL][$NumC]['colspan']." rowspan='".$AD[$NumO][$NumL][$NumC]['rowspan']."'";
					break;
					}
					//if ( isset ( $AD[$NumO][$NumL][$NumC]['cont'] ) ) { 
					if ( $pv['spanscore'] == 0 ) {
						$pv['rendu'] .= $pv['tdtmp'] .">".$AD[$NumO][$NumL][$NumC]['cont']."</td>\r";
					}
				}
				else { $pv['rendu'] .= "<td></td>\r"; }
				$pv['TDidx'] ^= 1;
			}
			echo("</tr>\r");
			if ( $NumL == $ADC['onglet'][$NumO]['theadF'] ) { $pv['rendu'] .= "</thead>\r"; }
			if ( $NumL == $ADC['onglet'][$NumO]['tbodyF'] ) { $pv['rendu'] .= "</tbody>\r"; }
			if ( $NumL == $ADC['onglet'][$NumO]['tfootF'] ) { $pv['rendu'] .= "</tfoot>\r"; }
			$pv['TRidx'] ^= 1;
		}
		$pv['rendu'] .= "</table>\r";
	}
	if ( $tab_infos['AffOnglet'] != 0 ) { $pv['rendu'] .= "</div>\r"; }
}
if ( $tab_infos['AffOnglet'] != 0 ) { $pv['rendu'] .= "</div>\r"; }

switch ( $tab_infos['mode_rendu'] ) {
	case 0:
		echo $pv['rendu'];
		unset ($pv['rendu']);
	break;
	case 1: break;
}


//if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { 
	unset (
	$tab_pf_style,
	$tab_tr,
	$NumC,
	$NumL,
	$NumO,
	$AD,
	$ADC
	); 
//}

?>
