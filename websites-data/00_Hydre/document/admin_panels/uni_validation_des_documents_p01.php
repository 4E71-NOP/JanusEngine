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
/* @var $AdminFormToolObj AdminFormTool             */
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $I18nObj I18n                               */
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

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

// --------------------------------------------------------------------------------------------
$RequestDataObj->setRequestData('scriptFile', '01020203110001_p02.wmcode');
$RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_validation_des_documents_p01.php";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_validation_des_documents_p01.php");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_validation_des_documents_p01.php");


switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=>	"Cette partie va vous permettre de modifier les documents.",
		"type0"			=>	"Hydr",
		"type1"			=>	"Pas de code",
		"type2"			=>	"PHP",
		"type3"			=>	"Mixed",
		"modif0"		=>	"Non",
		"modif1"		=>	"Oui",
		"cell_1_txt"	=>	"Informations",
		"col_1_txt"		=>	"Nom",
		"col_2_txt"		=>	"Type",
		"col_3_txt"		=>	"Modifiable",
		"raf1"			=>	"Rien a afficher",
		"btn1"			=>	"Créer un document",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=>	"This part will allow you to modify documents.",
		"type0"			=>	"Hydr",
		"type1"			=>	"No code",
		"type2"			=>	"PHP",
		"type3"			=>	"Mixed",
		"modif0"		=>	"No",
		"modif1"		=>	"Yes",
		"cell_1_txt"	=>	"Informations",
		"col_1_txt"		=>	"Name",
		"col_2_txt"		=>	"Type",
		"col_3_txt"		=>	"Can be modified",
		"raf1"			=>	"Nothing to display",
		"btn1"			=>	"Create a document",
		));
		break;
}

// --------------------------------------------------------------------------------------------

$dbquery = $SDDMObj->query("
SELECT doc.docu_id,doc.docu_nom,doc.docu_type,shr.share_modification 
FROM ".$SqlTableListObj->getSQLTableName('document')." doc, ".$SqlTableListObj->getSQLTableName('document_share')." shr 
WHERE shr.site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND shr.docu_id = doc.docu_id 
AND doc.docu_correction = '0' 
AND doc.docu_origine = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
;");

$tab_modif = array(
		0 => $I18nObj->getI18nEntry('modif0'),
		1 => $I18nObj->getI18nEntry('modif1'),
);
$tab_type = array(
		0 => $I18nObj->getI18nEntry('type0'),
		1 => $I18nObj->getI18nEntry('type1'),
		2 => $I18nObj->getI18nEntry('type2'),
		3 => $I18nObj->getI18nEntry('type3'),
);

$T = array();
$i = 1;
if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
	$T['AD']['1'][$i]['1']['cont'] = $I18nObj->getI18nEntry('nothingToDisplay');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
}
else {
	$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "<a class='" . $Block."_lien " . $Block."_t1' href='index.php?&amp;M_DOCUME[document_selection]=".$dbp['docu_id'].$bloc_html['url_sldup']."&amp;arti_page=2'>".$dbp['docu_nom']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $tab_type[$dbp['docu_type']];
		$T['AD']['1'][$i]['3']['cont']	= $tab_modif[$dbp['part_modification']];
	}
}

$T['tab_infos']['EnableTabs']		= 1;
$T['tab_infos']['NbrOfTabs']		= 1;
$T['tab_infos']['TabBehavior']		= 0;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 1;
$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_nom'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "list";
$T['tab_infos']['CellName']			= "dl";
$T['tab_infos']['DocumentName']		= "doc";
$T['tab_infos']['cell_1_txt']		= $I18nObj->getI18nEntry('cell_1_txt');

$T['ADC']['onglet']['1']['nbr_ligne']	= $i;
$T['ADC']['onglet']['1']['nbr_cellule']	= 3;
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

// --------------------------------------------------------------------------------------------
$Content .= "
<br>\r
<br>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
<form ACTION='index.php?' method='post'>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
"<input type='hidden' name='arti_page'	value='2'>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_login').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_pass')
;

$SB = array(
		"id"				=> "createButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "",
		"message"			=> $I18nObj->getI18nEntry('btn1'),
		"mode"				=> 0,
		"size" 				=> 0,
		"lastSize"			=> 0,
);
$Content .= $InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "<br>\r&nbsp;
</form>\r
</td>\r
</tr>\r
</table>\r
<br>\r
";

/*Hydre-contenu_fin*/
?>
