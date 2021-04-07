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
//	Module : ModuleFooter
// --------------------------------------------------------------------------------------------

class ModuleFooter {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$localisation = " / ModuleFooter";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("ModuleFooter");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("ModuleFooter");
		
// 		$l = $bts->CMObj->getLanguageListSubEntry($CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang'), 'lang_639_3');
		$l = $CurrentSetObj->getDataEntry ( 'language');
		$i18n = array();
		include ($infos['module']['module_directory']."/i18n/".$l.".php");
		
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$Content = "
		<table style='margin-left: auto; margin-right: auto;'>\r
		<tr>\r
		<td style='text-align: right;'>
		".$i18n['engine']."<a href='http://".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_home')."' target='_new'>Hydr</a><br>".$i18n['author']."<br>".$i18n['license']."<span style='font-weight: bold;'>CC-by-nc-sa</span></td>\r
		<td style='text-align: left;'><a rel='license' href='http://creativecommons.org/licenses/by-nc-sa/4.0/'><img alt='Licence Creative Commons' style='border-width:0' src='https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png'/></a></td>\r
		</tr>\r
		</table>\r
		";
		
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$i18n,
				$localisation,
				);
		}
		return $Content;
	}
}
?>