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
//	Module : ModuleDynamicHelp
// --------------------------------------------------------------------------------------------

class ModuleTooltip {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = "";
		if ( $CurrentSetObj->getInstanceOfUserObj()->hasPermission('group_default_read_permission') === true ) {
			$localisation = " / ModuleTooltip";
			$bts->MapperObj->AddAnotherLevel($localisation );
			$bts->LMObj->logCheckpoint("ModuleTooltip");
			$bts->MapperObj->RemoveThisLevel($localisation );
			$bts->MapperObj->setSqlApplicant("ModuleTooltip");
			
			$GeneratedScriptObj = $CurrentSetObj->getInstanceOfGeneratedScriptObj();
			$cdx = $cdy = 0;
			if ($cdx == 0) { $cdx = 192;}
			if ($cdy == 0) { $cdy = 96;}
	
			$GeneratedScriptObj->insertString('JavaScript-File', $infos['module']['module_directory'].'lib_Tooltip.js');
			$GeneratedScriptObj->insertString('JavaScript-Init', 'var t = new ToolTip();');
			$GeneratedScriptObj->insertString('JavaScript-Init', 'm.mouseFunctionList.ToolTip = { "obj": t, "method":"MouseEvent"};');
			$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tt.InitToolTip('".$infos['module']['module_container_name']."' , '".$infos['module']['module_name']."_ex22' , '".$cdx."' , '".$cdy."' );");
			$GeneratedScriptObj->AddObjectEntry ('TooltipConfig', "'default' : { 'State':1, 'X':'".$cdx."', 'Y':'".$cdy."' }");
		}

		// Cleaning up
	
	}
}
?>