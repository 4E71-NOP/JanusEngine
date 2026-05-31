<?php
// @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see      : https://github.com/4E71-NOP/JanusEngine
//
// @license  : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author   : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note     : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//             without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


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
					$ptr .= $bts->RenderFormObj->renderCheckbox($A['idAndName'], $A['text'], $A['value'], $A['checked'], $A['disabled'], $A['onclik']);
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
