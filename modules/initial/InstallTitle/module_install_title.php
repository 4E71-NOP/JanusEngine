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
//	Module : InstallTitle
// --------------------------------------------------------------------------------------------

class InstallTitle {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "InstallTitle");
		
		$l = $CurrentSetObj->getDataEntry ('language');
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ));
		
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];
		$Content = "<span style='display:block; text-align:center; vertical-align:middle; padding:10px; font-size:38px; font-weight:bold;'>". $bts->I18nTransObj->getI18nTransEntry("Invite"); "</span>";

			if ( $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
			);
		}

		$bts->segmentEnding(__METHOD__);
		return $Content;
	}
}
?>