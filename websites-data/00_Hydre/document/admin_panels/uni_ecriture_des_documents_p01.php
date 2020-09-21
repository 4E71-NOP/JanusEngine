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
// Some definitions in order to ease the IDE work.
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

$RequestDataObj->setRequestData('test',
		array(
				'test'		=> 1,
		)
	);

/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_documents_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_documents_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_documents_p01");

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

$dbquery = $SDDMObj->query("
SELECT doc.docu_id, doc.docu_name, doc.docu_type, shr.share_modification 
FROM ".$SqlTableListObj->getSQLTableName('document')." doc, ".$SqlTableListObj->getSQLTableName('document_share')." shr 
WHERE shr.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND shr.docu_id = doc.docu_id 
AND doc.docu_origin = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY docu_id, docu_type, part_modification ASC
;");
$docList = array();
if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont'] = $i18nDoc['raf1'];
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
	$T['AD']['1'][$i]['4']['cont'] = "";
}
else {
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
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
	
	$dbquery = $SDDMObj->query("
	SELECT dcm.docu_id, art.arti_id, bcl.deadline_id, dcm.docu_name 
	FROM ".$SqlTableListObj->getSQLTableName('article')." art, ".$SqlTableListObj->getSQLTableName('deadline')." bcl , ".$SqlTableListObj->getSQLTableName('document')." dcm
	WHERE art.docu_id ".$Clause." 
	AND dcm.docu_id = art.docu_id 
	AND art.deadline_id = bcl.deadline_id 
	AND bcl.deadline_state = '1' 
	AND art.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
	ORDER BY dcm.docu_id ASC 
	;");
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { $docList[$dbp['docu_id']]['edition'] = 0; }
	
	$trr['nbr_col'] = 4;
	
	
	$i = 1;
	$T['AD']['1'][$i]['1']['cont']	= $i18nDoc['col_1_txt'];
	$T['AD']['1'][$i]['2']['cont']	= $i18nDoc['col_2_txt'];
	$T['AD']['1'][$i]['3']['cont']	= $i18nDoc['col_3_txt'];
	$T['AD']['1'][$i]['4']['cont']	= $i18nDoc['col_4_txt'];
	
	foreach ( $docList as $A ) { 
		$i++;
		switch ( $editionLevel + $A['edition'] ) {
		case 9 :
		case 16 :
		case 17 :
			$T['AD']['1'][$i]['1']['cont']	= "<a class='" . $Block."_lien' href='index.php?
			&amp;M_DOCUME[document_selection]=".$A['docu_id'].
			$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup')."
			&amp;arti_page=2'>".$A['docu_name']."</a>";
		break;
		default:
			$T['AD']['1'][$i]['1']['cont'] = $A['docu_name'];
		break;
		} 
		$T['AD']['1'][$i]['2']['cont']	= $i18nDoc['type'][$A['docu_type']];
		$T['AD']['1'][$i]['3']['cont']	= $i18nDoc[$A['part_modification']];
		$T['AD']['1'][$i]['4']['cont']	= $i18nDoc[$A['edition']];
	}
}


$T['tab_infos']['EnableTabs']		= 1;
$T['tab_infos']['NbrOfTabs']		= 1;
$T['tab_infos']['TabBehavior']		= 0;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 1;
$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_name'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "list";
$T['tab_infos']['CellName']			= "dl";
$T['tab_infos']['DocumentName']		= "doc";
$T['tab_infos']['cell_1_txt']		= $i18nDoc['cell_1_txt'];
// $T['tab_infos']['cell_2_txt']		= $i18nDoc['col_2_txt'];
// $T['tab_infos']['cell_3_txt']		= $i18nDoc['col_3_txt'];
// $T['tab_infos']['cell_4_txt']		= $i18nDoc['col_4_txt'];

$T['ADC']['onglet']['1']['nbr_ligne']	= $i;
$T['ADC']['onglet']['1']['nbr_cellule']	= 4;
$T['ADC']['onglet']['1']['legende']		= 1;

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

$Content .= "<br>\r&nbsp;
</form>\r
</td>\r
</tr>\r
</table>\r
<br>\r
";


/*Hydre-contenu_fin*/
?>
