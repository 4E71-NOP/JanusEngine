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

$CurrentSetObj->setDataEntry('TestMode', 1 ); 
$CurrentSetObj->setDataEntry('formScrExec', array(
// 		"inputFile"	=>	"../websites-data/00_Hydre/document/uni_actualite_p01.php",
		"inputFile"	=>	"../websites-data/www.multiweb-manager.net/document/eng_acceuil_p01.mwmcode",
) 
);

$RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'				=> 'AdminScriptExecutionP01',
		)
);


// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/

$localisation = " / uni_execution_de_scripts_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_execution_de_scripts_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_execution_de_scripts_p01");

switch ($l) {
	case "fra":
		$i18nDoc = array(
		"invite1"		=> "Cette partie va vous permettre de tester du code PHP. Entrez un nom de fichier qui contient un script PHP et vous pourrez le tester directement dans l'interface. Le fichier doit se trouver dans le repertoire 'Document'.<br>\r",
		"tf1"			=> "Passage en mode MWM",
		);
		break;
	case "eng":
		$i18nDoc = array(
		"invite1"		=> "This part will help you test some PHP code. Enter a filename and you will be able to test it directly. The file must be located in the 'Document' directory.<br>\r",
		"tf1"			=> "MWM code mode",
		);
		break;
}

$formInputFile = $RequestDataObj->getRequestDataSubEntry('formScrExec', 'inputFile');
// if ( strlen($formData['ScrExec_id']) == 0 )		{ $RequestDataObj->setRequestData('ScrExec_id', 'test_001.php'); }
// if ( strlen($formData['ScrExec_rep']) == 0 )		{ $RequestDataObj->setRequestData('ScrExec_rep', $WebSiteObj->getWebSiteEntry('sw_repertoire')); }
// if ( strlen($formData['ScrExec_file']) == 0 )	{ $RequestDataObj->setRequestData('ScrExec_file', $RequestDataObj->getRequestDataEntry('ScrExec_rep')."/document/".$RequestDataObj->getRequestDataEntry('ScrExec_id')); }

$FileSelectorConfig = array(
		"width"				=> 80,	//in %
		"height"			=> 50,	//in %
		"formName"			=> "formScrExec",
		"formTargetId"		=> "formScrExec[inputFile]",
		"formInputSize"		=> 60 ,
		"formInputVal"		=> $formInputFile,
		"path"				=> $WebSiteObj->getWebSiteEntry('sw_repertoire')."/document",
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
$Content .= $I18nObj->getI18nEntry('invite1');
$Content .= "
<form name='formScrExec' ACTION='index.php?' method='post'>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_login').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_pass').
"
<table cellpadding='0' cellspacing='0' style='width :".($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') - 16)."px;'>
<tr>\r
<td>\r"
.$InteractiveElementsObj->renderIconSelectFile($infos)
."</td>\r
<td>\r
</td>\r
</tr>\r

<tr>\r
<td>\r
</td>\r
<td>\r
";


$SB = array();
$SB['id']				= "execButton";
$SB['type']				= "submit";
$SB['initialStyle']		= $Block."_t3 ".$Block."_submit_s1_n";
$SB['hoverStyle']		= $Block."_t3 ".$Block."_submit_s1_h";
$SB['onclick']			= "";
$SB['message']			= $I18nObj->getI18nEntry('btnExecute');
$SB['mode']				= 1;
$SB['size'] 			= 128;
$SB['lastSize']			= 0;
$Content .= $InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</td>\r
</tr>\r
</table>\r

<br>\r
</form>\r
<hr>\r
";

$path = $_SERVER['DOCUMENT_ROOT']."Hydr/websites-data/";
$fileName = $path.$formInputFile;
$StringFormat = StringFormat::getInstance();
// $Content .= $StringFormat->print_r_html($formData);

if ( file_exists($fileName) && $CurrentSetObj->getDataEntry('TestMode') != 1 ) {
	if ( strpos($fileName ,".mwmcode") !== FALSE ) {
		$fileHandle = fopen($fileName,"r");
		$fileData = fread($fileHandle,filesize($fileName));
		if ($fileData === FALSE) {$Content .= "ERRRRRRR<br>\r";}
		$this->documentConvertion($fileData, $infos);		// ModuleDocument->documentConvertion()
		$Content .= $I18nObj->getI18nEntry('tf1')."<br>\r".$formInputFile."<hr>\r".$fileData ;
		fclose($fileHandle);
	}
	else { include ($fileName); }
}

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
