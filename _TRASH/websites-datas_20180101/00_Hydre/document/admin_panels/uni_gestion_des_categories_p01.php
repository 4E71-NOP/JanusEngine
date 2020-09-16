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
$_REQUEST['cate_parent'] = "39";
// --------------------------------------------------------------------------------------------
//	2005 07 20 : fra_modification_de_categorie_p01.php debut
// --------------------------------------------------------------------------------------------
$tl_['eng'][] = "?";
$tl_['fra'][] = "?";

/*Hydre-contenu_debut*/

$_REQUEST['sql_initiateur'] = "fra_modification_de_categorie_p01";


// --------------------------------------------------------------------------------------------
// Récuperation données

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT c.cate_lang, l.langue_nom_original 
FROM ".$SQL_tab_abrege['categorie']." c, ".$SQL_tab_abrege['langues']." l, ".$SQL_tab_abrege['site_langue']." sl 
WHERE c.cate_type IN ('0','1') 
AND c.cate_etat = '1' 
AND c.site_id = '2' 
AND c.cate_lang = l.langue_id 
AND l.langue_id = sl.lang_id 
AND c.site_id = sl.site_id 
AND c.site_id = '".$site_web['sw_id']."' 
GROUP BY c.cate_lang
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$pv['ListeCateLang'][$dbp['cate_lang']]['id'] = $dbp['cate_lang']; 
	$pv['ListeCateLang'][$dbp['cate_lang']]['nom'] = $dbp['langue_nom_original']; 
}

foreach ( $pv['ListeCateLang'] as $A ) {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['categorie']." 
	WHERE cate_type IN ('0','1') 
	AND cate_etat = '1' 
	AND site_id = '".$site_web['sw_id']."' 
	AND cate_lang = '".$A['id']."'
	ORDER BY  cate_parent, cate_position
	;");
	while ($dbp = fetch_array_sql($dbquery)) { 
		$pv['c'] = &$pv['CatSrc'][$A['id']][$dbp['cate_id']];
		foreach ( $dbp as $B => $C ) { $pv['c'][$B] = $C; }
	}
}

// --------------------------------------------------------------------------------------------
// Tri des données
function CateRchRacine ( $cate_type, &$src , &$dst ) {
	foreach ( $src as $A ) {
		if ( $A['cate_type'] == $cate_type ) { 
			foreach ( $A as $B => $C ) { $dst['0'][$B] = $C ; }
		}
	}
}
function CateTriTable ( $id, $niveau, &$src , &$dst ) {
	echo("off");
}

$pv['onglet'] = 1;
$pv['CatDst'] = array();
foreach ( $pv['ListeCateLang'] as $A ) {



	CateRchRacine ( 0 , $pv['CatSrc'][$A['id']] , $pv['CatDst'][$A['id']] );

}




outil_debug ( $pv['CatDst'] , "\$pv['CatDst']" );
outil_debug ( $pv['CatSrc'] , "\$pv['CatSrc']" );


/*
	$pv['ligne'] = 1;
	$AD[$pv['onglet']][$pv['ligne']]['1']['cont'] = "Titre";
	$AD[$pv['onglet']][$pv['ligne']]['2']['cont'] = "Nom";
	$AD[$pv['onglet']][$pv['ligne']]['5']['cont'] = "Pos";
	$AD[$pv['onglet']][$pv['ligne']]['6']['cont'] = "Desc";
	$pv['ligne']++;

function CateTriTable ( Source, id(en cours) , niveau ){

positionner un index a 1 
	tant que resultat=1 a été trouvé
	rechercher l'entité de la position index et dont le parent est id
	si trouvé 
		if dossier
			niveau++
			CateTriTable
			niveau--
		finsi
		index ++
		resultat = 1
	fin si
	refaire
}
*/

/*
		$AD[$pv['onglet']][$pv['ligne']]['1']['cont'] = $dbp['cate_titre'];
		if ($dbp['arti_ref'] == "0") {
			$AD[$pv['onglet']][$pv['ligne']]['1']['style'] = "font-weight:bold;";
		}
		$AD[$pv['onglet']][$pv['ligne']]['2']['cont'] = $dbp['cate_nom'];
		$AD[$pv['onglet']][$pv['ligne']]['2']['tc'] = 1;

		$AD[$pv['onglet']][$pv['ligne']]['5']['cont'] = $dbp['cate_position'];
		$AD[$pv['onglet']][$pv['ligne']]['5']['tc'] = 1;

		$AD[$pv['onglet']][$pv['ligne']]['6']['cont'] = $dbp['cate_desc'];
		$AD[$pv['onglet']][$pv['ligne']]['6']['tc'] = 1;
		$pv['ligne']++;
	}
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = ($pv['ligne']-1);	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 6;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;
	$tab_infos['cell_'.$pv['onglet'].'_txt'] = $A['nom'];
	$pv['onglet']++;
}
*/

$tl_['eng']['onglet_1'] = "Informations";		$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= ($pv['onglet']-1);
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 512;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "mb_cat1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";

//$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];


include ("routines/website/affichage_donnees.php");


/*

utiliser une requete pour trouve les langues pour lequelles on a des catégorie active
SELECT * FROM mt_categorie WHERE cate_type = '1' AND cate_etat = '1' AND site_id = '2' GROUP BY cate_lang;
Choper le nom de la langue avec

Remplir chaque onglet avec un FOR I TO NEXT
*/

/*


*/
// --------------------------------------------------------------------------------------------
/*
$tl_['eng']['ws_modif'] = "Modify";			$tl_['eng']['ws_up'] = "Move up";			$tl_['eng']['ws_down'] = "Move down";
$tl_['fra']['ws_modif'] = "Modifier";	$tl_['fra']['ws_up'] = "Faire monter";	$tl_['fra']['ws_down'] = "Faire descendre";

function menu_affichage_modif_cate () {
	global $module_, $theme_tableau , ${$theme_tableau}, $site_web, $bloc_html, $db_, $menu_principal, $function_parametres, $tl_, $l, $DP_, $_REQUEST;

	$ptr = &${$theme_tableau}[$_REQUEST['blocT']];
	foreach ( $menu_principal as $A ) {
		if ($A['cate_parent'] == $function_parametres['cate_parent'] ) {
			echo ("<tr>\r<td class='" . $theme_tableau . $_REQUEST['bloc']."_fca'>\r");
			echo str_repeat ( "<img src='../graph/".$ptr['deco_repertoire']."/".$ptr['deco_transparent_8x8']."' alt='!' border='0'>", $function_parametres['espacement'] );
			$bloc_url = $bloc_html['url_slup']."&amp;arti_ref=".$DP_['arti_ref']."&amp;M_CATEGO[nom]=".$A['cate_nom']."&amp;M_CATEGO[id]=".$A['cate_id'];
			switch (TRUE) {
			case  ( $A['arti_ref'] == "0" ):
				echo ("
				<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien'
				href='index.php?".$bloc_url."&amp;arti_page=2&amp;M_CATEGO[cate_lang]=".$A['cate_lang']."' 
 				onMouseOver = \"window.status = '".$tl_[$l]['ws_modif']." ".$A['cate_titre']."'; return true;\" 
				onMouseOut = \"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
				><span style='font-weight: bold;'>".$A['cate_titre']."</span></a></td>\r
				");
			break;
			default:
				echo ("
				<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_t1'
				href='index.php?".$bloc_url."&amp;arti_page=2&amp;M_CATEGO[cate_lang]=".$A['cate_lang']."' 
 				onMouseOver = \"window.status = '".$tl_[$l]['ws_modif']." ".$A['cate_titre']."'; return true;\" 
				onMouseOut = \"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
				>".$A['cate_titre']."</a></td>\r
				");
			break;
			}

			$cate_move_up	= $A['cate_position'] -1 ;
			$cate_move_down	= $A['cate_position'] +1 ;
			if ( $cate_move_up == 0 ) { $cate_move_up = 1; }

			echo ("
			<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb " . $theme_tableau . $_REQUEST['bloc']."_t1'> ".$A['cate_nom']." </td>
			<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb " . $theme_tableau . $_REQUEST['bloc']."_t1' style='text-align:right;'> ".$A['cate_position']." </td>
			<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb " . $theme_tableau . $_REQUEST['bloc']."_t1'>\r
			<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_t1'
			href='index.php?".$bloc_url."&amp;arti_page=1&M_CATEGO[position]=".$cate_move_up."&amp;UPDATE_action=UPDATE_CATEGORY&amp;M_CATEGO[confirmation_modification]=1' 
			onMouseOver = \"window.status = '".$tl_[$l]['ws_up']." ".$A['cate_nom']."'; return true;\" 
			onMouseOut = \"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
			><img src='../graph/".$ptr['deco_repertoire']."/".$ptr['deco_icone_haut']."' alt='!' border='0' width='16' height='16' ></a></td>\r

			<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb " . $theme_tableau . $_REQUEST['bloc']."_t1'>\r
			<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_t1'
			href='index.php?".$bloc_url."&amp;arti_page=1&M_CATEGO[position]=".$cate_move_down."&amp;UPDATE_action=UPDATE_CATEGORY&amp;M_CATEGO[confirmation_modification]=1' 
			onMouseOver = \"window.status = '".$tl_[$l]['ws_down']." ".$A['cate_nom']."'; return true;\" 
			onMouseOut = \"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
			><img src='../graph/".$ptr['deco_repertoire']."/".$ptr['deco_icone_bas']."' alt='!' border='0' width='16' height='16' ></a></td>\r
			<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb " . $theme_tableau . $_REQUEST['bloc']."_t1'> ".$A['cate_desc']." </td>\r</tr>\r
			");

			switch (TRUE) {
			case  ($A['arti_ref'] == "0"):
				$function_parametres['espacement']++;
				$function_parametres_save = $function_parametres['cate_parent'];
				$function_parametres['cate_parent'] = $A['cate_id'];
				menu_affichage_modif_cate ( $function_parametres );
				$function_parametres['cate_parent'] = $function_parametres_save;
				$function_parametres['espacement']--;
			default:
			break;
			}
		}
	}
}

// --------------------------------------------------------------------------------------------
// Recherche le menu racine du site
// --------------------------------------------------------------------------------------------
$tl_['eng']['invite1'] = "Select the categories you wish to modify in the list.";
$tl_['fra']['invite1'] = "Selectionnez la cat&eacute;gorie que vous d&eacute;sirez modifier parmis cette liste.<br>\r";

$tl_['eng']['col1'] = "Title";		$tl_['eng']['col2'] = "Name";		$tl_['eng']['col3'] = "Position";		$tl_['eng']['col4'] = "Type";		$tl_['eng']['col5'] = "Description";	
$tl_['fra']['col1'] = "Titre";	$tl_['fra']['col2'] = "Nom";	$tl_['fra']['col3'] = "Position";	$tl_['fra']['col4'] = "Type";	$tl_['fra']['col5'] = "Description";	

echo ("
<p>".$tl_[$l]['invite1']."</p>\r
<br>\r
");

$dbquery_a = requete_sql($_REQUEST['sql_initiateur'],"
SELECT cate_id,cate_lang 
FROM ".$SQL_tab_abrege['categorie']." 
WHERE cate_type = '0' 
AND cate_etat = '1' 
AND site_id = '".$site_web['sw_id']."' 
ORDER BY cate_lang
;");
while ($dbp_a = fetch_array_sql($dbquery_a)) { 
	$menu_racine = $dbp_a['cate_id']; 

// --------------------------------------------------------------------------------------------
//	Affichage en menu des categories
// --------------------------------------------------------------------------------------------
	$WM_MA_table_witdh = ${$theme_tableau}['theme_module_t62_x'] - 32 ;
	echo ("
	<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r ".$tl_[$l]['col1']." </td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r ".$tl_[$l]['col2']." </td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r ".$tl_[$l]['col3']." </td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r </td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r </td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r ".$tl_[$l]['col5']."</td>\r
	</tr>\r
	");

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['categorie']." 
	WHERE cate_type = '1' 
	AND cate_etat = '1' 
	AND site_id = '".$site_web['sw_id']."' 
	ORDER BY cate_parent,cate_position
	;");
	while ($dbp = fetch_array_sql($dbquery)) { 
		$cate_id_index = $dbp['cate_id'];
		foreach ( $dbp as $A => $B ) { $menu_principal[$cate_id_index][$A] = $B; }
	}
	
//	outil_debug ( $theme_tableau, "theme_tableau");
//	outil_debug ( $_REQUEST['bloc'] , "_REQUEST['bloc']");
//	outil_debug ( $theme_princ_['B02T'] , "{theme_tableau}[_REQUEST['bloc']]");

	$function_parametres = array (
		"cate_parent" 			=> $menu_racine,
		"espacement" 			=> 0,
	);
	menu_affichage_modif_cate ();
	unset ($menu_principal);

	echo ("
	</table>\r
	<br>\r
	<br>\r
	");
	}
// --------------------------------------------------------------------------------------------
//	Affichage des categories inactive
// --------------------------------------------------------------------------------------------

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['categorie']." 
WHERE cate_etat != '1' 
AND site_id = '".$site_web['sw_id']."' 
ORDER BY cate_parent,cate_position
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$cate_id_index = $dbp['cate_id'];
	foreach ( $dbp as $A => $B ) { $menu_principal[$cate_id_index][$A] = $B; }
}
if( num_row_sql($dbquery) != 0) {
	$tl_['eng']['cat_inactive'] = "These categories are inactive categories. This means the public don't have acces to it.<br>\r<br>\rSelect the categories you wish to modify in the list.";
	$tl_['fra']['cat_inactive'] = "Les cat&eacute;gories ci-dessous sont les cat&eacute;gorie marqu&eacute;es inactives. Cela signifie qu'elle ne sont pas accessibles pour le public.<br>\r<br>\rSelectionnez la cat&eacute;gorie que vous d&eacute;sirez modifier parmis cette liste.<br>\r";

	echo ("
	<p>
	".$tl_[$l]['cat_inactive']." 
	</p>\r
	<hr>\r
	<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
	<tr>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r".$tl_[$l]['col1']." </td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r".$tl_[$l]['col2']." </td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r".$tl_[$l]['col4']." </td>\r
	<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta " . $theme_tableau . $_REQUEST['bloc']."_tb3'>\r".$tl_[$l]['col5']." </td>\r
	</tr>\r
	");

	foreach ( $menu_principal as $A ) {
		echo ("
		<tr><td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta'>
		<a class='".$theme_tableau."s0".$module_['module_deco_nbr']."_a_t2' href='index.php?
".$bloc_html['url_slup']."
&amp;arti_ref=".$DP_['arti_ref']."
&amp;arti_page=2
&M_CATEGO[id]=".$A['cate_id']."
' onMouseOver = \"window.status = '".$tl_[$l]['ws_modif'] ." ".$A['cate_titre']."'; return true;\" 
 onMouseOut = \"window.status = '".$site_web['sw_barre_status']."'; return true;\">
		<span style='font-weight: bold;'>".$A['cate_titre']."</span></a>(".$A['cate_position'].")</td>\r
		<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta'>".$A['cate_nom']."</td>\r
		<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcb'>".$A['cate_desc']."</td>\r
		");
		if ( $A['arti_ref'] == 0 ) { echo ("Dossier"); }
		else { echo ("Article"); }
		echo ("
		</td>\r
		<td class='" . $theme_tableau . $_REQUEST['bloc']."_fcta'>".$A['cate_desc']."</td>\r
		</tr>\r
		");
	}
	unset ($menu_principal);
	echo ("
	</table>\r
	<br>\r
	<br>\r
");
}
*/
if ( $site_web['sw_info_debug'] < 10 ) { 
	unset ( 
		$pv,
		$WM_MA_table_witdh , 
		$cate_id_index , 
		$function_parametres , 
		$tl_  
	); 
}


/*Hydre-contenu_fin*/
?>
