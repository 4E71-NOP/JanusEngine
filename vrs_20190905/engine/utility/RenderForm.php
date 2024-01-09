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

/**
 * The goal of this class is to make the syntax uniform amonst the code.
 * Also it will put the default needed values so the client isn't bothered with it.
 */
class  RenderForm
{
	private static $Instance = null;

	private function __construct()
	{
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderForm
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new RenderForm();
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
	public function renderformHeader($name, $action = "/", $method = "post")
	{
		if (strlen($name) > 0 && strlen($method) > 0) {
			return "<form ACTION='" . $action . "' method='" . $method . "' name='" . $name . "' id='" . $name . "'>\r";
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
	public function renderInputText($name, $value = "", $placeholder = "", $size = 35, $maxlength = 255)
	{
		if (strlen($name) > 0) {
			$builder = "";
			$spacer = "";
			if (strlen($value) > 0) { $builder .= $spacer . "value='" . $value . "'"; $spacer = " "; }
			if (strlen($placeholder) > 0) { $builder .= $spacer . "placeholder='" . $placeholder . "'"; $spacer = " "; }
			if ($size > 0) { $builder .= $spacer . "size='" . $size . "'"; $spacer = " "; }
			if ($maxlength > 0) { $builder .= $spacer . "maxlength='" . $maxlength . "'"; $spacer = " "; }

			return "<input type='text' name='" . $name . "' id='".$name."' " . $builder . ">\r";
		}
		return false;
	}

	/**
	 * Returns the html input type=text.
	 * @param Array $arr
	 * @return string
	 */
	public function renderInputTextEnhanced($arr)
	{
		if (strlen($arr['name'] ?? '') > 0) {
			$builder = "";
			$spacer = "";
			if (strlen($arr['id'] ?? '') > 0) { $builder .= $spacer . "id='" . $arr['id'] . "'"; $spacer = " "; }
			if (strlen($arr['name'] ?? '') > 0) { $builder .= $spacer . "name='" . $arr['name'] . "'"; $spacer = " "; }
			if (strlen($arr['value'] ?? '') > 0) { $builder .= $spacer . "value='" . $arr['value'] . "'"; $spacer = " "; }
			if (strlen($arr['size'] ?? '') > 0) { $builder .= $spacer . "size='" . $arr['size'] . "'"; $spacer = " "; }
			if (strlen($arr['maxlength'] ?? '') > 0) { $builder .= $spacer . "maxlength='" . $arr['maxlength'] . "'"; $spacer = " "; }
			if (strlen($arr['placeholder'] ?? '') > 0) { $builder .= $spacer . "placeholder='" . $arr['placeholder'] . "'"; $spacer = " "; }
			if ($arr['readonly'] == true) { $builder .= $spacer . "readonly"; $spacer = " "; }
			if ($arr['disable'] == true) { $builder .= $spacer . "disable"; $spacer = " "; }
			if (strlen($arr['oninput'] ?? '') > 0) { $builder .= $spacer . "onInput=\"" . $arr['oninput'] . "\""; $spacer = " "; }
			if (strlen($arr['onkeyup'] ?? '') > 0) { $builder .= $spacer . "onKeyUp=\"" . $arr['onkeyup'] . "\""; $spacer = " "; }
			if (strlen($arr['javascript'] ?? '') > 0) { $builder .= $spacer . "javascript=\"" . $arr['javascript'] . "\""; $spacer = " "; }
			if (strlen($arr['special'] ?? '') > 0) { $builder .= $spacer . "special='" . $arr['special'] . "'"; $spacer = " "; }

			return "<input type='text' " . $builder . ">\r";
		}

		return false;
	}

	/**
	 * Returns the html input type=password.
	 * @param String $name
	 * @param number $size
	 * @param number $maxlength
	 * @param String $value
	 * @return string
	 */
	public function renderInputPassword($name, $value, $placeholder = "", $size = 35, $maxlength = 255)
	{
		if (strlen($name) > 0) {
			$builder = "";
			$spacer = "";
			if (strlen($value) > 0) { $builder .= $spacer . "value='" . $value . "'"; $spacer = " "; }
			if (strlen($placeholder) > 0) { $builder .= $spacer . "placeholder='" . $placeholder . "'"; $spacer = " "; }
			if ($size > 0) { $builder .= $spacer . "size='" . $size . "'"; $spacer = " "; }
			if ($maxlength > 0) { $builder .= $spacer . "maxlength='" . $maxlength . "'"; $spacer = " "; }

			return "<input type='password' name='" . $name . "' id='".$name."' " . $builder . ">\r";

			// return "<input type='password' name='" . $name . "'	size='" . $size . "' maxlength='" . $maxlength . "' value='" . $value . "' placeholder='" . $placeholder . "'>\r";
		}
		return false;
	}

	/**
	 * Returns the html select menu (standard html - no fast search).<br>
	 * $arr is composed like the following:<br>
	 * 			name = stringname,<br>
	 * 			options = array(db:<value in db>, s:<selected or not>, t:<string in menu>)<br>
	 * @param array $arr
	 * @return string
	 */
	public function renderMenuSelect($arr)
	{
		if (strlen($arr['defaultSelected']) != 0) {
			$arr['options'][$arr['defaultSelected']]['s'] = " selected ";
		}
		$content = "<select name='" . $arr['name'] . "'>\r";
		foreach ($arr['options'] as $A) {
			$content .= "<option value='" . $A[_MENU_OPTION_DB_] . "' " . $A[_MENU_OPTION_SELECTED_] . ">" . $A[_MENU_OPTION_TXT_] . "</option>\r";
		}
		$content .= "</select>\r";
		return $content;
	}

	/**
	 * Returns the html radio selector
	 * @param String $id
	 * @param String $name
	 * @param String $text
	 * @return string
	 */
	public function renderRadioSelection($name, $value, $text, $selected = false)
	{
		if (strlen($name) > 0 && strlen($text) > 0) {
			$selectText = ($selected == true) ? " checked" : "";
			return "<input type='radio' id='" . $name . "' name='" . $name . "' value='" . $value . "'" . $selectText . "> <label for='" . $name . "'>" . $text . "</label><br>\r";
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
	public function renderCheckbox($idAndName, $value, $text, $checked = false, $disabled = false, $onclik = '')
	{
		$content = false;
		if (strlen($idAndName) > 0 && strlen($value) > 0 && strlen($text) > 0) {
			$content =
				"<input type='checkbox' id='" . $idAndName . "' name='" . $idAndName . "' " .
				(($checked == true) ? "checked " : "") .
				(($disabled == true) ? "disabled='disabled " : "") .
				((strlen($onclik) > 0) ? "onclick='" . $onclik . "'" : "") .
				"value='" . $value . "'
			>\r
			<label for='" . $idAndName . "'>" . $text . "</label> <br>\r";
		}
		return $content;
	}


	/**
	 * Returns the html input hidden
	 * @param String $name
	 * @param String $value
	 * @return string
	 */
	public function renderHiddenInput($name, $value)
	{
		if (strlen($name) > 0 && strlen($value) > 0) {
			return "<input type='hidden' name='" . $name . "' value='" . $value . "'>\r";
		}
		return (false);
	}
}
