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
$_REQUEST['type_recherche'] = "A"; 
$_REQUEST['expression_recherche'] = "utilisat";

//$_REQUEST['type_recherche'] = "T"; 
//$_REQUEST['expression_recherche'] = "concept";
/* -------------------------------------------------------------------------------------------- */
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_recherche_p01";

/* -------------------------------------------------------------------------------------------- */
if ( strlen( $_REQUEST['expression_recherche'] ) > 3 ) {
	$_REQUEST['expression_recherche'] = strtolower ( $_REQUEST['expression_recherche'] ) ;

	switch ( $_REQUEST['type_recherche'] ) {
	case "T": 
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT tag.tag_id, art.arti_id, art.arti_ref, art.arti_desc, art.arti_titre, art.arti_sous_titre, art.arti_page 
		FROM ".$SQL_tab_abrege['tag']." as tag, ".$SQL_tab_abrege['article_tag']." as at, ".$SQL_tab_abrege['article']." as art, ".$SQL_tab_abrege['bouclage']." as bcl, ".$SQL_tab_abrege['categorie']." as cat 
		WHERE tag.tag_nom LIKE '%".$_REQUEST['expression_recherche']."%' 
		AND tag.site_id = '".$site_web['sw_id']."' 

		AND at.tag_id = tag.tag_id 
		AND at.arti_id = art.arti_id 

		AND art.arti_bouclage = bcl.bouclage_id 
		AND bcl.bouclage_etat = '1' 

		AND cat.arti_ref = art.arti_ref 
		AND cat.cate_etat = '1' 
		AND cat.cate_lang = '".$user['lang']."' 
		ORDER BY art.arti_titre
		;");
	break;
	case "A":
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT art.arti_id, art.arti_ref, art.arti_desc, art.arti_titre, art.arti_sous_titre, art.arti_page, doc.docu_cont 
		FROM ".$SQL_tab_abrege['article']." as art, ".$SQL_tab_abrege['bouclage']." as bcl, ".$SQL_tab_abrege['categorie']." as cat, ".$SQL_tab_abrege['document']." as doc 
		WHERE art.site_id = '".$site_web['sw_id']."' 
		AND doc.docu_id = art.docu_id 

		AND art.site_id = cat.site_id  
		AND art.arti_bouclage = bcl.bouclage_id 
		AND art.arti_ref = cat.arti_ref 

		AND bcl.bouclage_etat = '1' 
		AND cat.cate_type IN ('0','1') 
		AND cat.cate_lang = '".$user['lang']."' 
		AND docu_cont LIKE '%".$_REQUEST['expression_recherche']."%'
		;");
	break;
	}

	if ( num_row_sql($dbquery) > 0 ) {
		while ($dbp = fetch_array_sql($dbquery)) { 
			$pv['i'] = $dbp['arti_ref'];
			$pv['j'] = $dbp['arti_id'];
			foreach ( $dbp as $A => $B ) { $tag_recherche[$pv['i']][$pv['j']][$A] = $B; }
			unset ($A, $B);
		}

		$ligne = 1;
		$AD['1'][$ligne]['1']['cont']	= "Section";
		$AD['1'][$ligne]['2']['cont']	= "Article";
		$ligne++;
		foreach ( $tag_recherche as $A ) {
			$pv['titre_article'] = 0;
			foreach ( $A as $B ) {
				if ( $pv['titre_article'] == 0 ) {
					$AD['1'][$ligne]['1']['cont']	= "<a class='".$theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_tb4' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$bloc_html['url_slup']."\">".$B['arti_titre']."</a>";
					$pv['titre_article'] = 1;
				}
				$AD['1'][$ligne]['2']['cont'] = "<a class='".$theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_tb3' href=\"index.php?arti_ref=".$B['arti_ref']."&amp;arti_page=".$B['arti_page'].$bloc_html['url_slup']."\">".$B['arti_sous_titre']."</a><br>\r";
				switch ( $_REQUEST['type_recherche'] ) {
				case "A":
					$pv['taille_extrait'] = 92;
					$pv['position_expr'] = strpos ( $B['docu_cont'] , $_REQUEST['expression_recherche'] );
					if ( $pv['position_expr'] <= ($pv['taille_extrait'] / 2) ) { $pv['extrait_debut'] = 0 ; }
					else { $pv['extrait_debut'] = $pv['position_expr'] - ($pv['taille_extrait'] / 2); }
					$pv['extrait'] = "..." . substr ( $B['docu_cont'] , $pv['extrait_debut'] , $pv['taille_extrait'] ) . "...";
					$pv['expression_remplacante'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_avert ".$theme_tableau.$_REQUEST['bloc']."_tb3'>".$_REQUEST['expression_recherche']."</span>";
					$pv['extrait'] = str_replace ( $_REQUEST['expression_recherche'] , $pv['expression_remplacante'] , $pv['extrait'] );
					$AD['1'][$ligne]['2']['cont'] .= "<span style='font-style:italic;'>".$pv['extrait']."</span><br>\r<br>\r";
				break;
				}
			$ligne++;
			}
			unset ($B);
		}

		$ADC['onglet']['1']['nbr_ligne'] = $ligne-1;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 1;

		$tl_['eng']['resultat'] = "Search results:"; 
		$tl_['fra']['resultat'] = "R&eacute;sultat de votre recherche:"; 
		$tl_[$l]['onglet_1'] = $tl_[$l]['resultat']." '".$_REQUEST['expression_recherche']."'";


		$tab_infos['AffOnglet']			= 1;
		$tab_infos['NbrOnglet']			= 1;
		$tab_infos['tab_comportement']	= 0;
		$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
		$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
		$tab_infos['doc_height']		= 512;
		$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
		$tab_infos['groupe']			= "R_grp1";
		$tab_infos['cell_id']			= "tab";
		$tab_infos['document']			= "doc";
		$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
		include ("routines/website/affichage_donnees.php");
	}
	else {
		$tl_['eng']['aucunresultat'] = "Found no result"; 
		$tl_['fra']['aucunresultat'] = "Aucun r&eacute;sultat"; 

		echo (" 
		<p class='".$theme_tableau.$_REQUEST['bloc']."_p'>
		<span class='".$theme_tableau.$_REQUEST['bloc']."_tb4'>" .
		$tl_[$l]['resultat'] .
		$_REQUEST['expression_recherche']."</span><br>\r<br>\r
		<span class='".$theme_tableau.$_REQUEST['bloc']."_t3'>" .
		$tl_[$l]['aucunresultat'] .
		"</span><br>\r<br>\r 
		</p>\r
		");
	}
}
else { 
	$tl_['eng']['err1'] = "Expression too small"; 
	$tl_['fra']['err1'] = "Expression trop courte."; 
	echo ("<p class='".$theme_tableau.$_REQUEST['bloc']."_p'>".$tl_[$site_web['sw_lang']]['err1']."</p>"); 
}

if ( $site_web['sw_info_debug'] < 10 ) { 
	unset (
		$dbp,
		$dbquery,
		$ligne,
		$pv,
		$tl_,
		$tag_recherche
	);
}

/*Hydre-contenu_fin*/

/*
	if ( num_row_sql($dbquery) > 0 ) {
		while ($dbp = fetch_array_sql($dbquery)) { 
			$pv['i'] = $dbp['arti_ref'];
			$pv['j'] = $dbp['arti_id'];
			foreach ( $dbp as $A => $B ) { $tag_recherche[$pv['i']][$pv['j']][$A] = $B; }
			unset ($A, $B);
		}
		$tl_['eng']['resultat'] = "Search results:"; 
		$tl_['fra']['resultat'] = "R&eacute;sultat de votre recherche:"; 

		$tl_[$l]['onglet_1'] = $tl_[$l]['resultat'];

		echo (" 
		<p class='".$theme_tableau.$_REQUEST['bloc']."_p'>
		<span class='".$theme_tableau.$_REQUEST['bloc']."_tb4'>" .
		$tl_[$l]['resultat'] .
		" " . $_REQUEST['expression_recherche']."</span><br>\r<br>\r");

		$ligne = 1;
		$AD['1'][$ligne]['1']['cont']	= "Section";
		$AD['1'][$ligne]['2']['cont']	= "Article";
		$ligne++;
		echo ("<table>");
		foreach ( $tag_recherche as $A ) {
			$pv['titre_article'] = 0;
			foreach ( $A as $B ) {
				if ( $pv['titre_article'] == 0 ) {

					$AD['1'][$ligne]['1']['cont']	= "<a href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$bloc_html['url_slup']."\">".$B['arti_titre']."</a>";
					$AD['1'][$ligne]['1']['class'] = $theme_tableau.$_REQUEST['bloc']."_lien".$theme_tableau.$_REQUEST['bloc']."_t3";
					$AD['1'][$ligne]['1']['style'] = "font-weight:bold;";

					echo ("
					<tr>\r
					<td class='".$theme_tableau.$_REQUEST['bloc']."_fcta class='".$theme_tableau.$_REQUEST['bloc']."_tb4'>\r
					<a class='".$theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_t4' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$bloc_html['url_slup']."\">".$B['arti_titre']."</a>
					</td>\r
					<td class='".$theme_tableau.$_REQUEST['bloc']."_fcta class='".$theme_tableau.$_REQUEST['bloc']."_tb2'>\r
					");
					$pv['titre_article'] = 1;
				}

				$AD['1'][$ligne]['2']['cont'] = "<a href=\"index.php?arti_ref=".$B['arti_ref']."&amp;arti_page=".$B['arti_page'].$bloc_html['url_slup']."\">".$B['arti_sous_titre']."</a><br>\r";
				$AD['1'][$ligne]['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_lien";

				//echo ("<a class='".$theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_t3' href=\"index.php?arti_ref=".$B['arti_ref']."&amp;arti_page=".$B['arti_page'].$bloc_html['url_slup']."\">".$B['arti_sous_titre']."</a><br>\r");

				switch ( $_REQUEST['type_recherche'] ) {
				case "A":

//					echo ("<span class='".$theme_tableau.$_REQUEST['bloc']."_t1' style='vertical-align: bottom;'>");
					$pv['taille_extrait'] = 92;
					$pv['position_expr'] = strpos ( $B['docu_cont'] , $_REQUEST['expression_recherche'] );
					if ( $pv['position_expr'] <= ($pv['taille_extrait'] / 2) ) { $pv['extrait_debut'] = 0 ; }
					else { $pv['extrait_debut'] = $pv['position_expr'] - ($pv['taille_extrait'] / 2); }
					$pv['extrait'] = "..." . substr ( $B['docu_cont'] , $pv['extrait_debut'] , $pv['taille_extrait'] ) . "...";
					$pv['expression_remplacante'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_tb1 ".$theme_tableau.$_REQUEST['bloc']."_avert'>".$_REQUEST['expression_recherche']."</span>";
					$pv['extrait'] = str_replace ( $_REQUEST['expression_recherche'] , $pv['expression_remplacante'] , $pv['extrait'] );
					$AD['1'][$ligne]['2']['cont'] .= $pv['extrait']."<br>\r<br>\r";

//					echo $pv['extrait'];
//					echo ("<br>\r<br>\r");
				break;
				}
			$ligne++;
			}
			unset ($B);
			echo ("</td>\r</tr>\r");
		}
		echo ("</table>\r");
	}
	else {
		$tl_['eng']['aucunresultat'] = "Found no result"; 
		$tl_['fra']['aucunresultat'] = "Aucun r&eacute;sultat"; 

		echo (" 
		<p class='".$theme_tableau.$_REQUEST['bloc']."_p'>
		<span class='".$theme_tableau.$_REQUEST['bloc']."_tb4'>" .
		$tl_[$l]['resultat'] .
		$_REQUEST['expression_recherche']."</span><br>\r<br>\r
		<span class='".$theme_tableau.$_REQUEST['bloc']."_t3'>" .
		$tl_[$l]['aucunresultat'] .
		"</span><br>\r<br>\r 
		</p>\r
		");
	}
}
else { 
	$tl_['eng']['err1'] = "Expression too small"; 
	$tl_['fra']['err1'] = "Expression trop courte."; 
	echo ("<p class='".$theme_tableau.$_REQUEST['bloc']."_p'>".$tl_[$site_web['sw_lang']]['err1']."</p>"); 
}
*/


?>
