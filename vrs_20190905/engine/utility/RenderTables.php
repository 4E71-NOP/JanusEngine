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
	
	public function __construct() {}
	
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
	 * The renderer is reactive to specific definitions in the array. Ex: $myArray[1][2][3][tc] is defining the font size to use when rendering the cell at tab 1, line 2, cell 3.<br>
	 * <br>
	 * <b>TD level:</b><br>
	 * cc : Defines caption class.<br>
	 * DEPRECATED sc : Defines the "selection class" when hover.<br>
	 * b  : Enables bold font.<br>
	 * class : if not empty tells the renderer to use the specified classname.<br>
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
// 	 * tc : Define font size class from 1 to 7. Default is 3.<br>
		$cs = CommonSystem::getInstance(); 
// 	$T as Table containing all needed information for rendering the table and tabs.

		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
		
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"));
		
		$Content = "<!-- Render Table Begin -->\r";
		if ( $T['tab_infos']['NbrOfTabs'] == 0 ) { $T['tab_infos']['NbrOfTabs'] = 1; }
		if ( $T['tab_infos']['EnableTabs'] != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Tabs are enabled"));
			$ClassLoaderObj = ClassLoader::getInstance();
			$ClassLoaderObj->provisionClass('RenderTabs');
			$RenderTabsObj = RenderTabs::getInstance();
			$GeneratedJavaScriptObj->insertJavaScript('File', "engine/javascript/lib_TabsManagement.js");
			$Content .= $RenderTabsObj->render($infos, $T); 
		}
		
		// --------------------------------------------------------------------------------------------
		//
		//	Preparation of styles
		//
		// --------------------------------------------------------------------------------------------
		// $CurT = Current Tab
		// $CurL = Current Line
		// $CurC = Current Cell
		$ADC = &$T['ADC'];
		$AD = &$T['AD'];
		$tab_infos = &$T['tab_infos'];
		$tab_infos['HighLightTypeBackup'] = $tab_infos['HighLightType'];
		
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Table on the bench"));
// 		$legendClasses = "";
		$block = $ThemeDataObj->getThemeName().$infos['block'];
		
		for ( $CurT = 1 ; $CurT <= $tab_infos['NbrOfTabs'] ; $CurT++ ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Legend for Tab number ".$CurT." is " . $ADC['onglet'][$CurT]['legende']));
			switch ( $ADC['onglet'][$CurT]['legende'] ) {
				case 1: 	$ADC['onglet'][$CurT]['legendClasses'] .= $block.CLASS_TblLgnd_Top;									break;// top
				case 2: 	$ADC['onglet'][$CurT]['legendClasses'] .= $block.CLASS_TblLgnd_Left;								break;// left
				case 3: 	$ADC['onglet'][$CurT]['legendClasses'] .= $block.CLASS_TblLgnd_Right;								break;// right
				case 4: 	$ADC['onglet'][$CurT]['legendClasses'] .= $block.CLASS_TblLgnd_Bottom;								break;// bottom
				case 5: 	$ADC['onglet'][$CurT]['legendClasses'] .= $block.CLASS_TblLgnd_Left." ".$block.CLASS_TblLgnd_Right;	break;// left&right
				case 6:		$ADC['onglet'][$CurT]['legendClasses'] .= $block.CLASS_TblLgnd_Top." ".$block.CLASS_TblLgnd_Bottom;	break;// top&bottom
			}
		}
		// --------------------------------------------------------------------------------------------
		//
		//	Display
		//
		
		if ( $tab_infos['EnableTabs'] != 0 ) {
			$Height = ($tab_infos['Height'] > 0) ? "height:".$tab_infos['Height']."px; " : "height:auto; ";
			$Content .= "<div id='AD_".$tab_infos['GroupName']."_".$tab_infos['DocumentName']."' class='".$block."_tabFrame' style='position:relative; overflow:hidden; width:".($tab_infos['Width']-10) ."px; ".$Height."' >\r"; // overflow:hidden;
		}
// 		$classTab= array (
// 			0  =>	$block."_fca",
// 			1  =>	$block."_fcb",
// 			2  =>	$block."_fcc",
// 			3  =>	$block."_fcd",

// 			4  =>	$block."_fcsa",
// 			5  =>	$block."_fcsb",
// 			6  =>	$block."_fcsa",
// 			7  =>	$block."_fcsb",
				
// 			8  =>	$block."_fcta",
// 			9  =>	$block."_fctb",
// 			10 =>	$block."_fcta",
// 			11 =>	$block."_fctb",
// 		);
		
		
		$TableWidth = ($tab_infos['Width']-32);
		$visibility = "visible";
		for ( $CurT = 1 ; $CurT <= $tab_infos['NbrOfTabs'] ; $CurT++ ) {
			if ( $CurT > 1 ) { $visibility = "hidden"; }
			if ( $tab_infos['EnableTabs'] != 0 ) {
				$Content .= "<div id='".$tab_infos['GroupName']."_".$tab_infos['DocumentName'].$CurT."' style='position:absolute; visibility:".$visibility."; width:".( $tab_infos['Width']-16)."px; ".$Height." overflow:auto;'>\r"; // position:absolute;
			}
			
			unset ($A);
			$i = 0;
			if ( isset($ADC['onglet'][$CurT]['colswidth']) ) {
				$ListeColWidth = "<colgroup>\r";
				foreach ( $ADC['onglet'][$CurT]['colswidth'] as $A ) {
					$ListeColWidth .= "<col span='".$i."' style='width:".floor( $TableWidth * $A )."px;'>\r";
					$i++;
				}
				$ListeColWidth .= "</colgroup>\r";
				if ( $i == 0 ) { $ListeColWidth =""; }
			}
			
			if ( $ADC['onglet'][$CurT]['nbr_ligne'] != 0 ) {
				$cs->LMObj->InternalLog(array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ .
 						"\$ADC['onglet'][\$CurT]['nbr_ligne']=`".$ADC['onglet'][$CurT]['nbr_ligne'].
 						"`; HighLightType=`". $ADC['onglet'][$CurT]['HighLightType'])."`" );
				if ( isset($ADC['onglet'][$CurT]['HighLightType'])) { $tab_infos['HighLightType'] = $ADC['onglet'][$CurT]['HighLightType']; }

				$Content .= "<table class='".$block.CLASS_Table01." ".$ADC['onglet'][$CurT]['legendClasses']."' style='width:".$TableWidth."px; empty-cells: show;'>\r" . $ListeColWidth; //table-layout: fixed; overflow:hidden;
				
				if ( isset($AD[$CurT]['caption']['cont']) ) {
					if ( isset($AD[$CurT]['caption']['class']) ) { $captionClass .= "class='".$AD[$CurT]['caption']['class']."' "; }
					if ( isset($AD[$CurT]['caption']['syle']) ) { $CaptionStyle = "style='".$AD[$CurT]['caption']['style']."' "; }
					$Content .= "<caption ".$captionClass.$CaptionStyle.">".$AD[$CurT]['caption']['cont']."</caption>\r";
				}
				
				$TRidx = 0;
				for ( $CurL = 1 ; $CurL <= $ADC['onglet'][$CurT]['nbr_ligne'] ; $CurL++ ) {
					if ( $CurL == $ADC['onglet'][$CurT]['theadD'] ) { $Content .= "<thead>\r"; }
					if ( $CurL == $ADC['onglet'][$CurT]['tbodyD'] ) { $Content .= "<tbody style='display:block; width:".$TableWidth."px; height:".($tab_infos['Height']-64)."px; overflow-y:scroll;'>\r"; }		//display:block;
					if ( $CurL == $ADC['onglet'][$CurT]['tfootD'] ) { $Content .= "<tfoot>\r"; }
					
					$trLink = "";
					if (isset($AD[$CurT][$CurL]['link'])) { $trLink = "onclick=\"document.location = '".$AD[$CurT][$CurL]['link']."';\""; }
					if ( $tab_infos['HighLightType'] == 1 ) {
						$strTR = "<tr style='vertical-align:middle;' ".$trLink." >\r";
					}
					else { $strTR = "<tr style='vertical-align:middle;' ".$trLink." >\r"; }
					$Content .= $strTR;
					
					$TRidx = $TRidx;
					for ( $CurC = 1 ; $CurC <= $ADC['onglet'][$CurT]['nbr_cellule'] ; $CurC++ ) {
						if ( $AD[$CurT][$CurL][$CurC]['desactive'] == 0 ) {
							
							$strDeco = " class='";
							$boldB = $boldE = "";
							if ($AD[$CurT][$CurL][$CurC]['b'] == 1 ) {
								$boldB = "<b>";
								$boldE = "</b>"; 
							}
							if ( isset($AD[$CurT][$CurL][$CurC]['cc']) )	{ $strDeco .= $AD[$CurT][$CurL][$CurC]['cc']; }
// 							if ( isset($AD[$CurT][$CurL][$CurC]['sc']) )	{ $strDeco .= $classTab[$AD[$CurT][$CurL][$CurC]['sc']]." "; }
							if ( isset($AD[$CurT][$CurL][$CurC]['class']) )	{ $strDeco .= $AD[$CurT][$CurL][$CurC]['class']." "; }
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
					if ( $CurL == $ADC['onglet'][$CurT]['theadF'] ) { $Content .= "</thead>\r"; }
					if ( $CurL == $ADC['onglet'][$CurT]['tbodyF'] ) { $Content .= "</tbody>\r"; }
					if ( $CurL == $ADC['onglet'][$CurT]['tfootF'] ) { $Content .= "</tfoot>\r"; }
					$TRidx ^= 1;
				}
				$Content .= "</table>\r";
			}
			$tab_infos['HighLightType'] = $tab_infos['HighLightTypeBackup'];
			if ( $tab_infos['EnableTabs'] != 0 ) { $Content .= "</div>\r"; }
		}
		if ( $tab_infos['EnableTabs'] != 0 ) { $Content .= "</div>\r"; }
		
		unset (
		$CurC,
		$CurL,
		$CurT
		);
		$Content .= "<!-- Render Table End -->\r";
		
		switch ( $tab_infos['RenderMode'] ) {
			case 0:			echo ($Content);	unset ($Content);		break;
			case 1:			return $Content;							break;
		}
		
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"));
		
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
	public function getDefaultDocumentConfig (&$infos, $lines=10, $NbrOfTabs=1, $TabBehavior=1, $HighLightType=1, $TabTxt="tabTxt") {
		$I18nObj = I18n::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$tab = array(	
		"EnableTabs"		=> 1,
		"NbrOfTabs"			=> $NbrOfTabs,
		"TabBehavior"		=> $TabBehavior,
		"RenderMode"		=> 1,
		"HighLightType"		=> $HighLightType,
		"Height"			=> floor( $infos['fontSizeMin'] + ($infos['fontCoef']*3) +10 ) * $lines, //T3 is default; total padding = 10; nbr line +1
		"Width"				=> $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne'),
		"GroupName"			=> "l",
		"CellName"			=> "c",
		"DocumentName"		=> "d",
		);
		for ($i=1; $i<=$NbrOfTabs; $i++ ){
			$tab["tabTxt".$i] = $I18nObj->getI18nEntry($TabTxt.$i);
		}
		
		return $tab;
		
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
				"nbr_ligne"		=>	$lines,	
				"nbr_cellule"	=>	$cells,
				"legende"		=>	$legend,
			)
		);
	}
	
}


