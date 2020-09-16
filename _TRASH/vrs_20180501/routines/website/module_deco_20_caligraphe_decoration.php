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
//	module_deco_20_caligraphe_decoration.php
// --------------------------------------------------------------------------------------------
//outil_debug ( $theme_GD_ , "theme_GD_");

$tl_['fra']['cell_1_txt'] = "Texte";		$tl_['eng']['cell_1_txt'] = "Text";
$tl_['fra']['cell_2_txt'] = "Liens";		$tl_['eng']['cell_2_txt'] = "Links";
$tl_['fra']['cell_3_txt'] = "Tables";		$tl_['eng']['cell_3_txt'] = "Tables";
$tl_['fra']['cell_4_txt'] = "Formulaires";	$tl_['eng']['cell_4_txt'] = "Forms";
$tl_['fra']['cell_5_txt'] = "Boutons";		$tl_['eng']['cell_5_txt'] = "Buttons";
$tl_['fra']['cell_6_txt'] = "Onglets";		$tl_['eng']['cell_6_txt'] = "Tabs";
$tl_['fra']['cell_7_txt'] = "Icones";		$tl_['eng']['cell_7_txt'] = "Icons";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 7;
$tab_infos['tab_comportement']	= 1
$tab_infos['mode_rendu']		= 0;
$tab_infos['doc_height']		= $tab_infos['doc_height'] - 48;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] - 48;
$tab_infos['groupe']			= "cali_";
$tab_infos['cell_id']			= "tab_";
$tab_infos['document']			= "caligraph";
$tab_infos['cell_1_txt']		= $tl_[$l]['cell_1_txt'];
$tab_infos['cell_2_txt']		= $tl_[$l]['cell_2_txt'];
$tab_infos['cell_3_txt']		= $tl_[$l]['cell_3_txt'];
$tab_infos['cell_4_txt']		= $tl_[$l]['cell_4_txt'];
$tab_infos['cell_5_txt']		= $tl_[$l]['cell_5_txt'];
$tab_infos['cell_6_txt']		= $tl_[$l]['cell_6_txt'];
$tab_infos['cell_7_txt']		= $tl_[$l]['cell_7_txt'];

$pv['onglet'] = 0;

// --------------------------------------------------------------------------------------------
$pv['onglet']++;
$pv['ligne'] = 1;

$tl_['eng']['cali_ex1'] = "Text sample. ";			$tl_['fra']['cali_ex1'] = "Exemple de texte. ";
$tl_['eng']['cali_tmin'] = "Minimum text size";		$tl_['fra']['cali_tmin'] = "Taille minimum du texte";
$tl_['eng']['cali_tmax'] = "Maximum text size";		$tl_['fra']['cali_tmax'] = "Taille maximum du texte";

$tl_['eng']['cali_def_titre'] = "Title definition";		$tl_['fra']['cali_def_titre'] = "D&eacute;finition du titre";
$tl_['eng']['cali_def_titre2'] = "Test size";			$tl_['fra']['cali_def_titre2'] = "Taille du texte";

$tl_['eng']['txt1'] = "Text sample";			$tl_['fra']['txt1'] = "Exemple de texte";	
$tl_['eng']['legende_n'] = "Normal";			$tl_['fra']['legende_n'] = "Normal";
$tl_['eng']['legende_h'] = "Hover";				$tl_['fra']['legende_h'] = "Survol";
$tl_['eng']['legende_11'] = "Visual";			$tl_['fra']['legende_11'] = "Visuel";
$tl_['eng']['legende_21'] = "Left cell";		$tl_['fra']['legende_21'] = "Cellule de gauche";
$tl_['eng']['legende_31'] = "Central cell";		$tl_['fra']['legende_31'] = "Cellule centrale";
$tl_['eng']['legende_41'] = "Right cell";		$tl_['fra']['legende_41'] = "Cellule de droite";
$tl_['eng']['legende_51'] = "Height";			$tl_['fra']['legende_51'] = "Hauteur";
$tl_['eng']['legende_61'] = "Text color";		$tl_['fra']['legende_61'] = "Couleur du texte";

$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= $tl_[$l]['cali_def_titre'];
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 3;

$pv['ligne']++;
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	= "<center>\r
<table style='border-style: none; border-width: 0px; border-collapse: collapse;'>\r
<tr>\r
<td id='caligraph_titre_ft1' style='padding: 0px; width: ".$theme_GD_['B02T']['deco_ft1_x']."px;	height: ".$theme_GD_['B02T']['deco_ft_y']."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T']['deco_ft1'].");'>\r</td>\r
<td id='caligraph_titre_ft2' style='padding: 0px; 													height: ".$theme_GD_['B02T']['deco_ft_y']."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T']['deco_ft2'].");'>\r
<span id='caligraph_titre_col' class='theme_GD_B05_tb4' style='color: ".str_replace ( "#" , "" ,$theme_GD_['B02T']['deco_txt_titre_col']).";'>".$tl_[$l]['cali_ex1']."</span>\r
</td>\r
<td id='caligraph_titre_ft3' style='padding: 0px; width: ".$theme_GD_['B02T']['deco_ft3_x']."px;	height: ".$theme_GD_['B02T']['deco_ft_y']."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T']['deco_ft3'].");'>\r</td>\r
</tr>\r
</table>\r
</center>\r";
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 2;
$AD[$pv['onglet']][$pv['ligne']]['2']['cont']		= "";
$AD[$pv['onglet']][$pv['ligne']]['3']['cont']		= "<input type='text' name='M_DECORA[caligraph_titre_ft_height]' id='M_DECORA[caligraph_titre_ft_height]' size='3' maxlength='3' value='".$theme_GD_['B02T']['deco_ft_y']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
onChange='GestionDecorationCaligraph ();'>px\r
#<input type='text' id='M_DECORA[caligraph_titre_col_input]' name='M_DECORA[caligraph_titre_col_input]' size='6' maxlength='6' value='".str_replace ("#", "" , $theme_GD_['B02T']['deco_txt_titre_col'])."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>\r
";

$pv['ligne']++;
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= "<input type='text' name='M_DECORA[caligraph_titre_ft1_width]' id='M_DECORA[caligraph_titre_ft1_width]' size='3' maxlength='3' value='".$theme_GD_['B02T']['deco_ft1_x']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
onChange='GestionDecorationCaligraph ();'>px\r<br>\r" .	
generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[caligraph_titre_ft1_bg]" , "M_DECORA[caligraph_titre_ft1_width]" , 0, "M_DECORA[repertoire]" , $theme_GD_['B02T']['deco_ft1'] , 0, "GestionDecorationCaligraph" , 1 );
$AD[$pv['onglet']][$pv['ligne']]['2']['cont']		= generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[caligraph_titre_ft2_bg]" , 0, "M_DECORA[caligraph_titre_ft_height]" , "M_DECORA[repertoire]" , $theme_GD_['B02T']['deco_ft2'] , "" , "GestionDecorationCaligraph" , 1 );
$AD[$pv['onglet']][$pv['ligne']]['3']['cont']		= "<input type='text' name='M_DECORA[caligraph_titre_ft3_width]' id='M_DECORA[caligraph_titre_ft3_width]' size='3' maxlength='3' value='".$theme_GD_['B02T']['deco_ft3_x']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
onChange='GestionDecorationCaligraph ();'>px\r<br>\r" .	
generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[caligraph_titre_ft3_bg]" , "M_DECORA[caligraph_titre_ft3_width]", 0, "M_DECORA[repertoire]" , $theme_GD_['B02T']['deco_ft3'] , "" , "GestionDecorationCaligraph" , 1 );

$pv['ligne']++;
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= $tl_[$l]['cali_def_titre2'];
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 3;
$AD[$pv['onglet']][$pv['ligne']]['1']['sc']			= 1;

$pv['ligne']++;
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= "
<span id='Bloc_GD_caligraphe_t1' class='theme_GD_".$_REQUEST['bloc']."_t1'>\r".$tl_[$l]['cali_ex1']." (1)</span>\r
<span id='Bloc_GD_caligraphe_t2' class='theme_GD_".$_REQUEST['bloc']."_t2'>\r".$tl_[$l]['cali_ex1']." (2)</span>\r
<span id='Bloc_GD_caligraphe_t3' class='theme_GD_".$_REQUEST['bloc']."_t3'>\r".$tl_[$l]['cali_ex1']." (3)</span>\r
<span id='Bloc_GD_caligraphe_t4' class='theme_GD_".$_REQUEST['bloc']."_t4'>\r".$tl_[$l]['cali_ex1']." (4)</span>\r
<span id='Bloc_GD_caligraphe_t5' class='theme_GD_".$_REQUEST['bloc']."_t5'>\r".$tl_[$l]['cali_ex1']." (5)</span>\r
<span id='Bloc_GD_caligraphe_t6' class='theme_GD_".$_REQUEST['bloc']."_t6'>\r".$tl_[$l]['cali_ex1']." (6)</span>\r
<span id='Bloc_GD_caligraphe_t7' class='theme_GD_".$_REQUEST['bloc']."_t7'>\r".$tl_[$l]['cali_ex1']." (7)</span>\r";
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 2;
$AD[$pv['onglet']][$pv['ligne']]['2']['cont']		= "";
$AD[$pv['onglet']][$pv['ligne']]['3']['cont']		= $tl_[$l]['cali_tmin']." <input type='text' name='M_DECORA[".$GD_module_['module_nom']."_taille_mini]' id='M_DECORA[".$GD_module_['module_nom']."_taille_mini]' size='2' maxlength='2' value='10'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1' onChange=\"Calcule_taille_texte();\">px<br>\r
".$tl_[$l]['cali_tmax']." <input type='text' name='M_DECORA[".$GD_module_['module_nom']."_taille_maxi]' id='M_DECORA[".$GD_module_['module_nom']."_taille_maxi]' size='2' maxlength='2' value='24'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1' onChange=\"Calcule_taille_texte();\">px\r";

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['ligne'];	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 3;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;



TJED_insertion ( "M_DECORA[caligraph_titre_ft1_width]",	"caligraph_titre_ft1",	"width",			"GestionDecorationCaligraph"  );
TJED_insertion ( "M_DECORA[caligraph_titre_ft3_width]",	"caligraph_titre_ft3",	"width",			"GestionDecorationCaligraph"  );

TJED_insertion ( "M_DECORA[caligraph_titre_ft_height]",	"caligraph_titre_ft1",	"height",			"GestionDecorationCaligraph"  );
TJED_insertion ( "M_DECORA[caligraph_titre_ft_height]",	"caligraph_titre_ft2",	"height",			"GestionDecorationCaligraph"  );
TJED_insertion ( "M_DECORA[caligraph_titre_ft_height]",	"caligraph_titre_ft3",	"height",			"GestionDecorationCaligraph"  );

TJED_insertion ( "M_DECORA[caligraph_titre_col_input]",	"caligraph_titre_col",	"color",			"GestionDecorationCaligraph"  );
TJED_insertion ( "M_DECORA[caligraph_titre_ft1_bg]",	"caligraph_titre_ft1",	"backgroundImage",	"GestionDecorationCaligraph"  );
TJED_insertion ( "M_DECORA[caligraph_titre_ft2_bg]",	"caligraph_titre_ft2",	"backgroundImage",	"GestionDecorationCaligraph"  );
TJED_insertion ( "M_DECORA[caligraph_titre_ft3_bg]",	"caligraph_titre_ft3",	"backgroundImage",	"GestionDecorationCaligraph"  );


// --------------------------------------------------------------------------------------------
$pv['onglet']++;
$pv['ligne'] = 1;

function form_deco_liens ( $id , $typefg , $typebg ) {
	global $tl_ , $l , $theme_GD_, $pv, $AD;
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= $tl_[$l]['cali_exa'];
	$AD[$pv['onglet']][$pv['ligne']]['2']['cont']		= "#<input type='text' readonly name='M_DECORA[".$typefg."]'	id='M_DECORA[".$typefg."]'	size='8' maxlength='6' value='".str_replace("#", "", $theme_GD_['B02T'][$typefg])."'			 class='" . $theme_tableau .$_REQUEST['bloc']."_form_1' onChange='GestionDecorationCaligraph ();'>";
	$AD[$pv['onglet']][$pv['ligne']]['3']['cont']		= "#<input type='text' readonly name='M_DECORA[".$typebg."]'	id='M_DECORA[".$typebg."]'	size='8' maxlength='6' value='".str_replace("#", "", $theme_GD_['B02T'][$typebg])."'			 class='" . $theme_tableau .$_REQUEST['bloc']."_form_1' onChange='GestionDecorationCaligraph ();'>";
	$AD[$pv['onglet']][$pv['ligne']]['4']['cont']		= "<span id='caligraphe_lien_".$id."' style='color: ".$theme_GD_['B02T'][$typefg]."; background-color:".$theme_GD_['B02T'][$typebg].";'>".$tl_[$l]['cali_exatst']."</span>";

	TJED_insertion ( "M_DECORA[".$typefg."]",	"caligraphe_lien_".$id,	"color",	"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$typebg."]",	"caligraphe_lien_".$id,	"backgroundColor",	"GestionDecorationCaligraph" );
}

$tl_['eng']['cali_lien_titre1'] = "Link (in normal text)";	$tl_['fra']['cali_lien_titre1'] = "Lien (dans le texte)";
$tl_['eng']['cali_lien_titre2'] = "Link in a table";		$tl_['fra']['cali_lien_titre2'] = "Lien dans une table";
$tl_['eng']['cali_ffg'] = "Foreground";						$tl_['fra']['cali_ffg'] = "Avant plan";
$tl_['eng']['cali_fbg'] = "Background";						$tl_['fra']['cali_fbg'] = "Arrière plan";


$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= $tl_[$l]['cali_lien_titre1'];
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 4;

$pv['ligne']++;
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= "";
$AD[$pv['onglet']][$pv['ligne']]['2']['cont']		= $tl_[$l]['cali_ffg'];
$AD[$pv['onglet']][$pv['ligne']]['3']['cont']		= $tl_[$l]['cali_fbg'];
$AD[$pv['onglet']][$pv['ligne']]['4']['cont']		= "";



$tl_['eng']['cali_exatst'] = "Link sample. 123456789. ";				$tl_['fra']['cali_exatst'] = "Exemple de lien. 123456789. ";

$pv['ligne']++;
$tl_['eng']['cali_exa'] = "Normal colors";								$tl_['fra']['cali_exa'] = "Couleur normal";
form_deco_liens ( "deco_txt_l_01_fg_col",			"deco_txt_l_01_fg_col",			"deco_txt_l_01_bg_col");

$pv['ligne']++;
$tl_['eng']['cali_exa'] = "Hover color";								$tl_['fra']['cali_exa'] = "Couleur lors du survol";
form_deco_liens ( "deco_txt_l_01_fg_hover_col",		"deco_txt_l_01_fg_hover_col",	"deco_txt_l_01_bg_hover_col");

$pv['ligne']++;
$tl_['eng']['cali_exa'] = "Active color";								$tl_['fra']['cali_exa'] = "Couleur active";	
form_deco_liens ( "deco_txt_l_01_fg_active_col",	"deco_txt_l_01_fg_active_col",	"deco_txt_l_01_bg_active_col");

$pv['ligne']++;
$tl_['eng']['cali_exa'] = "Visited link color";							$tl_['fra']['cali_exa'] = "Couleur des liens visit&eacute;s";
form_deco_liens ( "deco_txt_l_01_fg_visite_col",	"deco_txt_l_01_fg_visite_col",	"deco_txt_l_01_bg_visite_col");


$pv['ligne']++;
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= $tl_[$l]['cali_lien_titre2'];
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 4;
$AD[$pv['onglet']][$pv['ligne']]['1']['sc']			= 1;


$tl_['eng']['cali_exatst'] = "Link sample in a table. 123456789. ";	$tl_['fra']['cali_exatst'] = "Exemple de lien dans une table. 123456789. ";

$pv['ligne']++;
$tl_['eng']['cali_exa'] = "Normal colors";							$tl_['fra']['cali_exa'] = "Couleur normal";
form_deco_liens ( "deco_txt_l_td_fg_col",			"deco_txt_l_td_fg_col" , 		"deco_txt_l_td_bg_col");

$pv['ligne']++;
$tl_['eng']['cali_exa'] = "Hover color";							$tl_['fra']['cali_exa'] = "Couleur lors du survol";
form_deco_liens ( "deco_txt_l_td_fg_hover_col",		"deco_txt_l_td_fg_hover_col" ,	"deco_txt_l_td_bg_hover_col");

$pv['ligne']++;
$tl_['eng']['cali_exa'] = "Active color";							$tl_['fra']['cali_exa'] = "Couleur active";	
form_deco_liens ( "deco_txt_l_td_fg_active_col",	"deco_txt_l_td_fg_active_col" , "deco_txt_l_td_bg_active_col");

$pv['ligne']++;
$tl_['eng']['cali_exa'] = "Visited link color";						$tl_['fra']['cali_exa'] = "Couleur des liens visit&eacute;s";
form_deco_liens ( "deco_txt_l_td_fg_visite_col",	"deco_txt_l_td_fg_visite_col" , "deco_txt_l_td_bg_visite_col");


$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['ligne'];	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 4;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;
// --------------------------------------------------------------------------------------------
$pv['onglet']++;
$pv['ligne'] = 1;

function form_deco_fcxx ( $id , $colone ) {
	global $theme_GD_, ${$theme_tableau}, $pv, $AD;
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	= "
	<table>
	<tr>\r
	<td id='caligraph_".$id."_bg' style='width: 192px; height: 16px; border:solid 1px; border-color: #000000;' class='theme_GD_".$_REQUEST['bloc']."_".$id."'>".$id."</td>\r
	</td>\r
	</tr>\r
	</table>";
	$AD[$pv['onglet']][$pv['ligne']]['2']['cont']	= generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[caligraph_".$id."_bg]" , 0, 0, "M_DECORA[repertoire]" , $theme_GD_['B02T'][$colone] , "" , "GestionDecorationCaligraph" , 1 );
	TJED_insertion ( "M_DECORA[caligraph_".$id."_bg]",	"caligraph_".$id."_bg",	"backgroundImage",	"GestionDecorationCaligraph" );
}

$tl_['eng']['fond_cellule_titre'] = "Cells background";		$tl_['fra']['fond_cellule_titre'] = "Fonds des cellules";

$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= $tl_[$l]['fond_cellule_titre'];
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 2;

$pv['ligne']++; form_deco_fcxx ('fca' , 'deco_bgca');
$pv['ligne']++; form_deco_fcxx ('fcb' , 'deco_bgcb');
$pv['ligne']++; form_deco_fcxx ('fcc' , 'deco_bgcc');
$pv['ligne']++; form_deco_fcxx ('fcd' , 'deco_bgcd');
$pv['ligne']++; form_deco_fcxx ('fcta' , 'deco_bgcta');
$pv['ligne']++; form_deco_fcxx ('fctb' , 'deco_bgctb');
$pv['ligne']++; form_deco_fcxx ('fcsa' , 'deco_bgcsa');
$pv['ligne']++; form_deco_fcxx ('fcsb' , 'deco_bgcsb');
$pv['ligne']++; form_deco_fcxx ('fco' , 'deco_bgco');

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['ligne'];	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

// --------------------------------------------------------------------------------------------
$pv['onglet']++;
$pv['ligne'] = 1;

function form_deco_input ( $titre , $id ) {
	global $theme_GD_, $tl_, $l, $pv, $theme_tableau, ${$theme_tableau}, $AD;
	$tl_['eng']['fg'] = "Foreground";				$tl_['fra']['fg'] = "Avant plan";
	$tl_['eng']['bg'] = "Background";				$tl_['fra']['bg'] = "Arri&egrave;re plan";

	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= $titre;
	$AD[$pv['onglet']][$pv['ligne']]['1']['rowspan']	= 2;
	$AD[$pv['onglet']][$pv['ligne']]['2']['cont']		= "<input type='text' name='' id='fake_".$id."' size='15' maxlength='255' value='".$tl_[$l]['cali_ex1']."' class='theme_GD_".$_REQUEST['bloc']."_form_1'>";
	$AD[$pv['onglet']][$pv['ligne']]['2']['rowspan']	= 2;

	$AD[$pv['onglet']][$pv['ligne']]['3']['cont']		= "#<input type='text' name='M_DECORA[txt_".$id."_fg_col]' id='M_DECORA[txt_".$id."_fg_col]' size='8' maxlength='6' value='".str_replace("#" , "", $theme_GD_['B02T']['deco_txt_'.$id.'_fg_col'])."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange=\"Gebi('fake_".$id."').style.color = '#'+this.value;\">\r".$tl_[$l]['fg'];

	$pv['ligne']++; 
	$AD[$pv['onglet']][$pv['ligne']]['1']['desactive']		= 1;
	$AD[$pv['onglet']][$pv['ligne']]['2']['desactive']		= 2;
	$AD[$pv['onglet']][$pv['ligne']]['3']['cont']		= "#<input type='text' name='M_DECORA[txt_".$id."_bg_col]' id='M_DECORA[txt_".$id."_bg_col]' size='8' maxlength='6' value='".str_replace("#" , "", $theme_GD_['B02T']['deco_txt_'.$id.'_bg_col'])."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange=\"Gebi('fake_".$id."').style.backgroundColor = '#'+this.value;\">\r".$tl_[$l]['bg'];

	TJED_insertion ( "M_DECORA[txt_".$id."_fg_col]",	"fake_".$id,	"color",	"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[txt_".$id."_bg_col]",	"fake_".$id,	"backgroundColor",	"GestionDecorationCaligraph" );
}

$tl_['eng']['txt_titre_04'] = "Input field decoration";	$tl_['fra']['txt_titre_04'] = "D&eacute;coration des champs d'insertion";	
$tl_['eng']['txt_o4_l1'] = "Normal #1";					$tl_['fra']['txt_o4_l1'] = "Normal #1";	
$tl_['eng']['txt_o4_l2'] = "Normal #2";					$tl_['fra']['txt_o4_l2'] = "Normal #2";	
$tl_['eng']['txt_o4_l3'] = "In table #1";				$tl_['fra']['txt_o4_l3'] = "Dans une table #1";	
$tl_['eng']['txt_o4_l4'] = "In table #2";				$tl_['fra']['txt_o4_l4'] = "Dans une table #2";	

$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	= $tl_[$l]['txt_titre_04'];
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 3;

$pv['ligne']++;	form_deco_input ( $tl_[$l]['txt_o4_l1'] , 'input1' );
$pv['ligne']++;	form_deco_input ( $tl_[$l]['txt_o4_l2'] , 'input2' );
$pv['ligne']++;	form_deco_input ( $tl_[$l]['txt_o4_l3'] , 'input1_td' );
$pv['ligne']++;	form_deco_input ( $tl_[$l]['txt_o4_l4'] , 'input2_td' );


$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['ligne'];	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 3;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

// --------------------------------------------------------------------------------------------
$pv['onglet']++;
$pv['ligne'] = 1;

function element_3_parties ( $titre , $ids , $graph_n , $graph_h , $taille_x1 , $taille_y , $taille_x3 ) {
	global $theme_GD_, $l, $theme_SW_, $tl_, $pv, ${$theme_tableau}, $AD;

	$graph_n01 = $graph_n . "01";
	$graph_n02 = $graph_n . "02";
	$graph_n03 = $graph_n . "03";
	$graph_h01 = $graph_h . "01";
	$graph_h02 = $graph_h . "02";
	$graph_h03 = $graph_h . "03";

	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	= "
	<table style='width: 100%' border='0' >\r
	<tr>\r
	".$_REQUEST['td_fcta'].$titre." </td>\r
	".$_REQUEST['td_cs2_fcta'].$tl_[$l]['legende_n']." </td>\r
	".$_REQUEST['td_cs2_fcta'].$tl_[$l]['legende_h']." </td>\r
	</tr>\r

	<tr>\r
	".$_REQUEST['td_fctb'].$tl_[$l]['legende_11']."</td>\r
	".$_REQUEST['td_cs2_fcb']."
	<center>\r
	<table style='border-style: none; border-width: 0px; border-collapse: collapse;'>\r
	<tr>\r
	<td id='".$ids."n1' style='border-style: none; padding: 0px; width: ".$theme_GD_['B02T'][$taille_x1]."px;	height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_n01].");'>\r</td>\r
	<td id='".$ids."n2' style='border-style: none; padding: 0px; 												height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_n02].");'>\r
	<span id='".$ids."txt_n2' style='color: ".$theme_GD_['B02T']['txt_col'].";'>".$tl_[$l]['txt1']."</span>\r
	</td>\r
	<td id='".$ids."n3' style='border-style: none; padding: 0px; width: ".$theme_GD_['B02T'][$taille_x3]."px;	height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_n03].");'>\r</td>\r
	</tr>\r
	</table>\r
	</center>\r
	</td>\r

	".$_REQUEST['td_cs2_fcb']."
	<center>\r
	<table style='border-style: none; border-width: 0px; border-collapse: collapse; '>\r
	<tr>\r
	<td id='".$ids."h1' style='border-style: none; padding: 0px; width: ".$theme_GD_['B02T'][$taille_x1]."px;	height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_h01].");'>\r</td>\r
	<td id='".$ids."h2' style='border-style: none; padding: 0px; 												height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_h02].");'>\r
	<span id='".$ids."txt_h2' style='color: ".$theme_GD_['B02T']['txt_col'].";'>".$tl_[$l]['txt1']."</span>\r
	</td>\r
	<td id='".$ids."h3' style='border-style: none; padding: 0px; width: ".$theme_GD_['B02T'][$taille_x3]."px;	height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_h03].");'>\r</td>\r
	</tr>\r
	</table>\r
	</center>\r
	</td>\r
	</tr>\r

	<tr>\r
	".$_REQUEST['td_fcta'].$tl_[$l]['legende_21']."</td>\r
	".$_REQUEST['td_fca']."<input type='text' name='M_DECORA[".$ids."n1_width]' id='M_DECORA[".$ids."n1_width]' size='3' maxlength='3' value='".$theme_GD_['B02T'][$taille_x1]."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange=\"
	modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$ids."h1_width]' , this.value );
	GestionDecorationCaligraph ();
	\">px\r</td>\r".
	$_REQUEST['td_fca'].
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$ids."n1_bg]", "M_DECORA[".$ids."n1_width]", 0 , "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_n01] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r".
	$_REQUEST['td_fca'].
	"<input type='text' name='M_DECORA[".$ids."h1_width]' id='M_DECORA[".$ids."h1_width]' size='3' maxlength='3' value='".$theme_GD_['B02T'][$taille_x1]."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange=\"
	modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$ids."n1_width]' , this.value );
	GestionDecorationCaligraph ();
	\">px\r</td>\r".
	$_REQUEST['td_fca'].
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$ids."h1_bg]" , "M_DECORA[".$ids."h1_width]" , 0, "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_h01] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r
	</tr>\r

	<tr>\r".
	$_REQUEST['td_fctb'].$tl_[$l]['legende_31']."</td>\r".
	$_REQUEST['td_fcb']."</td>\r".
	$_REQUEST['td_fcb'].
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$ids."n2_bg]" , 0, "M_DECORA[".$ids."_height]", "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_n02] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r".
	$_REQUEST['td_fcb']."</td>\r".
	$_REQUEST['td_fcb'].
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$ids."h2_bg]" , 0, "M_DECORA[".$ids."_height]", "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_h02] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r".
	"</td>\r
	</tr>\r

	<tr>\r
	".$_REQUEST['td_fcta'].$tl_[$l]['legende_41']."</td>\r".
	$_REQUEST['td_fca'].
	"<input type='text' name='M_DECORA[".$ids."n3_width]' id='M_DECORA[".$ids."n3_width]' size='3' maxlength='3' value='".$theme_GD_['B02T'][$taille_x1]."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange=\"
	modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$ids."h3_width]' , this.value );
	GestionDecorationCaligraph ();
	\">px\r</td>\r".
	$_REQUEST['td_fca'].
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$ids."n3_bg]" , "M_DECORA[".$ids."n3_width]" , 0 , "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_n03] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r".
	$_REQUEST['td_fca'].
	"<input type='text' name='M_DECORA[".$ids."h3_width]' id='M_DECORA[".$ids."h3_width]' size='3' maxlength='3' value='".$theme_GD_['B02T'][$taille_x1]."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange=\"
	modifie_INPUT ( 'formulaire_gdd' , 'M_DECORA[".$ids."n3_width]' , this.value );
	GestionDecorationCaligraph ();
	\">px\r</td>\r".
	$_REQUEST['td_fca'].
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$ids."h3_bg]" , "M_DECORA[".$ids."h3_width]" , 0 , "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_h03] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r
	</tr>\r

	<tr>\r
	".$_REQUEST['td_fctb'].$tl_[$l]['legende_51']."</td>\r".
	$_REQUEST['td_cs4_fcb'].
	"<input type='text' name='M_DECORA[".$ids."_height]' id='M_DECORA[".$ids."_height]' size='3' maxlength='3' value='".$theme_GD_['B02T'][$taille_y]."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange='GestionDecorationCaligraph ();'>\rpx
	</td>\r
	</tr>\r

	<tr>\r
	".$_REQUEST['td_fcta'].$tl_[$l]['legende_61']."</td>\r".
	$_REQUEST['td_cs4_fca'].
	"#<input type='text' name='M_DECORA[".$ids."txt_col]' id='M_DECORA[".$ids."txt_col]' size='6' maxlength='6' value='".str_replace ("#", "" , $theme_GD_['B02T']['deco_txt_titre_col'])."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange='GestionDecorationCaligraph ();'>\r
	</td>\r
	</tr>\r

	</table>\r
	";

	TJED_insertion ( "M_DECORA[".$ids."n1_width]",	$ids."n1",		"width",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."n1_width]",	$ids."h1",		"width",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."n1_bg]",		$ids."n1",		"backgroundImage",	"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."h1_width]",	$ids."n1",		"width",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."h1_width]",	$ids."h1",		"width",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."h1_bg]",		$ids."h1",		"backgroundImage",	"GestionDecorationCaligraph" );

	TJED_insertion ( "M_DECORA[".$ids."n2_bg]",		$ids."n2",		"backgroundImage",	"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."h2_bg]",		$ids."h2",		"backgroundImage",	"GestionDecorationCaligraph" );

	TJED_insertion ( "M_DECORA[".$ids."n3_width]",	$ids."n3",		"width",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."n3_width]",	$ids."h3",		"width",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."n3_bg]",		$ids."n3",		"backgroundImage",	"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."h3_width]",	$ids."n3",		"width",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."h3_width]",	$ids."h3",		"width",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."h3_bg]",		$ids."h3",		"backgroundImage",	"GestionDecorationCaligraph" );

	TJED_insertion ( "M_DECORA[".$ids."_height]",	$ids."n1",		"height",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."_height]",	$ids."n2",		"height",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."_height]",	$ids."n3",		"height",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."_height]",	$ids."h1",		"height",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."_height]",	$ids."h2",		"height",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."_height]",	$ids."h3",		"height",			"GestionDecorationCaligraph" );

	TJED_insertion ( "M_DECORA[".$ids."txt_col]",	$ids."txt_n2",	"color",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[".$ids."txt_col]",	$ids."txt_h2",	"color",			"GestionDecorationCaligraph" );
}

$tl_['eng']['txt_titre_05'] = "Button decoration";	$tl_['fra']['txt_titre_05'] = "D&eacute;coration des boutons";	
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	= $tl_[$l]['txt_titre_05'];

$pv['ligne']++;
$tl_['eng']['titre_1'] = "Type #1 button";			$tl_['fra']['titre_1'] = "Bouton de type #1";
element_3_parties ( $tl_[$l]['titre_1'], 'deco_s1_', 'deco_s1_n', 'deco_s1_h', 'deco_s1_01_x', 'deco_s1_01_y', 'deco_s1_03_x' );

$pv['ligne']++;
$tl_['eng']['titre_1'] = "Type #2 button";			$tl_['fra']['titre_1'] = "Bouton de type #2";
element_3_parties ( $tl_[$l]['titre_1'], 'deco_s2_', 'deco_s2_n', 'deco_s2_h', 'deco_s2_01_x', 'deco_s2_01_y', 'deco_s2_03_x' );

$pv['ligne']++;
$tl_['eng']['titre_1'] = "Type #3 button";			$tl_['fra']['titre_1'] = "Bouton de type #3";
element_3_parties ( $tl_[$l]['titre_1'], 'deco_s3_', 'deco_s3_n', 'deco_s3_h', 'deco_s3_01_x', 'deco_s3_01_y', 'deco_s3_03_x' );

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['ligne'];	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

// --------------------------------------------------------------------------------------------
$pv['onglet']++;
$pv['ligne'] = 1;

function form_deco_tab ( $titre , $ids , $taille_ax , $taille_y , $taille_cx , $affiche_dimenssion ) {
	global $theme_GD_, $l, $theme_SW_, $tl_, $pv, ${$theme_tableau}, $AD;

	$graph_ta = "deco_tab_".$ids."_a";
	$graph_tb = "deco_tab_".$ids."_b";
	$graph_tc = "deco_tab_".$ids."_c";

	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	= "
	<table style='width: 100%' border='0' >\r
	<tr>\r
	<td colspan='2'  class='" . $theme_tableau .$_REQUEST['bloc']."_fcta ".$theme_tableau.$_REQUEST['bloc']."_t2'>\r ".$titre." </td>\r
	</tr>\r

	<tr>\r
	".$_REQUEST['td_fca'].$tl_[$l]['legende_11']."</td>\r
	<td colspan='2'  class='" . $theme_tableau .$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t2'>\r
	<center>\r
	<table border='0' cellspacing='0'>\r
	<tr>\r
	<td id='tab_".$ids."_a' style='padding: 0px; width: ".$theme_GD_['B02T'][$taille_ax]."px;	height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_ta].");'>\r</td>\r
	<td id='tab_".$ids."_b' style='padding: 0px; 												height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_tb].");'>\r
	<span id='".$ids."txt_b' style='color: ".$theme_GD_['B02T']['txt_col'].";'>".$tl_[$l]['txt1']."</span>\r
	</td>\r
	<td id='tab_".$ids."_c' style='padding: 0px; width: ".$theme_GD_['B02T'][$taille_cx]."px;	height: ".$theme_GD_['B02T'][$taille_y]."px; background-image: url(../graph/".$theme_GD_['theme_repertoire']."/".$theme_GD_['B02T'][$graph_tc].");'>\r</td>\r
	</tr>\r
	</table>\r
	</center>\r
	</td>\r
	</tr>\r

	<tr>\r
	".$_REQUEST['td_fca'].$tl_[$l]['legende_21']."</td>\r
	".$_REQUEST['td_fca'] .	
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[tab_".$ids."_a_bg]", "M_DECORA[tab_".$ids."_a_width]", 0 , "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_ta] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r
	".$_REQUEST['td_fca']
	;
	if ($affiche_dimenssion == 1 ) {
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	.= "
		<input type='text' name='M_DECORA[tab_".$ids."_a_width]' id='M_DECORA[tab_".$ids."_a_width]' size='3' maxlength='3' value='".$theme_GD_['B02T'][$taille_ax]."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
		onChange='GestionDecorationCaligraph ();'>\rpx
		";
		TJED_insertion ( "M_DECORA[tab_".$ids."_a_width]",		"tab_".$ids."_a",	"width",	"GestionDecorationCaligraph" );
	}

	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	.= "
	</td>\r
	</tr>\r

	<tr>\r
	".$_REQUEST['td_fca'].$tl_[$l]['legende_31']."</td>\r
	".$_REQUEST['td_fca'].	
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[tab_".$ids."_b_bg]", 0, "M_DECORA[tab_".$ids."_height]" , "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_tb] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r
	".$_REQUEST['td_fca']."</td>\r
	</tr>\r


	<tr>\r
	".$_REQUEST['td_fca'].$tl_[$l]['legende_41']."</td>\r
	".$_REQUEST['td_fca'].	
	generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[tab_".$ids."_c_bg]", "M_DECORA[tab_".$ids."_c_width]", 0 , "M_DECORA[repertoire]" , $theme_GD_['B02T'][$graph_tc] , "" , "GestionDecorationCaligraph" , 1 ) . 
	"</td>\r
	".$_REQUEST['td_fca']
	;
	if ($affiche_dimenssion == 1 ) {
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	.= "
		<input type='text' name='M_DECORA[tab_".$ids."_c_width]' id='M_DECORA[tab_".$ids."_c_width]' size='3' maxlength='3' value='".$theme_GD_['B02T'][$taille_cx]."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
		onChange='GestionDecorationCaligraph ();'>\rpx
		";
		TJED_insertion ( "M_DECORA[tab_".$ids."_c_width]",		"tab_".$ids."_c",	"width",	"GestionDecorationCaligraph" );
	}
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	.= "
	</td>\r
	</tr>\r
	";

	if ($affiche_dimenssion == 1 ) {
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	.= "
		<tr>\r
		".$_REQUEST['td_fca'].$tl_[$l]['legende_51']."</td>\r
		<td colspan='2' class='" . $theme_tableau .$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t2' style='text-align: center;'>\r 
		<input type='text' name='M_DECORA[tab_".$ids."_height]' id='M_DECORA[tab_".$ids."_height]' size='3' maxlength='3' value='".$theme_GD_['B02T'][$taille_y]."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
		onChange='GestionDecorationCaligraph ();'>\rpx
		</td>\r
		</tr>\r
		";
		TJED_insertion ( "M_DECORA[tab_".$ids."_height]",		"tab_".$ids."_a",	"height",	"GestionDecorationCaligraph" );
		TJED_insertion ( "M_DECORA[tab_".$ids."_height]",		"tab_".$ids."_b",	"height",	"GestionDecorationCaligraph" );
		TJED_insertion ( "M_DECORA[tab_".$ids."_height]",		"tab_".$ids."_c",	"height",	"GestionDecorationCaligraph" );
	}
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	.= "
	<tr>\r
	".$_REQUEST['td_fca'].$tl_[$l]['legende_61']."</td>\r
	<td colspan='2'  class='" . $theme_tableau .$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t2' style='text-align: center;'>\r 
	#<input type='text' readonly name='M_DECORA[tab_".$ids."_txt_col]' id='M_DECORA[tab_".$ids."_txt_col]' size='6' maxlength='6' value='".str_replace ("#", "" , $theme_GD_['B02T']['deco_tab_'.$ids.'_txt_col'])."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange='GestionDecorationCaligraph ();'>\r
	#<input type='text' readonly name='M_DECORA[tab_".$ids."_txt_bg_col]' id='M_DECORA[tab_".$ids."_txt_bg_col]' size='6' maxlength='6' value='".str_replace ("#", "" , $theme_GD_['B02T']['deco_tab_'.$ids.'_txt_bg_col'])."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'
	onChange='GestionDecorationCaligraph ();'>\r
	</td>\r
	</tr>\r
	</table>\r
	<br>\r
	<br>\r
	<br>\r
	";

	TJED_insertion ( "M_DECORA[tab_".$ids."_a_bg]",			"tab_".$ids."_a",	"backgroundImage",	"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[tab_".$ids."_b_bg]",			"tab_".$ids."_b",	"backgroundImage",	"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[tab_".$ids."_c_bg]",			"tab_".$ids."_c",	"backgroundImage",	"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[tab_".$ids."_txt_col]",		$ids."txt_b",		"color",			"GestionDecorationCaligraph" );
	TJED_insertion ( "M_DECORA[tab_".$ids."_txt_bg_col]",	$ids."txt_b",		"backgroundColor",	"GestionDecorationCaligraph" );
}

$tl_['eng']['txt_titre_06'] = "Tab decoration";	$tl_['fra']['txt_titre_06'] = "D&eacute;coration des onglets";	
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	= $tl_[$l]['txt_titre_05'];


$pv['ligne']++;
$tl_['eng']['titre_1'] = "Tab (down)";		$tl_['fra']['titre_1'] = "Onglet (en retrait)";
form_deco_tab ( $tl_[$l]['titre_1'] , 'down'  , 'deco_tab_a_x' , 'deco_tab_y' , 'deco_tab_c_x' , 1 );

$pv['ligne']++;
$tl_['eng']['titre_1'] = "Tab (up)";		$tl_['fra']['titre_1'] = "Onglet (actif)";
form_deco_tab ( $tl_[$l]['titre_1'] , 'up'    , 'deco_tab_a_x' , 'deco_tab_y' , 'deco_tab_c_x' , 1 );

$pv['ligne']++;
$tl_['eng']['titre_1'] = "Tab (hover)";	$tl_['fra']['titre_1'] = "Onglet (survol&eacute;)";
form_deco_tab ( $tl_[$l]['titre_1'] , 'hover' , 'deco_tab_a_x' , 'deco_tab_y' , 'deco_tab_c_x' , 1 );

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['ligne'];	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 1;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

// --------------------------------------------------------------------------------------------
$pv['onglet']++;
$pv['ligne'] = 1;

$tl_['eng']['deco_icone_repertoire'] = "Open file selector";	$tl_['fra']['deco_icone_repertoire'] = "Ouvre le s&eacute;lecteur de fichier";
$tl_['eng']['deco_icone_efface'] = "Erase input field";			$tl_['fra']['deco_icone_efface'] = "Efface le champs d'insertion";
$tl_['eng']['deco_icone_gauche'] = "Left";						$tl_['fra']['deco_icone_gauche'] = "Gauche";
$tl_['eng']['deco_icone_droite'] = "Right";						$tl_['fra']['deco_icone_droite'] = "Droite";
$tl_['eng']['deco_icone_haut'] = "Top";							$tl_['fra']['deco_icone_haut'] = "Haut";
$tl_['eng']['deco_icone_bas'] = "Bottom";						$tl_['fra']['deco_icone_bas'] = "Bas";
$tl_['eng']['deco_icone_ok'] = "Ok";							$tl_['fra']['deco_icone_ok'] = "Ok";
$tl_['eng']['deco_icone_nok'] = "Not Ok";						$tl_['fra']['deco_icone_nok'] = "Mauvais";
$tl_['eng']['deco_icone_question'] = "Question";				$tl_['fra']['deco_icone_question'] = "Question";
$tl_['eng']['deco_icone_notification'] = "Notification";		$tl_['fra']['icone_notification'] = "Notification";

$tl_['eng']['txt_titre_06'] = "Icon decoration";	$tl_['fra']['txt_titre_06'] = "D&eacute;coration des icones";	
$AD[$pv['onglet']][$pv['ligne']]['1']['cont']		= $tl_[$l]['txt_titre_06'];
$AD[$pv['onglet']][$pv['ligne']]['1']['colspan']	= 3;


$pv['liste_icone'] = array ('deco_icone_repertoire','deco_icone_efface','deco_icone_gauche','deco_icone_droite','deco_icone_haut','deco_icone_bas','deco_icone_ok','deco_icone_nok');
foreach ( $pv['liste_icone'] as $A ) {
	$pv['ligne']++;
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont']	= "<div id='cell_".$A."_bg' style='border-style: solid; border-width: 1px; border-color: #000000; 
	width: 128px; height: 128px; background-image: url(../graph/".$theme_GD_['B02T']['deco_repertoire']."/".$theme_GD_['B02T'][$A]."); 
	background-repeat: no-repeat; background-position:center; 
	'></div>";
	$AD[$pv['onglet']][$pv['ligne']]['2']['cont']	= $tl_['fra'][$A];
	$AD[$pv['onglet']][$pv['ligne']]['3']['cont']	= generation_icone_selecteur_image ( 3 , "formulaire_gdd" , "M_DECORA[".$A."]", 0, 0 , "M_DECORA[repertoire]" , $theme_GD_['B02T'][$A] , "" , "GestionDecorationCaligraph" , 1 );
	TJED_insertion ( "M_DECORA[".$A."]",		"cell_".$A."_bg",	"backgroundImage",	"GestionDecorationCaligraph" );
}

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['ligne'];	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 3;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;
// --------------------------------------------------------------------------------------------
include ("routines/website/affichage_donnees.php");
// --------------------------------------------------------------------------------------------
?>

