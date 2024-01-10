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
class RenderTabs {
	private static $Instance = null;

	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderTabs
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderTabs ();
		}
		return self::$Instance;
	}

	public function render($infos, $T) {
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		
		$tab_infos = &$T['ContentInfos'];
		
		$pv= array();
		$widthA = $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'tab_a_width');
		$widthC = $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'tab_c_width');
		$widthB = floor(($tab_infos['Width']-(($widthA+$widthC)*$tab_infos['NbrOfTabs'])) / $tab_infos['NbrOfTabs']);
		$widthD = $widthA + $widthB + $widthC;
		
		$HeightABCD = $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'tab_height');
		
		$c_id_a = $tab_infos['GroupName']."_".$tab_infos['CellName']."_a"; // decoration
		$c_id_b = $tab_infos['GroupName']."_".$tab_infos['CellName']."_b";
		$c_id_c = $tab_infos['GroupName']."_".$tab_infos['CellName']."_c";
		$c_id_d = $tab_infos['GroupName']."_".$tab_infos['CellName']."_d"; // réactif
		
		$tab = array();
		$tab['1'] = "visible";	$tab['2'] = "hidden";
		$tab['3'] = $tab['4'] = $tab['5'] = $tab['6'] = $tab['7'] = $tab['8'] = $tab['9'] = $tab['10'] = &$tab['2'];
		
		// $class = $ThemeDataObj->getThemeName().$infos['block']."_t2 ";//.theme_princ_B01_t1
		// $Content = "<div id='table_".$tab_infos['GroupName']."' class='".$class."' style='height:".($HeightABCD)."px'>\r";
		$Content = "<div id='table_".$tab_infos['GroupName']."' style='height:".($HeightABCD)."px'>\r";
		
		$TabPosDim = array();
		for ( $i = 1 ; $i <= $tab_infos['NbrOfTabs'] ; $i++ ) {
			$TabPosDim[$i]['pa'] = ($widthD*($i-1));
			$TabPosDim[$i]['pb'] = ($widthA+($widthD*($i-1)));
			$TabPosDim[$i]['pc'] = (($widthA + $widthB)+($widthD*($i-1)));
			$TabPosDim[$i]['da'] = $widthA;
			$TabPosDim[$i]['db'] = $widthB;
			$TabPosDim[$i]['dc'] = $widthC;
			$TabPosDim[$i]['dd'] = $widthD;
			
			if ( $i == $tab_infos['NbrOfTabs'] ) {
				$compensation =  $tab_infos['Width'] - ($widthD * $tab_infos['NbrOfTabs']);
				$TabPosDim[$i]['pc'] += $compensation;
				$TabPosDim[$i]['db'] += $compensation;
				$TabPosDim[$i]['dd'] += $compensation;
			}		//Compensate sub pixel calculations that does NOT end well. Like 2+2 = 3.99999e1 (Thank you Chrome!!! You cunt!!!) 
		}
		
		for ( $i = 1 ; $i <= $tab_infos['NbrOfTabs'] ; $i++ ) {
			if ( $i == 1 ) { $type = "up"; }
			else { $type = "down"; }
			$TabFullName = "TabsData_".$tab_infos['GroupName'].$tab_infos['CellName'].$tab_infos['DocumentName'];
			
			if ( $tab_infos['TabBehavior'] == 1 ) {
				$onMouseOverOut = "
			onmouseover=\"javascript:tm.TabStyleManagement ( 0 , 0 , ".$TabFullName." , '".$tab_infos['GroupName']."' , '".$tab_infos['DocumentName']."', ".$i." );\"
			 onmouseout=\"javascript:tm.TabStyleManagement ( 0 , 1 , ".$TabFullName." , '".$tab_infos['GroupName']."' , '".$tab_infos['DocumentName']."', ".$i." );\"
			";
			}
			
			$Block = $ThemeDataObj->getThemeName().$infos['block'];
			$Content .= "
			<div style='position:relative; display:table-cell'>\r
			<div id='".$c_id_a.$i."' class='".$Block."_tab_".$type."_a' style='position:absolute;	left: ".$TabPosDim[$i]['pa']."px; width: ".$TabPosDim[$i]['da']."px; height: ".$HeightABCD."px;'></div>\r
			<div id='".$c_id_b.$i."' class='".$Block."_tab_".$type."_b' style='position:absolute;	left: ".$TabPosDim[$i]['pb']."px; width: ".$TabPosDim[$i]['db']."px; height: ".$HeightABCD."px;'>
			<span style='text-align: center; line-height: ".$HeightABCD."px;'>".
			$tab_infos["tabTxt".$i] . "</span></div>\r
			<div id='".$c_id_c.$i."' class='".$Block."_tab_".$type."_c' style='position:absolute;	left: ".$TabPosDim[$i]['pc']."px; width: ".$TabPosDim[$i]['dc']."px; height: ".$HeightABCD."px;'></div>\r
					
			<div id='".$c_id_d.$i."' style='position: absolute;	left: ".$TabPosDim[$i]['pa']."px; width: ".$TabPosDim[$i]['dd']."px; height: ".$HeightABCD."px;'
			onClick=\"javascript:tm.TabStyleManagement ( 1 , 0 , ".$TabFullName.", '".$tab_infos['GroupName']."','".$tab_infos['DocumentName']."', ".$i." );\"
			".$onMouseOverOut."
			></div>\r
			</div>\r
			";
		}
		
		$Content .= "
	</div>\r
	";
		
		$JavaScriptTable = "\rvar TabsData_".$tab_infos['GroupName'].$tab_infos['CellName'].$tab_infos['DocumentName']." = {\r
		'hostDiv' : 'table_".$tab_infos['GroupName']."',
		'tabsNbr' :'".$tab_infos['NbrOfTabs']."',
		'size' : { 'a':'".$TabPosDim['1']['da']."', c:'".$TabPosDim['1']['dc']."',},\r
		'styles' : {\r
			'up':	{	'Styla':'".$Block."_tab_up_a',		'Stylb':'".$Block."_tab_up_b',		'Stylc':'".$Block."_tab_up_c',	},\r
			'down':	{	'Styla':'".$Block."_tab_down_a',	'Stylb':'".$Block."_tab_down_b',	'Stylc':'".$Block."_tab_down_c',},\r
			'hover':{	'Styla':'".$Block."_tab_hover_a',	'Stylb':'".$Block."_tab_hover_b',	'Stylc':'".$Block."_tab_hover_c',},\r
		},\r
		'elements': {\r";
		
		for ( $i = 1 ; $i <= $tab_infos['NbrOfTabs'] ; $i++ ) {
			if ( $i == 1 ) { $selection = 1; }
			else { $selection = 0; }
			$JavaScriptTable .= "\"".$tab_infos['GroupName']."_".$tab_infos['CellName'].$i."\": {
			'cibleDoc':'".$tab_infos['GroupName']."_".$tab_infos['DocumentName'].$i."',
			'isSelected':'".$selection."',
			'HoverState':'0',
			'up': {		'ida':'".$c_id_a.$i."',	'idb':'".$c_id_b.$i."',	'idc':'".$c_id_c.$i."', },\r
			'down': {	'ida':'".$c_id_a.$i."',	'idb':'".$c_id_b.$i."',	'idc':'".$c_id_c.$i."', },\r
			'hover': {	'ida':'".$c_id_a.$i."',	'idb':'".$c_id_b.$i."',	'idc':'".$c_id_c.$i."', },\r
			'sup': {	'idd':'".$c_id_d.$i."', },\r
		},\r
		";
		}
		$JavaScriptTable .= "	\r},\r}\r";

		$JavaScriptTableLength = strlen($JavaScriptTable) - 2;
		$JavaScriptTable = substr( $JavaScriptTable, 0 , $JavaScriptTableLength) . "\r};\r";
		
		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
		$GeneratedScriptObj->insertString('JavaScript-Init', "var tm = new TabsManagement();");
		$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\ttm.InitTabs (TabsData_".$tab_infos['GroupName'].$tab_infos['CellName'].$tab_infos['DocumentName'].");");
		$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\ttm.TabsResize (TabsData_".$tab_infos['GroupName'].$tab_infos['CellName'].$tab_infos['DocumentName'].");");
		$GeneratedScriptObj->insertString('JavaScript-OnResize', "\ttm.TabsResize (TabsData_".$tab_infos['GroupName'].$tab_infos['CellName'].$tab_infos['DocumentName'].");");
		$GeneratedScriptObj->insertString('JavaScript-Data', $JavaScriptTable);

		switch ( $tab_infos['RenderMode'] ) {
			case 0:
				echo $Content;
				unset ($Content);
				break;
			case 1:
				return $Content;
				break;
		}
	}
}
?>