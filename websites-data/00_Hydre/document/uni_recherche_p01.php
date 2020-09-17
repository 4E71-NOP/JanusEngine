<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE's work.
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */
/* @var $TimeObj Time                               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $RenderLayoutObj RenderLayout               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

$RequestDataObj->setRequestDataEntry('searchForm' ,
	array(
		"searchType"	=>	"A",
		"search"		=>	"utilisat",
	),
);
$RequestDataObj->setRequestDataEntry('searchForm' ,
	array(
		"searchType"	=>	"T",
		"search"		=>	"concep",
	),
);

/* -------------------------------------------------------------------------------------------- */
/*Hydre-contenu_debut*/
$localisation = " / uni_recherche_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_recherche_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_recherche_p01");

if ( strlen( $RequestDataObj->getRequestDataSubEntry('searchForm', 'search') ) > 3 ) {
	switch ($RequestDataObj->getRequestDataSubEntry('searchForm', 'searchType')) {
		case "T":
			$dbquery = $SDDMObj->query("
			SELECT tag.tag_id, art.arti_id, art.arti_ref, art.arti_desc, art.arti_titre, art.arti_sous_titre, art.arti_page
			FROM ".$SqlTableListObj->getSQLTableName('tag')." as tag, ".$SqlTableListObj->getSQLTableName('article_tag')." as at, ".$SqlTableListObj->getSQLTableName('article')." as art, ".$SqlTableListObj->getSQLTableName('bouclage')." as bcl, ".$SqlTableListObj->getSQLTableName('categorie')." as cat
			WHERE tag.tag_nom LIKE '%".$RequestDataObj->getRequestDataSubEntry('searchForm', 'search')."%'
			AND tag.site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
					
			AND at.tag_id = tag.tag_id
			AND at.arti_id = art.arti_id
					
			AND art.arti_bouclage = bcl.bouclage_id
			AND bcl.bouclage_etat = '1'
					
			AND cat.arti_ref = art.arti_ref
			AND cat.cate_etat = '1'
			AND cat.cate_lang = '".$CurrentSetObj->getDataEntry('language_id')."'
			ORDER BY art.arti_titre
			;");
			break;
		case "A":
			$dbquery = $SDDMObj->query("
			SELECT art.arti_id, art.arti_ref, art.arti_desc, art.arti_titre, art.arti_sous_titre, art.arti_page, doc.docu_cont
			FROM ".$SqlTableListObj->getSQLTableName('article')." as art, ".$SqlTableListObj->getSQLTableName('bouclage')." as bcl, ".$SqlTableListObj->getSQLTableName('categorie')." as cat, ".$SqlTableListObj->getSQLTableName('document')." as doc
			WHERE art.site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
			AND doc.docu_id = art.docu_id
					
			AND art.site_id = cat.site_id
			AND art.arti_bouclage = bcl.bouclage_id
			AND art.arti_ref = cat.arti_ref
					
			AND bcl.bouclage_etat = '1'
			AND cat.cate_type IN ('0','1')
			AND cat.cate_lang = '".$CurrentSetObj->getDataEntry('language_id')."'
			AND docu_cont LIKE '%".$RequestDataObj->getRequestDataSubEntry('searchForm', 'search')."%'
			;");
			break;
	}
	
	$tag_recherche = $pv = array();
// 	$Content = "";
	$T = array();
	if ( $SDDMObj->num_row_sql($dbquery) > 0 ) {
		while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
			$pv['i'] = $dbp['arti_ref'];
			$pv['j'] = $dbp['arti_id'];
			foreach ( $dbp as $A => $B ) { $tag_recherche[$pv['i']][$pv['j']][$A] = $B; }
			unset ($A, $B);
		}
		
		$ligne = 1;
		$T['AD']['1'][$ligne]['1']['cont']	= "Section";
		$T['AD']['1'][$ligne]['2']['cont']	= "Article";
		$ligne++;
		foreach ( $tag_recherche as $A ) {
			$pv['titre_article'] = 0;
			foreach ( $A as $B ) {
				if ( $pv['titre_article'] == 0 ) {
					$T['AD']['1'][$ligne]['1']['cont']	= "<a class='".$Block."_lien ".$Block."_tb4' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')."\">".$B['arti_titre']."</a>";
					$pv['titre_article'] = 1;
				}
				$T['AD']['1'][$ligne]['2']['cont'] = "<a class='".$Block."_lien ".$Block."_tb3' href=\"index.php?arti_ref=".$B['arti_ref']."&amp;arti_page=".$B['arti_page'].$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')."\">".$B['arti_sous_titre']."</a><br>\r";
				switch ( $RequestDataObj->getRequestDataSubEntry('searchForm', 'searchType') ) {
					case "A":
						$pv['taille_extrait'] = 92;
						$pv['position_expr'] = strpos ( $B['docu_cont'] , $RequestDataObj->getRequestDataSubEntry('searchForm', 'search') );
						if ( $pv['position_expr'] <= ($pv['taille_extrait'] / 2) ) { $pv['extrait_debut'] = 0 ; }
						else { $pv['extrait_debut'] = $pv['position_expr'] - ($pv['taille_extrait'] / 2); }
						$pv['extrait'] = "..." . substr ( $B['docu_cont'] , $pv['extrait_debut'] , $pv['taille_extrait'] ) . "...";
						$pv['expression_remplacante'] = "<span class='".$Block."_avert ".$Block."_tb3'>".$RequestDataObj->getRequestDataSubEntry('searchForm', 'search')."</span>";
						$pv['extrait'] = str_replace ( $RequestDataObj->getRequestDataSubEntry('searchForm', 'search') , $pv['expression_remplacante'] , $pv['extrait'] );
						$T['AD']['1'][$ligne]['2']['cont'] .= "<span style='font-style:italic;'>".$pv['extrait']."</span><br>\r<br>\r";
						break;
					case "T":
						$T['AD']['1'][$ligne]['2']['cont'] .= "<span style='font-style:italic;'>".$B['arti_ref']." p".$B['arti_page']."</span><br>\r<br>\r";
						break;
				}
				$ligne++;
			}
			unset ($B);
		}
		
		$T['ADC']['onglet']['1']['nbr_ligne'] = $ligne-1;	$T['ADC']['onglet']['1']['nbr_cellule'] = 2;	$T['ADC']['onglet']['1']['legende'] = 1;

		switch ($l) {
			case "fra":
				$i18nDoc = array(
				"cell_1_txt"		=> "Résultat de votre recherche:",
				"noResult"		=> "Aucun résultat",
				"err1"			=> "Expression trop courte",
				);
				break;
			case "eng":
				$i18nDoc = array(
				"cell_1_txt"		=> "Search results:",
				"noResult"		=> "No result",
				"err1"			=> "Expression too short",
				);
				break;
		}
	
		
		$T['tab_infos']['EnableTabs']		= 1;
		$T['tab_infos']['NbrOfTabs']		= 1;
		$T['tab_infos']['TabBehavior']		= 0;
		$T['tab_infos']['RenderMode']		= 1;
		$T['tab_infos']['HighLightType']	= 1;
		$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_nom'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
		$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
		$T['tab_infos']['GroupName']		= "list";
		$T['tab_infos']['CellName']			= "grp";
		$T['tab_infos']['DocumentName']		= "doc";
		$T['tab_infos']['cell_1_txt']		= $i18nDoc['cell_1_txt'];
		
		$config = array(
				"mode" => 1,
				"affiche_module_mode" => "normal",
				"module_z_index" => 2,
				"block" => $infos['block'],
				"blockG" => $infos['block']."G",
				"blockT" => $infos['block']."T",
				"deco_type" => 50,
				"module" => $infos['module'],
		);
		
		$Content .= $RenderTablesObj->render($config, $T);
		
	}
	else {
		$Content .= "
			<p class='".$Block."_p'>
			<span class='".$Block."_tb4'>" .
				$i18nDoc['result'] .
				$RequestDataObj->getRequestDataSubEntry('searchForm', 'search')."</span><br>\r<br>\r
			<span class='".$Block."_t3'>" .
				$i18nDoc['noResult'] .
				"</span><br>\r<br>\r
			</p>\r
			";
		}
	}
else {
	$Content .= "<p class='".$Block."_p'>".$i18nDoc['err1']."</p>";
}

/*Hydre-contenu_fin*/
?>
