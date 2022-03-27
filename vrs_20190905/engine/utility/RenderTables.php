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
class  RenderTables {
	private static $Instance = null;
	private $javascriptAlreadyIncluded = false;
	
	private function __construct() {
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderTables
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderTables ();
		}
		return self::$Instance;
	}
	
	/**
	 * Takes the array and render it as a chart (option : with tabs).<br>
	 * The renderer is reactive to specific definitions in the array. Ex: $myArray[1][2][3][cc] is defining the caption class<br>
	 * <br>
	 * <b>TD level:</b><br>
	 * cc : Defines caption class.<br>
	 * b  : Enables bold font.<br>
	 * class : if not empty tells the renderer to use the specified classname for a cell.<br>
	 * DEPRECATED tc : Defines font size.<br>
	 * DEPRECATED sc : Defines the "selection class" when hover.<br>
	 * <br>
	 * <b>TR level:</b><br>
	 * link : Enable the TR to be clickable as a link
	 * 
	 * @param array $infos
	 * @param array $T
	 * @return string
	 * 
	 */
	public function render($infos, $T) {
// 		$T as Table containing all needed information for rendering the table and tabs.
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		error_reporting (0);
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"));
		
		$Content = "<!-- Render Table Begin -->\r<div style='width:100%;'>\r";
		if ( $T['ContentInfos']['NbrOfTabs'] == 0 ) { $T['ContentInfos']['NbrOfTabs'] = 1; }
		if ( $T['ContentInfos']['EnableTabs'] != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Tabs are enabled"));
			if ( $this->javascriptAlreadyIncluded == false ) {
				$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-File', "current/engine/javascript/lib_TabsManagement.js");
				$this->javascriptAlreadyIncluded = true;
			}
			$Content .= $bts->RenderTabsObj->render($infos, $T); 
		}
		
		// --------------------------------------------------------------------------------------------
		//
		//	Preparation of styles
		//
		// --------------------------------------------------------------------------------------------
		// $CurT = Current Tab
		// $CurL = Current Line
		// $CurC = Current Cell
		$ADC = &$T['ContentCfg'];
		$AD = &$T['Content'];
		$tab_infos = &$T['ContentInfos'];
		$tab_infos['HighLightTypeBackup'] = $tab_infos['HighLightType'];
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " A table is on the bench. Let's get to work!"));
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		
		for ( $CurT = 1 ; $CurT <= $tab_infos['NbrOfTabs'] ; $CurT++ ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Legend for Tab number ".$CurT." is " . $ADC['tabs'][$CurT]['TableCaptionPos']));
			switch ( $ADC['tabs'][$CurT]['TableCaptionPos'] ) {
				case 1: 	$ADC['tabs'][$CurT]['legendClasses'] .= $Block._CLASS_TBL_LGND_TOP_;									break;// top
				case 2: 	$ADC['tabs'][$CurT]['legendClasses'] .= $Block._CLASS_TBL_LGND_LEFT_;									break;// left
				case 3: 	$ADC['tabs'][$CurT]['legendClasses'] .= $Block._CLASS_TBL_LGND_RIGHT_;									break;// right
				case 4: 	$ADC['tabs'][$CurT]['legendClasses'] .= $Block._CLASS_TBL_LGND_BOTTOM_;									break;// bottom
				case 5: 	$ADC['tabs'][$CurT]['legendClasses'] .= $Block._CLASS_TBL_LGND_LEFT_." ".$Block._CLASS_TBL_LGND_RIGHT_;	break;// left&right
				case 6:		$ADC['tabs'][$CurT]['legendClasses'] .= $Block._CLASS_TBL_LGND_TOP_." ".$Block._CLASS_TBL_LGND_BOTTOM_;	break;// top&bottom
			}
		}
		// --------------------------------------------------------------------------------------------
		//
		//	Display
		//
		
		if ( $tab_infos['EnableTabs'] != 0 ) {
			$Height = ($tab_infos['Height'] > 0) ? "height:".$tab_infos['Height']."px; " : "height:auto; ";
			$Content .= "<div id='AD_".$tab_infos['GroupName']."_".$tab_infos['DocumentName']."' class='".$Block."_tabFrame' style='width:100%; padding:0px; margin:0px; overflow:auto; ".$Height."' >\r"; // overflow:hidden;
		}

		$TableWidth = ($tab_infos['Width']-32);
		$visibility = ($infos['initial_visibility']) ? $infos['initial_visibility'] : "visible";
		for ( $CurT = 1 ; $CurT <= $tab_infos['NbrOfTabs'] ; $CurT++ ) {
			if ( $CurT > 1 ) { $visibility = "hidden"; }
			if ( $tab_infos['EnableTabs'] != 0 ) {
				$Content .= "<div id='".$tab_infos['GroupName']."_".$tab_infos['DocumentName'].$CurT."' style='position:absolute; visibility:".$visibility."; width:100%; ".$Height." overflow:auto;'>\r"; // position:absolute;
			}
			
			unset ($A);
			$i = 0;
			if ( isset($ADC['tabs'][$CurT]['colswidth']) ) {
				$ListeColWidth = "<colgroup>\r";
				foreach ( $ADC['tabs'][$CurT]['colswidth'] as $A ) {
					$ListeColWidth .= "<col span='".$i."' style='width:".floor( $TableWidth * $A )."px;'>\r";
					$i++;
				}
				$ListeColWidth .= "</colgroup>\r";
				if ( $i == 0 ) { $ListeColWidth =""; }
			}
			
			if ( $ADC['tabs'][$CurT]['NbrOfLines'] != 0 ) {
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "ADC['tabs'][".$CurT."]['NbrOfLines']=".$ADC['tabs'][$CurT]['NbrOfLines']."; HighLightType=".$ADC['tabs'][$CurT]['HighLightType']));
// 				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "ADC['tabs'][".$CurT."]['NbrOfLines']=".$ADC['tabs'][$CurT]['NbrOfLines']."; HighLightType=".$ADC['tabs'][$CurT]['HighLightType'])." ");
// 				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "ADC"));
				if ( isset($ADC['tabs'][$CurT]['HighLightType'])) { $tab_infos['HighLightType'] = $ADC['tabs'][$CurT]['HighLightType']; }

				$Content .= "<table class='".$Block._CLASS_TABLE01_." ".$ADC['tabs'][$CurT]['legendClasses']."' style='width:100%; empty-cells: show;'>\r" . $ListeColWidth; //table-layout: fixed; overflow:hidden;
				
				if ( isset($AD[$CurT]['caption']['cont']) ) {
					if ( isset($AD[$CurT]['caption']['class']) ) { $captionClass = "class='".$AD[$CurT]['caption']['class']."' "; }
					if ( isset($AD[$CurT]['caption']['syle']) ) { $CaptionStyle = "style='".$AD[$CurT]['caption']['style']."' "; }
					$Content .= "<caption ".$captionClass.$CaptionStyle.">".$AD[$CurT]['caption']['cont']."</caption>\r";
				}
				
				$TRidx = 0;
				for ( $CurL = 1 ; $CurL <= $ADC['tabs'][$CurT]['NbrOfLines'] ; $CurL++ ) {
					if ( $CurL == $ADC['tabs'][$CurT]['theadD'] ) { $Content .= "<thead>\r"; }
					if ( $CurL == $ADC['tabs'][$CurT]['tbodyD'] ) { $Content .= "<tbody style='display:block; width:100%; height:".($tab_infos['Height']-64)."px; overflow-y:scroll;'>\r"; }		//display:block;
					if ( $CurL == $ADC['tabs'][$CurT]['tfootD'] ) { $Content .= "<tfoot>\r"; }
					
					$trLink = "";
					if (isset($AD[$CurT][$CurL]['link'])) { $trLink = "onclick=\"document.location = '".$AD[$CurT][$CurL]['link']."';\""; }
					if ( $tab_infos['HighLightType'] == 1 ) {
						$strTR = "<tr style='vertical-align:middle;' ".$trLink." >\r";
					}
					else { $strTR = "<tr style='vertical-align:middle;' ".$trLink." >\r"; }
					$Content .= $strTR;
					
					$TRidx = $TRidx;
					for ( $CurC = 1 ; $CurC <= $ADC['tabs'][$CurT]['NbrOfCells'] ; $CurC++ ) {
						if ( $AD[$CurT][$CurL][$CurC]['disabled'] == 0 ) {
								$strDeco = " class='";
							$boldB = $boldE = "";
							if ($AD[$CurT][$CurL][$CurC]['b'] == 1 ) {
								$boldB = "<b>";
								$boldE = "</b>"; 
							}
							if ( isset($AD[$CurT][$CurL][$CurC]['cc']) )	{ $strDeco .= $AD[$CurT][$CurL][$CurC]['cc']; }
							if ( isset($AD[$CurT][$CurL][$CurC]['class']))	{ $strDeco .= $AD[$CurT][$CurL][$CurC]['class']." "; }
							if ( $strDeco == " class='" ) { $strDeco = ""; }
							else  { $strDeco = substr( $strDeco, 0, -1 ) . "'"; }
							
							if ( isset($AD[$CurT][$CurL][$CurC]['style']) ) { $strDeco .= " style='".$AD[$CurT][$CurL][$CurC]['style']."'"; }
							
							$tdTmp = "<td" . $strDeco;
							$spanScore = 0;
							if ( $AD[$CurT][$CurL][$CurC]['colspan'] != 0 ) { $spanScore += 1; }
							if ( $AD[$CurT][$CurL][$CurC]['rowspan'] != 0 ) { $spanScore += 2; }
							switch ($spanScore) {
								case 1:
									$tdTmp .= " colspan='".$AD[$CurT][$CurL][$CurC]['colspan']."'";
									$CurC += $AD[$CurT][$CurL][$CurC]['colspan']-1;
									break;
								case 2:
									$tdTmp .= " rowspan='".$AD[$CurT][$CurL][$CurC]['rowspan']."'";
									break;
								case 3:
									$tdTmp .= " colspan='".$AD[$CurT][$CurL][$CurC]['colspan']." rowspan='".$AD[$CurT][$CurL][$CurC]['rowspan']."'";
									break;
							}
							$Content .= $tdTmp .">".$boldB.$AD[$CurT][$CurL][$CurC]['cont'].$boldE."</td>\r";
						}
						else { $Content .= "<td></td>\r"; }
						$TRidx ^= 1;
					}
					$Content .= "</tr>\r";
					if ( $CurL == $ADC['tabs'][$CurT]['theadF'] ) { $Content .= "</thead>\r"; }
					if ( $CurL == $ADC['tabs'][$CurT]['tbodyF'] ) { $Content .= "</tbody>\r"; }
					if ( $CurL == $ADC['tabs'][$CurT]['tfootF'] ) { $Content .= "</tfoot>\r"; }
					$TRidx ^= 1;
				}
				$Content .= "</table>\r";
			}
			$tab_infos['HighLightType'] = $tab_infos['HighLightTypeBackup'];
			if ( $tab_infos['EnableTabs'] != 0 ) { $Content .= "</div>\r"; }
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End of tab :". $CurT));
		}
		if ( $tab_infos['EnableTabs'] != 0 ) { $Content .= "</div>\r"; }
		
		unset (
		$CurC,
		$CurL,
		$CurT
		);
		$Content .= "</div>\r<!-- Render Table End -->\r";
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : \$tab_infos['RenderMode']:". $tab_infos['RenderMode']));
		switch ( $tab_infos['RenderMode'] ) {
			case 0:			echo ($Content);	unset ($Content);		break;
			case 1:			return $Content;							break;
		}
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
		error_reporting(DEFAULT_ERROR_REPORTING);
	}
	
	/**
	 * Returns an array with default values for renderTable->render()
	 * @param array $infos
	 * @param number $lines
	 * @param number $NbrOfTabs
	 * @param number $TabBehavior
	 * @param number $HighLightType
	 * @param string $TabTxt
	 * @return array
	 */
	public function getDefaultDocumentConfig (&$infos, $lines=0, $NbrOfTabs=1, $TabBehavior=1, $HighLightType=1, $TabTxt="tabTxt") {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$tab = array(
		"EnableTabs"		=> 1,
		"NbrOfTabs"			=> $NbrOfTabs,
		"TabBehavior"		=> $TabBehavior,
		"RenderMode"		=> 1,
		"HighLightType"		=> $HighLightType,
		"Height"			=> $lines * 24,		// default
		"Width"				=> 960, // Minimum size (we don't have theme_module_internal_width any more)
		"GroupName"			=> "l",
		"CellName"			=> "c",
		"DocumentName"		=> "d",
		);
		for ($i=1; $i<=$NbrOfTabs; $i++ ){
			$tab["tabTxt".$i] = $bts->I18nTransObj->getI18nTransEntry($TabTxt.$i);
		}
		return $tab;
	}
	
	/**
	 * Update the tabs titles with the I18n fresh data
	 * @param array $ContentInfos
	 * @param number $NbrOfTabs
	 * @param string $TabTxt
	 */
	public function updateTabsTitle(&$ContentInfos, $NbrOfTabs, $TabTxt="tabTxt") {
		$bts = BaseToolSet::getInstance();
		for ($i=1; $i<=$NbrOfTabs; $i++ ){
			$ContentInfos["tabTxt".$i] = $bts->I18nTransObj->getI18nTransEntry($TabTxt.$i);
		}
	}

	/**
	 * Returns an array with default values for renderTable->render()
	 * @param number $lines
	 * @param number $cells
	 * @param number $legend
	 * @return array
	 */
	public function getDefaultTableConfig ($lines=10 , $cells=2, $legend=1) {
		return (
			array(
				"NbrOfLines"		=>	$lines,	
				"NbrOfCells"		=>	$cells,
				"TableCaptionPos"	=>	$legend,
			)
		);
	}
	
}


