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
//	Module : ModuleCoatOfArms
// --------------------------------------------------------------------------------------------

class ModuleCoatOfArms {
	public function __construct(){}
	
	public function render ($infos) {
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
		$CMObj = ConfigurationManagement::getInstance();
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		
		$localisation = " / ModuleCoatOfArms";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleCoatOfArms");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleCoatOfArms");
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$l = $CurrentSetObj->getDataEntry('language');
		$i18n = array();
		include ("../modules/initial/Blason/i18n/".$l.".php");
		$Content = "";

		$Content .= "
		<div style='text-align: center;'>\r
		<a href='".$WebSiteObj->getWebSiteEntry('sw_home')."' onMouseOver=\"t.ToolTip('".$SDDMObj->escapeString($i18n['tooltip'])."')\" onMouseOut=\"t.ToolTip()\">\r
		<img src='../graph/".$ThemeDataObj->getThemeDataEntry('theme_repertoire')."/".$ThemeDataObj->getThemeDataEntry('theme_blason')."' alt='".$WebSiteObj->getWebSiteEntry('sw_nom')."' border='0'>\r
		</a>\r
		</div>\r
		";
		
		// Cleaning up
		if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
			unset (
				$i18n,
				$localisation,
				$MapperObj,
				$LMObj,
				$MapperObj,
				$CurrentSetObj,
				$WebSiteObj,
				$ThemeDataObj,
				$CMObj
				);
		}
		
		return $Content;
		
	}
}
?>