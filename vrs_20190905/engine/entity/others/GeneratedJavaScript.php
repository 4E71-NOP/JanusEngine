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


/**
 * @author faust
 * This class is responssible for the Javascript code rendered at the end of the HTML script. 
 *  
 */
class GeneratedJavaScript {
	private $GeneratedJavaScript = array();

	public function __construct() {}

// 	Sections are "Command", "Data", "Onload", "Fichier" 
	public function insertJavaScript ( $section , $content) {
		$this->GeneratedJavaScript[$section][] = $content;
	}
	
	public function getGeneratedJavaScript () { return $this->GeneratedJavaScript; }
	public function getGeneratedJavaScriptEntry ($data) { return $this->GeneratedJavaScript[$data]; }

	/**
	 * Render a JavaScript to get a local website ressource (ie Hydr scripts)
	 * @param String $section
	 * @param String $left
	 * @param String $right
	 * @return string
	 */
	public function renderJavaScriptFile ( $section, $left, $right ) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = "";
		if ( isset($this->GeneratedJavaScript[$section])) {
			reset ($this->GeneratedJavaScript[$section]);
			$tab = &$this->GeneratedJavaScript[$section];
			$baseUrl  = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url');
			foreach ($tab as $A ) { 
				$Content .= $left .$baseUrl.$A . $right;
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Adding `".$left.$baseUrl.$A . $right."`. and ".$_SERVER['HTTP_HOST']));
			}
		}
		return  $Content."\r";
	}
	
	/**
	 * Renders a JavaScript to get an external ressource (third party script)
	 * @param String $section
	 * @param String $left
	 * @param String $right
	 * @return string
	 */
	public function renderJavaScriptExternalRessource ( $section, $left, $right ) {
// 		$bts = BaseToolSet::getInstance();
		$Content = "";
		if ( isset($this->GeneratedJavaScript[$section])) {
			reset ($this->GeneratedJavaScript[$section]);
			$tab = &$this->GeneratedJavaScript[$section];
			foreach ($tab as $A ) { 
				$Content .= $left .$A . $right;
// 				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Adding `".$left . $A . $right."`"));
				
			}
		}
		return  $Content."\r";
	}
	
	
	/**
	 * Renders the JavaScript with no modifications.
	 * @param String $section
	 * @return string
	 */
	public function renderJavaScriptCrudeMode ( $section ) {
// 		$bts = BaseToolSet::getInstance();
		$Content = "";
		if ( isset($this->GeneratedJavaScript[$section])) {
			reset ($this->GeneratedJavaScript[$section]);
			$tab = &$this->GeneratedJavaScript[$section];
			foreach ($tab as $A ) { 
				$Content .= $A . "\r"; 
// 				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Adding `".$A ."`"));
			}
		}
		return  $Content."\r";
	}
}

?>
