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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$localisation = " / ModuleCalendar";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("ModuleCalendar");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("ModuleCalendar");
		
		$CurrentSet = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSet->getInstanceOfWebSiteObj();
		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
// 		$l = $bts->CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('ws_lang'), 'lang_639_3');
		$l = $CurrentSetObj->getDataEntry ( 'language');
		
		$i18n = array();
		include ("modules/initial/Calendar/i18n/".$l.".php");
	
		$CurrentDate = mktime(0,0,0,date('m'), date('d'), date('Y'));
		$date = array(
				'day' => date('N', $CurrentDate),
				'number' => date('d', $CurrentDate),
				'month' => date('n', $CurrentDate)
		);
		
		$pv = array(
			'table_height' => 64 ,
			'table_width' => 72,
		);
		$pv['table_margintop'] = floor (( $ThemeDataObj->getThemeDataEntry('theme_module_hauteur_interne') - $pv['table_height'] ) /2);
		$pv['table_marginright'] = floor (( $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') - $pv['table_width'] ) /2);
		
		$Content = "
		<table class='".$ThemeDataObj->getThemeName().$infos['block']._CLASS_TABLE_STD_."' style='height: ".$pv['table_height']."px; margin-top: ".$pv['table_margintop']."px;'>
						
		<tr>\r
		<td style='font-size:150%'>\r".$i18n['day'][$date['day']]."</td>\r
		<td rowspan='2' style='font-size: ".( $pv['table_height'] - 8 )."px; font-weight: bold; vertical-align: middle;'>\r".$date['number']."</td>\r
		</tr>\r
		<tr>\r
		<td style='font-size:200%' class='".$ThemeDataObj->getThemeName().$infos['block']._CLASS_TXT_FADE_."'>\r".$i18n['month'][$date['month']]."</td>\r
		</tr>\r
		</table>\r
		";
		
		if ( $WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
				$CurrentSet,
				$WebSiteObj,
				$ThemeDataObj,
				$CurrentDate,
				$date,
				$pv
				);
		}
		return $Content;
	}
}
?>