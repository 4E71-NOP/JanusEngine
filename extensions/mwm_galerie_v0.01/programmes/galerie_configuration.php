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
// --------------------------------------------------------------------------------------------
$tl_['English']['d5_01'] = "Storage type";					$tl_['Français_fr']['d5_01'] = "Type de stockage";	
$tl_['English']['d5_02'] = "File tag";						$tl_['Français_fr']['d5_02'] = "Tag de fichier";	
$tl_['English']['d5_03'] = "Compression quality (jpeg)";	$tl_['Français_fr']['d5_03'] = "Qualit&eacute; de compression (jpeg)";	
$tl_['English']['d5_04'] = "thumbnail width";				$tl_['Français_fr']['d5_04'] = "Largeur de la vignette";	
$tl_['English']['d5_05'] = "Thumbnail heigth";				$tl_['Français_fr']['d5_05'] = "Hauteur de la vignette";	
$tl_['English']['d5_06'] = "Thumbnail border thickness";	$tl_['Français_fr']['d5_06'] = "Epaisseur du liserai";

$pv['div_id'] = $tab_infos['group'] . "_" . $tab_infos['document'] . $pv['div_compteur'];
echo ("
<div id='".$pv['div_id']."' style='position: absolute; visibility: hidden; height: ".$tab_infos['doc_height']."px; overflow: auto;'>\r
<table ".$theme_princ_['tab_std_rules']." width='".$theme_SW_['tab_interieur']."'>\r
<tr><td class='" . $theme_tableau.$_REQUEST['bloc']."_fcc " . $theme_tableau.$_REQUEST['bloc']."_t3'>Type de stockage</td>						<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcd " . $theme_tableau.$_REQUEST['bloc']."_t3'>

<select name='MSW[gal_mode]' class='" . $theme_tableau.$_REQUEST['bloc']."_form_1 " . $theme_tableau.$_REQUEST['bloc']."_t3'>\r
");
$GAL_mode_select['0']['t'] = "Off";							$GAL_mode_select['0']['s'] = "";		$GAL_mode_select['0']['cmd'] = "0";
$GAL_mode_select['1']['t'] = "Stockage en base";			$GAL_mode_select['1']['s'] = "";		$GAL_mode_select['1']['cmd'] = "1";
$GAL_mode_select['2']['t'] = "Stockage dans des fichiers";	$GAL_mode_select['2']['s'] = "";		$GAL_mode_select['2']['cmd'] = "2";
$GAL_mode_select[$website['ws_gal_mode']]['s'] = " selected ";
foreach ( $GAL_mode_select as $A ) { echo ("<option value='".$A['cmd']."' ".$A['s']."> ".$A['t']."</option>\r"); }
echo ("
</select>\r
</td></tr>\r

<tr><td class='" . $theme_tableau.$_REQUEST['bloc']."_fcc " . $theme_tableau.$_REQUEST['bloc']."_t3'>".$tl_[$l]['d5_01']."</td>	<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcd " . $theme_tableau.$_REQUEST['bloc']."_t3'>&lt;nom de fichier&gt;<input type='text' name='MSW[gal_fichier_tag]' size='20' maxlength='255' value='".$website['ws_gal_fichier_tag']."' class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'></td></tr>\r
<tr><td class='" . $theme_tableau.$_REQUEST['bloc']."_fcc " . $theme_tableau.$_REQUEST['bloc']."_t3'>".$tl_[$l]['d5_02']."</td>	<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcd " . $theme_tableau.$_REQUEST['bloc']."_t3'><input type='text' name='MSW[gal_qualite]' size='20' maxlength='255' value='".$website['ws_gal_qualite']."' class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>%</td></tr>\r
<tr><td class='" . $theme_tableau.$_REQUEST['bloc']."_fcc " . $theme_tableau.$_REQUEST['bloc']."_t3'>".$tl_[$l]['d5_03']."</td>	<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcd " . $theme_tableau.$_REQUEST['bloc']."_t3'><input type='text' name='MSW[gal_x]' size='20' maxlength='255' value='".$website['ws_gal_x']."' class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>pixels</td></tr>\r
<tr><td class='" . $theme_tableau.$_REQUEST['bloc']."_fcc " . $theme_tableau.$_REQUEST['bloc']."_t3'>".$tl_[$l]['d5_04']."</td>	<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcd " . $theme_tableau.$_REQUEST['bloc']."_t3'><input type='text' name='MSW[gal_y]' size='20' maxlength='255' value='".$website['ws_gal_y']."' class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>pixels</td></tr>\r
<tr><td class='" . $theme_tableau.$_REQUEST['bloc']."_fcc " . $theme_tableau.$_REQUEST['bloc']."_t3'>".$tl_[$l]['d5_05']."</td>	<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcd " . $theme_tableau.$_REQUEST['bloc']."_t3'><input type='text' name='MSW[gal_liserai]' size='20' maxlength='255' value='".$website['ws_gal_liserai']."' class='" . $theme_tableau.$_REQUEST['bloc']."_form_1'>pixels</td></tr>\r
</table>\r
</div>\r
");
$pv['div_compteur']++;
/*MWM-content_end*/
?>
