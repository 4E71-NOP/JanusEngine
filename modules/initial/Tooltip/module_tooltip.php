<?php
 // // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


//	Module : ModuleDynamicHelp
// --------------------------------------------------------------------------------------------

class ModuleTooltip {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = "";
		if ( $CurrentSetObj->UserObj->hasPermission('group_default_read_permission') === true ) {
			$bts->mapSegmentLocation(__METHOD__, "ModuleTooltip");
			
			$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;
			$cdx = $cdy = 0;
			if ($cdx == 0) { $cdx = 192;}
			if ($cdy == 0) { $cdy = 96;}
	
			$GeneratedScriptObj->insertString('JavaScript-File', $infos['module']['module_directory'].'javascript/lib_Tooltip.js');
			$GeneratedScriptObj->insertString('JavaScript-Init', 'var t = new ToolTip();');
			$GeneratedScriptObj->insertString('JavaScript-Init', 'm.mouseFunctionList.ToolTip = { "obj": t, "method":"MouseEvent"};');
			$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tt.InitToolTip('".$infos['module']['module_container_name']."' , '".$infos['module']['module_name']."_ex22' , '".$cdx."' , '".$cdy."' );");
			$GeneratedScriptObj->AddObjectEntry ('TooltipConfig', "'default' : { 'State':1, 'X':'".$cdx."', 'Y':'".$cdy."' }");

			$bts->segmentEnding(__METHOD__);
			}

		// Cleaning up
	
	}
}
?>