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
//	2005 05 11 : uni_execution_de_scripts_p01.php debut
//	2007 08 16 : derniere modification
// --------------------------------------------------------------------------------------------
$_REQUEST['mode_test'] = 1;

/*Hydre-contenu_debut*/
$l = $langues[$site_web['sw_lang']]['langue_639_3'];

$pv['colone_taille']		= 48;
$pv['colone_modification']	= 128;
$pv['colone_nom']			= ${$theme_tableau}['theme_module_largeur_interne'] - $pv['colone_taille'] - $pv['colone_modification'] - 32;

$tl_['eng']['invite1'] = "This part will help you test some PHP code. 
Enter a filename and you will be able to test it directly inside the MWM engine. 
The file must be located in the 'Document' directory.<br>\r";
$tl_['fra']['invite1'] = "Cette partie va vous permettre de tester du code PHP. 
Entrez un nom de fichier qui contient un script PHP et vous pourrez le tester directement dans l'interface de WebMachine. 
Le fichier doit se trouver dans le repertoire 'Document'.<br>\r";

/*
$tl_['eng']['tl1'] = "File list in the 'Document' directory"; 
$tl_['fra']['tl1'] = "Liste des fichiers pr&eacute;sents dans le r&eacute;pertoire 'Document'."; 

$tl_['eng']['c1'] = "File";	$tl_['eng']['c2'] = "Size";	$tl_['eng']['c3'] = "Last modification";
$tl_['fra']['c1'] = "Fichier";	$tl_['fra']['c2'] = "Taille";	$tl_['fra']['c3'] = "Derni&egrave;re modification";
*/

// --------------------------------------------------------------------------------------------
echo ("
<p>\r
".$tl_[$l]['invite1']."
<br>\r
");

if ( !isset($_REQUEST['WM_EDS_script_id']) ) { $_REQUEST['WM_EDS_script_id'] = "test_001.php"; }
if ( !isset($_REQUEST['WM_EDS_script_rep']) ) { $_REQUEST['WM_EDS_script_rep'] = $site_web['sw_repertoire']; }
if ( !isset($_REQUEST['WM_EDS_script_file']) ) { $_REQUEST['WM_EDS_script_file'] = "../websites-datas/".$_REQUEST['WM_EDS_script_rep']."/document/".$_REQUEST['WM_EDS_script_id']; }


$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_eds";
$fsi['champs']					= "WM_EDS_script_file";
$fsi['lsdf_chemin']				= "../websites-datas/".$site_web['sw_repertoire']."/document";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 20;
$fsi['lsdf_indicatif']			= "EDS";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 0;
$fsi['lsdf_conserve_chemin']	= "";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']		= array();

echo ("
<form name='formulaire_eds' ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<table cellpadding='0' cellspacing='0' style='width :". (${$theme_tableau}['theme_module_largeur_interne'] - 16) ."px;'>
<tr>\r
<td>\r" .
generation_icone_selecteur_fichier ( 1 , $fsi['formulaire'] , $fsi['champs'] , 40 , $_REQUEST['WM_EDS_script_file'] , "TabSDF_".$fsi['lsdf_indicatif'] )
. "
</td>\r
<td>\r
</td>\r
</tr>\r

<tr>\r
<td>\r
</td>\r
<td>\r
");

$tl_['eng']['bouton_exec'] = "Execute";
$tl_['fra']['bouton_exec'] = "Executer";

$_REQUEST['BS']['id']				= "bouton_execution";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton_exec'];
$_REQUEST['BS']['mode']				= 0;
$_REQUEST['BS']['taille'] 			= 0;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();

echo ("
</td>\r
</tr>\r
</table>\r

<br>\r
</form>\r
<hr>\r
");

if ( file_exists($_REQUEST['WM_EDS_script_file']) && $_REQUEST['mode_test'] == 0 ) { 
	$pv['extenssion'] = substr( $_REQUEST['WM_EDS_script_file'] , -8 ) ;
	if ( $pv['extenssion'] == ".mwmcode" ) { 
		$pv['eds_fichier_handle'] = fopen($_REQUEST['WM_EDS_script_file'],"r");
		$pv['eds_fichier_data'] = fread($pv['eds_fichier_handle'],filesize($_REQUEST['WM_EDS_script_file']));
		if ( !function_exists(document_convertion)) { include ("routines/website/module_affiche_document_convert.php"); }
		$tl_['eng']['tf1'] = "MWM code mode";
		$tl_['fra']['tf1'] = "Passage en mode MWM";
		echo ( $tl_[$l]['tf1'] . "<br>\r<hr>\r" . document_convertion ( $pv['eds_fichier_data'] , ${$document_tableau}['arti_ref']."_p0".${$document_tableau}['arti_page'] ));
		fclose($pv['eds_fichier_handle']);
	}
	else { include ( $_REQUEST['WM_EDS_script_file'] ); }
}

/*
Le fichier existe toujours car on a bloqué l'affichage sur le résultat du selecteur de fichier. 
else { echo ("Fichier non trouv&eacute; <br>\r"); }
*/


if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp , 
		$dbquery , 
		$fc_class_ , 
		$handle, 
		$liste_fichier,
		$pv,
		$tl_,
		$CTZ_liste_repertoire,
		$file_stat
	);
}

/*Hydre-contenu_fin*/
?>
