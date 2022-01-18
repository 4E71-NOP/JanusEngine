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
/*Hydre-IDE-begin*/
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
/*Hydre-IDE-end*/

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
			// error_log ( __METHOD__ . " : ".$A);
			$c++;
		}
		
		$dbquery = $bts->SDDMObj->query("SELECT * FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation_report')
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
		$dbquery = $bts->SDDMObj->query("SELECT count(*) as lineCount FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation_report')
		." WHERE instreport_section = '".$section."';"
		);
		while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) { $n = $dbp['lineCount']; }
		// $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : Section '".$section."' has ".$n." lines."));
		return ($n);
	}

	/**
	 * renderPerfomanceReport
	 */
	public function renderPerfomanceReport () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$Content = array();
		
		$Content['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab01');	$Content['1']['1']['class'] = $Block."_tb3";	$Content['1']['1']['1']['style'] = "text-align: center;";
		$Content['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab02');	$Content['1']['2']['class'] = $Block."_tb3";
		$Content['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab03');	$Content['1']['3']['class'] = $Block."_tb3";	$Content['1']['1']['3']['style'] = "text-align: center;";
		$Content['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab04');	$Content['1']['4']['class'] = $Block."_tb3";	$Content['1']['1']['4']['style'] = "text-align: center;";
		$Content['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab05');	$Content['1']['5']['class'] = $Block."_tb3";	$Content['1']['1']['5']['style'] = "text-align: center;";
// 		$Content['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab06');	$Content['1']['6']['class'] = $Block."_tb3";
		
		$sg['MemoireMax'] = 0;
		$sg['MemoireMin'] = 1000;
		$sg['TempsMin'] = $bts->TimeObj->microtime_chrono();
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
			if ( $i == 2 ) { 
				$sg['tempsAV'] = $A['temps'];
				$t0 = $A['temps'];
			}
			$A['TempsPerf'] =  round ( ($A['temps'] - $sg['tempsAV']), 4 );
			$A['TempsCheckpoint'] =  round ($A['temps'] - $sg['TempsMin'], 4 );
			$sg['tempsAV'] = $A['temps'];
			
			$A['MemoireSegment'] = ( $A['memoire'] - $pv['mem_b4'] );
			$pv['mem_b4'] = $A['memoire'];
			
			$Content[$i]['1']['cont'] = $A['position'];																	$Content[$i]['1']['tc'] = 1;	$Content[$i]['1']['style'] = "text-align: center;";
			$Content[$i]['2']['cont'] = $A['routine'];																	$Content[$i]['2']['tc'] = 1;
			$Content[$i]['3']['cont'] = $A['TempsPerf'];																$Content[$i]['3']['tc'] = 1;	$Content[$i]['3']['style'] = "text-align: center;";
			$Content[$i]['4']['cont'] = $bts->StringFormatObj->makeSizeHumanFriendly($infos, $A['MemoireSegment'] );	$Content[$i]['4']['tc'] = 1;	$Content[$i]['4']['style'] = "text-align: center;";
			$Content[$i]['5']['cont'] = $A['SQL_queries'];																$Content[$i]['5']['tc'] = 1;	$Content[$i]['5']['style'] = "text-align: center;";
// 			$Content[$i]['6']['cont'] = $A['context'];																	$Content[$i]['6']['tc'] = 1;
// 			error_log("----------------------->inserted : " . $bts->StringFormatObj->arrayToString($Content[$i]));

			$SQLQueries += $A['SQL_queries'];
			$memoryUsed += $A['MemoireSegment'];
			$tLast = $A['temps'];
			$i++;
		}
		
		$timeSpent = round ($tLast - $t0, 4);
		
		$memoryUsed = $bts->StringFormatObj->makeSizeHumanFriendly($infos, $memoryUsed);
		$Content[$i]['1']['cont'] = "";								$Content[$i]['1']['tc'] = 1;	$Content[$i]['1']['style'] = "text-align: center;";
		$Content[$i]['2']['cont'] = "";								$Content[$i]['2']['tc'] = 1;
		$Content[$i]['3']['cont'] = $timeSpent;						$Content[$i]['3']['tc'] = 1;	$Content[$i]['3']['style'] = "text-align: center;";
		$Content[$i]['4']['cont'] = $memoryUsed;					$Content[$i]['4']['tc'] = 1;	$Content[$i]['4']['style'] = "text-align: center;";
		$Content[$i]['5']['cont'] = $SQLQueries;					$Content[$i]['5']['tc'] = 1;	$Content[$i]['5']['style'] = "text-align: center;";
		
		$config = array(
				"NbrOfLines" => $i,
				"NbrOfCells" => 5,
				"TableCaptionPos" => 1,
		);
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}


}