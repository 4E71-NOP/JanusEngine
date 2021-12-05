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
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $cs CommonSystem                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

$bts->RequestDataObj->setRequestDataEntry('searchForm' ,
	array(
		"searchType"	=>	"A",
		"search"		=>	"utilisat",
	),
);
$bts->RequestDataObj->setRequestDataEntry('searchForm' ,
	array(
		"searchType"	=>	"T",
		"search"		=>	"concep",
	),
);

/* -------------------------------------------------------------------------------------------- */
/*Hydr-Content-Begin*/
$localisation = " / uni_search_p01.php";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_search_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_search_p01.php");


if ( strlen( $bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'search') ) > 3 ) {
	switch ($bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'searchType')) {
		case "T":
			$dbquery = $bts->SDDMObj->query("
			SELECT tag.tag_id, art.arti_id, art.arti_ref, art.arti_desc, art.arti_title, art.arti_subtitle, art.arti_page
			FROM ".$SqlTableListObj->getSQLTableName('tag')." as tag, ".$SqlTableListObj->getSQLTableName('article_tag')." as at, ".$SqlTableListObj->getSQLTableName('article')." as art, ".$SqlTableListObj->getSQLTableName('deadline')." as bcl, ".$SqlTableListObj->getSQLTableName('category')." as cat
			WHERE tag.tag_name LIKE '%".$bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'search')."%'
			AND tag.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
					
			AND at.tag_id = tag.tag_id
			AND at.arti_id = art.arti_id
					
			AND art.deadline_id = bcl.deadline_id
			AND bcl.deadline_state = '1'
					
			AND cat.arti_ref = art.arti_ref
			AND cat.cate_state = '1'
			AND cat.lang_id = '".$CurrentSetObj->getDataEntry('language_id')."'
			ORDER BY art.arti_title
			;");
			break;
		case "A":
			$dbquery = $bts->SDDMObj->query("
			SELECT art.arti_id, art.arti_ref, art.arti_desc, art.arti_title, art.arti_subtitle, art.arti_page, doc.docu_cont
			FROM ".$SqlTableListObj->getSQLTableName('article')." as art, ".$SqlTableListObj->getSQLTableName('deadline')." as bcl, ".$SqlTableListObj->getSQLTableName('category')." as cat, ".$SqlTableListObj->getSQLTableName('document')." as doc
			WHERE art.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
			AND doc.docu_id = art.docu_id
					
			AND art.ws_id = cat.ws_id
			AND art.deadline_id = bcl.deadline_id
			AND art.arti_ref = cat.arti_ref
					
			AND bcl.deadline_state = '1'
			AND cat.cate_type IN ('0','1')
			AND cat.lang_id = '".$CurrentSetObj->getDataEntry('language_id')."'
			AND docu_cont LIKE '%".$bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'search')."%'
			;");
			break;
	}
	
	$tag_recherche = $pv = array();
// 	$Content = "";
	$T = array();
	if ( $bts->SDDMObj->num_row_sql($dbquery) > 0 ) {
		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$pv['i'] = $dbp['arti_ref'];
			$pv['j'] = $dbp['arti_id'];
			foreach ( $dbp as $A => $B ) { $tag_recherche[$pv['i']][$pv['j']][$A] = $B; }
			unset ($A, $B);
		}
		
		$ligne = 1;
		$T['Content']['1'][$ligne]['1']['cont']	= "Section";
		$T['Content']['1'][$ligne]['2']['cont']	= "Article";
		$ligne++;
		foreach ( $tag_recherche as $A ) {
			$pv['titre_article'] = 0;
			foreach ( $A as $B ) {
				if ( $pv['titre_article'] == 0 ) {
					$T['Content']['1'][$ligne]['1']['cont']	= "<a class='".$Block."_lien ".$Block."_tb4' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')."\">".$B['arti_title']."</a>";
					$pv['titre_article'] = 1;
				}
				$T['Content']['1'][$ligne]['2']['cont'] = "<a class='".$Block."_lien ".$Block."_tb3' href=\"index.php?arti_ref=".$B['arti_ref']."&amp;arti_page=".$B['arti_page'].$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')."\">".$B['arti_subtitle']."</a><br>\r";
				switch ( $bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'searchType') ) {
					case "A":
						$pv['taille_extrait'] = 92;
						$pv['position_expr'] = strpos ( $B['docu_cont'] , $bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'search') );
						if ( $pv['position_expr'] <= ($pv['taille_extrait'] / 2) ) { $pv['extrait_debut'] = 0 ; }
						else { $pv['extrait_debut'] = $pv['position_expr'] - ($pv['taille_extrait'] / 2); }
						$pv['extrait'] = "..." . substr ( $B['docu_cont'] , $pv['extrait_debut'] , $pv['taille_extrait'] ) . "...";
						$pv['expression_remplacante'] = "<span class='".$Block."_avert ".$Block."_tb3'>".$bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'search')."</span>";
						$pv['extrait'] = str_replace ( $bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'search') , $pv['expression_remplacante'] , $pv['extrait'] );
						$T['Content']['1'][$ligne]['2']['cont'] .= "<span style='font-style:italic;'>".$pv['extrait']."</span><br>\r<br>\r";
						break;
					case "T":
						$T['Content']['1'][$ligne]['2']['cont'] .= "<span style='font-style:italic;'>".$B['arti_ref']." p".$B['arti_page']."</span><br>\r<br>\r";
						break;
				}
				$ligne++;
			}
			unset ($B);
		}
		
		$T['ContentCfg']['tabs']['1']['NbrOfLines'] = $ligne-1;	$T['ContentCfg']['tabs']['1']['NbrOfCells'] = 2;	$T['ContentCfg']['tabs']['1']['TableCaptionPos'] = 1;

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
		
		$RenderLayoutObj = RenderLayout::getInstance();
		$T['ContentInfos']['EnableTabs']	= 1;
		$T['ContentInfos']['NbrOfTabs']		= 1;
		$T['ContentInfos']['TabBehavior']	= 0;
		$T['ContentInfos']['RenderMode']	= 1;
		$T['ContentInfos']['HighLightType']	= 1;
		$T['ContentInfos']['Height']		= $RenderLayoutObj->getLayoutModuleEntry($infos['module_name'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
		$T['ContentInfos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_internal_width');
		$T['ContentInfos']['GroupName']		= "list";
		$T['ContentInfos']['CellName']		= "grp";
		$T['ContentInfos']['DocumentName']	= "doc";
		$T['ContentInfos']['cell_1_txt']	= $i18nDoc['cell_1_txt'];
		
		$config = array(
				"mode" => 1,
				"module_display_mode" => "normal",
				"module_z_index" => 2,
				"block" => $infos['block'],
				"blockG" => $infos['block']."G",
				"blockT" => $infos['block']."T",
				"deco_type" => 50,
				"module" => $infos['module'],
		);
		$RenderTablesObj = RenderTables::getInstance();
		$Content .= $RenderTablesObj->render($config, $T);
		
	}
	else {
		$Content .= "
			<p class='".$Block."_p'>
			<span class='".$Block."_tb4'>" .
				$i18nDoc['result'] .
				$bts->RequestDataObj->getRequestDataSubEntry('searchForm', 'search')."</span><br>\r<br>\r
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

/*Hydr-Content-End*/
?>
