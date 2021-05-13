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
// --------------------------------------------------------------------------------------------
//	uni_gestion_des_decoration_p02.php debut
// --------------------------------------------------------------------------------------------
//	15	mwm_aqua_menu_002	1	10	4
//	11	mwm_aqua_texte_001	1	20	2
//	28	mwm_magma_block_099	1	30	2
//	8	mwm_aqua_block_001	1	40	2
//	9	mwm_aqua_block_002	1	50	2
//	27	mwm_magma_block_002	1	60	2


$_REQUEST['uni_gestion_des_decorations_p'] = 2;
$_REQUEST['M_DECORA']['ref_id'] = 15;

$DP_['arti_page_save'] = $DP_['arti_page'];
$pv['deco_name_form'] = "modification";

/*Hydr-Content-Begin*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_decoration_p02.php";

$_REQUEST['tableau_javascript_element_dynamique'] = array();
$TJED = &$_REQUEST['tableau_javascript_element_dynamique'];
$_REQUEST['TJED_ptr'] = 0;
// TJED stocke pour générer des tables JavaScript
function TJED_insertion ( $form , $element , $type, $routine ) { 
	$TJED = &$_REQUEST['tableau_javascript_element_dynamique'];
	$i = $_REQUEST['TJED_ptr'];
	$TJED[$i]['Form']		= $form;
	$TJED[$i]['Cible']		= $element;
	$TJED[$i]['Methode']	= $type;
	$TJED[$i]['Routine']	= $routine;
	$_REQUEST['TJED_ptr']++;
}

$_REQUEST['tableau_javascript_position_module'] = array();
$TJPM = &$_REQUEST['tableau_javascript_position_module'];
function creation_tableau_javascript ( $mn ) {
	global $GD_pres_;
	$TJPM = &$_REQUEST['tableau_javascript_position_module'];
	$TJPM[$mn]['nom_module'] = $mn;
	$TJPM[$mn]['pos_x1_22'] = $GD_pres_[$mn]['pos_x1_22'];
	$TJPM[$mn]['pos_x2_22'] = $GD_pres_[$mn]['pos_x2_22'];
	$TJPM[$mn]['pos_y1_22'] = $GD_pres_[$mn]['pos_y1_22'];
	$TJPM[$mn]['pos_y3_22'] = $GD_pres_[$mn]['pos_y3_22'];
}

// Repertorie les modules
// s'accompagne de Javascript : CalculeDecoModule ( '$j' , '$GD_module_['module_name']' , 'formulaire_gdd' );
$_REQUEST['tableau_javascript_liste_module'] = array();
$TJLM = &$_REQUEST['tableau_javascript_liste_module'];
$_REQUEST['TJLM_ptr'] = 0;
function TJLM_insertion ( $type , $ModType , $NomModule , $FormCible ) {
	$TJLM = &$_REQUEST['tableau_javascript_liste_module'];
	$i = $_REQUEST['TJLM_ptr'];
	$TJLM[$i]['type']		= $type;
	$TJLM[$i]['ModType']	= $ModType;
	$TJLM[$i]['NomModule']	= $NomModule;
	$TJLM[$i]['FormCible']	= $FormCible;
	$_REQUEST['TJLM_ptr']++;
}

//	Ligne_formulaire_deco_graphique ( "ex11" , "EX 11", 1,1,1,1, "exquise");
function ligne_formulaire_deco_graphique ( $div , $nom_div , $x , $y , $b ,$p, $j ) {
	global $GD_module_, $mn, $pv, ${$theme_tableau};
	$ChdimX = $ChdimY = "";
	echo ("
	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta'>".$nom_div."</td>\r
	".$_REQUEST['td_fca']."
	");
	if ( $x == 1 ) {
		$ChdimX = "M_DECORA[".$GD_module_['module_name']."_".$div."_dimx]";
		echo ("
		<input type='text' name='M_DECORA[".$GD_module_['module_name']."_".$div."_dimx]' size='2' maxlength='3' value='".$pv["deco_".$div.'_x_'.$j]."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'
		onChange=\"
		elm.Gebi('".$GD_module_['module_name']."_".$div."').style.width = this.value+'px';\r
		CalculeDecoModule ( '".$j."' , '".$GD_module_['module_name']."'  , 'formulaire_gdd' );
		\">px\r
		");
	}
	echo ("
	</td>\r
	".$_REQUEST['td_fca']."
	");
	if ( $y == 1 ) {
		$ChdimY = "M_DECORA[".$GD_module_['module_name']."_".$div."_dimy]";
		echo ("
		<input type='text' name='M_DECORA[".$GD_module_['module_name']."_".$div."_dimy]' size='2' maxlength='3' value='".$pv["deco_".$div.'_y_'.$j]."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'
		onChange=\"
		elm.Gebi('".$GD_module_['module_name']."_".$div."').style.height = this.value+'px';\r
		CalculeDecoModule ( '".$j."' , '".$GD_module_['module_name']."' , 'formulaire_gdd' );
		\">px\r
		");
	}
	echo ("
	</td>\r
	".$_REQUEST['td_fca']."
	");
	if ( $b == 1 ) {
		echo generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$GD_module_['module_name']."_".$div."_bg]" , $ChdimX , $ChdimY , "M_DECORA[repertoire]" , $pv["deco_".$div."_".$j] , $GD_module_['module_name'] , "CalculeDecoModule" , $j );
	}
	echo ("
	</td>\r
	".$_REQUEST['td_fca']."
	");
	if ( $p == 1 ) {
		echo ("
		<select name='M_DECORA[".$GD_module_['module_name']."_".$div."_bgp]' 
		onChange=\"elm.Gebi('".$GD_module_['module_name']."_".$div."').style.backgroundPosition = this.value;\r
		\">\r
		<option value='top left'>top left</option>\r
		<option value='top center'>top center</option>\r
		<option value='top right'>top right</option>\r
		<option value='center left'>center left</option>\r
		<option value='center center'>center center</option>\r
		<option value='center right'>center right</option>\r
		<option value='bottom left'>bottom left</option>\r
		<option value='bottom center'>bottom center</option>\r
		<option value='bottom right'>bottom right</option>\r
		</select>
		");
	}
	echo ("
	</td>\r
	</tr>\r
	");
}

$_REQUEST['td_fca']			= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>\r";
$_REQUEST['td_fcb']			= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb'>\r";
$_REQUEST['td_fcc']			= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcc'>\r";
$_REQUEST['td_fcd']			= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcd'>\r";

$_REQUEST['td_fcta']		= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta'>\r";
$_REQUEST['td_fctb']		= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fctb'>\r";
$_REQUEST['td_cs2_fcta']	= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta' colspan='2'>\r";
$_REQUEST['td_cs2_fca']		= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca' colspan='2'>\r";
$_REQUEST['td_cs2_fcb']		= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb' colspan='2'>\r";
$_REQUEST['td_cs3_fca']		= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca' colspan='3'>\r";
$_REQUEST['td_cs3_fcb']		= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb' colspan='3'>\r";
$_REQUEST['td_cs4_fca']		= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca' colspan='4'>\r";
$_REQUEST['td_cs4_fcb']		= "<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb' colspan='4'>\r";

// --------------------------------------------------------------------------------------------
//	Generation du stylesheet
// --------------------------------------------------------------------------------------------
$_REQUEST['sauve']['website_ws_stylesheet'] = $website['ws_stylesheet'];

$website['ws_stylesheet'] = 1; // Passe en mode dynamique

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['theme_descriptor']."  
WHERE theme_id = '1' 
;"); //1 = one (the theme name)

// Charge aussi les données de la decoration en mode modification.
// $DEC est crée dans charge_donnees_theme_tableau.php
$pv['gestion_deco'] = 1;		// active le segment de script dédié dans charge_donnée_tableau
$theme_tableau = "theme_GD_";
include ("engine/charge_donnees_theme_tableau.php");
$theme_tableau_a_ecrire = "theme_GD_";
$stylesheet_entete = "";
include ("engine/charge_donnees_theme_stylesheet.php");
echo ( $stylesheet . "\r");

// Faire une requete pour retrouver le theme d'origine qui permettra de charger quelques information comme le fond (BG)
// outil_debug ( ${$theme_tableau} , $theme_tableau );
// --------------------------------------------------------------------------------------------
foreach ( ${$theme_tableau}['B01M'] as $A => $B ) { $pv[$A.'_menu'] = $B; }			unset ($A , $B );
foreach ( ${$theme_tableau}['B02T'] as $A => $B ) { $pv[$A.'_caligraph'] = $B; }	unset ($A , $B );
foreach ( ${$theme_tableau}['B03G'] as $A => $B ) { $pv[$A.'_1_div'] = $B; }		unset ($A , $B );
foreach ( ${$theme_tableau}['B04G'] as $A => $B ) { $pv[$A.'_elegance'] = $B; }		unset ($A , $B );
foreach ( ${$theme_tableau}['B05G'] as $A => $B ) { $pv[$A.'_exquisite'] = $B; }		unset ($A , $B );
foreach ( ${$theme_tableau}['B06G'] as $A => $B ) { $pv[$A.'_elysion'] = $B; }		unset ($A , $B );

$tl_['fra']['md_type1'] = "Menu";							$tl_['eng']['md_type1'] = "Menu";
$tl_['fra']['md_type2'] = "Caligraphe (réglages du texte)";	$tl_['eng']['md_type2'] = "Caligraph (text settings)";
$tl_['fra']['md_type3'] = "1 Div";							$tl_['eng']['md_type3'] = "1 Div";
$tl_['fra']['md_type4'] = "Elegance";						$tl_['eng']['md_type4'] = "Elegance";
$tl_['fra']['md_type5'] = "Exquise";						$tl_['eng']['md_type5'] = "Exquisite";						
$tl_['fra']['md_type6'] = "Elysion";						$tl_['eng']['md_type6'] = "Elysion";

$md_type['10']['t'] = $tl_[$l]['md_type1'];	$md_type['10']['s'] = "";	$md_type['10']['db'] = "menu";
$md_type['20']['t'] = $tl_[$l]['md_type2'];	$md_type['20']['s'] = "";	$md_type['20']['db'] = "caligraph";
$md_type['30']['t'] = $tl_[$l]['md_type3'];	$md_type['30']['s'] = "";	$md_type['30']['db'] = "1_div";
$md_type['40']['t'] = $tl_[$l]['md_type4'];	$md_type['40']['s'] = "";	$md_type['40']['db'] = "elegance";
$md_type['50']['t'] = $tl_[$l]['md_type5'];	$md_type['50']['s'] = "";	$md_type['50']['db'] = "exquisite";
$md_type['60']['t'] = $tl_[$l]['md_type6'];	$md_type['60']['s'] = "";	$md_type['60']['db'] = "elysion";

switch ( $_REQUEST['uni_gestion_des_decorations_p'] ) { 
case 2:	
	$pv['o1l32'] = $md_type[$DEC['deco_type']]['db'] . "<input type='hidden' name='M_DECORA[type]'	value='".$md_type[$DEC['deco_type']]['db']."'>\r";
	$_REQUEST['deco_type_db'] = $md_type[$DEC['deco_type']]['db'];
	$pv['deco_type_backup'] = $DEC['deco_type'];
	switch ( $DEC['deco_type'] ) {
	case 10:	$_REQUEST['deco_repertoire'] = ${$theme_tableau}['B01M']['deco_repertoire'];	break;
	case 20:	$_REQUEST['deco_repertoire'] = ${$theme_tableau}['B02T']['deco_repertoire'];	break;
	case 30:	$_REQUEST['deco_repertoire'] = ${$theme_tableau}['B03G']['deco_repertoire'];	break;
	case 40:	$_REQUEST['deco_repertoire'] = ${$theme_tableau}['B04G']['deco_repertoire'];	break;
	case 50:	$_REQUEST['deco_repertoire'] = ${$theme_tableau}['B05G']['deco_repertoire'];	break;
	case 60:	$_REQUEST['deco_repertoire'] = ${$theme_tableau}['B06G']['deco_repertoire'];	break;
	}
break;
case 3:
	$GDS_mode = "creation";
	$pv['o1l32'] = "<select name='M_DECORA[type]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'
	onChange=\"SelectOngletDeco( 'formulaire_gdd' , 'M_DECORA[type]' , 'type1', 'deco' );\"
	>\r";
	//unset ( $A ); reset ( $md_type );
	foreach ( $md_type as $A ) { $pv['o1l32'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
	unset ( $A );
	$pv['o1l32'] .= "</select>\r";
	$_REQUEST['deco_repertoire'] = "one";
	$DEC['deco_name'] = "deco_". date ( "Y_m_j_-_G_i_s", mktime() );
break;
}

$theme_tableau = "theme_princ_";
$theme_tableau_a_ecrire = "theme_princ_";

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "GDGestionRepertoire();";
$fsi['formulaire']				= "formulaire_gdd";
$fsi['champs']					= "M_DECORA[repertoire]";
$fsi['lsdf_chemin']				= "../media/theme/";
$fsi['mode_selection']			= "repertoire";
$fsi['lsdf_mode']				= "repertoire";
$fsi['lsdf_nivmax']				= 0;
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 1;
$fsi['lsdf_conserve_chemin']	= "";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']			= array();
$pv['o1l42'] = generation_icone_selecteur_fichier ( 3 , $_REQUEST['deco_repertoire'] , $fsi['formulaire'] , $fsi['champs'] , 20 , $_REQUEST['deco_repertoire'] , "TabSDF_".$fsi['lsdf_indicatif'] );


// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
$tl_['fra']['o1l11'] = "Nom";				$tl_['eng']['o1l11'] = "Name";
$tl_['fra']['o1l21'] = "Etat";				$tl_['eng']['o1l21'] = "State";
$tl_['fra']['o1l31'] = "Type";				$tl_['eng']['o1l31'] = "Type";
$tl_['fra']['o1l41'] = "R&eacute;pertoire";	$tl_['eng']['o1l41'] = "Directory";

$tl_['eng']['md_etat1'] = "Offline";	$tl_['fra']['md_etat1'] = "Hors ligne";
$tl_['eng']['md_etat2'] = "Online";		$tl_['fra']['md_etat2'] = "En ligne";

unset ( $md_etat);
$md_etat['0']['t'] = $tl_[$l]['md_etat1'];		$md_etat['0']['s'] = "";	$md_etat['0']['db'] = "OFFLINE";
$md_etat['1']['t'] = $tl_[$l]['md_etat2'];		$md_etat['1']['s'] = "";	$md_etat['1']['db'] = "ONLINE";

//outil_debug ( $DEC['deco_state'] , "DEC['deco_state']");
//outil_debug ( $md_etat , "md_etat");

//if ( $DEC['deco_state'] < 0 && $DEC['deco_state'] > 2 ) { $DEC['deco_state'] = 1; }
$md_etat[$DEC['deco_state']]['s'] = " selected";
$pv['o1l22'] = "<select name='M_DECORA[etat]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $md_etat as $A ) { $pv['o1l22'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
unset ( $A );
$pv['o1l22'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
$tl_['eng']['invite1'] = "This part will allow you to modify a decoration.";
$tl_['fra']['invite1'] = "Cette partie va vous permettre de modifier une d&eacute;coration.";

switch ( $_REQUEST['uni_gestion_des_decorations_p'] ) { 
case 2:
	if ( $_REQUEST['M_DECORA']['confirmation_modification_oubli'] == 1 ) { 
		$tl_['eng']['err'] = "You didn't confirm the decoration updates.";
		$tl_['fra']['err'] = "Vous n'avez pas confirm&eacute; la modification de la d&eacute;coration.";
		echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur'>".$tl_[$l]['err']."<br>\r"); 
	}

	if ( $_REQUEST['M_DECORA']['modification_effectuee'] == 1 ) { 
		$tl_['eng']['err1'] = "The decoration named ".$document['docu_name']." has been updated.";
		$tl_['fra']['err1'] = "La d&eacute;coration ".$document['docu_name']." a &eacute;t&eacute; mise a jour.";
		echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>".$tl_[$l]['err1']."</p>\r"); 
	}
	$tl_['eng']['bouton1'] = "Modify a decoration";
	$tl_['fra']['bouton1'] = "Modifier une d&eacute;coration";
	$bloc_html['UPDATE_action'] = "<input type='hidden' name='UPDATE_action'		value='UPDATE_DECORATION'>\r";
break;
case 3:
	$tl_['eng']['bouton1'] = "Create a decoration";
	$tl_['fra']['bouton1'] = "Cr&eacute;er une d&eacute;coration";
	$bloc_html['UPDATE_action'] = "<input type='hidden' name='UPDATE_action'		value='ADD_DECORATION'>\r";
break;
}

echo ("
<form ACTION='index.php?' method='post' name='formulaire_gdd'>\r
<p>
".$tl_[$l]['invite1']."<br>\r
</p>\r
");

$AD['1']['1']['1']['cont'] = $tl_[$l]['o1l11'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['o1l21'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['o1l31'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['o1l41'];

if ( $GDS_mode != "creation" ) { $pv['deco_name_form'] = " readonly "; }
$AD['1']['1']['2']['cont'] = "<input type='text'  ".$pv['deco_name_form']." name='M_DECORA[nom]' size='35' maxlength='255' value='".$DEC['deco_name']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['1']['2']['2']['cont'] = $pv['o1l22'];
$AD['1']['3']['2']['cont'] = $pv['o1l32'];
$AD['1']['4']['2']['cont'] = $pv['o1l42'];

$ADC['tabs']['1']['NbrOfLines'] = 4;
$ADC['tabs']['1']['NbrOfCells'] = 2;
$ADC['tabs']['1']['TableCaptionPos'] = 2;

$tl_['eng']['onglet1'] = "Informations";
$tl_['fra']['onglet1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 192;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_internal_width'] -16 ;
$tab_infos['group']			= "md_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("engine/affichage_donnees.php");



//echo ("</div>\r");
// --------------------------------------------------------------------------------------------
//	debut du blocs
// --------------------------------------------------------------------------------------------
$tab_infos['nbr'] = 1;
$tl_['eng']['cell_1_txt']	= "Decoration";	$tl_['fra']['cell_1_txt'] = "D&eacute;coration";
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['doc_height']		= 548;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_internal_width'] -16;
$tab_infos['group']			= "type1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "deco";
$tab_infos['cell_1_txt']		= $tl_[$l]['cell_1_txt'];
//$theme_SW_['tab_interieur']	= ${$theme_tableau}['theme_module_internal_width'] -16;
$tab_infos['visible']			= "visible";
genere_onglet_html ();

switch ( $_REQUEST['uni_gestion_des_decorations_p'] ) { 
case 2:
	switch ( $DEC['deco_type'] ) { 
	case 10:		$tab_infos['premier'] = 1;	break;
	case 20:		$tab_infos['premier'] = 2;	break;
	case 30:		$tab_infos['premier'] = 3;	break;
	case 40:		$tab_infos['premier'] = 4;	break;
	case 50:		$tab_infos['premier'] = 5;	break;
	case 60:		$tab_infos['premier'] = 6;	break;
	}
	$tab_infos['nbr'] = $tab_infos['premier'];
break;
case 3:
	$tab_infos['nbr'] = 6;
	$tab_infos['premier'] = 1;
	$pv['blockselection']['1']	= "B01M";	
	$pv['blockselection']['2']	= "B02T";	
	$pv['blockselection']['3']	= "B03G";	
	$pv['blockselection']['4']	= "B04G";	
	$pv['blockselection']['5']	= "B05G";	
	$pv['blockselection']['6']	= "B06G";	
break;
}

$_REQUEST['sauvegarde']['_REQUEST_bloc_01'] = $_REQUEST['bloc'];
$theme_GD_['background_image'] = "../media/theme/".$theme_GD_['theme_directory']."/".$theme_GD_['theme_bg'];

echo ("<div id='decoration_principal' class='" . $theme_tableau . $_REQUEST['bloc']."_fco' style='width: ".( ${$theme_tableau}['theme_module_internal_width'] - 24 ) ."px; height: ".$tab_infos['doc_height']."px; overflow: hidden;' >\r");
for ( $pv['i'] = $tab_infos['premier'] ; $pv['i'] <= $tab_infos['nbr'] ; $pv['i']++ ) { 

	$theme_GD_['background_image'] = "../media/theme/".$theme_GD_['theme_directory']."/".$theme_GD_['theme_bg'];
	$pv['module_ecart_bordure_x'] = 128;
	$pv['module_ecart_bordure_y'] = 32;
	$pv['bloc_taille_y'] = "height: " . 320 ."px; ";
	$pv['TabNom']['menu']		= 1	;		$pv['TabCon']['1']	=	"menu";
	$pv['TabNom']['caligraph']	= 2	;		$pv['TabCon']['2']	=	"caligraph";
	$pv['TabNom']['1_div']		= 3 ;		$pv['TabCon']['3']	=	"1_div";
	$pv['TabNom']['elegance']	= 4	;		$pv['TabCon']['4']	=	"elegance";
	$pv['TabNom']['exquisite']	= 5	;		$pv['TabCon']['5']	=	"exquisite";
	$pv['TabNom']['elysion']	= 6	;		$pv['TabCon']['6']	=	"elysion";

	$_REQUEST['blocN'] = decoration_nomage_bloc ( "B", $pv['i'] , "");
	$_REQUEST['blocT'] = decoration_nomage_bloc ( "B", $pv['i'] , "T");
	$_REQUEST['blocG'] = decoration_nomage_bloc ( "B", $pv['i'] , "G");
	$_REQUEST['blocM'] = decoration_nomage_bloc ( "B", $pv['i'] , "M");

	switch ( $_REQUEST['uni_gestion_des_decorations_p'] ) { 
	case 2:
		// outil_debug ( $theme_GD_['B01M'] , "theme_GD_['B01M']" ) ;
		switch ( $DEC['deco_type'] ) { 
		case 10:	$_REQUEST['bloc'] = $_REQUEST['blocM'];	break;
		case 20:	$_REQUEST['bloc'] = $_REQUEST['blocT'];	break;
		default:	$_REQUEST['bloc'] = $_REQUEST['blocG'];	break;
		}
	break;
	case 3:
		$tab_infos['visible'] = "visible";
		if ( $pv['i'] > 1 ) { $tab_infos['visible'] = "hidden"; }
		$_REQUEST['bloc'] = $pv['blockselection'][$pv['i']];	
		$DEC['deco_type'] = $pv['i']*10;
		// outil_debug ( $_REQUEST['bloc'] , "_REQUEST['bloc']" ) ;
		// outil_debug ( $DEC['deco_type'] , "DEC['deco_type']" ) ;
	break;
	}

	$GD_module_['module_name'] = "Bloc_GD_". $pv['TabCon'][$pv['i']]; 
	$mn = &$GD_module_['module_name'];

	switch ( $DEC['deco_type'] ) {
	case 10:	
	case "menu":
	case 20:	
	case "caligraph":	
		$GD_pres_[$mn]['px'] = 0;
		$GD_pres_[$mn]['py'] = 0;
		$GD_pres_[$mn]['dx'] = 0;
		$GD_pres_[$mn]['dy'] = 0;
		$pv['bloc_taille_y'] = "height: " . 480 ."px; ";
	break;
	default:
		$GD_pres_[$mn]['px'] = $pv['module_ecart_bordure_x'];
		$GD_pres_[$mn]['py'] = $pv['module_ecart_bordure_y'];
		$GD_pres_[$mn]['dx'] = (${$theme_tableau}['theme_module_internal_width'] - ($pv['module_ecart_bordure_x']*2));
		$GD_pres_[$mn]['dy'] = $pv['bloc_taille_y'] - ($pv['module_ecart_bordure_y'] * 2);
	break;
	}

	$pv['div_id'] = $tab_infos['group'] . "_" . $tab_infos['document'] . "_" . $pv['TabCon'][$pv['i']];
	echo ("
	<div id='".$pv['div_id']."' class='css_".$pv['div_id']."' 
	style='position: absolute; visibility: ".$tab_infos['visible']."; 
	width: ".(${$theme_tableau}['theme_module_internal_width'] - 24)."px; 
	height: ".$tab_infos['doc_height']."px; 
	background-image: url(".$theme_GD_['background_image']."); 
	overflow:auto'>

	<table style='width:100%'>\r
	<tr>\r
	<td style='".$pv['bloc_taille_y']." vertical-align:top;'>\r
	");

	if ( $pv['i'] == 2 ) { $_REQUEST['bloc'] = $_REQUEST['blocT']; }
	else { $_REQUEST['bloc'] = $_REQUEST['blocG']; }

	echo ("\r<!-- decoration = ".$theme_GD_[$_REQUEST['bloc']]['deco_type']."! -->\r\r");
	// outil_debug ( $GD_pres_[$mn] , "GD_pres_[$mn]" );
	switch ( $DEC['deco_type'] ) {
	case 10:	
	case "menu":
		$_REQUEST['bloc'] = $_REQUEST['blocN'];	
		$tab_infos_bakup = array();
		foreach ( $tab_infos as $K => $V ) { $tab_infos_bakup[$K] = $V; }
//		$pv['div_compteur_2'] = 1;
		include ("engine/module_deco_10_menu_decoration.php");
		foreach ( $tab_infos_bakup as $K => $V ) { $tab_infos[$K] = $V; }
		unset ($tab_infos_bakup, $K, $V );
		TJLM_insertion ( 1 , $j , $GD_module_['module_name'] , 'formulaire_gdd' );
		//$JavaScriptInitCommandes[] = "CalculeDecoModule ( '".$md_type[$pv['deco_type_backup']]['db']."' , '".$mn."' , 'formulaire_gdd' );";
	echo ("
	</td>\r
	</tr>\r
	</table>\r
	</div>\r
	");
	break;

	// --------------------------------------------------------------------------------------------
	case 20:	
	case "caligraph":	
		$tab_infos_bakup = array();
		unset ( $K, $V );
		foreach ( $tab_infos as $K => $V ) { $tab_infos_bakup[$K] = $V; }
		$pv['backup_bloc'] = $_REQUEST['bloc'];
		$_REQUEST['bloc'] = $_REQUEST['blocN'];	
		//$pv['div_compteur_2'] = 1;
		include ("engine/module_deco_20_caligraph_decoration.php");
		unset ( $K, $V );
		foreach ( $tab_infos_bakup as $K => $V ) { $tab_infos[$K] = $V; }
		unset ($tab_infos_bakup, $K, $V );
		TJLM_insertion ( 2 , $j , $GD_module_['module_name'] , 'formulaire_gdd' );
		$_REQUEST['bloc'] = $pv['backup_bloc'];
	echo ("
	</td>\r
	</tr>\r
	</table>\r
	</div>\r
	");
	break;
	// --------------------------------------------------------------------------------------------
	case 30:	
	case "1_div":
		function ligne_formulaire_deco_1div ( $titre , $input , $bord , $tous ) {
			global $GD_module_, $pv;

			if ( $tous == 1 ) {
				$allWidth = "
				modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$GD_module_['module_name']."_blw]' , this.value );
				modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$GD_module_['module_name']."_brw]' , this.value );
				modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$GD_module_['module_name']."_btw]' , this.value );
				modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$GD_module_['module_name']."_bbw]' , this.value );
				";
				//M_DECORA[".$GD_module_['module_name']."_".$div."_dimx]
				$allStyle = "
				modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$GD_module_['module_name']."_bls]' , this.value );
				modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$GD_module_['module_name']."_brs]' , this.value );
				modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$GD_module_['module_name']."_bts]' , this.value );
				modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$GD_module_['module_name']."_bbs]' , this.value );
				";
			}

			switch ( $bord ) {
			case "Top":		$label = "border_top";		break;
			case "Left":	$label = "border_left";		break;
			case "Right":	$label = "border_right";	break;
			case "Bottom":	$label = "border_bottom";	break;
			}
			if ( !$pv['deco_'.$label.'_width_1_div'] ) { $pv['deco_'.$label.'_width_1_div'] = $pv['border_all_width_1_div']; }
			if ( strlen($pv['deco_'.$label.'_color_1_div']) == 0 ) { $pv['deco_'.$label.'_color_1_div'] = $pv['border_all_color_1_div']; }
			if ( strlen($pv['deco_'.$label.'_style_1_div']) == 0 ) { $pv['deco_'.$label.'_style_1_div'] = $pv['border_all_style_1_div']; }

			echo ("
			<tr>\r
			<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta'>".$titre."</td>\r
			".$_REQUEST['td_fca']."
			<input type='text' name='M_DECORA[".$GD_module_['module_name']."_".$input."w]' id='M_DECORA[".$GD_module_['module_name']."_".$input."w]' size='3' maxlength='3' 
			value='".str_replace("#" , "" , $pv['deco_'.$label.'_width_1_div'])."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1' onChange=\"".$allWidth." GestionDecorationOneDiv ();\">\rpx
			</td>\r
			".$_REQUEST['td_fca']."
			<select name='M_DECORA[".$GD_module_['module_name']."_".$input."s]' id='M_DECORA[".$GD_module_['module_name']."_".$input."s]' onChange=\"".$allStyle." GestionDecorationOneDiv ();\">\r
			<option value='solid'>solid</option>\r
			<option value='none'>none</option>\r
			<option value='dotted'>dotted</option>\r
			<option value='dashed'>dashed</option>\r
			<option value='double'>double</option>\r
			<option value='groove'>groove</option>\r
			<option value='ridge'>ridge</option>\r
			<option value='inset'>inset</option>\r
			<option value='outset'>outset</option>\r
			</select>\r
			</td>\r
			".$_REQUEST['td_fca']."
			#<input type='text' name='M_DECORA[".$GD_module_['module_name']."_".$input."c]' id='M_DECORA[".$GD_module_['module_name']."_".$input."c]' size='5' maxlength='6' value='".str_replace("#" , "" , $pv['deco_'.$label.'_color_1_div'])."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
			</td>\r
			</tr>\r
			");
			TJED_insertion ( "M_DECORA[".$GD_module_['module_name']."_".$input."w]" , $GD_module_['module_name'] , "border".$bord."Width" , "GestionDecorationOneDiv" );
			TJED_insertion ( "M_DECORA[".$GD_module_['module_name']."_".$input."s]" , $GD_module_['module_name'] , "border".$bord."Style" , "GestionDecorationOneDiv" );
			TJED_insertion ( "M_DECORA[".$GD_module_['module_name']."_".$input."c]" , $GD_module_['module_name'] , "border".$bord."Color" , "GestionDecorationOneDiv" );

			$pv['TabTJED'][] = "M_DECORA[".$GD_module_['module_name']."_".$input."c]";
		}

		if ( !function_exists("module_deco_30_1_div") ) { include ("engine/module_deco_30_1_div.php"); }		
		$_REQUEST['div_id']['un_div'] = "id='".$GD_module_['module_name']. "'";		
		$_REQUEST['bloc'] = $_REQUEST['blocN'];
		module_deco_30_1_div ("theme_GD_" , "GD_pres_" , "GD_module_", 0 );		

		$tl_['eng']['md_bl'] = "Left";			$tl_['eng']['md_br'] = "Right";			$tl_['eng']['md_bt'] = "Top";		$tl_['eng']['md_bb'] = "Bottom";
		$tl_['fra']['md_bl'] = "Gauche";	$tl_['fra']['md_br'] = "Droite";	$tl_['fra']['md_bt'] = "Haut";	$tl_['fra']['md_bb'] = "Bas";
		$tl_['eng']['md_all'] = "all";			$tl_['fra']['md_all'] = "Tous";

		$tl_['eng']['md_bw'] = "Border Width";		$tl_['fra']['md_bw'] = "Epaisseur de bordure";
		$tl_['eng']['md_bs'] = "Border Style";		$tl_['fra']['md_bs'] = "Style de bordure";
		$tl_['eng']['md_bc'] = "Border Color";		$tl_['fra']['md_bc'] = "Couleur de bordure";

		$tl_['eng']['md_bgc'] = "Background color";		$tl_['fra']['md_bgc'] = "Couleur de fond";
		$tl_['eng']['md_bgi'] = "Background image";		$tl_['fra']['md_bgi'] = "Image de fond";

		$pv['60pc'] = floor(${$theme_tableau}['theme_module_internal_width'] * 0.6);
		$pv['decalage_60pc'] = floor( ( ${$theme_tableau}['theme_module_internal_width'] - $pv['60pc'] ) /2 );
		// outil_debug ( $pv['60pc'] , "pv['60pc']" );

		echo ("
		</div>\r
		</td>\r
		</tr>\r

		<tr>\r
		<td style='background-image: url(../media/img/universal/noir_50prct.png);'>\r
			<table style='
			width:".$pv['60pc']."px; 
			margin-left:".$pv['decalage_60pc']."px;
			'>\r
			<tr>\r
			<td></td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_bw']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_bs']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_bc']."</td>\r
			</tr>\r
			");

			ligne_formulaire_deco_1div ( $tl_[$l]['md_all']	, "all"	, "all" 	,	1 );
			ligne_formulaire_deco_1div ( $tl_[$l]['md_bt']	, "bt"	, "Top" 	,	0 );
			ligne_formulaire_deco_1div ( $tl_[$l]['md_bl']	, "bl"	, "Left"	,	0 );
			ligne_formulaire_deco_1div ( $tl_[$l]['md_br']	, "br"	, "Right"	,	0 );
			ligne_formulaire_deco_1div ( $tl_[$l]['md_bb']	, "bb"	, "Bottom"	,	0 );

			echo ("
			</tr>\r
			<td colspan='4' class='".$theme_tableau.$_REQUEST['bloc']."_fca'>\r
			".$tl_[$l]['md_bgc']."
			#<input type='text' name='M_DECORA[".$GD_module_['module_name']."_bgc]' id='M_DECORA[".$GD_module_['module_name']."_bgc]' size='5' maxlength='6' value='555555' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'
			onChange=\"elm.Gebi('".$GD_module_['module_name']."').style.backgroundColor = '#'+this.value;\"
			>\r
			</td>\r
			</tr>\r

			<tr>\r
			<td colspan='4' class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>\r
			". $tl_[$l]['md_bgi'] .
			generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$GD_module_['module_name']."_bgi]" , 0, 0, "M_DECORA[repertoire]" , $pv['deco_background_url_1_div'] , $GD_module_['module_name'] , "GestionDecorationOneDiv" , 1 )
			. "
			</td>\r
			</tr>\r
			</table>\r

		</td>\r
		</tr>\r
		</table>\r
		</div>\r
		");

		TJED_insertion ( "M_DECORA[".$GD_module_['module_name']."_bgc]" , $GD_module_['module_name'] , "backgroundColor" , "GestionDecorationOneDiv" );
		TJED_insertion ( "M_DECORA[".$GD_module_['module_name']."_bgi]" , $GD_module_['module_name'] , "backgroundImage" , "GestionDecorationOneDiv" );
		TJLM_insertion ( 3 , $j , $GD_module_['module_name'] , 'formulaire_gdd' );

	break;
	// --------------------------------------------------------------------------------------------
	case 40:	
	case "elegance":
		if ( !function_exists("module_deco_40_elegance") ) { include ("engine/module_deco_40_elegance.php"); }
		$_REQUEST['bloc'] = $_REQUEST['blocN'];
		$_REQUEST['div_id']['ex11'] = "id='".$GD_module_['module_name']."_ex11'";
		$_REQUEST['div_id']['ex12'] = "id='".$GD_module_['module_name']."_ex12'";
		$_REQUEST['div_id']['ex13'] = "id='".$GD_module_['module_name']."_ex13'";

		$_REQUEST['div_id']['ex21'] = "id='".$GD_module_['module_name']."_ex21'";
		$_REQUEST['div_id']['ex22'] = "id='".$GD_module_['module_name']."_ex22'";
		$_REQUEST['div_id']['ex23'] = "id='".$GD_module_['module_name']."_ex23'";

		$_REQUEST['div_id']['ex31'] = "id='".$GD_module_['module_name']."_ex31'";
		$_REQUEST['div_id']['ex32'] = "id='".$GD_module_['module_name']."_ex32'";
		$_REQUEST['div_id']['ex33'] = "id='".$GD_module_['module_name']."_ex33'";

		module_deco_40_elegance ("theme_GD_" , "GD_pres_" , "GD_module_", 0 );
		creation_tableau_javascript ( $mn );

		$tl_['eng']['md_dimx'] = "Width";					$tl_['fra']['md_dimx'] = "Largeur";
		$tl_['eng']['md_dimy'] = "Height";					$tl_['fra']['md_dimy'] = "Hauteur";
		$tl_['eng']['md_image'] = "Background";				$tl_['fra']['md_image'] = "Image de fond";
		$tl_['eng']['md_align'] = "Alignment";				$tl_['fra']['md_align'] = "Alignement";
		$tl_['eng']['md_bgp'] = "Background position";		$tl_['fra']['md_bgp'] = "Positionnement";

		echo ("
		</div>\r
		</td>\r
		</tr>\r

		<tr>\r
		<td style='background-image: url(../media/img/universal/noir_50prct.png);'>\r
			<table style='
			width:".$pv['60pc']."px; 
			margin-left:".$pv['decalage_60pc']."px;
			'>\r

			<tr>\r
			<td></td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_dimx']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_dimy']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_image']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_bgp']."</td>\r
			</tr>\r
			");

			ligne_formulaire_deco_graphique ( "ex11" , "EX 11", 1,1,1,1, "elegance");
			ligne_formulaire_deco_graphique ( "ex12" , "EX 12", 0,1,1,1, "elegance");
			ligne_formulaire_deco_graphique ( "ex13" , "EX 13", 1,1,1,1, "elegance");

			ligne_formulaire_deco_graphique ( "ex21" , "EX 21", 1,0,1,1, "elegance");
			ligne_formulaire_deco_graphique ( "ex22" , "EX 22", 0,0,1,1, "elegance");
			ligne_formulaire_deco_graphique ( "ex23" , "EX 23", 1,0,1,1, "elegance");

			ligne_formulaire_deco_graphique ( "ex31" , "EX 31", 1,1,1,1, "elegance");
			ligne_formulaire_deco_graphique ( "ex32" , "EX 32", 0,1,1,1, "elegance");
			ligne_formulaire_deco_graphique ( "ex33" , "EX 33", 1,1,1,1, "elegance");

			echo ("
			</table>\r
			</td>\r
			</tr>\r
		</table>\r
		</div>\r
		");
		TJLM_insertion ( 3 , 'elegance' , $GD_module_['module_name'] , 'formulaire_gdd' );
	break;

	// --------------------------------------------------------------------------------------------
	case 50:	
	case "exquisite":		
		if ( !function_exists("module_deco_50_exquise") ) { include ("engine/module_deco_50_exquisite.php"); }	

		$_REQUEST['bloc'] = $_REQUEST['blocN'];
		$_REQUEST['div_id']['ex11'] = "id='".$GD_module_['module_name']."_ex11'";
		$_REQUEST['div_id']['ex12'] = "id='".$GD_module_['module_name']."_ex12'";
		$_REQUEST['div_id']['ex13'] = "id='".$GD_module_['module_name']."_ex13'";
		$_REQUEST['div_id']['ex14'] = "id='".$GD_module_['module_name']."_ex14'";
		$_REQUEST['div_id']['ex15'] = "id='".$GD_module_['module_name']."_ex15'";

		$_REQUEST['div_id']['ex21'] = "id='".$GD_module_['module_name']."_ex21'";
		$_REQUEST['div_id']['ex22'] = "id='".$GD_module_['module_name']."_ex22'";
		$_REQUEST['div_id']['ex25'] = "id='".$GD_module_['module_name']."_ex25'";

		$_REQUEST['div_id']['ex31'] = "id='".$GD_module_['module_name']."_ex31'";
		$_REQUEST['div_id']['ex35'] = "id='".$GD_module_['module_name']."_ex35'";

		$_REQUEST['div_id']['ex41'] = "id='".$GD_module_['module_name']."_ex41'";
		$_REQUEST['div_id']['ex45'] = "id='".$GD_module_['module_name']."_ex45'";

		$_REQUEST['div_id']['ex51'] = "id='".$GD_module_['module_name']."_ex51'";
		$_REQUEST['div_id']['ex52'] = "id='".$GD_module_['module_name']."_ex52'";
		$_REQUEST['div_id']['ex53'] = "id='".$GD_module_['module_name']."_ex53'";
		$_REQUEST['div_id']['ex54'] = "id='".$GD_module_['module_name']."_ex54'";
		$_REQUEST['div_id']['ex55'] = "id='".$GD_module_['module_name']."_ex55'";

		module_deco_50_exquise ("theme_GD_" , "GD_pres_" , "GD_module_", 0 );	
		creation_tableau_javascript ( $mn );

		$tl_['eng']['md_dimx'] = "Width";					$tl_['fra']['md_dimx'] = "Largeur";
		$tl_['eng']['md_dimy'] = "Height";					$tl_['fra']['md_dimy'] = "Hauteur";
		$tl_['eng']['md_image'] = "Background";				$tl_['fra']['md_image'] = "Image de fond";
		$tl_['eng']['md_align'] = "Alignment";				$tl_['fra']['md_align'] = "Alignement";
		$tl_['eng']['md_bgp'] = "background-position";		$tl_['fra']['md_bgp'] = "Positionnement";

		echo ("
		</div>\r
		</td>\r
		</tr>\r

		<tr>\r
		<td style='background-image: url(../media/img/universal/noir_50prct.png);'>\r
			<table style='
			width:".$pv['60pc']."px; 
			margin-left:".$pv['decalage_60pc']."px;
			'>\r

			<tr>\r
			<td></td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_dimx']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_dimy']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_image']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_bgp']."</td>\r
			</tr>\r
			");

			ligne_formulaire_deco_graphique ( "ex11" , "EX 11", 1,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex12" , "EX 12", 1,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex13" , "EX 13", 0,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex14" , "EX 14", 1,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex15" , "EX 15", 1,1,1,1, "exquise");

			ligne_formulaire_deco_graphique ( "ex21" , "EX 21", 1,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex22" , "EX 22", 0,0,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex25" , "EX 25", 1,1,1,1, "exquise");

			ligne_formulaire_deco_graphique ( "ex31" , "EX 31", 1,0,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex35" , "EX 35", 1,0,1,1, "exquise");

			ligne_formulaire_deco_graphique ( "ex41" , "EX 41", 1,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex45" , "EX 45", 1,1,1,1, "exquise");

			ligne_formulaire_deco_graphique ( "ex51" , "EX 51", 1,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex52" , "EX 52", 1,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex53" , "EX 53", 0,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex54" , "EX 54", 1,1,1,1, "exquise");
			ligne_formulaire_deco_graphique ( "ex55" , "EX 55", 1,1,1,1, "exquise");

			echo ("
			</table>\r
			</td>\r
			</tr>\r
		</table>\r
		</div>\r
		");
		TJLM_insertion ( 3 , 'exquise' , $GD_module_['module_name'] , 'formulaire_gdd' );
	echo ("</div>\r");
	break;

	// --------------------------------------------------------------------------------------------
	case 60:	
	case "elysion":
		if ( !function_exists("module_deco_60_elysion") ) { include ("engine/module_deco_60_elysion.php"); }

		$_REQUEST['bloc'] = $_REQUEST['blocN'];
		$_REQUEST['div_id']['ex11'] = "id='".$GD_module_['module_name']."_ex11'";
		$_REQUEST['div_id']['ex12'] = "id='".$GD_module_['module_name']."_ex12'";
		$_REQUEST['div_id']['ex13'] = "id='".$GD_module_['module_name']."_ex13'";
		$_REQUEST['div_id']['ex14'] = "id='".$GD_module_['module_name']."_ex14'";
		$_REQUEST['div_id']['ex15'] = "id='".$GD_module_['module_name']."_ex15'";
		$_REQUEST['div_id']['ex21'] = "id='".$GD_module_['module_name']."_ex21'";
		$_REQUEST['div_id']['ex22'] = "id='".$GD_module_['module_name']."_ex22'";
		$_REQUEST['div_id']['ex25'] = "id='".$GD_module_['module_name']."_ex25'";
		$_REQUEST['div_id']['ex31'] = "id='".$GD_module_['module_name']."_ex31'";
		$_REQUEST['div_id']['ex35'] = "id='".$GD_module_['module_name']."_ex35'";
		$_REQUEST['div_id']['ex41'] = "id='".$GD_module_['module_name']."_ex41'";
		$_REQUEST['div_id']['ex45'] = "id='".$GD_module_['module_name']."_ex45'";
		$_REQUEST['div_id']['ex51'] = "id='".$GD_module_['module_name']."_ex51'";
		$_REQUEST['div_id']['ex52'] = "id='".$GD_module_['module_name']."_ex52'";
		$_REQUEST['div_id']['ex53'] = "id='".$GD_module_['module_name']."_ex53'";
		$_REQUEST['div_id']['ex54'] = "id='".$GD_module_['module_name']."_ex54'";
		$_REQUEST['div_id']['ex55'] = "id='".$GD_module_['module_name']."_ex55'";

		$_REQUEST['div_id']['in11'] = "id='".$GD_module_['module_name']."_in11'";
		$_REQUEST['div_id']['in12'] = "id='".$GD_module_['module_name']."_in12'";
		$_REQUEST['div_id']['in13'] = "id='".$GD_module_['module_name']."_in13'";
		$_REQUEST['div_id']['in14'] = "id='".$GD_module_['module_name']."_in14'";
		$_REQUEST['div_id']['in15'] = "id='".$GD_module_['module_name']."_in15'";
		$_REQUEST['div_id']['in21'] = "id='".$GD_module_['module_name']."_in21'";
		$_REQUEST['div_id']['in25'] = "id='".$GD_module_['module_name']."_in25'";
		$_REQUEST['div_id']['in31'] = "id='".$GD_module_['module_name']."_in31'";
		$_REQUEST['div_id']['in35'] = "id='".$GD_module_['module_name']."_in35'";
		$_REQUEST['div_id']['in41'] = "id='".$GD_module_['module_name']."_in41'";
		$_REQUEST['div_id']['in45'] = "id='".$GD_module_['module_name']."_in45'";
		$_REQUEST['div_id']['in51'] = "id='".$GD_module_['module_name']."_in51'";
		$_REQUEST['div_id']['in52'] = "id='".$GD_module_['module_name']."_in52'";
		$_REQUEST['div_id']['in53'] = "id='".$GD_module_['module_name']."_in53'";
		$_REQUEST['div_id']['in54'] = "id='".$GD_module_['module_name']."_in54'";
		$_REQUEST['div_id']['in55'] = "id='".$GD_module_['module_name']."_in55'";

		module_deco_60_elysion ("theme_GD_" , "GD_pres_" , "GD_module_", 0 );
		creation_tableau_javascript ( $mn );

		$tl_['eng']['md_dimx'] = "Width";					$tl_['fra']['md_dimx'] = "Largeur";
		$tl_['eng']['md_dimy'] = "Height";					$tl_['fra']['md_dimy'] = "Hauteur";
		$tl_['eng']['md_image'] = "Background";				$tl_['fra']['md_image'] = "Image de fond";
		$tl_['eng']['md_align'] = "Alignment";				$tl_['fra']['md_align'] = "Alignement";
		$tl_['eng']['md_bgp'] = "background-position";		$tl_['fra']['md_bgp'] = "Positionnement";

		echo ("
		</div>\r
		</td>\r
		</tr>\r

		<tr>\r
		<td style='background-image: url(../media/img/universal/noir_50prct.png);'>\r
			<table style='
			width:".$pv['60pc']."px; 
			margin-left:".$pv['decalage_60pc']."px;
			'>\r

			<tr>\r
			<td></td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_dimx']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_dimy']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_image']."</td>\r".
			$_REQUEST['td_fcta'].$tl_[$l]['md_bgp']."</td>\r
			</tr>\r
			");

			ligne_formulaire_deco_graphique ( "ex11" , "EX 11", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex12" , "EX 12", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex13" , "EX 13", 0,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex14" , "EX 14", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex15" , "EX 15", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex21" , "EX 21", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex22" , "EX 22", 0,0,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex25" , "EX 25", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex31" , "EX 31", 1,0,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex35" , "EX 35", 1,0,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex41" , "EX 41", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex45" , "EX 45", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex51" , "EX 51", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex52" , "EX 52", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex53" , "EX 53", 0,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex54" , "EX 54", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "ex55" , "EX 55", 1,1,1,1, "elysion" );

			ligne_formulaire_deco_graphique ( "in11" , "IN 11", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in12" , "IN 12", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in13" , "IN 13", 0,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in14" , "IN 14", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in15" , "IN 15", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in21" , "IN 21", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in25" , "IN 25", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in31" , "IN 31", 1,0,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in35" , "IN 35", 1,0,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in41" , "IN 41", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in45" , "IN 45", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in51" , "IN 51", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in52" , "IN 52", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in53" , "IN 53", 0,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in54" , "IN 54", 1,1,1,1, "elysion" );
			ligne_formulaire_deco_graphique ( "in55" , "IN 55", 1,1,1,1, "elysion" );

			echo ("
			</table>\r
			</td>\r
			</tr>\r
		</table>\r
		</div>\r
		");
		TJLM_insertion ( 3 , 'elysion' , $GD_module_['module_name'] , 'formulaire_gdd' );
	echo ("</div>\r");
	break;
	default:
	/*
		//echo ("<div id='$mn' class='" . $theme_tableau . $_REQUEST['bloc']."_div_std' style='position:absolute; left:".$pres_[$mn]['px']."px; top:".$pres_[$mn]['py']."px; width:".$pres_[$mn]['dx']."px; height:".$pres_[$mn]['dy']."px; '>\r
		?!?!?! \r
		ERR sur numero $pv['i'] <br>\r
		Bloc : $_REQUEST['bloc'] <br>\r
		GD_module_['module_name'] : $GD_module_['module_name'] <br>\r
		theme_GD_[_REQUEST['bloc']]['type'] : ".$theme_GD_[$_REQUEST['bloc']]['type']." <br>\r
		?!?!?! \r
		"); 
		//echo 								print_r_html ($pv['TabCon']) . "<br>\r<br>\r";
		//echo print_r_html ($pv['TabNom']) . "<br>\r<br>\r";
		//echo print_r_html ($theme_GD_) . "<br>\r<br>\r";
	*/
		break;
	}
}

$_REQUEST['bloc'] = $_REQUEST['sauvegarde']['_REQUEST_bloc_01'];
// --------------------------------------------------------------------------------------------
$tl_['eng']['text_confirm1'] = "I confirm the decoration modifications.";
$tl_['fra']['text_confirm1'] = "Je valide la modification de la d&eacute;coration.";

echo ("
</div>\r
<br>\r
<br>\r

<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_internal_width']."'>\r
<tr>\r
".$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['UPDATE_action']."
");

switch ( $_REQUEST['uni_gestion_des_decorations_p'] ) { 
case 2:	echo ("<input type='hidden' name='arti_page'	value='2'>\r");	break;
case 3:	echo ("<input type='hidden' name='arti_page'	value='1'>\r");	break;
}

echo ("
<input type='hidden' name='uni_gestion_des_decorations_p'	value='".$_REQUEST['uni_gestion_des_decorations_p']."'>\r
<input type='hidden' name='M_DECORA[ref_id]'	value='".$_REQUEST['M_DECORA']['ref_id']."'>\r
".$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']
);

switch ( $_REQUEST['uni_gestion_des_decorations_p'] ) { 
case 2:	
	echo ("<td>\r<input type='checkbox' name='M_DECORA[confirmation_modification]' value='1'>".$tl_[$l]['text_confirm1']."\r</td>\r
	<td style='text-align: right;'>\r");
	$_REQUEST['BS']['id']				= "bouton_modification";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
	$_REQUEST['BS']['mode']				= 1;
	$_REQUEST['BS']['taille'] 			= 192;
	$_REQUEST['BS']['derniere_taille']	= 0;
break;
case 3:	
	echo ("<td>\r</td>\r
	<td style='text-align: right;'>\r");

	$_REQUEST['BS']['id']				= "bouton_creation";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
	$_REQUEST['BS']['mode']				= 1;
	$_REQUEST['BS']['taille'] 			= 192;
	$_REQUEST['BS']['derniere_taille']	= 0;
break;
}
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

// --------------------------------------------------------------------------------------------
$pv['tvi_cmpt'] = 0;
$pv['TabValInitiales'] = "var TabValInitiales = {\r";
foreach ( $TJPM as $Y ) {
	$pv['TabValInitiales'] .= "	\"" . $Y['nom_module'] . "\": { \"pos_x1_22\":\"".$Y['pos_x1_22']."\",  \"pos_x2_22\":\"".$Y['pos_x2_22']."\",	\"pos_y1_22\":\"".$Y['pos_y1_22']."\",	\"pos_y3_22\":\"".$Y['pos_y3_22']."\"	},\r";
	$pv['tvi_cmpt']++;
}
$pv['TabValInitiales'] = substr( $pv['TabValInitiales'], 0 , -2 ) . "\r};\r";

if ( $pv['tvi_cmpt'] > 0 ) { $JavaScriptInitDonnees[] = $pv['TabValInitiales']; }

// --------------------------------------------------------------------------------------------
$handledir = opendir("../media/theme/");
$pv['FSJavaScript'] = "var TabFSJS = {\r";
while (false !== ($pv['entrydir'] = readdir($handledir))) {
	if ( $pv['entrydir'] != "." && $pv['entrydir'] != ".." && !is_file("../media/theme/".$entrysir)  ) {
		$pv['FSJavaScript'] .= "\"".$pv['entrydir']."\": { \r";
		$handlefile = opendir("../media/theme/".$pv['entrydir']."/");
		$pv['fcount'] = 0;
		$pv['fichiertrouve'] = 0;
		while (false !== ($pv['entryfile'] = readdir($handlefile))) {
			if ( $pv['entryfile'] != "." && $pv['entryfile'] != ".." && !is_dir("../media/theme/".$pv['entrydir']."/".$pv['entryfile']) ) {
				if ( stripos($pv['entryfile'], ".gif") != FALSE || stripos($pv['entryfile'], ".jpg") != FALSE || stripos($pv['entryfile'], ".jpeg") != FALSE || stripos($pv['entryfile'], ".png") != FALSE ) {
					$pv['listefichierdir'][$pv['entrydir']][] = $pv['entryfile'];
					$pv['fichiertrouve'] = 1;
				}
			}
		}
		if ( $pv['fichiertrouve'] == 1 ) {
			sort ($pv['listefichierdir'][$pv['entrydir']]);
			reset ($pv['listefichierdir'][$pv['entrydir']]);
			$B = &$pv['listefichierdir'][$pv['entrydir']];
			foreach ( $B as $A ) {
				$pv['FSJavaScript'] .= "	\"".$pv['fcount']."\": { \"nomfichier\":\"".$A."\", ";
				list($pv['imgW'], $pv['imgH'], $pv['imgT'] , $pv['imgA'] ) = getimagesize("../media/theme/".$pv['entrydir']."/".$A );
				$pv['ix'] = $pv['imgW'];
				$pv['iy'] = $pv['imgH'];
				$pv['imgScore'] = 0;
				if ( $pv['ix'] > 64 ) { $pv['imgScore'] += 1; }
				if ( $pv['iy'] > 64 ) { $pv['imgScore'] += 2; }
				if ( $pv['ix'] > $pv['iy'] ) { $pv['imgScore'] += 4; }
				switch ( $pv['imgScore'] ) {
				case 1: case 2: case 3:		$pv['iCoef'] = 64 / $pv['iy'];	break;
				case 0: case 4:				$pv['iCoef'] = 1;				break;
				case 5: case 6: case 7:		$pv['iCoef'] = 64 / $pv['ix'];	break;
				}
				$pv['ix'] = floor($pv['ix'] * $pv['iCoef']);
				$pv['iy'] = floor($pv['iy'] * $pv['iCoef']);
				if ( $pv['ix'] == 0 ) { $pv['ix'] = 1; }
				if ( $pv['iy'] == 0 ) { $pv['iy'] = 1; }
				$pv['FSJavaScript'] .= "\"dimX\":\"".$pv['ix']."\", \"dimY\":\"".$pv['iy']."\", \"OdimX\":\"".$pv['imgW']."\", \"OdimY\":\"".$pv['imgH']."\" },\r";
				$pv['fcount']++;
			}
		}
		$pv['FSJavaScript'] = substr( $pv['FSJavaScript'], 0 , -2 ) . "\r},\r";
		closedir($handlefile);
	}
}
unset ($A , $B );
$pv['FSJavaScript'] = substr( $pv['FSJavaScript'], 0 , -2 ) . "\r};\r";

closedir($handledir);

$JavaScriptInitDonnees[] = $pv['FSJavaScript'];

$JavaScriptFichier[] = "engine/javascript_gestion_decoration.js";
$JavaScriptFichier[] = "engine/javascript_ColorPicker.js";


if ( count($TJED) > 0 ) {
	$pv['TabTJEDCaligraphCpt']		= 0;	$pv['TabTJEDCaligraph']	= "";
	$pv['TabTJEDOneDivCpt']			= 0;	$pv['TabTJEDOneDiv']	= "";
	$pv['TabTJEDMenuCpt']			= 0;	$pv['TabTJEDMenu']		= "";
	$pv['i'] = 0; 

	foreach ( $TJED as $A => $Av ) {
		switch ( $Av['Routine'] ) {
		case "GestionDecorationCaligraph":
			$pv['TabTJEDCaligraph'] .= "'".$pv['i']."': { 'Form':'".$Av['Form']."',	'Cible':'".$Av['Cible']."',	'Methode':'".$Av['Methode']."',	'ObjCible':'',	'ObjSource':'',	'Routine':'".$Av['Routine']."'	},\r";
			$pv['TabTJEDCaligraphCpt']++;
		break;
		case "GestionDecorationOneDiv":
			$pv['TabTJEDOneDiv'] .= "'".$pv['i']."': { 'Form':'".$Av['Form']."',	'Cible':'".$Av['Cible']."',	'Methode':'".$Av['Methode']."',	'ObjCible':'',	'ObjSource':'',	'Routine':'".$Av['Routine']."'	},\r";
			$pv['TabTJEDOneDivCpt']++;
		break;
		case "GestionDecorationMenu":
			$pv['TabTJEDMenu'] .= "'".$pv['i']."': { 'Form':'".$Av['Form']."',	'Cible':'".$Av['Cible']."',	'Methode':'".$Av['Methode']."',	'ObjCible':'',	'ObjSource':'',	'Routine':'".$Av['Routine']."'	},\r";
			$pv['TabTJEDMenuCpt']++;
		break;
		}
		$pv['i']++;
	}

	if ( $pv['TabTJEDCaligraphCpt'] != 0 ) {
		$pv['TabTJEDCaligraph'] = "\rvar TabTJEDCaligraph = { \r" . substr( $pv['TabTJEDCaligraph'], 0 , -2 ) . "\r};\r
		for ( var PtrC in TabTJEDCaligraph ) {\r
			switch ( TabTJEDCaligraph[PtrC].Methode ) {\r
			case 'color':\r
			case 'backgroundColor':\r
				MWMCPAttacheSurElement ( TabTJEDCaligraph[PtrC].Form , GestionDecorationCaligraph );\r
			break;\r
			}\r
		};\r
		InitialisationTJED ( TabTJEDCaligraph );\r
		GestionDecorationCaligraph ();\r
		";
		$pv['TabTJED'] .=	$pv['TabTJEDCaligraph']; 
	} 

	if ( $pv['TabTJEDOneDivCpt'] != 0 ) {
		$pv['TabTJEDOneDiv'] = "\rvar TabTJEDOneDiv = { \r" . substr( $pv['TabTJEDOneDiv'], 0 , -2 ) . "\r};\r
		for ( var PtrOD in TabTJEDOneDiv ) {\r
			switch ( TabTJEDOneDiv[PtrOD].Methode ) {\r
			case 'borderTopColor':\r
			case 'borderLeftColor':\r
			case 'borderRightColor':\r
			case 'borderBottomColor':\r
			case 'backgroundColor':\r
				MWMCPAttacheSurElement ( TabTJEDOneDiv[PtrOD].Form , GestionDecorationOneDiv );\r
			break;\r
			}\r
		};\r
		MWMCPAttacheSurElement ( 'M_DECORA[Bloc_GD_1_div_allc]' , GestionDecorationOneDivAllCol );\r
		InitialisationTJED ( TabTJEDOneDiv );\r
		GestionDecorationOneDiv ();\r
		";
		$pv['TabTJED'] .=	$pv['TabTJEDOneDiv']; 
	} 

	if ( $pv['TabTJEDMenuCpt'] != 0 ) {
		$pv['TabTJEDMenu'] = "\rvar TabTJEDMenu = { \r" . substr( $pv['TabTJEDMenu'], 0 , -2 ) . "\r};\r
		for ( var PtrM in TabTJEDMenu ) {\r
			switch ( TabTJEDMenu[PtrM].Methode ) {\r
			case 'color':\r
			case 'colorA':\r
			case 'colorAH':\r
			case 'backgroundColor':\r
			case 'backgroundColorA':\r
			case 'backgroundColorAH':\r
			case 'borderColor':\r
				MWMCPAttacheSurElement ( TabTJEDMenu[PtrM].Form , GestionDecorationMenu );\r
			break;\r
			}\r
		};\r
		InitialisationTJED ( TabTJEDMenu );\r
		GestionDecorationMenu ();\r
		";
		$pv['TabTJED'] .=	$pv['TabTJEDMenu']; 
	} 
	$JavaScriptInitCommandes[] = $pv['TabTJED'];
}
unset ( $A, $Av );

// --------------------------------------------------------------------------------------------
if ( count($TJLM) > 0 ) {
	$pv['TabTJLM'] .= "var TabTJLM = { \r";
	$pv['i'] = 0; 

	foreach ( $TJLM as $A => $Av ) {
		$pv['TabTJLM'] .= "'".$pv['i']."' : { 'Type' : '".$Av['type']."',	'ModType' : '".$Av['ModType']."',	'NomModule' : '".$Av['NomModule']."',	'FormCible' : '".$Av['FormCible']."'	},\r";
		$pv['i']++;
	}
	$pv['TabTJLM'] = substr( $pv['TabTJLM'], 0 , -2 ) . "\r};\r";
	$JavaScriptInitDonnees[] = $pv['TabTJLM'];
}
unset ( $A, $Av );

$JavaScriptInitCommandes[] = "document.forms['formulaire_gdd'].elements['M_DECORA[repertoire]'].value = '".$_REQUEST['deco_repertoire']."';";

switch ( $_REQUEST['uni_gestion_des_decorations_p'] ) { 
case 2:
	//$JavaScriptInitCommandes[] = "CalculeDecoModule ( '".$md_type[$pv['deco_type_backup']]['db']."' , '".$mn."' , 'formulaire_gdd' );";
break;
case 3:
	$JavaScriptInitCommandes[] = "SelectOngletDeco ( 'formulaire_gdd' , 'M_DECORA[type]' , 'type1', 'deco' );";	
break;
}

// --------------------------------------------------------------------------------------------




// CreationElement = OBSOLETE : A VIRER LORS DE LA MISE A JOUR DE CETTE PAGE.
/*
$_REQUEST['CreationElementIndex']++;
$pv['j'] = &$_REQUEST['CreationElement'][$_REQUEST['CreationElementIndex']];
$pv['j']['type'] = "uni_gestion_des_decorations"; 
$pv['j']['id'] = "FSJavaScript"; 
$pv['j']['Cellnom'] = "FSJS_C_"; 
$pv['j']['width'] = 640; 
$pv['j']['height'] = 640; 

$_REQUEST['CreationElementIndex']++;
$pv['j'] = &$_REQUEST['CreationElement'][$_REQUEST['CreationElementIndex']];
$pv['j']['type'] = "ColoPicker"; 
*/
$website['ws_stylesheet'] = $_REQUEST['sauve']['website_ws_stylesheet'];


if ( $website['ws_info_debug'] < 10 ) {
	unset (
		$dbp,
		$dbquery,
		$fc_class_,
		$handledir, 
		$handlefile, 
		$liste_fichier,
		$md_etat,
		$pv,
		$AD,
		$ADC,
		$tab_etat,
		$trr,
		$tl_,
		$TJED,
		$TJPM
	);
}

//$theme_tableau_a_ecrire = "theme_princ_";
/*Hydr-Content-End*/
$DP_['arti_page'] = $DP_['arti_page_save'];

?>
