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
//	module_menu_animation.php
// --------------------------------------------------------------------------------------------
$localisation = " / module_menu_01_animation";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_menu_01_animation");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_menu_01_animation");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_menu_01_animation");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

// --------------------------------------------------------------------------------------------
//
//	Analyse de la variable $menu_principal qui contient les informations relatives au menus
//
// --------------------------------------------------------------------------------------------
unset ( $A );
foreach ( $menu_principal as $A ) {
	if ( $A['cate_parent'] != 0 ) {
		if ( $A['arti_ref'] == "0" ) {									// dossier
			$Mi = &$pv['menu_div'][$A['cate_id']];
			$Mp = &$pv['menu_div'][$A['cate_parent']];
			$Mi['niv'] = ( $Mp['niv'] + 1 );
			$Mi['id'] = "d_menu_".$A['cate_id'];
			$Mi['nf'] = menu_nbr_fils ( $A['cate_id'] );
			$Mi['idx'] = 0;
			$Mp['entree'][$Mp['idx']]['type'] = 1;
		}
		elseif ( $A['arti_ref'] == $FPRM['arti_request'] ) { 
			$Mp = &$pv['menu_div'][$A['cate_parent']];
			$Mp['entree'][$Mp['idx']]['type'] = 3;
		}
		else { 
			$Mp = &$pv['menu_div'][$A['cate_parent']];
			$Mp['entree'][$Mp['idx']]['type'] = 2;
			$Mp['entree'][$Mp['idx']]['ref'] = $A['arti_ref'];
		}
		$Mp['entree'][$Mp['idx']]['nom'] = $A['cate_titre'];
		$Mp['entree'][$Mp['idx']]['id'] = $A['cate_id'];


// --------------------------------------------------------------------------------------------
//JSON
// Jbn "Json bloc numéro" -> "BxxM"
// Jb "Json bloc "
// Jd "Json dossier"
// Jp "Json Parent"
// --------------------------------------------------------------------------------------------
		if ( $A['cate_type'] != 0 ) {									// evite le menu racine
			$J = &$pv['menu_JSON']['a_menu_'.$A['cate_id']];			// section 'a'

			$J['menu'] 		= $J['id'] = 'a_menu_'.$A['cate_id'];
			$J['par']		= $Mp['id'];								// Parent
			$J['niv']		= $Mp['niv'];								// Niveau dans l'arborescence
			if ( $J['niv'] > 0 ) { $J['deco'] = ${$theme_tableau}[ decoration_nomage_bloc ( "B", $J['niv'] , "M") ]['deco_type']; }
			$J['anim']		= $Spb['menu_anim'];						// Type d'animation
			$J['entree']	= $A['cate_position'];						// N° dans l'ordre
			$J['typ']		= "a";										// type
			$J['dos']		= 0;										// dossier

			$Jbn = decoration_nomage_bloc ( "B" , $J['niv'] , "M" );
			$Jb = &${$theme_tableau}[$Jbn];
			$J['anim'] = $Jb['deco_anim'];
			$J['le'] = ( $Jb['deco_txt_l_01_margin_top'] + $Jb['deco_txt_l_01_margin_bottom'] + $Jb['deco_a_line_height'] );
//			$J['le'] = ( $Jb['deco_txt_l_01_margin_top'] + $Jb['deco_txt_l_01_margin_bottom'] + $Jb['deco_txt_l_01_size'] );

			if ( $A['cate_parent'] != 0 ) {								// Evite la référence à la racine.
				$Jp = &$pv['menu_JSON']['d_menu_'.$A['cate_parent']];	// ajout du fils au parent.
				$Jp['fils'][] = "a_menu_" . $A['cate_id'];
				$Jp['nf']++;
			}

			if ( $A['arti_ref'] == "0" ) {								// dossier, creation du d_menu
				$J['dos'] = 1;
				$Jd = &$pv['menu_JSON']['d_menu_'.$A['cate_id']];
				$Jd['menu'] 	= $Jd['id'] = "d_menu_".$A['cate_id'];
				$Jd['par']		= $J['id'];								// Parent
				$Jd['niv']		= ( $J['niv'] + 1 );					// Niveau dans l'arborescence
				if ( $Jd['niv'] > 0 ) { $Jd['deco'] = ${$theme_tableau}[ decoration_nomage_bloc ( "B", $Jd['niv'] , "M") ]['deco_type']; }
				$Jd['entree']	= $A['cate_position'];					// N° dans l'ordre
				$Jd['typ']		= "div";								// type
				$Jbn = decoration_nomage_bloc ( "B" , $Jd['niv'] , "M" );
				$Jb = &${$theme_tableau}[$Jbn];
				$Jd['anim']		= $Jb['deco_anim'];						// Type d'animation
				$Jd['width']	= $Jb['deco_div_width'];
				$Jd['dock_cible']	= $Jb['deco_dock_cible'];
				$Jd['dock_decal_x']	= $Jb['deco_dock_decal_x'];
				$Jd['dock_decal_y']	= $Jb['deco_dock_decal_y'];
				$Jd['div_height']	= $Mi['div_height'] = $Jb['deco_div_height'];
				$Jp = &$pv['menu_JSON'][$Jd['par']];
				$Jd['le'] = $Jp['le'];
				$Jp['fils'][] = "d_menu_" . $A['cate_id'];
				$Jp['nf']++;
			}
		}
		$Mp['idx']++;
	}
	else {
		$Mi = &$pv['menu_div'][$A['cate_id']];
		$Mi = &$pv['menu_div'][$A['cate_id']];
		$Mi['niv'] = 0;
		$Mi['id'] = "d_menu_".$A['cate_id'];

		$J = &$pv['menu_JSON']['d_menu_'.$A['cate_id']];
		$J['menu']		= $J['id'] = "d_menu_".$A['cate_id'];
		$J['par']		= "racine";										// Parent
		$J['niv']		= 0;											// Niveau dans l'arborescence
		$J['entree']	= $A['cate_position'];							// N° dans l'ordre
		$J['typ']		= "div";										// type
		$J['dos']		= 0;											// dossier
		$Jbn = decoration_nomage_bloc ( "B" , $J['niv'] , "M" );
		$Jb = &${$theme_tableau}[$Jbn];
		$J['anim']		= $Jb['deco_anim'];								// Type d'animation
		$J['width']		= $Jb['deco_div_width'];
		$J['le']		= ( $Jb['deco_a_line_height'] + $Jb['deco_a_margin_bottom'] );
	}
}

// --------------------------------------------------------------------------------------------
//	Prepare une table qui permet le calcul des positions des différents div des menus
// cible
// 0  8  4
// 2  10 6
// 1  9  5
for ( $pv['i'] = 0 ; $pv['i'] < 10 ; $pv['i']++) {
	$pv['MenuNiv'] = decoration_nomage_bloc ( "B" , $pv['i'], "M" );
	$Pm = &${$theme_tableau}[$pv['MenuNiv']];	//PM presentation menu
	$TPM = &$pv['tablePositionMenu'][$pv['MenuNiv']];
	$TPM['menu_div_width']		= $Pm['deco_div_width'];
	$TPM['menu_dock_cible']		= $Pm['deco_dock_cible'];
	$TPM['menu_dock_decal_x']	= $Pm['deco_dock_decal_x'];
	$TPM['menu_dock_decal_y']	= $Pm['deco_dock_decal_y'];

	$TPM['txt_l_01_size']			= $Pm['deco_txt_l_01_size'];
	$TPM['txt_l_01_margin_top']		= $Pm['deco_txt_l_01_margin_top'];
	$TPM['txt_l_01_margin_bottom']	= $Pm['deco_txt_l_01_margin_bottom'];
	$TPM['txt_l_01_margin_left']	= $Pm['deco_txt_l_01_margin_left'];
	$TPM['txt_l_01_margin_right']	= $Pm['deco_txt_l_01_margin_right'];
	$TPM['a_line_height']			= $Pm['deco_a_line_height'];
	switch ( $Pm['deco_type'] ) {
	case 40:
		$TPM['ex11_y']				= $Pm['deco_ex11_y'];
		$TPM['exF1_y']				= $Pm['deco_ex31_y'];
	break;
	case 50:
	case 60:
		$TPM['ex11_y']				= $Pm['deco_ex11_y'];
		$TPM['exF1_y']				= $Pm['deco_ex51_y'];
	break;
	}
}

// Valeur par défaut en cas de probleme.
unset ( $A );
foreach ( $pv['menu_JSON'] as $A ) { 
	if ( $A['typ'] == "div" ) {
		$pv['coef'] = 1;
		if ( $A['par'] == "racine" ) { $pv['coef'] = 0; }
		$pres_[$A['id']]['px'] = ( 160 * $pv['coef'] );
		$pres_[$A['id']]['py'] = ( 160 * $pv['coef'] );
		$pres_[$A['id']]['dx'] = ( $A['width'] * $pv['coef'] );
		$pres_[$A['id']]['dy'] = ( 256 * $pv['coef'] );
	}
}

// Calcule de la taille des divs contenant les decorations et menu.
// C'est mieux que de le faire dans le Javascript qui produira un effet de "flickering"

unset ( $A );
foreach ( $pv['menu_JSON'] as $A ) { 
	$pv['MenuNiv'] = decoration_nomage_bloc ( "B" , ($A['niv']), "M" );
	$TPM = &$pv['tablePositionMenu'][$pv['MenuNiv']];
	$pres_[$A['id']]['dx'] = $TPM['menu_div_width'];
	$pres_[$A['id']]['dy'] = (( $TPM['txt_l_01_margin_top'] + $TPM['txt_l_01_margin_bottom'] + $TPM['a_line_height'] ) * ($A['nf']+1) ) + $TPM['ex11_y'] + $TPM['exF1_y'];
//	$pres_[$A['id']]['dy'] = (( $TPM['txt_l_01_margin_top'] + $TPM['txt_l_01_margin_bottom'] + $TPM['txt_l_01_size'] ) * ($A['nf']+1) ) + $TPM['ex11_y'] + $TPM['exF1_y'];
}

$pv['div_liste'] = array ( "1div",
"ex11", "ex12", "ex13", "ex14", "ex15",
"ex21", "ex22", "ex23", "ex25",
"ex31", "ex32", "ex33", "ex35",
"ex41", "ex45",
"ex51", "ex52", "ex53", "ex54", "ex55",

"in11", "in12", "in13", "in14", "in15",
"in21", "in25",
"in31", "in35",
"in41", "in45",
"in51", "in52", "in53", "in54", "in55"
);

$_REQUEST['module_z_index_compteur'] = $module_z_index['compteur'];

$GeneratedJavaScriptObj = $CurrentSet->getInstanceOfGeneratedJavaScriptObj();

unset ( $A );
reset ( $pv['menu_div'] );
foreach ( $pv['menu_div'] as $A ) { 
	$Abn = decoration_nomage_bloc ( "B" , $A['niv'] , "M" );
	$Ab = &${$theme_tableau}[$Abn];
	$pv['visibility'] = "hidden";
	if ( $A['niv'] == 0 ) { 
		$JavaScriptOnload[] = "\telm.Gebi( '".$A['id']."' ).style.visibility = 'visible';";
		$GeneratedJavaScriptObj->insertJavaScript ( "Onload" , "\telm.Gebi( '".$A['id']."' ).style.visibility = 'visible';");
	}
	if ( $Ab['deco_affiche_icones'] == 1 ) { 
		if ( strlen ($Ab['deco_icone_repertoire_01']) > 0 ) { $Micone_rep = "<img src='../graph/".$Ab['deco_repertoire']."/".$Ab['deco_icone_repertoire_01']."' width='".$Ab['deco_icone_taille_x']."' height='".$Ab['deco_icone_taille_y']."' border='0'>"; }
		if ( strlen ($Ab['deco_icone_fichier_01']) > 0 ) { $Micone_fichier = "<img src='../graph/".$Ab['deco_repertoire']."/".$Ab['deco_icone_fichier_01']."' width='".$Ab['deco_icone_taille_x']."' height='".$Ab['deco_icone_taille_y']."' border='0'>"; }
	}
	
	$pv['NiveauZero'] = "";
	if ( $A['niv'] == 0 ) { 
		$pv['am_contenu'] = &$affiche_module_['contenu_pendant_module']; 
		$pv['style_niveau_en_cours'] = "";
		$pv['NiveauZero'] = "style='width:".$Ab['deco_div_width']."px;'";
	}
	else { $pv['am_contenu'] = &$affiche_module_['contenu_apres_module']; }

	$module_z_index['compteur'] = $_REQUEST['module_z_index_compteur']+$A['niv']+1;
	if ( $A['niv'] != 0 ) {
		$Ab['BACKUP_REQUEST_bloc'] = $_REQUEST['bloc'];
		$module_menu_['module_nom'] = $A['id'];
		$_REQUEST['blocG'] = $_REQUEST['bloc'] = $Abn;
		$pv['BACKUP_affiche_module_mode'] = $affiche_module_mode;
		$affiche_module_mode = "menu";

		unset ($DL);
		foreach ( $pv['div_liste'] as $DL ) { $_REQUEST['div_id'][$DL] = "id='" . $module_menu_['module_nom'] ."_". $DL ."' "; }

		switch ( $Ab['deco_type'] ) {
		case 30:	case "1_div":		if ( !function_exists("module_deco_30_1_div") )		{ include ("routines/website/module_deco_30_1_div.php"); }		$pv['am_contenu_deco'] = module_deco_30_1_div ( $theme_tableau , "pres_" , "module_menu_", 1 );	break;
		case 40:	case "elegance":	if ( !function_exists("module_deco_40_elegance") )	{ include ("routines/website/module_deco_40_elegance.php"); }	$pv['am_contenu_deco'] = module_deco_40_elegance ( $theme_tableau , "pres_" , "module_menu_", 1 );	break;
		case 50:	case "exquise":		if ( !function_exists("module_deco_50_exquise") )	{ include ("routines/website/module_deco_50_exquise.php"); }	$pv['am_contenu_deco'] = module_deco_50_exquise ( $theme_tableau , "pres_" , "module_menu_", 1 );	break;
		case 60:	case "elysion":		if ( !function_exists("module_deco_60_elysion") )	{ include ("routines/website/module_deco_60_elysion.php"); }	$pv['am_contenu_deco'] = module_deco_60_elysion ( $theme_tableau , "pres_" , "module_menu_", 1 );	break;
		}
		$JavaScriptInitCommandes[] = "CalculeDecoModule ( TabInfoModule , '".$module_menu_['module_nom']."' );";
		$GeneratedJavaScriptObj->insertJavaScript ( "Command", "CalculeDecoModule ( TabInfoModule , '".$module_menu_['module_nom']."' );");
		$_REQUEST['bloc'] = $Ab['BACKUP_REQUEST_bloc'];
		$affiche_module_mode = $pv['BACKUP_affiche_module_mode'];
	}

	$A['div_height_calc'] = (( $TPM['txt_l_01_margin_top'] + $TPM['txt_l_01_margin_bottom'] + $TPM['a_line_height'] ) * ($A['nf']) ) + $TPM['ex11_y'] + $TPM['exF1_y'];
	$A['div_height_calc'] = max ( $A['div_height'] , $A['div_height_calc'] );

	if ( $Ab['deco_a_line_height'] > 0 ) { $pv['supLH'] = "; line-height:". $Ab['deco_a_line_height']."px;"; }

	 // position: absolute; est nécessaire sinon les DIVs se retrouvent en haut à gauche.
	$pv['style_niveau_en_cours'] = "style='position: absolute; z-index: ".$module_z_index['compteur'].";
	left: ".$pres_[$A['id']]['px']."px; top: ".$pres_[$A['id']]['py']."px; 
	width: ".$pres_[$A['id']]['dx']."px; height: ". $A['div_height_calc'] . "px; 
	visibility: ".$pv['visibility']."; ".$pv['supLH']."'";

	$pv['am_contenu'] .= "<div id='".$A['id']."' class='".$theme_tableau."menu_niv_".$A['niv']."' " . $pv['style_niveau_en_cours'] . " ".$pv['NiveauZero']." >\r" . $pv['am_contenu_deco'] ;

	unset ( $B );
	if ( is_array ( $A['entree'] ) ) {
		foreach ( $A['entree'] as $B ) { 
			switch ( $B['type'] ) {
				case 1: $pv['am_contenu'] .= "<a id='a_menu_".$B['id']."' class='".$theme_tableau."menu_niv_".$A['niv']."_lien' href=\"#\" style='display: block;'>".$Micone_rep." ".$B['nom']."</a>\r";				break;
				case 2: $pv['am_contenu'] .= "<a id='a_menu_".$B['id']."' class='".$theme_tableau."menu_niv_".$A['niv']."_lien' href=\"index.php?arti_ref=".$B['ref']."&amp;arti_page=1".$bloc_html['url_slup']."\" style='display: block;'>".$Micone_fichier." ".$B['nom']."</a>\r";				break;
				case 3: $pv['am_contenu'] .= "<a id='a_menu_".$B['id']."' class='".$theme_tableau."menu_niv_".$A['niv']."_lien' href=\"#\" style='display: block;'>".$Micone_fichier." ".$B['nom']."</a>\r";			break;
			}
		}
	}
	$pv['am_contenu'] .= "\r</div>\r";
	if ( $A['niv'] != 0 ) { $pv['am_contenu'] .= "\r</div>\r"; }
}

$_REQUEST['module_z_index_compteur'] = $module_z_index['compteur'];

$pv['menu_JSON_nom'] = "TabMenuArbre";
$pv['menu_JSON_rendu'] .= "var ".$pv['menu_JSON_nom']." = {\r";
foreach ( $pv['menu_JSON'] as &$A ) { 
	$pv['menu_JSON_rendu'] .= "\t'".$A['menu']."':	{ 'id':'".$A['id']."',	'p':'".$A['par']."',	'niv':'".$A['niv']."',	'deco':'".$A['deco']."',	'anim':'".$A['anim']."',	'ent':'".$A['entree']."',	'nbent':'".$A['nf']."',	'width':'".$A['width']."',	'cible':'".$A['dock_cible']."',	'decal_x':'".$A['dock_decal_x']."',	'decal_y':'".$A['dock_decal_y']."',	'le':'".$A['le']."', 'dos':'".$A['dos']."',	'typ':'".$A['typ']."',	'min_height':'" .$A['div_height'] ."'";
	if ( $A['nf'] > 0 ) { 
		$pv['menu_JSON_rendu'] .= ",	f:{ ";
		foreach ( $A['fils'] as $B => &$C ) { $pv['menu_JSON_rendu'] .= "'a".( $B + 1 )."':'".$C."',	"; } // par reference obligatoire 
		$pv['menu_JSON_rendu'] = substr ( $pv['menu_JSON_rendu'] , 0 , -2 ) . "} ";
	}
	$pv['menu_JSON_rendu'] .= "},\r";
}
$pv['menu_JSON_rendu'] = substr ( $pv['menu_JSON_rendu'] , 0 , -2 ) . "\r};\r\r";

unset ( 
	$A, 
	$B, 
	$C,
	$Abn,
	$Ab,
	$Mi,
	$Mp,
	$J,
	$Jb,
	$Jd,
	$Jp,
	$Jbn, 
	$Pm,
	$TPM
);

?>
