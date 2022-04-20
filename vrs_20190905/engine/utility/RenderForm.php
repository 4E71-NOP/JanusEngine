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
 * The goal of this class is to make the syntax uniform amonst the code.
 * Also it will put the default needed values so the client isn't bothered with it.
 */
class  RenderForm {
	private static $Instance = null;
	
	private function __construct() {
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderForm
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderForm ();
		}
		return self::$Instance;
	}
	
	/**
	 * Returns the form html delcaration
	 * @param string $name
	 * @param string $action
	 * @param string $method
	 * @return string
	 */
	public function renderformHeader( $name, $action="/", $method="post" ){
		if ( strlen($name)>0 && strlen($method)>0) {
			return "<form ACTION='".$action."' method='".$method."' name='".$name."'>\r";
		}
		return false;
	}
	
	/**
	 * Returns the html input type=text.
	 * @param String $name
	 * @param number $size
	 * @param number $maxlength
	 * @param String $value
	 * @return string
	 */
	public function renderInputText( $name , $value, $size=35, $maxlength=255 ){
		if ( strlen($name)>0) {
			return "<input type='text' name='".$name."'	size='".$size."' maxlength='".$maxlength."' value='".$value."'>\r";			
		}
		return false;
	}
	
	/**
	 * Returns the html select menu (standard html - no fast search).  
	 * @param array $arr
	 * @return string
	 */
	public function renderMenuSelect($arr) {
		if (strlen($arr['defaultSelected']) != 0 ) { $arr['options'][$arr['defaultSelected']]['s'] = " selected ";}
		$content = "<select name='".$arr['name']."'>\r";
		foreach ($arr['options'] as $A ) {
			$content .= "<option value='".$A[_MENU_OPTION_DB_]."' ".$A[_MENU_OPTION_SELECTED_].">".$A[_MENU_OPTION_TXT_]."</option>\r";
		}
		$content .= "</select>";
		return $content;
	}
	
	/**
	 * Returns the html radio selector
	 * @param String $id
	 * @param String $name
	 * @param String $text
	 * @return string
	 */
	public function renderRadioSelection($id, $name, $text){
		if ( strlen($id)>0 && strlen($name)>0 && strlen($text)>0 ) {
			return "<input type='radio' id='".$id."' name='".$name."' value='".$id."'> <label for='".$id."'>".$text."</label><br>\r";
		}
		return (false);
	}
	
	/**
	 * Returns the html checkbox 
	 * @param String $idAndName
	 * @param String $value
	 * @param String $text
	 * @param boolean $checked
	 * @param boolean $disabled
	 * @param string $onclik
	 * @return string
	 */
	public function renderCheckbox($idAndName, $value, $text, $checked=false, $disabled=false, $onclik=''){
		$content = false;
		if ( strlen($idAndName)>0 && strlen($value)>0 && strlen($text)>0 ) {
		$content = 
			"<input type='checkbox' id='".$idAndName."' name='".$idAndName."' ".
			(($checked==true)?"checked ":"").
			(($disabled==true)?"disabled='disabled ":"").
			((strlen($onclik)>0)?"onclick='".$onclik."'":"").
			"value='".$value."'
			>\r
			<label for='".$idAndName."'>".$text."</label> <br>\r";
		}
		return $content;
	}
	
	
	/**
	 * Returns the html input hidden
	 * @param String $name
	 * @param String $value
	 * @return string
	 */
	public function renderHiddenInput($name, $value){
		if (strlen($name)>0 && strlen($value)>0) {
			return "<input type='hidden' name='".$name."' value='".$value."'>\r";
		}
		return (false);
	}
	
}