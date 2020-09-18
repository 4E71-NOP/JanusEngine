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

/*Hydre-contenu_debut*/
$localisation = " / uni_outil_url_utiles_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_outil_url_utiles_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_outil_url_utiles_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=>	"Liste d'URL utiles",
		"cell_1_txt"			=>	"JavaScript",
		"cell_2_txt"			=>	"CSS",
		"cell_3_txt"			=>	"Validation",
		"cell_4_txt"			=>	"Gratuit",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=>	"Useful links",
		"cell_1_txt"			=>	"JavaScript",
		"cell_2_txt"			=>	"CSS",
		"cell_3_txt"			=>	"Validation",
		"cell_4_txt"			=>	"Free Stuff",
		));
		break;
}

$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

$collection = array(
	"JavaScript" => array(
		0 => array ( "name"=>"JSFiddle",					"url"=> "http://jsfiddle.net"),
		1 => array ( "name"=>"CodeBeautify",				"url"=> "https://codebeautify.org/jsvalidate"),
		2 => array ( "name"=>"JSLint",						"url"=> "http://jslint.com/"),
		3 => array ( "name"=>"Esprima validate",			"url"=> "http://esprima.org/demo/validate.html"),
		4 => array ( "name"=>"DevDocs",						"url"=> "http://devdocs.io/javascript/"),
	),
	"CSS" => array(
		0 => array ( "name"=>"CSS-Tricks",					"url"=> "https://css-tricks.com/snippets/css/a-guide-to-flexbox/"),
		1 => array ( "name"=>"W3Schools",					"url"=> "https://www.w3schools.com/cssref/pr_class_display.asp"),
		2 => array ( "name"=>"CanIUse",						"url"=> "https://caniuse.com/"),
		3 => array ( "name"=>"Wikipedia Couleur du Web",	"url"=> "https://fr.wikipedia.org/wiki/Couleur_du_Web"),
	),
	"Validation"=> array(
		0 => array ( "name"=>"JSONFormatter",				"url"=> "https://jsonformatter.org/"),
		1 => array ( "name"=>"Regex101",					"url"=> "https://regex101.com/"),
		2 => array ( "name"=>"W3",							"url"=> "https://validator.w3.org/"),
	),
	"Free"=> array(
		0 => array ( "name"=>"GoogleFonts",					"url"=> "https://fonts.google.com/"),
		1 => array ( "name"=>"Lorem Ipsum",					"url"=> "https://fr.lipsum.com/"),
		2 => array ( "name"=>"CSS Colors",					"url"=> "https://www.w3schools.com/cssref/css_colors.asp"),
	),
);


// --------------------------------------------------------------------------------------------
$T = array();
$o = 1;
unset ( $A );
foreach ( $collection as $key => &$A ) {
	$i = 1;
	unset ( $B );
	foreach ( $A as $B ) {
		$T['AD'][$o][$i]['1']['cont']	= "<a class='".$Block."_lien' style='display:block;' target='_blank' href='".$B['url']."'>".$B['name']."</a>";
		$T['AD'][$o][$i]['1']['style']	= "padding:4px;";
		$i++;
	}
	$T['ADC']['onglet'][$o]['nbr_ligne'] = ($i-1);	$T['ADC']['onglet'][$o]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$o]['legende'] = 0;
	$o++;
}

$T['tab_infos']['EnableTabs']		= 1;
$T['tab_infos']['NbrOfTabs']		= ($o-1);
$T['tab_infos']['TabBehavior']		= 1;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 0;
$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_name'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "list";
$T['tab_infos']['CellName']			= "link";
$T['tab_infos']['DocumentName']		= "doc";
$T['tab_infos']['cell_1_txt']		= $I18nObj->getI18nEntry('cell_1_txt');
$T['tab_infos']['cell_2_txt']		= $I18nObj->getI18nEntry('cell_2_txt');
$T['tab_infos']['cell_3_txt']		= $I18nObj->getI18nEntry('cell_3_txt');
$T['tab_infos']['cell_4_txt']		= $I18nObj->getI18nEntry('cell_4_txt');

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


/*Hydre-contenu_fin*/
?>
