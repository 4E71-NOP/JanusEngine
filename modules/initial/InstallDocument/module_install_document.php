<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
//	Module : InstallDocument
// --------------------------------------------------------------------------------------------

class InstallDocument {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$localisation = " / InstallDocument";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("InstallDocument");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("InstallDocument");
		
		$l = $CurrentSetObj->getDataEntry ('language');
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ));

		$localisation = "Page";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Page" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Page" );

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
		}
		$DocContent .= $pageInstallObj->render($infos);
		$DocContent .= "</div>\r</div>\r";

		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
			);
		}
		return ($DocContent);
	}
}
?>