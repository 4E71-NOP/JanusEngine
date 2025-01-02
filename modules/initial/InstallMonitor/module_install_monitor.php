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
//	Module : InstallMonitor
// --------------------------------------------------------------------------------------------

class InstallMonitor {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$bts->mapSegmentLocation(__METHOD__, "InstallMonitor");
		
		$l = $CurrentSetObj->getDataEntry ('language');
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ));
		
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];

		// --------------------------------------------------------------------------------------------
		$Content = "<h1 style='text-align: center;'>".$bts->I18nTransObj->getI18nTransEntry('title')."</h1>\r";
		$CurrentTab = 1;
		$lt = 1;
		
		$T['ContentInfos']['EnableTabs']	= 0;
		$T['ContentInfos']['NbrOfTabs']		= 1;
		$T['ContentInfos']['TabBehavior']	= 1;
		$T['ContentInfos']['RenderMode']	= 1;
		$T['ContentInfos']['HighLightType']	= 0; // 1:ligne, 2:cellule
		$T['ContentInfos']['Height']		= 380;
		// $T['ContentInfos']['Width']			= $ThemeDataObj->getDefinitionValue('module_internal_width') -24;  
		$T['ContentInfos']['GroupName']		= "inst1";
		$T['ContentInfos']['CellName']		= "frame01";
		$T['ContentInfos']['DocumentName']	= "doc";
		
		$itd = $CurrentSetObj->getDataEntry('itd');
		if ( $bts->RequestDataObj->getRequestDataEntry('installToken') == $itd['installToken']['inst_nbr'] ) {

			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = "<b>".$bts->I18nTransObj->getI18nTransEntry('status')."</b>";
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<b>"
			."<span id='monitorStatusPending' style='display:block; visibility:visible'>".$bts->I18nTransObj->getI18nTransEntry('monitorStatusPending')."</span>"
			."<span id='monitorStatusRunning' style='display:none; visibility:hidden'>".$bts->I18nTransObj->getI18nTransEntry('monitorStatusRunning')."</span>"
			."</b>";
			$lt++;
			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SQL_query_count');
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<span id='monitor_SQL_query_count'></span>";
			$lt++;
			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('command_count');
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<span id='monitor_command_count'></span>";
			$lt++;
			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('start_date');
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<span id='monitor_start_date'></span>";
			$lt++;

			$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('end_date');
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<span id='monitor_end_date'></span>";
			$lt++;

			$T['Content'][$CurrentTab][$lt]['1']['cont'] = "<span style='display:none; visibility:hidden' id='monitorInactive'>".$bts->I18nTransObj->getI18nTransEntry('inactive');
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<span style='display:none; visibility:hidden' id='monitorInactiveTime'></span>";
			$lt++;
			
			$T['Content'][$CurrentTab][$lt]['1']['cont'] = "<span style='visibility:hidden' id='installStateEnded'>".$bts->I18nTransObj->getI18nTransEntry('installStateEnded')."</span>";
			$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<span style='visibility:hidden' id='installDuration'></span>";
			$lt++;


			$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfLines'] = $lt;	$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfCells'] = 2;	$T['ContentCfg']['tabs'][$CurrentTab]['TableCaptionPos'] = 1;
			
			$Content .= $bts->RenderTablesObj->render($infos, $T);
			
			$Content .= "
			<br>\r
			<div id='btnInstallReport' style='margin:auto; display:block; visibility:hidden;'>\r
			";

			$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
				$infos , 'button', 
				$bts->I18nTransObj->getI18nTransEntry('monitorBtnReport'), 192, 
				'goToInstallReport', 
				1, 1, 
				"li.makeFormInstallReport()" 
			);
			$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
			$Content .= "
			</div>\r
			<form id='formInstallReport' ACTION='install.php' method='post'>\r
			</form>\r
			</div>\r";

		}
	
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