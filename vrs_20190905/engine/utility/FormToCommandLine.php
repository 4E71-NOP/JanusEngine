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
	
	/**
	 * Analyze a form to create a commande line.
	 */
	public function analysis () {
		$cs = CommonSystem::getInstance();
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "FormToCommandLine/analysis(): Analysis started"));

		$CurrentSetObj = CurrentSet::getInstance();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		
		$scr = &$this->CommandLineScript;
		$cln = &$this->CommandLineNbr;
		$cln = 0;
		
		switch ($cs->RequestDataObj->getRequestDataSubEntry('formGenericData','origin')) {
			// Analyze the origin of the form
			case "ModuleQuickSkin":
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "ModuleQuickSkin submitted a form."));
				$scr[$cln] = "update user name ".$UserObj->getUserEntry('user_login'). " pref_theme '".$cs->RequestDataObj->getRequestDataSubEntry('userForm','user_pref_theme')."';";
				$cln++;
				break;
				
			// All AdminDashboard will provide the necessary elements to build a set of command line.
			case "AdminDashboard":
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "AdminDashboard submitted a form."));
				$n = 1;
				while ( $n != 0 ) {
					if ( strlen($cs->RequestDataObj->getRequestDataEntry('formCommand'.$n)) > 0 ) {
						$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Processing formCommand".$n));
						
						$formCommand	= $cs->RequestDataObj->getRequestDataEntry('formCommand'.$n);
						$formEntity		= $cs->RequestDataObj->getRequestDataEntry('formEntity'.$n);
						$formTarget		= $cs->RequestDataObj->getRequestDataEntry('formTarget'.$n);
						$formParams		= $cs->RequestDataObj->getRequestDataEntry('formParams'.$n);
						switch ($formCommand.$formEntity) {
							case "assignlanguage":
								// This one is an additive from website manipulation
								$scr[$cln] = "reset languages on_website ".$cs->RequestDataObj->getRequestDataSubEntry('site_context','site_nom').";";
								$cln++;
								$n++;
								foreach ($formTarget as $k => $v ) {
									$str = "assign language ".$k." to_website ".$cs->RequestDataObj->getRequestDataSubEntry('site_context','site_nom').";";
									$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "(assignlanguage) Processed =".$str));
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
								$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Processed =".$str));
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
		
	}
	
	//@formatter:off
	public function getCommandLineScript() { return $this->CommandLineScript; }
	public function getCommandLineNbr() { return $this->CommandLineNbr; }

	public function setCommandLineScript($CommandLineScript) { $this->CommandLineScript = $CommandLineScript; }
	public function setCommandLineNbr($CommandLineNbr) { $this->CommandLineNbr = $CommandLineNbr; }
	//@formatter:on
	
	
	
	
	
	
	
}