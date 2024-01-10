<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
//	Module : ModuleLogo
// --------------------------------------------------------------------------------------------

class ModuleLogo {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$localisation = " / ModuleLogo";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("ModuleLogo");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("ModuleLogo");
		
		$l = $CurrentSetObj->getDataEntry('language');
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ) );
		// $i18n = array();
		// include ($infos['module']['module_directory']."/i18n/".$l.".php");
		// $bts->I18nTransObj->apply($i18n);
		// unset ($i18n);
		$Content = "";
		
		$Content .= "
		<div style='text-align: center;'>\r
		<a href='".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_home')."' onMouseOver=\"t.ToolTip('".$bts->SDDMObj->escapeString($bts->I18nTransObj->getI18nTransEntry('tooltip'))."')\" onMouseOut=\"t.ToolTip()\">\r
		<img src='".
			$CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')
			."media/theme/".$CurrentSetObj->ThemeDataObj->getDefinitionValue('directory')
			."/".$CurrentSetObj->ThemeDataObj->getDefinitionValue('logo')
			."' alt='".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_name')."' style='border:0px'
		>\r
		</a>\r
		</div>\r
		";
		
		// Cleaning up
		if ( $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
				$CurrentSetObj,
				);
		}
		
		return $Content;
		
	}
}
?>