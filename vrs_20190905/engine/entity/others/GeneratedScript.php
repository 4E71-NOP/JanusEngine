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
 * This class is responssible for the script/css code rendered at the end of the HTML script. 
 *  
 */
class GeneratedScript {
	private $GeneratedScript = array();
	private $Object = array();
	private $ObjectList = array();

	public function __construct() {}
	
	/**
	 * Insert data into the desired $section
	 * Sections are "JavaScript-Command", "JavaScript-Data", "JavaScript-Onload", "JavaScript-File" 
	 * @param String $section
	 * @param String $content
	 * @return string
	 */
	public function insertString ( $section , $content) {
		$this->GeneratedScript[$section][] = $content;
	}
	
	public function getGeneratedScript () { return $this->GeneratedScript; }
	public function getGeneratedScriptEntry ($data) { return $this->GeneratedScript[$data]; }

	/**
	 * Render a JavaScript to get a local website ressource (ie Hydr scripts)
	 * @param String $section
	 * @param String $left
	 * @param String $right
	 * @return string
	 */
	public function renderScriptFileWithBaseURL ( $section, $left, $right ) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = "";
		if ( isset($this->GeneratedScript[$section])) {
			reset ($this->GeneratedScript[$section]);
			$tab = &$this->GeneratedScript[$section];
			$baseUrl  = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url');
			foreach ($tab as $A ) { 
				$Content .= $left .$baseUrl.$A . $right;
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Adding `".$left.$baseUrl.$A . $right."`. and ".$_SERVER['HTTP_HOST']));
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
	public function renderExternalRessourceScript ( $section, $left, $right ) {
// 		$bts = BaseToolSet::getInstance();
		$Content = "";
		if ( isset($this->GeneratedScript[$section])) {
			reset ($this->GeneratedScript[$section]);
			$tab = &$this->GeneratedScript[$section];
			foreach ($tab as $A ) { 
				$Content .= $left .$A . $right;
// 				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Adding `".$left . $A . $right."`"));
				
			}
		}
		return  $Content."\r";
	}
	
	
	/**
	 * Renders the JavaScript with no modifications.
	 * @param String $section
	 * @return string
	 */
	public function renderScriptCrudeMode ( $section ) {
// 		$bts = BaseToolSet::getInstance();
		$Content = "";
		if ( isset($this->GeneratedScript[$section])) {
			reset ($this->GeneratedScript[$section]);
			$tab = &$this->GeneratedScript[$section];
			foreach ($tab as $A ) { 
				$Content .= $A . "\r"; 
// 				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Adding `".$A ."`"));
			}
		}
		return  $Content."\r";
	}


	/**
	 * Adds an entry into the $this->Object[$section]
	 * 
	 * @param string	$section
	 * @param string	$content
	 *
	 * */
	public function AddObjectEntry ($section, $content ) {
		$this->Object[$section][] = $content;
		$this->ObjectList[$section] = 1;
	}

	/**
	 * Adds an entry into the $this->Object[$section]
	 * 
	 * @param string	$section
	 * @param string	$content
	 * 
	 * @return string
	 *
	 * */
	public function renderJavaScriptObjects () {
		$Content = "";
		foreach ( $this->ObjectList as $k => $v ) {
			$Content .= $this->renderJavaScriptObject($k);
		}
		return $Content;
	}

	/**
	 * Renders the JavaScript with no modifications.
	 * @param String $section
	 * @return string
	 */
	public function renderJavaScriptObject ( $section ) {
		$Content = "";
		if ( isset($this->Object[$section])) {
			$Content = "var ". $section ." = {\r";
			reset ($this->Object[$section]);
			$tab = &$this->Object[$section];
			foreach ($tab as $A ) { 
				$Content .= $A . ",\r"; 
			}
			$Content = substr($Content, 0 , -2 )."\r};\r";
		}
		return  $Content."\r";
	}
}

?>
