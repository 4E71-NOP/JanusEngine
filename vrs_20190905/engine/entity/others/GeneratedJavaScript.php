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

	public function renderJavaScriptDecoratedMode ( $section, $left, $right ) {
		$Content = "";
		if ( isset($this->GeneratedJavaScript[$section])) {
			reset ($this->GeneratedJavaScript[$section]);
			$tab = &$this->GeneratedJavaScript[$section];
			foreach ($tab as $A ) { $Content .= $left . $A . $right; }
		}
		return  $Content."\r";
	}
	
	public function renderJavaScriptCrudeMode ( $section ) {
		$Content = "";
		if ( isset($this->GeneratedJavaScript[$section])) {
			reset ($this->GeneratedJavaScript[$section]);
			$tab = &$this->GeneratedJavaScript[$section];
			foreach ($tab as $A ) { $Content .= $A . "\r"; }
		}
		return  $Content."\r";
	}
}

?>
