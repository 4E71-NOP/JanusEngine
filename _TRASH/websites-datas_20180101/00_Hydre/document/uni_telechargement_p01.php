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
$_REQUEST['MM']['id'] = 10 ;
/* -------------------------------------------------------------------------------------------- */
/*	2005 09 11 : fra_gestion_des_modules_p02.php debut 											*/
/*	2007 08 16 : derniere modification															*/
/* -------------------------------------------------------------------------------------------- */
/*Hydre-contenu_debut*/

$_REQUEST['sql_initiateur'] = "uni_telechargement_p01";

$tl_['fra']['invit'] = "Section t&eacute;l&eacute;chargement.";
$tl_['eng']['invit'] = "Download section.";

echo ("
<p class='".$theme_tableau.$_REQUEST['bloc']."_lien skin_princ_".$_REQUEST['bloc']."_t3' style='text-align: justify;' >\r
".$tl_[$l]['invit']."
</p>
");

// --------------------------------------------------------------------------------------------
$i = 1;
$tl_['fra']['legende1'] = "Fichier";		$tl_['eng']['legende1'] = "File";
$tl_['fra']['legende2'] = "Taille";			$tl_['eng']['legende2'] = "Size";
$AD['1'][$i]['1']['cont']	= $tl_['fra']['legende1'];
$AD['1'][$i]['2']['cont']	= $tl_['fra']['legende2'];


$realpath = realpath ( "../websites-datas/".$site_web['sw_repertoire']."/data/public/" );
$handle = opendir( $realpath );
while (false !== ( $f = readdir($handle))) {
	if ( $f != "." && $f != ".." ) {
		$i++;
		$id = $idx_['lsdf_racine'] . $_REQUEST['lsdf_id'];
		$f_stat = stat( $realpath."/".$f );
		$AD['1'][$i]['1']['cont'] = "<a class='" . $theme_tableau.$_REQUEST['bloc']."_lien' href='../download/".$f."'>".$f."</a>";
		$AD['1'][$i]['2']['cont'] = Conversion_taille ( $f_stat['size'] );
	}
}

if ($i == 1 ) {
	$i++;
	$tl_['fra']['l2c1'] = "Répertoire vide";		$tl_['eng']['l2c1'] = "Empty directory";
	$AD['1'][$i]['1']['cont']	= $tl_['fra']['l2c1'];
	$AD['1'][$i]['2']['cont']	= "";
}


$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 1;
$tl_['fra']['onglet_1'] = "Fichiers disponibles";		$tl_['eng']['onglet_1'] = "Available files";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "d_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");
// --------------------------------------------------------------------------------------------

/*Hydre-contenu_fin*/
?>
