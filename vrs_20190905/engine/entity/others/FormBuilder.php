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

class FormBuilder {
	private static $Instance = null;
	private $formElements = array();

	/**
	 * 
	 */
	private function __construct(){}
	
	/**
	 * 
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new FormBuilder();
		}
		return self::$Instance;
	}

	/**
	 * Build the table based upon the '$data' content
	 * 
	 */
	public function buildFormElements ( $data ) {
		$bts = BaseToolSet::getInstance();

		foreach ( $data as $A ) {
			$ptr = &$this->formElements[$A['name']];
			switch ( $A['type']) {
				case 'text':
					$ptr .= $bts->RenderFormObj->renderInputText($A['name'], $A['value'], $A['placeholder'], $A['size'], $A['maxlength'] );
					break;
				case 'radio':
					$ptr .= $bts->RenderFormObj->renderRadioSelection($A['name'], $A['value'], $A['text']);
					break;
				case 'checkbox':
					$ptr .= $bts->RenderFormObj->renderCheckbox($A['idAndName'], $A['value'], $A['text'], $A['checked'], $A['disabled'], $A['onclik']);
					break;
				case 'menuSelect':
					$ptr .= $bts->RenderFormObj->renderMenuSelect($A['data']);
					break;
			}
		}
	}

	//@formatter:off
	public function getFormElements () { return $this->formElements; }
	public function getFormElementsEntry ($data) { return $this->formElements[$data]; }
	//@formatter:on


}
