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
$_REQUEST['M_PRESNT']['pres_id'] = 5;

/*Hydre-contenu_debut*/
if ( $_REQUEST['M_PRESNT']['confirmation_modification_oubli'] == 1 ) {
		$tl_['eng']['err'] = "You didn't confirm the layout update.";
		$tl_['fra']['err'] = "Vous n'avez pas confirm&eacute; la modification de la pr&eacute;sentation";
		echo ("<p class='".$theme_tableau."s0".$module_['module_deco_nbr']."_erreur2'>".$tl_[$l]['err']."<br>\r"); 
	}

$tl_['eng']['invite1'] = "This part will alow you to modify displays.";
$tl_['fra']['invite1'] = "Cette partie va vous permettre de modifier les pr&eacute;sentation.";

echo ("<p>". $tl_[$l]['invite1']."</p>");

$dbquery = requete_sql( $_REQUEST['sql_initiateur'],"
SELECT pr.* 
FROM ".$SQL_tab_abrege['presentation']." pr 
WHERE pr.pres_id = ".$_REQUEST['M_PRESNT']['pres_id']."
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$AD['1']['1']['2']['cont'] = $dbp['pres_nom'];
	$AD['1']['2']['2']['cont'] = $dbp['pres_titre'];
	$AD['1']['3']['2']['cont'] = $dbp['pres_nom_generique'];
	$AD['1']['4']['2']['cont'] = $dbp['pres_desc'];
	$pv['onglet_deco'] = $dbp['pres_titre'] . " (" . $dbp['pres_nom'] . ")";
}

$tl_['eng']['po1l1'] = "Name";			$tl_['fra']['po1l1'] = "Nom";
$tl_['eng']['po1l2'] = "Tittle";		$tl_['fra']['po1l2'] = "Titre";
$tl_['eng']['po1l3'] = "Generic name";	$tl_['fra']['po1l3'] = "Nom g&eacute;n&eacute;rique";
$tl_['eng']['po1l4'] = "Description";	$tl_['fra']['po1l4'] = "Description";

$AD['1']['1']['1']['cont'] = $tl_[$l]['po1l1'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['po1l2'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['po1l3'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['po1l4'];

$ADC['onglet']['1']['nbr_ligne'] = 4;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;

$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 128;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -16 ;
$tab_infos['groupe']			= "mp_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");


// --------------------------------------------------------------------------------------------
function presentation_ligne () {
	global $l, $tl_, $pv, $theme_tableau, ${$theme_tableau}, $MP_module, $tab_infos;
	$ptr = &$pv['pres_ligne'][$pv['ligne']];
	$SoustractionCol2 =160;

	$rendu = "
	<input type='hidden' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_cont_id]'	value='".$ptr['pres_cont_id']."'>\r
	<div style='width : ".($tab_infos['doc_width'] - $SoustractionCol2)."px;'>

	<table style='width: ".($tab_infos['doc_width'] - $SoustractionCol2)."px; border-spacing: 1px; empty-cells: show; vertical-align: top;'>\r
	<tr>\r
	<td ".$pv['decotable_style01'].">ID:".$ptr['pres_cont_id']."</td>\r

	<td ".$pv['decotable_style01'].">
	Module 
	<select name='M_PRESNT[L".$ptr['pres_cont_id']."][module_nom]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
	";
	unset ( $M );
	foreach ( $MP_module as $M ) {
		$ms = "";
		if ( $M['module_nom'] == $ptr['pres_module_nom'] ) { $ms = " selected "; }
		$rendu .= "<option value='".$M['module_nom']."' ".$ms.">".$M['module_nom']."</option>\r";
	}
	$rendu .= "
	</select>\r
	</td>\r
	<td ".$pv['decotable_style01'].">Position : 
	<input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][nouvelordre]' size='2' maxlength='3' value='".$ptr['pres_ligne']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>
	</td>\r
	<td ".$pv['decotable_style01']."><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_bas']."' alt='&gt;&gt;' border='0' width='24' height='24' onClick=\"CommuteAffichage ( 'Contenu_".$ptr['pres_ligne']."' );\"></td>\r
	</tr>\r
	</table>\r

	<div id='Contenu_".$ptr['pres_ligne']."' style='visibility: hidden; display: none;'>
	<table style='width: ".($tab_infos['doc_width'] - $SoustractionCol2 - 8 )."px; border-spacing: 1px; empty-cells: show; vertical-align: top;'>\r
	<tr>\r
	<td colspan='2' ".$pv['decotable_style02'].">".$tl_[$l]['min']." X</td>\r
	<td colspan='2' ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][minimum_x]' size='2' maxlength='3' value='".$ptr['pres_minimum_x']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	<td colspan='2' ".$pv['decotable_style02'].">".$tl_[$l]['min']." Y</td>\r
	<td colspan='2' ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][minimum_y]' size='2' maxlength='3' value='".$ptr['pres_minimum_y']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	</tr>\r

	<tr>\r
	<td ".$pv['decotable_style02'].">".$tl_[$l]['espacement_bord_haut']."</td>\r
	<td ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_espacement_bord_haut]' size='2' maxlength='3' value='".$ptr['pres_espacement_bord_haut']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	<td ".$pv['decotable_style02'].">".$tl_[$l]['espacement_bord_bas']."</td>\r
	<td ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_espacement_bord_bas]' size='2' maxlength='3' value='".$ptr['pres_espacement_bord_bas']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	<td ".$pv['decotable_style02'].">".$tl_[$l]['espacement_bord_gauche']."</td>\r
	<td ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_espacement_bord_gauche]' size='2' maxlength='3' value='".$ptr['pres_espacement_bord_gauche']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	<td ".$pv['decotable_style02'].">".$tl_[$l]['espacement_bord_droite']."</td>\r
	<td ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_espacement_bord_droite]' size='2' maxlength='3' value='".$ptr['pres_espacement_bord_droite']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	</tr>\r
	<tr>\r
	<td colspan='2' ".$pv['decotable_style02'].">".$tl_[$l]['dim']." X</td>\r
	<td colspan='2' ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_dimenssion_x]' size='2' maxlength='3' value='".$ptr['pres_dimenssion_x']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	<td colspan='2' ".$pv['decotable_style02'].">".$tl_[$l]['dim']." X</td>\r
	<td colspan='2' ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_dimenssion_y]' size='2' maxlength='3' value='".$ptr['pres_dimenssion_y']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	</tr>\r

	<tr>\r
	<td colspan='8' ".$pv['decotable_style02'].">".$tl_[$l]['typcal_txt']."
	<select name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_type_calcul]' id='pres_type_calcul_".$pv['ligne']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1' onChange='ManiPresTypCal ( this.id , ".$pv['ligne'].");'>\r
	";

	$ms_tc_['0']['t'] = $tl_[$l]['typcal_s'];	$ms_tc_['0']['d'] = "STATIC";	$ms_tc_['0']['s'] = "";
	$ms_tc_['1']['t'] = $tl_[$l]['typcal_d'];	$ms_tc_['1']['d'] = "DYNAMIC";	$ms_tc_['1']['s'] = "";
	$ms_tc_[$ptr['pres_type_calcul']]['s'] = " selected ";
	foreach ( $ms_tc_ as $TC ) { $rendu .= "<option value='".$TC['d']."' ".$TC['s'].">".$TC['t']."</option>\r"; }

	if ( strlen( $ms_tc_['0']['s'] ) == 0 ) { $pv['vis']['TabCalStatic'] = "visibility: hidden; display: none;"; $pv['vis']['TabCalDynamic'] = "visibility: visible; display: block;"; }
	else { $pv['vis']['TabCalStatic'] = "visibility: visible; display: block;"; $pv['vis']['TabCalDynamic'] = "visibility: hidden; display: none;"; }

	$rendu .= "
	</select>\r
	</td>\r
	</tr>\r
	</table>\r

	<div id='TabCalStatic_".$pv['ligne']."' style='".$pv['vis']['TabCalStatic']."'>
	<table style='width: ".($tab_infos['doc_width'] - $SoustractionCol2 -8 )."px; border-spacing: 1px; empty-cells: show; vertical-align: top;'>\r
	<tr>\r
	<td ".$pv['decotable_style02'].">".$tl_[$l]['pos']." X</td>\r
	<td ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_position_x]' size='2' maxlength='3' value='".$ptr['pres_position_x']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	<td ".$pv['decotable_style02'].">".$tl_[$l]['pos']." Y</td>\r
	<td ".$pv['decotable_style02']."><input type='text' name='M_PRESNT[L".$ptr['pres_cont_id']."][pres_position_y]' size='2' maxlength='3' value='".$ptr['pres_position_y']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px</td>\r
	</tr>\r
	</table>\r
	</div>\r


	<div id='TabCalDynamic_".$pv['ligne']."' style='".$pv['vis']['TabCalDynamic']."'>
	<table style='width: ".($tab_infos['doc_width'] - $SoustractionCol2 - 16 )."px; border-spacing: 1px; empty-cells: show; vertical-align: top;'>\r
	";
	$pv['abcde'] = "*abcdef";
	$ms_gauchedroite_['0']['t'] = "?";					$ms_gauchedroite_['0']['d'] = 0;		$ms_gauchedroite_['0']['s'] = "";
	$ms_gauchedroite_['1']['t'] = $tl_[$l]['gauche'];	$ms_gauchedroite_['1']['d'] = "GAUCHE";	$ms_gauchedroite_['1']['s'] = "";
	$ms_gauchedroite_['2']['t'] = $tl_[$l]['droite'];	$ms_gauchedroite_['2']['d'] = "DROITE";	$ms_gauchedroite_['2']['s'] = "";
	$ms_hautbas_['0']['t'] = "?";						$ms_hautbas_['0']['d'] = 0;				$ms_hautbas_['0']['s'] = "";
	$ms_hautbas_['2']['t'] = $tl_[$l]['bas'];			$ms_hautbas_['2']['d'] = "BAS";			$ms_hautbas_['2']['s'] = "";
	$ms_hautbas_['1']['t'] = $tl_[$l]['haut'];			$ms_hautbas_['1']['d'] = "HAUT";		$ms_hautbas_['1']['s'] = "";

	for ( $i = 1 ; $i <= 3 ; $i++ ) {
		$rendu .= "
		<tr>\r
		";
		for ( $j = 1 ; $j <= 5 ; $j++ ) {
			if ( $j != 1 ) { $rendu .= "<tr>\r"; }
			$AncreM = "pres_module_ancre_e"  . $i . $pv['abcde'][$j];
			$AncreX = "pres_ancre_ex" . $i . $pv['abcde'][$j];
			$AncreY = "pres_ancre_ey" . $i . $pv['abcde'][$j];
			$ms_hautbas_['0']['s'] = "";			$ms_hautbas_['1']['s'] = "";		$ms_hautbas_['2']['s'] = "";
			$ms_gauchedroite_['0']['s'] = "";		$ms_gauchedroite_['1']['s'] = "";	$ms_gauchedroite_['2']['s'] = "";
			$ms_gauchedroite_[$ptr[$AncreX]]['s'] = " selected ";	$ms_hautbas_[$ptr[$AncreY]]['s'] = " selected ";

			$rendu .= "
			<td ".$pv['decotable_style02'].">".$j."</td>\r
			<td ".$pv['decotable_style02'].">\r
			<select name='M_PRESNT[L".$ptr['pres_cont_id']."][" . $AncreM . "]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
			<option value='0'>?</option>\r
			";
			unset ( $M );
			foreach ( $MP_module as $M ) {
				$ms = "";
				if ( $M['module_nom'] == $ptr[$AncreM] ) { $ms = " selected "; }
				$rendu .= "<option value='".$M['module_id']."' ".$ms.">".$M['module_nom']."</option>\r";
			}
			$rendu .= "
			</select>\r

			</td>\r
			<td colspan='2' ".$pv['decotable_style02'].">
			<select name='M_PRESNT[L".$ptr['pres_cont_id']."][".$AncreX."]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
			";
			foreach ( $ms_gauchedroite_ as $k ) { $rendu .= "<option value='".$k['d']."' ".$k['s'].">".$k['t']."</option>\r"; }
			unset ( $k );

			$rendu .= "
			</select>\r
			</td>\r
			<td colspan='2' ".$pv['decotable_style02'].">\r
			<select name='M_PRESNT[L".$ptr['pres_cont_id']."][".$AncreY."]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
			";
			foreach ( $ms_hautbas_ as $k ) { $rendu .= "<option value='".$k['d']."' ".$k['s'].">".$k['t']."</option>\r"; }
			unset ( $k );
			$rendu .= "
			</select>\r
			</td>\r
			";
			if ( $j == 1 ) { 
				$AncreX = "pres_ancre_dx" . ( $i * 10 );
				$AncreY = "pres_ancre_dy" . ( $i * 10 );
				$ms_hautbas_['0']['s'] = "";			$ms_hautbas_['1']['s'] = "";		$ms_hautbas_['2']['s'] = "";
				$ms_gauchedroite_['0']['s'] = "";		$ms_gauchedroite_['1']['s'] = "";	$ms_gauchedroite_['2']['s'] = "";
				$ms_gauchedroite_[$ptr[$AncreX]]['s'] = " selected ";	$ms_hautbas_[$ptr[$AncreY]]['s'] = " selected ";
				$rendu .= "
				<td colspan='2' rowspan='5' ".$pv['decotable_style02'].">".$AncreX."<select name='M_PRESNT[L".$ptr['pres_cont_id']."][".$AncreX."]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
				";
				foreach ( $ms_gauchedroite_ as $k ) { $rendu .= "<option value='".$k['d']."' ".$k['s'].">".$k['t']."</option>\r"; }
				unset ( $k );
				$rendu .= "
				</select>\r
				<br>\r
				<br>\r
				".$AncreY."<select name='M_PRESNT[L".$ptr['pres_cont_id']."][".$AncreY."]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
				";
				foreach ( $ms_hautbas_ as $k ) { $rendu .= "<option value='".$k['d']."' ".$k['s'].">".$k['t']."</option>\r"; }
				unset ( $k );
				$rendu .= "
				</select>\r
				</td>\r
				";
			}
		$rendu .= "
		</tr>\r
		";
		}
	}
	$rendu .= "
	</table>\r
	</div>\r

	</div>\r
	</div>\r
	<br>\r
	";
	return ( $rendu );
}

// --------------------------------------------------------------------------------------------
$tl_['eng']['typcal_txt'] = "Method";	$tl_['fra']['typcal_txt'] = "M&eacute;thode de calcul";
$tl_['eng']['typcal_s'] = "Static";		$tl_['fra']['typcal_s'] = "Statique";
$tl_['eng']['typcal_d'] = "Dynamic";	$tl_['fra']['typcal_d'] = "Dynamique";

$tl_['eng']['min'] = "Minimum";			$tl_['fra']['min'] = "Minimum";

$tl_['eng']['espacement_bord_haut'] = "Spacing top";			$tl_['fra']['espacement_bord_haut'] = "Espacement haut";
$tl_['eng']['espacement_bord_bas'] = "Spacing bottom";			$tl_['fra']['espacement_bord_bas'] = "Espacement bas";
$tl_['eng']['espacement_bord_gauche'] = "Spacing left";			$tl_['fra']['espacement_bord_gauche'] = "Espacement gauche";
$tl_['eng']['espacement_bord_droite'] = "Spacing right";		$tl_['fra']['espacement_bord_droite'] = "Espacement droite";

$tl_['eng']['pos'] = "Position";		$tl_['fra']['pos'] = "Position";
$tl_['eng']['dim'] = "Size";			$tl_['fra']['dim'] = "Dimmenssion";

$tl_['eng']['haut'] = "Top";			$tl_['fra']['haut'] = "Haut";
$tl_['eng']['bas'] = "Bottom";			$tl_['fra']['bas'] = "Bas";
$tl_['eng']['gauche'] = "Left";			$tl_['fra']['gauche'] = "Gauche";
$tl_['eng']['droite'] = "Right";		$tl_['fra']['droite'] = "Droite";

$tl_['eng']['lignePF'] = "Line ";		$tl_['fra']['LignePF'] = "Ligne ";
$tl_['eng']['onglet1'] = "Program";		$tl_['fra']['onglet1'] = "Programme";


$pv['decotable_style']['0'] = " class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_t2' style='text-align:center;' ";
$pv['decotable_style']['1'] = " class='" . $theme_tableau . $_REQUEST['bloc']."_fcd " . $theme_tableau . $_REQUEST['bloc']."_t2' style='text-align:center;' ";

$pv['decotable_style']['10'] = " class='" . $theme_tableau . $_REQUEST['bloc']."_fctb " . $theme_tableau . $_REQUEST['bloc']."_t2' style='text-align:center;' ";
$pv['decotable_style']['11'] = " class='" . $theme_tableau . $_REQUEST['bloc']."_fcb " . $theme_tableau . $_REQUEST['bloc']."_t2' style='text-align:center;' ";

$pv['decotable_style01'] = $pv['decotable_style']['0'];
$pv['decotable_style02'] = $pv['decotable_style']['1'];

// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'] ,"
SELECT * 
FROM ".$SQL_tab_abrege['module']." m, ".$SQL_tab_abrege['site_module']." sm 
WHERE sm.site_id = '".$site_web['ws_id']."' 
AND m.module_id = sm.module_id
AND m.module_groupe_pour_voir ".$user['clause_in_groupe']." 
ORDER BY module_position
;");
$pv['i'] = 1;
while ($dbp = fetch_array_sql($dbquery)) { 
	unset ( $A , $B );
	foreach ( $dbp as $A => $B ) { $MP_module[$pv['i']][$A] = $B; } 
	$pv['i']++;
}

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['presentation_contenu']." 
WHERE pres_id = '".$_REQUEST['M_PRESNT']['pres_id']."' 
ORDER BY pres_ligne
;");

$pv['i'] = 1;
while ($dbp = fetch_array_sql($dbquery)) {
	unset ( $A , $B );
	foreach ( $dbp as $A => $B ) { $pv['pres_ligne'][$pv['i']][$A] = $B; }
	$pv['i']++;
}
$pv['cssidx'] = 10;
for ( $pv['ligne'] = 1 ; $pv['ligne'] < $pv['i'] ; $pv['ligne']++ ) { 
	$AD['1'][$pv['ligne']]['1']['cont'] = $tl_[$l]['LignePF'] . ": " . $pv['pres_ligne'][$pv['ligne']]['pres_ligne'];
	$AD['1'][$pv['ligne']]['2']['cont'] = presentation_ligne (); 

	$pv['decotable_style01'] = $pv['decotable_style'][$pv['cssidx']];
	$pv['decotable_style02'] = $pv['decotable_style'][($pv['cssidx']+1)];
	switch ($pv['cssidx']) {
	case 0:  $pv['cssidx'] = 10;	break;
	case 10:  $pv['cssidx'] = 0;	break;
	}
}

$ADC['onglet']['1']['nbr_ligne'] = ( $pv['i'] - 1 );	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 512;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -16 ;
$tab_infos['groupe']			= "gp_grp2";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $pv['onglet_deco'];

echo ("<form ACTION='index.php?' method='post' name='formulaire_gdp'>\r");
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------
$tl_['eng']['text_confirm1'] = "I confirm the presentation modifications.";					$tl_['eng']['bouton1'] = "Modify";
$tl_['fra']['text_confirm1'] = "Je valide la modification de la pr&eacute;sentation.";	$tl_['fra']['bouton1'] = "Modifier";
$bloc_html['UPDATE_action'] = "<input type='hidden' name='UPDATE_action'		value='UPDATE_DISPLAY'>\r";
echo ("
<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
<tr>\r
<td>\r<input type='checkbox' name='M_PRESNT['confirmation_modification']' value='1'>".$tl_[$l]['text_confirm1']."\r</td>\r

<td style='text-align: right;'>\r
".$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['UPDATE_action']."
<input type='hidden' name='arti_page'						value='2'>\r
<input type='hidden' name='uni_gestion_des_presentation_p'	value='".$_REQUEST['uni_gestion_des_presentations_p']."'>\r
<input type='hidden' name='M_PRESNT[pres_id]'						value='".$_REQUEST['M_PRESNT']['pres_id']."'>\r
".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']
);

$_REQUEST['BS']['id']				= "bouton_modification";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 192;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();

echo ("<br>\r&nbsp;
</form>\r
</td>\r
</tr>\r

<tr>\r
<td ></td>\r
<td style='text-align: right;'>\r
<form ACTION='index.php?' method='post'>\r
".$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'	value='1'>\r
".$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
");

$tl_['eng']['bouton2'] = "Return to list";
$tl_['fra']['bouton2'] = "Retour &agrave; la liste";

$_REQUEST['BS']['id']				= "bouton_retour_liste";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton2'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 0;
echo generation_bouton ();
echo ("<br>\r&nbsp;</td>\r
</form>\r
</tr>\r

</table>\r
<br>\r
");

$JavaScriptFichier[] = "routines/website/javascript/lib_LayoutManagement.js";

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp,
		$dbquery,
		$MP_module,
		$pv,
		$AD,
		$ADC,
		$tab_etat,
		$trr,
		$tl_
	);
}


/*Hydre-contenu_fin*/
?>
