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

class ModuleGlobalReport {
	public function __construct(){}
	
	/**
	 * Return the rendered HTML bloc about log, SQL quesries, and other things.
	 * @param array $infos
	 * @return string
	 */
	public function render (&$infos){
		$ClassLoaderObj = ClassLoader::getInstance();
		
		$CMObj				= ConfigurationManagement::getInstance();
		$LMObj				= LogManagement::getInstance();
		$RenderLayoutObj	= RenderLayout::getInstance();
		$RequestDataObj		= RequestData::getInstance();
		$I18nObj			= I18n::getInstance();
		$SMObj				= SessionManagement::getInstance($CMObj);
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$ThemeDescriptorObj = $CurrentSetObj->getInstanceOfThemeDescriptorObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('sw_lang'), 'langue_639_3');
		
		$LMObj->logDebug($RequestDataObj->getRequestDataArray(),	"RequestDataObj");
		$LMObj->logDebug($infos,									"infos");
		$LMObj->logDebug($CurrentSetObj->getData(),					"CurrentSetObj->getData()");
		$LMObj->logDebug($CMObj->ConfigDump(),						"CMObj->ConfigDump()");
		$LMObj->logDebug($SMObj->getSession(),						"SMObj->getSession()");
		$LMObj->logDebug($I18nObj->getI18n(),						"I18nObj->getI18n()");
		$LMObj->logDebug($ThemeDescriptorObj->getThemeDescriptor(),	"ThemeDescriptorObj->getThemeDescriptor()");
		$LMObj->logDebug($ThemeDataObj->getThemeData(),				"ThemeDataObj->getThemeData()");
		$LMObj->logDebug($RenderLayoutObj->getLayout(),				"RenderLayoutObj->getLayout()");
		
		
		$T = array();
		include ($infos['module']['module_directory']."/i18n/".$l.".php");
		$I18nObj->apply($tabI18n);
		
		
		$ClassLoaderObj->provisionClass('RenderTables');
		$RenderTablesObj = RenderTables::getInstance();
		
		$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 20,8);
		
		$Content = "";
		
		$CurrentTab = 1;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 1 )	{ $tmp = $this->reportTab01($infos);	$T['AD'][$CurrentTab] = $tmp['content']; $T['ADC']['onglet'][$CurrentTab] = $tmp['config']; }	else { $T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 0; $T['AD'][$CurrentTab]['1']['1']['cont'] = $I18nObj->getI18nEntry('defaut'); }
		$CurrentTab = 2;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 2 )	{ $tmp = $this->reportTab02($infos);	$T['AD'][$CurrentTab] = $tmp['content']; $T['ADC']['onglet'][$CurrentTab] = $tmp['config']; }	else { $T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 0; $T['AD'][$CurrentTab]['1']['1']['cont'] = $I18nObj->getI18nEntry('defaut'); }
		$CurrentTab = 3;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 3 )	{ $tmp = $this->reportTab03($infos);	$T['AD'][$CurrentTab] = $tmp['content']; $T['ADC']['onglet'][$CurrentTab] = $tmp['config']; }	else { $T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 0; $T['AD'][$CurrentTab]['1']['1']['cont'] = $I18nObj->getI18nEntry('defaut'); }
		$CurrentTab = 4;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 4 )	{ $tmp = $this->reportTab04($infos);	$T['AD'][$CurrentTab] = $tmp['content']; $T['ADC']['onglet'][$CurrentTab] = $tmp['config']; }	else { $T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 0; $T['AD'][$CurrentTab]['1']['1']['cont'] = $I18nObj->getI18nEntry('defaut'); }
		$CurrentTab = 5;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 7 )	{ $tmp = $this->reportTab07($infos);	$T['AD'][$CurrentTab] = $tmp['content']; $T['ADC']['onglet'][$CurrentTab] = $tmp['config']; }	else { $T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 0; $T['AD'][$CurrentTab]['1']['1']['cont'] = $I18nObj->getI18nEntry('defaut'); }
		$CurrentTab = 6;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 8 )	{ $tmp = $this->reportTab08($infos);	$T['AD'][$CurrentTab] = $tmp['content']; $T['ADC']['onglet'][$CurrentTab] = $tmp['config']; }	else { $T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 0; $T['AD'][$CurrentTab]['1']['1']['cont'] = $I18nObj->getI18nEntry('defaut'); }
		$CurrentTab = 7;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 9 )	{ $tmp = $this->reportTab09($infos);	$T['AD'][$CurrentTab] = $tmp['content']; $T['ADC']['onglet'][$CurrentTab] = $tmp['config']; }	else { $T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 0; $T['AD'][$CurrentTab]['1']['1']['cont'] = $I18nObj->getI18nEntry('defaut'); }
		$CurrentTab = 8;	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') >= 10 )	{ $tmp = $this->reportTab10($infos);	$T['AD'][$CurrentTab] = $tmp['content']; $T['ADC']['onglet'][$CurrentTab] = $tmp['config']; }	else { $T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = 1;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 1;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 0; $T['AD'][$CurrentTab]['1']['1']['cont'] = $I18nObj->getI18nEntry('defaut'); }
		
		$tabDbgLvl = array(
			1 => 1,			2 => 2,			3 => 3,
			4 => 4,			5 => 4,			6 => 4,
			7 => 5,			8 => 6,			9 => 7,
			10=> 8
		);
		
		$T['tab_infos']['NbrOfTabs']		= $tabDbgLvl[$WebSiteObj->getWebSiteEntry('sw_info_debug')];
		$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_nom'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-92;
		$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
		$T['tab_infos']['GroupName']		= "gr";
		$Content .= $RenderTablesObj->render($infos, $T);
		return $Content;
	}
	
	/**
	 * Returns the general report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab01 (&$infos){
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();

		$I18nObj = I18n::getInstance();
		$Content = array();
		
		$Content['1']['1']['cont']		= $I18nObj->getI18nEntry('t1l11');
		$Content['2']['1']['cont']		= $I18nObj->getI18nEntry('t1l21');
		$Content['3']['1']['cont']		= $I18nObj->getI18nEntry('t1l31');
		$Content['4']['1']['cont']		= $I18nObj->getI18nEntry('t1l41');
		$Content['5']['1']['cont']		= $I18nObj->getI18nEntry('t1l51');
		$Content['6']['1']['cont']		= $I18nObj->getI18nEntry('t1l61');
		$Content['7']['1']['cont']		= $I18nObj->getI18nEntry('t1l71');
		$Content['8']['1']['cont']		= $I18nObj->getI18nEntry('t1l81');
		$Content['9']['1']['cont']		= $I18nObj->getI18nEntry('t1l91');
		$Content['10']['1']['cont']		= $I18nObj->getI18nEntry('t1l101');
		$Content['11']['1']['cont']		= $I18nObj->getI18nEntry('t1l111');
		$Content['12']['1']['cont']		= $I18nObj->getI18nEntry('t1l121');
		
		$memory_			= array();
		$memory_['peak']	= memory_get_peak_usage();
		$memory_['usage']	= memory_get_usage();
		
		$Content['1']['2']['cont']		= $_SERVER['HTTP_HOST'];													$Content['1']['2']['class']		= $infos['block']."_tb4";
		$Content['2']['2']['cont']		= round(($memory_['peak']/1024), 2) . $I18nObj->getI18nEntry('Ko');			$Content['2']['2']['class']		= $infos['block']."_tb4";
		$Content['3']['2']['cont']		= phpversion();																$Content['3']['2']['class']		= $infos['block']."_tb4";
		$Content['4']['2']['cont']		= round(($memory_['usage']/1024), 2) . $I18nObj->getI18nEntry('Ko');		$Content['4']['2']['class']		= $infos['block']."_tb4";
		$Content['5']['2']['cont']		= $WebSiteObj->getWebSiteEntry('sw_info_debug');							$Content['5']['2']['tc']		= 1;
		$Content['6']['2']['cont']		= get_include_path();														$Content['6']['2']['tc']		= 1;
		$Content['7']['2']['cont']		= getcwd();																	$Content['7']['2']['tc']		= 1;
		$Content['8']['2']['cont']		= getmyuid();																$Content['8']['2']['tc']		= 1;
		$Content['9']['2']['cont']		= getmygid();																$Content['9']['2']['tc']		= 1;
		$Content['10']['2']['cont']		= getmypid();																$Content['10']['2']['tc']		= 1;
		$Content['11']['2']['cont']		= getenv("HTTP_USER_AGENT");												$Content['11']['2']['tc']		= 1;
		$Content['12']['2']['cont']		= get_current_user();														$Content['12']['2']['tc']		= 1;
		
		$config = array(
			"nbr_ligne" => 12,	
			"nbr_cellule" => 2,
			"legende" => 2,
		);
		
		$package = array ("content" => $Content , "config" => $config);
		
		// --------------------------------------------------------------------------------------------
		$dbquery = $SDDMObj->query("
			SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('pv')."
			WHERE pv_nom = 'sl'
			;");
		if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
			$SDDMObj->query("
			INSERT INTO ".$SqlTableListObj->getSQLTableName('pv')." VALUES (
			'sl',
			'0',
			'RW-1234-4321-8765-5678-9999'
			);");
		}
		
		while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
			$pv['pv_nombre'] = $dbp['pv_nombre'];
			$pv['pv_l'] = $dbp['pv_text'];
		}
		
		$pv['pv_t'] = mktime() - (60*60*24*30);
		if ( $pv['pv_nombre'] < $pv['pv_t'] ) {
			//	echo ("<br>...Mail...<br><br>");
			$pv['a']	= "license@rootwave.net";
			$pv['b']	= "[RW-L] - " . $pv['pv_l'];
			$pv['c']	= "\r\n" . $_SERVER . "\r\n";
			$pv['d']	= "From: " . $_REQUEST['server_infos']['uid'] . "." . $_REQUEST['server_infos']['proprietaire'] . "@" . $_REQUEST['server_infos']['srv_hostname'] . "\r\nReply-To: none@example.com\r\nX-Mailer: PHP/" . phpversion();
			mail( $pv['a'], $pv['b'], $pv['c'], $pv['d'] );
			
			$pv['pv_nombre'] = mktime();
		}
		$SDDMObj->query("
		UPDATE ".$SqlTableListObj->getSQLTableName('pv')." SET
		pv_nombre = '".$pv['pv_nombre']."'
		WHERE pv_nom = 'sl'
		;");
		
		return $package ;
	}

	/**
	 * Returns the Stats report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab02 (&$infos){
		$Content = "image";
		$config = array(
				"nbr_ligne" => 1,
				"nbr_cellule" => 1,
				"legende" => 0,
		);
		
		$package = array ("content" => $Content , "config" => $config);
		
	}
	
	/**
	 * Returns the Stats report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab03 (&$infos){
		$LMObj = LogManagement::getInstance();
		$TimeObj = Time::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$I18nObj = I18n::getInstance();
		$Content = array();
		$block = $ThemeDataObj->getThemeName().$infos['block'];
		$Content = array();
		
		$Content['1']['1']['cont'] = $I18nObj->getI18nEntry('t2l11');	$Content['1']['1']['class'] = $block."_tb3";	$Content['1']['1']['1']['style'] = "text-align: center;";
		$Content['1']['2']['cont'] = $I18nObj->getI18nEntry('t2l12');	$Content['1']['2']['class'] = $block."_tb3";
		$Content['1']['3']['cont'] = $I18nObj->getI18nEntry('t2l13');	$Content['1']['3']['class'] = $block."_tb3";	$Content['1']['1']['3']['style'] = "text-align: center;";
		$Content['1']['4']['cont'] = $I18nObj->getI18nEntry('t2l14');	$Content['1']['4']['class'] = $block."_tb3";	$Content['1']['1']['4']['style'] = "text-align: center;";
		$Content['1']['5']['cont'] = $I18nObj->getI18nEntry('t2l15');	$Content['1']['5']['class'] = $block."_tb3";	$Content['1']['1']['5']['style'] = "text-align: center;";
		$Content['1']['6']['cont'] = $I18nObj->getI18nEntry('t2l16');	$Content['1']['6']['class'] = $block."_tb3";
		
		$sg['MemoireMax'] = 0;
		$sg['MemoireMin'] = 1000;
		$sg['TempsMin'] = $TimeObj->microtime_chrono(); 
		$sg['TempsMax'] = 0;
		
		$TableStats = $LMObj->getStatisticsLog();
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
// 			$A['memX'] = floor (( ($pv['i']-2) * $sg['GraphPasX']) + $sg['bordG'] );
// 			$A['memY'] = floor (($sg['y']-$sg['bordB']) - (($A['SgMem']-$sg['MemoireMin'])/$sg['memcoef']));
			
			if ( $i == 2 ) { $sg['tempsAV'] = $A['temps']; }
			$A['TempsPerf'] =  round ( ($A['temps'] - $sg['tempsAV']), 4 );
			$A['TempsCheckpoint'] =  round ($A['temps'] - $sg['TempsMin'], 4 );
// 			$A['tempsX'] = floor ((( ($pv['i']-2) * $sg['GraphPasX']) + $sg['bordG']) - (($sg['GraphPasX']*$sg['barre_coef'])/2) );
// 			$A['tempsY'] = floor (($sg['y']-$sg['bordB']) - (($A['temps']-$sg['tempsAV'])/$sg['tempscoef']));
			$sg['tempsAV'] = $A['temps'];
			
			$A['MemoireSegment'] = ( $A['memoire'] - $pv['mem_b4'] );
			$pv['mem_b4'] = $A['memoire'];
			
			$Content[$i]['1']['cont'] = $A['position'];										$Content[$i]['1']['tc'] = 1;	$Content[$i]['1']['style'] = "text-align: center;";
			$Content[$i]['2']['cont'] = $A['routine'];										$Content[$i]['2']['tc'] = 1;
			$Content[$i]['3']['cont'] = $A['TempsPerf'];									$Content[$i]['3']['tc'] = 1;	$Content[$i]['3']['style'] = "text-align: center;";
			$Content[$i]['4']['cont'] = $this->convertSize($infos, $A['MemoireSegment'] );	$Content[$i]['4']['tc'] = 1;	$Content[$i]['4']['style'] = "text-align: center;";
			$Content[$i]['5']['cont'] = $A['SQL_queries'];									$Content[$i]['5']['tc'] = 1;	$Content[$i]['5']['style'] = "text-align: center;";
			$Content[$i]['6']['cont'] = $A['context'];										$Content[$i]['6']['tc'] = 1;
			
			$i++;
		}
		
		$config = array(
				"nbr_ligne" => $i - 1,
				"nbr_cellule" => 6,
				"legende" => 1,
		);
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}
	
	
	/**
	 * Returns the log (in DB) report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab04 (&$infos){
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$I18nObj = I18n::getInstance();
		$Content = array();
		$block = $ThemeDataObj->getThemeName().$infos['block'];
		$Content = array();
		
		$Content['1']['1']['cont'] = $I18nObj->getI18nEntry('t3l11');	$Content['1']['1']['class'] = $block."_tb3";	$Content['1']['1']['style'] = "text-align: center;";
		$Content['1']['2']['cont'] = $I18nObj->getI18nEntry('t3l12');	$Content['1']['2']['class'] = $block."_tb3";	$Content['1']['2']['style'] = "text-align: center;";
		$Content['1']['3']['cont'] = $I18nObj->getI18nEntry('t3l13');	$Content['1']['3']['class'] = $block."_tb3";
		$Content['1']['4']['cont'] = $I18nObj->getI18nEntry('t3l14');	$Content['1']['4']['class'] = $block."_tb3";	$Content['1']['4']['style'] = "text-align: center;";
		$Content['1']['5']['cont'] = $I18nObj->getI18nEntry('t3l15');	$Content['1']['5']['class'] = $block."_tb3";	$Content['1']['5']['style'] = "text-align: center;";
		$Content['1']['6']['cont'] = $I18nObj->getI18nEntry('t3l16');	$Content['1']['6']['class'] = $block."_tb3";	$Content['1']['6']['style'] = "text-align: center;";
		$Content['1']['7']['cont'] = $I18nObj->getI18nEntry('t3l17');	$Content['1']['7']['class'] = $block."_tb3";
		
		$tabSignal = array(
		0 => "<span class='".$block."_erreur'>ERR</span>",
		1 => "<span class='".$block."_ok'>OK</span>",
		2 => "<span class='".$block."_avert'>WARN</span>",
		3 => "<span class='".$block."_ok'>INFO</span>",
		4 => "<span class='".$block."_ok'>AUTRE</span>",
		);
		
		$pv['historique_date'] = mktime();
		$dbquery = $SDDMObj->query("
			SELECT * 
			FROM ".$SqlTableListObj->getSQLTableName('historique')."
			WHERE site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
			ORDER BY historique_id DESC
			LIMIT 0,15
			;");
		
		$i = 2;
		while ($dbp =  $SDDMObj->fetch_array_sql($dbquery)) {
			$pv['historique_action_longeur'] = strlen($dbp['historique_action']);
			switch (TRUE) {
				case ($pv['historique_action_longeur'] < 128 && $pv['historique_action_longeur'] > 64):	$dbp['historique_action'] = substr ($dbp['historique_action'],0,59) . " [...] ";		break;
				case ($pv['historique_action_longeur'] > 128):									$dbp['historique_action'] = substr ($dbp['historique_action'],0,59) . " [...] " . substr ($dbp['historique_action'],($pv['historique_action_longeur'] - 64) ,$pv['historique_action_longeur'] );		break;
			}
			$Content[$i]['1']['cont'] = $dbp['historique_id'];								$Content[$i]['1']['tc'] = 1;	$Content[$i]['1']['style'] = "text-align: center;";
			$Content[$i]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['historique_date'] );	$Content[$i]['2']['tc'] = 1;	$Content[$i]['2']['style'] = "text-align: center;";
			$Content[$i]['3']['cont'] = $dbp['historique_initiateur'];						$Content[$i]['3']['tc'] = 2;
			$Content[$i]['4']['cont'] = $dbp['historique_action'];							$Content[$i]['4']['tc'] = 1;	$Content[$i]['4']['style'] = "text-align: center;";
			$Content[$i]['5']['cont'] = $tabSignal[$dbp['historique_signal']];												$Content[$i]['5']['style'] = "text-align: center;";
			$Content[$i]['6']['cont'] = $dbp['historique_msgid'];							$Content[$i]['6']['tc'] = 1;	$Content[$i]['6']['style'] = "text-align: center;";
			$Content[$i]['7']['cont'] = $dbp['historique_contenu'];							$Content[$i]['7']['tc'] = 1;
			$i++;
		}
		
		$config = array(
				"nbr_ligne" => $i - 1,
				"nbr_cellule" => 7,
				"legende" => 1,
		);
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
	private function reportTab07 (&$infos){
		$LMObj = LogManagement::getInstance();
		$StringFormatObj = StringFormat::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$I18nObj = I18n::getInstance();
		$Content = array();
		$block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$Content['1']['1']['cont']		= $I18nObj->getI18nEntry('t6l11');	$Content['1']['1']['class'] = $block."_tb3";	$Content['1']['1']['style'] = "text-align: center;";  
		$Content['1']['2']['cont']		= $I18nObj->getI18nEntry('t6l12');	$Content['1']['2']['class'] = $block."_tb3";
		$Content['1']['3']['cont']		= $I18nObj->getI18nEntry('t6l13');	$Content['1']['3']['class'] = $block."_tb3";	$Content['1']['3']['style'] = "text-align: center;";  
		$Content['1']['4']['cont']		= $I18nObj->getI18nEntry('t6l14');	$Content['1']['4']['class'] = $block."_tb3";
		
		$i = 2;
		foreach ( $LMObj->getSqlQueryLog() as $A ) {
			$query = $StringFormatObj->ConvertToHtml($A['requete']);
			
			$queryTime = round( ( $A['temps_fin'] - $A['temps_debut'] ) , 4);
// 			$queryTimeTotal += $queryTime;
			
			$Content[$i]['1']['cont'] = $A['nbr'];				$Content[$i]['1']['style'] = "text-align: center;"; $Content[$i]['1']['tc'] = 1;
			$Content[$i]['2']['cont'] = $A['nom'];																	$Content[$i]['2']['tc'] = 2;
			$Content[$i]['3']['cont'] = $queryTime;				$Content[$i]['3']['style'] = "text-align: center;"; $Content[$i]['3']['tc'] = 1;
			$Content[$i]['4']['cont'] = $query;
			$Content[$i]['4']['tc'] = 1;
			if ( isset ($A['signal']) && $A['signal'] != "OK")	{
				// 		outil_debug($A, "A");
				$Content[$i]['4']['cont']	.= "<br>\r" . $A['err_no']." : ".$A['err_msg'];
				$Content[$i]['4']['class']	= $block."_avert";
				$Content[$i]['4']['style']	= "font-weight: bold";
				$Content[$i]['4']['tc']		= 2;
			}
			$i++;
		}
		$config = array(
				"nbr_ligne" => $i - 1,
				"nbr_cellule" => 4,
				"legende" => 1,
		);
		
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
	 */private function reportTab09 (&$infos){
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$I18nObj = I18n::getInstance();
		$Content = array();
		$block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$Content['1']['1']['cont']	= $I18nObj->getI18nEntry('t9l11');	$Content['1']['1']['class'] = $block."_tb3";	$Content['1']['1']['style'] = "text-align: center;";
		$Content['1']['2']['cont']	= $I18nObj->getI18nEntry('t9l12');	$Content['1']['2']['class'] = $block."_tb2";
		$Content['1']['3']['cont']	= $I18nObj->getI18nEntry('t9l13');	$Content['1']['3']['class'] = $block."_tb2";	$Content['1']['3']['style'] = "text-align: center;";
		
		$i = 2;
		foreach ( $LMObj->getInternalLog() as $A ) {
			$Content[$i]['1']['cont'] = $A['nbr'];			$Content[$i]['1']['tc'] = 1;
			$Content[$i]['2']['cont'] = $A['origin'];		$Content[$i]['2']['tc'] = 1;	$Content[$i]['2']['style'] = "white-space:nowrap;";
			$Content[$i]['3']['cont'] = $A['message'];		$Content[$i]['3']['tc'] = 1;
			$i++;
		}
		
		$config = array(
				"nbr_ligne" => $i - 1,
				"nbr_cellule" => 3,
				"legende" => 1,
		);
		
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}
	
	/**
	 * Returns the Debug report into an array for RenderTables:render()
	 * @param array $infos
	 * @return array
	 */
	private function reportTab10 (&$infos){
		$LMObj = LogManagement::getInstance();
		$StringFormatObj = StringFormat::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$I18nObj = I18n::getInstance();
		$block = $ThemeDataObj->getThemeName().$infos['block'];
		$Content = array();
		
		$Content['1']['1']['cont'] = $I18nObj->getI18nEntry('t10l11');	$Content['1']['1']['class'] = $block."_tb3";
		$Content['1']['2']['cont'] = $I18nObj->getI18nEntry('t10l12');	$Content['1']['2']['class'] = $block."_tb3";
		
		$i = 2;
		
		foreach ( $LMObj->getDebugLog() as $A ) {
			$Content[$i]['1']['cont'] = $A['name'];
			$Content[$i]['2']['cont'] = $StringFormatObj->print_r_html($A['data']);
			$Content[$i]['1']['style'] = "vertical-align:top;";
			$Content[$i]['2']['tc'] = 1;
			$i++;
		}
		
		$config = array(
				"nbr_ligne" => $i - 1,
				"nbr_cellule" => 2,
				"legende" => 1,
		);
		
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}
	
	/**
	 * Convert a size in a human readdable fashion
	 * @param array $infos
	 * @param number $size
	 * @return string
	 */
	private function convertSize( $infos, $size ) {
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$block = $ThemeDataObj->getThemeName().$infos['block'];
		$TabUnits = array(
				"<span class='" . $block."_ok'>b</span>",
				"<span class='" . $block."_avert'>Kb</span>",
				"<span class='" . $block."_erreur " . $block."_tb3'>MB</span>",
				"<span class='" . $block."_erreur " . $block."_tb4'>GB</span>"
		);
		if ($size == 0 ) {
			return "0<span class='" . $block."_erreur " . $block."_tb3'>Kb</span>";
		}
		else {
			if ( $size < 0 ) { return "-".round(abs($size)/pow(1024,($i=floor(log(abs($size),1024)))),2)." ".$TabUnits[$i]; }
			else { return round(abs($size)/pow(1024,($i=floor(log(abs($size),1024)))),2).' '.$TabUnits[$i]; }
		}
	}
	
}
