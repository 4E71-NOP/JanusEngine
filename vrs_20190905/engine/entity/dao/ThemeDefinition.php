<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class ThemeDefinition extends Entity{
	private $ThemeDefinition = array ();

	//@formatter:off
	private $columns = array(
			'def_id'		=> 0,
			'fk_theme_id'	=> "",
			'def_type'		=> 1,
			'def_name'		=> "bg",
			'def_number'	=> 0,
			'def_string'	=> "bg.png",
	);
	//@formatter:on
	
	public function __construct($id, $type, $name, $number, $string) {
		$this->ThemeDefinition['fk_theme_id'] .= $id;
		$this->ThemeDefinition['def_type'] .= $type;
		$this->ThemeDefinition['def_name'] .= $name;
		$this->ThemeDefinition['def_number'] = $number;
		$this->ThemeDefinition['def_string'] = $string;
	}

	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$tab = $this->columns;
		$tab['def_type'] .= 0;
		$tab['def_number'] = 0;
		$tab['def_string'] = "N/A";
		return $tab;
	}

	//@formatter:off
	public function getDefType () { return $this->ThemeDefinition['def_type'];}
	public function getDefName () { return $this->ThemeDefinition['def_name'];}
	public function getDefNumber () { return $this->ThemeDefinition['def_number'];}
	public function getDefString () { return $this->ThemeDefinition['def_string'];}
	
	public function getThemeDefinition ($data) { return $this->ThemeDefinition[$data]; }
	public function setThemeDefinition ($entry, $data) { $this->ThemeDefinition[$entry] = $data; }
	//@formatter:on

	public function getValue() {
		switch ($this->ThemeDefinition['def_type']) {
			case 0:
				return $this->ThemeDefinition['def_number'];
				break;
			case 1:
				return $this->ThemeDefinition['def_string'];
				break;
			default:
				return false;
				break;
		}
	}

}