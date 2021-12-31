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
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$l = $CurrentSetObj->getDataEntry ('language');
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$Content = "";
		if ( $CurrentSetObj->getInstanceOfUserObj()->hasPermission('group_default_read_permission') === true ) {
			$localisation = " / ModuleCalendar";
			$bts->MapperObj->AddAnotherLevel($localisation );
			$bts->LMObj->logCheckpoint("ModuleCalendar");
			$bts->MapperObj->RemoveThisLevel($localisation );
			$bts->MapperObj->setSqlApplicant("ModuleCalendar");
			
	
			$tabDay = array(
				1 => "monday",
				2 => "tuesday",
				3 => "wetnesday",
				4 => "thurday",
				5 => "friday",
				6 => "saturday",
				7 => "sunday",
			);
			$tabMonth = array (
				1 => "january",
				2 => "february",
				3 => "march",
				4 => "april",
				5 => "may",
				6 => "june",
				7 => "july",
				8 => "august",
				9 => "september",
				10 => "october",
				11 => "november",
				12 => "december",
				
			);
			
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
			$pv['table_margintop'] = floor (( $ThemeDataObj->getThemeDataEntry('theme_module_internal_height') - $pv['table_height'] ) /2);
			$pv['table_marginright'] = floor (( $ThemeDataObj->getThemeDataEntry('theme_module_internal_width') - $pv['table_width'] ) /2);
			
			$Content .= "
			<table class='".$Block._CLASS_TABLE_STD_."' style='height: ".$pv['table_height']."px; margin-top: ".$pv['table_margintop']."px;'>
							
			<tr>\r
			<td style='font-size:125%'>\r".$bts->I18nTransObj->getI18nTransEntry($tabDay[$date['day']])."</td>\r
			<td rowspan='2' style='font-size: ".( $pv['table_height'] - 8 )."px; font-weight: bold; vertical-align: middle;'>\r".$date['number']."</td>\r
			</tr>\r
			<tr>\r
			<td style='font-size:150%' class='".$Block._CLASS_TXT_FADE_."'>\r".$bts->I18nTransObj->getI18nTransEntry($tabMonth[$date['month']])."</td>\r
			</tr>\r
			</table>\r
			";
		}
		
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