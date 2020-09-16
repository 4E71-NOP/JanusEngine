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
//	2005 04 18 : Routine d'affichage du contenu du document.
// 日本語 Русский لعربية		<---- on peut !!!!!
// --------------------------------------------------------------------------------------------
$localisation = " / module_affiche_document";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_affiche_document");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_affiche_document");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_affiche_document");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );
$_REQUEST['sql_initiateur'] = "Affichage contenu du document";

// --------------------------------------------------------------------------------------------

$tl_['eng']['parution1'] = "Edited on ";		$tl_['fra']['parution1'] = "Edit&eacute; en ";
$tl_['eng']['par1'] = " by ";					$tl_['fra']['par1'] = " par ";
$tl_['eng']['maj1'] = " update : ";				$tl_['fra']['maj1'] = " mise a jour : ";

$l = $langues[$WebSiteObj->getWebSiteEntry('sw_lang')]['langue_639_3'];

$DT = &${$document_tableau};
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT art.*, doc.docu_id, doc.docu_nom, doc.docu_type, 
doc.docu_createur, doc.docu_creation_date, 
doc.docu_correcteur, doc.docu_correction_date, 
doc.docu_origine, doc.docu_cont, sit.sw_repertoire 
FROM ".$SQL_tab_abrege['article']." art, ".$SQL_tab_abrege['document']." doc, ".$SQL_tab_abrege['bouclage']." bcl, ".$SQL_tab_abrege['site_web']." sit 
WHERE art.arti_ref = '".$affdoc_arti_ref."' 
AND art.arti_page = '".$affdoc_arti_page."' 
AND art.docu_id = doc.docu_id 
AND art.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
AND sit.sw_id = doc.docu_origine 
AND art.arti_bouclage = bcl.bouclage_id 
AND bcl.bouclage_etat = '1' 
;");

if ( num_row_sql($dbquery) == 0 ) {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT doc.* 
	FROM ".$SQL_tab_abrege['document']." doc, ".$SQL_tab_abrege['document_partage']." dp 
	WHERE doc.docu_nom LIKE '%article_inexistant%' 
	AND dp.docu_id = doc.docu_id 
	AND dp.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
	;");
}

unset ( $A , $B );
while ($dbp = fetch_array_sql($dbquery)) { 
	foreach ( $dbp as $A => $B ) { $DT[$A] = $B; }
}
$DT['arti_creation_date']		= date ("Y M d - H:i:s",$DT['arti_creation_date']);
$DT['arti_validation_date']		= date ("Y M d - H:i:s",$DT['arti_validation_date']);
$DT['arti_parution_date']		= date ("Y M d - H:i:s",$DT['arti_parution_date']);
$DT['docu_creation_date']		= date ("Y M d - H:i:s",$DT['docu_creation_date']);
$DT['docu_correction_date']		= date ("Y M d - H:i:s",$DT['docu_correction_date']);
$DT['docu_cont_brut']			= $document_contenu = $DT['docu_cont'];

$liste_document = array();
$LD_idx = 1;
$liste_document[$LD_idx]['arti_id']						= $DT['arti_id'];
$liste_document[$LD_idx]['arti_titre']					= $DT['arti_titre'];
$liste_document[$LD_idx]['arti_creation_createur']		= $DT['arti_creation_createur'];
$liste_document[$LD_idx]['arti_creation_date']			= $DT['arti_creation_date'];
$liste_document[$LD_idx]['arti_validation_validateur']	= $DT['arti_validation_validateur'];
$liste_document[$LD_idx]['arti_validation_date']		= $DT['arti_validation_date'];
$LD_idx++;
$liste_document[$LD_idx]['docu_id']						= $DT['docu_id'];
$liste_document[$LD_idx]['docu_nom']					= $DT['docu_nom'];
$liste_document[$LD_idx]['docu_createur']				= $DT['docu_createur'];
$liste_document[$LD_idx]['docu_creation_date']			= $DT['docu_creation_date'];
$liste_document[$LD_idx]['docu_correcteur']				= $DT['docu_correcteur'];
$liste_document[$LD_idx]['docu_correction_date']		= $DT['docu_correction_date'];
$LD_idx++;


$position_float['0'] = "none";
$position_float['1'] = "left";
$position_float['2'] = "right";
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab['article_config']." 
WHERE config_id = '".$DT['config_id']."'
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$DT['arti_menu_type']					= $dbp['config_menu_type'];
	$DT['arti_menu_style']					= $dbp['config_menu_style'];
	$pv['1']								= $dbp['config_menu_float_position'];
	$DT['arti_menu_float_position']			= $position_float[$pv['1']];
	$DT['arti_menu_float_taille_x']			= $dbp['config_menu_float_taille_x'];
	$DT['arti_menu_float_taille_y']			= $dbp['config_menu_float_taille_y'];
	$DT['arti_menu_occurence']				= $dbp['config_menu_occurence'];
	$DT['arti_montre_info_parution']		= $dbp['config_montre_info_parution'];
	$DT['arti_montre_info_modification']	= $dbp['config_montre_info_modification'];
}
//outil_debug ( $DT , "\$DT" );
// --------------------------------------------------------------------------------------------
//	Recupere le nombre de page de l'article
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT COUNT(docu_id) AS arti_nbr_page 
	FROM ".$SQL_tab_abrege['article']." art, ".$SQL_tab_abrege['bouclage']." bcl 
	WHERE art.arti_ref = '".$affdoc_arti_ref."'
	AND art.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
	AND art.arti_bouclage = bcl.bouclage_id
	AND bcl.bouclage_etat = '1'
	;");
while ($dbp = fetch_array_sql($dbquery)) { $pv['docu_nbr_page'] = $dbp['arti_nbr_page']; }

// --------------------------------------------------------------------------------------------
//	Traitement du document
// --------------------------------------------------------------------------------------------
//	On fait le menu si on a besoin
// --------------------------------------------------------------------------------------------
$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G";
$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T";

echo ( "
<table class='" . $theme_tableau.$_REQUEST['bloc']."_ft'>\r
<tr>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_ft1'></td>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_ft2 " . $theme_tableau.$_REQUEST['bloc']."_tb7'>".$DT['arti_titre']."</td>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_ft3'></td>\r
</tr>\r
</table>\r
<br>\r
<span class='" . $theme_tableau.$_REQUEST['bloc']."_tb4'>". $DT['arti_sous_titre'] ."</span>
<br>\r
<br>\r
<div id='document_contenu' class='" . $theme_tableau.$_REQUEST['bloc']."_div_std'>
");

if ( $pv['docu_nbr_page'] > 1 && $DT['arti_menu_type'] > 0 ) {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT art.arti_id, art.arti_ref, art.arti_sous_titre, art.arti_page, bcl.bouclage_nom 
	FROM ".$SQL_tab_abrege['article']." art, ".$SQL_tab_abrege['bouclage']." bcl 
	WHERE art.arti_ref = '".$affdoc_arti_ref."' 
	AND art.arti_validation_etat = '1' 
	AND art.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
	AND art.arti_bouclage = bcl.bouclage_id
	AND bcl.bouclage_etat = '1'
	;");
	$pv['1'] = 1;
	$pv['2'] = $DT['arti_page'];
	$tab_menu_selected[$pv['2']] = " selected";
	while ($dbp = fetch_array_sql($dbquery)) {
		$P2P_tab_[$pv['1']]['arti_id']			= $dbp['arti_id'];
		$P2P_tab_[$pv['1']]['arti_ref']			= $dbp['arti_ref'];
		$P2P_tab_[$pv['1']]['arti_sous_titre']	= $dbp['arti_sous_titre'];
		$P2P_tab_[$pv['1']]['arti_page']		= $dbp['arti_page'];
		$P2P_tab_[$pv['1']]['arti_ref']			= $dbp['arti_ref'];
		$P2P_tab_[$pv['1']]['lien']				= " 
		<a class='" . $theme_tableau.$_REQUEST['bloc']."_lien " . $theme_tableau.$_REQUEST['bloc']."_t2' 
		href='index.php?sw=".$WebSiteObj->getWebSiteEntry('sw_id')."&amp;l=".$WebSiteObj->getWebSiteEntry('sw_lang')."&amp;arti_ref=".$dbp['arti_ref']."&amp;arti_page=".$dbp['arti_page']."&amp;user_login=".$user['login']."&amp;user_pass=".$user['pass']."' 
		onMouseOver=\"Bulle('Aller a : ". addslashes($dbp['arti_sous_titre']) .", en page ".$dbp['arti_page']."'); window.status = 'Article : ". addslashes($dbp['arti_sous_titre']) ."'; return true;\" 
		onMouseOut=\"Bulle(); window.status = '".$WebSiteObj->getWebSiteEntry('sw_barre_status')."'; return true;\">".$dbp['arti_page']." ".$dbp['arti_sous_titre']."</a>\r
		";
		$P2P_tab_[$pv['1']]['menu_select']		= "<option value='".$dbp['arti_page']."' ".$tab_menu_selected[$pv['1']].">".$dbp['arti_sous_titre']."</option>\r";
		$pv['1']++;
	}

	$pv['p2p_count'] = $pv['1'] -1;

// --------------------------------------------------------------------------------------------

	switch ( $DT['arti_menu_type'] ) {
	case "1":
		$i = 1;
		foreach ( $P2P_tab_ as $A ) {
			if ( $A['arti_page'] == $affdoc_arti_page ) { 
				$AD['1'][$i]['1']['cont'] = $A['arti_page']." ".$A['arti_sous_titre'];
				$pv['p2p_marque'] = $A['arti_page'];
			}
			else { $AD['1'][$i]['1']['cont'] = $A['lien']; }
			$i++;
		}

		$ADC['onglet']['1']['nbr_ligne'] = ($i-1);	$ADC['onglet']['1']['nbr_cellule'] = 1;	$ADC['onglet']['1']['legende'] = 0;
		$tl_['eng']['onglet_1'] = "Index";	$tl_['fra']['onglet_1'] = "Index";

		$tab_infos['AffOnglet']			= 1;
		$tab_infos['NbrOnglet']			= 1;
		$tab_infos['tab_comportement']	= 1;
		$tab_infos['mode_rendu']		= 1;
		$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
		$tab_infos['doc_height']		= 64;
		$tab_infos['doc_width']			= floor(${$theme_tableau}['theme_module_largeur_interne']/3);
		$tab_infos['groupe']			= "arti_menu1";
		$tab_infos['cell_id']			= "tab";
		$tab_infos['document']			= "doc";
		$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
		include ("routines/website/affichage_donnees.php");
		$tab_infos['mode_rendu']		= 0;
		$document_menu_contenu .= $pv['rendu'];
	break;

	case "2":
		$document_menu_contenu = "
		<form ACTION='index.php?' method='post'>\r".
		$bloc_html['post_hidden_sw'].
		$bloc_html['post_hidden_l'].
		$bloc_html['post_hidden_arti_ref'].
		$bloc_html['post_hidden_user_login'].
		$bloc_html['post_hidden_user_pass']."
		<table style='border:1px solid #000000; box-shadow:8px 5px 5px #80808080;'>\r
		<tr>\r
		<td class='".$theme_tableau.$_REQUEST['bloc']."_fcta ".$theme_tableau.$_REQUEST['bloc']."_tb5'>
		Index
		</td>\r
		</tr>\r
		
		<tr>\r
		<td class='".$theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_tb5'>
		<select name='arti_page' class='".$theme_tableau.$_REQUEST['bloc']."_form_1 ".$theme_tableau.$_REQUEST['bloc']."_t3' style='padding:5px;' onChange=\"javascript:this.form.submit();\">\r";
		$pv['1'] = 1;
		foreach ( $P2P_tab_ as $A ) {
			if ( $A['arti_page'] == $affdoc_arti_page ) { $pv['p2p_marque'] = $A['arti_page']; }
			$document_menu_contenu .= $A['menu_select'];
		}
		$document_menu_contenu .= "</select>\r
		</tr>\r
		</table>\r
		</form>\r
		";

	break;
	default:
		$document_menu_contenu = "plop";
	break;
	}

// --------------------------------------------------------------------------------------------
	switch ( $DT['arti_menu_style'] ) {
	case "0":
	case "1":
		$document_menu_contenu = "<div id='document_menu' class='" . $theme_tableau.$_REQUEST['bloc']."_div_std' style='padding: 10px;'>\r" . $document_menu_contenu . "</div>\r";
	break;
	case "2":
		( $DT['arti_menu_float_taille_x'] != 0 ) ? $tab_float_['taille_x'] = "width: ".$DT['arti_menu_float_taille_x']."px;" : $tab_float_['taille_x'] = "width:auto; ";
		( $DT['arti_menu_float_taille_y'] != 0 ) ? $tab_float_['taille_y'] = "height: ".$DT['arti_menu_float_taille_y']."px;" : $tab_float_['taille_y'] = "height:auto; ";
		$document_menu_contenu = "<div id='document_menu' class='" . $theme_tableau.$_REQUEST['bloc']."_div_std' style='float:".$DT['arti_menu_float_position']."; ".$tab_float_['taille_x']." ".$tab_float_['taille_y']." padding: 10px;'>\r" . $document_menu_contenu . "</div>\r";
	break;
	}
}

// --------------------------------------------------------------------------------------------
//	Evalutation du document et affichage
// --------------------------------------------------------------------------------------------
switch ( $DT['arti_menu_occurence'] ) {
case "1": 
case "3": 
	echo $document_menu_contenu;
break;
}

// --------------------------------------------------------------------------------------------
$analyse_document['mode'] = "recherche";
$analyse_document['nbr'] = 1 ;

$ad['0']['0'] = 0;	$ad['1']['0'] = 0;	$ad['2']['0'] = 3;	$ad['3']['0'] = 3;
$ad['0']['1'] = 0;	$ad['1']['1'] = 1;	$ad['2']['1'] = 3;	$ad['3']['1'] = 3;
$ad['0']['2'] = 3;	$ad['1']['2'] = 3;	$ad['2']['2'] = 2;	$ad['3']['2'] = 3;
$ad['0']['3'] = 3;	$ad['1']['3'] = 3;	$ad['2']['3'] = 3;	$ad['3']['3'] = 3;

while ( $analyse_document['mode'] == "recherche" ) {
	$analyse_document['start'] = stripos( $document_contenu , "[INCLUDE]");
	if ( $analyse_document['start'] !== FALSE ) {
		$analyse_document['contenu_include']	= "";
		$analyse_document['docu_type']		= 0; //MWMCODE
		$analyse_document['stop'] = stripos( $document_contenu , "[/INCLUDE]");
		$analyse_document['start2'] = $analyse_document['start'] + 9;
		$analyse_document['include_docu_nom'] = substr($document_contenu , $analyse_document['start2'], ($analyse_document['stop'] - $analyse_document['start2']) );
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT doc.docu_id, doc.docu_type, doc.docu_cont, doc.docu_createur, doc.docu_creation_date, doc.docu_correcteur, doc.docu_correction_date 
 		FROM ".$SQL_tab['document']." doc, ".$SQL_tab['document_partage']." dp 
		WHERE doc.docu_nom = '".$analyse_document['include_docu_nom']."' 
		AND doc.docu_id = dp.docu_id 
		AND dp.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
		;");

		if ( num_row_sql($dbquery) == 0 ) {
			$tl_['eng']['err'] = "The specified sub-article (" . $analyse_document['include_docu_nom'] . ") could not be found for including.";
			$tl_['fra']['err'] = "Le sous-article mention&eacute; (" . $analyse_document['include_docu_nom'] . ") pour inclusion n'a pas &eacute;t&eacute; trouv&eacute;";
			journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , "MADP" , "ERR" , "MADP_0009" , $tl_[$l]['err']  );
			$analyse_document['contenu_include']	= " ";
			$analyse_document['docu_type']		= 0; //MWMCODE
		}
		else { 
			while ($dbp = fetch_array_sql($dbquery)) { 
				$analyse_document['contenu_include']	= $dbp['docu_cont'];
				$analyse_document['docu_type']		= $dbp['docu_type'];
				$liste_document[$LD_idx]['docu_id']						= $DT['docu_id'];
				$liste_document[$LD_idx]['docu_nom']						= $DT['docu_nom'];
				$liste_document[$LD_idx]['docu_createur']					= $DT['docu_createur'];
				$liste_document[$LD_idx]['docu_creation_date']			= $DT['docu_creation_date'];
				$liste_document[$LD_idx]['docu_correcteur']				= $DT['docu_correcteur'];
				$liste_document[$LD_idx]['docu_correction_date']			= $DT['docu_correction_date'];
				$LD_idx++;
			}
		}
		$x = $DT['docu_type'];
		$y = $analyse_document['docu_type'];
		$DT['docu_type'] = $ad[$x][$y];

		$analyse_document['stop2'] = $analyse_document['stop'] + 10;
		$analyse_document['taille_fin'] = strlen($document_contenu) - $analyse_document['stop2'];
		$document_contenu = substr( $document_contenu , 0, $analyse_document['start'] ) . $analyse_document['contenu_include'] . substr($document_contenu ,$analyse_document['stop2'] , $analyse_document['taille_fin']) ;
	}
	if ( $analyse_document['nbr'] == 15 ) { $analyse_document['mode'] = "sortie"; }
	$analyse_document['nbr']++;
}

// --------------------------------------------------------------------------------------------
// Post processing du document (mot cles)
// --------------------------------------------------------------------------------------------
function article_post_processing ( &$doc , $article ) {
	global $SQL_tab_abrege , $WebSiteObj;
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['mot_cle']." 
	WHERE arti_id = '".$article."' 
	AND mc_etat = '1' 
	AND site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
	;");
	while ($dbp = fetch_array_sql($dbquery)) {
		$pv['MC']['id']		= $dbp['mc_id'];
		$pv['MC']['chaine']	= $dbp['mc_chaine'];
		$pv['MC']['nbr']	= $dbp['mc_nbr'];
		$pv['MC']['type']	= $dbp['mc_type'];
		$pv['MC']['donnee']	= $dbp['mc_donnee'];
		switch ($pv['MC']['type'] ) {
		case 1:
		break;
		case 2:
			$pv['MC']['cible'] = "<a class='" . $theme_tableau.$_REQUEST['bloc']."_lien' href='".$pv['MC']['donnee']."' target='_new'>".$pv['MC']['chaine']."</a>";
			$doc = str_replace ( $pv['MC']['chaine'] , $pv['MC']['cible'] , $doc , $pv['MC']['nbr'] ) ;
		break;
		case 3:
			$pv['MC']['cible'] = "<span style='font-weight: bold;' onMouseOver=\"Bulle('".$pv['MC']['donnee']."')\" onMouseOut=\"Bulle()\">".$pv['MC']['chaine']."</span>\r";
			$doc = str_replace ( $pv['MC']['chaine'] , $pv['MC']['cible'] , $doc , $pv['MC']['nbr'] ) ;
		break;
		}
	}
}

if ( !function_exists("document_convertion")) { include ("../modules/initial/AfficheDocument/module_affiche_document_convert.php"); }
switch ( $DT['docu_type'] ) {
case 3:		$DT['docu_cont'] = &$document_contenu;	include ("../modules/initial/AfficheDocument/module_affiche_document_exec.php");													break;
case 2:		eval ($document_contenu);																																				break;
case 0:
	article_post_processing ( $document_contenu , $DT['arti_id'] );	
	echo document_convertion ( $document_contenu , $DT['sw_repertoire'] , $DT['arti_ref']."_p0".$DT['arti_page'] );			break;
case 1:		echo $document_contenu;																																					break;
}

// --------------------------------------------------------------------------------------------
// Stat du document

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['stat_document']." 
WHERE arti_id = '".$DT['arti_id']."' 
AND  arti_page = '".$DT['arti_page']."'
;");
if ( num_row_sql($dbquery) == 0 ) {
	requete_sql($_REQUEST['sql_initiateur'],"
	INSERT INTO ".$SQL_tab_abrege['stat_document']." VALUES (
	'".$DT['arti_id']."',
	'".$DT['arti_page']."',
	'1'
	);");
}
elseif ( num_row_sql($dbquery) == 1 ) {
	while ($dbp = fetch_array_sql($dbquery)) { $pv['arti_count'] = $dbp['arti_count']; }
	$pv['arti_count']++;
	requete_sql($_REQUEST['sql_initiateur'],"
	UPDATE ".$SQL_tab_abrege['stat_document']." SET 
	arti_count = '".$pv['arti_count']."' 
	WHERE arti_id = '".$DT['arti_id']."' 
	AND arti_page = '".$DT['arti_page']."' 
	;");
}

// --------------------------------------------------------------------------------------------
switch ( $DT['arti_menu_occurence'] ) {
case "2": 
case "3": 
	echo ( $document_menu_contenu );
break;
}

// --------------------------------------------------------------------------------------------
//	Pied de page
// --------------------------------------------------------------------------------------------
echo ("
<br>\r
</div>\r
<div id='document_pied_de_page' style='width: ".${$theme_tableau}['theme_module_largeur_interne']."px;' class='" . $theme_tableau.$_REQUEST['bloc']."_div_std'>\r
");

if ( $pv['p2p_count'] > 1 ) {
	$tl_['eng']['precedent1']	= " Previous ";
	$tl_['fra']['precedent1']	= " Pr&eacute;c&eacute;dent ";

	$tl_['eng']['suivant1']		= " Next ";
	$tl_['fra']['suivant1']		= " Suivant ";

	switch ($pv['p2p_marque']) {
	case "1":
		echo ("
		<a class='" . $theme_tableau.$_REQUEST['bloc']."_lien " . $theme_tableau.$_REQUEST['bloc']."_t1' 
		href='index.php?&amp;arti_ref=".$DT['arti_ref']."&amp;arti_page=".($DT['arti_page'] + 1).$bloc_html['url_slup']."'>".$tl_[$l]['suivant1']."</a>\r
		");
	break;

	case $pv['p2p_count']:
		echo ("
		<a class='" . $theme_tableau.$_REQUEST['bloc']."_lien " . $theme_tableau.$_REQUEST['bloc']."_t1' 
		href='index.php?&amp;arti_ref=".$DT['arti_ref']."&amp;arti_page=".($DT['arti_page'] - 1).$bloc_html['url_slup']."'>".$tl_[$l]['precedent1']."</a>\r
		");
	break;

	default:
		echo ("
		<a class='" . $theme_tableau.$_REQUEST['bloc']."_lien " . $theme_tableau.$_REQUEST['bloc']."_t1' 
		href='index.php?&amp;arti_ref=".$DT['arti_ref']."&amp;arti_page=".($DT['arti_page'] - 1).$bloc_html['url_slup']."'>".$tl_[$l]['precedent1']."</a>\r
		- 
		<a class='" . $theme_tableau.$_REQUEST['bloc']."_lien " . $theme_tableau.$_REQUEST['bloc']."_t1' 
		href='index.php?&amp;arti_ref=".$DT['arti_ref']."&amp;arti_page=".($DT['arti_page'] + 1).$bloc_html['url_slup']."'>".$tl_[$l]['suivant1']."</a>\r
		");
	break;
	}
}
echo ("
</div>\r
");

// --------------------------------------------------------------------------------------------
//	Affichage des informations du document
// --------------------------------------------------------------------------------------------
if ( ( $DT['arti_montre_info_modification'] + $DT['arti_montre_info_parution'] ) != 0 ) {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT a.user_id,a.user_nom 
	FROM ".$SQL_tab_abrege['user']." a , ".$SQL_tab_abrege['groupe_user']." b, ".$SQL_tab_abrege['site_groupe']." c  
	WHERE a.user_id = b.user_id
	AND b.groupe_id = c.groupe_id 
	AND b.groupe_premier = '1' 
	ORDER BY a.user_id
	;");
	while ($dbp = fetch_array_sql($dbquery)) { $ADP_users[$dbp['user_id']] = $dbp['user_nom']; }

	echo ("
	<hr>\r
	<div id='document_infos' class='" . $theme_tableau.$_REQUEST['bloc']."_div_std' style='position: absolute;'>\r
	<span class='" . $theme_tableau.$_REQUEST['bloc']."_t1 " . $theme_tableau.$_REQUEST['bloc']."_fade'>
	");

	$tl_['eng']['auteurs_par'] = " by ";			$tl_['fra']['auteurs_par'] = " par ";
	$tl_['eng']['auteurs_date'] = " on ";			$tl_['fra']['auteurs_date'] = " le ";
	$tl_['eng']['auteurs_update'] = " updated on ";	$tl_['fra']['auteurs_update'] = " mis &agrave; jour  ";
	$pv['LD_1er'] = 1;
	foreach ( $liste_document as $A ) {
		if ( $pv['LD_1er'] == 1 ) { 
			$pv['C'] = "<b>'" . $A['arti_titre'] . "'</b><br>\r" . $tl_[$l]['auteurs_par'] . $ADP_users[$A['arti_creation_createur']] . 
			$tl_[$l]['auteurs_date'] . $A['arti_creation_date'] . " - " .
			$tl_[$l]['auteurs_update'] . $A['arti_validation_date'] . $tl_[$l]['auteurs_par'] . $ADP_users[$A['arti_validation_validateur']] . "<br>\r";
			$pv['LD_1er'] = 0;
		}
		else {
			$pv['C'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $tl_[$l]['auteurs_par'] . $ADP_users[$A['docu_createur']] . 
			$tl_[$l]['auteurs_date'] . $A['docu_creation_date'] . " - " .
			$tl_[$l]['auteurs_update'] . $A['docu_correction_date'] . $tl_[$l]['auteurs_par'] . $ADP_users[$A['docu_correcteur']] . "<br>\r";
		}
		echo ( $pv['C']);
	}
	echo ("
	</span>\r
	</div>\r
	");
}

if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
	if ( $document_tableau != "MAA_" ) { unset ($DT); }
	if ( $DT['arti_menu_occurence'] != 4 ) { unset ($document_menu_contenu); }
	unset ( 
	$ad, 
	$ADP_users, 
	$analyse_document, 
	$document_contenu, 
	$dbp, 
	$dbquery, 
	$expression_separateur, 
	$i,
	$P2P_tab_, 
	$position_float,
	$pv,  
	$tl_, 
	$x, 
	$y 
	);
}

?>
