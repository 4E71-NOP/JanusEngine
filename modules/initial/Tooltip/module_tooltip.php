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
		$cs = CommonSystem::getInstance();
		$CurrentSet = CurrentSet::getInstance();
		
		$localisation = " / ModuleTooltip";
		$cs->MapperObj->AddAnotherLevel($localisation );
		$cs->LMObj->logCheckpoint("ModuleTooltip");
		$cs->MapperObj->RemoveThisLevel($localisation );
		$cs->MapperObj->setSqlApplicant("ModuleTooltip");
		
		$GeneratedJavaScriptObj = $CurrentSet->getInstanceOfGeneratedJavaScriptObj();
		$RenderLayoutObj = RenderLayout::getInstance();
		
		$cdx = $RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_name'], 'cdx'); 
		$cdy = $RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_name'], 'cdy');
		if ($cdx == 0) { $cdx = 256;}
		if ($cdy == 0) { $cdy = 256;}

		$GeneratedJavaScriptObj->insertJavaScript('File', '../modules/initial/Tooltip/lib_tooltip.js');
		$GeneratedJavaScriptObj->insertJavaScript('File', 'engine/javascript/lib_DecorationManagement.js');
		$GeneratedJavaScriptObj->insertJavaScript('Init', 'var t = new ToolTip();');
		$GeneratedJavaScriptObj->insertJavaScript('Init', 'var dm = new DecorationManagement();');
		$GeneratedJavaScriptObj->insertJavaScript('Init', 'm.mouseFunctionList.ToolTip = { "obj": t, "method":"MouseEvent"};');
		$GeneratedJavaScriptObj->insertJavaScript('Onload', "\tt.InitToolTip('".$infos['module']['module_container_name']."' , '".$infos['module']['module_name']."_ex22' , '".$cdx."' , '".$cdy."' );");
		
		// Cleaning up
	
	}
}
?>