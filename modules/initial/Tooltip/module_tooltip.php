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
//	Module : ModuleDynamicHelp
// --------------------------------------------------------------------------------------------

class ModuleTooltip {
	public function __construct(){}
	
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = "";
		if ( $CurrentSetObj->getInstanceOfUserObj()->hasReadPermission('group_default_read_permission') === true ) {
			$localisation = " / ModuleTooltip";
			$bts->MapperObj->AddAnotherLevel($localisation );
			$bts->LMObj->logCheckpoint("ModuleTooltip");
			$bts->MapperObj->RemoveThisLevel($localisation );
			$bts->MapperObj->setSqlApplicant("ModuleTooltip");
			
			$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
			$cdx = $cdy = 0;
			if ($cdx == 0) { $cdx = 192;}
			if ($cdy == 0) { $cdy = 96;}
	
			$GeneratedJavaScriptObj->insertJavaScript('File', 'modules/initial/Tooltip/lib_Tooltip.js');
			$GeneratedJavaScriptObj->insertJavaScript('Init', 'var t = new ToolTip();');
			$GeneratedJavaScriptObj->insertJavaScript('Init', 'm.mouseFunctionList.ToolTip = { "obj": t, "method":"MouseEvent"};');
			$GeneratedJavaScriptObj->insertJavaScript('OnLoad', "\tt.InitToolTip('".$infos['module']['module_container_name']."' , '".$infos['module']['module_name']."_ex22' , '".$cdx."' , '".$cdy."' );");
			$GeneratedJavaScriptObj->AddObjectEntry ('TooltipConfig', "'default' : { 'State':1, 'X':'".$cdx."', 'Y':'".$cdy."' }");
		}

		// Cleaning up
	
	}
}
?>