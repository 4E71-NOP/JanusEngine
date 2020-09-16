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
//	Module : ModuleDynamicHelp
// --------------------------------------------------------------------------------------------

class ModuleDynamicHelp {
	public function __construct(){}
	
	public function render ($infos) {
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
		$CMObj = ConfigurationManagement::getInstance();
		
		$localisation = " / ModuleDynamicHelp";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleDynamicHelp");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleDynamicHelp");
		
		$CurrentSet = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSet->getInstanceOfWebSiteObj();
		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
		$GeneratedJavaScriptObj = $CurrentSet->getInstanceOfGeneratedJavaScriptObj();
		$RenderLayoutObj = RenderLayout::getInstance();
		
		$cdx = $RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_nom'], 'cdx'); 
		$cdy = $RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_nom'], 'cdy'); 

		$GeneratedJavaScriptObj->insertJavaScript('File', 'routines/website/javascript_Aide_dynamique.js');
		$GeneratedJavaScriptObj->insertJavaScript('File', 'routines/website/javascript_lib_calculs_decoration.js');
		$GeneratedJavaScriptObj->insertJavaScript('Onload', "\tinitAdyn('".$infos['module']['module_conteneur_nom']."' , '".$infos['module']['module_nom']."_ex22' , '".$cdx."' , '".$cdy."' );");

		// Cleaning up
		if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
			unset (
				$localisation,
				$MapperObj,
				$LMObj,
				$CurrentSet,
				$WebSiteObj,
				$ThemeDataObj,
				$GeneratedJavaScriptObj,
				$RenderLayoutObj,
				$CMObj
				);
		}
	
	}
}
?>