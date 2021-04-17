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
/* @var $RenderLayoutObj RenderLayout               */
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
	
	public function renderReport ( &$src , $style ) {
		reset ($src);
		$R = array();
		$counters= array('file' => 0, 'OK' => 0, 'WARN' => 0, 'ERR' => 0, );

		$l = 1;
		foreach ( $src as $A ) {
			$c = 1;
			if ( $l == 1 ) {
				foreach ( $style['titles'] as $B ) {
					$R[$l][$c]['cont']	= $B;
					$R[$l][$c]['tc']	= 4;
					$R[$l][$c]['sc']	= 8;
					$c++;
				}
				$c = 1;
				$l++;
			}
			foreach ( $style['cols'] as $B ) {
				$R[$l][$c]['tc']	= $style['tc'];
				if ( $B == "WARN" && $A[$B] > 0 ) { $R[$l][$c]['class'] = $style['block'] . "_warning" ;	$R[$l][$c]['b'] =1;	$R[$l][$c]['tc'] +=2; }
				if ( $B == "ERR"  && $A[$B] > 0 ) { $R[$l][$c]['class'] = $style['block'] . "_error";	$R[$l][$c]['b'] =1;	$R[$l][$c]['tc'] +=2; }
				$R[$l][$c]['cont']	= $A[$B];
				if ($c != 1 ) { $counters[$B] += $A[$B]; }
				$c++;
			}
			$l++;
		}
		// last values of the chart.
		unset ($B);
		$c = 1;
		foreach ( $style['cols'] as $B ) {			
			if ($c != 1 ) {
				$R[$l][$c]['tc']	= $style['tc'];
				if ( $B == "WARN" && $A[$B] > 0 ) { $R[$l][$c]['class'] = $style['block'] . "_warning" ;	$R[$l][$c]['tc'] +=2; }
				if ( $B == "ERR" && $A[$B] > 0 )  { $R[$l][$c]['class'] = $style['block'] . "_error";	$R[$l][$c]['tc'] +=2; }
				$R[$l][$c]['cont']	= $counters[$B];
				$R[$l][$c]['b'] =1;
			}
			$c++;
		}
		return $R;
	}
	
	public function renderPerfomanceReport () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$Content = array();
		
		$Content['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab01');	$Content['1']['1']['class'] = $block."_tb3";	$Content['1']['1']['1']['style'] = "text-align: center;";
		$Content['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab02');	$Content['1']['2']['class'] = $block."_tb3";
		$Content['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab03');	$Content['1']['3']['class'] = $block."_tb3";	$Content['1']['1']['3']['style'] = "text-align: center;";
		$Content['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab04');	$Content['1']['4']['class'] = $block."_tb3";	$Content['1']['1']['4']['style'] = "text-align: center;";
		$Content['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab05');	$Content['1']['5']['class'] = $block."_tb3";	$Content['1']['1']['5']['style'] = "text-align: center;";
// 		$Content['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('perfTab06');	$Content['1']['6']['class'] = $block."_tb3";
		
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
				"nbr_ligne" => $i,
				"nbr_cellule" => 5,
				"legende" => 1,
		);
		$package = array ("content" => $Content , "config" => $config);
		return $package ;
	}


}