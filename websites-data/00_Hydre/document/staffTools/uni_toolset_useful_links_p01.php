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

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

// $RequestDataObj->setRequestDataEntry('script_source',"");

/*Hydr-Content-Begin*/
$localisation = " / uni_toolset_useful_links_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_toolset_useful_links_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_toolset_useful_links_p01.php");


$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Liste d'URL utiles",
			"tabTxt1"		=>	"JavaScript",
			"tabTxt2"		=>	"CSS",
			"tabTxt3"		=>	"Validation",
			"tabTxt4"		=>	"Gratuit",
		),
		"eng" => array(
			"invite1"		=>	"Useful links",
			"tabTxt1"		=>	"JavaScript",
			"tabTxt2"		=>	"CSS",
			"tabTxt3"		=>	"Validation",
			"tabTxt4"		=>	"Free Stuff",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

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

$T['ContentCfg']['tabs'] = array(
	1	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,1,0),
	2	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,1,0),
	3	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,1,0),
	4	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,1,0),
);

$tab = 1;
unset ($A);
reset ($collection);
foreach ( $collection as $key => $A ) {
	$i = 1;
	unset ( $B );
	foreach ( $A as $B ) {
		$T['Content'][$tab][$i]['1']['cont']	= "<a class='".$Block."_lien' style='display:block;' target='_blank' href='".$B['url']."'>".$B['name']."</a>";
		$T['Content'][$tab][$i]['1']['style']	= "padding:4px;";
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "Processing tab[".$tab."]line[".$i."]/collection[" . $B['name']. ']'));
		$i++;

	}
	$T['ContentCfg']['tabs'][$tab]['NbrOfLines'] = ($i-1);	
	// $T['ContentCfg']['tabs'][$tab]['NbrOfCells'] = 1;	$T['ContentCfg']['tabs'][$tab]['TableCaptionPos'] = 0;
	$tab++;
}	
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, $i+1, ($tab-1));
$Content .= $bts->RenderTablesObj->render($infos, $T);

/*Hydr-Content-End*/
?>
