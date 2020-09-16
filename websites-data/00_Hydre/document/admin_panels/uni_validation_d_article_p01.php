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

// $RequestDataObj->setRequestDataEntry('script_source',"");
$RequestDataObj->setRequestDataEntry('RenderCSS',
		array(
				'CssSelection' => 2,
				'go' => 1,
		),
		);

/*Hydre-contenu_debut*/
$localisation = " / uni_validation_d_article_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_validation_d_article_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_validation_d_article_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=>	"Cette partie va vous permettre de valider des articles.",
		"raf1"			=>	"Rien à afficher",
		"cell_1_txt"	=> "Informations",
		"col_1_txt"		=>	"Nom",
		"col_2_txt"		=>	"Référence",
		"col_3_txt"		=>	"Titre",
		"col_4_txt"		=>	"Bouclage",
		"btn1"			=>	"Cr&eacute;er un article",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=>	"This part will allow you to validate documents.",
		"raf1"			=>	"Nothing to display",
		"cell_1_txt"	=> "Informations",
		"col_1_txt"		=>	"Name",
		"col_2_txt"		=>	"Reference",
		"col_3_txt"		=>	"Title",
		"col_4_txt"		=>	"Deadline",
		"btn1"			=>	"Create a article",
		));
		break;
}


// --------------------------------------------------------------------------------------------
$T = array();

$dbquery = $SDDMObj->query("
SELECT art.* , bcl.bouclage_nom 
FROM ".$SqlTableListObj->getSQLTableName('article')." art, ".$SqlTableListObj->getSQLTableName('bouclage')." bcl 
WHERE art.arti_validation_etat = '0' 
AND bcl.bouclage_id = art.arti_bouclage 
AND art.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
;");

$i = 1;
if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {

	$T['AD']['1'][$i]['1']['cont'] = $I18nObj->getI18nEntry('nothingToDisplay');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
	$T['AD']['1'][$i]['4']['cont'] = "";
}
else {
	$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
	$T['AD']['1'][$i]['4']['cont']	= $I18nObj->getI18nEntry('col_4_txt');
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "
		<a class='" . $Block."_lien' href='index.php?
		&amp;M_ARTICL[arti_id_selection]=".$dbp['arti_id']."
		&amp;M_ARTICL[arti_ref_selection]=".$dbp['arti_ref']."
		&amp;M_ARTICL[arti_page_selection]=".$dbp['arti_page'].
		$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup')."
		&amp;arti_page=2'
		>".$dbp['arti_nom']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $dbp['arti_ref'];
		$T['AD']['1'][$i]['3']['cont']	= $dbp['arti_titre'];
		$T['AD']['1'][$i]['4']['cont']	= $dbp['bouclage_nom'];
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
$T['tab_infos']['CellName']			= "art";
$T['tab_infos']['DocumentName']		= "doc";
$T['tab_infos']['cell_1_txt']		= $I18nObj->getI18nEntry('cell_1_txt');

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
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')."
<input type='hidden' name='arti_page'	value='2'>\r
<input type='hidden' name='uni_gestion_des_articles_p' value='3';".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_login').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_pass')."
";


$SB = array(
		"id"				=> "createButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "",
		"message"			=> $I18nObj->getI18nEntry('btn1'),
		"mode"				=> 0,
		"size" 				=> 128,
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
