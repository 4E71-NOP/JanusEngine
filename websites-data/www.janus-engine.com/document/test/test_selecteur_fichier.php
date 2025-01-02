<?php
 /*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_TST";
$fsi['champs']					= "fonkytext";
$fsi['lsdf_chemin']				= "../modules/";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 10;
$fsi['lsdf_indicatif']			= "TSTSDF";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 1;
$fsi['lsdf_conserve_chemin']	= "modules/";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']			= array();
echo ("
FS_index=" . $_REQUEST['FS_index']."
<form name='".$fsi['formulaire']."' id='".$fsi['formulaire']."'>\r");
echo ( generation_icone_selecteur_fichier ( 1 , $fsi['formulaire'] , $fsi['champs'] , 50 , "selection fichier" , "TabSDF_".$fsi['lsdf_indicatif'] ) );

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_TST";
$fsi['champs']					= "fonkytext2";
$fsi['lsdf_chemin']				= "../media/theme/";
$fsi['mode_selection']			= "repertoire";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 10;
$fsi['lsdf_indicatif']			= "TSTSDF2";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 0;
$fsi['lsdf_conserve_chemin']	= "graph/";
$fsi['lsdf_coupe_repertoire']	= 1;
$fsi['liste_fichier']			= array();
echo ( generation_icone_selecteur_fichier ( 3 , $fsi['formulaire'] , $fsi['champs'] , 50 , "selection fichier" , "TabSDF_".$fsi['lsdf_indicatif'] ) );

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_TST";
$fsi['champs']					= "fonkytext3";
$fsi['lsdf_chemin']				= "../websites-datas/".$website['ws_directory']."/document";
$fsi['mode_selection']			= "repertoire";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 10;
$fsi['lsdf_indicatif']			= "TSTSDF3";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 0;
$fsi['lsdf_conserve_chemin']	= "";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']			= array();
echo ( generation_icone_selecteur_fichier ( 3 , $fsi['formulaire'] , $fsi['champs'] , 50 , "selection fichier" , "TabSDF_".$fsi['lsdf_indicatif'] ) );

echo ("</form>\r");
echo ("<hr>");

?>
