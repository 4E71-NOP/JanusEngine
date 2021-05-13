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
/* @var $bts BaseToolSet                            */
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

$bts->RequestDataObj->setRequestData('test',
		array(
				'test'		=> 1,
		)
	);

/*Hydr-Content-Begin*/
$localisation = " / uni_document_editor_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_document_editor_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_document_editor_p01.php");

switch ($l) {
	case "fra":
		$i18nDoc = array(
		"invite1"		=> "Cette partie va vous permettre de modifier les documents.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Type",
		"col_3_txt"		=> "Modifiable par tiers ?",
		"col_4_txt"		=> "État",
		"cell_1_txt"	=> "Informations",
		"raf1"			=> "Rien a afficher",
		"btn1"			=> "Rafraichir la vue",
		"type"			=> array(
					0		=> "MWM code",
					1		=> "No code",
					2		=> "PHP",
					3		=> "Mixed",
			),
		"level"			=> array(
					0		=> 2,
					1		=> 4,
					2		=> 8,
					3		=> 16,
			),
		0				=> "Non",
		1				=> "Oui",
		);
		break;
	case "eng":
		$i18nDoc = array(
		"invite1"		=> "This part will allow you to modify documents.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Type",
		"col_3_txt"		=> "Can be modified by a tier ?",
		"col_4_txt"		=> "State",
		"cell_1_txt"	=> "Informations",
		"raf1"			=> "Nothing to display",
		"btn1"			=> "Refresh display",
		"type"			=> array(
					0		=> "MWM code",
					1		=> "No code",
					2		=> "PHP",
					3		=> "Mixé",
			),
			"level"			=> array(
					0		=> 2,
					1		=> 4,
					2		=> 8,
					3		=> 16,
			),
		0				=> "No",
		1				=> "Yes",
		);
		break;
}

$editionLevel = $i18nDoc['level'][$UserObj->getUserEntry('group_tag')];

// --------------------------------------------------------------------------------------------
$T = array();

$dbquery = $bts->SDDMObj->query("
SELECT doc.docu_id, doc.docu_name, doc.docu_type, shr.share_modification 
FROM ".$SqlTableListObj->getSQLTableName('document')." doc, ".$SqlTableListObj->getSQLTableName('document_share')." shr 
WHERE shr.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND shr.docu_id = doc.docu_id 
AND doc.docu_origin = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY docu_id, docu_type, part_modification ASC
;");
$docList = array();
if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont'] = $i18nDoc['raf1'];
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
	$T['Content']['1'][$i]['4']['cont'] = "";
}
else {
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$docList[$dbp['docu_id']]['docu_name']			= $dbp['docu_name'];
		$docList[$dbp['docu_id']]['docu_id']			= $dbp['docu_id'];
		$docList[$dbp['docu_id']]['docu_type']			= $dbp['docu_type'];
		$docList[$dbp['docu_id']]['part_modification']	= $dbp['part_modification'];
		$docList[$dbp['docu_id']]['edition'] = 1;
	}
	$Clause = " IN ( ";
	foreach ( $docList as $A ) { $Clause .= "'".$A['docu_id']."', ";	}
	$Clause = substr( $Clause , 0 , -2 ) . ") ";
	unset ($A);
	
	$dbquery = $bts->SDDMObj->query("
	SELECT dcm.docu_id, art.arti_id, bcl.deadline_id, dcm.docu_name 
	FROM ".$SqlTableListObj->getSQLTableName('article')." art, ".$SqlTableListObj->getSQLTableName('deadline')." bcl , ".$SqlTableListObj->getSQLTableName('document')." dcm
	WHERE art.docu_id ".$Clause." 
	AND dcm.docu_id = art.docu_id 
	AND art.deadline_id = bcl.deadline_id 
	AND bcl.deadline_state = '1' 
	AND art.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
	ORDER BY dcm.docu_id ASC 
	;");
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $docList[$dbp['docu_id']]['edition'] = 0; }
	
	$trr['nbr_col'] = 4;
	
	
	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $i18nDoc['col_1_txt'];
	$T['Content']['1'][$i]['2']['cont']	= $i18nDoc['col_2_txt'];
	$T['Content']['1'][$i]['3']['cont']	= $i18nDoc['col_3_txt'];
	$T['Content']['1'][$i]['4']['cont']	= $i18nDoc['col_4_txt'];
	
	foreach ( $docList as $A ) { 
		$i++;
		switch ( $editionLevel + $A['edition'] ) {
		case 9 :
		case 16 :
		case 17 :
			$T['Content']['1'][$i]['1']['cont']	= "<a class='" . $Block."_lien' href='index.php?
			&amp;M_DOCUME[document_selection]=".$A['docu_id'].
			$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup')."
			&amp;arti_page=2'>".$A['docu_name']."</a>";
		break;
		default:
			$T['Content']['1'][$i]['1']['cont'] = $A['docu_name'];
		break;
		} 
		$T['Content']['1'][$i]['2']['cont']	= $i18nDoc['type'][$A['docu_type']];
		$T['Content']['1'][$i]['3']['cont']	= $i18nDoc[$A['part_modification']];
		$T['Content']['1'][$i]['4']['cont']	= $i18nDoc[$A['edition']];
	}
}


$T['ContentInfos']['EnableTabs']		= 1;
$T['ContentInfos']['NbrOfTabs']		= 1;
$T['ContentInfos']['TabBehavior']		= 0;
$T['ContentInfos']['RenderMode']		= 1;
$T['ContentInfos']['HighLightType']	= 1;
$T['ContentInfos']['Height']			= $bts->RenderLayoutObj->getLayoutModuleEntry($infos['module_name'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
$T['ContentInfos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_internal_width');
$T['ContentInfos']['GroupName']		= "list";
$T['ContentInfos']['CellName']			= "dl";
$T['ContentInfos']['DocumentName']		= "doc";
$T['ContentInfos']['cell_1_txt']		= $i18nDoc['cell_1_txt'];
// $T['ContentInfos']['cell_2_txt']		= $i18nDoc['col_2_txt'];
// $T['ContentInfos']['cell_3_txt']		= $i18nDoc['col_3_txt'];
// $T['ContentInfos']['cell_4_txt']		= $i18nDoc['col_4_txt'];

$T['ContentCfg']['tabs']['1']['NbrOfLines']	= $i;
$T['ContentCfg']['tabs']['1']['NbrOfCells']	= 4;
$T['ContentCfg']['tabs']['1']['TableCaptionPos']		= 1;

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

$Content .= $bts->RenderTablesObj->render($config, $T);

$Content .= "<br>\r&nbsp;
</form>\r
</td>\r
</tr>\r
</table>\r
<br>\r
";


/*Hydr-Content-End*/
?>
