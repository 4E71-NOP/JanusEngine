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

$CurrentSetObj->setDataEntry('TestMode', 1);
$CurrentSetObj->setDataEntry(
	'formScrExec',
	array(
		// 		"inputFile"	=>	"../websites-data/00_JanusEngineCore/document/uni_actualite_p01.php",
		"inputFile"	=>	"websites-data/www.janus-engine.net/document/eng_acceuil_p01.htm",
	)
);

$bts->RequestDataObj->setRequestData(
	'formGenericData',
	array(
		'origin'				=> 'AdminScriptExecutionP01',
	)
);

// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_script_execution_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de tester du code PHP. Sélectionnez un fichier qui contient un script PHP et vous pourrez le tester directement dans l'interface. Le fichier doit se trouver dans le repertoire 'Document'.<br>\r",
			"processing"	=> "Traitement de : ",
			"mode"			=> "Mode : "
		),
		"eng" => array(
			"invite1"		=> "This part will help you test some PHP code. Select a file and you will be able to test it directly. The file must be located in the 'Document' directory.<br>\r",
			"processing"	=> "Processing : ",
			"mode"			=> "Mode : "
		)
	)
);

$formInputFile = $bts->RequestDataObj->getRequestDataSubEntry('formScrExec', 'inputFile');

$FileSelectorConfig = array(
	"width"				=> 80,	//in %
	"height"			=> 50,	//in %
	"formName"			=> "formScrExec",
	"formTargetId"		=> "formScrExec[inputFile]",
	"formInputSize"		=> 60,
	"formInputVal"		=> $formInputFile,
	"path"				=> $WebSiteObj->getWebSiteEntry('ws_directory') . "/document",
	"restrictTo"		=> "websites-data",
	"strRemove"			=> "",
	"strAdd"			=> "../",
	"selectionMode"		=> "file",
	"displayType"		=> "fileList",
	"buttonId"			=> "buttonScriptExec",
	"case"				=> 1,
	"array"				=> "tableFileSelector[" . $CurrentSetObj->getDataEntry('fsIdx') . "]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);

// --------------------------------------------------------------------------------------------
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1');
$Content .= "
<form name='formScrExec' ACTION='/' method='post'>\r
<input type='hidden' name='formSubmitted'					value='1'>
<input type='hidden' name='formGenericData[origin]'			value='AdminScriptExecutionP01'>

<table cellpadding='0' cellspacing='0' style='width:100%;'>
<tr>\r
<td colspan='2'>\r"
	. $bts->InteractiveElementsObj->renderIconSelectFile($infos)
	. "</td>\r
</tr>\r

<tr>\r
<td style='width:60%;'>\r

</td>\r
<td style='width:35%;'>\r
";

$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
	$infos,
	'submit',
	$bts->I18nTransObj->getI18nTransEntry('btnExecute'),
	128,
	'scriptExecButton',
	1,
	1,
	""
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</td>\r
</tr>\r
</table>\r

<br>\r
</form>\r
<hr>\r
";

$path = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/";
$fileName = str_replace("//",  "/", $path . $formInputFile);

$logTitle = "Script Execution - Start";
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT,	'msg' => "+--------------------------------------------------------------------------------+"));
$bts->LMObj->msgLog(array('level' => LOGLEVEL_INFORMATION, 'msg' => "| " . $logTitle . str_repeat(" ", (82 - (strlen($logTitle ?? '') + 3))) . "|"));
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT,	'msg' => "|                                                                                |"));
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT,	'msg' => "+--------------------------------------------------------------------------------+"));

$bts->LMObj->msgLog(array(
	'level' => LOGLEVEL_BREAKPOINT,
	'msg' => __METHOD__ .
		"Route state : currentRoute=" .
		$bts->StringFormatObj->arrayToString($bts->SMObj->getSessionSubEntry($CurrentSetObj->getDataEntry('ws'), 'currentRoute'))
		. " / previousRoute=" .
		$bts->StringFormatObj->arrayToString($bts->SMObj->getSessionSubEntry($CurrentSetObj->getDataEntry('ws'), 'previousRoute'))
));

$bts->LMObj->msgLog(array(
	'level' => LOGLEVEL_BREAKPOINT,
	'msg' =>  __METHOD__ . " Processing file : '" . $fileName . "'.'"
));
if (file_exists($fileName) && $CurrentSetObj->getDataEntry('TestMode') != 1) {
	$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('processing') . $formInputFile . "<br>\r";


	switch (true) {
		case (strpos($fileName, ".htm")):
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT,	'msg' =>  __METHOD__ . " File type is HTML"));
			$Content .= $bts->I18nTransObj->getI18nTransEntry('mode') . " HTML</p>\r<hr>\r";
			$fileHandle = fopen($fileName, "r");
			$fileData = fread($fileHandle, filesize($fileName));
			if ($fileData === FALSE) {
				$Content .= "ERROR : Something horrible happended!<br>\r";
			}
			// 			$this->documentConvertion($fileData, $infos);		// ModuleDocument->documentConvertion()
			fclose($fileHandle);
			break;
		case (strpos($fileName, ".php")):
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT,	'msg' =>  __METHOD__ . " File type is PHP"));
			$Content .= $bts->I18nTransObj->getI18nTransEntry('mode') . "PHP</p>\r<hr>\r";
			$fileData = include($fileName);
			break;
	}
	$Content .= $fileData;
} else {
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING,	'msg' =>  __METHOD__ . " File '" . $fileName . "' not found. From PWD '" . $path . "'."));
}

$bts->LMObj->msgLog(array(
	'level' => LOGLEVEL_BREAKPOINT,
	'msg' => __METHOD__ . 	"Route state : currentRoute=" .
		$bts->StringFormatObj->arrayToString($bts->SMObj->getSessionSubEntry($CurrentSetObj->getDataEntry('ws'), 'currentRoute'))
		. " / previousRoute=" .
		$bts->StringFormatObj->arrayToString($bts->SMObj->getSessionSubEntry($CurrentSetObj->getDataEntry('ws'), 'previousRoute'))
));

$logTitle = "Script Execution - End";
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT,	'msg' => "+--------------------------------------------------------------------------------+"));
$bts->LMObj->msgLog(array('level' => LOGLEVEL_INFORMATION, 'msg' => "| " . $logTitle . str_repeat(" ", (82 - (strlen($logTitle ?? '') + 3))) . "|"));
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT,	'msg' => "+--------------------------------------------------------------------------------+"));

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
