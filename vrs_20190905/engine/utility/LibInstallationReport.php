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
/*JanusEngine-IDE-begin*/
// Some definitions in order to ease the IDE work.
/* @var $bts BaseToolSet                            */
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*JanusEngine-IDE-end*/

class LibInstallationReport {
	private static $Instance = null;
	
	private function __construct() {}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new LibInstallationReport();
		}
		return self::$Instance;
	}
	
	/**
	 * Renders a 2D array containing the report on a spécific installation section
	 * @param string $section
	 * @param array $style
	 * @return array
	 */
	public function renderReport ($section , $style) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$T = array();

		$l = $c = 1;
		foreach ( $style['titles'] as $A ) {
			$T[$l][$c]['cont'] = $A;
			$c++;
		}
		
		$dbquery = $bts->SDDMObj->query("SELECT * FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('installation_report')
		." WHERE instreport_section = '".$section."'"
		." ORDER BY instreport_name"
		.";"
		);
		$l = 3;
		$dataOk = $dataWrn = $dataErr = $dataTim = $dataQry = $dataCmd = 0;
		while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
			$T[$l]['1']['cont'] = $dbp['instreport_name'];
			$T[$l]['2']['cont'] = $dbp['instreport_ok'];

			if ( $dbp['instreport_wrn'] > 0 ) { 
				$T[$l]['3']['class'] = $style['block'] . "_warning" ; 
				$T[$l]['3']['b'] = 1 ; 
			} 
			$T[$l]['3']['cont'] = $dbp['instreport_wrn'];
			
			if ( $dbp['instreport_err'] > 0 ) { 
				$T[$l]['4']['class'] = $style['block'] . "_error" ; 
				$T[$l]['4']['b'] = 1; 
			} 
			$T[$l]['4']['cont'] =  $dbp['instreport_err'];

			$T[$l]['5']['cont'] = round  ( (($dbp['instreport_end'] - $dbp['instreport_start'])/1000000000), 4 );
			$T[$l]['6']['cont'] = $dbp['instreport_nbr_query'];
			$T[$l]['7']['cont'] = $dbp['instreport_nbr_cmd'];

			$dataOk		+= $dbp['instreport_ok'];
			$dataWrn	+= $dbp['instreport_wrn'];
			$dataErr	+= $dbp['instreport_err'];
			$dataTim	+= ($dbp['instreport_end'] - $dbp['instreport_start']);
			$dataQry	+= $dbp['instreport_nbr_query'];
			$dataCmd	+= $dbp['instreport_nbr_cmd'];

			$l++;
		}

		$l = 2;
		$T[$l]['1']['b'] = 1;	$T[$l]['1']['cont'] = "Tot";
		$T[$l]['2']['b'] = 1;	$T[$l]['2']['cont'] = $dataOk;
		$T[$l]['3']['b'] = 1;	$T[$l]['3']['cont'] = $dataWrn;
		$T[$l]['4']['b'] = 1;	$T[$l]['4']['cont'] = $dataErr;
		$T[$l]['5']['b'] = 1;	$T[$l]['5']['cont'] = round(($dataTim/1000000000), 4 );
		$T[$l]['6']['b'] = 1;	$T[$l]['6']['cont'] = $dataQry;
		$T[$l]['7']['b'] = 1;	$T[$l]['7']['cont'] = $dataCmd;

		if ( $dataWrn > 0 )  { $T[$l]['3']['class'] = $style['block'] . "_warning"; }
		if ( $dataErr > 0 )  { $T[$l]['4']['class'] = $style['block'] . "_error"; }

		return ($T);
	}

	/**
	 * Returns the number of lines in the installation reponrt table for a named section
	 * @param string $section
	 * @return integer

	 */
	public function getInstallSectionLineCount($section){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$n=0;
		$dbquery = $bts->SDDMObj->query("SELECT COUNT(*) as lc FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('installation_report')
		." WHERE instreport_section = '".$section."';"
		);
		while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) { $n = $dbp['lc']; }
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : Section '".$section."' has ".$n." lines."));
		return ($n);
	}

	/**
	 * renderPerfomanceReport
	 */
	public function renderPerfomanceReport ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		// $Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];
		$SQLQueries = 0;
		$memoryUsed = 0;
		$RamB4 = 0;
		$Content = array();
		
		$Content['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab01');
		$Content['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab02');
		$Content['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab03');
		$Content['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab04');
		$Content['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab05');
		// $Content['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab06');
		
		$sg['MemoryMax'] = 0;
		$sg['MemoryMin'] = 1000;
		$sg['timeMin'] = $bts->TimeObj->getMicrotime();
		$sg['timeMax'] = 0;
		
		$TableStats = $bts->LMObj->getStatisticsLog();
		reset ( $TableStats );
		
		foreach ( $TableStats as &$A ) {
			$A['SgMem'] = round(( $A['memory'] / 1024 ), 2 );
			if ( $A['SgMem'] > $sg['MemoryMax'] )	{ $sg['MemoryMax'] = $A['SgMem']; }
			if ( $A['SgMem'] < $sg['MemoryMin'] )	{ $sg['MemoryMin'] = $A['SgMem']; }
			if ( $A['time'] > $sg['timeMax'] )	{ $sg['timeMax'] = $A['time']; }
			if ( $A['time'] < $sg['timeMin'] )	{ $sg['timeMin'] = $A['time']; }
		}
		$i = 2;
		foreach ( $TableStats as &$A ) {
			if ( $i == 2 ) { 
				$sg['timeB4'] = $A['time'];
				$t0 = $A['time'];
			}
			$A['timePerf'] =  round ( ($A['time'] - $sg['timeB4']), 4 );
			$A['timeCheckpoint'] =  round ($A['time'] - $sg['timeMin'], 4 );
			$sg['timeB4'] = $A['time'];
			
			$A['MemorySegment'] = ( $A['memory'] - $RamB4 );
			$RamB4 = $A['memory'];
			
			$Content[$i]['1']['cont'] = $A['position'];																	$Content[$i]['1']['style'] = "text-align: center;";
			$Content[$i]['2']['cont'] = $A['routine'];																	$Content[$i]['3']['cont'] = $A['timePerf'];																$Content[$i]['3']['style'] = "text-align: center;";
			$Content[$i]['4']['cont'] = $bts->StringFormatObj->makeSizeHumanFriendly($infos, $A['MemorySegment'] );	$Content[$i]['4']['style'] = "text-align: center;";
			$Content[$i]['5']['cont'] = $A['SQL_queries'];																$Content[$i]['5']['style'] = "text-align: center;";
			// $Content[$i]['6']['cont'] = $A['context'];																	
			// error_log("----------------------->inserted : " . $bts->StringFormatObj->arrayToString($Content[$i]));

			$SQLQueries += $A['SQL_queries'];
			$memoryUsed += $A['MemorySegment'];
			$tLast = $A['time'];
			$i++;
		}
		
		$timeSpent = round ($tLast - $t0, 4);
		
		$memoryUsed = $bts->StringFormatObj->makeSizeHumanFriendly($infos, $memoryUsed);
		$Content[$i]['1']['cont'] = "";				$Content[$i]['1']['style'] = "text-align: center;";
		$Content[$i]['2']['cont'] = "";				
		$Content[$i]['3']['cont'] = $timeSpent;		$Content[$i]['3']['style'] = "text-align: center;";
		$Content[$i]['4']['cont'] = $memoryUsed;	$Content[$i]['4']['style'] = "text-align: center;";
		$Content[$i]['5']['cont'] = $SQLQueries;	$Content[$i]['5']['style'] = "text-align: center;";
		
		$config = array(
				"NbrOfLines" => $i,
				"NbrOfCells" => 5,
				"TableCaptionPos" => 1,
		);
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}

	/**
	 * Return a template of a config file. 
	 * @param array $infos
	 * @return string
	 */
	public function renderConfigFile (&$infos) {
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : creating config for site N°:".$infos['n']));

// 		$CurrentSetObj = CurrentSet::getInstance();
		$Content = "
<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/
//	This config file has been generated.
//	Date		:	".$bts->TimeObj->timestampToDate($bts->TimeObj->getMicrotime())."
//	Filename	:	site_".$infos['n']."_config.php
//	
//	
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

function returnConfig () {
	\$tab = array();
	\$tab['type']				= \"".$bts->CMObj->getConfigurationSubEntry('db', 'type')."\"; // mysql, pgsql
	\$tab['host']				= \"".$bts->CMObj->getConfigurationSubEntry('db', 'host')."\";
	\$tab['dal']				= \"".$bts->CMObj->getConfigurationSubEntry('db', 'dal')."\";	//PDO, PHP
	\$tab['port']				= \"".$bts->CMObj->getConfigurationSubEntry('db', 'port')."\";
	\$tab['db_user_login']		= \"".$bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin')."\";
	\$tab['db_user_password']	= \"".$bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserPassword')."\";
	\$tab['dbprefix']			= \"".$bts->CMObj->getConfigurationSubEntry('db', 'dbprefix')."\";
	\$tab['tabprefix']			= \"".$bts->CMObj->getConfigurationSubEntry('db', 'tabprefix')."\";
	\$tab['SessionMaxAge']	= (60*60*24);
	
	\$tab['DebugLevel_SQL']	= LOGLEVEL_WARNING;					// SDDM
	\$tab['DebugLevel_CC']	= LOGLEVEL_WARNING;					// Commande Console
	\$tab['DebugLevel_PHP']	= LOGLEVEL_WARNING;					// 
	\$tab['DebugLevel_JS']	= LOGLEVEL_WARNING;					// 
	
	\$tab['execution_context']		= \"render\";
	\$tab['InsertStatistics']		= 1;
	\$tab['commandLineEngine'] = array(
			\"state\"		=>	\"enabled\",
	);
	return \$tab;
}

?>
";
	
	return $Content;
	}



}