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
//	2008 04 21 : uni_ecriture_des_documents_p01.php debut
// --------------------------------------------------------------------------------------------
$user['groupe_tag'] = 3;

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_documents_p01.php";
// --------------------------------------------------------------------------------------------

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT doc.docu_id, doc.docu_nom, doc.docu_type, part.part_modification 
FROM ".$SQL_tab_abrege['document']." doc, ".$SQL_tab_abrege['document_partage']." part 
WHERE part.site_id = '".$site_web['sw_id']."' 
AND part.docu_id = doc.docu_id 
AND doc.docu_origine = '".$site_web['sw_id']."' 
ORDER BY docu_id, docu_type, part_modification ASC
;");
if ( num_row_sql($dbquery) == 0 ) {
	$tl_['txt']['eng']['raf1'] = "Nothing to display";			$tl_['txt']['fra']['raf1'] = "Rien a afficher";

	$i = 1;
	$AD['1'][$i]['1']['cont'] = $tl_['txt'][$l]['raf1'];
	$AD['1'][$i]['2']['cont'] = "";
	$AD['1'][$i]['3']['cont'] = "";
	$AD['1'][$i]['4']['cont'] = "";
}
else {
	while ($dbp = fetch_array_sql($dbquery)) {
		$pv['doc_liste'][$dbp['docu_id']]['docu_nom']			= $dbp['docu_nom'];
		$pv['doc_liste'][$dbp['docu_id']]['docu_id']			= $dbp['docu_id'];
		$pv['doc_liste'][$dbp['docu_id']]['docu_type']			= $dbp['docu_type'];
		$pv['doc_liste'][$dbp['docu_id']]['part_modification']	= $dbp['part_modification'];
		$pv['doc_liste'][$dbp['docu_id']]['edition'] = 1;
	}
	$pv['clause'] = " IN ( ";
	foreach ( $pv['doc_liste'] as $A ) { $pv['clause'] .= "'".$A['docu_id']."', ";	}
	$pv['clause'] = substr( $pv['clause'] , 0 , -2 ) . ") ";
	unset ($A);

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT dcm.docu_id, art.arti_id, bcl.bouclage_id, dcm.docu_nom 
	FROM ".$SQL_tab_abrege['article']." art, ".$SQL_tab_abrege['bouclage']." bcl , ".$SQL_tab_abrege['document']." dcm
	WHERE art.docu_id ".$pv['clause']." 
	AND dcm.docu_id = art.docu_id 
	AND art.arti_bouclage = bcl.bouclage_id 
	AND bcl.bouclage_etat = '1' 
	AND art.site_id = '".$site_web['sw_id']."'
	ORDER BY dcm.docu_id ASC 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { $pv['doc_liste'][$dbp['docu_id']]['edition'] = 0; }

	$trr['nbr_col'] = 4;

	$tl_['txt']['eng']['invite1'] = "This part will allow you to modify documents.";
	$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de modifier les documents.";

	$tl_['txt']['eng']['col_1_txt'] = "Name";									$tl_['txt']['fra']['col_1_txt'] = "Nom";
	$tl_['txt']['eng']['col_2_txt'] = "Type";									$tl_['txt']['fra']['col_2_txt'] = "Type";
	$tl_['txt']['eng']['col_3_txt'] = "Can be modified by another site ?";		$tl_['txt']['fra']['col_3_txt'] = "Modifiable par un autre site ?";
	$tl_['txt']['eng']['col_4_txt'] = "Online ?";								$tl_['txt']['fra']['col_4_txt'] = "En ligne ?";

	// docu_modif					WMCODE 0	NOCODE 1	PHP 2	MIXED 3
	$tl_['type']['0']['eng'] = "MWM code";		$tl_['type']['0']['fra'] = "Code MWM";
	$tl_['type']['1']['eng'] = "No code";		$tl_['type']['1']['fra'] = "Pas de code";
	$tl_['type']['2']['eng'] = "PHP";			$tl_['type']['2']['fra'] = "PHP";
	$tl_['type']['3']['eng'] = "Mixed";			$tl_['type']['3']['fra'] = "Mix&eacute;";

	$tl_['modif']['0']['eng'] = "No";			$tl_['modif']['0']['fra'] = "Non";
	$tl_['modif']['1']['eng'] = "Yes";			$tl_['modif']['1']['fra'] = "Oui";

	$tl_['edition']['0']['eng'] = "Yes";		$tl_['edition']['0']['fra'] = "Oui";
	$tl_['edition']['1']['eng'] = "No";			$tl_['edition']['1']['fra'] = "Non";

	$pv['level']['0'] = 2;	$pv['level']['1'] = 4;	$pv['level']['2'] = 8;	$pv['level']['3'] = 16;
	$pv['edlvl'] = $pv['level'][$user['groupe_tag']];

	$i = 1;
	$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
	$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
	$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
	$AD['1'][$i]['4']['cont']	= $tl_['txt'][$l]['col_4_txt'];

	foreach ( $pv['doc_liste'] as $A ) { 
		$i++;
		switch ( $pv['edlvl'] + $A['edition'] ) {
		case 9 :
		case 16 :
		case 17 :
			$AD['1'][$i]['1']['cont']	= "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?
&amp;M_DOCUME[document_selection]=".$A['docu_id'].
$bloc_html['url_sldup']."
&amp;arti_page=2'>".$A['docu_nom']."</a>";
		break;
		default:
			$AD['1'][$i]['1']['cont'] = $A['docu_nom'];
		break;
		} 
		$AD['1'][$i]['2']['cont']	= $tl_['type'][$A['docu_type']][$l];
		$AD['1'][$i]['3']['cont']	= $tl_['modif'][$A['part_modification']][$l];
		$AD['1'][$i]['4']['cont']	= $tl_['edition'][$A['edition']][$l];
	}
}

$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 4;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "edc_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

echo ("<br>\r&nbsp;
</form>\r
</td>\r
</tr>\r
</table>\r
<br>\r
");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp,
		$dbquery,
		$fc_class_,
		$tab_etat,
		$tl_,
		$trr
	);
}
/*Hydre-contenu_fin*/
?>
