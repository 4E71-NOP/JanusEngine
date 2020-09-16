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
class FormToCommandLine {
	private static $Instance = null;
	private $CommandLineScript = array();
	private $CommandLineNbr = 0;

	public function __construct() {}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new FormToCommandLine ();
		}
		return self::$Instance;
	}
	
	
	public function analysis () {
// 		$CMObj = ConfigurationManagement::getInstance();
		$RequestDataObj = RequestData::getInstance();
		$LMObj = LogManagement::getInstance();
		
		$logTarget = $LMObj->getInternalLogTarget();
		$LMObj->setInternalLogTarget("none");
		$LMObj->InternalLog("FormToCommandLine/analysis(): Analysis started");

		$CurrentSetObj = CurrentSet::getInstance();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		
		$scr = &$this->CommandLineScript;
		$cln = &$this->CommandLineNbr;
		$cln = 0;
		
		switch ($RequestDataObj->getRequestDataSubEntry('formGenericData','origin')) {
			// Analyse the origin of the form
			case "ModuleQuickSkin":
				$LMObj->InternalLog("ModuleQuickSkin submitted a form.");
// 				$a = $RequestDataObj->getRequestDataEntry('user');
				$scr[$cln] = "update user name ".$UserObj->getUserEntry('user_login'). " pref_theme '".$RequestDataObj->getRequestDataSubEntry('userForm','user_pref_theme')."';";
				$cln++;
				break;
				
			// All AdminDashboard will provide the necessary elements to build a set of command line.
			case "AdminDashboard":
				$LMObj->InternalLog("AdminDashboard submitted a form.");
				$n = 1;
				while ( $n != 0 ) {
					if ( strlen($RequestDataObj->getRequestDataEntry('formCommand'.$n)) > 0 ) {
						$LMObj->InternalLog("Processing formCommand".$n);
						
						$formCommand	= $RequestDataObj->getRequestDataEntry('formCommand'.$n);
						$formEntity		= $RequestDataObj->getRequestDataEntry('formEntity'.$n);
						$formTarget		= $RequestDataObj->getRequestDataEntry('formTarget'.$n);
						$formParams		= $RequestDataObj->getRequestDataEntry('formParams'.$n);
						switch ($formCommand.$formEntity) {
							case "assignlanguage":
								// This one is an additive from website manipulation
								$scr[$cln] = "reset languages on_website ".$RequestDataObj->getRequestDataSubEntry('site_context','site_nom').";";
								$cln++;
								$n++;
								foreach ($formTarget as $k => $v ) {
									$str = "assign language ".$k." to_website ".$RequestDataObj->getRequestDataSubEntry('site_context','site_nom').";";
									$LMObj->InternalLog("(assignlanguage) Processed =".$str);
									$scr[$cln] = $str;
									$cln++;
									$n++;
								}
								break;
							default :
								$str = $formCommand." ".$formEntity." ";
								foreach ($formTarget as $k => $v) { $str .= $k." '".$v."' ";}
								foreach ($formParams as $k => $v) { $str .= $k." '".$v."' ";}
								$str .= ";";
								$LMObj->InternalLog("Processed =".$str);
								$scr[$cln] = $str;
								$cln++;
								$n++;
								
								break;
						}
						
					}
					else { $n = 0; } // Exit
				}
				break;
		}
		
		$LMObj->setInternalLogTarget($logTarget);
	}
	
	//@formatter:off
	public function getCommandLineScript() { return $this->CommandLineScript; }
	public function getCommandLineNbr() { return $this->CommandLineNbr; }

	public function setCommandLineScript($CommandLineScript) { $this->CommandLineScript = $CommandLineScript; }
	public function setCommandLineNbr($CommandLineNbr) { $this->CommandLineNbr = $CommandLineNbr; }
	//@formatter:on
	
	
	
	
	
	
	
}