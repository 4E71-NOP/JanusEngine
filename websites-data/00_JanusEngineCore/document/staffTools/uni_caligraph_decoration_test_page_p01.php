<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
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
/*JanusEngine-IDE-end*/

// $CurrentSetObj->setDataEntry('TestMode', 1 ); 
// $CurrentSetObj->setDataEntry('formScrExec', array(
// // 		"inputFile"	=>	"../websites-data/" . JANUS_ENGINE_CORE_SCRIPT_DIR . "/document/uni_actualite_p01.php",
// 		"inputFile"	=>	"websites-data/www.janus-engine.net/document/eng_acceuil_p01.htm",
// 	)
// );

// $bts->RequestDataObj->setRequestData('formGenericData',
// 		array(
// 				'origin'				=> 'AdminScriptExecutionP01',
// 		)
// );


// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_script_execution_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Page de visualisation de la décoration caligraphe<br>\r",
			"tabTxt1"		=>	"Onglet 01",
			"tabTxt2"		=>	"Onglet 02",
			"button"		=>	"Bouton Lorem Ipsum",
		),
		"eng" => array(
			"invite1"		=> "Visualisation page of caligraph decoration.<br>\r",
			"tabTxt1"		=>	"Tab zero 1",
			"tabTxt2"		=>	"Tab zero 2",
			"button"		=>	"Lorem Ipsum Button",
		)
	)
);

$formInputFile = $bts->RequestDataObj->getRequestDataSubEntry('formScrExec', 'inputFile');

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "formScrExec",
		"formTargetId"		=> "formScrExec[inputFile]",
		"formInputSize"		=> 60 ,
		"formInputVal"		=> $formInputFile,
		"path"				=> $WebSiteObj->getWebSiteEntry('ws_directory')."/document",
		"restrictTo"		=> "websites-data",
		"strRemove"			=> "",
		"strAdd"			=> "../",
		"selectionMode"		=> "file",
		"displayType"		=> "fileList",
		"buttonId"			=> "buttonScriptExec",
		"case"				=> 1,
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );

// --------------------------------------------------------------------------------------------
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1');
$Content .= "
<h1>Lorem Ipsum</h1>\r
<h2>Lorem Ipsum</h2>\r
<h3>Lorem Ipsum</h3>\r
<h4>Lorem Ipsum</h4>\r

<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus gravida mi sed ligula efficitur, eget finibus elit fermentum. Nam ultrices molestie nibh, at congue felis auctor eget. Vestibulum consectetur, ipsum ut iaculis egestas, tortor diam pellentesque urna, at sodales velit felis nec justo. Aliquam eu sapien ultrices, auctor elit sed, consequat lorem. In augue dolor, condimentum sit amet ullamcorper a, ullamcorper eu nibh. Vestibulum interdum turpis in tellus posuere sollicitudin. Sed orci sem, accumsan in ligula varius, feugiat vestibulum mauris. Nulla pulvinar id nunc sed venenatis. Nulla ultricies consectetur auctor. 
</p>

<h5>Lorem Ipsum</h5>\r
<h6>Lorem Ipsum</h6>\r
<h7>Lorem Ipsum</h7>\r

<hr>

<table class='".$Block._CLASS_TABLE_STD_."'>\r
<caption>Lorem Ipsum</caption>\r
";
// --------------------------------------------------------------------------------------------
// table 01
$tab = array( "a", "b" , "c" , "d");
foreach ( $tab as $Letter ) {
	$Content .= "<tr>";
	for ( $i=1 ; $i <= 4; $i++) {
		$Content .= "<td>-- ".$Letter." ".$i." --</td>";
	}
	$Content .= "</tr>\r";
}
$Content .= "</table>\r<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
// table 02
$Content .= "
<table class='".$Block._CLASS_TABLE01_."'>\r
<caption>Lorem Ipsum</caption>\r
";
$tab = array( "a", "b" , "c" , "d");
foreach ( $tab as $Letter ) {
	$Content .= "<tr>";
	for ( $i=1 ; $i <= 4; $i++) {
		$Content .= "<td>-- ".$Letter." ".$i." --</td>";
	}
	$Content .= "</tr>\r";
}
$Content .= "</table>\r<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
// RenderTable 
$T = array();

reset ($tab);
$l = 1;
foreach ( $tab as $Letter ) {
	for ( $c=1 ; $c <= 4; $c++) {
		$T['Content']['1'][$l][$c]['cont'] = $Letter." ". $c;
		$T['Content']['2'][$l][$c]['cont'] = $Letter." ". $c;
	}
	$l++;
}

$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 5, 2);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(4,4,1),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(4,4,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T). "<br>\r";

// --------------------------------------------------------------------------------------------

$SB = array(
	"id"				=> "Test01",
	"type"				=> "button",
	"initialStyle"		=> $Block."_submit_s1_n",
	"hoverStyle"		=> $Block."_submit_s1_h",
	"onclick"			=> "",
	"message"			=> $bts->I18nTransObj->getI18nTransEntry('button'),
	"mode"				=> 0,
	"size" 				=> 256,
	"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB) . "<br>\r<br>\r";

$SB["id"]				= "Test02";
$SB["initialStyle"]		= $Block."_submit_s2_n";
$SB["hoverStyle"]		= $Block."_submit_s2_h";
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB) . "<br>\r<br>\r";

$SB["id"]				= "Test03";
$SB["initialStyle"]		= $Block."_submit_s3_n";
$SB["hoverStyle"]		= $Block."_submit_s3_h";
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB) . "<br>\r<br>\r";

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/

?>