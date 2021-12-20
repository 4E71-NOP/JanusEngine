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
//	Module : InstallMonitor
// --------------------------------------------------------------------------------------------

class InstallMonitor {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		

		$localisation = " / InstallMonitor";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("InstallMonitor");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("InstallMonitor");
		
		$l = $CurrentSetObj->getDataEntry ('language');
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ));
		
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];

		// --------------------------------------------------------------------------------------------
		$$Content .= "<h1 style='text-align: center;'>".$bts->I18nTransObj->getI18nTransEntry('title')."</h1>\r";
		$CurrentTab = 1;
		$lt = 1;
		
		$T['ContentInfos']['EnableTabs']	= 0;
		$T['ContentInfos']['NbrOfTabs']		= 1;
		$T['ContentInfos']['TabBehavior']	= 1;
		$T['ContentInfos']['RenderMode']	= 1;
		$T['ContentInfos']['HighLightType']	= 0; // 1:ligne, 2:cellule
		$T['ContentInfos']['Height']		= 380;
		// $T['ContentInfos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_internal_width') -24;  
		$T['ContentInfos']['GroupName']		= "inst1";
		$T['ContentInfos']['CellName']		= "frame01";
		$T['ContentInfos']['DocumentName']	= "doc";
		
		
		//	Choice matrix 
		//	session				Finished?
		// 0 Wut!?				not finished
		// 1 SessionID ok		not finished
		// 2 SessionID nok		finished
		// 3 SessionID ok		finished
		$itd = $CurrentSetObj->getDataEntry('itd');
		if ( $bts->RequestDataObj->getRequestDataEntry('SessionID') == $itd['SessionID']['inst_nbr'] ) {
			$score = 0;
			if ( $bts->RequestDataObj->getRequestDataEntry('SessionID') == $itd['SessionID']['inst_nbr'] ) { $score +=1; }
			if ( $itd['end_date']['inst_nbr'] > 0 ) { $score +=2; }
			
			switch ($score) {
				case 0: 	
				case 2: 
					$status = "?????";
					break;
				case 1: 
					$time = (time() - $itd['last_activity']['inst_nbr']);
					if ( $time > 60 ) { $status = "<span class='".$Block."_error'>" .$bts->I18nTransObj->getI18nTransEntry('inactive') . ": " . $time . "s.</span>"; }
					else { $status = $bts->I18nTransObj->getI18nTransEntry('installState1'); }
					break;	
				case 3: $status = $bts->I18nTransObj->getI18nTransEntry('installState2');	break;
			}
			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = "<b>".$bts->I18nTransObj->getI18nTransEntry('status')."</b>";				
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<b>".$status."</b>";												
			$lt++;
			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SQL_query_count');					
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = $itd['SQL_query_count']['inst_nbr'];								
			$lt++;
			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('command_count');						
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = $itd['command_count']['inst_nbr'];								
			$lt++;
			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('start_date');							
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->TimeObj->timestampToDate($itd['start_date']['inst_nbr']);	
			
			$isInactive = time() - $itd['last_activity']['inst_nbr'];
			if ( $isInactive > 10 ) {
				$lt++;
				$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('inactive');		$T['Content'][$CurrentTab][$lt]['1']['class'] = $Block."_error";
				$T['Content'][$CurrentTab][$lt]['2']['cont'] = $isInactive." s";										$T['Content'][$CurrentTab][$lt]['2']['class'] = $Block."_error"; 
			}
			
			if ($itd['end_date']['inst_nbr'] != 0 ) {
				$lt++;
				$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('end_date');						
				$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->TimeObj->timestampToDate($itd['end_date']['inst_nbr']);	
			}
			
			$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfLines'] = $lt;	$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfCells'] = 2;	$T['ContentCfg']['tabs'][$CurrentTab]['TableCaptionPos'] = 1;
			
			$Content .= $bts->RenderTablesObj->render($infos, $T)."</div>\r";
		}
	
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$localisation,
			);
		}
		return $Content;
	}
}
?>