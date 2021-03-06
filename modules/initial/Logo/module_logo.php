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

class ModuleLogo {
	public function __construct(){}
	
	public function render ($infos) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$localisation = " / ModuleCoatOfArms";
		$cs->MapperObj->AddAnotherLevel($localisation );
		$cs->LMObj->logCheckpoint("ModuleLogo");
		$cs->MapperObj->RemoveThisLevel($localisation );
		$cs->MapperObj->setSqlApplicant("ModuleLogo");
		
		$l = $CurrentSetObj->getDataEntry('language');
		$i18n = array();
		include ($infos['module']['module_directory']."/i18n/".$l.".php");
		$cs->I18nObj->apply($i18n);
		unset ($i18n);
		$Content = "";
		
		$Content .= "
		<div style='text-align: center;'>\r
		<a href='".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_home')."' onMouseOver=\"t.ToolTip('".$cs->SDDMObj->escapeString($cs->I18nObj->getI18nEntry('tooltip'))."')\" onMouseOut=\"t.ToolTip()\">\r
		<img src='../media/theme/".$CurrentSetObj->getInstanceOfThemeDataObj()->getThemeDataEntry('theme_directory')."/".$CurrentSetObj->getInstanceOfThemeDataObj()->getThemeDataEntry('theme_logo')."' alt='".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_name')."' border='0'>\r
		</a>\r
		</div>\r
		";
		
		// Cleaning up
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
				$CurrentSetObj,
				);
		}
		
		return $Content;
		
	}
}
?>