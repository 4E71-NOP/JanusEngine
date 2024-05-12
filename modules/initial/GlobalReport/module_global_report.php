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

class ModuleGlobalReport {
	public function __construct(){}
	
	/**
	 * Return the rendered HTML bloc about log, SQL quesries, and other things.
	 * @param array $infos
	 * @return string
	 */
	public function render (&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$Content = "";
		if ( $CurrentSetObj->UserObj->hasPermission('admin_default_read_permission') === true ) {

// 			$l = $bts->CMObj->getLanguageListSubEntry($CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_lang'), 'lang_639_3');
			$l = $CurrentSetObj->getDataEntry ( 'language');
			
			$bts->LMObj->logDebug($bts->RequestDataObj->getRequestDataArray(),		"RequestDataObj");
			$bts->LMObj->logDebug($bts->SMObj->getSession(),						"SMObj->getSession()");
			$bts->LMObj->logDebug($CurrentSetObj->ServerInfosObj,					"CurrentSetObj->getInstanceOfServerInfosObj");
			$bts->LMObj->logDebug($CurrentSetObj->UserObj->getUser(),				"User");
			$bts->LMObj->logDebug($infos,											"infos");
			$bts->LMObj->logDebug($CurrentSetObj->getData(),						"CurrentSetObj->getData()");
			$bts->LMObj->logDebug($bts->CMObj->ConfigDump(),						"CMObj->ConfigDump()");
			$bts->LMObj->logDebug($bts->I18nTransObj->getI18nTrans(),				"I18nObj->getI18nTrans()");
			$bts->LMObj->logDebug($CurrentSetObj->ThemeDescriptorObj->getThemeDescriptor(),		"ThemeDescriptorObj->getThemeDescriptor()");
			$bts->LMObj->logDebug($CurrentSetObj->ThemeDataObj->getThemeData(),					"ThemeDataObj->getThemeData()");
			
			$T = array();
			$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ) );
			
			$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 25,8);
			$T['ContentInfos']['NbrOfTabs'] = 0;
			$dbgLvl = $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug');
			$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$dbgLvl=".$dbgLvl.", binary is:`".sprintf('%016b', $dbgLvl)."`") );
			$CurrentTab = 0;	
			if ( ($dbgLvl & 0b0000000000000001 ) != 0)	{ 
				$CurrentTab++;
				$bts->I18nTransObj->setI18nTransEntry("tabTxt".$CurrentTab , $bts->I18nTransObj->getI18nTransEntry('srcTabTxt1'));
				$tmp = $this->reportTab01($infos);	$T['Content'][$CurrentTab] = $tmp['content']; $T['ContentCfg']['tabs'][$CurrentTab] = $tmp['config']; $T['ContentInfos']['NbrOfTabs']++;
				$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : result binary is:`".sprintf('%016b', ($dbgLvl & 0b0000000000000001 ))."`; NbrOfTabs=".$T['ContentInfos']['NbrOfTabs']) );
			}
			
			if ( ($dbgLvl & 0b0000000000000010 ) != 0)	{ 
				$CurrentTab++;	
				$bts->I18nTransObj->setI18nTransEntry("tabTxt".$CurrentTab , $bts->I18nTransObj->getI18nTransEntry('srcTabTxt2'));
				$tmp = $this->reportTab02($infos);	$T['Content'][$CurrentTab] = $tmp['content']; $T['ContentCfg']['tabs'][$CurrentTab] = $tmp['config']; $T['ContentInfos']['NbrOfTabs']++;
				$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : result binary is:`".sprintf('%016b', ($dbgLvl & 0b0000000000000010 ))."`; NbrOfTabs=".$T['ContentInfos']['NbrOfTabs']) );
			}
			
			if ( ($dbgLvl & 0b0000000000000100 ) != 0)	{ 
				$CurrentTab++;	
				$bts->I18nTransObj->setI18nTransEntry("tabTxt".$CurrentTab , $bts->I18nTransObj->getI18nTransEntry('srcTabTxt3'));
				$tmp = $this->reportTab03($infos);	$T['Content'][$CurrentTab] = $tmp['content']; $T['ContentCfg']['tabs'][$CurrentTab] = $tmp['config']; $T['ContentInfos']['NbrOfTabs']++;
				$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : result binary is:`".sprintf('%016b', ($dbgLvl & 0b0000000000000100 ))."`; NbrOfTabs=".$T['ContentInfos']['NbrOfTabs']) );
			}
			
			if ( ($dbgLvl & 0b0000000000001000 ) != 0)	{ 
				$CurrentTab++;	
				$bts->I18nTransObj->setI18nTransEntry("tabTxt".$CurrentTab , $bts->I18nTransObj->getI18nTransEntry('srcTabTxt4'));
				$tmp = $this->reportTab04($infos);	$T['Content'][$CurrentTab] = $tmp['content']; $T['ContentCfg']['tabs'][$CurrentTab] = $tmp['config']; $T['ContentInfos']['NbrOfTabs']++;
				$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : result binary is:`".sprintf('%016b', ($dbgLvl & 0b0000000000001000 ))."`; NbrOfTabs=".$T['ContentInfos']['NbrOfTabs']) );
			}
			
			if ( ($dbgLvl & 0b0000000000010000 ) != 0)	{ 
				$CurrentTab++;	
				$bts->I18nTransObj->setI18nTransEntry("tabTxt".$CurrentTab , $bts->I18nTransObj->getI18nTransEntry('srcTabTxt5'));
				$tmp = $this->sqlReportTab($infos);	$T['Content'][$CurrentTab] = $tmp['content']; $T['ContentCfg']['tabs'][$CurrentTab] = $tmp['config']; $T['ContentInfos']['NbrOfTabs']++;
				$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : result binary is:`".sprintf('%016b', ($dbgLvl & 0b0000000000010000 ))."`; NbrOfTabs=".$T['ContentInfos']['NbrOfTabs']) );
			}
			
			if ( ($dbgLvl & 0b0000000000100000 ) != 0)	{ 
				$CurrentTab++;	
				$bts->I18nTransObj->setI18nTransEntry("tabTxt".$CurrentTab , $bts->I18nTransObj->getI18nTransEntry('srcTabTxt6'));
				$tmp = $this->reportTab08($infos);	$T['Content'][$CurrentTab] = $tmp['content']; $T['ContentCfg']['tabs'][$CurrentTab] = $tmp['config']; $T['ContentInfos']['NbrOfTabs']++;
				$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : result binary is:`".sprintf('%016b', ($dbgLvl & 0b0000000000100000 ))."`; NbrOfTabs=".$T['ContentInfos']['NbrOfTabs']) );
			}
			
			if ( ($dbgLvl & 0b0100000000000000 ) != 0)	{ 
				$CurrentTab++;	
				$bts->I18nTransObj->setI18nTransEntry("tabTxt".$CurrentTab , $bts->I18nTransObj->getI18nTransEntry('srcTabTxt7'));
				$tmp = $this->internalLogReport($infos);	$T['Content'][$CurrentTab] = $tmp['content']; $T['ContentCfg']['tabs'][$CurrentTab] = $tmp['config']; $T['ContentInfos']['NbrOfTabs']++;
				$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : result binary is:`".sprintf('%016b', ($dbgLvl & 0b0100000000000000 ))."`; NbrOfTabs=".$T['ContentInfos']['NbrOfTabs']) );
			}
			
			if ( ($dbgLvl & 0b1000000000000000 ) != 0)	{ 
				$CurrentTab++;	
				$bts->I18nTransObj->setI18nTransEntry("tabTxt".$CurrentTab , $bts->I18nTransObj->getI18nTransEntry('srcTabTxt8'));
				$tmp = $this->variablesReport($infos);	$T['Content'][$CurrentTab] = $tmp['content']; $T['ContentCfg']['tabs'][$CurrentTab] = $tmp['config']; $T['ContentInfos']['NbrOfTabs']++;
				$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : result binary is:`".sprintf('%016b', ($dbgLvl & 0b1000000000000000 ))."`; NbrOfTabs=".$T['ContentInfos']['NbrOfTabs']) );
			}
			
			$bts->RenderTablesObj->updateTabsTitle($T['ContentInfos'],$CurrentTab);

			$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
			$GeneratedScriptObj->insertString('JavaScript-File', $infos['module']['module_directory'].'lib_GlobalReport.js');
			$GeneratedScriptObj->insertString('JavaScript-Init', 'var gr = new GlobalReport();');
		}
	
			$T['ContentInfos']['GroupName']		= "AdmGr";
			$Content .= $bts->RenderTablesObj->render($infos, $T);
			return $Content;
	}
	
	/**
	 * Returns the general report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab01 (&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$Content = array();
		
		$Content['1']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l11');
		$Content['2']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l21');
		$Content['3']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l31');
		$Content['4']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l41');
		$Content['5']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l51');
		$Content['6']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l61');
		$Content['7']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l71');
		$Content['8']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l81');
		$Content['9']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l91');
		$Content['10']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l101');
		$Content['11']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l111');
		$Content['12']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l112');
		$Content['13']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t1l113');
		
		$memory_			= array();
		$memory_['peak']	= memory_get_peak_usage();
		$memory_['usage']	= memory_get_usage();
		
		$Content['1']['2']['cont']		= $_SERVER['HTTP_HOST'];														
		$Content['2']['2']['cont']		= round(($memory_['peak']/1024), 2) . $bts->I18nTransObj->getI18nTransEntry('Ko');
		$Content['3']['2']['cont']		= phpversion();																	
		$Content['4']['2']['cont']		= round(($memory_['usage']/1024), 2) . $bts->I18nTransObj->getI18nTransEntry('Ko');
		$Content['5']['2']['cont']		= $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug');	
		$Content['6']['2']['cont']		= get_include_path();															
		$Content['7']['2']['cont']		= getcwd();																		
		$Content['8']['2']['cont']		= getmyuid();																	
		$Content['9']['2']['cont']		= getmygid();																	
		$Content['10']['2']['cont']		= getmypid();																	
		$Content['11']['2']['cont']		= getenv("HTTP_USER_AGENT");													
		$Content['12']['2']['cont']		= get_current_user();															
		$Content['13']['2']['cont']		= $CurrentSetObj->ServerInfosObj->getServerInfosEntry('request_uri');
		;																												
		
		$config = $bts->RenderTablesObj->getDefaultTableConfig(13,2,2);
		// array(
		// 	"NbrOfLines" => 13,	
		// 	"NbrOfCells" => 2,
		// 	"TableCaptionPos" => 2,
		// );
		
		$package = array ("content" => $Content , "config" => $config);
		
		// --------------------------------------------------------------------------------------------
		$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('definition')."
			WHERE def_name = 'sl'
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
			$bts->SDDMObj->query("
			INSERT INTO ".$CurrentSetObj->SqlTableListObj->getSQLTableName('definition')." VALUES (
			'1',
			'sl',
			'0',
			'RW-1234-4321-8765-5678-9999'
			);");
		}
		
		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$pv['def_number'] = $dbp['def_number'];
			$pv['def_text'] = $dbp['def_text'];
		}
		
		$pv['pv_t'] = time() - (60*60*24*30);
		if ( $pv['def_number'] < $pv['pv_t'] ) {
			//	echo ("<br>...Mail...<br><br>");
			$pv['a']	= "license@rootwave.net";
			$pv['b']	= "[HYDR-L] - " . $pv['def_text'];
			$pv['c']	= "\r\n" . $_SERVER . "\r\n";
			$pv['d']	= "From: " . $_REQUEST['server_infos']['uid'] . "." . $_REQUEST['server_infos']['serverOwner'] . "@" . $_REQUEST['server_infos']['srv_hostname'] . "\r\nReply-To: none@example.com\r\nX-Mailer: PHP/" . phpversion();
			mail( $pv['a'], $pv['b'], $pv['c'], $pv['d'] );
			
			$pv['def_number'] = time();
		}
		$bts->SDDMObj->query("
		UPDATE ".$CurrentSetObj->SqlTableListObj->getSQLTableName('definition')." SET
		def_number = '".$pv['def_number']."'
		WHERE def_name = 'sl'
		;");
		
		return $package ;
	}

	/**
	 * Returns the Stats report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab02 (&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		// This will be implemented with "'" at the end of the string 
		// Reference URL : https://cdnjs.com/libraries/Chart.js
		// Since 4.0.0 we have to use the UMD version
		// $CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-ExternalRessource', "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js' integrity='sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==' crossorigin='anonymous");
		// $CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-ExternalRessource', "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js' integrity='sha512-O2fWHvFel3xjQSi9FyzKXWLTvnom+lOYR/AUEThL/fbP4hv1Lo5LCFCGuTXBRyKC4K4DJldg5kxptkgXAzUpvA==' crossorigin='anonymous' referrerpolicy='no-referrer");
		// $CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-ExternalRessource', "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js' integrity='sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==' crossorigin='anonymous' referrerpolicy='no-referrer");
		// $CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-ExternalRessource', "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js' integrity='sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==' crossorigin='anonymous' referrerpolicy='no-referrer");
		$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-ExternalRessource', "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js' integrity='sha512-CQBWl4fJHWbryGE+Pc7UAxWMUMNMWzWxF4SQo9CgkJIN1kx6djDQZjh3Y8SZ1d+6I+1zze6Z7kHXO7q3UyZAWw==' crossorigin='anonymous' referrerpolicy='no-referrer");

		$log = $bts->LMObj->getStatisticsLog();
		$stepOne = true;
		$timeStart = 0;
		
		$dataObjectChart1 = $this->initializeChartJsArray();
		$dataObjectChart2 = $this->initializeChartJsArray();
		$dataObjectChart3 = $this->initializeChartJsArray();
		$dataObjectChart2['data']['datasets'][0] = array('label' => '%Time','data' => array(),'fill' => 'false','borderColor' => '#FF0000');
		$dataObjectChart3['data']['datasets'][1] = array('label' => '%Time','data' => array(),'fill' => 'false','borderColor' => '#FF0000');
		
		$dataObjectChart1['data']['datasets'][0]['label'] = $bts->I18nTransObj->getI18nTransEntry('tGraphLabelM');
		$dataObjectChart2['data']['datasets'][0]['label'] = $bts->I18nTransObj->getI18nTransEntry('tGraphLabelT');
		$dataObjectChart3['data']['datasets'][0]['label'] = $bts->I18nTransObj->getI18nTransEntry('tGraphLabelM2');
		$dataObjectChart3['data']['datasets'][1]['label'] = $bts->I18nTransObj->getI18nTransEntry('tGraphLabelT2');
		
		$mainTimeEnd = $CurrentSetObj->getDataSubEntry('timeStat', 'end');
		
		foreach ( $log as $l ) {
			
			$curMemory = round(($l['memoire']/1024/1024),6);
			$highestMemory = round(memory_get_peak_usage()/1024/1024,6);
			
			$dataObjectChart1['data']['datasets'][0]['data'][] = $curMemory;
			$dataObjectChart1['data']['labels'][] = $l['context'];
			
			if ( $stepOne === true ) {
				$timeStart = $l['temps'];
				$stepOne = !$stepOne;
				$dataObjectChart2['data']['datasets'][0]['data'][] = 0;
				$mainTimeSpent = ($mainTimeEnd-$l['temps']);
			}
			else { 
				$dataObjectChart2['data']['datasets'][0]['data'][] = round(($l['temps'] - $timeStart),4);
			}
			$dataObjectChart2['data']['labels'][] = $l['context'];
			$dataObjectChart3['data']['datasets'][0]['data'][] = ($curMemory/$highestMemory)*100;
			$dataObjectChart3['data']['datasets'][1]['data'][] = round((($l['temps'] - $timeStart)/$mainTimeSpent)*100,4);
			$dataObjectChart3['data']['labels'][] = $l['context'];
			
		}
		
		$dataObjectEncoded1 = json_encode($dataObjectChart1,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
		$dataObjectEncoded2 = json_encode($dataObjectChart2,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
		$dataObjectEncoded3 = json_encode($dataObjectChart3,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );

		$javaScriptForChartJs = "
var Chart01 = new Chart(document.getElementById('statChart1'), ".$dataObjectEncoded1 ."\r);\r\r
var Chart02 = new Chart(document.getElementById('statChart2'), ".$dataObjectEncoded2 ."\r);\r\r
var Chart03 = new Chart(document.getElementById('statChart3'), ".$dataObjectEncoded3 ."\r);\r\r
";
		
		$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-Data',$javaScriptForChartJs."\r");
		$Content = array();
		$Content['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('tMemoryMaxMemUsed')." : ". $highestMemory . $bts->I18nTransObj->getI18nTransEntry('tMemoryMb');
		$Content['2']['1']['cont'] = "<canvas id='statChart1' style='width:512px; height:256px; background-color: #FFFFFF; margin:5px;'></canvas>\r";
		$Content['3']['1']['cont'] = "<canvas id='statChart2' style='width:512px; height:256px; background-color: #FFFFFF; margin:5px;'></canvas>\r";
		$Content['4']['1']['cont'] = "<canvas id='statChart3' style='width:512px; height:256px; background-color: #FFFFFF; margin:5px;'></canvas>\r";
		
		$config = $bts->RenderTablesObj->getDefaultTableConfig(4,1,0);
		// array(
		// 	"NbrOfLines" => 4,
		// 	"NbrOfCells" => 1,
		// 	"TableCaptionPos" => 0,
		// 	"HighLightType" => 0,
				
		// );
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
}

	private function initializeChartJsArray () {
		return array(
				'type' => 'line',
				'data' => array(
						'labels' => array(),
						'datasets' => array(
								'0' => array(
										'label' => 'Label',
										'data' => array(),
										'fill' => 'false',
										'borderColor' => '#80a0C0'
								),
						)
				),
		);
	}

	
	/**
	 * Returns the Stats report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab03 (&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];
		$Content = array();
		
		$Content['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l11');	$Content['1']['1']['class'] = $Block."_tb3";	$Content['1']['1']['1']['style'] = "text-align: center;";
		$Content['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l12');	$Content['1']['2']['class'] = $Block."_tb3";
		$Content['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l13');	$Content['1']['3']['class'] = $Block."_tb3";	$Content['1']['1']['3']['style'] = "text-align: center;";
		$Content['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l14');	$Content['1']['4']['class'] = $Block."_tb3";	$Content['1']['1']['4']['style'] = "text-align: center;";
		$Content['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l15');	$Content['1']['5']['class'] = $Block."_tb3";	$Content['1']['1']['5']['style'] = "text-align: center;";
		$Content['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l16');	$Content['1']['6']['class'] = $Block."_tb3";
		
		$sg['MemoireMax'] = 0;
		$sg['MemoireMin'] = 1000;
		$sg['TempsMin'] = $bts->TimeObj->getMicrotime(); 
		$sg['TempsMax'] = 0;
		
		$TableStats = $bts->LMObj->getStatisticsLog();
		reset ( $TableStats );
		
		foreach ( $TableStats as &$A ) {
			$A['SgMem'] = round(( $A['memoire'] / 1024 ), 2 );
			if ( $A['SgMem'] > $sg['MemoireMax'] )	{ $sg['MemoireMax'] = $A['SgMem']; }
			if ( $A['SgMem'] < $sg['MemoireMin'] )	{ $sg['MemoireMin'] = $A['SgMem']; }
			if ( $A['temps'] > $sg['TempsMax'] )	{ $sg['TempsMax'] = $A['temps']; }
			if ( $A['temps'] < $sg['TempsMin'] )	{ $sg['TempsMin'] = $A['temps']; }
		}
		$i = 2;
		foreach ( $TableStats as &$A ) {
			$pv['mem_b4'] =0;
			if ( $i == 2 ) { $sg['tempsAV'] = $A['temps']; }
			$A['TempsPerf'] =  round ( ($A['temps'] - $sg['tempsAV']), 4 );
			$A['TempsCheckpoint'] =  round ($A['temps'] - $sg['TempsMin'], 4 );
			$sg['tempsAV'] = $A['temps'];
			
			$A['MemoireSegment'] = ( $A['memoire'] - $pv['mem_b4'] );
			$pv['mem_b4'] = $A['memoire'];
			
			$Content[$i]['1']['cont'] = $A['position'];																$Content[$i]['1']['tc'] = 1;	$Content[$i]['1']['style'] = "text-align: center;";
			$Content[$i]['2']['cont'] = $A['routine'];																$Content[$i]['2']['tc'] = 1;
			$Content[$i]['3']['cont'] = $A['TempsPerf'];															$Content[$i]['3']['tc'] = 1;	$Content[$i]['3']['style'] = "text-align: center;";
			$Content[$i]['4']['cont'] = $bts->StringFormatObj->makeSizeHumanFriendly($infos, $A['MemoireSegment'] );	$Content[$i]['4']['tc'] = 1;	$Content[$i]['4']['style'] = "text-align: center;";
			$Content[$i]['5']['cont'] = $A['SQL_queries'];															$Content[$i]['5']['tc'] = 1;	$Content[$i]['5']['style'] = "text-align: center;";
			$Content[$i]['6']['cont'] = $A['context'];																$Content[$i]['6']['tc'] = 1;
			
			$i++;
		}
		
		$config = $bts->RenderTablesObj->getDefaultTableConfig(($i-1),6,1);
		// array(
		// 		"NbrOfLines" => $i - 1,
		// 		"NbrOfCells" => 6,
		// 		"TableCaptionPos" => 1,
		// );
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}
	
	
	/**
	 * Returns the log (in DB) report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab04 (&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = array();
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];
		$Content = array();
		
		$Content['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l11');	$Content['1']['1']['class'] = $Block."_tb3";	$Content['1']['1']['style'] = "text-align: center;";
		$Content['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l12');	$Content['1']['2']['class'] = $Block."_tb3";	$Content['1']['2']['style'] = "text-align: center;";
		$Content['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l13');	$Content['1']['3']['class'] = $Block."_tb3";
		$Content['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l14');	$Content['1']['4']['class'] = $Block."_tb3";	$Content['1']['4']['style'] = "text-align: center;";
		$Content['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l15');	$Content['1']['5']['class'] = $Block."_tb3";	$Content['1']['5']['style'] = "text-align: center;";
		$Content['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l16');	$Content['1']['6']['class'] = $Block."_tb3";	$Content['1']['6']['style'] = "text-align: center;";
		$Content['1']['7']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3l17');	$Content['1']['7']['class'] = $Block."_tb3";
		
		$tabSignal = array(
		0 => "<span class='".$Block."_erreur'>ERR</span>",
		1 => "<span class='".$Block."_ok'>OK</span>",
		2 => "<span class='".$Block."_warning'>WARN</span>",
		3 => "<span class='".$Block."_ok'>INFO</span>",
		4 => "<span class='".$Block."_ok'>AUTRE</span>",
		);
		
		$pv['log_date'] = time();
		$dbquery = $bts->SDDMObj->query("
			SELECT * 
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('log')."
			WHERE fk_ws_id = '".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')."'
			ORDER BY log_id DESC
			LIMIT 15
			;");
		
		$i = 2;
		while ($dbp =  $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$pv['log_action_longeur'] = strlen($dbp['log_action']);
			switch (TRUE) {
				case ($pv['log_action_longeur'] < 128 && $pv['log_action_longeur'] > 64):	$dbp['log_action'] = substr ($dbp['log_action'],0,59) . " [...] ";		break;
				case ($pv['log_action_longeur'] > 128):									$dbp['log_action'] = substr ($dbp['log_action'],0,59) . " [...] " . substr ($dbp['log_action'],($pv['log_action_longeur'] - 64) ,$pv['log_action_longeur'] );		break;
			}
			$Content[$i]['1']['cont'] = $dbp['log_id'];								$Content[$i]['1']['tc'] = 1;	$Content[$i]['1']['style'] = "text-align: center;";
			$Content[$i]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['log_date'] );	$Content[$i]['2']['tc'] = 1;	$Content[$i]['2']['style'] = "text-align: center;";
			$Content[$i]['3']['cont'] = $dbp['log_initiator'];						$Content[$i]['3']['tc'] = 2;
			$Content[$i]['4']['cont'] = $dbp['log_action'];							$Content[$i]['4']['tc'] = 1;	$Content[$i]['4']['style'] = "text-align: center;";
			$Content[$i]['5']['cont'] = $tabSignal[$dbp['log_signal']];												$Content[$i]['5']['style'] = "text-align: center;";
			$Content[$i]['6']['cont'] = $dbp['log_msgid'];							$Content[$i]['6']['tc'] = 1;	$Content[$i]['6']['style'] = "text-align: center;";
			$Content[$i]['7']['cont'] = $dbp['log_contenu'];							$Content[$i]['7']['tc'] = 1;
			$i++;
		}
		
		$config = $bts->RenderTablesObj->getDefaultTableConfig(($i-1),7,1);
		// array(
		// 		"NbrOfLines" => $i - 1,
		// 		"NbrOfCells" => 7,
		// 		"TableCaptionPos" => 1,
		// );
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}
	
	private function reportTab05 (&$infos){
		$Content = array();
		return $Content;
	}
	
	private function reportTab06 (&$infos){
		$Content = array();
		return $Content;
	}
	
	
	/**
	 * Returns the SQL query report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function sqlReportTab (&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = array();
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];
		
		$Content['1']['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('t6l11');	$Content['1']['1']['style'] = "text-align: center;";  
		$Content['1']['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('t6l12');
		$Content['1']['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('t6l13');	$Content['1']['3']['style'] = "text-align: center;";  
		$Content['1']['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('t6l14');
		
		$i = 2;
		foreach ( $bts->LMObj->getSqlQueryLog() as $A ) {
			$query = $bts->StringFormatObj->ConvertToHtml($A['requete']);
			
			$queryTime = round( ( $A['temps_fin'] - $A['temps_debut'] ) , 4);
			
			$Content[$i]['1']['cont']	= $A['nbr'];		$Content[$i]['1']['style']	= "text-align: center;";
			$Content[$i]['2']['cont']	= $A['nom'];		$Content[$i]['2']['style']	= "font-size:75%;";
			$Content[$i]['3']['cont']	= $queryTime;		$Content[$i]['3']['style']	= "text-align: center;font-size:75%;";
			$Content[$i]['4']['cont']	= $query;			$Content[$i]['4']['style']	= "font-size:60%;";
			if ( isset ($A['signal']) && $A['signal'] != "OK")	{
				// 		outil_debug($A, "A");
				$Content[$i]['4']['cont']	.= "<br>\rErr N°=" . $A['err_no']." : ".$A['err_msg'];
				$Content[$i]['4']['class']	= $Block."_warning";
				$Content[$i]['4']['style']	.= " font-weight: bold;";
			}
			$i++;
		}
		$config = $bts->RenderTablesObj->getDefaultTableConfig(($i-1),4,1);
		// $config = array(
		// 		"NbrOfLines" => $i - 1,
		// 		"NbrOfCells" => 4,
		// 		"TableCaptionPos" => 1,
		// );
		
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}
	
	private function reportTab08 (&$infos){
		$Content = array();
		return $Content;
	}
	
	/**
	 * Returns the internal report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */private function internalLogReport (&$infos){
	 	$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = array();
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];
		
		$Content['1']['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('t9l11');	$Content['1']['1']['style'] = "text-align: center;";
		$Content['1']['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('t9l12');	
		$Content['1']['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('t9l13');	$Content['1']['3']['style'] = "text-align: center;";
		
		$i = 2;
		foreach ( $bts->LMObj->getMsgLog() as $A ) {
			$Content[$i]['1']['cont'] = $A['nbr'];		
			$Content[$i]['2']['cont'] = $A['origin'];	$Content[$i]['2']['style'] = "font-size:60%;";
			$Content[$i]['3']['cont'] = $A['message'];	$Content[$i]['3']['style'] = "font-size:60%;";
			$i++;
		}
		
		$config = $bts->RenderTablesObj->getDefaultTableConfig(($i-1),3,1);
		// $config = array(
		// 		"NbrOfLines" => $i - 1,
		// 		"NbrOfCells" => 3,
		// 		"TableCaptionPos" => 1,
		// );
		
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}
	
	/**
	 * Returns the Debug report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function variablesReport (&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = array();
		$Content['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t10l11');
		$Content['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t10l12');
		
		$i = 2;
		
		foreach ( $bts->LMObj->getDebugLog() as $A ) {
			$Content[$i]['1']['cont'] = $A['name'];
			$Content[$i]['2']['cont'] = $bts->StringFormatObj->print_r_html($A['data']);
			$Content[$i]['1']['style'] = "vertical-align:top;font-size:75%;";
			$Content[$i]['2']['style'] = "font-size:60%;";
			$i++;
		}
		
		$config = array(
				"NbrOfLines" => $i - 1,
				"NbrOfCells" => 2,
				"TableCaptionPos" => 1,
		);
		
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}
}
