<?php
 /*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/
//	Module : InstallDocument
// --------------------------------------------------------------------------------------------

class InstallDocument {
	public function __construct(){}
	
	/**
	 * Render the install document
	 */
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "InstallDocument");
		$l = $CurrentSetObj->getDataEntry ('language');
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ));

		if ($bts->RequestDataObj->getRequestDataEntry ( 'PageInstall' ) == null) {
			$bts->RequestDataObj->setRequestData ( 'PageInstall', 1 );
		}

		switch ($bts->RequestDataObj->getRequestDataEntry ( 'PageInstall' )) {
			case "1" :
				include ($infos['module']['module_directory']."/install_page_01.php");
				$pageInstallObj = InstallPage01::getInstance();
				break;
			case "2" :
				include ($infos['module']['module_directory']."/install_page_02.php");
				$pageInstallObj = InstallPage02::getInstance();
				break;
			case "3" :
				include ($infos['module']['module_directory']."/install_page_03.php");
				$pageInstallObj = InstallPage03::getInstance();
				break;
		}
		$DocContent .= $pageInstallObj->render($infos);
		$DocContent .= "</div>\r</div>\r";

		if ( $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
			);
		}

		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
		$GeneratedScriptObj->insertString('JavaScript-File', $infos['module']['module_directory'].'javascript/lib_install.js');
		$GeneratedScriptObj->insertString('JavaScript-File', $infos['module']['module_directory'].'javascript/lib_testdb.js');
		$GeneratedScriptObj->insertString('JavaScript-File', $infos['module']['module_directory'].'javascript/lib_monitorInstall.js');
		$GeneratedScriptObj->insertString('JavaScript-Init', 'var li = new LibInstall();');
		$GeneratedScriptObj->insertString('JavaScript-Init', 'var tdb = new LibTestDB();');
		$GeneratedScriptObj->insertString('JavaScript-Init', 'var mi = new LibMonitorInstall();');


		$bts->segmentEnding(__METHOD__);
		return ($DocContent);
	}
}
?>