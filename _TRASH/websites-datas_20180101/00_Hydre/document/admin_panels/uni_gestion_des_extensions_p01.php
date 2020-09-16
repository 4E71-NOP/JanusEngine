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

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_extensions_p01.php";

$tl_['txt']['eng']['invite1'] = "This part will allow you to manage extensions.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de g&eacute;rer les extensions.";

$tl_['txt']['eng']['col_1_txt'] = "Available extension";	$tl_['txt']['fra']['col_1_txt'] = "Extensions disponibles";
$tl_['txt']['eng']['col_2_txt'] = "Version";				$tl_['txt']['fra']['col_2_txt'] = "Version";
$tl_['txt']['eng']['col_3_txt'] = "Installed";				$tl_['txt']['fra']['col_3_txt'] = "Install&eacute;";
$tl_['txt']['eng']['col_4_txt'] = "Action #1";				$tl_['txt']['fra']['col_4_txt'] = "Action #1";
$tl_['txt']['eng']['col_5_txt'] = "Action #2";				$tl_['txt']['fra']['col_5_txt'] = "Action #2";

// --------------------------------------------------------------------------------------------
if ( $user['groupe_tag'] == 3 ) {
	$pv['extensions_liste_rep'] = array();
	$handle = opendir("../extensions/");
	while (false !== ($file = readdir($handle))) {
		if ( $file != "." && $file != ".." && !is_file("../extensions/".$file)  ) { $pv['extensions_liste_rep'][] = $file; }
	}

	unset ( $A );
	$pv['i'] = 0;
	foreach ( $pv['extensions_liste_rep'] as $A ) {
		$B = "../extensions/".$A."/extension_config.php";
		if ( file_exists ( $B ) ) { include ( $B ); }
		else {
			$extensions_['donnees'][$pv['i']]['introuvable'] = 1;
			$extensions_['donnees'][$pv['i']]['repertoire_vide'] = $A;
		}
		$pv['i']++;
	}

	unset ( $A );
	foreach ( $extensions_['donnees'] as &$A ) {
		if ( $A['introuvable'] != 1 ) {
			$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
			SELECT ext.* 
			FROM ".$SQL_tab_abrege['extension']." ext 
			WHERE ext.site_id = '".$site_web['sw_id']."' 
			AND ext.extension_nom = '".$A['extension_nom']."'
			;");
			if ( num_row_sql( $dbquery ) != 0 ) { $A['extension_etat'] = 1; }
		}
	}

	$tl_['eng']['tab1'][0] = "No";				$tl_['fra']['tab1'][0] = "Non";
	$tl_['eng']['tab1'][1] = "Yes";				$tl_['fra']['tab1'][1] = "Oui";
	$tl_['eng']['tab2'][0] = "Activate";		$tl_['fra']['tab2'][0] = "Activer";
	$tl_['eng']['tab2'][1] = "Reinstall";		$tl_['fra']['tab2'][1] = "R&eacute;installer";
	$tl_['eng']['tab3'][0] = "Delete";			$tl_['fra']['tab3'][0] = "Supprimer";
	$tl_['eng']['tab3'][1] = "Deactivate";		$tl_['fra']['tab3'][1] = "D&eacute;sactiver";

	unset ( $A );
	$pv['i'] = 1;
	$AD['1'][$pv['i']]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
	$AD['1'][$pv['i']]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
	$AD['1'][$pv['i']]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
	$AD['1'][$pv['i']]['4']['cont']	= $tl_['txt'][$l]['col_4_txt'];
	$AD['1'][$pv['i']]['5']['cont']	= $tl_['txt'][$l]['col_5_txt'];
	foreach ( $extensions_['donnees'] as $A ) {
		if ( $A['introuvable'] != 1 ) {
			$pv['i']++;
			$AD['1'][$pv['i']]['1']['cont'] = $A['extension_nom'];
			$AD['1'][$pv['i']]['2']['cont'] = $A['extension_version'];
			$AD['1'][$pv['i']]['3']['cont'] = $tl_[$l]['tab1'][$A['extension_etat']];

			$_REQUEST['BS']['id']				= "bouton_install1";
			$_REQUEST['BS']['type']				= "submit";
			$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
			$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
			$_REQUEST['BS']['onclick']			= "";
			$_REQUEST['BS']['message']			= $tl_[$l]['tab2'][$A['extension_etat']];
			$_REQUEST['BS']['mode']				= 0;
			$_REQUEST['BS']['taille'] 			= 0;
			$_REQUEST['BS']['derniere_taille']	= 0;
			$AD['1'][$pv['i']]['4']['cont']		= "<br>\r&nbsp;
			<form ACTION='index.php?' method='post' name='formulaire_install1'>\r".
			$bloc_html['post_hidden_sw'].
			$bloc_html['post_hidden_l'].
			$bloc_html['post_hidden_arti_ref']."
			<input type='hidden' name='arti_page'						value='2'>\r
			<input type='hidden' name='M_EXTENS[extension_nom]'			value='".$A['extension_nom']."'>\r
			<input type='hidden' name='M_EXTENS[extension_repertoire]'	value='".$A['extension_repertoire']."'>\r
			<input type='hidden' name='M_EXTENS[extension_requete]'		value='Installer'>\r
			<input type='hidden' name='uni_gestion_des_extensions_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
			". generation_bouton () . "</form>\r<br>\r&nbsp;";

			$_REQUEST['BS']['id']				= "bouton_supprime1";
			$_REQUEST['BS']['type']				= "submit";
			$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
			$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
			$_REQUEST['BS']['onclick']			= "";
			$_REQUEST['BS']['message']			= $tl_[$l]['tab3'][$A['extension_etat']];
			$_REQUEST['BS']['mode']				= 0;
			$_REQUEST['BS']['taille'] 			= 0;
			$_REQUEST['BS']['derniere_taille']	= 0;
			$AD['1'][$pv['i']]['5']['cont']		= "<br>\r&nbsp;
			<form ACTION='index.php?' method='post' name='formulaire_install1'>\r".
			$bloc_html['post_hidden_sw'].
			$bloc_html['post_hidden_l'].
			$bloc_html['post_hidden_arti_ref']."
			<input type='hidden' name='arti_page'						value='2'>\r
			<input type='hidden' name='M_EXTENS[extension_nom]'			value='".$A['extension_nom']."'>\r
			<input type='hidden' name='M_EXTENS[extension_repertoire]'	value='".$A['extension_repertoire']."'>\r
			<input type='hidden' name='M_EXTENS[extension_requete]'		value='Supprimer'>\r
			<input type='hidden' name='uni_gestion_des_extensions_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
			". generation_bouton () . "</form>\r<br>\r&nbsp;";
		}
		if ( $A['extension_etat'] == 1 ) {
			$_REQUEST['BS']['id']				= "bouton_retirer1";
			$_REQUEST['BS']['type']				= "submit";
			$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_n";
			$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_h";
			$_REQUEST['BS']['onclick']			= "";
			$_REQUEST['BS']['message']			= $tl_[$l]['tab3'][$A['extension_etat']];
			$_REQUEST['BS']['mode']				= 0;
			$_REQUEST['BS']['taille'] 			= 0;
			$_REQUEST['BS']['derniere_taille']	= 0;
			$AD['1'][$pv['i']]['5']['cont']		= "<br>\r&nbsp;
			<form ACTION='index.php?' method='post' name='formulaire_Retire1'>\r".
			$bloc_html['post_hidden_sw'].
			$bloc_html['post_hidden_l'].
			$bloc_html['post_hidden_arti_ref'].
			"<input type='hidden' name='arti_page'						value='2'>\r
			<input type='hidden' name='M_EXTENS[extension_repertoire]'	value='".$A['extension_repertoire']."'>\r
			<input type='hidden' name='M_EXTENS[extension_requete]'		value='Retirer'>\r
			<input type='hidden' name='uni_gestion_des_extensions_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
			". generation_bouton () . "</form>\r<br>\r&nbsp;";
		}
	}

	$ADC['onglet']['1']['nbr_ligne'] = $pv['i'];	$ADC['onglet']['1']['nbr_cellule'] = 5;	$ADC['onglet']['1']['legende'] = 1;
	$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

	$tab_infos['AffOnglet']			= 1;
	$tab_infos['NbrOnglet']			= 1;
	$tab_infos['tab_comportement']	= 0;
	$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
	$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
	$tab_infos['doc_height']		= 256;
	$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
	$tab_infos['groupe']			= "edc_grp1";
	$tab_infos['cell_id']			= "tab";
	$tab_infos['document']			= "doc";
	$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
	include ("routines/website/affichage_donnees.php");
}
else { echo ("!!!!!!!!!!!!!!!!"); }

/*Hydre-contenu_fin*/
?>
