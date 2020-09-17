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
//	Module : ModuleCalendar
// --------------------------------------------------------------------------------------------

class ModuleCalendar {
	public function __construct(){}
	
	public function render ($infos) {
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
		$CMObj = ConfigurationManagement::getInstance();
		
		$localisation = " / ModuleCalendar";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleCalendar");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleCalendar");
		
		$CurrentSet = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSet->getInstanceOfWebSiteObj();
		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('ws_lang'), 'langue_639_3');
		
		$i18n = array();
		include ("../modules/initial/Calendar/i18n/".$l.".php");
	
		$CurrentDate = mktime(0,0,0,date('m'), date('d'), date('Y'));
		$date = array(
				'day' => date('N', $CurrentDate),
				'number' => date('d', $CurrentDate),
				'month' => date('n', $CurrentDate)
		);
		
		$pv = array(
			'table_hauteur' => 64 ,
			'table_largeur' => 72,
		);
		$pv['table_margintop'] = floor (( $ThemeDataObj->getThemeDataEntry('theme_module_hauteur_interne') - $pv['table_hauteur'] ) /2);
		$pv['table_marginright'] = floor (( $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') - $pv['table_largeur'] ) /2);
		
		$Content = "
		<table cellpadding='0' cellspacing='0' style='height: ".$pv['table_hauteur']."px; margin-top: ".$pv['table_margintop']."px; margin-left: auto; margin-right: auto;'>
						
		<tr>\r
		<td rowspan='2' style='font-size: ".( $pv['table_hauteur'] - 8 )."px; font-weight: bold; vertical-align: middle;'>\r".$date['number']."</td>\r
		<td class='" . $ThemeDataObj->getThemeName().$infos['block']."_t4'>\r".$i18n['day'][$date['day']]."</td>\r
		</tr>\r
		<tr>\r
		<td class='" . $ThemeDataObj->getThemeName().$infos['block']."_tb6'>\r".$i18n['month'][$date['month']]."</td>\r
		</tr>\r
		</table>\r
		";
		
		if ( $WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
				$MapperObj,
				$LMObj,
				$MapperObj,
				$CurrentSet,
				$WebSiteObj,
				$ThemeDataObj,
				$CMObj,
				$CurrentDate,
				$date,
				$pv
				);
		}
		return $Content;
	}
}
?>