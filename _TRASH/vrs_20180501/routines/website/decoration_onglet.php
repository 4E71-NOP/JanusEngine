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
//	Forge les DIVs qui vont servir d'onglet
// --------------------------------------------------------------------------------------------
function genere_onglet_html () {
	global $theme_tableau , ${$theme_tableau}, $tab_infos, $module_, $module_z_index, $JavaScriptInitDonnees , $JavaScriptOnload;
	$_REQUEST['bloc']	= decoration_nomage_bloc ( "B", $module_['module_deco_nbr'] , "");
	$_REQUEST['blocT']	= decoration_nomage_bloc ( "B", $module_['module_deco_nbr'] , "T");

	$pv['larg_a'] = ${$theme_tableau}[$_REQUEST['blocT']]['deco_tab_a_x'];
	$pv['larg_c'] = ${$theme_tableau}[$_REQUEST['blocT']]['deco_tab_c_x'];
	$pv['larg_b'] = floor(($tab_infos['doc_width']-(($pv['larg_a']+$pv['larg_c'])*$tab_infos['NbrOnglet'])) / $tab_infos['NbrOnglet']);  
	$pv['larg_d'] = $pv['larg_a'] + $pv['larg_b'] + $pv['larg_c'];

	$pv['hauteur_abcd'] = ${$theme_tableau}[$_REQUEST['blocT']]['deco_tab_y'];

	$c_id_a = $tab_infos['groupe']."_".$tab_infos['cell_id']."_a"; // decoration
	$c_id_b = $tab_infos['groupe']."_".$tab_infos['cell_id']."_b";
	$c_id_c = $tab_infos['groupe']."_".$tab_infos['cell_id']."_c";
	$c_id_d = $tab_infos['groupe']."_".$tab_infos['cell_id']."_d"; // réactif

	$tab['1'] = "visible";	$tab['2'] = "hidden";
	$tab['3'] = $tab['4'] = $tab['5'] = $tab['6'] = $tab['7'] = $tab['8'] = $tab['9'] = $tab['10'] = &$tab['2'];

	$rendu = "<div id='table_".$tab_infos['groupe']."' style='height:".($pv['hauteur_abcd'])."px'>\r";

	$TabPosDim = array();
	for ( $i = 1 ; $i <= $tab_infos['NbrOnglet'] ; $i++ ) {
		$TabPosDim[$i]['pa'] = ($pv['larg_d']*($i-1));
		$TabPosDim[$i]['pb'] = ($pv['larg_a']+($pv['larg_d']*($i-1)));
		$TabPosDim[$i]['pc'] = (($pv['larg_a'] + $pv['larg_b'])+($pv['larg_d']*($i-1)));
		$TabPosDim[$i]['da'] = $pv['larg_a'];
		$TabPosDim[$i]['db'] = $pv['larg_b'];
		$TabPosDim[$i]['dc'] = $pv['larg_c'];
		$TabPosDim[$i]['dd'] = $pv['larg_d'];

		if ( $i == $tab_infos['NbrOnglet'] ) { 
			$pv['compensation'] =  $tab_infos['doc_width'] - ($pv['larg_d'] * $tab_infos['NbrOnglet']);
			$TabPosDim[$i]['pc'] += $pv['compensation'];
			$TabPosDim[$i]['db'] += $pv['compensation'];
			$TabPosDim[$i]['dd'] += $pv['compensation'];
		}		//Compense le problème de calcul ne tombant pas sur des entier. 
	}

	for ( $i = 1 ; $i <= $tab_infos['NbrOnglet'] ; $i++ ) {
		if ( $i == 1 ) { $type = "up"; }
		else { $type = "down"; }
		$pv['tableOnglet'] = "OngletData_".$tab_infos['groupe'].$tab_infos['cell_id'].$tab_infos['document'];

		if ( $tab_infos['tab_comportement'] == 1 ) { 
			$pv['onmouseoverout'] = "
			onmouseover=\"javascript:GestionOnglets ( 0 , 0 , ".$pv['tableOnglet']." , '".$tab_infos['groupe']."' , '".$tab_infos['document']."', ".$i." );\"
			 onmouseout=\"javascript:GestionOnglets ( 0 , 1 , ".$pv['tableOnglet']." , '".$tab_infos['groupe']."' , '".$tab_infos['document']."', ".$i." );\"
			";
		}

		$rendu .= "
		<div style='position:relative; display:table-cell'>\r
		<div id='".$c_id_a.$i."' class='".$theme_tableau.$_REQUEST['bloc']."_tab_".$type."_a' style='position:absolute;	left: ".$TabPosDim[$i]['pa']."px; width: ".$TabPosDim[$i]['da']."px; height: ".$pv['hauteur_abcd']."px;'></div>\r
		<div id='".$c_id_b.$i."' class='".$theme_tableau.$_REQUEST['bloc']."_tab_".$type."_b' style='position:absolute;	left: ".$TabPosDim[$i]['pb']."px; width: ".$TabPosDim[$i]['db']."px; height: ".$pv['hauteur_abcd']."px;'>
		<span style='text-align: center; line-height: ".$pv['hauteur_abcd']."px;'>". 
		$tab_infos["cell_".$i."_txt"] . "</span></div>\r
		<div id='".$c_id_c.$i."' class='".$theme_tableau.$_REQUEST['bloc']."_tab_".$type."_c' style='position:absolute;	left: ".$TabPosDim[$i]['pc']."px; width: ".$TabPosDim[$i]['dc']."px; height: ".$pv['hauteur_abcd']."px;'></div>\r

		<div id='".$c_id_d.$i."' style='position: absolute;	left: ".$TabPosDim[$i]['pa']."px; width: ".$TabPosDim[$i]['dd']."px; height: ".$pv['hauteur_abcd']."px;'
		onClick=\"javascript:GestionOnglets ( 1 , 0 , ".$pv['tableOnglet'].", '".$tab_infos['groupe']."','".$tab_infos['document']."', ".$i." );\"
		".$pv['onmouseoverout']."
		></div>\r
		</div>\r
		";
	}

	$rendu .= "
	</div>\r
	";

	$pv['JavaScriptTable'] = "\rvar OngletData_".$tab_infos['groupe'].$tab_infos['cell_id'].$tab_infos['document']." = {\r";

	for ( $i = 1 ; $i <= $tab_infos['NbrOnglet'] ; $i++ ) {
		if ( $i == 1 ) { $pv['selection'] = 1; }
		else { $pv['selection'] = 0; }
		$pv['JavaScriptTable'] .= "\"".$tab_infos['groupe']."_".$tab_infos['cell_id'].$i."\": {
		'cibleDoc':'".$tab_infos['groupe']."_".$tab_infos['document'].$i."',
		'EtatSelection':'".$pv['selection']."', 
		'EtatHover':'0', 
		'up': {\r
		'ida':'".$c_id_a.$i."', 'Styla':'".$theme_tableau.$_REQUEST['bloc']."_tab_up_a', 
		'idb':'".$c_id_b.$i."', 'Stylb':'".$theme_tableau.$_REQUEST['bloc']."_tab_up_b', 
		'idc':'".$c_id_c.$i."', 'Stylc':'".$theme_tableau.$_REQUEST['bloc']."_tab_up_c' },\r
		'down': {\r
		'ida':'".$c_id_a.$i."', 'Styla':'".$theme_tableau.$_REQUEST['bloc']."_tab_down_a', 
		'idb':'".$c_id_b.$i."', 'Stylb':'".$theme_tableau.$_REQUEST['bloc']."_tab_down_b', 
		'idc':'".$c_id_c.$i."', 'Stylc':'".$theme_tableau.$_REQUEST['bloc']."_tab_down_c' },\r
		'hover': {\r
		'ida':'".$c_id_a.$i."', 'Styla':'".$theme_tableau.$_REQUEST['bloc']."_tab_hover_a', 
		'idb':'".$c_id_b.$i."', 'Stylb':'".$theme_tableau.$_REQUEST['bloc']."_tab_hover_b', 
		'idc':'".$c_id_c.$i."', 'Stylc':'".$theme_tableau.$_REQUEST['bloc']."_tab_hover_c' }\r
		 },\r";
	}

	$pv['JavaScriptTable_length'] = strlen($pv['JavaScriptTable']) - 2;
	$pv['JavaScriptTable'] = substr( $pv['JavaScriptTable'], 0 , $pv['JavaScriptTable_length']) . "\r};\r";
	$JavaScriptOnload[] = "\tInitOnglets ( OngletData_".$tab_infos['groupe'].$tab_infos['cell_id'].$tab_infos['document']." );";
	$JavaScriptInitDonnees[] = $pv['JavaScriptTable'];

	switch ( $tab_infos['mode_rendu'] ) {
		case 0:
		default:
			echo ($rendu);
		break;
		case 1:	
			return $rendu;
		break;
	}
}
?>
