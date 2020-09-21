<?php
/*MWM-licence*/
// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
/*MWM-licence-fin*/
/*
$_REQUEST['C_GALERI']['update'] = 1;
$_REQUEST['C_GALERI']['mode'] = 1;
$_REQUEST['C_GALERI']['qualite'] = 40;
$_REQUEST['C_GALERI']['x'] = 64;
$_REQUEST['C_GALERI']['y'] = 64;
$_REQUEST['C_GALERI']['liserai'] = 5;
$_REQUEST['C_GALERI']['tag'] = "Thumbplouf_";
*/
/*MWM-file_content*/
$_REQUEST['sql_initiateur'] = "Gestion de l'extension MWMGalerie";

if ( $_REQUEST['C_GALERI']['update'] == 1 ) {
	$_REQUEST['C_GALERI']['extension_id'] = Extension_Recherche_Id ( "MWM_Galerie" );
	$requete[] = "UPDATE ".$SQL_tab_abrege['extension_config']." SET extension_value = '".$_REQUEST['C_GALERI']['mode']."'				WHERE extension_variable = 'mode'			AND ws_id = '".$website['ws_id']."' AND extension_id =  '".$_REQUEST['C_GALERI']['extension_id']."'";
	$requete[] = "UPDATE ".$SQL_tab_abrege['extension_config']." SET extension_value = '".$_REQUEST['C_GALERI']['qualite']."'			WHERE extension_variable = 'qualite'		AND ws_id = '".$website['ws_id']."' AND extension_id =  '".$_REQUEST['C_GALERI']['extension_id']."'";
	$requete[] = "UPDATE ".$SQL_tab_abrege['extension_config']." SET extension_value = '".$_REQUEST['C_GALERI']['x']."'				WHERE extension_variable = 'x'				AND ws_id = '".$website['ws_id']."' AND extension_id =  '".$_REQUEST['C_GALERI']['extension_id']."'";
	$requete[] = "UPDATE ".$SQL_tab_abrege['extension_config']." SET extension_value = '".$_REQUEST['C_GALERI']['y']."'				WHERE extension_variable = 'y'				AND ws_id = '".$website['ws_id']."' AND extension_id =  '".$_REQUEST['C_GALERI']['extension_id']."'";
	$requete[] = "UPDATE ".$SQL_tab_abrege['extension_config']." SET extension_value = '".$_REQUEST['C_GALERI']['liserai']."'			WHERE extension_variable = 'liserai'		AND ws_id = '".$website['ws_id']."' AND extension_id =  '".$_REQUEST['C_GALERI']['extension_id']."'";
	$requete[] = "UPDATE ".$SQL_tab_abrege['extension_config']." SET extension_value = '".$_REQUEST['C_GALERI']['table_colonnes']."'	WHERE extension_variable = 'table_colonnes'	AND ws_id = '".$website['ws_id']."' AND extension_id =  '".$_REQUEST['C_GALERI']['extension_id']."'";
	$requete[] = "UPDATE ".$SQL_tab_abrege['extension_config']." SET extension_value = '".$_REQUEST['C_GALERI']['table_lignes']."'		WHERE extension_variable = 'table_lignes'	AND ws_id = '".$website['ws_id']."' AND extension_id =  '".$_REQUEST['C_GALERI']['extension_id']."'";
	$requete[] = "UPDATE ".$SQL_tab_abrege['extension_config']." SET extension_value = '".$_REQUEST['C_GALERI']['fichier_tag']."'		WHERE extension_variable = 'fichier_tag'	AND ws_id = '".$website['ws_id']."' AND extension_id =  '".$_REQUEST['C_GALERI']['extension_id']."'";
	unset ( $A );
	foreach ( $requete as $A ) { manipulation_traitement_requete ( $A ); }
}
else {
	$pv['extension_id'] = Extension_Recherche_Id ( "MWM_Galerie" );
	$pv['requete'] = "SELECT exc.* 
	FROM ".$SQL_tab_abrege['extension_config']." exc 
	WHERE exc.ws_id = '".$website['ws_id']."' 
	AND exc.extension_id = '".$pv['extension_id']."'
	;";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
	while ($dbp = fetch_array_sql($dbquery)) { $_REQUEST['C_GALERI'][$dbp['extension_variable']] = $dbp['extension_value']; }
}


$tl_['eng']['o1_l1'] = "Storage";		$tl_['fra']['o1_l1'] = "Stockage";	
$tl_['eng']['o1_l2'] = "Quality";		$tl_['fra']['o1_l2'] = "Qualit&eacute;";	
$tl_['eng']['o1_l3'] = "Max width";		$tl_['fra']['o1_l3'] = "Largeur maximum";	
$tl_['eng']['o1_l4'] = "Max height";	$tl_['fra']['o1_l4'] = "Hauteur maximum";
$tl_['eng']['o1_l5'] = "Border width";	$tl_['fra']['o1_l5'] = "&eacute;paisseur liserai";
$tl_['eng']['o1_l6'] = "File tag";		$tl_['fra']['o1_l6'] = "Marquage fichier";

$AD['1']['1']['1']['cont'] = $tl_[$l]['o1_l1'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['o1_l2'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['o1_l3'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['o1_l4'];
$AD['1']['5']['1']['cont'] = $tl_[$l]['o1_l5'];
$AD['1']['6']['1']['cont'] = $tl_[$l]['o1_l6'];


$tl_['eng']['selectmode']['0'] = "Live mode";			$tl_['fra']['selectmode']['0'] = "Pas de stockage";
$tl_['eng']['selectmode']['1'] = "Store in database";	$tl_['fra']['selectmode']['1'] = "Stockage en base de donn&eacute;e";
$tl_['eng']['selectmode']['2'] = "Store in files";		$tl_['fra']['selectmode']['2'] = "Stockage dans des fichiers";

$AD['1']['1']['2']['cont'] = "<select name='GG[mode]' class='" . $theme_tableau.$_REQUEST['bloc']."_form_1 " . $theme_tableau.$_REQUEST['bloc']."_t2'>\r";
$GAL_mode_select['0']['t'] = $tl_[$l]['selectmode']['0'];	$GAL_mode_select['0']['s'] = "";		$GAL_mode_select['0']['cmd'] = "0";
$GAL_mode_select['1']['t'] = $tl_[$l]['selectmode']['1'];	$GAL_mode_select['1']['s'] = "";		$GAL_mode_select['1']['cmd'] = "1";
$GAL_mode_select['2']['t'] = $tl_[$l]['selectmode']['2'];	$GAL_mode_select['2']['s'] = "";		$GAL_mode_select['2']['cmd'] = "2";
$GAL_mode_select[$_REQUEST['C_GALERI']['mode']]['s'] = " selected ";
foreach ( $GAL_mode_select as $A ) { $AD['1']['1']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s']."> ".$A['t']."</option>\r"; }
$AD['1']['1']['2']['cont'] .= "</select>\r";

$AD['1']['2']['2']['cont'] = "<input type='text' name='GG[qualite]'		size='20' maxlength='255' value='".$_REQUEST['C_GALERI']['qualite']."'		class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>%";
$AD['1']['3']['2']['cont'] = "<input type='text' name='GG[x]'			size='20' maxlength='255' value='".$_REQUEST['C_GALERI']['x']."'				class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>pixels";
$AD['1']['4']['2']['cont'] = "<input type='text' name='GG[y]'			size='20' maxlength='255' value='".$_REQUEST['C_GALERI']['y']."'				class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>pixels";
$AD['1']['5']['2']['cont'] = "<input type='text' name='GG[liserai]'		size='20' maxlength='255' value='".$_REQUEST['C_GALERI']['liserai']."'		class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>pixels";
$AD['1']['6']['2']['cont'] = "<input type='text' name='GG[fichier_tag]'	size='20' maxlength='255' value='".$_REQUEST['C_GALERI']['fichier_tag']."'	class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>_image.jpg";


$tl_['eng']['onglet1'] = "Gallery";	$tl_['fra']['onglet1'] = "Galerie";	
$ADC['onglet']['1']['nbr_ligne'] = 6;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 7*36;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -16 ;
$tab_infos['group']			= "mb_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];

echo ("<form ACTION='index.php?' method='post' name='formulaire_GG_config'>\r");

include ("engine/affichage_donnees.php");

echo (
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
"<input type='hidden' name='C_GALERI[update]'		value='1'>\r 
<br>\r"
);

$tl_['eng']['bouton_config1'] = "Modify";	$tl_['fra']['bouton_config1'] = "Modifier";
$_REQUEST['BS']['id']				= "bouton_config1";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau.$_REQUEST['bloc']."_t2 " . $theme_tableau.$_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau.$_REQUEST['bloc']."_t2 " . $theme_tableau.$_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton_config1'];
$_REQUEST['BS']['mode']				= 0;
$_REQUEST['BS']['taille'] 			= 0;

echo ( 
"<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."px;'>\r
<tr>
<td class='" . $theme_tableau.$_REQUEST['bloc']."_t2'>\r</td>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_t2' style='width: 128px;'>\r
" . generation_bouton () . "
</td>\r
</tr>\r
</table>
</form>\r<br>\r&nbsp;
<hr>
");

$pv['requete'] = "UPDATE ".$SQL_tab_abrege['pv']." SET pv_number = 1 WHERE pv_name = 'galerie_ticket';";
manipulation_traitement_requete ( $pv['requete'] );
$pv['i'] = 1;

$PA = Extension_Appel ( "MWM_Galerie"  );
$PLC = &$PA['extension_config'];
$PLF = &$PA['extension_fichiers'];
$GAL_table_colones = 3;
$GAL_table_lignes = 3;
$GAL_taille_nom = 24;
$GAL_nom = "Example";
$GAL_dir = "../websites-datas/www.rootwave.net/data/documents/fra_gallerie_photographie_p01";
if (!isset($_REQUEST['GAL_page_selection'])) { $_REQUEST['GAL_page_selection'] = 1; }
$pv['galerie_album'] = "../extensions/".$PA['extension_directory']."/programmes/".$PLF['Galerie']['fichier_nom'];
//echo ($GAL_dir);
include ( $pv['galerie_album'] );


if ( $website['ws_info_debug'] < 10 ) {
	unset (
		$A,
		$B , 
		$dbquery , 
		$dbp , 
		$GAL_mode_select,
		$AD,
		$ADC,
		$pv,
		$tl_
	);
}
/*MWM-content_end*/
?>
